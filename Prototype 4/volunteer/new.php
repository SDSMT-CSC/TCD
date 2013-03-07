<?php
$menuarea = "volunteer";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_volunteer.php");

// make sure logged in user has access to edit this user
if( $user_programID != $program->getProgramID() )
{
	echo "NO ACCESS!";
}

// get the positions that this program uses
$volunteer = new Volunteer();
$programPositions = $volunteer->getProgramPositions($user_programID);

// set variables to default
$action = "Add Volunteer";
$firstName = "";
$lastName = "";
$phone = 0;
$email = "";
?>

<script>
$(function () {
	$("#add-volunteer").button().click(function(){ $("#newVolunteer").submit(); });
	
	$("#newVolunteer").validate({
		errorElement: "div",
		wrapper: "div",
		errorPlacement: function(error, element) {
			error.insertAfter(element);
			error.addClass('messsage');
		},
		rules: {
			lastName: {
				required: true
			},
			phone: {
				required: true
			}
		}
	} );
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
					<? // positions array is run through to generate the table
						foreach( $programPositions as $key => $value)
						echo "
					<tr>
						<td>$key</td>
						<td><input type=\"checkbox\" name=\"position[]\" value=\"$value\" /></td>
					</tr>";
					?>
				</table>
			</fieldset>
		</td>
	</tr>
</table>

</form>

<?php 
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>