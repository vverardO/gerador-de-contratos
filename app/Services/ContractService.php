<?php

namespace App\Services;

use App\Enums\ContractStatus;
use App\Enums\ContractType;
use App\Models\Contract;
use Barryvdh\DomPDF\Facade\Pdf;
use DOMDocument;
use DOMXPath;
use Exception;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ContractService
{
    public function getContractHtml(Contract $contract): string
    {
        $templateData = [
            'motorista_nome' => $contract->driver_name,
            'motorista_documento' => $contract->driver_document,
            'motorista_rua' => $contract->driver_street,
            'motorista_numero' => $contract->driver_number,
            'motorista_bairro' => $contract->driver_neighborhood,
            'motorista_cep' => $contract->driver_zip_code,
            'veiculo' => $contract->vehicle,
            'fabricacao_modelo' => $contract->manufacturing_model,
            'placa' => $contract->license_plate,
            'chassi' => $contract->chassis,
            'renavam' => $contract->renavam,
            'proprietario_nome' => $contract->owner_name,
            'proprietario_documento' => $contract->owner_document,
            'valor' => $contract->value,
            'valor_extenso' => $contract->value_in_words,
            'data_hoje' => $contract->today_date,
        ];

        $templateName = match ($contract->type) {
            ContractType::APP_RENTAL => 'app-rental',
            ContractType::OCCASIONAL_RENTAL => 'occasional-rental',
        };

        $templateContent = view('components.templates.'.$templateName, $templateData)->render();

        $dom = new DOMDocument;
        @$dom->loadHTML('<?xml encoding="UTF-8">'.$templateContent, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new DOMXPath($dom);

        $head = $xpath->query('//head')->item(0);
        $body = $xpath->query('//body')->item(0);

        $styles = '';
        if ($head) {
            $styleTags = $xpath->query('//style', $head);
            foreach ($styleTags as $style) {
                $styles .= $dom->saveHTML($style);
            }
        }

        $bodyContent = '';
        if ($body) {
            foreach ($body->childNodes as $child) {
                $bodyContent .= $dom->saveHTML($child);
            }
        } else {
            $bodyContent = $templateContent;
        }

        if ($styles) {
            $styles = str_replace('padding: 40px 60px;', 'padding: 1in;', $styles);
            $styles = str_replace('background: #fff;', '', $styles);
        }

        return '<!DOCTYPE html><html><head><meta charset="UTF-8">'.$styles.'</head><body>'.$bodyContent.'</body></html>';
    }

    public function generatePdfAndSendToZapSign(Contract $contract): void
    {
        try {
            $html = $this->getContractHtml($contract);

            if (class_exists(Pdf::class)) {
                $pdf = Pdf::loadHTML($html);
                $pdfContent = $pdf->output();
            } else {
                throw new \Exception('PDF library not installed. Please install barryvdh/laravel-dompdf package.');
            }

            $response = Http::attach(
                'file',
                $pdfContent,
                'contract-'.$contract->id.'.pdf'
            )->post('https://contratos-teste.free.beeceptor.com');

            if ($response->successful()) {
                $contract->status = ContractStatus::SENT;
                $contract->save();
            } else {
                Log::error('Failed to send PDF', [
                    'contract_id' => $contract->id,
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);

                throw new Exception('Erro ao enviar PDF. Tente novamente.');
            }
        } catch (RequestException $e) {
            Log::error('Exception while sending PDF', [
                'contract_id' => $contract->id,
                'message' => $e->getMessage(),
            ]);

            throw new Exception('Erro ao enviar PDF: '.$e->getMessage());
        } catch (Exception $e) {
            Log::error('Exception while generating PDF', [
                'contract_id' => $contract->id,
                'message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
