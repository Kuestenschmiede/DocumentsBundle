<?php
/*
 * This file is part of con4gis, the gis-kit for Contao CMS.
 * @package con4gis
 * @version 8
 * @author con4gis contributors (see "authors.txt")
 * @license LGPL-3.0-or-later
 * @copyright (c) 2010-2022, by Küstenschmiede GmbH Software & Design
 * @link https://www.con4gis.org
 */
namespace con4gis\DocumentsBundle\Classes\Pdf;

use Contao\FrontendTemplate;

/**
 * Class PdfDocument
 * @package con4gis\DocumentsBundle\Classes\Pdf
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
    protected $data = [];

    /**
     * PdfDocument constructor.
     * @param PdfGeneratorGeneric $pdf
     */
    public function __construct(PdfGeneratorGeneric $pdf = null, $pdfProtected = '')
    {
        if ($pdf !== null) {
            $this->pdf = $pdf;
        } else {
            $this->pdf = new PdfGeneratorDomPdf(null, $pdfProtected);
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
        $template = new FrontendTemplate($tampleteName);
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
    public function setTemplate(FrontendTemplate $template)
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
        $template = $this->getTemplate();
        $data = $this->getData();
        $template->setData($data);
        $html = $template->parse();
        $this->pdf->setHtml($html);
        $this->pdf->setOptions($this->getData());
    }
}
