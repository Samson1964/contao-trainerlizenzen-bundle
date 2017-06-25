<?php
/**
 * @file Beispiel zum laden eines Lizenzvordrucks im PDF Format 
 * @author Stefan Hörterer <stefan.hoerterer@ghostthinker.de> 
 */

$license_number_dosb = "1093";

//HOST - Achtung, hier demo system
$host = "https://bildungsnetz.ghostthinker.de/api/lims/request";
$username = "webmaster";
$password = "katerpillarZ58";

//Anfuegen der DOSB Lizenznummer als url parameter.
$host .= urlencode($license_number_dosb);

$process = curl_init($host);

//hier ist auch noch application/xml möglich
curl_setopt($process, CURLOPT_HTTPHEADER, array(
  'Accept: application/json'
));
curl_setopt($process, CURLOPT_HEADER, 1);
curl_setopt($process, CURLOPT_USERPWD, $username . ":" . $password);
curl_setopt($process, CURLOPT_TIMEOUT, 30);
curl_setopt($process, CURLOPT_POST, 1);
curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);


//Request ausfuehren
$response = curl_exec($process);

$errors = NULL;
if (curl_errno($process)) {
  $errors=  'Curl error: ' . curl_error($process);
}

//schreiben der Daten in eine PDF - hier als Beispiel einfach ins Verzeichnis /tmp
$filename = "/tmp/lizenz".$license_number_dosb.".pdf";
file_put_contents($filename, $response);

/*

postal => 42431 
organisation_id => 1093 
mail => test@example.com 
training_course_id => 512 
firstname => demo 
lastname => user 
birthdate => 519137072 
gender => w 
street => 123 fakestreet 
city => Hamburg 
valid_until => 1939207472 
issue_date => 1465908272 
issue_place => Hamburg 
honor_code => 1 
honor_code_date => 1402749872 
first_aid => 0 
first_aid_date =>  

*/
