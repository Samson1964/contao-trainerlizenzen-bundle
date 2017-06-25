<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package Fh-counter
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
    'Samson',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'Samson\Trainerlizenzen\trainerlizenzImport' => 'system/modules/trainerlizenzen/classes/trainerlizenzImport.php',
	'trainerlizenzExport'                        => 'system/modules/trainerlizenzen/classes/trainerlizenzExport.php',
	'Samson\Trainerlizenzen\DOSBLizenzen'        => 'system/modules/trainerlizenzen/classes/DOSBLizenzen.php',
	'Samson\Trainerlizenzen\Mailer'              => 'system/modules/trainerlizenzen/classes/Mailer.php',
	'ajaxRequest'                                => 'system/modules/trainerlizenzen/ajaxRequest.php',
	'Samson\Trainerlizenzen\Trainerliste'        => 'system/modules/trainerlizenzen/classes/Trainerliste.php', 
	'Samson\Trainerlizenzen\Helper'              => 'system/modules/trainerlizenzen/classes/Helper.php', 
));

/**
 * Register the templates
 */
TemplateLoader::addFiles(array
( 
	'be_export_lizenzen'             => 'system/modules/trainerlizenzen/templates',
	'mod_trainerliste'               => 'system/modules/trainerlizenzen/templates',
	'mail_trainerlizenzen_blanko'    => 'system/modules/trainerlizenzen/templates',
	'mail_trainerlizenzen_default'   => 'system/modules/trainerlizenzen/templates',
	'mail_trainerlizenzen_hinweis'   => 'system/modules/trainerlizenzen/templates',
	'mail_trainerlizenzen_leer'      => 'system/modules/trainerlizenzen/templates',
));
