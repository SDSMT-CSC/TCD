<?php
$menuarea = "workshop";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
?>
<script src="/includes/js/dataTables.ajaxReload.js"></script>
<script>
jQuery(function($)
{
	var oTable = $("#data-table").dataTable( { 
		"aaSorting": [],
    "sPaginationType": "full_numbers",
		"bProcessing": false,
    "sAjaxSource": '/data/workshops.php',
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
  var newtimer = setInterval( function() { oTable.fnReloadAjax(); }, 10000 );
});
</script>

<h1>Active Workshops</h1>

<table id="data-table">
	<thead>
			<tr>
				<th width="15%">Date</th>
				<th width="20%">Topic</th>
				<th width="15%">Instructor</th>
        <th width="25%">Venue</th>
				<th width="20%">Location</th>
				<th width="5%"></th>
			</tr>
	</thead>
	<tbody></tbody>
</table>

<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>