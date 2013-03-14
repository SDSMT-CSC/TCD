
jQuery(function($) {	

	$("#tabs").tabs({ cookie: { expires: 5 } });
  $("#tabs").show(); 

	$("#previous-defendant").button();
	$("#update-defendant").button().click(function() { $("#defendant-primary").submit(); });
	$("#delete-defendant").button().click(function() {  });
	$("#next-defendant").button().click(function() {	});

	$("#defendant-list").button().click(function() {	window.location.href = "index.php";	});	
	$("#add-defendant").button().click(function() { $("#defendant-primary").submit(); });
	$("#citation-submit").button().click(function() { $("#citation").submit(); });
		
	$("#add-officer").click(function(){ $('#officer-dialog').dialog('open'); });
	$("#add-common-place").click(function(){ $('#common-place-dialog').dialog('open'); });
	$("#add-offense").click(function(){ $('#offense-dialog').dialog('open'); });
	$("#add-item").click(function(){ $('#item-dialog').dialog('open'); });
	$("#add-vehicle").click(function(){ $('#vehicle-dialog').dialog('open'); });
	
	$("#dob").datepicker();
	$("#citation-date").datepicker({maxDate: new Date});
	$("#citation-time").timepicker({showLeadingZero: false,showPeriod: true,defaultTime: ''});
		
	$("#defendant-primary").validate({
		errorElement: "div",
		wrapper: "div",
		errorPlacement: function(error, element) {
			  error.insertAfter(element);
				error.addClass('message');
		},
		rules: {
			lastname: { required: true },
			firstname: { required: true },
			dob: { required: true },
			courtcase: { required: true }
		}
	});	
		
	$("#defendant-personal-submit").button().click(function() { $("#defendant-personal").submit(); });
			
	$("#school-dialog").dialog({
			resizable: false,
			autoOpen:false,
			modal: true,
			width:600,
			buttons: {
				Cancel: function() {
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
					$(this).dialog('close');
				}
			}	
		});
		
	$("#officer-dialog").dialog({
			resizable: false,
			autoOpen:false,
			modal: true,
			width:400,
			buttons: {
				'Add Officer': function() {
					$(this).dialog('close');
						// TO DO: add school
					},
				Cancel: function() {
					$(this).dialog('close');
				}
			}
		});
		
		$("#common-place-dialog").dialog({
			resizable: false,
			autoOpen:false,
			modal: true,
			width:450,
			buttons: {
				'Add Location': function() {
					$(this).dialog('close');
						// TO DO: add school
					},
				Cancel: function() {
					$(this).dialog('close');
				}
			}
		});
		
		$("#offense-dialog").dialog({
			resizable: false,
			autoOpen:false,
			modal: true,
			width:600,
			height:200,
			buttons: {
				'Add Offense': function() {
					$(this).dialog('close');
						// TO DO: add offense
					},
				Cancel: function() {
					$(this).dialog('close');
				}
			}
		});
		
		$("#item-dialog").dialog({
			resizable: false,
			autoOpen:false,
			modal: true,
			width:400,
			height:200,
			buttons: {
				'Add Item': function() {
					$(this).dialog('close');
						// TO DO: add stolen item
					},
				Cancel: function() {
					$(this).dialog('close');
				}
			}
		});
		
		$("#vehicle-dialog").dialog({
			resizable: false,
			autoOpen:false,
			modal: true,
			width:400,
			height:310,
			buttons: {
				'Add Vehicle': function() {
					$(this).dialog('close');
						// TO DO: add vehicle
					},
				Cancel: function() {
					$(this).dialog('close');
				}
			}
		});
	
	$("#sameaddress").click(function() {
			if($(this).is(':checked')) {
				$("#mailing-address").val($("#physical-address").val());
				$("#mailing-city").val($("#physical-city").val());
				$("#mailing-state").val($("#physical-state").val());
				$("#mailing-zip").val($("#physical-zip").val());
			}
	});
	
	$('#select-school-location').click(function(){
			$('#school-dialog').dialog('open');
			$('.ui-dialog :button').blur();
	});
	
	$('.select-location').click(function(){
			address = $(this).attr('id');
			$('#location-dialog').dialog('open');
			$('.ui-dialog :button').blur();
	});
			
	var locTable = $("#location-table").dataTable( { 
				"aaSorting": [],
				"sPaginationType": "full_numbers",
				"bProcessing": false,
				"sAjaxSource": '/data/program_locations.php'
	});
	
	var schoolTable = $("#school-table").dataTable( { 
				"aaSorting": [],
				"sPaginationType": "full_numbers",
				"bProcessing": false,
				"sAjaxSource": '/data/program_schools.php'
	});
	
	var address;
	$('#location-table tbody tr').live('click', function (event) {        
		var oData = locTable.fnGetData(this); // get datarow
		if (oData != null)  // null if we clicked on title row
		{
						
			// set input values
			if( address == "physical-location" ) 
			{
				$("#physical-city").val(oData[0]);
				$("#physical-state").val(oData[1]);
				$("#physical-zip").val(oData[2]);
			}
			else if( address == "mailing-location" )
			{
				$("#mailing-city").val(oData[0]);
				$("#mailing-state").val(oData[1]);
				$("#mailing-zip").val(oData[2]);
			}
			else if( address == "guardian-plocation" )
			{
				$("#guardian-physical-city").val(oData[0]);
				$("#guardian-physical-state").val(oData[1]);
				$("#guardian-physical-zip").val(oData[2]);
			}
			else if( address == "guardian-mlocation" )
			{
				$("#guardian-mailing-city").val(oData[0]);
				$("#guardian-mailing-state").val(oData[1]);
				$("#guardian-mailing-zip").val(oData[2]);
			}
			else if( address == "citation-location" )
			{
				$("#citation-city").val(oData[0]);
				$("#citation-state").val(oData[1]);
				$("#citation-zip").val(oData[2]);
			}
			
			for( i = 1; i <= $("#totalGuardians").val(); i++ )
			{
				if( address == 'guardian-plocation-'+i )
				{
					 $("#guardian-physical-city-"+i).val(oData[0]);
					 $("#guardian-physical-state-"+i).val(oData[1]);
					 $("#guardian-physical-zip-"+i).val(oData[2]);
				}
				else if( address == 'guardian-mlocation-'+i )
				{
					 $("#guardian-mailing-city-"+i).val(oData[0]);
					 $("#guardian-mailing-state-"+i).val(oData[1]);
					 $("#guardian-mailing-zip-"+i).val(oData[2]);
				}
			}
			
			// close the window
			$("#location-dialog").dialog('close');
		}
	});
	
	$('#school-table tbody tr').live('click', function (event) {        
		var oData = schoolTable.fnGetData(this); // get datarow
		if (oData != null)  // null if we clicked on title row
		{
				$("#school-name").val(oData[0]);
				$("#school-address").val(oData[1]);
				$("#school-city").val(oData[2]);
				$("#school-state").val(oData[3]);
				$("#school-zip").val(oData[4]);
			
			// close the window
			$("#school-dialog").dialog('close');
		}
	});
	
	$("#parent-dialog").dialog({
			resizable: false,
			autoOpen:false,
			modal: true,
			width:820,
			buttons: {
				'Add Parent/Guardian': function() {
					$("#guardian-form").submit();
					},
				Cancel: function() {
					$(this).dialog('close');
				}
			}
		});
		
	$('#add-parent').click(function(){$('#parent-dialog').dialog('open');});
	
	$("#SameAsDefendant").click(function() {
		if($(this).is(':checked')) {
			$("#guardian-physical-address").val($("#physical-address").val());
			$("#guardian-physical-city").val($("#physical-city").val());
			$("#guardian-physical-state").val($("#physical-state").val());
			$("#guardian-physical-zip").val($("#physical-zip").val());
			$("#guardian-mailing-address").val($("#mailing-address").val());
			$("#guardian-mailing-city").val($("#mailing-city").val());
			$("#guardian-mailing-state").val($("#mailing-state").val());
			$("#guardian-mailing-zip").val($("#mailing-zip").val());
		}
	});
	
	$(".update-guardian").button();		
	$(".delete-guardian").button().click(function() {
		dTitle = 'Delete Guardian';
		dMsg = 'Are you sure you want to delete this guardian?';
		dHref = $(this).val();
		popupDialog( dTitle, dMsg, dHref );		
		return false;
	});
		
	function popupDialog( dTitle, dMsg, dHref )
	{
		$("#confirm-dialog").find("p:first").html(dMsg);
		
		var dlg = $("#confirm-dialog").dialog({
			autoOpen: false,
			title: dTitle,
			modal: true,
			buttons: {
					'Delete': function() {
						window.location.href = dHref;
					},
					Cancel: function() {
						$(this).dialog('close');
					}
				}
		});	
		
		dlg.dialog('open');
	}
		
});