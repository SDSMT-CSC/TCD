<?php
header("Content-Type: application/json");
include($_SERVER['DOCUMENT_ROOT']."/includes/secure.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_data.php");

//pulls the data, and gets the table
$data = new Data();
echo $data->fetchCourtSearchListing( $user_programID, $_GET["courtName"], $_GET["courtAddress"], $_GET["courtTime"], $_GET["courtDate"] );
?>