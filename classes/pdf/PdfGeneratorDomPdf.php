<?php
/**
 * @package     con4gis_print
 * @filesource  PdfGeneratorDomPdf.php
 * @version     1.0.0
 * @since       16.12.16 - 10:18
 * @author      Patrick Froch <info@easySolutionsIT.de>
 * @link        http://easySolutionsIT.de
 * @copyright   e@sy Solutions IT 2016
 * @license     EULA
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
            $this->setFielname($GLOBALS['c4g']['projects']['pdf']['dompdf']['defaultfilename']);
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
