<?php
/*
 * This file is part of con4gis, the gis-kit for Contao CMS.
 * @package con4gis
 * @version 8
 * @author con4gis contributors (see "authors.txt")
 * @license LGPL-3.0-or-later
 * @copyright (c) 2010-2021, by Küstenschmiede GmbH Software & Design
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
    /**
     * PdfGeneratorDomPdf constructor.
     * @param null $html
     */
    public function __construct($html = null)
    {
        parent::__construct($html);

        if (isset($GLOBALS['c4g']['projects']['pdf']['dompdf']['deafultoptions'])) {
            $this->setOptions($GLOBALS['c4g']['projects']['pdf']['dompdf']['deafultoptions']);
        }

        if (isset($GLOBALS['c4g']['projects']['pdf']['dompdf']['defaultpath'])) {
            $this->setPath($GLOBALS['c4g']['projects']['pdf']['dompdf']['defaultpath']);
        }

        if (isset($GLOBALS['c4g']['projects']['pdf']['dompdf']['defaultfilename'])) {
            $this->setFilename($GLOBALS['c4g']['projects']['pdf']['dompdf']['defaultfilename']);
        }
    }

    /**
     * Konviguriert den PDF-Generator und rendert das HTML als PDF.
     * @return \Dompdf\Dompdf
     */
    protected function generate()
    {
        $dompdf = new Dompdf($this->options);
        $dompdf->loadHtml($this->html);
        $dompdf->render();

        return $dompdf;
    }

    /**
     * Erzeugt ein PDF und sendet es an der Browser.
     */
    protected function generateOutput()
    {
        $filename = $this->getFilename();
        $filename = str_replace('.pdf', '', $filename);   // Wird con dompdf automatisch gesetzt!
        $dompdf = $this->generate();
        $dompdf->stream($filename, $this->getOptions());
    }

    /**
     * Erzeugt ein PDF und speichert es auf dem Server.
     * @param $file
     */
    protected function generateFile()
    {
        $dompdf = $this->generate();
        $pdfstring = $dompdf->output();
        $this->saveFile($pdfstring);
    }
}
