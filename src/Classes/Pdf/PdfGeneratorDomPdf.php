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
        $options = $this->getOptions();
        $options['isPhpEnabled'] = true;
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($this->getHtml());
        if (!empty($this->paper)) {
            $dompdf->setPaper($this->paper[0], $this->paper[1]);
        }
        $dompdf->render();

        $canvas = $dompdf->getCanvas();
        if ($canvas) {
            $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
                $text = ($GLOBALS['TL_LANG']['fe_c4g_reservation']['page'] ?: 'Seite') . " $pageNumber " . ($GLOBALS['TL_LANG']['fe_c4g_reservation']['page_of'] ?: 'von') . " $pageCount";
                $font = $fontMetrics->getFont("Verdana");
                $size = 10;
                $width = $fontMetrics->get_text_width($text, $font, $size);
                $x = ($canvas->get_width() - $width) / 2;
                $y = $canvas->get_height() - 35;
                $canvas->text($x, $y, $text, $font, $size);
            });
        }

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
