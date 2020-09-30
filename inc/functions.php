<?php
function get_user($id) {
	include 'mysql.php';

	$sql = "SELECT * FROM PlayerIndexes WHERE `key` = '" . $id . "';";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		return json_decode($row['value'], true);
		}
	}
}

function cap($str) {
	return ucfirst(strtolower($str));
}

function toDate($mil) {
	$seconds = $mil / 1000;
	return date("d/m/Y h:m:s A", $seconds);
}

function convert_seconds($mil) {
	$seconds = $mil * 0.001;
 	$dt1 = new DateTime("@0");
  	$dt2 = new DateTime("@$seconds");
  	return $dt1->diff($dt2)->format('%a d, %h h, %i min and %s sec');
}

function toReadableSec($seconds) {
  $dtF = new \DateTime('@0');
  $dtT = new \DateTime("@$seconds");
  $time = (string)$dtF->diff($dtT)->format('%a days, %h hrs, %i mins, and %s secs');
  $time = str_replace('0 days, ', '', $time);
  $time = str_replace('0 hrs, ', '', $time);
  $time = str_replace('0 mins, ', '', $time);
  if(!strpos($time, 'mins') && !strpos($time, 'hrs') && !strpos($time, 'days')) {
	  if(strpos($time, '0 secs')) {
	     return $dtF->diff($dtT)->format('%s seconds');
	  }
  }
  return $time;
}

function CheckForUpdates(){
	$updateconfig = file_get_contents('https://ultrapluginswebaddons.com/new/uecon/version.json');
	$updateconfig = json_decode($updateconfig);

	$curconfig = file_get_contents('inc/config.json');
	$curconfig = json_decode($curconfig);
	
	$newversion = $updateconfig->version;
	$curvresion = $curconfig->version;

	if($newversion > $curvresion){
		return true;
	}else{
		return false;
	}
}

function GetNewVersion(){
	$updateconfig = file_get_contents('https://ultrapluginswebaddons.com/new/uecon/version.json');
	$updateconfig = json_decode($updateconfig);
	
	$newversion = $updateconfig->version;
	
	return $newversion;
}
?>