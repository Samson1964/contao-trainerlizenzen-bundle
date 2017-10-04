<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @package   Trainerlizenzen
 * @author    Frank Hoppe <webmaster@schachbund.de>
 * @license   http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 * @copyright Frank Hoppe 2014 - 2017
 */

$GLOBALS['TL_CSS'][] = 'system/modules/trainerlizenzen/assets/css/default.css';

/**
 * Table tl_trainerlizenzen
 */
$GLOBALS['TL_DCA']['tl_trainerlizenzen'] = array
(
	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ctable'                      => array('tl_trainerlizenzen_mails'),
		'enableVersioning'            => true,
		'switchToEdit'                => true,
		'onload_callback' => array
		(
			array('tl_trainerlizenzen', 'applyAdvancedFilter'),
			array('tl_trainerlizenzen', 'getVerbandsmails'),
		), 
		'sql' => array
		(
			'keys' => array
			(
				'id'             => 'primary',
				'vorname'        => 'index',
				'name'           => 'index',
				'erwerb'         => 'index',
				'gueltigkeit'    => 'index',
			)
		)
	),
	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 2,
			'fields'                  => array('name ASC', 'vorname ASC'),
			'flag'                    => 11,
			'panelLayout'             => 'myfilter;filter;search,sort,limit',
			'panel_callback'          => array('myfilter' => array('tl_trainerlizenzen', 'generateAdvancedFilter')),  
		),
		'label' => array
		(
			'fields'                  => array('name', 'vorname', 'verband', 'lizenz', 'gueltigkeit', 'license_number_dosb'),
			'showColumns'             => true,
			//'label_callback'          => array('tl_trainerlizenzen', 'convertDate') 
		),
		'global_operations' => array
		(
			'referenten' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['referenten'],
				'href'                => 'table=tl_trainerlizenzen_referenten',
				'icon'                => 'system/modules/trainerlizenzen/assets/images/referenten.png',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			),
			'exportDOSB' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['exportDOSB'],
				'href'                => 'key=exportDOSB',
				'icon'                => 'system/modules/trainerlizenzen/assets/images/export.png',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			),
			'export' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['export'],
				'href'                => 'key=export',
				'icon'                => 'system/modules/trainerlizenzen/assets/images/exportCSV.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			),
			'exportXLS' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['exportXLS'],
				'href'                => 'key=exportXLS',
				'icon'                => 'system/modules/trainerlizenzen/assets/images/exportEXCEL.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			),
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'email' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['emailbox'],
				'href'                => 'table=tl_trainerlizenzen_mails',
				'icon'                => 'system/modules/trainerlizenzen/assets/images/email.png',
				'button_callback'     => array('tl_trainerlizenzen', 'toggleEmail')
			), 
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif',
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('tl_trainerlizenzen', 'toggleIcon')
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),
	// Palettes
	'palettes' => array
	(
		'__selector__'                => array('codex', 'help'),
		//'default'                     => '{verification_legend},verification;{dosb_legend},license_number_dosb,button_license,view_pdf,button_pdf;{marker_legend},marker;{name_legend},vorname,name,titel,geburtstag,geschlecht;{adresse_legend},strasse,plz,ort,email,telefon;{verband_legend},verband;{lizenz_legend},lizenznummer,lizenz;{lizenzver_legend},erwerb,verlaengerung1,verlaengerung2,verlaengerung3,verlaengerung4,verlaengerung5;{lizenzbis_legend},gueltigkeit;{codex_legend},codex,help;{datum_legend},letzteAenderung;{hinweise_legend:hide},bemerkung;{published_legend},published'
		'default'                     => 'verification,{dosb_legend},license_number_dosb,button_license,view_pdf,button_pdf,view_pdfcard,button_pdfcard;{marker_legend},marker;{name_legend},vorname,name,titel,geburtstag,geschlecht;{adresse_legend},strasse,plz,ort,email,telefon;{verband_legend},verband;{lizenz_legend},lizenznummer,lizenz;{lizenzver_legend},erwerb,verlaengerungen;{lizenzbis_legend},gueltigkeit;{codex_legend},codex,help;{datum_legend},letzteAenderung,setHeute;{hinweise_legend:hide},bemerkung;{published_legend},published'
	),

	// Subpalettes
	'subpalettes' => array
	(
		'codex'                       => 'codex_date',
		'help'                        => 'help_date'
	), 

	// Base fields in table tl_trainerlizenzen
	'fields' => array
	(
		'id' => array
		(
			'search'                  => true,
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['tstamp'],
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		// Gibt Warnungen und Hinweise aus
		'verification' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['verification'],
			'input_field_callback'    => array('tl_trainerlizenzen', 'getVerification'),
		),
		// DOSB-Lizenzstring, z.B. DSchB-T-C-0002146
		'license_number_dosb' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['license_number_dosb'],
			'input_field_callback'    => array('tl_trainerlizenzen', 'getLizenznummer'),
			'exclude'                 => false,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 12,
			'filter'                  => false,
			'sql'                     => "varchar(255) NOT NULL default ''",
		),
		// DOSB-Lizenznummer, z.B. 3535 (korreliert mit der obigen Lizenz) 
		'lid' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['lid'],
			'exclude'                 => true,
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		// Unixzeit der letzten Lizenzerstellung/-verlängerung beim DOSB
		'dosb_tstamp' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['dosb_tstamp'],
			'flag'                    => 8,
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		// HTTP-Code der letzten Lizenzerstellung/-verlängerung beim DOSB
		'dosb_code' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['dosb_code'],
			'filter'                  => true,
			'sql'                     => "int(3) unsigned NOT NULL default '0'"
		),
		// Antwort der letzten Lizenzerstellung/-verlängerung beim DOSB
		'dosb_antwort' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['dosb_antwort'],
			'filter'                  => true,
			'sql'                     => "varchar(255) NOT NULL default ''",
		),
		'button_license' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['button_license'],
			'exclude'                 => true,
			'input_field_callback'    => array('tl_trainerlizenzen', 'getLizenzbutton')
		), 
		// PDF-Link Format DIN A4
		'view_pdf' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['view_pdf'],
			'input_field_callback'    => array('tl_trainerlizenzen', 'getLizenzPDFView'),
			'exclude'                 => false,
		),
		// Button zur PDF-Anforderung DIN A4
		'button_pdf' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['button_pdf'],
			'exclude'                 => true,
			'input_field_callback'    => array('tl_trainerlizenzen', 'getLizenzPDF')
		), 
		// Unixzeit des letzten PDF-Abrufs beim DOSB
		'dosb_pdf_tstamp' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['dosb_pdf_tstamp'],
			'flag'                    => 8,
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		// HTTP-Code des letzten PDF-Abrufs beim DOSB
		'dosb_pdf_code' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['dosb_pdf_code'],
			'sql'                     => "int(3) unsigned NOT NULL default '0'"
		),
		// Antwort des letzten PDF-Abrufs beim DOSB
		'dosb_pdf_antwort' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['dosb_pdf_antwort'],
			'sql'                     => "varchar(255) NOT NULL default ''",
		),
		// PDF-Link Format Card
		'view_pdfcard' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['view_pdfcard'],
			'input_field_callback'    => array('tl_trainerlizenzen', 'getLizenzPDFCardView'),
			'exclude'                 => false,
		),
		// Button zur PDF-Anforderung Format Card
		'button_pdfcard' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['button_pdfcard'],
			'exclude'                 => true,
			'input_field_callback'    => array('tl_trainerlizenzen', 'getLizenzPDFCard')
		), 
		// Unixzeit des letzten PDF-Abrufs beim DOSB
		'dosb_pdfcard_tstamp' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['dosb_pdfcard_tstamp'],
			'flag'                    => 8,
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		// HTTP-Code des letzten PDF-Abrufs beim DOSB
		'dosb_pdfcard_code' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['dosb_pdfcard_code'],
			'sql'                     => "int(3) unsigned NOT NULL default '0'"
		),
		// Antwort des letzten PDF-Abrufs beim DOSB
		'dosb_pdfcard_antwort' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['dosb_pdfcard_antwort'],
			'sql'                     => "varchar(255) NOT NULL default ''",
		),
		'marker' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['marker'],
			'inputType'               => 'checkbox',
			'default'                 => true,
			'filter'                  => true,
			'eval'                    => array('tl_class' => 'w50','isBoolean' => true),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		// Vorname
		'vorname' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['vorname'],
			'inputType'               => 'text',
			'exclude'                 => false,
			'search'                  => true,
			'sorting'                 => true,
			'filter'                  => false,
			'sql'                     => "varchar(255) NOT NULL default ''",
			'eval'                    => array
			(
				'mandatory'           => true,
				'tl_class'            => 'w50'
			)
		),
		// Nachname
		'name' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['name'],
			'inputType'               => 'text',
			'exclude'                 => false,
			'search'                  => true,
			'sorting'                 => true,
			'filter'                  => false,
			'sql'                     => "varchar(255) NOT NULL default ''",
			'eval'                    => array
			(
				'mandatory'           => true,
				'tl_class'            => 'w50'
			)
		),
		// Titel
		'titel' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['titel'],
			'inputType'               => 'text',
			'exclude'                 => false,
			'search'                  => true,
			'sorting'                 => true,
			'filter'                  => false,
			'sql'                     => "varchar(10) NOT NULL default ''",
			'eval'                    => array
			(
				'tl_class'            => 'w50'
			)
		),
		// Geburtstag
		'geburtstag' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['geburtstag'],
			'inputType'               => 'text',
			'exclude'                 => false,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 8,
			'filter'                  => true,
			'eval'                    => array
			(
				'mandatory'           => true,
				'rgxp'                => 'date', 
				'datepicker'          => true,
				'tl_class'            => 'w50 wizard clr'
			),
			'sql'                     => "varchar(11) NOT NULL default ''",
		),
		// Geschlecht
		'geschlecht' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['geschlecht'],
			'inputType'               => 'select',
			'exclude'                 => false,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 12,
			'filter'                  => true,
			'sql'                     => "varchar(1) NOT NULL default ''",
			'options'                 => array
			(
				'-'                   => '-',
				'm'                   => 'männlich',
				'w'                   => 'weiblich',
			),
			'eval'                    => array
			(
				'mandatory'           => true,
				'chosen'              => true,
				'tl_class'            => 'w50'
			)
		),
		// Straße
		'strasse' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['strasse'],
			'inputType'               => 'text',
			'exclude'                 => false,
			'search'                  => true,
			'sorting'                 => true,
			'filter'                  => false,
			'explanation'             => 'trainerlizenzen_strasse', 
			'sql'                     => "varchar(255) NOT NULL default ''",
			'eval'                    => array
			(
				'mandatory'           => true,
				'helpwizard'          => true,
				'tl_class'            => 'w50'
			)
		),
		// PLZ
		'plz' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['plz'],
			'inputType'               => 'text',
			'exclude'                 => false,
			'search'                  => true,
			'sorting'                 => true,
			'explanation'             => 'trainerlizenzen_plz', 
			'filter'                  => false,
			'sql'                     => "varchar(32) NOT NULL default ''",
			'eval'                    => array
			(
				'rgxp'                => 'natural',
				'minlength'           => 5,
				'maxlength'           => 5,
				'mandatory'           => true,
				'helpwizard'          => true,
				'tl_class'            => 'w50 clr'
			)
		),
		// Ort
		'ort' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['ort'],
			'inputType'               => 'text',
			'exclude'                 => false,
			'search'                  => true,
			'sorting'                 => true,
			'filter'                  => false,
			'sql'                     => "varchar(255) NOT NULL default ''",
			'explanation'             => 'trainerlizenzen_strasse', 
			'eval'                    => array
			(
				'mandatory'           => true,
				'helpwizard'          => true,
				'tl_class'            => 'w50'
			)
		),
		// Email
		'email' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['email'],
			'inputType'               => 'text',
			'exclude'                 => false,
			'search'                  => true,
			'sorting'                 => true,
			'filter'                  => false,
			'sql'                     => "varchar(255) NOT NULL default ''",
			'eval'                    => array
			(
				'rgxp'                => 'email',
				'tl_class'            => 'w50'
			)
		),
		// Telefon
		'telefon' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['telefon'],
			'inputType'               => 'text',
			'exclude'                 => false,
			'search'                  => true,
			'sorting'                 => true,
			'filter'                  => false,
			'sql'                     => "varchar(255) NOT NULL default ''",
			'eval'                    => array
			(
				'mandatory'           => false,
				'tl_class'            => 'w50'
			)
		),
		// Verband
		'verband' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['verband'],
			'inputType'               => 'select',
			'exclude'                 => false,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'filter'                  => true,
			'sql'                     => "varchar(3) NOT NULL default ''",
			'options'                 => \Samson\Trainerlizenzen\Helper::getVerbaende(),
			'eval'                    => array
			(
				'mandatory'           => true,
				'chosen'              => true,
				'tl_class'            => 'w50'
			)
		),
		// Lizenznummer
		'lizenznummer' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['lizenznummer'],
			'inputType'               => 'text',
			'default'                 => 'B.38',
			'exclude'                 => false,
			'search'                  => true,
			'sorting'                 => true,
			'filter'                  => false,
			'sql'                     => "varchar(255) NOT NULL default ''",
			'eval'                    => array
			(
				'tl_class'            => 'w50',
				'doNotCopy'           => true,
				'mandatory'           => false,
			)
		),
		// Lizenz
		'lizenz' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['lizenz'],
			'inputType'               => 'select',
			'exclude'                 => false,
			'search'                  => true,
			'sorting'                 => true,
			'filter'                  => true,
			'options'                 => \Samson\Trainerlizenzen\Helper::getLizenzen(),
			'eval'                    => array
			(
				'chosen'              => true,
				'tl_class'            => 'w50',
				'doNotCopy'           => true,
				'mandatory'           => true,
			),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		// Datum des Lizenzerwerbs
		'erwerb' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['erwerb'],
			'inputType'               => 'text',
			'exclude'                 => false,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 8,
			'explanation'             => 'trainerlizenzen_erwerb', 
			'filter'                  => true,
			'eval'                    => array
			(
				'rgxp'                => 'date',
				'datepicker'          => true,
				'helpwizard'          => true,
				'tl_class'            => 'w50 wizard',
				'doNotCopy'           => true
			),
			'sql'                     => "varchar(11) NOT NULL default ''"
		),
		// Datum der 1. Lizenzverlängerung
		'verlaengerung1' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['verlaengerung1'],
			'inputType'               => 'text',
			'exclude'                 => false,
			'search'                  => false,
			'sorting'                 => false,
			'flag'                    => 8,
			'filter'                  => false,
			'eval'                    => array
			(
				'rgxp'                => 'date',
				'datepicker'          => true,
				'tl_class'            => 'w50 wizard',
				'doNotCopy'           => true
			),
			'sql'                     => "varchar(11) NOT NULL default ''"
		),
		// Datum der 2. Lizenzverlängerung
		'verlaengerung2' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['verlaengerung2'],
			'inputType'               => 'text',
			'exclude'                 => false,
			'search'                  => false,
			'sorting'                 => false,
			'flag'                    => 8,
			'filter'                  => false,
			'eval'                    => array
			(
				'rgxp'                => 'date',
				'datepicker'          => true,
				'tl_class'            => 'w50 wizard',
				'doNotCopy'           => true
			),
			'sql'                     => "varchar(11) NOT NULL default ''"
		),
		// Datum der 3. Lizenzverlängerung
		'verlaengerung3' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['verlaengerung3'],
			'inputType'               => 'text',
			'exclude'                 => false,
			'search'                  => false,
			'sorting'                 => false,
			'flag'                    => 8,
			'filter'                  => false,
			'eval'                    => array
			(
				'rgxp'                => 'date',
				'datepicker'          => true,
				'tl_class'            => 'w50 wizard',
				'doNotCopy'           => true
			),
			'sql'                     => "varchar(11) NOT NULL default ''"
		),
		// Datum der 4. Lizenzverlängerung
		'verlaengerung4' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['verlaengerung4'],
			'inputType'               => 'text',
			'exclude'                 => false,
			'search'                  => false,
			'sorting'                 => false,
			'flag'                    => 8,
			'filter'                  => false,
			'eval'                    => array
			(
				'rgxp'                => 'date',
				'datepicker'          => true,
				'tl_class'            => 'w50 wizard',
				'doNotCopy'           => true
			),
			'sql'                     => "varchar(11) NOT NULL default ''"
		),
		// Datum der 5. Lizenzverlängerung
		'verlaengerung5' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['verlaengerung5'],
			'inputType'               => 'text',
			'exclude'                 => false,
			'search'                  => false,
			'sorting'                 => false,
			'flag'                    => 8,
			'filter'                  => false,
			'eval'                    => array
			(
				'rgxp'                => 'date',
				'datepicker'          => true,
				'tl_class'            => 'w50 wizard',
				'doNotCopy'           => true
			),
			'sql'                     => "varchar(11) NOT NULL default ''"
		),
		// Datum der 6. Lizenzverlängerung
		'verlaengerung6' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['verlaengerung6'],
			'inputType'               => 'text',
			'exclude'                 => false,
			'search'                  => false,
			'sorting'                 => false,
			'flag'                    => 8,
			'filter'                  => false,
			'eval'                    => array
			(
				'rgxp'                => 'date',
				'datepicker'          => true,
				'tl_class'            => 'w50 wizard',
				'doNotCopy'           => true
			),
			'sql'                     => "varchar(11) NOT NULL default ''"
		),
		// Datum der 7. Lizenzverlängerung
		'verlaengerung7' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['verlaengerung7'],
			'inputType'               => 'text',
			'exclude'                 => false,
			'search'                  => false,
			'sorting'                 => false,
			'flag'                    => 8,
			'filter'                  => false,
			'eval'                    => array
			(
				'rgxp'                => 'date',
				'datepicker'          => true,
				'tl_class'            => 'w50 wizard',
				'doNotCopy'           => true
			),
			'sql'                     => "varchar(11) NOT NULL default ''"
		),
		// Datum der 8. Lizenzverlängerung
		'verlaengerung8' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['verlaengerung8'],
			'inputType'               => 'text',
			'exclude'                 => false,
			'search'                  => false,
			'sorting'                 => false,
			'flag'                    => 8,
			'filter'                  => false,
			'eval'                    => array
			(
				'rgxp'                => 'date',
				'datepicker'          => true,
				'tl_class'            => 'w50 wizard',
				'doNotCopy'           => true
			),
			'sql'                     => "varchar(11) NOT NULL default ''"
		),
		'verlaengerungen' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['verlaengerungen'],
			'exclude'                 => true,
			'search'                  => false,
			'inputType'               => 'multiColumnWizard',
			'eval'                    => array
			(
				'tl_class'            => 'clr',
				'columnFields'        => array
				(
					'datum' => array
					(
						'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['verlaengerung_datum'],
						'exclude'                 => true,
						'inputType'               => 'text',
						'eval'                    => array
						(
							'tl_class'            => 'w50 wizard',
							'rgxp'                => 'date',
							'datepicker'          => true,
							'maxlength'           => 10
						),
					),
				)
			),
			'sql'                     => "blob NULL"
		),
		// Datum der Lizenzgültigkeit
		'gueltigkeit' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['gueltigkeit'],
			'inputType'               => 'text',
			'exclude'                 => false,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 8,
			'filter'                  => true,
			'eval'                    => array
			(
				'rgxp'                => 'date',
				'datepicker'          => true,
				'tl_class'            => 'w50 wizard',
				'doNotCopy'           => true
			),
			'sql'                     => "varchar(11) NOT NULL default ''"
		),
		// Ehrencodex anerkannt
		'codex' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['codex'],
			'inputType'               => 'checkbox',
			'default'                 => true,
			'explanation'             => 'trainerlizenzen_kodex', 
			'filter'                  => true,
			'eval'                    => array
			(
				'mandatory'           => false,
				'tl_class'            => 'w50',
				'helpwizard'          => true,
				'isBoolean'           => true,
				'submitOnChange'      => true
			),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		// Datum Ehrencodex
		'codex_date' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['codex_date'],
			'inputType'               => 'text',
			'exclude'                 => false,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 8,
			'filter'                  => true,
			'eval'                    => array
			(
				'rgxp'                => 'date',
				'datepicker'          => true,
				'tl_class'            => 'w50 wizard',
				'doNotCopy'           => true
			),
			'sql'                     => "varchar(11) NOT NULL default ''"
		),
		// Erste-Hilfe-Ausbildung absolviert
		'help' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['help'],
			'inputType'               => 'checkbox',
			'default'                 => true,
			'filter'                  => true,
			'explanation'             => 'trainerlizenzen_kodex', 
			'eval'                    => array
			(
				'mandatory'           => false,
				'tl_class'            => 'w50 clr',
				'helpwizard'          => true,
				'isBoolean'           => true,
				'submitOnChange'      => true
			),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		// Datum der Erste-Hilfe-Ausbildung
		'help_date' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['help_date'],
			'inputType'               => 'text',
			'exclude'                 => false,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 8,
			'filter'                  => true,
			'eval'                    => array
			(
				'rgxp'                => 'date',
				'datepicker'          => true,
				'tl_class'            => 'w50 wizard',
				'doNotCopy'           => true
			),
			'sql'                     => "varchar(11) NOT NULL default ''"
		),
		// Datum der letzten Änderung
		'letzteAenderung' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['letzteAenderung'],
			'inputType'               => 'text',
			'exclude'                 => false,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 8,
			'filter'                  => true,
			'eval'                    => array
			(
				'rgxp'                => 'date',
				'datepicker'          => true,
				'tl_class'            => 'w50 wizard',
				'doNotCopy'           => true
			),
			'sql'                     => "varchar(11) NOT NULL default ''"
		),
		// Heutiges Datum bei letzteAenderung setzen
		'setHeute' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['setHeute'],
			'exclude'                 => true,
			'input_field_callback'    => array('tl_trainerlizenzen', 'setHeute')
		), 
		'bemerkung' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['bemerkung'],
			'inputType'               => 'textarea',
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => false,
			'filter'                  => false,
			'eval'                    => array('rte' => 'tinyMCE', 'cols' => 80,'rows' => 5, 'style' => 'height: 80px'),
			'sql'                     => "text NULL"
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen']['published'],
			'inputType'               => 'checkbox',
			'default'                 => true,
			'filter'                  => true,
			'eval'                    => array('tl_class' => 'w50','isBoolean' => true),
			'sql'                     => "char(1) NOT NULL default ''"
		),
	),
);

