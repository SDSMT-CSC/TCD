<?php
header("Content-Type: application/json");
include($_SERVER['DOCUMENT_ROOT']."/includes/secure.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_citation.php");

// pulls the data, and gets the table
$citation = new Citation( $_GET["id"] );
echo $citation->getOffenseList();
?>
