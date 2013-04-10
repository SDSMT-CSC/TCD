<?php 
$menuarea = "defendant";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
?>
<script src="/includes/js/dataTables.ajaxReload.js"></script>
<script>
jQuery(function($)
{	
	// if tab cookie is set, reset it to 0
	$.removeCookie('ui-tabs-1');
	
	$("#new-defendant").button().click(function() { window.location.href = "view.php"; });
	
	var oTable = $("#data-table").dataTable( { 
		"aaSorting": [],
		"aoColumnDefs" : [ { "aTargets": [0], "bVisible": false, "bSearchable": false }  ],
		"sPaginationType": "full_numbers",
		"bProcessing": false,
		"sAjaxSource": '/data/defendants_current.php',
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

<h1>Current Defendants</h1>

<table id="data-table">
	<thead>
			<tr>
				<th width="10">ID</th>
				<th width="75">Court Case#</th>
				<th width="75">Last Name</th>
				<th width="75">First Name</th>
				<th width="150">Location</th>
				<th width="150">Added</th>
				<th width="50"></th>
			</tr>
	</thead>
	<tbody></tbody>
</table>

<?php 
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>