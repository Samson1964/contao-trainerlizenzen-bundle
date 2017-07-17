<?php

// runonce.php: Wird ausgeführt beim Aktualisieren der Datenbank im BE und danach gelöscht!
// Verlängerungen in das neue Feld übertragen

class TrainerRunonceJob extends Controller
{
	public function __construct()
	{
		parent::__construct();
		//$this->import('Database');
	}
	public function run()
	{
		$result = \Database::getInstance()->prepare("SELECT * FROM tl_trainerlizenzen")
		                                  ->execute();
		
		if($result->numRows)
		{
			while($result->next()) 
			{
				$set = array(); // Leeres Ziel-Array anlegen
				$leer = true;
				if($result->verlaengerung1) {$set[]['datum'] = 0 + $result->verlaengerung1; $leer = false;}
				if($result->verlaengerung2) {$set[]['datum'] = 0 + $result->verlaengerung2; $leer = false;}
				if($result->verlaengerung3) {$set[]['datum'] = 0 + $result->verlaengerung3; $leer = false;}
				if($result->verlaengerung4) {$set[]['datum'] = 0 + $result->verlaengerung4; $leer = false;}
				if($result->verlaengerung5) {$set[]['datum'] = 0 + $result->verlaengerung5; $leer = false;}
				if($result->verlaengerung6) {$set[]['datum'] = 0 + $result->verlaengerung6; $leer = false;}
				if($result->verlaengerung7) {$set[]['datum'] = 0 + $result->verlaengerung7; $leer = false;}
				if($result->verlaengerung8) {$set[]['datum'] = 0 + $result->verlaengerung8; $leer = false;}

				if(!$leer)
				{
					// Datensatz schreiben, wenn Daten vorhanden sind
					$serArr = serialize($set);
					log_message($result->id.' '.$serArr, 'trainerlizenzen_error.log');
					$set = array
					(
						'verlaengerungen' => $serArr
					);
					\Database::getInstance()->prepare("UPDATE tl_trainerlizenzen %s WHERE id = ?")->set($set)->execute($result->id);
				}
			}
		}		
		
	}
}
$objTrainerRunonceJob = new TrainerRunonceJob();
$objTrainerRunonceJob->run();
