jQuery(function($) {
	$("#my-program").button().click(function() {	window.location.href = "program.php";	});	
	$("#edit-locations-dialog").button().click(function(){ $('#location-dialog').dialog('open'); });
	
	$("#location-dialog").dialog({
			resizable: false,
			autoOpen:false,
			modal: true,
			width:750,
			buttons: {
				'Cancel': function() {
					resetDataTable( locTable );
					$(this).dialog('close');
				}
			}	
		});
		
		
	var locTable = $("#location-table").dataTable( { 
				"aaSorting": [],
				"sPaginationType": "full_numbers",
				"bProcessing": false,
				"sAjaxSource": '/data/program_locations.php'
	});
	
	$('#location-table tbody tr').live('click', function (event) {        
		var oData = locTable.fnGetData(this); // get datarow
		if (oData != null)  // null if we clicked on title row
		{
			$("#location-city").val(oData[0]);
			$("#location-state").val(oData[1]);
			$("#location-zip").val(oData[2]);
		}
});