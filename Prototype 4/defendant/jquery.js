
jQuery(function($) {	

	/**************************************************************************************************
		BUTTON AND MAIN TAB SETUP
	**************************************************************************************************/
	$("#tabs").tabs({ cookie: { expires: 5 } });
  $("#tabs").show(); 

	// Top menu
	$("#update-defendant").button().click(function() { $("#defendant-primary").submit(); });
	$("#delete-defendant").button().click(function() {  });
	$("#defendant-list").button().click(function() {	window.location.href = "index.php";	});	
	$("#add-defendant").button().click(function() { $("#defendant-primary").submit(); });

	// TAB1: personal
	$("#dob").datepicker();
	$("#defendant-personal-submit").button().click(function() { $("#defendant-personal").submit(); });

	// TAB2: Guardian items
	$('#add-parent').click(function(){$('#parent-dialog').dialog('open');});
	$(".update-guardian").button();
	
	// TAB3: Citation items
	$("#citation-submit").button().click(function() { $("#citation").submit(); });
	$("#add-officer").click(function(){ $('#officer-dialog').dialog('open'); });
	$("#add-common-location").click(function(){ $('#common-location-dialog').dialog('open'); });
	$("#add-existing-offense").button().click(function(){ $('#offense-existing-dialog').dialog('open'); });
	$("#add-new-statute").button().click(function(){ $('#offense-new-statute').dialog('open'); });
	$("#add-item").button().click(function(){ $('#item-dialog').dialog('open'); });
	$("#add-vehicle").button().click(function(){ $('#vehicle-dialog').dialog('open'); });
	$("#citation-date").datepicker({maxDate: new Date});
	$("#citation-time").timepicker({showLeadingZero: false,showPeriod: true,defaultTime: ''});
	
	// TAB4: Intake
	$("#intake-submit").button().click(function() { $("#intake").submit(); });
	$("#intake-date").datepicker();
	$("#intake-time").timepicker({showLeadingZero: false,showPeriod: true,defaultTime: 'now'});
	$("#reschedule-date").datepicker();
	$("#reschedule-time").timepicker({showLeadingZero: false,showPeriod: true,defaultTime: 'now'});
	$("#referred-date").datepicker();
	$("#dismissed-date").datepicker();

	// TAB7: Workshop
	$("#create-workshop").button().click(function() {	window.location.href = "/workshop/view.php";	});	

	/**************************************************************************************************
		FORM VALIDATION
	**************************************************************************************************/
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
	
	$("#officer").validate({
		errorElement: "div",
		wrapper: "div",
		errorPlacement: function(error, element) {
			  error.insertAfter(element);
				error.addClass('message');
		},
		rules: {
			'officer-lastname': { required: true },
			'officer-firstname': { required: true }
		},
		submitHandler: function(form) {
			$.post('process.php', $(form).serialize(), function(data) {
				if( data > 0 )
					{
						// add the newly entered location to the dropdown and make is selected
						var name = $("#officer-lastname").val()+", "+$("#officer-firstname").val();
						$("#officerID").append($("<option selected></option>").attr("value",data).text(name)); 					
						
						// close dialog and clear form
						$("#officer-dialog").dialog('close');	
						$("#officer")[0].reset();
					}
			});
		}
	});	
	
	$("#citation").validate({
		errorElement: "div",
		wrapper: "div",
		errorPlacement: function(error, element) {
			  error.insertAfter(element);
				error.addClass('message');
		},
		rules: {
			'citation-date': { required: true },
			'citation-time': { required: true }
		}
	});	
	
	$("#statute").validate({
		errorElement: "div",
		wrapper: "div",
		errorPlacement: function(error, element) {
			  error.insertAfter(element);
				error.addClass('message');
		},
		rules: {
			'statute-code': { required: true },
			'statute-title': { required: true }
		}
	});	
	
	$("#item").validate({
		errorElement: "div",
		wrapper: "div",
		errorPlacement: function(error, element) {
			  error.insertAfter(element);
				error.addClass('message');
		},
		rules: { 'item-name': { required: true } }
	});
			
	/**************************************************************************************************
		DIALOG FUNCTIONALITY
	**************************************************************************************************/
	$("#parent-dialog").dialog({
			resizable: false,
			autoOpen:false,
			modal: true,
			width:820,
			buttons: {
				'Add Parent/Guardian': function() {
					$("#guardian-form").submit();
					},
				'Cancel': function() {
					$(this).dialog('close');
				}
			}
		});
		
	$("#school-dialog").dialog({
			resizable: false,
			autoOpen:false,
			modal: true,
			width:600,
			buttons: {
				'Cancel': function() {
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
				'Cancel': function() {
					$(this).dialog('close');
				}
			}	
		});

	$("#officer-dialog").dialog({
		 resizable: false,
		 autoOpen:false,
		 modal: true,
      width:475,
      buttons: {
				 'Add Officer': function() { $("#officer").submit()  },
				 'Cancel': function() { 
         		$(this).dialog('close'); 
         		$("#officer")[0].reset(); 
						$(".message").css("display","none");
        }
      }
    });

	$("#offense-existing-dialog").dialog({
			resizable: false,
			autoOpen:false,
			modal: true,
			width:600,
			buttons: {
				'Cancel': function() { 					
					resetDataTable( statuteTable );
					$(this).dialog('close');
				}
			}
		});
		
	$("#offense-new-statute").dialog({
			resizable: false,
			autoOpen:false,
			modal: true,
			width:600,
			buttons: {
				'Add Offense': function() { $("#statute").submit();	},
				'Cancel': function() { 
					$(this).dialog('close'); 
					$("#statute")[0].reset();
					$(".message").css("display","none");
				}
			}
		});
		
		$("#common-location-dialog").dialog({
			resizable: false,
			autoOpen:false,
			modal: true,
			width:450,
			buttons: {
				'Add Location': function() {
					$.post('process.php', $("#common-location-form").serialize(), function(data) {
						if( data > 0 )
						{
							// add the newly entered location to the dropdown and make is selected
							$("#common-location").append($("<option selected></option>").attr("value",data).text($("#common-location-name").val())); 					
							
							// close dialog and clear form
							$("#common-location-dialog").dialog('close');	
							$("#common-location-name")[0].reset();
						}
					});					
				},
				'Cancel': function() { 
					$(this).dialog('close');
					$("#common-location-name")[0].reset();				
				}
			}
		});
				
		$("#item-dialog").dialog({
			resizable: false,
			autoOpen:false,
			modal: true,
			width:475,
			buttons: {
				'Add Item': function() { $("#item").submit();	},
				'Cancel': function() { 
					$(this).dialog('close');
					$(".message").css("display","none");
				}
			}
		});
		
		$("#vehicle-dialog").dialog({
			resizable: false,
			autoOpen:false,
			modal: true,
			width:475,
			buttons: {
				'Add Vehicle': function() { $("#vehicle").submit(); },
				'Cancel': function() { $(this).dialog('close'); }
			}
		});
	
	/**************************************************************************************************
		CLICK FUNCTIONS
	**************************************************************************************************/
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
	
	/**************************************************************************************************
		DATA TABLE SETUP
	**************************************************************************************************/
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
	
	var statuteTable = $("#statute-table").dataTable( { 
				"aaSorting": [],
				"aoColumns" : [ 
					{ "bVisible": false, "bSearchable": false },  // statuteID
					{ sWidth: '20%' }, 										        // statute
					{ sWidth: '80%', sClass: "alignLeft" } ],     // description
				"sPaginationType": "full_numbers",
				"iDisplayLength": 5,
				"aLengthMenu": [[5, 10], [5, 10]],
				"bProcessing": false,
				"sAjaxSource": '/data/program_statutes.php'
	});
				
	var offenseList = $("#offense-listing").dataTable( { 
				"aaSorting": [],
				"aoColumns" : [ 
					{ "bVisible": false, "bSearchable": false },	// statuteID
					{ sWidth: '15%' },                            // statute
					{ sWidth: '80%', sClass: "alignLeft" },       // description
					{ sWidth: '5%', "bSearchable": false }        // remove link
				],
				"sPaginationType": "full_numbers",
				"bLengthChange": false,
				"bFilter": false,
				"bPaginate": false,
				"bInfo": false,
				"bDeferRender": false,
				"bProcessing": false,
				"sAjaxSource": '/data/citation_offenses.php?id='+$("#citation input[name='defendantID']").val()
	});
	
	/**************************************************************************************************
		DATA TABLE CLICK FUNCTIONALITY
	**************************************************************************************************/
	var address;	// used for tracking locations
	
	// Location dialog table
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
	
	// School dialog table
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
			
	// Offense dialog table
	$('#statute-table tbody tr').live('click', function (event) {
		var oData = statuteTable.fnGetData(this); // get datarow
	
		if (oData != null)  // null if we clicked on title row
		{
			// add record to database
			var defID = $("#citation input[name='defendantID']").val();
			$.post('process.php',{ action: 'Add Offense', statuteID: oData[0], defendantID: defID }, function(data) {
					// add to list if entered
					if( data > 0 ) {
						
						// build the delete string...again
						var delStr = '<a class="editor_remove" name="process.php?action=Delete Offense&defendantID='+defID+'&offenseID='+data+'">Delete</a>'
						
						offenseList.fnAddData( [ oData[0], oData[1], oData[2], delStr ] );
					}
			});
			
			// close the window
			$("#offense-existing-dialog").dialog('close');
		}
	});
	
	/**************************************************************************************************
		DELETE FUNCTIONALITY
	**************************************************************************************************/
	// Delete a offense
	$('a.editor_remove').live('click', function (event) {
			dTitle = 'Delete Offense';
			dMsg = 'Are you sure you want to delete this offense?';
			dHref = $(this).attr("name");
			popupDialog( dTitle, dMsg, dHref );
   });
	
	// Delete a guardian
	$(".delete-guardian").button().click(function() {
		dTitle = 'Delete Guardian';
		dMsg = 'Are you sure you want to delete this guardian?';
		dHref = $(this).val();
		popupDialog( dTitle, dMsg, dHref );
		return false;
	});
	
	// Delete an item
	$("a.delete-item").click(function() {
		dTitle = 'Delete Stolen Item';
		dMsg = 'Are you sure you want to delete this item?';
		dHref = $(this).attr("href");
		popupDialog( dTitle, dMsg, dHref );
		return false;
	});
	
	// Delete an vehicle
	$("a.delete-vehicle").click(function() {
		dTitle = 'Delete Vehicle';
		dMsg = 'Are you sure you want to delete this vehicle?';
		dHref = $(this).attr("href");
		popupDialog( dTitle, dMsg, dHref );
		return false;
	});
	
});