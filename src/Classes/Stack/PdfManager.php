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
namespace con4gis\DocumentsBundle\Classes\Stack;

use con4gis\DocumentsBundle\Classes\Pdf\PdfDocument;

/**
 * Class PdfManager
 * @package con4gis\DocumentsBundle\Classes\Stack
 */
class PdfManager
{
    /**
     * Instanz von PdfStack
     * @var PdfStack|null
     */
    protected $pdfStack = null;

    /**
     * Instanz von PdfDocument
     * @var PdfDocument|null
     */
    protected $PdfDocument = null;

    /**
     * Array mit den Daten des aktuellen Datensatzes
     * @var array
     */
    protected $data = [];

    /**
     * Felder, die im Array $this->data gesetzt sein müssen, damit ein PDF erstellt werden kann.
     * @var array
     */
    protected $checkField = ['template', 'filename', 'filepath'];

    /**
     * PdfStackManager constructor.
     * @param PdfStack|null    $pdfStack
     * @param PdfDocument|null $pdfDocument
     */
    public function __construct(PdfStack $pdfStack = null, PdfDocument $pdfDocument = null, $pdfProtected = '')
    {
        if ($pdfStack) {
            $this->pdfStack = $pdfStack;
        } else {
            $this->pdfStack = new PdfStack();
        }

        if ($pdfDocument) {
            $this->PdfDocument = $pdfDocument;
        } else {
            $this->PdfDocument = new PdfDocument(null, $pdfProtected);
        }
    }

    /**
     * Setzt eine Einstellung für das PDF.
     * @param $key
     * @param $value
     */
    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * Gibt einen Einstellung aus den Daten des PDFs zurück.
     * @param $key
     * @return mixed
     */
    public function __get($key)
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }

        return null;
    }

    /**
     * Ersetzt das Daten-Array.
     * @param $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Setzt das Daten-Array zurück.
     */
    public function resetData()
    {
        $this->data = [];
    }

    /**
     * Legt die aktuellen Daten auf den Stack.
     */
    public function push()
    {
        $this->pdfStack->push($this->data);
    }

    /**
     * Ruft einen Datensatz vom Stack ab.
     * @return bool
     */
    public function pop()
    {
        $this->resetData();
        $this->data = $this->pdfStack->pop();

        return (is_array($this->data) && count($this->data));
    }

    /**
     * Erzeugt und Speichert ein PDF.
     */
    public function save()
    {
        $this->processData();
        $this->PdfDocument->save();
    }

    /**
     * Erzeugt ein PDF und gibt es aus.
     */
    public function output()
    {
        $this->processData();
        $this->PdfDocument->output();
    }

    /**
     * Setzt die Daten für das PDF.
     */
    protected function processData()
    {
        if ($this->checkData()) {
            $this->PdfDocument->setTemplateName($this->data['template']);
            $this->PdfDocument->setFilename($this->data['filename']);
            $this->PdfDocument->setPath($this->data['filepath']);
            $this->PdfDocument->setData($this->data);
        }
    }

    /**
     * Prüft, ob die erforderlichen Daten für das Erstellen eines PDFs gesetzt sind.
     * @return bool
     * @throws \Exception
     */
    public function checkData()
    {
        if (is_array($this->data) && count($this->data)) {
            foreach ($this->checkField as $field) {
                if (!isset($this->data[$field]) || !$this->data[$field]) {
                    throw new \Exception($field . ' is not set!');
                }
            }

            return true;
        }

        return false;
    }

    /**
     * @return PdfDocument|null
     */
    public function getPdfDocument()
    {
        return $this->PdfDocument;
    }
}
