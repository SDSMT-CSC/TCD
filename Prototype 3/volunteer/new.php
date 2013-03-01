<?php
$menuarea = "volunteer";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");

// make sure logged in user has access to edit this user
//if( $user_type == 1 || $programID != $program->getProgramID() )
//{
//	echo "NO ACCESS!";
//}

//set variables to default
$action = "Add Volunteer";
$firstName = "";
$lastName = "";
$phone = 0;
$email = "";
?>

<script>
$(function () {
	$("#add-volunteer").button().click(function(){ $("#newVolunteer").submit(); });
	
	//ADD INFO VALIDATION
});
</script>

<div id="control-header">
	<div class="left"><h1>Add New Volunteer</h1></div>	
	<div class="right">
		<div id="control" class="ui-state-error">
			<button id="add-volunteer">Add Volunteer</button>
		</div>
	</div>
</div>

<form name="newVolunteer" id="newVolunteer" method="post" action="process.php">
<input type="hidden" name="action" value="<? echo $action ?>" />
<input type="hidden" name="programID" value="<?echo $user->getProgramID(); ?>" />

<table>
	<tr>
		<td style="width:50%;vertical-align:top">
			<fieldset>
				<legend>Volunteer Information</legend>
				<table>
					<tr>
						<td>First Name:</td>
						<td><input type="text" name="firstName" /></td>
					</tr>
					<tr>
						<td>Last Name:</td>
						<td><input type="text" name="lastName" /></td>
					</tr>
					<tr>
						<td>Phone #:</td>
						<td><input type="text" name="phone" size="10" /></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><input type="text" name ="email" size="10" /></td>
					</tr>
				</table>
			</fieldset>
		</td>
		<td style="width:50%">
			<fieldset>
				<legend>Volunteer Positions</legend>
				<table>
					<tr>
						<td>Judge</td>
						<td><input type="checkbox" name="position[]" value="judge" /></td>
					</tr>
					<tr>
						<td>Prosecuting Attorney</td>
						<td><input type="checkbox" name="position[]" value="prosecuting_attorney" /></td>
					</tr>
					<tr>
						<td>Defence Attorney</td>
						<td><input type="checkbox" name="position[]" value="defense_attorney" /></td>
					</tr>
					<tr>
						<td>Clerk</td>
						<td><input type="checkbox" name="position[]" value="clerk" /></td>
					</tr>
					<tr>
						<td>Bailiff</td>
						<td><input type="checkbox" name="position[]" value="bailiff" /></td>
					</tr>
					<tr>
						<td>Exit Interviewer</td>
						<td><input type="checkbox" name="position[]" value="exit_interviewer" /></td>
					</tr>
					<tr>
						<td>Advisor</td>
						<td><input type="checkbox" name="position[]" value="advisor" /></td>
					</tr>
					<tr>
						<td>Jury</td>
						<td><input type="checkbox" name="position[]" value="jury" /></td>
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