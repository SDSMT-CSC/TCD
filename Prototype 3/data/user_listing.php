<?php

// check session validity here

header("Content-Type: application/json");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_core.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_data.php");

$data = new Data();
$table = $data->fetchUserData();
$lastElement = end($table);
?>

{
	"aaData": [
		<?php $data->buildDataTable($table); ?>
	]
}
