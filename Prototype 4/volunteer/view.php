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
	var_dump($positions);
	$programPositions = $volunteer->getProgramPositions($user_programID);
	var_dump($programPositions);
}
else
{
	//should not be here
	header("location:index.php");
}
?>

<script>
$(function () {
	$( "#previous-volunteer" ).button().click(function() {		});
	$( "#update-volunteer" ).button().click(function() { $("#updateVolunteer").submit(); });
	$( "#next-volunteer" ).button().click(function() {		});
	
	("#updateVolunteer").validate({
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
			<button id="previous-volunteer">Previous</button>
			<button id="update-volunteer">Update Volunteer</button>
			<button id="next-volunteer">Next</button>
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
								<option>Yes</option>
								<option>No</option>
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
						echo "
					<tr>
						<td>$key</td>
						<td><input type=\"checkbox\" name=\"position[]\" value=\"$value\" /></td>
					</tr>";
						//foreach( $position as $pkey => $pvalue)
						//	if ($pvalue == $value) echo " checked=\"checked\" ";
						//echo "/></td></tr>";
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