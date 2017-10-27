<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Table tl_trainerlizenzen_mails
 */
$GLOBALS['TL_DCA']['tl_trainerlizenzen_mails'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_trainerlizenzen',
		'enableVersioning'            => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'pid' => 'index'
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 4,
			'fields'                  => array('sent_state ASC', 'sent_date DESC'),
			'headerFields'            => array('name', 'vorname', 'geburtstag', 'lizenz', 'gueltigkeit', 'verband'),
			'panelLayout'             => 'filter;sort,search,limit',
			'child_record_callback'   => array('tl_trainerlizenzen_mails', 'listEmails') 
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_trainerlizenzen_mails']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_trainerlizenzen_mails']['copy'],
				'href'                => 'act=paste&amp;mode=copy',
				'icon'                => 'copy.gif'
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_trainerlizenzen_mails']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_trainerlizenzen_mails']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_trainerlizenzen_mails']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			),
			'send' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_trainerlizenzen_mails']['send'],
				'href'                => 'key=send',
				'icon'                => 'system/modules/trainerlizenzen/assets/images/email_senden.png'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => '{text_legend},subject,content;{template_legend},template,preview;{mail_legend},insertLizenz,insertLizenzCard,copyVerband,copyDSB,send'
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array
		(
			'foreignKey'              => 'tl_trainerlizenzen.id',
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
		),
		'tstamp' => array
		(
			'flag'                    => 11,
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'template' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen_mails']['template'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'default'                 => 'mail_trainerlizenzen_blanko',
			'options_callback'        => array('tl_trainerlizenzen_mails', 'getTemplates'),
			'eval'                    => array
			(
				'tl_class'            => 'w50',
				'submitOnChange'      => true
			),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),  
		'preview' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen_mails']['preview'],
			'input_field_callback'    => array('tl_trainerlizenzen_mails', 'getPreview'),
			'exclude'                 => false,
		),
		'subject' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen_mails']['subject'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'default'                 => 'Übersendung der Trainerlizenzen',
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'decodeEntities'=>true, 'maxlength'=>128, 'tl_class'=>'long clr'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'content' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen_mails']['content'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array
			(
				'rte'                 => 'tinyMCE', 
				'helpwizard'          => true,
				'tl_class'            => 'long clr',
			),
			'explanation'             => 'insertTags',
			'sql'                     => "mediumtext NULL"
		),
		'insertLizenz' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen_mails']['insertLizenz'],
			'inputType'               => 'checkbox',
			'default'                 => true,
			'exclude'                 => true,
			'eval'                    => array
			(
				'tl_class'            => 'w50',
				'isBoolean'           => false
			),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'insertLizenzCard' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen_mails']['insertLizenzCard'],
			'inputType'               => 'checkbox',
			'default'                 => true,
			'exclude'                 => true,
			'eval'                    => array
			(
				'tl_class'            => 'w50',
				'isBoolean'           => false
			),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'copyVerband' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen_mails']['copyVerband'],
			'inputType'               => 'checkbox',
			'default'                 => true,
			'exclude'                 => true,
			'eval'                    => array
			(
				'tl_class'            => 'w50 clr',
				'isBoolean'           => false
			),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'copyDSB' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen_mails']['copyDSB'],
			'inputType'               => 'checkbox',
			'default'                 => true,
			'exclude'                 => true,
			'eval'                    => array
			(
				'tl_class'            => 'w50',
				'isBoolean'           => false
			),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'sent_state' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen_mails']['sent_state'],
			'eval'                    => array
			(
				'doNotCopy'           => true,
				'isBoolean'           => true,
			),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'sent_date' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen_mails']['sent_date'],
			'flag'                    => 7,
			'eval'                    => array
			(
				'rgxp'                => 'date',
				'doNotCopy'           => true,
			),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'sent_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_trainerlizenzen_mails']['sent_text'],
			'eval'                    => array
			(
				'doNotCopy'           => true,
			),
			'sql'                     => "mediumtext NULL"
		),
	)
);


/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class tl_trainerlizenzen_mails extends Backend
{

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}


	/**
	 * List records
	 *
	 * @param array $arrRow
	 *
	 * @return string
	 */
	public function listEmails($arrRow)
	{
		$objTemplate = new \BackendTemplate($arrRow['template']);
		// Trainer-Datensatz einlesen
		$result = \Database::getInstance()->prepare("SELECT * FROM tl_trainerlizenzen WHERE id = ?")
										  ->execute($arrRow['pid']);
		$objTemplate->setData($result->row()); // Trainer-Daten in Template-Objekt eintragen
		$objTemplate->subject = $arrRow['subject'];
		$objTemplate->content = $arrRow['content'];
		$arrRow['sent_text'] ? $content = $arrRow['sent_text'] : $content = $objTemplate->parse();

		return '
<div class="cte_type ' . (($arrRow['sent_state'] && $arrRow['sent_date']) ? 'published' : 'unpublished') . '"><strong>' . $arrRow['subject'] . '</strong> - ' . (($arrRow['sent_state'] && $arrRow['sent_date']) ? 'Versendet am '.Date::parse(Config::get('datimFormat'), $arrRow['sent_date']) : 'Nicht versendet'). '</div>
<div class="limit_height' . (!Config::get('doNotCollapse') ? ' h128' : '') . '">' . (!$arrRow['sendText'] ? '
' . StringUtil::insertTagToSrc($content) . '<hr>' : '' ) . '
</div>' . "\n"; 

	}


	public function getTemplates($dc)
	{
		return $this->getTemplateGroup('mail_trainerlizenzen_', $dc->activeRecord->id);
	}  

	public function getPreview($dc)
	{
		// Lizenzstatus
		if($dc->activeRecord->template)
		{
			$objTemplate = new \BackendTemplate($dc->activeRecord->template);
			// Trainer-Datensatz einlesen
			$result = \Database::getInstance()->prepare("SELECT * FROM tl_trainerlizenzen WHERE id = ?")
											  ->execute($dc->activeRecord->pid);
			$objTemplate->setData($result->row()); // Trainer-Daten in Template-Objekt eintragen
			$objTemplate->subject = $dc->activeRecord->subject;
			$objTemplate->content = $dc->activeRecord->content;
			preg_match('/<body>(.*)<\/body>/s', $objTemplate->parse(), $matches); // Body extrahieren
			$content = \StringUtil::restoreBasicEntities($matches[1]); // [nbsp] und Co. ersetzen
			$content = '<div class="tl_preview">'.$content.'</div>';
		}
		else
		{
			$content = 'Keine Vorlage ausgewählt';
		}
		
		$string = '
<div class="long clr">
	<h3><label>'.$GLOBALS['TL_LANG']['tl_trainerlizenzen_mails']['preview'][0].'</label></h3>
	'.$content.'
</div>'; 
		
		return $string;
	}  

}
