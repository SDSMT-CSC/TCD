<?php
$menuarea = "court";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_court.php");

$court = new Court( $user_programID );
$court->getFromID( 11 );
var_dump($court);
?>

<script type="text/javascript" src="jquery.js"></script>

<div id="tabs">
  <ul>
    <li><a href="#tabs-members">Court Members</a></li>
    <li><a href="#tabs-jury">Jury Members</a></li>
  </ul>
  <div id="tabs-members">
    <? include("tab_members.php"); ?> 
  </div>
  <div id="tabs-jury">
    <? include("tab_jury.php"); ?>  
  </div>
</div>

<?php

include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>