<?php 
$menuarea = "defendant";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
?>

<script>
jQuery(function($)
{
	$("#data-table").dataTable( { 
				"aaSorting": [],
        "sPaginationType": "full_numbers",
				"bProcessing": true,
        "sAjaxSource": '/data/defendant_listing_current.php'
	} );

});
</script>

<h1>Active Defendants</h1>

<table id="data-table">
	<thead>
			<tr>
				<th width="50">Citation#</th>
				<th width="75">Court Case#</th>
				<th width="75">Last Name</th>
				<th width="75">First Name</th>
				<th width="125">Location</th>
				<th width="150">Added</th>
				<th width="50"></th>
			</tr>
	</thead>
	<tbody>

	</tbody>
</table>

<?php 
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>