<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Services\ContractService;
use Barryvdh\DomPDF\Facade\Pdf;

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
            'contractId' => $id,
        ]);
    }

    public function downloadPdf($id)
    {
        $contract = Contract::findOrFail($id);
        $html = $this->contractService->getContractHtml($contract);

        $footerCss = '@page { margin-bottom: 70px; }'
            .'.pdf-footer { position: fixed; left: 0; right: 10px; bottom: 10px; height: 50px; text-align: right; z-index: 9999; }'
            .'.pdf-footer img { height: 45px; width: auto; filter: grayscale(100%); }';
        $footerHtml = '<div class="pdf-footer"><img src="images/watter_mark.jpg" alt=""></div>';

        $html = str_replace('</head>', '<style>'.$footerCss.'</style></head>', $html);
        $html = str_replace('</body>', $footerHtml.'</body>', $html);

        $pdf = Pdf::loadHTML($html)->setBasePath(public_path());

        $driverName = strtoupper(preg_replace('/[^A-Z0-9]/i', '-', $contract->driver_name));

        $filename = 'CONTRATO-'.$contract->id.'-'.$driverName.'-'.strtoupper($contract->license_plate).'.pdf';

        return $pdf->download($filename);
    }
}
