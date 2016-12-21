<?php
/**
 * @package     con4gis_print
 * @filesource  autoload.php
 * @version     1.0.0
 * @since       14.12.16 - 16:50
 * @author      Patrick Froch <info@easySolutionsIT.de>
 * @link        http://easySolutionsIT.de
 * @copyright   e@sy Solutions IT 2016
 * @license     EULA
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
    'c4g\documents\PdfStack'            => "system/modules/$strFolder/classes/stack/PdfStack.php"
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'pdf_demotemplate'  => "system/modules/$strFolder/templates"
));