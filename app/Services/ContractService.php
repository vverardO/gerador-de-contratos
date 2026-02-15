<?php

namespace App\Services;

use App\Enums\ContractType;
use App\Models\Contract;
use Carbon\Carbon;
use DOMDocument;
use DOMXPath;

class ContractService
{
    public function getContractHtml(Contract $contract): string
    {
        Carbon::setLocale('pt_BR');

        if ($contract->type === ContractType::PERSONALIZADO && $contract->contract_template_id) {
            return $this->getCustomTemplateHtml($contract);
        }

        $templateData = $this->buildTemplateData($contract);
        $templateName = match ($contract->type) {
            ContractType::APP_RENTAL => 'app-rental',
            ContractType::OCCASIONAL_RENTAL => 'occasional-rental',
            ContractType::PERSONALIZADO => 'app-rental',
        };

        $templateContent = view('components.templates.'.$templateName, $templateData)->render();

        return $this->wrapHtmlWithStructure($templateContent);
    }

    private function getCustomTemplateHtml(Contract $contract): string
    {
        $template = $contract->contractTemplate;
        if (! $template) {
            return $this->wrapHtmlWithStructure('<p>Template não configurado.</p>');
        }

        $templateData = $this->buildTemplateData($contract);
        $html = $template->template;

        foreach ($templateData as $key => $value) {
            $html = str_replace('{{ $'.$key.' }}', (string) $value, $html);
        }

        return $this->wrapHtmlWithStructure($html);
    }

    private function buildTemplateData(Contract $contract): array
    {
        $templateData = [
            'contract_id' => $contract->id,
            'motorista_nome' => $contract->driver_name,
            'motorista_documento' => $contract->driver_document,
            'motorista_cnh' => $contract->driver_license ?? '',
            'motorista_rua' => $contract->driver_street,
            'motorista_numero' => $contract->driver_number,
            'motorista_bairro' => $contract->driver_neighborhood,
            'motorista_cep' => $contract->driver_zip_code,
            'motorista_cidade' => $contract->driver_city,
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
            'caucao' => $contract->deposit_formatted,
            'caucao_extenso' => $contract->deposit_in_words,
        ];

        $carbonStartDate = $contract->start_date ? Carbon::parse($contract->start_date) : Carbon::now();
        $carbonEndDate = $contract->end_date ? Carbon::parse($contract->end_date) : Carbon::now();
        $carbonTodayDate = Carbon::now();
        $carbonContractTodayDate = $contract->today_date ? Carbon::parse($contract->today_date) : Carbon::now();

        if ($contract->today_date) {
            $carbonTodayDate = Carbon::parse($contract->today_date);
        }

        $startDateString = $carbonStartDate->translatedFormat('d').' de '.$carbonStartDate->translatedFormat('F').' de '.$carbonStartDate->translatedFormat('Y');
        $endDateString = $carbonEndDate->translatedFormat('d').' de '.$carbonEndDate->translatedFormat('F').' de '.$carbonEndDate->translatedFormat('Y');
        $todayDateString = $carbonTodayDate->translatedFormat('d').' de '.$carbonTodayDate->translatedFormat('F').' de '.$carbonTodayDate->translatedFormat('Y');
        $contractTodayDateString = $carbonContractTodayDate->translatedFormat('d').' de '.$carbonContractTodayDate->translatedFormat('F').' de '.$carbonContractTodayDate->translatedFormat('Y');

        if ($contract->type === ContractType::OCCASIONAL_RENTAL || $contract->start_date) {
            $templateData['valor_total'] = $contract->value_formatted;
            $templateData['valor_total_extenso'] = $contract->value_in_words;
            $templateData['quantidade_dias'] = $contract->quantity_days ?? 30;
            $templateData['data_inicio'] = $startDateString ?? $todayDateString;
            $templateData['data_fim'] = $endDateString ?? $todayDateString;
        }

        $templateData['data_hoje_extenso'] = $contractTodayDateString;

        return $templateData;
    }

    private function wrapHtmlWithStructure(string $templateContent): string
    {
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
