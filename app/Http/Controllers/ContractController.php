<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Services\ContractService;

class ContractController extends Controller
{
    public function __construct(
        private ContractService $contractService
    ) {}

    public function show($id)
    {
        $contract = Contract::findOrFail($id);
        $html = $this->contractService->getContractHtml($contract);

        $dom = new \DOMDocument;
        @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
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
            $bodyContent = $html;
        }

        return view('contracts.show', [
            'content' => $bodyContent,
            'styles' => $styles,
        ]);
    }
}
