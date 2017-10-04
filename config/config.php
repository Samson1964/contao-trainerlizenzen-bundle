<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2013 Leo Feyer
 *
 * @package   bdf
 * @author    Frank Hoppe
 * @license   GNU/LGPL
 * @copyright Frank Hoppe 2014
 */

define(TRAINERLIZENZEN_ABSENDER, $GLOBALS['TL_CONFIG']['trainerlizenzen_absender']);
define(TRAINERLIZENZEN_PFAD, TL_ROOT . '/files/trainerlizenzen');

// Zugang LiMS
define(LIMS_HOST, $GLOBALS['TL_CONFIG']['lims_host']);
define(LIMS_USERNAME, $GLOBALS['TL_CONFIG']['lims_username']);
define(LIMS_PASSWORD, $GLOBALS['TL_CONFIG']['lims_password']);
define(LIMS_LINK, $GLOBALS['TL_CONFIG']['lims_link']);

/**
 * Backend-Bereich DSB anlegen, wenn noch nicht vorhanden
 */
if(!$GLOBALS['BE_MOD']['dsb']) 
{
	$dsb = array(
		'dsb' => array()
	);
	array_insert($GLOBALS['BE_MOD'], 0, $dsb);
}

$GLOBALS['BE_MOD']['dsb']['trainerlizenzen'] = array
(
	'tables'            => array('tl_trainerlizenzen', 'tl_trainerlizenzen_referenten', 'tl_trainerlizenzen_mails'),
	'icon'              => 'system/modules/trainerlizenzen/assets/images/icon.png',
	'export'            => array('trainerlizenzExport', 'exportTrainer'),
	'exportXLS'         => array('trainerlizenzExport', 'exportXLSTrainer'),
	'import'            => array('Samson\Trainerlizenzen\trainerlizenzImport', 'importTrainer'), 
	'getLizenz'         => array('Samson\Trainerlizenzen\DOSBLizenzen', 'getLizenz'),
	'getLizenzPDF'      => array('Samson\Trainerlizenzen\DOSBLizenzen', 'getLizenzPDF'),
	'getLizenzPDFCard'  => array('Samson\Trainerlizenzen\DOSBLizenzen', 'getLizenzPDFCard'),
	'exportDOSB'        => array('Samson\Trainerlizenzen\DOSBLizenzen', 'exportDOSB'),
	'send'              => array('Samson\Trainerlizenzen\Mailer', 'send'), 
);

// SimpleAjax Hook
$GLOBALS['TL_HOOKS']['simpleAjax'][] = array('ajaxRequest', 'compile');

/**
 * Frontend-Module
 */
$GLOBALS['FE_MOD']['dsb']['trainerlizenzen'] = 'Samson\Trainerlizenzen\Trainerliste';

// Konfiguration für ProSearch
$GLOBALS['PS_SEARCHABLE_MODULES']['trainerlizenzen'] = array(
	'icon'              => 'system/modules/trainerlizenzen/assets/images/icon.png',
	'title'             => array('name'),
	'searchIn'          => array('vorname','name', 'email', 'lizenznummer'),
	'tables'            => array('tl_trainerlizenzen'),
	'shortcut'          => 'tlizenzen'
);

