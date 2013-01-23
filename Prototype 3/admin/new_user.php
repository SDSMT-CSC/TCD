<?php
$menuarea = "admin";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
?>

<script>
$(function () {
	$( "#add-user" ).button().click(function(){ window.location.href = "view_user.php"; });
});
</script>

<div id="control-header">
	
	<div class="left"><h1>Add New User</h1></div>	
	<div class="right">
		<div id="control" class="ui-state-error">
			<button id="add-user">Add User</button>
		</div>
	</div>
	
</div>

<form name="newUser" id="newUser" method="post" action="new.php">

<table>
	<tr>
		<td>
			<fieldset>
				<legend>User Information</legend>
				<table>
					<tr>
						<td>First Name:</td>
						<td><input type="text" name="name"/></td>
						<td>Last Name:</td>
						<td><input type="text" name="pAddress"/></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><input type="text" name="email"/></td>
						<td>Password:</td>
						<td><input type="text" name="password"/></td>
					</tr>
					<tr>
						<td>Associated Program:</td>
						<td><select name="program">
							<option></option>
							<option>Lawrence County Teen Court</option>
						</select></td>
						<td></td>
						<td></td>
					</tr>
				</table>
			</fieldset>
			<fieldset>
				<legend>User Type</legend>
				<table>
					<tr>
						<td>Access level:</td>
						<td><input type="checkbox" name="userLevel" value="admin"/> Site Admin</td>
						<td><input type="checkbox" name="userLevel" value="programAdmin"/> Program Admin</td>
						<td><input type="checkbox" name="userLevel" value="programManager"/> Program Manager</td>
						<td><input type="checkbox" name="userLevel" value="programuser"/> Program User</td>
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