<?php

/**
 * @version   php 5
 * @package   con4gis_documents
 * @author    con4gis contributors (see "authors.txt")
 * @license   GNU/LGPL http://opensource.org/licenses/lgpl-3.0.html
 * @copyright Küstenschmiede GmbH Software & Design 2017
 * @link      https://www.kuestenschmiede.de
 */


$GLOBALS['con4gis_documents_extension']['installed'] = true;
$GLOBALS['con4gis_documents_extension']['version']   = '0.2.0-snapshot';


// Speicherort für die Pdfs
$GLOBALS['c4g']['projects']['pdf']['dompdf']['defaultpath']     = 'files/pdfs';

// Dateiname für die Pdfs
$GLOBALS['c4g']['projects']['pdf']['dompdf']['defaultfilename'] = '{{date::Y.m.d-H.i.s}}_document';

// Maximale Anzahl der auszuführenden Jobs pro Aufruf.
$GLOBALS['c4g']['projects']['pdf']['dompdf']['jobsmaxcount']    = 100;

// Optionen für die Pdf-Erstellung
$GLOBALS['c4g']['projects']['pdf']['dompdf']['deafultoptions']  = array(
    'defaultFont'               => 'Courier',
    'defaultPaperSize'          => 'a4',
    'defaultPaperOrientation'   => 'portrait'
);

// Dateirechte, wenn der Ordner für die Pdfs automatisch erstellt wird.
$GLOBALS['c4g']['projects']['pdf']['dompdf']['foldermode']      = 0777;
