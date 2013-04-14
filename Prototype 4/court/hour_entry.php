<?php
$menuarea = "court";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_court.php");

$court = new Court( $user_programID );
$court->getFromID( $_GET["id"] );

if( isset($id) ) {
?>
<script type="text/javascript">
jQuery(function($) {
	$("#court-list").button().click(function() { window.location.href = 'hours.php' });
	$("#view-court").button().click(function() { window.location.href = 'view.php?id=<? echo $id ?>' });
	$('#update-court-hours').button().click(function(){ $('#court-hours').submit(); });
});
</script>

<h1>Enter Court Hours</h1>

<div id="control-header">
	<div class="left"><h1><? echo $action ?></h1></div>	
	<div class="right">
		<div id="control" class="ui-state-error">
			<button id="court-list">Back to List</button>
			<button id="view-court">View Court</button>
		</div>
	</div>
</div>

<form name="court-hours" method="post" action="process.php">
<input type="hidden" name="action" value="Update Court Hours" />
<input type="hidden" name="courtID" value="<? echo $id ?>" />

<div class="ui-state-highlight ui-corner-all" style="padding: 5px 0;">
  <span class="ui-icon ui-icon-info" style="float: left; margin: 6px;"></span>
  <span style="padding-right: 282px; color: #464646;">Globally set all hours:</span> <input type="text" name="global-hours" size="5" />
</div>

<fieldset>
  <legend>Set hours for court members</legend>
  <table style="width: 600px">
  <?
  // get programs court positions and who was assigned for this court
  $members = $court->getMembersForTime( "positions" );
  
	if( !$members )
	{ 
	?>
	<tr><td colspan="3">No members assigned to this court.</td></tr>
  <?
	}
	else
	{
		$index = 0;
		foreach( $members as $row )
		{
		 	?>
			<tr>
				<td width="200"><? echo $row['position'] ?>: </td>
				<td><? echo $row['lastName'] . ", " . $row['firstName'] ?></td>
				<td>
        	<input type="hidden" name="members[<? echo $index ?>][volunteerID]" value="<? echo $row['volunteerID'] ?>" />
        	<input type="hidden" name="members[<? echo $index ?>][positionID]" value="<? echo $row['positionID'] ?>" />
        	<input type="text" name="members[<? echo $index ?>][hours]" value="<? echo ( $row['hours'] ) ? $row['hours'] : "0.00" ?>" size="5" />
          
        </td>
			</tr>  
			<?
			$index++;
		}
	}
  ?>
</table>
</fieldset>

<fieldset>
  <legend>Set hours for jury members</legend>
  <table style="width: 600px">
  <?
  // get programs court positions and who was assigned for this court
  $members = $court->getMembersForTime( "jury" );
  
	if( !$members )
	{ 
	?>
  <tr class=""><td colspan="3">No members assigned to this court.</td></tr>
  <?
	}
	else
	{
		$index = 0;
		foreach( $members as $row )
		{
		 ?>
			<tr>
				<td width="200"><? echo $row['type'] ?>: </td>
				<td><? echo $row['lastName'] . ", " . $row['firstName'] ?></td>
				<td>
          <input type="hidden" name="jury[<? echo $index ?>][id]" value="<? echo $row['id'] ?>"  />
          <input type="hidden" name="jury[<? echo $index ?>][type]" value="<? echo $row['type'] ?>"  />
        	<input type="text" name="jury[<? echo $index ?>][hours]" value="<? echo ( $row['hours'] ) ? $row['hours'] : "0.00" ?>" size="5" />
        </td>
			</tr>  
			<?
			$index++;
		}
	}
  ?>
  </table>
</fieldset>
<button id="update-court-hours">Update Court Hours</button>
<?php
}

include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>
