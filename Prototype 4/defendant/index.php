<?php 
$menuarea = "defendant";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
?>

<script>
jQuery(function($)
{
	$("#new-defendant").button().click(function() { window.location.href = "view.php"; });
	
	$("#data-table").dataTable( { 
				"aaSorting": [],
        "sPaginationType": "full_numbers",
				"bProcessing": false,
        "sAjaxSource": '/data/defendants_current.php'
	} );

});
</script>


<div id="control-header">
	<div class="left"><h1>Active Defendants</h1></div>	
	<div class="right">
		<div id="control" class="ui-state-error">
			<button id="new-defendant">New Defendant</button>
		</div>
	</div>
</div>

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
	<tbody></tbody>
</table>

<?php 
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>