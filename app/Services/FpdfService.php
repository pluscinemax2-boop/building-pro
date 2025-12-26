<?php

namespace App\Services;

use FPDF;

class FpdfService extends FPDF
{
    public function __construct($orientation = 'P', $unit = 'mm', $size = 'A4')
    {
        parent::__construct($orientation, $unit, $size);
    }

    public function addHtmlPage($html)
    {
        // Basic HTML to FPDF conversion (FPDF does not support full HTML)
        // For more advanced HTML, consider using setasign/fpdi or a wrapper
        $this->AddPage();
        $this->SetFont('Arial', '', 12);
        $this->Write(5, strip_tags($html));
    }

    public function outputDownload($filename = 'document.pdf')
    {
        return $this->Output('D', $filename);
    }

    public function outputInline($filename = 'document.pdf')
    {
        return $this->Output('I', $filename);
    }
}
