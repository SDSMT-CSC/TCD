<?php
$menuarea = "workshop";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
?>

<script>
$(function () {
	$( "#add-workshop" ).button().click(function(){ window.location.href = "view.php"; });
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

<form name="newWorkshop" id="newWorkshop" method="post" action="new.php">
	
<table>
	<tr>
		<td>
			<fieldset>
				<legend>Workshop Information</legend>
				<table>
					<tr>
						<td>Date:</td>
						<td><input type="text" name="date"/></td>
					</tr>
					<tr>
						<td>Time:</td>
						<td><input type="text" name="date"/></td>
					</tr>
					<tr>
						<td>Topic:</td>
						<td><input type="text" name="date"/></td>
					</tr>
					<tr>
						<td>Instructor:</td>
						<td><input type="text" name="date"/></td>
					</tr>
					<tr>
						<td>Officer:</td>
						<td><input type="text" name="date"/></td>
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