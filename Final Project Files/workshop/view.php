<?php
$menuarea = "workshop";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
?>

<script>
$(function () {
	$( "#previous-workshop" ).button().click(function() {		});
	$( "#update-workshop" ).button().click(function() {		});
	$( "#next-workshop" ).button().click(function() {		});
});
</script>

<div id="control-header">
	
	<div class="left"><h1>Add New Volunteer</h1></div>	
	<div class="right">
		<div id="control" class="ui-state-error">
			<button id="previous-workshop">Previous</button>
			<button id="update-workshop">Update</button>
			<button id="next-workshop">Next</button>
		</div>
	</div>
	
</div>

<form name="newWorkshop" id="newWorkshop" method="post" action="new.php">
	

<fieldset>
	<legend>Workshop Information</legend>
	<table>
		<tr>
			<td>Date:</td>
			<td><input type="text" name="date" value="12/18/2012"/></td>
		</tr>
		<tr>
			<td>Time:</td>
			<td><input type="text" name="date" value="7:30 PM"/></td>
		</tr>
		<tr>
			<td>Topic:</td>
			<td><input type="text" name="date" value="Alcohol Recovery"/></td>
		</tr>
		<tr>
			<td>Instructor:</td>
			<td><input type="text" name="date" value="Marlene Todd"/></td>
		</tr>
		<tr>
			<td>Officer:</td>
			<td><input type="text" name="date" value="Mark Williams"/></td>
		</tr>
	</table>
</fieldset>

<fieldset>
	<legend>Workshop Participant</legend>
	<table class="listing">
		<thead>
			<tr>
				<th width="75%">Participant</th>
				<th width="20%">Phone</th>
				<th width="5%"></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Adams, Sam</td>
				<td>(605) 555-5555</td>
				<td><a href="view.php">Remove</a></td>
			</tr>
			<tr>
				<td>Jones, Tom</td>
				<td>(605) 555-5555</td>
				<td><a href="view.php">Remove</a></td>
			</tr>
		</tbody>
	</table>
	<input type="button" class="add" value="Add Participant">
</fieldset>

</form>

<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>