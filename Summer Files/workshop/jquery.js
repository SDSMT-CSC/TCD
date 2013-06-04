jQuery(function($) {
	
	$("#update-workshop" ).button().click(function() {	$("#editWorkshop").submit(); });
	$("#workshop-list").button().click(function() {	window.location.href = "index.php";	});

	$("#workshop-location-dialog").dialog({
		resizable: false,
		autoOpen:false,
		modal: true,
		width:550,
		buttons: {
			Cancel: function() {
				resetDataTable( workshopLocationTable );
				$(this).dialog('close');
			}
		}
	});
	
	$("#program-location-dialog").dialog({
		resizable: false,
		autoOpen:false,
		modal: true,
		width:550,
		buttons: {
			Cancel: function() {
				resetDataTable( locTable );
				$(this).dialog('close');
			}
		}
	});
	
	$("#participant-dialog").dialog({
		resizable: false,
		autoOpen:false,
		modal: true,
		width:500,
		buttons: {
			Cancel: function() {
				$(this).dialog('close');
			}
		}
	});
	
	var workshopLocationTable = $("#workshop-location-table").dataTable( { 
				"aaSorting": [],
				"sPaginationType": "full_numbers",
				"bProcessing": false,
				"sAjaxSource": '/data/workshop_location.php'
	});
	
	var locTable = $("#program-location-table").dataTable( { 
				"aaSorting": [],
				"sPaginationType": "full_numbers",
				"bProcessing": false,
				"sAjaxSource": '/data/program_locations.php'
	});
	
	var defTable = $("#defendant-table").dataTable( { 
				"aaSorting": [],
				"sPaginationType": "full_numbers",
				"bProcessing": false,
				"sAjaxSource": '/data/workshop_defendants.php'
	});
	defTable.fnSetColumnVis(2, false);
	
	$('#defendant-table tbody tr').live('click', function (event) {        
		var oData = defTable.fnGetData(this); // get datarow
		if (oData != null)  // null if we clicked on title row
		{
			$("#add").val(oData[2]);
			$("#addParticipant").submit();
		}
	});
	
	$('#workshop-location-table tbody tr').live('click', function (event) {        
		var oData = workshopLocationTable.fnGetData(this); // get datarow
		if (oData != null)  // null if we clicked on title row
		{
			$("#workshop-name").val(oData[0]);
			$("#workshop-address").val(oData[1]);
			$("#workshop-city").val(oData[2]);
			$("#workshop-state").val(oData[3]);
			$("#workshop-zip").val(oData[4]);
			$("#workshopLocationID").val(oData[5]);
			$("#workshop-location-dialog").dialog('close');
		}
	});
	
	$('#program-location-table tbody tr').live('click', function (event) {
		var oData = locTable.fnGetData(this);
		if (oData != null)
		{
			$("#workshop-city").val(oData[0]);
			$("#workshop-state").val(oData[1]);
			$("#workshop-zip").val(oData[2]);
			$('#program-location-dialog').dialog('close');
		}
	});
	
	$("#delete-workshop").button().click(function() {
		dTitle = 'Delete Workshop';
		dMsg = 'Are you sure you want to delete this workshop?';
		dHref = $(this).val();
		popupDialog( dTitle, dMsg, dHref );
		return false;
	});
	
	$('#workshop-location').button().click(function(){ $('#workshop-location-dialog').dialog('open'); });
	$('#program-location').button().click(function(){ $('#program-location-dialog').dialog('open'); });	
	$('#add-participant').click(function(){ $('#participant-dialog').dialog('open'); });
	$("#date").datepicker( );
	$("#time").timepicker({showPeriod: true,defaultTime: ''});
	
	$("#editWorkshop").validate({
		errorElement: "div",
		wrapper: "div",
		errorPlacement: function(error, element) {
			error.insertAfter(element);
			  error.addClass('message');
		},
		rules: {
			date: {	required: true },
			time: { required: true },
			title: { required: true },
			instructor: { required: true }
		}
	});
	
});