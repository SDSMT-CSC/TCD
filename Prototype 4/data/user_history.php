<?php
header("Content-Type: application/json");
include($_SERVER['DOCUMENT_ROOT']."/includes/secure.php");

//pulls the data, and gets the table
echo $user->fetchHistory( $_GET["id"] );
?>

