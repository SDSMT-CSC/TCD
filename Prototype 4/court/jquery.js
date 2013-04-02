jQuery(function($)
{	
	$("#tabs").tabs();
	$("#tabs").show(); 
	
	$("#court-list").button().click(function() { window.location.href = 'index.php' });
	$("#add-court").button();
	$("#delete-court").button();
	$("#update-court").button();
	$("#court-date").datepicker();
	$("#court-time").timepicker();
	
	$("#location-dialog").dialog({
		resizable: false,
		autoOpen:false,
		modal: true,
		width:450,
		height:250,
		buttons: {
			'Add Location': function() {
				$(this).dialog('close');
					// TO DO: add location
				},
			Cancel: function() {
				$(this).dialog('close');
			}
		}
	});

	$("#jury-member-dialog").dialog({
		resizable: false,
		autoOpen:false,
		modal: true,
		width:450,
		height:165,
		buttons: {
			'Add Jury Member': function() {
				$(this).dialog('close');
					// TO DO: add jury member
				},
			Cancel: function() {
				$(this).dialog('close');
			}
		}
	});
	
	$('#add-location').click(function(){ $('#location-dialog').dialog('open'); });
	$('#add-jury-member').click(function(){ $('#jury-member-dialog').dialog('open'); });
	
});