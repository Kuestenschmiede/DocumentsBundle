<?php
/**
 * @package     eden
 * @filesource  PdfStack.php
 * @version     1.0.0
 * @since       16.12.16 - 19:36
 * @author      Patrick Froch <info@easySolutionsIT.de>
 * @link        http://easySolutionsIT.de
 * @copyright   e@sy Solutions IT 2016
 * @license     EULA
 */
namespace c4g\documents;

/**
 * Class PdfStack
 * @package c4g\documents
 */
class PdfStack extends \c4g\core\StackDatabase
{


    /**
     * Name der Tabelle für den Stack für die Pdf-Erzeugung.
     * @var string
     */
    protected $table = 'tl_pdfstack';


    /**
     * Liest alle Datensätze des Stacks aus, ohne ihn zu verändern.
     * @return array
     */
    public function getAll()
    {
        $query  = 'SELECT * FROM `' . $this->table . '` ORDER BY id ASC';
        $result = \Contao\Database::getInstance()->execute($query);

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
