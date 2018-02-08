<?php
$config = json_decode(file_get_contents("configuration.json"));

$admin_username = $config->database->username;
$admin_password = $config->database->password;
$admin_host = $config->database->host;
$admin_database = $config->database->name;


$db = new PDO('mysql:host='.$admin_host.';dbname='.$admin_database.';charset=utf8', $admin_username, $admin_password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


function yumdata_master($sql, $array = ''){
	global $db;
	try {
		if(gettype($array) == 'array'){
			$stmt = $db->prepare($sql);
			$stmt->execute($array);
		} else {
			$stmt = $db->query($sql);
		}
		$rows = $stmt->fetch(PDO::FETCH_ASSOC);
		return $rows;
	} catch(PDOException $ex) {
		echo "Database Query Failed.";
	}
}

function yumdata_do($sql, $array = ''){
	global $db;
	try {
		if(gettype($array) == 'array'){
			$stmt = $db->prepare($sql);
			$stmt->execute($array);
		} else {
			$stmt = $db->query($sql);
		}
	} catch(PDOException $ex) {
		echo "Database Submit Failed.";
	}
}

function yumdata_array($sql, $array = ''){
	global $db;
	$data = array();
	try {
		//echo gettype($array);
		if(gettype($array) == 'array'){
			$stmt = $db->prepare($sql);
			$stmt->execute($array);
		} else {
			$stmt = $db->query($sql);
		}
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		//print_r($rows);
		foreach($rows AS $r){
			$data[] = $r;
		}
		return $data;
	} catch(PDOException $ex) {
		echo "Database Query Array Failed.";
	}
}