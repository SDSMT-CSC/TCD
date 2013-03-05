<?php
$menuarea = "volunteer";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
?>

<script>
jQuery(function($)
{
	$("#data-table").dataTable( { 
				"aaSorting": [],
        "sPaginationType": "full_numbers",
				"bProcessing": false,
        "sAjaxSource": '/data/volunteers.php'
	} );

});
</script>

<h1>Active Volunteers</h1>

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
	<tbody></tbody>
</table>

<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>