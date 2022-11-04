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
use Contao\Template;

/**
 * Class PdfDocument
 * @package con4gis\DocumentsBundle\Classes\Pdf
 */
class PdfDocument
{
    private ?PdfGeneratorGeneric $pdf;
    private string $templateName = '';
    private ?Template $template = null;
    private array $data = [];

    /**
     * @param PdfGeneratorGeneric|null $pdf
     * @param string $pdfProtected
     */
    public function __construct(PdfGeneratorGeneric $pdf = null, string $pdfProtected = '')
    {
        if ($pdf !== null) {
            $this->pdf = $pdf;
        } else {
            $this->pdf = new PdfGeneratorDomPdf('', $pdfProtected);
        }
    }

    /**
     * @param array $options
     * @return void
     */
    public function setOptions(array $options): void
    {
        $this->pdf->setOptions($options);
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->pdf->getOptions();
    }

    /**
     * @param string $path
     * @return void
     * @deprecated
     */
    public function setPath(string $path): void
    {
        $this->setSavePath($path);
    }

    public function setSavePath(string $path): void
    {
        $this->pdf->setSavePath($path);
    }

    /**
     * @return string
     * @deprecated
     */
    public function getPath(): string
    {
        return $this->getSavePath();
    }

    public function getSavePath(): string
    {
        return $this->pdf->getSavePath();
    }

    public function setFilename(string $filename): void
    {
        $this->pdf->setFilename($filename);
    }

    public function getFilename(): string
    {
        return $this->pdf->getFilename();
    }

    /**
     * @return string
     * @deprecated
     */
    public function getTemplateName(): string
    {
        return $this->templateName;
    }

    /**
     * @param string $templateName
     * @deprecated
     */
    public function setTemplateName(string $templateName): void
    {
        $this->templateName = $templateName;
    }

    /**
     * @return Template|null
     */
    public function getTemplate(): ?Template
    {
        return $this->template;
    }

    /**
     * @param Template $template
     */
    public function setTemplate(Template $template): void
    {
        $this->template = $template;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @deprecated
     */
    public function save(): void
    {
        $this->saveAsFile();
    }

    /**
     * @deprecated
     */
    public function output(): void
    {
        $this->streamToBrowser();
    }

    public function saveAsFile(): void
    {
        $this->generateHtmlFromTemplate();
        $this->pdf->saveAsFile();
    }

    public function streamToBrowser(): void
    {
        $this->generateHtmlFromTemplate();
        $this->pdf->streamToBrowser();
    }

    private function generateHtmlFromTemplate(): void
    {
        if ($this->template === null) {
            $this->template = new FrontendTemplate($this->templateName);
        }
        $this->template->setData($this->data);
        $this->pdf->setHtml($this->template->parse());
        $this->pdf->setOptions($this->data);
    }
}
