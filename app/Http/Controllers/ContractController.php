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

        $watermarkCss = '.pdf-watermark { position: fixed; top: 0; left: 0; right: 0; bottom: 0; '
            .'background: url(images/water-mark.png) center center no-repeat; background-size: 100%; opacity: 0.15; z-index: 0; }'
            .'.pdf-content { position: relative; z-index: 1; }';

        $html = str_replace('</head>', '<style>'.$watermarkCss.'</style></head>', $html);
        $html = str_replace('<body>', '<body><div class="pdf-watermark"></div><div class="pdf-content">', $html);
        $html = str_replace('</body>', '</div></body>', $html);

        $pdf = Pdf::loadHTML($html)->setBasePath(public_path());

        $driverName = strtoupper(preg_replace('/[^A-Z0-9]/i', '-', $contract->driver_name));

        $filename = 'CONTRATO-'.$contract->id.'-'.$driverName.'-'.strtoupper($contract->license_plate).'.pdf';

        return $pdf->download($filename);
    }
}
