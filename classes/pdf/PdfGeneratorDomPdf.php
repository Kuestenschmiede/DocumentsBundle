<?php
/**
 * con4gis - the gis-kit
 *
 * @version   php 5
 * @package   con4gis_documents
 * @author    con4gis contributors (see "authors.txt")
 * @license   GNU/LGPL http://opensource.org/licenses/lgpl-3.0.html
 * @copyright Küstenschmiede GmbH Software & Design 2017
 * @link      https://www.kuestenschmiede.de
 */
namespace c4g\documents;

/**
 * Class PdfGeneratorDomPdf
 * @package c4g\documents
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

        if(isset($GLOBALS['c4g']['projects']['pdf']['dompdf']['deafultoptions'])) {
            $this->setOptions($GLOBALS['c4g']['projects']['pdf']['dompdf']['deafultoptions']);
        }

        if(isset($GLOBALS['c4g']['projects']['pdf']['dompdf']['defaultpath'])) {
            $this->setPath($GLOBALS['c4g']['projects']['pdf']['dompdf']['defaultpath']);
        }

        if(isset($GLOBALS['c4g']['projects']['pdf']['dompdf']['defaultfilename'])) {
            $this->setFilename($GLOBALS['c4g']['projects']['pdf']['dompdf']['defaultfilename']);
        }
    }


    /**
     * Konviguriert den PDF-Generator und rendert das HTML als PDF.
     * @return \Dompdf\Dompdf
     */
    protected function generate()
    {
        $dompdf = new \Dompdf\Dompdf($this->options);
        $dompdf->loadHtml($this->html);
        $dompdf->render();
        return $dompdf;
    }


    /**
     * Erzeugt ein PDF und sendet es an der Browser.
     */
    protected function generateOutput()
    {
        $dompdf = $this->generate();
        $dompdf->stream();
    }


    /**
     * Erzeugt ein PDF und speichert es auf dem Server.
     * @param $file
     */
    protected function generateFile()
    {
        $dompdf     = $this->generate();
        $pdfstring  = $dompdf->output();
        $this->saveFile($pdfstring);
    }
}
