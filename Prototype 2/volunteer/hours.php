<?php
$menuarea = "volunteer";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
?>

<script>
$(function () {
	$("#set-hours").button().click(function(){ window.location.href = "hours.php"; });	
});
</script>

<div id="control-header">
	
	<div class="left"><h1>Set Volunteer Hours</h1></div>	
	<div class="right">
		<div id="control" class="ui-state-error">
			<button id="set-hours">Set Hours</button>
		</div>
	</div>
	
</div>

<table>
	<tr>
		<td style="position:left">
			Select court date:
			<select>
				<option value="Court 1">12/3/12 3:30</option>
				<option value="Court 2">12/3/12 5:30</option>
			</select>
		</td>
	</tr>
</table>

<form name="newVolunteer" id="newVolunteer" method="post" action="new.php">
	
<table>
	<tr>
		<td>
			<fieldset>
				<legend>Set hours for court members</legend>
				<table>
					<tr>
						<td>Judge: </td>
						<td>Brianna Robertson</td>
						<td style="position:right"><input type="text" name="judge-hours" /></td>
					</tr>
					<tr>
						<td>Prosecutor: </td>
						<td>Roger Harris</td>
						<td><input type="text" name="prosecutor-hours" /></td>
					</tr>
					<tr>
						<td>Defense: </td>
						<td>Dana Nava</td>
						<td><input type="text" name="defense-hours" /></td>
					</tr>
					<tr>
						<td>Clerk: </td>
						<td>Brandon Gorney</td>
						<td><input type="text" name="clerk-hours" /></td>
					</tr>
					<tr>
						<td>Bailiff: </td>
						<td>Joey Smith</td>
						<td><input type="text" name="bailiff-hours" /></td>
					</tr>
					<tr>
						<td>Exit Interviewer: </td>
						<td>Daniel Roberts</td>
						<td><input type="text" name="exit-hours" /></td>
					</tr>
					<tr>
						<td>Advisor: </td>
						<td>Michael Fleming</td>
						<td><input type="text" name="advisor-hours" /></td>
					</tr>
				</table>
			</fieldset>
		</td>
	</tr>
	<tr>
		<td>
			<fieldset>
				<legend>Set hours for jury pool</legend>
				<table>
					<tr>
						<td></td>
						<td>Sarah Meyers</td>
						<td><input type="test" name="jury1" /></td>
					</tr>
					<tr>
						<td></td>
						<td>Leonard Drew</td>
						<td><input type="test" name="jury2" /></td>
					</tr>
					<tr>
						<td></td>
						<td>Jerry Adams</td>
						<td><input type="test" name="jury3" /></td>
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