<?php
$menuarea = "workshop";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_workshop.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_data.php");

$id = $_GET["id"];
if( isset($id) )
{
	$action = "Edit Volunteer";
	
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
	
	$locationName;
	$locationAddress;
	$locationCity;
	$locationState;
	$locationZip;
}
else
{
	//should not be here
	header("location:index.php");
}
?>

<script>
$(function () {	
	$( "#previous-workshop" ).button().click(function() {		});
	$( "#update-workshop" ).button().click(function() {		});
	$( "#next-workshop" ).button().click(function() {		});

	$("#participant-dialog").dialog({
		resizable: false,
		autoOpen:false,
		modal: true,
		width:500,
		height:400,
		buttons: {
			'Add Participant': function() {
				$(this).dialog('close');
				//tie selected participant to workshop
			},
			Cancel: function() {
				$(this).dialog('close');
			}
		}
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
			<td>Description:</td>
			<td><input type="text" name="description" value="<? echo $description ?>"/></td>
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
			<td>
				<input type="text" name="locationName" id="locationName" value="<? echo $locationName ?>"/>
				Address: <input type="text" name="address" id="address" value="<? echo $locationAddress ?>"/>
			</td>
		</tr>
		<tr>
			<td>City:</td>
			<td>
				<input type="text" name="city" id="city" value="<? echo $locationCity ?>"/>
				State:   <input type="text" name="state" id="state" value="<? echo $locationState ?>"/>
				Zip: <input type="text" name="zip" id="zip" value="<? echo $locationZip ?>"/>
			</td>
		</tr>
	</table>
</fieldset>
<fieldset>
	<legend>Workshop Participant</legend>
	<table class="listing">
		<thead>
			<tr>
				<th width="40%">Participant</th>
				<th width="40%">Phone</th>
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