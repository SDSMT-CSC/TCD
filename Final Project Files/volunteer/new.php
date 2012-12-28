<?php

$menuarea = "volunteer";

include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");

?>



<script>

$(function () {

	$("#add-volunteer").button().click(function(){ window.location.href = "view.php"; });	

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



<form name="newVolunteer" id="newVolunteer" method="post" action="new.php">



<table>

	<tr>

		<td style="width:50%;vertical-align:top">

			<fieldset>

				<legend>Volunteer Information</legend>

				<table>

					<tr>

						<td>First Name:</td>

						<td><input type="text" name="first-name" /></td>

					</tr>

					<tr>

						<td>Last Name:</td>

						<td><input type="text" name="last-name" /></td>

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