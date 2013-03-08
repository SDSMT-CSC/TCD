<?php
$menuarea = "workshop";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_data.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_workshop.php");

// make sure logged in user has access to edit this user
if( $user_programID != $program->getProgramID() )
{
	echo "NO ACCESS!";
}

//set variables to default
$data = new Data();
$action = "Add Workshop";
?>

<script>
$(function () {
	$( "#add-workshop" ).button().click(function(){ $("#newWorkshop").submit(); });
	$("#date").datepicker();
});
</script>

<div id="control-header">
	
	<div class="left"><h1>Add New Workshop</h1></div>	
	<div class="right">
		<div id="control" class="ui-state-error">
			<button id="add-workshop">Add Workshop</button>
		</div>
	</div>
	
</div>

<form name="newWorkshop" id="newWorkshop" method="post" action="process.php">
<input type="hidden" name="action" value="<? echo $action ?>" />
<input type="hidden" name="programID" value="<?echo $user->getProgramID(); ?>" />
	
<table>
	<tr>
		<td>
			<fieldset>
				<legend>Workshop Information</legend>
				<table>
					<tr>
						<td>Date:</td>
						<td><input type="text" name="date" value="<? echo date("m/d/Y") ?>"/></td>
					</tr>
					<tr>
						<td>Time:</td>
						<td><input type="text" name="time" value="<? echo date("g:ia") ?>"/></td>
					</tr>
					<tr>
						<td>Title:</td>
						<td><input type="text" name="title"/></td>
					</tr>
					<tr>
						<td>Description:</td>
						<td><input type="text" name="description"/></td>
					</tr>
					<tr>
						<td>Instructor:</td>
						<td><input type="text" name="instructor"/></td>
					</tr>
					<tr>
						<td>Officer:</td>
						<td>
							<select name="officer"/>
							<? echo $data->fetchOfficerDropdown( $user_programID, 0 )?>
							</select>
						</td>
					</tr>
				</table>
			</fieldset>
		</td>
	</tr>
</table>

</form>

<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>