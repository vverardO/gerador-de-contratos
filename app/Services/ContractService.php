<?php

namespace App\Services;

use App\Enums\ContractStatus;
use App\Enums\ContractType;
use App\Models\Contract;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
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
            'contract_id' => $contract->id,
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
            'valor' => $contract->value_formatted,
            'valor_extenso' => $contract->value_in_words,
            'data_hoje' => $contract->today_date ? Carbon::parse($contract->today_date)->format('d/m/Y') : Carbon::now()->format('d/m/Y'),
        ];

        Carbon::setLocale('pt_BR');

        $carbonStartDate = Carbon::parse($contract->start_date);
        $carbonEndDate = Carbon::parse($contract->end_date);
        $carbonTodayDate = Carbon::now();

        if ($contract->today_date) {
            $carbonTodayDate = Carbon::parse($contract->today_date);
        }

        $startDateString = $carbonStartDate->translatedFormat('d').' de '.$carbonStartDate->translatedFormat('F').' de '.$carbonStartDate->translatedFormat('Y');
        $endDateString = $carbonEndDate->translatedFormat('d').' de '.$carbonEndDate->translatedFormat('F').' de '.$carbonEndDate->translatedFormat('Y');
        $todayDateString = $carbonTodayDate->translatedFormat('d').' de '.$carbonTodayDate->translatedFormat('F').' de '.$carbonTodayDate->translatedFormat('Y');

        if ($contract->type === ContractType::OCCASIONAL_RENTAL) {
            $templateData['valor_total'] = $contract->value_formatted;
            $templateData['valor_total_extenso'] = $contract->value_in_words;
            $templateData['quantidade_dias'] = $contract->quantity_days ?? 30;
            $templateData['data_inicio'] = $startDateString ?? $todayDateString;
            $templateData['data_fim'] = $endDateString ?? $todayDateString;
        }

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
}
