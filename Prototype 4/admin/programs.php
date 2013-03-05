<?php
$menuarea = "admin";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
?>

<script>
jQuery(function($)
{
	$( "#new-program" ).button().click(function() {	window.location.href = "view_program.php";	});
	
	$("#data-table").dataTable( { 
		"aaSorting": [],
    "sPaginationType": "full_numbers",
		"bProcessing": false,
    "sAjaxSource": '/data/programs.php'
	} );

});
</script>

<div id="control-header">
	<div class="left"><h1>Active Court Programs</h1></div>	
	<div class="right">
		<div id="control" class="ui-state-error">
			<button id="new-program">New Program</button>
		</div>
	</div>
</div>

<table id="data-table">
	<thead>
		<tr>
			<th width="50">Code</th>
			<th width="200">Program Name</th>
			<th width="100">City</th>
			<th width="50">State</th>
			<th width="50">Zip</th>
      <th width="50">Active</th>
			<th width="50">Modify</th>
		</tr>
	</thead>
	<tbody>

	</tbody>
</table>


<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>