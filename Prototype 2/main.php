<?php 
$menuarea = "main";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
?>

<script>
jQuery(function($)
{
	$("#data-table").dataTable( { 
				"aaSorting": [],
        "sPaginationType": "full_numbers",
				"bProcessing": true,
        "sAjaxSource": '/data/court_listing.php'
	} );

});
</script>

<h1>Upcoming Court Dates</h1>

<table id="data-table">
	<thead>
			<tr>
				<th width="50">Court#</th>
				<th width="125">Defendant</th>
				<th width="125">Date</th>
				<th width="150">Location</th>
				<th width="50">Modify</th>
			</tr>
	</thead>
	<tbody>

	</tbody>
</table>


<?php 
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>