class tl_trainerlizenzen extends \Backend
{
	
	var $verbandsmail = array();

	public function toggleEmail($row, $href, $label, $title, $icon, $attributes)
	{
		$this->import('BackendUser', 'User');

		$href .= '&amp;table=tl_trainerlizenzen_mails&amp;id='.$row['id'];

		if($row['email'] && $this->verbandsmail[$row['verband']])
		{
			$icon = 'system/modules/trainerlizenzen/assets/images/email.png';
		}
		elseif($row['email'] || $this->verbandsmail[$row['verband']])
		{
			$icon = 'system/modules/trainerlizenzen/assets/images/email_gelb.png';
		}
		else
		{
			$icon = 'system/modules/trainerlizenzen/assets/images/email_grau.png';
		}

		return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
	}

	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{
		$this->import('BackendUser', 'User');

		if (strlen($this->Input->get('tid')))
		{
			$this->toggleVisibility($this->Input->get('tid'), ($this->Input->get('state') == 0));
			$this->redirect($this->getReferer());
		}

		// Check permissions AFTER checking the tid, so hacking attempts are logged
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_trainerlizenzen::published', 'alexf'))
		{
			return '';
		}

		$href .= '&amp;id='.$this->Input->get('id').'&amp;tid='.$row['id'].'&amp;state='.$row[''];

		if (!$row['published'])
		{
			$icon = 'invisible.gif';
		}

		return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
	}

