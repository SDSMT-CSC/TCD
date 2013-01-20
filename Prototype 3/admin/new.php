<?php
$menuarea = "admin";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
?>

<script>
$(function () {
	$( "#add-program" ).button().click(function(){ window.location.href = "view.php"; });
});
</script>

<div id="control-header">
	
	<div class="left"><h1>Add New Court Program</h1></div>	
	<div class="right">
		<div id="control" class="ui-state-error">
			<button id="add-program">Add Program</button>
		</div>
	</div>
	
</div>

<form name="newProgram" id="newProgram" method="post" action="new.php">

<table>
	<tr>
		<td style="width:50%;vertical-align:top">
			<fieldset>
				<legend>Court Program Information</legend>
				<table>
					<tr>
						<td>Court Name:</td>
						<td><input type="text" name="name"/></td>
					</tr>
					<tr>
						<td>Program Address</td>
						<td><input type="text" name="pAddress"/></td>
					</tr>
					<tr>
						<td>Program City</td>
						<td><input type="text" name="pCity"/></td>
					</tr>
					<tr>
						<td>Program State</td>
						<td><input type="text" name="pState"/></td>
					</tr>
					<tr>
						<td>Program Zip</td>
						<td><input type="text" name="pZip"/></td>
					</tr>
				</table>
			</fieldset>
		</td>
		<td style="width:50%">
			<fieldset>
				<legend>Court Mailing Information</legend>
				<table>
					<tr>
						<td>Copy over Physical Address: <input type="checkbox" name="copy" /></td>
					</tr>
					<tr>
						<td>Mailing Address</td>
						<td><input type="text" name="mAddress"/></td>
					</tr>
					<tr>
						<td>Mailing City</td>
						<td><input type="text" name="mCity"/></td>
					</tr>
					<tr>
						<td>Mailing State</td>
						<td><input type="text" name="mState"/></td>
					</tr>
					<tr>
						<td>Mailing Zip</td>
						<td><input type="text" name="mZip"/></td>
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