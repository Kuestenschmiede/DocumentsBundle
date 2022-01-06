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
