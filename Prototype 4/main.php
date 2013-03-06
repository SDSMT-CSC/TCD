<?php 
$menuarea = "main";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
?>
<script src="/includes/js/dataTables.ajaxReload.js"></script>

<script>
jQuery(function($)
{
	// build data table
	 var oTable = $('#data-table').dataTable( {
				"aaSorting": [],
    		"sPaginationType": "full_numbers",
        "sAjaxSource": '/data/courts_upcoming.php',
        "fnServerData": function ( sSource, aoData, fnCallback ) {
            // use ajax to get the source data
            $.ajax( {
                "dataType": 'json',
                "type": "GET",
                "url": sSource,
                "cache": false,
                "data": aoData,
                "success": fnCallback
            } );
        }
    } );

		// refresh the dataTable every 10 seconds
    var newtimer = setInterval( function () { oTable.fnReloadAjax(); }, 10000 );
});
</script>

<h1>Upcoming Court Dates</h1>

<table id="data-table">
	<thead>
		<tr>
			<th width="100">Court Case#</th>
			<th width="75">Last Name</th>
			<th width="75">First Name</th>
			<th width="125">Date</th>
			<th width="150">Location</th>
			<th width="50">Modify</th>
		</tr>
	</thead>
	<tbody></tbody>
</table>

<?php 
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>