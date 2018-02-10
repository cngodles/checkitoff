<?php
require_once("site_connect.php");

if(isset($_POST['do'])){
  if($_POST['do'] == 'logout'){
		$_SESSION['googleid'] = '';
		session_destroy();
	}
	if($_POST['do'] == 'setgoogleid'){
		if(isset($_POST['userid']) && isset($_POST['tokenid'])){
			$jrep = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v3/tokeninfo?id_token='.$_POST['tokenid']));
			if($jrep->iss == 'accounts.google.com' && $jrep->sub == $_POST['userid']){
				$_SESSION['googleid'] = $_POST['userid'];
				echo 'Logged in';
			} else {
				echo 0;
			}
		}
	}
	if($_POST['do'] == 'getmonth'){
    header('Content-Type: application/json');
		if(!empty($_SESSION['googleid'])){
			$dbreturn = yumdata_array("
				SELECT `date` 
				FROM `checks` 
				WHERE `googleid` = ? AND `date` BETWEEN '2018-02-01' AND '2018-02-28'
				", array($_SESSION['googleid']));

			$jsondata = $dbreturn;  
			//$jsondata = json_decode(file_get_contents("data-1.json"));
			print_r(json_encode($jsondata, JSON_PRETTY_PRINT));
		}
  }
  if($_POST['do'] == 'updatedata'){
    switch($_POST['action']){
			case 'on':
				$exists = yumdata_master("
					SELECT COUNT(*) AS TOT 
					FROM `checks` 
					WHERE `googleid` = ? AND `date` = ?
					", 
					array($_SESSION['googleid'], $_POST['date']));
				if($exists['TOT'] == 0){
					yumdata_do("
						INSERT INTO `checks`
						(`googleid`, `date`)
						VALUES
						(?, ?)
						",
						array($_SESSION['googleid'], $_POST['date']));
				}
				break;
			case 'off':
				yumdata_do("
					DELETE FROM `checks` 
					WHERE `googleid` = ? AND `date` = ?
					",
					array($_SESSION['googleid'], $_POST['date']));
				break;
		}
		//header('Content-Type: application/json');
    //$jsondata = json_decode(file_get_contents("data-1.json"));
    
    //file_put_contents("data-1.json", json_encode($jsondata));
  }
} else {
  echo 'shooo';
}
?>