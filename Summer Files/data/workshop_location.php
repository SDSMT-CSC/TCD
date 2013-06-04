<?php
header("Content-Type: application/json");
include($_SERVER['DOCUMENT_ROOT']."/includes/secure.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_data.php");

//pulls the data, and gets the table
$data = new Data();
echo $data->fetchWorkshopLocation( $user_programID );
?>