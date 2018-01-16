<?php
if(isset($_POST['do'])){
  if($_POST['do'] == 'getmonth'){
    header('Content-Type: application/json');
    $jsondata = json_decode(file_get_contents("data-1.json"));
    print_r(json_encode($jsondata, JSON_PRETTY_PRINT));
  }
  if($_POST['do'] == 'updatedata'){
    //header('Content-Type: application/json');
    //$jsondata = json_decode(file_get_contents("data-1.json"));
    
    //file_put_contents("data-1.json", json_encode($jsondata));
  }
} else {
  echo 'shooo';
}
?>