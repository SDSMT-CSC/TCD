<?php
$menuarea = "workshop";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
?>

<script>
jQuery(function($) {
	$("#data-table").dataTable( { 
				"aaSorting": [],
        "sPaginationType": "full_numbers",
				"bProcessing": true,
        "sAjaxSource": '/data/workshop_listing.php'
	} );

	 $( "#accordion" ).accordion({
		 				active: false,
            collapsible: true,
						heightStyle: "content"
        });
});
</script>

<h1>Search All Workshops</h1>

<div id="accordion">
	  <h3>Detailed Search</h3>
    <div>		
			<form name="searchWorkshop" id="searchWorkshop" method="post" action="search.php">
			<table>
				<tr>
					<td>Date:</td>
					<td><input type="text" name="date" /></td>
					<td>Instructor:</td>
					<td><input type="text" name="instructor"/></td>
					<td>Active:</td>
					<td>
							<select name="active">
								<option>Yes</option>
								<option>No</option>
							</select>
					</td>
				</tr>
				<tr>
					<td>Time:</td>
					<td><input type="text" name="time" /></td>
					<td>Officer:</td>
					<td><input type="text" name ="officer"/></td>
					<td>Topic:</td>
					<td><input type="text" name ="topic"/></td>
				</tr>
			</table>
			<div class="submitrow"><input type="submit" id="submit" name="submit" value="Search" /></div>
		</form>
		</div>
</div>

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

<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>