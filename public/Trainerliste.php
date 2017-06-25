<?php

/**
 * Contao Open Source CMS, Copyright (C) 2005-2016 Leo Feyer
 *
 * Trainerliste
 * ============
 * Verschickt an alle Referenten einer Liste der Trainer im Excelformat
 *
 * @copyright	Frank Hoppe 2016 <webmaster@schachbund.de>
 * @author      Frank Hoppe
 * @package     Banner
 * @license     LGPL
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */
use Contao\Controller;

/**
 * Initialize the system
 */
define('TL_MODE', 'FE');
// ER2 / ER3 (dev over symlink)
if(file_exists('../../../initialize.php')) require('../../../initialize.php');
else require('../../../../../system/initialize.php');


/**
 * Class Trainerliste
 *
 * @copyright  Frank Hoppe 2016
 * @author     Frank Hoppe
 * @package    trainerlizenzen
 */
class Trainerliste 
{
	public function run()
	{

		// Excel-Export
		if (file_exists(TL_ROOT . "/system/modules/xls_export/vendor/xls_export.php")) 
		{
			include(TL_ROOT . "/system/modules/xls_export/vendor/xls_export.php");
		}
		else die('/system/modules/xls_export/vendor/xls_export.php nicht gefunden!');
		
		$verbaende = \Samson\Trainerlizenzen\Helper::getVerbaende();
		
		// Referenten laden, die informiert werden wollen
		$objReferenten = \Database::getInstance()->prepare("SELECT * FROM tl_trainerlizenzen_referenten WHERE sent_info = ? AND published = ? AND email != ?")
		                                         ->execute(1, 1, '');
		if($objReferenten->numRows) 
		{
			while($objReferenten->next())
			{
				// Quartal des letzten Versandes ermitteln
				$QuartalLast = floor(date("m", $objReferenten->sent_date) / 3);
				$QuartalNow = floor(date("m") / 3);

				if($QuartalLast != $QuartalNow || $objReferenten->sent_date == 0)
				{
					// Lizenzen des Verbandes laden
					$objLizenzen = \Database::getInstance()->prepare("SELECT * FROM tl_trainerlizenzen WHERE verband = ? AND published = ? ORDER BY name,vorname ASC")
					                                       ->execute($objReferenten->verband, 1);

					if($objLizenzen->numRows) 
					{
						$xls = new \xlsexport();
						$sheet = 'Trainerlizenzen';
						$xls->addworksheet($sheet);
						// Daten in Exceldatei schreiben
						$row = 0;
						$xls->setcolwidth($sheet,0,4000); $xls->setcell(array('col' => 0, 'data' => 'Nachname', 'sheetname' => $sheet, 'row' => $row, 'fontweight' => XLSFONT_BOLD, 'hallign' => XLSXF_HALLIGN_CENTER));
						$xls->setcolwidth($sheet,1,4000); $xls->setcell(array('col' => 1, 'data' => 'Vorname', 'sheetname' => $sheet, 'row' => $row, 'fontweight' => XLSFONT_BOLD, 'hallign' => XLSXF_HALLIGN_CENTER));
						$xls->setcolwidth($sheet,2,2000); $xls->setcell(array('col' => 2, 'data' => 'Titel', 'sheetname' => $sheet, 'row' => $row, 'fontweight' => XLSFONT_BOLD, 'hallign' => XLSXF_HALLIGN_CENTER));
						$xls->setcolwidth($sheet,3,3000); $xls->setcell(array('col' => 3, 'data' => 'Geburtstag', 'sheetname' => $sheet, 'row' => $row, 'fontweight' => XLSFONT_BOLD, 'hallign' => XLSXF_HALLIGN_CENTER));
						$xls->setcolwidth($sheet,4,2000); $xls->setcell(array('col' => 4, 'data' => 'PLZ', 'sheetname' => $sheet, 'row' => $row, 'fontweight' => XLSFONT_BOLD, 'hallign' => XLSXF_HALLIGN_CENTER));
						$xls->setcolwidth($sheet,5,4000); $xls->setcell(array('col' => 5, 'data' => 'Ort', 'sheetname' => $sheet, 'row' => $row, 'fontweight' => XLSFONT_BOLD, 'hallign' => XLSXF_HALLIGN_CENTER));
						$xls->setcolwidth($sheet,6,6000); $xls->setcell(array('col' => 6, 'data' => 'Strasse', 'sheetname' => $sheet, 'row' => $row, 'fontweight' => XLSFONT_BOLD, 'hallign' => XLSXF_HALLIGN_CENTER));
						$xls->setcolwidth($sheet,7,4000); $xls->setcell(array('col' => 7, 'data' => 'Telefon', 'sheetname' => $sheet, 'row' => $row, 'fontweight' => XLSFONT_BOLD, 'hallign' => XLSXF_HALLIGN_CENTER));
						$xls->setcolwidth($sheet,8,9000); $xls->setcell(array('col' => 8, 'data' => 'E-Mail', 'sheetname' => $sheet, 'row' => $row, 'fontweight' => XLSFONT_BOLD, 'hallign' => XLSXF_HALLIGN_CENTER));
						$xls->setcolwidth($sheet,9,4000); $xls->setcell(array('col' => 9, 'data' => 'Lizenz-Nr.', 'sheetname' => $sheet, 'row' => $row, 'fontweight' => XLSFONT_BOLD, 'hallign' => XLSXF_HALLIGN_CENTER));
						$xls->setcolwidth($sheet,10,3000); $xls->setcell(array('col' => 10, 'data' => 'Lizenz', 'sheetname' => $sheet, 'row' => $row, 'fontweight' => XLSFONT_BOLD, 'hallign' => XLSXF_HALLIGN_CENTER));
						$xls->setcolwidth($sheet,11,3000); $xls->setcell(array('col' => 11, 'data' => 'Gueltig bis', 'sheetname' => $sheet, 'row' => $row, 'fontweight' => XLSFONT_BOLD, 'hallign' => XLSXF_HALLIGN_CENTER));
						$xls->setcolwidth($sheet,12,3000); $xls->setcell(array('col' => 12, 'data' => 'Ehrenkodex', 'sheetname' => $sheet, 'row' => $row, 'fontweight' => XLSFONT_BOLD, 'hallign' => XLSXF_HALLIGN_CENTER));
						$xls->setcolwidth($sheet,13,3000); $xls->setcell(array('col' => 13, 'data' => 'Erste Hilfe', 'sheetname' => $sheet, 'row' => $row, 'fontweight' => XLSFONT_BOLD, 'hallign' => XLSXF_HALLIGN_CENTER));
						$ablaufendArr = array(); // Array für bald ablaufende Lizenzen
						$gueltig = '';
						while($objLizenzen->next())
						{
							$row++;
							$xls->setcell(array('col' => 0, 'data' => utf8_decode($objLizenzen->name), 'sheetname' => $sheet, 'row' => $row, 'hallign' => XLSXF_HALLIGN_LEFT));
							$xls->setcell(array('col' => 1, 'data' => utf8_decode($objLizenzen->vorname), 'sheetname' => $sheet, 'row' => $row, 'hallign' => XLSXF_HALLIGN_LEFT));
							$xls->setcell(array('col' => 2, 'data' => utf8_decode($objLizenzen->titel), 'sheetname' => $sheet, 'row' => $row, 'hallign' => XLSXF_HALLIGN_LEFT));
							$xls->setcell(array('col' => 3, 'data' => $this->getDate($objLizenzen->geburtstag), 'sheetname' => $sheet, 'row' => $row, 'hallign' => XLSXF_HALLIGN_LEFT));
							$xls->setcell(array('col' => 4, 'data' => $objLizenzen->plz, 'sheetname' => $sheet, 'row' => $row, 'hallign' => XLSXF_HALLIGN_LEFT));
							$xls->setcell(array('col' => 5, 'data' => utf8_decode($objLizenzen->ort), 'sheetname' => $sheet, 'row' => $row, 'hallign' => XLSXF_HALLIGN_LEFT));
							$xls->setcell(array('col' => 6, 'data' => utf8_decode($objLizenzen->strasse), 'sheetname' => $sheet, 'row' => $row, 'hallign' => XLSXF_HALLIGN_LEFT));
							$xls->setcell(array('col' => 7, 'data' => utf8_decode($objLizenzen->telefon), 'sheetname' => $sheet, 'row' => $row, 'hallign' => XLSXF_HALLIGN_LEFT));
							$xls->setcell(array('col' => 8, 'data' => $objLizenzen->email, 'sheetname' => $sheet, 'row' => $row, 'hallign' => XLSXF_HALLIGN_LEFT));
							$xls->setcell(array('col' => 9, 'data' => utf8_decode($objLizenzen->lizenznummer), 'sheetname' => $sheet, 'row' => $row, 'hallign' => XLSXF_HALLIGN_LEFT));
							$xls->setcell(array('col' => 10, 'data' => utf8_decode($objLizenzen->lizenz), 'sheetname' => $sheet, 'row' => $row, 'hallign' => XLSXF_HALLIGN_LEFT));
							$xls->setcell(array('col' => 11, 'data' => $this->getDate($objLizenzen->gueltigkeit), 'sheetname' => $sheet, 'row' => $row, 'hallign' => XLSXF_HALLIGN_LEFT));
							$xls->setcell(array('col' => 12, 'data' => $objLizenzen->codex, 'sheetname' => $sheet, 'row' => $row, 'hallign' => XLSXF_HALLIGN_LEFT));
							$xls->setcell(array('col' => 13, 'data' => $objLizenzen->help, 'sheetname' => $sheet, 'row' => $row, 'hallign' => XLSXF_HALLIGN_LEFT));
							// Läuft die Lizenz bald ab?
							if($objLizenzen->gueltigkeit > time() && strtotime("+6 month") > $objLizenzen->gueltigkeit)
							{
								// Gültigkeit größer aktuelle Zeit und aktuelle Zeit + 6 Monate größer als Gültigkeit
								$ablaufendArr[] = array
								(
									'gueltigkeit'      => $objLizenzen->gueltigkeit,
									'name'             => $objLizenzen->name,
									'vorname'          => $objLizenzen->vorname,
									'lizenz'           => $objLizenzen->lizenz,
								);
							}
						}
						$filename = $sheet . '_'.$objReferenten->verband.'_'.date("Ymd-Hi").".xls";
						//$xls->sendFile($filename);
						$xls->saveFile(TL_ROOT.'/files/trainerlizenzen/versandlisten/'.$filename);
					}
					
					$content = '<p>Hallo '.$objReferenten->vorname.' '.$objReferenten->nachname.',</p>';
					$content .= '<p>Im Anhang finden Sie die aktuelle Trainerliste Ihres Landesverbandes.</p>';
					// Ablaufende Lizenzen einbauen
					if($ablaufendArr)
					{
						$ablaufendArr = \Samson\Trainerlizenzen\Helper::sortArrayByFields($ablaufendArr, array('gueltigkeit' => SORT_DESC, 'name' => array(SORT_ASC, SORT_STRING), 'vorname' => array(SORT_ASC, SORT_STRING), 'lizenz' => array(SORT_ASC, SORT_STRING)));
						$content .= '<p>Folgende Lizenzen laufen innerhalb der nächsten 6 Monate ab:</p>';
						$content .= '<ul>';
						foreach($ablaufendArr as $item)
						{
							$content .= '<li>'.date('d.m.Y', $item['gueltigkeit']).' <b>'.$item['lizenz'].'</b> '.$item['name'].','.$item['vorname'].'</li>';
						}
						$content .= '</ul>';
					}
					$content .= '<p>Deutscher Schachbund<br>Lizenzverwaltung<br><a href="mailto:lizenzen@schachbund.de">lizenzen@schachbund.de</a></p>';
					$content .= '<p><i>DIESE E-MAIL WURDE AUTOMATISCH GENERIERT!</i></p>';
					// Email versenden, wenn Ehrungen anstehen
					$objEmail = new \Email();
					$objEmail->logFile = 'trainerlizenzen_email.log';
					$objEmail->from = 'lizenzen@schachbund.de';
					$objEmail->fromName = 'Judith Ulrich';
					$objEmail->subject = '[DSB-Lizenzen] Aktuelle Trainerliste '.$verbaende[$objReferenten->verband];
					$objEmail->html = $content;
					$objEmail->attachFile(TL_ROOT.'/files/trainerlizenzen/versandlisten/'.$filename); 
					$objEmail->sendBcc(array
					(
						'Frank Hoppe <webmaster@schachbund.de>',
						'Judith Ulrich <lizenzen@schachbund.de>'
					)); 
					if($objEmail->sendTo(array($objReferenten->vorname.' '.$objReferenten->nachname.' <'.$objReferenten->email.'>')))
					{
						// Versand in Ordnung, Datum merken
						$set = array
						(
							'sent_date'  => time()
						);
						$trainer = \Database::getInstance()->prepare("UPDATE tl_trainerlizenzen_referenten %s WHERE id = ?")
														   ->set($set)
														   ->execute($objReferenten->id);
					}
				} 
			}
		}
		
	}

	/**
	 * Datumswert aus Datenbank umwandeln
	 * @param mixed
	 * @return mixed
	 */
	public function getDate($varValue)
	{
		return trim($varValue) ? date('d.m.Y', $varValue) : '';
	}

}

/**
 * Instantiate controller
 */
$objTrainerliste = new Trainerliste();
$objTrainerliste->run();
echo 'Fertig';

