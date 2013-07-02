<?php
$menuarea = "court";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_court.php");

$court = new Court( $user_programID );
$court->getFromCaseID( $_GET["id"] );

if( isset($id) ) {
?>

<script type="text/javascript" src="jquery.js"></script>

<script type="text/javascript">
jQuery(function($) {
	$("#court-list").button().click(function() { window.location.href = 'hours.php' });
	$("#view-court").button().click(function() { window.location.href = 'view.php?id=<? echo $court->getCourtID(); ?>' });
	$('#update-court-hours').button().click(function(){ $('#court-hours').submit(); });
});
</script>

<? if( $user_type == 5 ) { ?>
<script type="text/javascript">
jQuery(function($) {  
  $('form :input').attr ( 'disabled', true );
  $('#update-court-hours').attr ( 'disabled', true );
  
});
</script>
<? } ?>

<div id="control-header">
  <div class="left"><h1>Enter Court Hours</h1></div> 
  <div class="right">
    <div id="control" class="ui-state-error">
      <button id="court-list">Back to List</button>
      <button id="view-court">View Court</button>
    </div>
  </div>
</div>

<form name="court-hours" method="post" action="process.php">
  <input type="hidden" name="action" value="Update Court Hours" />
  <input type="hidden" name="caseID" value="<? echo $id ?>" />
</form>

<fieldset>
  <legend>Case Information</legend>
  <table>
    <form name="case-type" method="post" action="process.php">
      <input type="hidden" name="action" value="Add Case Type" />
      <input type="hidden" name="caseID" value="<? echo $id ?>" />
      <tr>
        <td width="15%">Defendant Name:</td>
        <td width="35%"><? echo $court->getDefendant( $court->getCourtCaseID() )?></td>
        <td width="10%">Court Type:</td>
        <td width="20%">
          <select id="court-type" name="court-type">
            <option></option>
            <option<? if($court->type == "Trial/Hearing") echo " selected"; ?>>Trial/Hearing</option>
            <option<? if($court->type == "Truancy") echo " selected"; ?>>Truancy</option>
            <option<? if($court->type == "Peer Panel") echo " selected"; ?>>Peer Panel</option>
          </select>
        </td>
        <td width="20%"><button id="update-court-type">Update Court Type</button></td>
      </tr>
    </form>
    <tr>
      <td>Court Date:</td>
      <td><? echo date("m/d/Y", $court->courtDate ) ?></td>
      <td>Court Time:</td>
      <td><? echo date("h:i A", $court->courtDate );?></td>
      <td></td>
    </tr>
  </table>
</fieldset>

<div class="ui-state-highlight ui-corner-all" style="padding: 5px 0;">
  <form name="case-global-hours" method="post" action="process.php">
    <input type="hidden" name="action" value="Set Global Hours" />
    <input type="hidden" name="caseID" value="<? echo $id ?>" />
    <span class="ui-icon ui-icon-info" style="float: left; margin: 6px;"></span>
    <span style="padding-right: 100px; color: #464646;">Set hours for all assigned court and jury members:</span> <input type="text" name="global-hours" size="5" />
    <button id="update-court-hours">Update Court Hours</button>
  </form>
</div>

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
}

include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>
