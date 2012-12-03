<?php
$menuarea = "volunteer";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
?>

<script>
$(function () {
	$("#search-volunteer").button().click(function(){ window.location.href = "search.php"; });	

	$("#data-table").dataTable( { 
				"aaSorting": [],
        "sPaginationType": "full_numbers",
				"bProcessing": true,
        "sAjaxSource": '/data/volunteer_listing.php'
	} );

});
</script>

<div id="control-header">
	
	<div class="left"><h1>Search Volunteers</h1></div>	
	<div class="right">
		<div id="control" class="ui-state-error">
			<button id="search-volunteer">Search</button>
		</div>
	</div>
	
</div>

<form name="searchVolunteer" id="searchVolunteer" method="post" action="search.php">
<fieldset>
	<legend>Volunteer Information</legend>
	<table>
		<tr>
			<td>First Name:</td>
			<td><input type="text" name="first-name" /></td>
			<td>Phone #:</td>
			<td><input type="text" name="phone" size="10" /></td>
		</tr>
		<tr>
			<td>Last Name:</td>
			<td><input type="text" name="last-name" /></td>
			<td>Email:</td>
			<td><input type="text" name ="email"/></td>
		</tr>
	</table>
</fieldset>
</form>

<div>
	<table id="data-table">
		<thead>
				<tr>
					<th width="50">Volunteer#</th>
					<th width="75">First Name</th>
					<th width="75">Last Name</th>
					<th width="125">Phone#</th>
					<th width="150">Email</th>
					<th width="125">Modify</th>
				</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>

<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>