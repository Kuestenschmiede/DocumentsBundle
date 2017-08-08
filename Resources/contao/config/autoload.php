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
$strBundle = 'con4gis/DocumentBundle';

/**
 * Register the templates
 */
\con4gis\CoreBundle\Classes\Helper\AutoloadHelper::loadTemplates("/src/$strBundle/");