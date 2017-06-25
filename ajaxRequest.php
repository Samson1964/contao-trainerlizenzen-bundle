<?php

if (!defined('TL_ROOT')) die('You cannot access this file directly!');
 
// MyClass.php

class ajaxRequest extends System 
{

	var $organization;
	var $host;
	var $username;
	var $password;
	var $training_course_id;
	
	function __construct() 
	{
		$this->organization = '1093';
		$this->host = LIMS_HOST;
		$this->username = LIMS_USERNAME;
		$this->password = LIMS_PASSWORD;
		$this->training_course_id = array
		(
			'A'              => 515, // T-A/L > Schach
			'B'              => 514, // T-B/L > Schach
			'C'              => 513, // T-C/L > Schach
			'C-B'            => 512, // T-C/B > Schach
			'C-Sonderlizenz' => 512, // T-C/B > Schach
			'F'              => 512, // fiktiv, nicht angelegt beim DOSB
			'F/C'            => 512, // fiktiv, nicht angelegt beim DOSB
			'J'              => 512, // fiktiv, nicht angelegt beim DOSB
		);
	}

	public function compile() 
	{
	
		if(\Input::get('acid') == 'trainerlizenzen') 
		{
			
			$offset = 25 * (\Input::get('step') - 1);
			$limit = 25;

			// Anfügen der Methode für das Erstellen/Aktualisieren einer Lizenz
			$host = $this->host.'request';
			
			$result = \Database::getInstance()->prepare("SELECT * FROM tl_trainerlizenzen WHERE gueltigkeit >= ? AND published = ? AND (letzteAenderung > dosb_tstamp OR dosb_code <> 200) ORDER BY id")
										      ->limit($limit, $offset)
										      ->execute(time(), 1);

			// Auswerten
			if($result->numRows)
			{
				$records_exported = 0;
				while($result->next()) 
				{
					$records_exported++;
					$text = 'Exportiere ID '.$result->id.' '.$result->vorname.' '.$result->name.' (Lizenz gültig bis '.date('d.m.Y', $result->gueltigkeit).')';
					
					// Letztes Verlängerungsdatum ermitteln
					$verlaengerung = $result->verlaengerung5;
					if(!$verlaengerung) $verlaengerung = $result->verlaengerung4;
					if(!$verlaengerung) $verlaengerung = $result->verlaengerung3;
					if(!$verlaengerung) $verlaengerung = $result->verlaengerung2;
					if(!$verlaengerung) $verlaengerung = $result->verlaengerung1;
					if(!$verlaengerung) $verlaengerung = $result->erwerb;
					
					// Datenpaket aufbereiten
					$data = array
					(
						'firstname'          => $result->vorname,
						'lastname'           => $result->name,
						'academic_title'     => $result->titel,
						'birthdate'          => $result->geburtstag, // Geburtstag als Unixzeit
						'gender'             => $result->geschlecht,
						'street'             => $result->strasse,
						'city'               => $result->ort,
						'postal'             => $result->plz,
						'mail'               => $result->email,
						'training_course_id' => $this->training_course_id[$result->lizenz], // Ausbildungsgang
						'valid_until'        => $result->gueltigkeit, // Lizenz gültig bis als Unixzeit
						'issue_date'         => $verlaengerung, // Verlängerungsdatum
						'issue_place'        => 'Berlin', // Ausstellungsort
						'honor_code'         => 0 + $result->codex, // Ehrenkodex
						'honor_code_date'    => $result->codex_date, // Datum Ehrenkodex
						'first_aid'          => 0 + $result->help, // Erste-Hilfe-Ausbildung
						'first_aid_date'     => $result->help_date, // Datum der Erste-Hilfe-Ausbildung
					);
					// Restliche Werte ergänzen
					if($result->license_number_dosb) 
					{
						$data['license_number_dosb'] = $result->license_number_dosb; // Aktive DOSB-Lizenznummer
					}
					else
					{
						$data['organisation_id']     = 1093; // Organisationsnummer DSB
						$data['first_issue_date']    = $result->erwerb; // Erstausstellungsdatum
					}

					$additionalHeaders = '';
					$process = curl_init($host);
					
					//hier ist auch noch application/xml möglich
					curl_setopt($process, CURLOPT_HTTPHEADER, array
					(
					  'Accept: application/json',
					  $additionalHeaders
					));
					curl_setopt($process, CURLOPT_HEADER, 1);
					curl_setopt($process, CURLOPT_USERPWD, $this->username . ":" . $this->password);
					curl_setopt($process, CURLOPT_TIMEOUT, 30);
					curl_setopt($process, CURLOPT_POST, 1);
					curl_setopt($process, CURLOPT_POSTFIELDS, $data);
					curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
					//nur für test zwecke
					curl_setopt($process, CURLOPT_SSL_VERIFYPEER, FALSE);
					//request ausführen
					$response = curl_exec($process);
					
					$errors = NULL;
					if (curl_errno($process)) 
					{
						$errors = 'Curl error: ' . curl_error($process);
					}
					
					$header_size = curl_getinfo($process, CURLINFO_HEADER_SIZE);
					$httpCode = curl_getinfo($process, CURLINFO_HTTP_CODE); // HTTP-Code der Abfrage
					$header = substr($response, 0, $header_size);
					$body = substr($response, $header_size);//json_decode(substr($response, $header_size));
			
					if($errors)
					{
						// Fehlermeldung in Datenbank eintragen
					}
					else
					{
						$data = json_decode($body);
						
						if(is_object($data) && $httpCode == 200)
						{
							// Datensatz aktualisieren
							$set = array(
								'license_number_dosb' => $data->license_number_dosb,
								'lid'                 => $data->lid,
							);
							$erg = \Database::getInstance()->prepare("UPDATE tl_trainerlizenzen %s WHERE id=?")
							                                  ->set($set)
							                                  ->execute($result->id); 
							$httpText = 'OK';
						}
						else
						{
							$httpText = substr($body, 2, strlen($body) - 4);
						}
						// Abrufinformationen ergänzen
						$set = array(
							'dosb_tstamp'         => time(),
							'dosb_code'           => $httpCode,
							'dosb_antwort'        => $httpText,
						);
						$erg = \Database::getInstance()->prepare("UPDATE tl_trainerlizenzen %s WHERE id=?")
						                                  ->set($set)
						                                  ->execute($result->id); 
						
						$text .= ' ('.$httpCode.' '.$httpText.')';
						if($httpCode == 200)
							$text = '<span style="color:#008000">'.$text.'</span><br>';
						else
							$text = '<span style="color:#CA0000">'.$text.'</span><br>';
						
						$datenpaket .= $text;
						
						//$content .= '<script type="text/javascript">';
						//$content .= '$(document).ready(function(){';
						//$content .= '$("trainer_'.$result_id.'").html("Geprüft");';
						//$content .= '$("trainer_'.$result_id.'").addClass("tl_green");';
						//$content .= '});</script>';
					}

				}
				$count = $_SESSION['trainerlizenzen_counter'] + 1;
				$content = Input::get('loops') == $count ? '<b>Fertig!</b><br>' : '';
				$content .= '[<i>'.date('d.m.Y H:i:s').'</i>] <b>Paket '.$count.' von '.Input::get('loops').' gesendet</b> = '.$records_exported.' Datensätze:<br>';
				$content .= $datenpaket;
				$_SESSION['trainerlizenzen_counter'] = $count;
				$datenpaket = '';
			}

			echo '<span class="item">'.$content.'</span>';
			exit;
		}
	}

}
