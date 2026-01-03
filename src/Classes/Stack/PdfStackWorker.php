<?php
/*
 * This file is part of con4gis, the gis-kit for Contao CMS.
 * @package con4gis
 * @author con4gis contributors (see "authors.md")
 * @license LGPL-3.0-or-later
 * @copyright (c) 2010-2026, by Küstenschmiede GmbH Software & Design
 * @link https://www.con4gis.org
 */
namespace con4gis\DocumentsBundle\Classes\Stack;

class PdfStackWorker
{
    /**
     * Instanz der PdfManagers
     * @var PdfManager|null
     */
    public $pdfManager = null;

    /**
     * Maximale Anzahl der auszuführenden Jobs pro Aufruf.
     * @var int
     */
    public $maxCount = 0;

    /**
     * PdfStackWorker constructor.
     * @param PdfManager|null $pdfManager
     */
    public function __construct(PdfManager $pdfManager = null)
    {
        if ($pdfManager) {
            $this->pdfManager = $pdfManager;
        } else {
            $this->pdfManager = new PdfManager();
        }

        if (isset($GLOBALS['c4g']['projects']['pdf']['dompdf']['jobsmaxcount'])) {
            $this->setMaxCount($GLOBALS['c4g']['projects']['pdf']['dompdf']['jobsmaxcount']);
        }
    }

    /**
     * @return int
     */
    public function getMaxCount()
    {
        return $this->maxCount;
    }

    /**
     * @param int $maxCount
     */
    public function setMaxCount($maxCount)
    {
        $this->maxCount = $maxCount;
    }

    /**
     * Ruft die Verarbeitung des PdfStacks auf.
     */
    public function run()
    {
        $i = 0;

        while ($this->pdfManager->pop()) {
            $this->pdfManager->save();
            $i++;

            if ($i >= $this->maxCount) {
                break;
            }
        }
    }
}
