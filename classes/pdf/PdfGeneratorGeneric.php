<?php
/**
 * @package     con4gis_print
 * @filesource  PdfGeneratorGeneric.php
 * @version     1.0.0
 * @since       16.12.16 - 09:46
 * @author      Patrick Froch <info@easySolutionsIT.de>
 * @link        http://easySolutionsIT.de
 * @copyright   e@sy Solutions IT 2016
 * @license     EULA
 */
namespace c4g\documents;

/**
 * Class PdfGeneratorGeneric
 * @package c4g\documents
 */
abstract class PdfGeneratorGeneric
{


    /**
     * Array mit den Optionen für die PDF-Erstellung
     * @var array
     */
    protected $options = array();


    /**
     * Speicherort für die PDF-Dateien
     * @var string
     */
    protected $path = '';


    /**
     * Dateiname für die PDF-Datei
     * @var string
     */
    protected $filename = '';


    /**
     * HTML-Source für das PDF.
     * @var string
     */
    protected $html = '';


    /**
     * PdfGenerator constructor.
     * @param null $html
     */
    protected function __construct($html = null)
    {
        if ($html !== null) {
            $this->setHtml($html);
        }
    }


    /**
     * Setzt eine Einstellung für die PDF-Erzeugung.
     * @param $name
     * @param $value
     */
    public function set($name, $value)
    {
        $this->options[$name] = $value;
    }


    /**
     * Gibt der Wert einer Einstellung zurück.
     * @param $name
     * @return mixed|null|string
     */
    public function get($name)
    {
        if (isset($this->options[$name])) {
            return $this->options[$name];
        }

        return null;
    }


    /**
     * Setzt ein Array als Einstellung für die PDF-Erzeugung.
     * @param array $options
     */
    public function setOptions(array $options)
    {
        foreach ($options as $name => $value) {
            $this->set($name, $value);
        }
    }


    /**
     * Gibt das Array mit den Einstellungen für die PDF-Erzeugung zurück.
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }


    /**
     * Setzt das HTML für das PDF.
     * @param $html
     */
    public function setHtml($html)
    {
        $this->html = $html;
    }


    /**
     * Gibt das HTML zurück.
     * @return string
     */
    public function getHtml()
    {
        return $this->html;
    }


    /**
     * Setzt den Pfad für das Speichern der PDF-Dateien.
     * @param $path
     */
    public function setPath($path)
    {
        $path       = (substr($path, 0, 1) != DIRECTORY_SEPARATOR) ? DIRECTORY_SEPARATOR . $path : $path;
        $path       = (substr($path, 0, strlen(TL_ROOT)) != TL_ROOT) ? TL_ROOT . $path : $path;
        $this->path = $path;
    }


    /**
     * Gibt den Pfaad für das Speichern der PDF-Dateien zurück.
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }


    /**
     * Gibt den Speichertort für das Pdf zurück (inkl. Pfad und Dateierweiterung).
     * @param $file
     */
    public function setFilename($file)
    {
        $file = \Contao\InsertTags::replaceInsertTags($file, false);
        $file = (substr($file, 0, 1) != DIRECTORY_SEPARATOR) ? DIRECTORY_SEPARATOR . $file : $file;
        $file = (strtolower(substr($file, strlen($file)-4, strlen($file))) != '.pdf') ? $file . '.pdf' : $file;
        $this->filename = $file;
    }


    /**
     * Gibt den geparsten Dateinamen für das Pdf zurück.
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }


    /**
     * Erstellt den Speicherordner für die Pdfs, falls nötig.
     * @param $path
     */
    protected function mkDir($path)
    {
        if (! is_dir($path)) {
            if (isset($GLOBALS['c4g']['projects']['pdf']['dompdf']['foldermode'])) {
                $mode = $GLOBALS['c4g']['projects']['pdf']['dompdf']['foldermode'];
            } else {
                $mode = 0777;
            }
            mkdir($path, $mode, true);
        }
    }

    /**
     * Speichert die Daten auf der Festplatte.
     * @param $pdfstring
     */
    protected function saveFile($pdfstring)
    {
        $path       = $this->getPath();
        $filename   = $path . $this->getFilename();
        $this->mkDir($path);
        file_put_contents($filename, $pdfstring);
    }


    /**
     * Wrapper für die Erzeugung eines PDFs, dass direkt an den Browser gesendet werden soll.
     * Ermöglicht eine einheitliche Schnittstelle bei verschiedenen PDF-Generatoren.
     */
    public function output()
    {
        $this->generateOutput();
    }


    /**
     * Wrapper für die Erzeugung einer PDF-Datei.
     * Ermöglicht eine einheitliche Schnittstelle bei verschiedenen PDF-Generatoren.
     */
    public function save()
    {
        $this->generateFile();
    }

    /**
     * Muss in der Kindklasse definiert werden.
     * Erzeugt ein PDF über den PDF-Generator und sendet es an der Browser.
     */
    abstract protected function generateOutput();


    /**
     * Muss in der Kindklasse definiert werden.
     * Erzeugt ein PDF über den PDF-Generator und ruft den Speichern-Dialog auf.
     */
    abstract protected function generateFile();
}
