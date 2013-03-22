<?php
$menuarea = "workshop";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_workshop.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_courtLocation.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_data.php");

$id = $_GET["id"];
$workshop = new Workshop();
$data = new Data();
	
if( isset($id) )
{
	$action = "Edit Workshop";
	
	$workshop->getWorkshop($id);
	$date = $workshop->getDate();
	//break down date and time
	$splitDate = explode(" ", $date);
	$date = $splitDate[0];
	$time = $splitDate[1] . " " . $splitDate[2];
	$title = $workshop->getTitle();
	$instructor = $workshop->getInstructor();
	$description = $workshop->getDescription();
	$officerID = $workshop->getOfficerID();
	$courtLocationID = $workshop->getcourtLocationID();
	
	$courtLocation = new courtLocation();
	$courtLocation->getCourtLocation( $courtLocationID );
	
	$locationID = $courtLocation->getLocationID();
	$locationName = $courtLocation->getName();
	$locationAddress = $courtLocation->getAddress();
	$locationCity = $courtLocation->getCity();
	$locationState = $courtLocation->getState();
	$locationZip = $courtLocation->getZip();
}
else
{
	$action = "Add Workshop";
	$date = date("m/d/Y");
	$time = date("g:i A");
	$title = "";
	$instructor = "";
	$description = "";
	$officerID = 0;
	$courtLocationID = 0;
	$programID = 0;
	
	$locationID = 0;
	$locationName = "";
	$locationAddress = "";
	$locationCity = "";
	$locationState = "";
	$locationZip = "";
}
?>

