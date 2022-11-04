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

use Contao\InsertTags;

/**
 * Class PdfGeneratorGeneric
 * @package con4gis\DocumentsBundle\Classes\Pdf
 */
abstract class PdfGeneratorGeneric
{
    private array $options = [];
    private string $savePath = '';
    private string $filename = '';
    private string $html;

    public function __construct(string $html = '')
    {
        $this->html = $html;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function getSavePath(): string
    {
        return $this->savePath;
    }

    /**
     * @param string $savePath
     * @return void
     */
    public function setSavePath(string $savePath): void
    {
        if (substr($savePath, 0, 1) !== DIRECTORY_SEPARATOR) {
            $savePath = DIRECTORY_SEPARATOR . $savePath;
        }
        if (substr($savePath, 0, strlen(TL_ROOT)) !== TL_ROOT) {
            $savePath = TL_ROOT . $savePath;
        }
        $this->savePath = $savePath;
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        return $this->html;
    }

    /**
     * @param string $html
     */
    public function setHtml(string $html): void
    {
        $this->html = $html;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @param string $fileName
     * @return void
     */
    public function setFilename(string $fileName): void
    {
        $fileName = InsertTags::replaceInsertTags($fileName, false);
        if (substr($fileName, 0, 1) !== DIRECTORY_SEPARATOR) {
            $fileName = DIRECTORY_SEPARATOR . $fileName;
        }
        if (strtolower(substr($fileName, strlen($fileName) - 4, strlen($fileName))) != '.pdf') {
            $fileName = $fileName . '.pdf' ;
        }
        $this->filename = $fileName;
    }

    /**
     * Erstellt den Speicherordner für die Pdfs, falls nötig.
     * @param $path
     */
    protected function mkDir($path): void
    {
        if (!is_dir($path)) {
            $mode = $GLOBALS['c4g']['projects']['pdf']['dompdf']['foldermode'] ?? 0777;
            mkdir($path, $mode, true);
        }
    }

    /**
     * @param mixed $pdfstring
     * @param string $suffix
     * @return void
     */
    protected function saveFile($pdfstring, string $suffix = '.pdf'): void
    {
        $filename = $this->generateFilename($suffix);
        file_put_contents($filename, $pdfstring);
    }

    /**
     * Erzeugt einen gültigen Dateinamen.
     * @param string $suffix
     * @return string
     */
    protected function generateFilename(string $suffix = '.pdf'): string
    {
        $i = 1;
        $path = $this->getSavePath();
        $filename = $path . $this->getFilename();
        $filename = str_replace($suffix, '', $filename);
        $this->mkDir($path);

        if (is_file($filename)) {
            while (is_file($filename . '_' . str_pad($i, 3, '0', STR_PAD_LEFT) . $suffix)) {
                $i++;

                if ($i > 100) {
                    break;
                }
            }

            $filename .= '_' . str_pad($i, 3, '0', STR_PAD_LEFT);
        }

        return $filename . $suffix;
    }

    abstract public function streamToBrowser();

    abstract public function saveAsFile();

    abstract public function setPaper(string $size, string $orientation): void;
}
