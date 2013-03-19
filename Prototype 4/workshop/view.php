<?php
$menuarea = "workshop";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_workshop.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_courtLocation.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_data.php");

$id = $_GET["id"];
if( isset($id) )
{
	$action = "Edit Workshop";
	
	$workshop = new Workshop();
	$data = new Data();
	
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
	
	$locationName = $courtLocation->getName();
	$locationAddress = $courtLocation->getAddress();
	$locationCity = $courtLocation->getCity();
	$locationState = $courtLocation->getState();
	$locationZip = $courtLocation->getZip();
}
else
{
	//should not be here
	header("location:index.php");
}
?>

<script>
$(function () {	
	$( "#previous-workshop" ).button().click(function() {  });
	$( "#update-workshop" ).button().click(function() {	$("#editWorkshop").submit(); });
	$( "#next-workshop" ).button().click(function() {		});

	$("#courtLocation-dialog").dialog({
		resizable: false,
		autoOpen:false,
		modal: true,
		width:550,
		height:250,
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
	
	$('#court-location').click(function(){ $('#courtLocation-dialog').dialog('open'); });
	$('#program-location').click(function(){ $('#programLocation-dialog').dialog('open'); });	
	$('#add-participant').click(function(){ $('#participant-dialog').dialog('open'); });
	$("#date").datepicker( );
	$("#time").timepicker({showLeadingZero: false,showPeriod: true,defaultTime: ''});
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
		<input type="hidden" name="programID" value=<? echo $user->getProgramID(); ?> />
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
	<div class="left"><h1>Edit Workshop</h1></div>	
	<div class="right">
		<div id="control" class="ui-state-error">
			<button id="previous-workshop">Previous</button>
			<button id="update-workshop">Update</button>
			<button id="next-workshop">Next</button>
		</div>
	</div>
</div>

<form name="editWorkshop" id="editWorkshop" method="post" action="process.php">
<input type="hidden" name="action" value="<? echo $action ?>" />
<input type="hidden" name="workshopID" value="<?echo $workshop->getWorkshopID() ?>" />
<input type="hidden" name="return" value="new.php" />

<fieldset>
	<legend>Workshop Information</legend>
	<table>
		<tr>
			<td>Date:</td>
			<td><input type="text" name="date" id="date" value="<? echo $date ?>"/></td>
		</tr>
		<tr>
			<td>Time:</td>
			<td><input type="text" name="time" id="time" value="<? echo $time ?>"/></td>
		</tr>
		<tr>
			<td>Title:</td>
			<td><input type="text" name="title" value="<? echo $title ?>"/></td>
		</tr>
		<tr>
			<td>Instructor:</td>
			<td><input type="text" name="instructor" value="<? echo $instructor ?>"/></td>
		</tr>
		<tr>
			<td>Officer:</td>
			<td>
				<select name="officer"/>
				<? echo $data->fetchOfficerDropdown( $user_programID, $officerID )?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Description:</td>
			<td><input type="text" name="description" value="<? echo $description ?>"/></td>
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
			<? echo $workshop->listWorkshopParticipants( $id ); ?>
		</tbody>
	</table>
	<input type="button" class="add" id="add-participant" value="Add Participant" />
</fieldset>

</form>

<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>