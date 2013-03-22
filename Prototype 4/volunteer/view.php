<?php
$menuarea = "volunteer";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_volunteer.php");

$id = $_GET["id"];
if( isset($id) )
{
	$action = "Edit Volunteer";
	
	$volunteer = new Volunteer();
	$volunteer->getVolunteer( $id );
	$firstName = $volunteer->getFirstName();
	$lastName = $volunteer->getLastName();
	$phone = $volunteer->getPhone();
	$email = $volunteer->getEmail();
	$positions = $volunteer->getPositions();
	$active = $volunteer->getActive();
	$programPositions = $volunteer->getProgramPositions($user_programID);
}
else
{
	//should not be here
	header("location:index.php");
}
?>

<script>
$(function () {
	$( "#volunteer-list" ).button().click(function() { window.location.href = "index.php";});
	$( "#update-volunteer" ).button().click(function() { $("#updateVolunteer").submit(); });
	
	$("#updateVolunteer").validate({
		errorElement: "div",
		wrapper: "div",
		errorPlacement: function(error, element) {
			error.insertAfter(element);
			error.addClass('message');
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
	
	$("#delete-volunteer").button().click(function() {
		dTitle = 'Delete Volunteer';
		dMsg = 'Are you sure you want to delete this volunteer?';
		dHref = $(this).val();
		popupDialog( dTitle, dMsg, dHref );
		return false
	});
});
</script>

<div id="control-header">
	
	<div class="left"><h1>Edit Existing Volunteer</h1></div>	
	<div class="right">
		<div id="control" class="ui-state-error">
			<button id="volunteer-list">Back to List</button>
			<button id="update-volunteer">Update Volunteer</button>
			<button class="delete-volunteer" id="delete-volunteer" value="process.php?action=Delete%20Volunteer&id=<? echo $id; ?>" \>Delete Workshop</button>
		</div>
	</div>
	
</div>

<form name="updateVolunteer" id="updateVolunteer" method="post" action="process.php">
<input type="hidden" name="action" value="<? echo $action ?>" />
<input type="hidden" name="volunteerID" value="<?echo $id ?>" />

<table>
	<tr>
		<td style="width:50%;vertical-align:top">
			<fieldset>
				<legend>Volunteer Information</legend>
				<table>
					<tr>
						<td>First Name:</td>
						<td><input type="text" name="firstName" value="<? echo $firstName ?>"/></td>
					</tr>
					<tr>
						<td>Last Name:</td>
						<td><input type="text" name="lastName" value="<? echo $lastName ?>"/></td>
					</tr>
					<tr>
						<td>Phone #:</td>
						<td><input type="text" name="phone" size="10" value="<? echo $phone?>"/></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><input type="text" name ="email" value="<? echo $email ?>"/></td>
					</tr>
					<tr>
						<td>Active?</td>
						<td>
							<select name="active">
								<option value="1" <? if($active == 1) echo "selected=\"true\"" ?> >Yes</option>
								<option value="0" <? if($active == 0) echo "selected=\"true\"" ?>>No</option>
							</select>
						</td>
					</tr>
				</table>
			</fieldset>
		</td>
		<td style="width:50%">
			<fieldset>
				<legend>Volunteer Positions</legend>
				<table>
					<? // positions array is run through to generate the table, compare to volunteer positions to check
						foreach( $programPositions as $key => $value)
						{
						echo "<tr>
						<td>$key</td>
						<td><input type=\"checkbox\" name=\"position[]\" value=\"$value\" ";
						foreach( $positions as $pkey => $pvalue)
							if ($pvalue == $value) echo " checked=\"checked\" ";
						echo "/></td></tr>";
						}
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