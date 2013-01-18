<?php
$menuarea = "admin";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
?>

<script>
jQuery(function($)
{
	$("#data-table").dataTable( { 
				"aaSorting": [],
        "sPaginationType": "full_numbers",
				"bProcessing": true,
        "sAjaxSource": '/data/program_listing.php'
	} );

});
</script>

<h1>Active Court Programs</h1>

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