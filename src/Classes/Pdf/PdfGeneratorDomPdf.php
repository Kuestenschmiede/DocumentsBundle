<?php
/*
 * This file is part of con4gis, the gis-kit for Contao CMS.
 * @package con4gis
 * @author con4gis contributors (see "authors.md")
 * @license LGPL-3.0-or-later
 * @copyright (c) 2010-2026, by Küstenschmiede GmbH Software & Design
 * @link https://www.con4gis.org
 */
namespace con4gis\DocumentsBundle\Classes\Pdf;

use Dompdf\Dompdf;

/**
 * Class PdfGeneratorDomPdf
 * @package con4gis\DocumentsBundle\Classes\Pdf
 */
class PdfGeneratorDomPdf extends PdfGeneratorGeneric
{
    private string $pdfProtected;
    private array $paper = [];

    /**
     * @param $html
     * @param string $pdfProtected
     */
    public function __construct($html = null, string $pdfProtected = '')
    {
        $this->pdfProtected = $pdfProtected;
        parent::__construct($html);

        if (isset($GLOBALS['c4g']['projects']['pdf']['dompdf']['defaultoptions'])) {
            $this->setOptions($GLOBALS['c4g']['projects']['pdf']['dompdf']['defaultoptions']);
        }

        if (isset($GLOBALS['c4g']['projects']['pdf']['dompdf']['defaultpath'])) {
            $this->setSavePath($GLOBALS['c4g']['projects']['pdf']['dompdf']['defaultpath']);
        }

        if (isset($GLOBALS['c4g']['projects']['pdf']['dompdf']['defaultfilename'])) {
            $this->setFilename($GLOBALS['c4g']['projects']['pdf']['dompdf']['defaultfilename']);
        }
    }

    /**
     * @return Dompdf
     */
    protected function generate(): Dompdf
    {
        $dompdf = new Dompdf($this->getOptions());
        $dompdf->loadHtml($this->getHtml());
        if (!empty($this->paper)) {
            $dompdf->setPaper($this->paper[0], $this->paper[1]);
        }
        $dompdf->render();

        if ($this->pdfProtected) {
            $dompdf->getCanvas()->get_cpdf()->setEncryption($this->pdfProtected, null, ['print']);
            $dompdf->getCanvas()->get_cpdf()->encrypted = true;
        }

        return $dompdf;
    }

    public function streamToBrowser()
    {
        $filename = $this->getFilename();
        $filename = str_replace('.pdf', '', $filename);
        $dompdf = $this->generate();
        $dompdf->stream($filename, $this->getOptions());
    }

    public function saveAsFile()
    {
        $dompdf = $this->generate();
        $pdfString = $dompdf->output();
        $this->saveFile($pdfString);
    }

    public function setPaper(string $size, string $orientation): void
    {
        $this->paper = [$size, $orientation];
    }
}
