<?php

namespace App\Http\Controllers;

use App\Enums\ContractType;
use App\Models\Contract;

class ContractController extends Controller
{
    public function show($id)
    {
        $contract = Contract::findOrFail($id);

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
            ContractType::AppRental => 'app-rental',
            ContractType::OccasionalRental => 'occasional-rental',
        };

        $templateContent = view('components.templates.'.$templateName, $templateData)->render();

        $dom = new \DOMDocument;
        @$dom->loadHTML('<?xml encoding="UTF-8">'.$templateContent, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new \DOMXPath($dom);

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

        return view('contracts.show', [
            'content' => $bodyContent,
            'styles' => $styles,
        ]);
    }
}
