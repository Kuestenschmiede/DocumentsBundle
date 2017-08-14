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
namespace con4gis\DocumentBundle\Classes\Stack;

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

            if($i >= $this->maxCount) {
                break;
            }
        }
    }
}
