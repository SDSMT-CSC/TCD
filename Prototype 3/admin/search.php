<?php
$menuarea = "volunteer";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
?>

<script>
jQuery(function($) {
	$("#data-table").dataTable( { 
				"aaSorting": [],
        "sPaginationType": "full_numbers",
				"bProcessing": true,
        "sAjaxSource": '/data/volunteer_listing.php'
	} );

	 $( "#accordion" ).accordion({
		 				active: false,
            collapsible: true,
						heightStyle: "content"
        });
});
</script>

<h1>Search All Volunteers</h1>

<div id="accordion">
	  <h3>Detailed Search</h3>
    <div>		
			<form name="searchProgram" id="searchProgram" method="post" action="search.php">
			<table>
				<tr>
					<td>Program Name:</td>
					<td><input type="text" name="name" /></td>
					<td>City:</td>
					<td><input type="text" name="city" /></td>
				</tr>
				<tr>
					<td>Address:</td>
					<td><input type="text" name="address" /></td>
					<td>Zip:</td>
					<td><input type="text" name="zip" /></td>
				</tr>
			</table>
			<div class="submitrow"><input type="submit" id="submit" name="submit" value="Search" /></div>
		</form>
		</div>
</div>

<table id="data-table">
	<thead>
			<tr>
				<th width="200">Program Name</th>
				<th width="100">City</th>
				<th width="50">State</th>
				<th width="125">Modify</th>
			</tr>
	</thead>
	<tbody>
	</tbody>
</table>

<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>