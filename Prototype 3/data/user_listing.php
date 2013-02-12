<?php

//verify user has access to this page
session_start();
if( ($cur_time > $out_time) || (!isset($_SESSION["valid"]) && !$_SESSION["valid"]) )
{
	header("location: /index.php");
	die();
}
else {
	header("Content-Type: application/json");
	include($_SERVER['DOCUMENT_ROOT']."/includes/class_core.php");
	include($_SERVER['DOCUMENT_ROOT']."/includes/class_data.php");

	//pulls the data, and gets the table
	$data = new Data();
	$table = $data->fetchUserData();
	$lastElement = end($table);
}
?>

{
	"aaData": [
		<?php $data->buildDataTable($table); ?>
	]
}
