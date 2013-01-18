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
						<td>Access level:</td>
						<td><select name="type">
							<option>Admin</option>
							<option>Program Manager</option>
							<option>Program User</option>
							<option>Program Clerk</option>
						</select></td>
						<td>Associated Program:</td>
						<td><select name="program">
							<option></option>
							<option>Lawrence County Teen Court</option>
						</select></td>
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