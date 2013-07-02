<?php
header("Content-Type: application/json");
include($_SERVER['DOCUMENT_ROOT']."/includes/secure.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_data.php");

//pulls the data, and gets the table
$data = new Data();
echo $data->fetchDefendantSearchListing( $user_programID, $_GET["lastName"], 
                                         $_GET["firstName"], $_GET["location"],
                                         $_GET["dateOfBirth"], $_GET["homePhone"],
                                         $_GET["courtFileNumber"], $_GET["AgencyNumber"]);
?>