	public function toggleVisibility($intId, $blnPublished)
	{
		// Check permissions to publish
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_trainerlizenzen::published', 'alexf'))
		{
			$this->log('Kein Zugriffsrecht für Aktivierung Datensatz ID "'.$intId.'"', 'tl_trainerlizenzen toggleVisibility', TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}
		
		$this->createInitialVersion('tl_trainerlizenzen', $intId);
		
		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_trainerlizenzen']['fields']['published']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_trainerlizenzen']['fields']['published']['save_callback'] as $callback)
			{
				$this->import($callback[0]);
				$blnPublished = $this->$callback[0]->$callback[1]($blnPublished, $this);
			}
		}
		
		// Update the database
		$this->Database->prepare("UPDATE tl_trainerlizenzen SET tstamp=". time() .", published='" . ($blnPublished ? '' : '1') . "' WHERE id=?")
					   ->execute($intId);
		$this->createNewVersion('tl_trainerlizenzen', $intId);
	}

	/**
	 * Add an image to each record
	 * @param array         $row (Assoziatives Array mit allen Werten des aktuellen Datensatzes)
	 * @param string        $label (Wert des erstes sichtbaren Wertes des aktuellen Datensatzes)
	 * @param DataContainer $dc
	 * @param array         $args (Numerisches Array mit den sichtbaren Werten des aktuellen Datensatzes)
	 *
	 * @return array
	 */
	public function convertDate($row, $label, DataContainer $dc, $args)
	{

		for($x=0;$x<count($args);$x++)
		{
			$args[$x] = \Samson\Helper::getDate($args[$x]);
		}
		return $args; 
	} 

	public function getLizenznummer(DataContainer $dc)
	{

		// Lizenzstatus
		if($dc->activeRecord->license_number_dosb)
		{
			$status = '<b>'.$dc->activeRecord->license_number_dosb.'</b> <a href="'.LIMS_LINK.'dosb_license/'.$dc->activeRecord->lid.'" target="_blank" class="dosb_button_mini">Ansehen</a>';
		}
		else
		{
			$status = 'Keine DOSB-Lizenz vorhanden';
		}
		
		$string = '
<div class="w50" style="height:40px;">
	<h3><label>&nbsp;</label></h3>
	'.$status.'
</div>'; 
		
		return $string;
	}

	public function getLizenzbutton(DataContainer $dc)
	{
		$link = 'contao/main.php?do=trainerlizenzen&amp;key=getLizenz&amp;id=' . $dc->activeRecord->id . '&amp;rt=' . REQUEST_TOKEN;

		// Letzter Lizenzabruf und Rückgabecode
		if($dc->activeRecord->dosb_tstamp)
		{
			$antwort = 'Letzter Abruf: '.date('d.m.Y H:i:s', $dc->activeRecord->dosb_tstamp).' ('.$dc->activeRecord->dosb_code.' '.$dc->activeRecord->dosb_antwort.')';
		}
		else $antwort = '';
		
		$string = '
<div class="w50" style="height:40px;">
	<h3><label>&nbsp;</label></h3>
	<a href="'.$link.'" class="dosb_button">'.$GLOBALS['TL_LANG']['tl_trainerlizenzen']['button_license'][0].'</a>
	<p class="tl_help tl_tip" title="">'.$antwort.'</p>
</div>'; 
		
		return $string;
	}
	
	public function getLizenzPDFView(DataContainer $dc)
	{
		// Lizenzstatus
		if($dc->activeRecord->license_number_dosb && file_exists(TL_ROOT.'/files/trainerlizenzen/'.$dc->activeRecord->license_number_dosb.'.pdf'))
		{
			$status = '<a href="files/trainerlizenzen/'.$dc->activeRecord->license_number_dosb.'.pdf" target="_blank" title="Zeigt die auf dem DSB-Server gespeicherte Lizenzurkunde an." class="dosb_button_mini">PDF DIN A4 anzeigen</a>';
			//$email = '&nbsp;<a href="" title="Verschickt die Lizenzurkunde mit der Standard-Mailvorlage an den Trainer, den Landesverband und den DSB" class="dosb_button_mini">PDF verschicken</a>';
			$email = '';
		}
		else
		{
			$status = 'Kein PDF DIN A4 vorhanden';
			$email = '';
		}
		
		if($dc->activeRecord->license_number_dosb)
		{
		$string = '
<div class="w50" style="height:40px;">
	<h3><label>&nbsp;</label></h3>
	'.$status.$email.'
</div> '; 
			return $string;
		}
		else return '';
	}

	public function getLizenzPDF(DataContainer $dc)
	{

		$link = 'contao/main.php?do=trainerlizenzen&amp;key=getLizenzPDF&amp;id=' . $dc->activeRecord->id . '&amp;rt=' . REQUEST_TOKEN;

		// Letzter Lizenzabruf und Rückgabecode
		if($dc->activeRecord->dosb_pdf_tstamp)
		{
			$antwort = 'Letzter Abruf: '.date('d.m.Y H:i:s', $dc->activeRecord->dosb_pdf_tstamp).' ('.$dc->activeRecord->dosb_pdf_code.' '.$dc->activeRecord->dosb_pdf_antwort.')';
		}
		else $antwort = '';

		if($dc->activeRecord->license_number_dosb)
		{
		$string = '
<div class="w50" style="height:40px;">
	<h3><label>&nbsp;</label></h3>
	<a href="'.$link.'" class="dosb_button">'.$GLOBALS['TL_LANG']['tl_trainerlizenzen']['button_pdf'][0].'</a>
	<p class="tl_help tl_tip" title="">'.$antwort.'</p>
</div>'; 
			return $string;
		}
		else return '';
			
	}

	public function getLizenzPDFCardView(DataContainer $dc)
	{
		// Lizenzstatus
		if($dc->activeRecord->license_number_dosb && file_exists(TL_ROOT.'/files/trainerlizenzen/'.$dc->activeRecord->license_number_dosb.'-card.pdf'))
		{
			$status = '<a href="files/trainerlizenzen/'.$dc->activeRecord->license_number_dosb.'-card.pdf" target="_blank" title="Zeigt die auf dem DSB-Server gespeicherte Lizenzurkunde im Format Card an." class="dosb_button_mini">PDF Karte anzeigen</a>';
			//$email = '&nbsp;<a href="" title="Verschickt die Lizenzurkunde mit der Standard-Mailvorlage an den Trainer, den Landesverband und den DSB" class="dosb_button_mini">PDF verschicken</a>';
			$email = '';
		}
		else
		{
			$status = 'Kein PDF Card vorhanden';
			$email = '';
		}
		
		if($dc->activeRecord->license_number_dosb)
		{
		$string = '
<div class="w50" style="height:40px;">
	<h3><label>&nbsp;</label></h3>
	'.$status.$email.'
</div> '; 
			return $string;
		}
		else return '';
	}

	public function getLizenzPDFCard(DataContainer $dc)
	{

		$link = 'contao/main.php?do=trainerlizenzen&amp;key=getLizenzPDFCard&amp;id=' . $dc->activeRecord->id . '&amp;rt=' . REQUEST_TOKEN;

		// Letzter Lizenzabruf und Rückgabecode
		if($dc->activeRecord->dosb_pdf_tstamp)
		{
			$antwort = 'Letzter Abruf: '.date('d.m.Y H:i:s', $dc->activeRecord->dosb_pdfcard_tstamp).' ('.$dc->activeRecord->dosb_pdfcard_code.' '.$dc->activeRecord->dosb_pdfcard_antwort.')';
		}
		else $antwort = '';

		if($dc->activeRecord->license_number_dosb)
		{
		$string = '
<div class="w50" style="height:40px;">
	<h3><label>&nbsp;</label></h3>
	<a href="'.$link.'" class="dosb_button">'.$GLOBALS['TL_LANG']['tl_trainerlizenzen']['button_pdfcard'][0].'</a>
	<p class="tl_help tl_tip" title="">'.$antwort.'</p>
</div>'; 
			return $string;
		}
		else return '';
			
	}


	/**
	 * Setzt das aktuelle Datum beim Änderungsdatum
	 * (Noch nicht weitergebaut, deshalb display:none; Unklar wwas aufgerufen werden soll und wie man das Feld per Button ändert.)
	 * @param DataContainer $dc
	 *
	 * @return array
	 */
	public function setHeute(DataContainer $dc)
	{
		$link = 'contao/main.php?do=trainerlizenzen&amp;key=getLizenz&amp;id=' . $dc->activeRecord->id . '&amp;rt=' . REQUEST_TOKEN;

		// Letzter Lizenzabruf und Rückgabecode
		if($dc->activeRecord->dosb_tstamp)
		{
			$antwort = 'Letzter Abruf: '.date('d.m.Y H:i:s', $dc->activeRecord->dosb_tstamp).' ('.$dc->activeRecord->dosb_code.' '.$dc->activeRecord->dosb_antwort.')';
		}
		else $antwort = '';
		
		$string = '
<div class="w50" style="display:none">
	<h3><label>&nbsp;</label></h3>
	<a href="#" onclick="AjaxRequest.toggleSubpalette(this, \'sub_login\', \'login\')" onfocus="Backend.getScrollOffset()" class="dosb_button_mini">'.$GLOBALS['TL_LANG']['tl_trainerlizenzen']['setHeute'][0].'</a>
	<p class="tl_help tl_tip" title="">'.$GLOBALS['TL_LANG']['tl_trainerlizenzen']['setHeute'][1].'</p>
</div>'; 
		
		return $string;
	}
	
	public function getVerification(DataContainer $dc)
	{

		// ----------------------------------------------------------------
		// GÜLTIGKEIT DER LIZENZ
		// ----------------------------------------------------------------
		// Letztes Verlängerungsdatum ermitteln
		$verlaengerung = \Samson\Trainerlizenzen\Helper::getVerlaengerung($dc->activeRecord->erwerb, $dc->activeRecord->verlaengerungen);

		// Zulässiges Gültigkeitsdatum feststellen
		switch(substr($dc->activeRecord->lizenz,0,1))
		{
			case 'A': // 2 Jahre ab Ausstellungsdatum - 1 Tag
				//echo "|$verlaengerung|";
				$gueltigkeit = strtotime('+2 years', $verlaengerung) - 86400;
				$gueltigkeit = $this->getQuartalsende($gueltigkeit);
				break;
			case 'B': // 4 Jahre ab Ausstellungsdatum - 1 Tag
			case 'C':
				$gueltigkeit = strtotime('+4 years', $verlaengerung) - 86400;
				$gueltigkeit = $this->getQuartalsende($gueltigkeit);
				break;
			default:
				$gueltigkeit = 0;
		}

		// Gültigkeitsdatum überprüfen
		if($dc->activeRecord->license_number_dosb)
		{
			// Gültigkeitsregeln des DOSB gelten
			if($dc->activeRecord->gueltigkeit > $gueltigkeit)
			{
				Message::addError('Gültig bis ('.date('d.m.Y', $dc->activeRecord->gueltigkeit).') ist größer als erlaubt. Der DOSB erlaubt nur den '.date('d.m.Y', $gueltigkeit).'!'); 
			}
		}
		else
		{
			// Kulanzregelung DOSB für Bestandsdaten
			if($dc->activeRecord->gueltigkeit > $gueltigkeit)
			{
				Message::addInfo('Gültig bis ('.date('d.m.Y', $dc->activeRecord->gueltigkeit).') ist größer als erlaubt. Der DOSB erlaubt nur den '.date('d.m.Y', $gueltigkeit).'! Es wird Probleme bei Updates geben.'); 
			}
		}
		
		// ----------------------------------------------------------------
		// E-MAIL
		// ----------------------------------------------------------------
		if(!$dc->activeRecord->email && $dc->activeRecord->tstamp)
		{
			// Fehlende E-Mail-Adresse bei nicht neuem Datensatz
			Message::addError('E-Mail-Adresse des Trainers fehlt! Ein automatischer Lizenzversand an ihn ist nicht möglich.'); 
		}

		return '';

	}


	/**
	 * Ermittelt das Quartalsende als Timestamp für einen beliebigen Zeitstempel
	 * @param timestamp     $value (beliebiger Zeitstempel)
	 *
	 * @return timestamp
	 */
	public function getQuartalsende($value)
	{
		$quartals = array
		(
			 1 => 1,
			 2 => 1,
			 3 => 1,
			 4 => 2,
			 5 => 2,
			 6 => 2,
			 7 => 3,
			 8 => 3,
			 9 => 3,
			10 => 4,
			11 => 4,
			12 => 4
		); 

		$year = date('Y', $value);
		$quartal = $quartals[date("n", $value)]; // n = Monat 1-12

		//log_message(date('d.m.Y', $value), 'trainerlizenzen_quartal.log');
		//log_message($quartal, 'trainerlizenzen_quartal.log');
		
		switch($quartal)
		{
			case 1:
				return mktime(0, 0, 0, 3, 31, $year);
			case 2:
				return mktime(0, 0, 0, 6, 30, $year);
			case 3:
				return mktime(0, 0, 0, 9, 30, $year);
			case 4:
				return mktime(0, 0, 0, 12, 31, $year);
			default:
				return 0;
		}
	}


	public function getDate($value)
	{
		return mktime(0, 0, 0, substr($value, 4, 2), substr($value, 6, 2), substr($value, 0, 4));
	}

    public function generateAdvancedFilter(DataContainer $dc)
    {
    
        if (\Input::get('id') > 0) {
            return '';
        }

        $session = \Session::getInstance()->getData();

        // Filters
        $arrFilters = array
        (
            'tli_filter'   => array
            (
                'name'    => 'tli_filter',
                'label'   => $GLOBALS['TL_LANG']['tl_trainerlizenzen']['filter_extended'],
                'options' => array
				(
					'1' => $GLOBALS['TL_LANG']['tl_trainerlizenzen']['filter_activetrainers'], 
					'2' => $GLOBALS['TL_LANG']['tl_trainerlizenzen']['filter_unsentmails'], 
				)
            ),
        );

        $strBuffer = '
<div class="tl_filter tli_filter tl_subpanel">
<strong>' . $GLOBALS['TL_LANG']['tl_trainerlizenzen']['filter'] . ':</strong> ' . "\n";

        // Generate filters
        foreach ($arrFilters as $arrFilter) 
        {
            $strOptions = '
  <option value="' . $arrFilter['name'] . '">' . $arrFilter['label'] . '</option>
  <option value="' . $arrFilter['name'] . '">---</option>' . "\n";

            // Generate options
            foreach ($arrFilter['options'] as $k => $v) 
            {
                $strOptions .= '  <option value="' . $k . '"' . (($session['filter']['tl_registerFilter'][$arrFilter['name']] === (string) $k) ? ' selected' : '') . '>' . $v . '</option>' . "\n";
            }

            $strBuffer .= '<select name="' . $arrFilter['name'] . '" id="' . $arrFilter['name'] . '" class="tl_select' . (isset($session['filter']['tl_registerFilter'][$arrFilter['name']]) ? ' active' : '') . '">
' . $strOptions . '
</select>' . "\n";
        }

        return $strBuffer . '</div>'; 

    }  
	
    public function applyAdvancedFilter()
    {
    
        $session = \Session::getInstance()->getData();

        // Store filter values in the session
        foreach ($_POST as $k => $v) 
        {
            if (substr($k, 0, 4) != 'tli_') 
            {
                continue;
            }

            // Reset the filter
            if ($k == \Input::post($k)) 
            {
                unset($session['filter']['tl_registerFilter'][$k]);
            } // Apply the filter
            else {
                $session['filter']['tl_registerFilter'][$k] = \Input::post($k);
            }
        }

        $this->Session->setData($session);

        if (\Input::get('id') > 0 || !isset($session['filter']['tl_registerFilter'])) 
        {
            return;
        }

        $arrPlayers = null;


		switch ($session['filter']['tl_registerFilter']['tli_filter']) 
		{
			case '1': // Alle Trainer mit noch gültigen Lizenzen
				$objPlayers = \Database::getInstance()->prepare("SELECT id FROM tl_trainerlizenzen WHERE gueltigkeit >= ? AND published = ?")
													  ->execute(time(), 1);
				$arrPlayers = is_array($arrPlayers) ? array_intersect($arrPlayers, $objPlayers->fetchEach('id')) : $objPlayers->fetchEach('id');
				break;
			case '2': // Alle Trainer mit noch ungesendeten E-Mails
				$objPlayers = \Database::getInstance()->prepare("SELECT pid FROM tl_trainerlizenzen_mails WHERE sent_state = ? AND published = ?")
													  ->execute('', 1);
				$arrPlayers = is_array($arrPlayers) ? array_intersect($arrPlayers, $objPlayers->fetchEach('pid')) : $objPlayers->fetchEach('pid');
				break;

			default:
		}

		if (is_array($arrPlayers) && empty($arrPlayers)) 
		{
			$arrPlayers = array(0);
		}

		$log = print_r($arrPlayers, true);
		log_message($log, 'trainerlizenzen.log');

		$GLOBALS['TL_DCA']['tl_trainerlizenzen']['list']['sorting']['root'] = $arrPlayers; 

	}

	/**
	 * Funktion getVerbandsmails
	 * =========================
	 * Liest die Mailadressen der Verbände ein
	 */
	public function getVerbandsmails()
	{
		// Datensatz einlesen
		$result = \Database::getInstance()->prepare("SELECT * FROM tl_trainerlizenzen_referenten WHERE published = ?")
										  ->execute(1);

		// Auswerten
		if($result->numRows)
		{
			while($result->next()) 
			{
				$this->verbandsmail[$result->verband] = $result->email;
			}
		}

	}

	/**
	 * Funktion getNo
	 * ==============
	 * Konvertiert den Feldwert 0 auf ''
	 */
	public function getNo($varValue)
	{

		switch($varValue)
		{
			case '0':
				return '';
			default:
				return $varValue;
		}

	}

	/**
	 * Funktion setNo
	 * ==============
	 * Setzt den Feldwert auf 0 oder 1
	 */
	public function setNo($varValue)
	{

		switch($varValue)
		{
			case '1':
				return $varValue;
			default:
				return '0';
		}

	}

}