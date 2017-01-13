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

/**
 * Variables
 */
$strFolder = 'con4gis_documents';


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'\c4g\documents'
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
    // PDF-Erzeugugn
    'c4g\documents\PdfDocument'         => "system/modules/$strFolder/classes/pdf/PdfDocument.php",
    'c4g\documents\PdfGeneratorDomPdf'  => "system/modules/$strFolder/classes/pdf/PdfGeneratorDomPdf.php",
    'c4g\documents\PdfGeneratorGeneric' => "system/modules/$strFolder/classes/pdf/PdfGeneratorGeneric.php",

    // Stack
    'c4g\documents\PdfManager'          => "system/modules/$strFolder/classes/stack/PdfManager.php",
    'c4g\documents\PdfStack'            => "system/modules/$strFolder/classes/stack/PdfStack.php",
    'c4g\documents\PdfStackWorker'      => "system/modules/$strFolder/classes/stack/PdfStackWorker.php"
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'pdf_demotemplate'  => "system/modules/$strFolder/templates"
));