<?php
/**
 * @package     eden
 * @filesource  PdfStackWorker.php
 * @version     1.0.0
 * @since       22.12.16 - 14:13
 * @author      Patrick Froch <info@easySolutionsIT.de>
 * @link        http://easySolutionsIT.de
 * @copyright   e@sy Solutions IT 2016
 * @license     EULA
 */
namespace c4g\documents;

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
