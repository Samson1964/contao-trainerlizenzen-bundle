<?php

// runonce.php: Wird ausgeführt beim Aktualisieren der Datenbank im BE und danach gelöscht!

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
				$geburtstag = $result->geburtstag;
				$erwerb = $result->erwerb;
				$gueltigkeit = $result->gueltigkeit;
				$letzteAenderung = $result->letzteAenderung;
				$verlaengerung1 = $result->verlaengerung1;
				$verlaengerung2 = $result->verlaengerung2;
				$verlaengerung3 = $result->verlaengerung3;
				$verlaengerung4 = $result->verlaengerung4;
				$set = array
				(
				
					'geburtstag' => $geburtstag ? mktime(0, 0, 0, substr($geburtstag, 4, 2), substr($geburtstag, 6, 2), substr($geburtstag, 0, 4)) : '',
					'erwerb' => $erwerb ? mktime(0, 0, 0, substr($erwerb, 4, 2), substr($erwerb, 6, 2), substr($erwerb, 0, 4)) : '',
					'gueltigkeit' => $gueltigkeit ? mktime(0, 0, 0, substr($gueltigkeit, 4, 2), substr($gueltigkeit, 6, 2), substr($gueltigkeit, 0, 4)) : '',
					'letzteAenderung' => $letzteAenderung ? mktime(0, 0, 0, substr($letzteAenderung, 4, 2), substr($letzteAenderung, 6, 2), substr($letzteAenderung, 0, 4)) : '',
					'verlaengerung1' => $verlaengerung1 ? mktime(0, 0, 0, substr($verlaengerung1, 4, 2), substr($verlaengerung1, 6, 2), substr($verlaengerung1, 0, 4)) : '',
					'verlaengerung2' => $verlaengerung2 ? mktime(0, 0, 0, substr($verlaengerung2, 4, 2), substr($verlaengerung2, 6, 2), substr($verlaengerung2, 0, 4)) : '',
					'verlaengerung3' => $verlaengerung3 ? mktime(0, 0, 0, substr($verlaengerung3, 4, 2), substr($verlaengerung3, 6, 2), substr($verlaengerung3, 0, 4)) : '',
					'verlaengerung4' => $verlaengerung4 ? mktime(0, 0, 0, substr($verlaengerung4, 4, 2), substr($verlaengerung4, 6, 2), substr($verlaengerung4, 0, 4)) : '',
				);
				\Database::getInstance()->prepare("UPDATE tl_trainerlizenzen %s WHERE id = ?")->set($set)->execute($result->id);
			}
		}		
		
	}
}
$objTrainerRunonceJob = new TrainerRunonceJob();
$objTrainerRunonceJob->run();