<script type="text/javascript">
jQuery(function($) {
	
	$("#update-workshop" ).button().click(function() {	$("#editWorkshop").submit(); });
	$("#workshop-list").button().click(function() {	window.location.href = "index.php";	});

	$("#courtLocation-dialog").dialog({
		resizable: false,
		autoOpen:false,
		modal: true,
		width:550,
		height:450,
		buttons: {
			Cancel: function() {
				$(this).dialog('close');
			}
		}
	});
	
	$("#programLocation-dialog").dialog({
		resizable: false,
		autoOpen:false,
		modal: true,
		width:550,
		height:450,
		buttons: {
			'Add Location': function() {
				$(this).dialog('close');
					$("#courtLocation-form").submit();
				},
			Cancel: function() {
				$(this).dialog('close');
			}
		}
	});
	
	$("#participant-dialog").dialog({
		resizable: false,
		autoOpen:false,
		modal: true,
		width:500,
		height:400,
		buttons: {
			Cancel: function() {
				$(this).dialog('close');
			}
		}
	});
	
	var courtLocationTable = $("#courtLocation-table").dataTable( { 
				"aaSorting": [],
				"sPaginationType": "full_numbers",
				"bProcessing": false,
				"sAjaxSource": '/data/courtLocation.php'
	});
	
	var locTable = $("#programLocation-table").dataTable( { 
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
	
	$('#courtLocation-table tbody tr').live('click', function (event) {        
		var oData = courtLocationTable.fnGetData(this); // get datarow
		if (oData != null)  // null if we clicked on title row
		{
			$("#workshop-name").val(oData[0]);
			$("#workshop-address").val(oData[1]);
			$("#workshop-city").val(oData[2]);
			$("#workshop-state").val(oData[3]);
			$("#workshop-zip").val(oData[4]);
			$("#courtLocationID").val(oData[5]);
			$("#courtLocation-dialog").dialog('close');
		}
	});
	
	$('#programLocation-table tbody tr').live('click', function (event) {
		var oData = locTable.fnGetData(this);
		if (oData != null)
		{
			$("#location-city").val(oData[0]);
			$("#location-state").val(oData[1]);
			$("#location-zip").val(oData[2]);
		}
	});
	
	$("#delete-workshop").button().click(function() {
		dTitle = 'Delete Workshop';
		dMsg = 'Are you sure you want to delete this workshop?';
		dHref = $(this).val();
		popupDialog( dTitle, dMsg, dHref );
		return false;
	});
	
	$('#court-location').click(function(){ $('#courtLocation-dialog').dialog('open'); });
	$('#program-location').click(function(){ $('#programLocation-dialog').dialog('open'); });	
	$('#add-participant').click(function(){ $('#participant-dialog').dialog('open'); });
	$("#date").datepicker( );
	$("#time").timepicker({showLeadingZero: false,showPeriod: true,defaultTime: ''});
	
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
</script>

<div id="participant-dialog" title="Add Participant">
	<form name="addParticipant" id="addParticipant" method="post" action="process.php">
	<input type="hidden" name="workshopID" value="<? echo $workshop->getWorkshopID() ?>" />
	<input type="hidden" name="action" value="Add Participant" />
	<input type="hidden" name="add" id="add" value="" />
	<table id="defendant-table">
      <thead>
          <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Add</th>
          </tr>
      </thead>
      <tbody></tbody>
    </table>
	</form>
</div>

<div id="courtLocation-dialog" title="Select Location">
	<table id="courtLocation-table">
		<thead>
			<tr>
				<th>Name</th>
				<th>Address</th>
				<th>City</th>
				<th>State</th>
				<th>Zip</th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
</div>

<div id="programLocation-dialog" title="Add New Court Location">
	<form id="courtLocation-form" action="process.php" method="post">
		<input type="hidden" name="action" value="Add Location" />
		<input type="hidden" name="locationID" value="<? echo $locationID; ?>" />
		<input type="hidden" name="programID" value="<? echo $user->getProgramID(); ?>" />
		
		<? if ( isset($id) ) { ?>
		<input type="hidden" name="return" value="view.php?id=<? echo $id ?>" />
		<? } else { ?>
		<input type="hidden" name="return" value="view.php" />
		<? } ?>

		<table>
			<tr>
				<td>Name</td>
				<td><input type="text" name="location-name" id="location-name" size="30" /></td>
			</tr>
			<tr>
				<td>Address:</td>
				<td><input type="text" name="location-address" id="location-address" size="30" /></td>
			</tr>
			<tr>
				<td>City:</td>
				<td><input type="text" name="location-city" id="location-city" /></td>
			</tr>
			<tr>
				<td>State:</td>
				<td><input type="text" name="location-state" id="location-state" /></td>
			</tr>
			<tr>
				<td>Zip:</td>
				<td><input type="text" name="location-zip" id="location-zip" /></td>
			</tr>
		</table>
		<table id="programLocation-table">
	    <thead>
	        <tr>
	          <th>City</th>
	          <th>State</th>
	          <th>Zip</th>
	        </tr>
	    </thead>
	    <tbody></tbody>
	  </table>
	</form>
</div>

<div id="control-header">
	<div class="left"><h1><? echo $action ?></h1></div>
	<div class="right">
		<div id="control" class="ui-state-error">
			<button id="workshop-list">Back to List</button>
			<? if ( $action == "Edit Workshop") { ?>
			<button id="update-workshop">Update Workshop</button>
			<button class="delete-workshop" id="delete-workshop" value="process.php?action=Delete%20Workshop&id=<? echo $id; ?>" \>Delete Workshop</button>
			<? } else if ( $action == "Add Workshop") { ?>
			<button id="update-workshop">Add Workshop</button>
			<? } ?>
		</div>
	</div>
</div>

<form name="editWorkshop" id="editWorkshop" method="post" action="process.php">
<input type="hidden" name="courtLocationID" id="courtLocationID" value="<? echo $courtLocationID ?>" />
<input type="hidden" name="action" value="<? echo $action ?>" />
<? if ( $action == "Edit Workshop" ) { ?>
<input type="hidden" name="workshopID" value="<? echo $workshop->getWorkshopID() ?>" />
<? } else if ( $action == "Add Workshop" ) { ?>
<input type="hidden" name="programID" value="<? echo $user->getProgramID() ?>" />
<? } ?>

<fieldset>
	<legend>Workshop Information</legend>
  <table>
    <tr>
      <td width="50%" valign="top">
      	<table width="100%">
      		<tr>
			      <td width="125">Date:</td>
			      <td><input type="text" name="date" id="date" value="<? echo $date ?>"/></td>
			    </tr>
			    <tr>
			      <td>Title:</td>
			      <td><input type="text" name="title" id="title" value="<? echo $title ?>" /></td>
			    </tr>
			    <tr>
			      <td>Officer:</td>
			      <td>
			        <select name="officer" id="officer" />
			        <option></option>
			        <? echo $program->fetchOfficerDropdown( $officerID )?>
			        </select>
			      </td>
			    </tr>
      	</table>
      </td>
      <td width="50%" valign="top">
      	<table width="100%">
			    <tr>
			      <td width="125">Time:</td>
			      <td><input type="text" name="time" id="time" value="<? echo $time ?>"/></td>
			    </tr>
			    <tr>
			      <td>Instructor:</td>
			      <td><input type="text" name="instructor" id="instructor" value="<? echo $instructor ?>"/></td>
			    </tr>
			    <tr>
			      <td>Description:</td>
			      <td><textarea rows="3" col="100" name="description" id="description" /><? echo $description ?></textarea></td>
			    </tr>
			  </table>
			</td>
		</tr>
	</table>
</fieldset>

<fieldset>
	<legend>Workshop Location</legend>
	<table>
		<tr>
			<td>Name:</td>
			<td><input type="text" name="locationName" id="workshop-name" value="<? echo $locationName ?>"/></td>
			<td>Address:</td>
			<td><input type="text" name="address" id="workshop-address" value="<? echo $locationAddress ?>"/></td>
		</tr>
		<tr>
			<td>City:</td>
			<td><input type="text" name="city" id="workshop-city" value="<? echo $locationCity ?>"/></td>
			<td>State:</td>
			<td><input type="text" name="state" id="workshop-state" value="<? echo $locationState ?>"/></td>
			<td>Zip:</td>
			<td><input type="text" name="zip" id="workshop-zip" value="<? echo $locationZip ?>"/></td>
		</tr>
	</table>
	<input type="button" class="add" id="court-location" value="List Locations" />
	<input type="button" class="add" id="program-location" value="Add Location" />
</fieldset>

<? if ($action == "Edit Workshop") { ?>
<fieldset>
	<legend>Workshop Participant</legend>
	<table class="listing">
		<thead>
			<tr>
				<th width="30%">Participant</th>
				<th width="30%">Phone</th>
				<th width="20%">Completion</th>
				<th width="10%"></th>
				<th width="10%"></th>
			</tr>
		</thead>
		<tbody>
    <? echo $workshop->listWorkshopParticipants( $id ) ?>
	  </tbody>
	</table>
	<input type="button" class="add" id="add-participant" value="Add Participant" />
</fieldset>
<? }?>

</form>

<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>