jQuery(function($) {

	/**************************************************************************************************
		BUTTON AND MAIN TAB SETUP
	**************************************************************************************************/
	$("#tabs").tabs();
	$("#tabs").show(); 
	$("#court-date").datepicker();
	$("#court-time").timepicker({showLeadingZero: false,showPeriod: true,defaultTime: ''});
	
	// Top menu
	$("#court-list").button().click(function() { window.location.href = 'index.php' });
	$("#add-court").button().click(function() { $("#court-primary").submit(); });
	$("#update-court").button().click(function() { $("#court-primary").submit(); });
	$("#delete-court").button();
	
	$('#add-location').click(function(){ $('#location-dialog').dialog('open'); });
	$('#add-jury-member').click(function(){ $('#jury-member-dialog').dialog('open'); });
	
	$('#court-defendant-select').button().click(function(){ $('#court-defendant-dialog').dialog('open'); });	
	$('#court-location').button().click(function(){ $('#court-location-dialog').dialog('open'); });
	$('#program-location').button().click(function(){ $('#location-dialog').dialog('open'); });	
	$('#update-court-members').button().click(function() { $("#court-members").submit(); });
	
	/**************************************************************************************************
		FORM VALIDATION
	**************************************************************************************************/
	
	$("#court-primary").validate({
		errorElement: "div",
		wrapper: "div",
		errorPlacement: function(error, element) {
			  error.insertAfter(element);
				error.addClass('message');
		},
		rules: {
			'court-defendant': { required: true },
			'court-date': { required: true },
			'court-time': { required: true }
		}
	});	
	
	/**************************************************************************************************
		DIALOG FUNCTIONALITY
	**************************************************************************************************/
	$("#court-defendant-dialog").dialog({
		resizable: false,
		autoOpen:false,
		modal: true,
		width:650,
		buttons: {
			Cancel: function() {
				resetDataTable( courtDefendantTable );
				$(this).dialog('close');
			}
		}
	});
	
	$("#location-dialog").dialog({
		resizable: false,
		autoOpen:false,
		modal: true,
		width:500,
		buttons: {
			Cancel: function() {
				resetDataTable( locTable );
				$(this).dialog('close');
			}
		}
	});
	
	$("#court-location-dialog").dialog({
		resizable: false,
		autoOpen:false,
		modal: true,
		width:650,
		buttons: {
			Cancel: function() {
				resetDataTable( courtLocationTable );
				$(this).dialog('close');
			}
		}
	});

	$("#jury-member-dialog").dialog({
		resizable: false,
		autoOpen:false,
		modal: true,
		width:450,
		buttons: {
			Cancel: function() {
				$(this).dialog('close');
			}
		}
	});
	
	
	/**************************************************************************************************
		DATA TABLE SETUP
	**************************************************************************************************/
	var courtDefendantTable = $("#court-defendant-table").dataTable( { 
				"aaSorting": [],
				"aoColumnDefs" : [ 
					{ "aTargets": [0], "bVisible": false, "bSearchable": false },
					{ "aTargets": [5], "bVisible": false, "bSearchable": false }  
				],
				"sPaginationType": "full_numbers",
				"bProcessing": false,
				"sAjaxSource": '/data/defendants_current.php'
	});
	
	var locTable = $("#location-table").dataTable( { 
				"aaSorting": [],
				"sPaginationType": "full_numbers",
				"bProcessing": false,
				"sAjaxSource": '/data/program_locations.php'
	});
	
	var courtLocationTable = $("#court-location-table").dataTable( { 
				"aaSorting": [],
				"sPaginationType": "full_numbers",
				"bProcessing": false,
				"sAjaxSource": '/data/court_location.php'
	});
	
	/**************************************************************************************************
		DATA TABLE CLICK FUNCTIONALITY
	**************************************************************************************************/
	$('#court-defendant-table tbody tr').live('click', function (event) {
		var oData = courtDefendantTable.fnGetData(this);
		if (oData != null)
		{
			$("#court-defendantID").val(oData[0]);
			$("#court-defendant").val( oData[2] + ', ' + oData[3] );
			$("#court-defendant-dialog").dialog('close');
		}
	});
	
	$('#court-location-table tbody tr').live('click', function (event) {        
		var oData = courtLocationTable.fnGetData(this); // get datarow
		if (oData != null)  // null if we clicked on title row
		{
			$("#court-name").val(oData[0]);
			$("#court-address").val(oData[1]);
			$("#court-city").val(oData[2]);
			$("#court-state").val(oData[3]);
			$("#court-zip").val(oData[4]);
			$("#court-location-dialog").dialog('close');
		}
	});
	
	$('#location-table tbody tr').live('click', function (event) {
		var oData = locTable.fnGetData(this);
		if (oData != null)
		{
			$("#court-city").val(oData[0]);
			$("#court-state").val(oData[1]);
			$("#court-zip").val(oData[2]);
			$('#location-dialog').dialog('close');
		}
	});
	
	
});
