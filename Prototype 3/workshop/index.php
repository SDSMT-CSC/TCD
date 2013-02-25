<?php
$menuarea = "workshop";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
?>

<script>
jQuery(function($)
{
	$("#data-table").dataTable( { 
		"aaSorting": [],
        "sPaginationType": "full_numbers",
		"bProcessing": true,
        "sAjaxSource": '/data/workshop_listing.php'
	} );

});
</script>

<h1>Active Workshops</h1>

<table id="data-table">
	<thead>
			<tr>
				<th width="150">Date</th>
				<th width="150">Topic</th>
				<th width="125">Instructor</th>
				<th width="125">Officer</th>
				<th width="50">Modify</th>
			</tr>
	</thead>
	<tbody>

	</tbody>
</table>


<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>