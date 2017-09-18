<?php
/**
 * con4gis - the gis-kit
 *
 * @version   php 7
 * @package   con4gis_documents
 * @author    con4gis contributors (see "authors.txt")
 * @license   GNU/LGPL http://opensource.org/licenses/lgpl-3.0.html
 * @copyright Küstenschmiede GmbH Software & Design 2017
 * @link      https://www.kuestenschmiede.de
 */
namespace con4gis\DocumentsBundle\Classes\Stack;

use con4gis\CoreBundle\Resources\contao\classes\stack\StackDatabase;
use Contao\Database;

/**
 * Class PdfStack
 * @package con4gis\DocumentsBundle\Classes\Stack
 */
class PdfStack extends StackDatabase
{


    /**
     * Name der Tabelle für den Stack für die Pdf-Erzeugung.
     * @var string
     */
    protected $table = 'tl_c4g_documents_pdfstack';


    /**
     * Liest alle Datensätze des Stacks aus, ohne ihn zu verändern.
     * @return array
     */
    public function getAll()
    {
        $query  = 'SELECT * FROM `' . $this->table . '` ORDER BY id ASC';
        $result = Database::getInstance()->execute($query);

        if ($result->numRows) {
            $data = $result->fetchAllAssoc();

            if (is_array($data) && count($data)) {
                for ($i = 0; $i < count($data); $i++) {
                    if (isset($data[$i]['data']) && is_string($data[$i]['data'])) {
                        $data[$i] = deserialize($data[$i]['data'], true);
                    }
                }

                return $data;
            }
        }

        return array();
    }


    /**
     * Gibt den obersten Eintrag des Stacks zurück.
     * @return array|mixed
     */
    public function pop()
    {
        $data = parent::pop();

        if (isset($data['data']) && is_string($data['data'])) {
            $data = deserialize($data['data'], true);
        }

        return $data;
    }
}
