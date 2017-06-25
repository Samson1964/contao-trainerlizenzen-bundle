<?php
/**
 * @file Einfacher CURL-PHP client zum testen der LiMS Schnittstelle
 *
 * Created by PhpStorm.
 * User: Stefan Hörterer for Ghostthinker GmbH
 * Date: 17.09.2015
 * Time: 09:14
 */

$host = isset($_POST['host'])? $_POST['host'] : 'https://bildungsnetz.ghostthinker.de/api/lims/request';
$username = isset($_POST['username'])? $_POST['username'] : "webmaster";
$password = isset($_POST['password'])? $_POST['password'] : "katerpillarZ58";

$training_course_id = 515;

//zusammenbauen der Parameter
if(isset($_POST['data'])) {
  $new_license_data = array();
  $d = explode("\n", $_POST['data']);

  foreach($d as $e){
    $ps = explode('=>', $e);
    if(!empty($ps[0])) {
      $new_license_data[trim($ps[0])] = trim($ps[1]);
    }
  }
  $data = $_POST['data'];

}else {

  $new_license_data = array(
    'postal' => 42431,
    'organisation_id' => 1093,
    'mail' => 'test@example.com',
    'training_course_id' => $training_course_id,
    'firstname' => 'demo',
    'lastname' => 'user',
    'birthdate' => strtotime("NOW - 30 years"),
    'gender' => 'w',
    'street' => '123 fakestreet',
    'city' => 'Hamburg',
    'valid_until' => strtotime("NOW + 15 years"),
    'issue_date' => time(),
    'issue_place' => 'Hamburg',
    'honor_code' => 1,
    'honor_code_date' => strtotime('NOW - 2years'),
    'first_aid' => 1,
    'first_aid_date' => strtotime('NOW - 2years'),
  );

  $data = "";
  foreach ($new_license_data as $k => $v) {

    $data .= "$k => $v \n";
  }
}
if(!empty($_POST)) {

  $additionalHeaders = '';

  $process = curl_init($host);

  //hier ist auch noch application/xml möglich
  curl_setopt($process, CURLOPT_HTTPHEADER, array(
    'Accept: application/json',
    $additionalHeaders
  ));
  curl_setopt($process, CURLOPT_HEADER, 1);
  curl_setopt($process, CURLOPT_USERPWD, $username . ":" . $password);
  curl_setopt($process, CURLOPT_TIMEOUT, 60);
  curl_setopt($process, CURLOPT_POST, 1);
  curl_setopt($process, CURLOPT_POSTFIELDS, $new_license_data);
  curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);

  //nur für test zwecke
  curl_setopt($process, CURLOPT_SSL_VERIFYPEER, FALSE);

  //request ausführen
  $response = curl_exec($process);

  $errors = NULL;
  if (curl_errno($process)) {
    $errors=  'Curl error: ' . curl_error($process);
  }

  $header_size = curl_getinfo($process, CURLINFO_HEADER_SIZE);
  $header = substr($response, 0, $header_size);
  $body = substr($response, $header_size);//json_decode(substr($response, $header_size));
}else{
  $body = $header = $errors = "no reponse sent yet";
}
?>

<style>
  input[type="text"], textarea {
    width: 500px;
  }
  label {
    display: block;
  }
</style>

<form method="post">
  <h1>Request form</h1>
  <label for="host">Host and service</label>
  <input type='text' name="host" value="<?php print $host ?>"/>
  <label for="username">Username</label>
  <input type='text' name="username" value="<?php print $username ?>"/>
  <label for="password">Password</label>
  <input type='text' name="password" value="<?php print $password ?>"/>
  <label for="data">Data</label>
  <textarea type='text' name="data" rows="20"><?php print $data ?></textarea>
  <br/>
  <input type="submit" value="send request"/>
</form>
<h1>Reponse header</h1>
<pre>
<?php print $header; ?>
</pre>
<h1>Reponse body</h1>
<pre>
<?php print_r($body) ?>
</pre>
<h1>CURL Errors</h1>
<pre>
<?php print $errors ?>
</pre>