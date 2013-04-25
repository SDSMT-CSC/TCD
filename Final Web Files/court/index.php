<?
$menuarea = "court";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
?>
<script src="/includes/js/dataTables.ajaxReload.js"></script>
<script>
jQuery(function($)
{
	// if tab cookie is set, reset it to 0
	$.removeCookie('ui-tabs-1');
	
	var oTable = $("#data-table").dataTable( { 
		"aaSorting": [],
    "sPaginationType": "full_numbers",
		"bProcessing": false,
    "sAjaxSource": '/data/courts.php?type=current',
			"fnServerData": function ( sSource, aoData, fnCallback ) {
					// use ajax to get the source data
					$.ajax( {
							"dataType": 'json',
							"type": "GET",
							"url": sSource,
							"cache": false,
							"data": aoData,
							"success": fnCallback
			});
		}
	});

	// refresh the dataTable every 10 seconds
	var newtimer = setInterval( function () { oTable.fnReloadAjax(); }, 10000 );
});
</script>

<h1>Court Management</h1>

<table id="data-table">
	<thead>
			<tr>
				<th width="75">Court Case#</th>
				<th width="75">Last Name</th>
				<th width="75">First Name</th>
				<th width="125">Date</th>
				<th width="150">Place</th>
				<th width="150">Location</th>
				<th width="50"></th>
			</tr>
	</thead>
	<tbody></tbody>
</table>

<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>