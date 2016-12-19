<?php
/**
 * @package     con4gis_print
 * @filesource  PdfDocument.php
 * @version     1.0.0
 * @since       16.12.16 - 17:26
 * @author      Patrick Froch <info@easySolutionsIT.de>
 * @link        http://easySolutionsIT.de
 * @copyright   e@sy Solutions IT 2016
 * @license     EULA
 */
namespace c4g\documents;

/**
 * Class PdfDocument
 * @package c4g\projects
 */
class PdfDocument
{


    /**
     * Instanz der PDF-Generators
     * @var PdfGeneratorGeneric|null
     */
    protected $pdf = null;


    /**
     * Name des Templates
     * @var string
     */
    protected $templateName = '';


    /**
     * Instanz des Telpmates
     * @var null
     */
    protected $template = null;


    /**
     * Daten für das Template
     * @var array
     */
    protected $data = array();


    /**
     * PdfDocument constructor.
     * @param PdfGeneratorGeneric $pdf
     */
    public function __construct(PdfGeneratorGeneric $pdf = null)
    {
        if ($pdf !== null) {
            $this->pdf = $pdf;
        } else {
            $this->pdf = new PdfGeneratorDomPdf();
        }
    }


    /**
     * Setzt die Optionen für die PDF-Erzeugung.
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->pdf->setOptions($options);
    }


    /**
     * Gibt die Optionen der PDF-Erzeugung zurück.
     * @return array
     */
    public function getOptions()
    {
        return $this->pdf->getOptions();
    }


    /**
     * Setzt den Pfad für die Speicherung des PDFs.
     * @param $path
     */
    public function setPath($path)
    {
        $this->pdf->setPath($path);
    }


    /**
     * Gibt den Pfad für die Speicherung des PDFs zurück.
     * @return string
     */
    public function getPath()
    {
        return $this->pdf->getPath();
    }


    /**
     * Setzt das Schema füe den Dateinamen des PDFs.
     * @param $filename
     */
    public function setFilename($filename)
    {
        $this->pdf->setFilename($filename);
    }


    /**
     * Gibt den geparsten Dateinamen zurück.
     * @return mixed
     */
    public function getFilename()
    {
        return $this->pdf->getFilename();
    }


    /**
     * Setzt den Namen des Templates für das PDF.
     * @param $tampleteName
     */
    public function setTemplateName($tampleteName)
    {
        $this->templateName = $tampleteName;
        $template           = new \Contao\FrontendTemplate($tampleteName);
        $this->setTemplate($template);
    }


    /**
     * Gibt den Namen des Templates des PDFs zurück.
     * @return string
     */
    public function getTemplateName()
    {
        return $this->templateName;
    }


    /**
     * Setzt das Template für das PDF.
     * @param \Contao\FrontendTemplate $template
     */
    public function setTemplate(\Contao\FrontendTemplate $template)
    {
        $this->template = $template;
    }


    /**
     * Gibt das Template des PDFs zurück.
     * @return null
     */
    public function getTemplate()
    {
        return $this->template;
    }


    /**
     * Setzt die Daten für das Template.
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }


    /**
     * Gibt die Daten für des Templates zurück.
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }


    /**
     * Bietet das PDF zum Speichern an.
     */
    public function save()
    {
        $this->generate();
        $this->pdf->save();
    }


    /**
     * Sendet das PDF an den Browser.
     */
    public function output()
    {
        $this->generate();
        $this->pdf->output();
    }


    /**
     * Erzeugt aus dem Template und den Daten das HTML für das PDF.
     */
    protected function generate()
    {
        $template   = $this->getTemplate();
        $data       = $this->getData();
        $template->setData($data);
        $html       = $template->parse();
        $this->pdf->setHtml($html);
    }
}
