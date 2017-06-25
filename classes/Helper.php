<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * @link http://www.contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 * 
 * Modul Banner - Check Helper 
 * 
 * PHP version 5
 * @copyright  Glen Langer 2007..2015
 * @author     Glen Langer
 * @package    Banner
 * @license    LGPL
 */


/**
 * Class BannerCheckHelper
 *
 * @copyright  Glen Langer 2015
 * @author     Glen Langer
 * @package    Banner
 */

namespace Samson\Trainerlizenzen;

class Helper extends \Frontend
{
	/**
	 * Current object instance
	 * @var object
	 */
	protected static $instance = null;

	var $user;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		// Benutzerdaten laden
		if(FE_USER_LOGGED_IN)
		{
			// Frontenduser eingeloggt
			$this->user = \FrontendUser::getInstance();
		}
		parent::__construct();
	}


	/**
	 * Return the current object instance (Singleton)
	 * @return BannerCheckHelper
	 */
	public static function getInstance()
	{
		if (self::$instance === null)
		{
			self::$instance = new \Samson\Trainerlizenzen\Helper();
		}
	
		return self::$instance;
	}

	public function getVerbaende() 
	{
		return array
		(
			'-'                   => '-',
			'1'                   => 'Baden',
			'2'                   => 'Bayern',
			'3'                   => 'Berlin',
			'D'                   => 'Brandenburg',
			'B'                   => 'Bremen',
			'4'                   => 'Hamburg',
			'5'                   => 'Hessen',
			'E'                   => 'Mecklenburg-Vorpommern',
			'7'                   => 'Niedersachsen',
			'6'                   => 'Nordrhein-Westfalen',
			'8'                   => 'Rheinland-Pfalz',
			'9'                   => 'Saarland',
			'F'                   => 'Sachsen',
			'H'                   => 'Sachsen-Anhalt',
			'A'                   => 'Schleswig-Holstein',
			'G'                   => 'Thüringen',
			'C'                   => 'Württemberg'
		);
	}

	public function getLizenzen() 
	{
		return array
		(
			'-'                   => '-',
			'A'                   => 'A',
			'B'                   => 'B',
			'C'                   => 'C',
			'C-B'                 => 'C-B',
			'C-Sonderlizenz'      => 'C-Sonderlizenz',
			'F'                   => 'F',
			'F/C'                 => 'F/C',
			'J'                   => 'J'
		);
	}

	/**
	 * Sortiert ein multidimensionales Array der Form
	 * $data = array(
	 *   array("jahrgang" => 1979, "nachname" => "Müller",   "vorname" => "Annegret"),
	 *   array("jahrgang" => 1983, "nachname" => "Schmidt",  "vorname" => "Lisbeth"),
	 *   array("jahrgang" => 1980, "nachname" => "Meier",    "vorname" => "Günther"),
	 *   array("jahrgang" => 1981, "nachname" => "Werner",   "vorname" => "Gabi"),
	 *   array("jahrgang" => 1980, "nachname" => "Hofmann",  "vorname" => "Ramona"),
	 *   array("jahrgang" => 1981, "nachname" => "Kaufmann", "vorname" => "Maria"),
	 * );
	 * indem das Array vorher umgebaut wird:
	 * foreach ($data as $key => $row) {
	 *   $jahrgang[$key] = $row['jahrgang'];
	 *   $nachname[$key] = $row['nachname'];
	 * }
	 *
	 * Aufruf mit z.B.:
	 * $sorted = sortArrayByFields(
	 *     $data,
	 *     array(
	 *         'jahrgang' => SORT_DESC,
	 *         'nachname' => array(SORT_ASC, SORT_STRING)
	 *     )
	 * );	 
	 *
	 * http://www.karlvalentin.de/660/mehrdimensionale-arrays-in-php-bequem-sortieren.html
	 */
	function sortArrayByFields($arr, $fields)
	{
		$sortFields = array();
		$args       = array();
		
		foreach ($arr as $key => $row) 
		{
			foreach ($fields as $field => $order) 
			{
				$sortFields[$field][$key] = $row[$field];
			}
		}
		
		foreach ($fields as $field => $order) 
		{
			$args[] = $sortFields[$field];
			
			if (is_array($order)) 
			{
				foreach ($order as $pt) 
				{
					$args[$pt];
				}
			} 
			else 
			{
				$args[] = $order;
			}
		}
		
		$args[] = &$arr;
		
		call_user_func_array('array_multisort', $args);
		
		return $arr;
	}

}