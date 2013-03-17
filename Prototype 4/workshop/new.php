<?php
$menuarea = "workshop";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_data.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_workshop.php");

// make sure logged in user has access to edit this user
if( $user_programID != $program->getProgramID() )
{
	echo "NO ACCESS!";
}

//set variables to default
$data = new Data();
$action = "Add Workshop";
?>

<script>
$(function () {
	$("#location-dialog").dialog({
		resizable: false,
		autoOpen:false,
		modal: true,
		width:450,
		height:250,
		buttons: {
			'Add Location': function() {
				$(this).dialog('close');
					$("#location-form").submit();
				},
			Cancel: function() {
				$(this).dialog('close');
			}
		}
	});
	
	$("#list-location").dialog({
		resizable: false,
		autoOpen:false,
		modal: true,
		width:450,
		height:250,
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
	//courtLocationTable.fnSetColumnVis(5, false);
	
	$('#courtLocation-table tbody tr').live('click', function (event) {        
		var oData = courtLocationTable.fnGetData(this); // get datarow
		if (oData != null)  // null if we clicked on title row
		{
			$("#name").val(oData[0]);
			$("#address").val(oData[1]);
			$("#city").val(oData[2]);
			$("#state").val(oData[3]);
			$("#zip").val(oData[4]);
			$("#locationID").val(oData[5]);
			$("#list-location").dialog('close');
		}
	});
	
	$('#court-location').click(function(){ $('#list-location').dialog('open'); });
	$('#add-location').click(function(){ $('#location-dialog').dialog('open'); });
	$( "#add-workshop" ).button().click(function(){ $("#newWorkshop").submit(); });
	$("#date").datepicker();
});
</script>

<div id="list-location" title="Select Location">
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

<div id="location-dialog" title="Add New Location">
	<form id="location-form" action="process.php" method="post">
		<input type="hidden" name="action" value="Add Location" />
		<input type="hidden" name="programID" value=<? echo $user->getProgramID(); ?>
		<table>
			<tr>
				<td>Name</td>
				<td><input type="text" name="location-name" size="30" /></td>
			</tr>
			<tr>
				<td>Address:</td>
				<td><input type="text" name="location-address" size="30" /></td>
			</tr>
			<tr>
				<td>City:</td>
				<td><input type="text" name="location-city" /></td>
			</tr>
			<tr>
				<td>State:</td>
				<td><input type="text" name="location-state=" /></td>
			</tr>
			<tr>
				<td>Zip:</td>
				<td><input type="text" name="location-zip" /></td>
			</tr>
		</table>		
	</form>
</div>

<div id="control-header">
	
	<div class="left"><h1>Add New Workshop</h1></div>	
	<div class="right">
		<div id="control" class="ui-state-error">
			<button id="add-workshop">Add Workshop</button>
		</div>
	</div>
	
</div>

<form name="newWorkshop" id="newWorkshop" method="post" action="process.php">
<input type="hidden" name="action" value="<? echo $action ?>" />
<input type="hidden" name="programID" value="<?echo $user->getProgramID(); ?>" />
<input type="hidden" name="return" value="new.php" />
<input type="hidden" name="locationID" value="" />
	
<fieldset>
	<legend>Workshop Information</legend>
	<table>
		<tr>
			<td>Date:</td>
			<td><input type="text" name="date" value="<? echo date("m/d/Y") ?>"/></td>
		</tr>
		<tr>
			<td>Time:</td>
			<td><input type="text" name="time" value="<? echo date("g:i a") ?>"/></td>
		</tr>
		<tr>
			<td>Title:</td>
			<td><input type="text" name="title"/></td>
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
			<td><input type="text" name="locationName" id="name" value="<? echo $locationName ?>"/></td>
			<td>Address:</td>
			<td><input type="text" name="address" id="address" value="<? echo $locationAddress ?>"/></td>
		</tr>
		<tr>
			<td>City:</td>
			<td><input type="text" name="city" id="city" value="<? echo $locationCity ?>"/></td>
			<td>State:</td>
			<td><input type="text" name="state" id="state" value="<? echo $locationState ?>"/></td>
			<td>Zip:</td>
			<td><input type="text" name="zip" id="zip" value="<? echo $locationZip ?>"/></td>
		</tr>
	</table>
	<input type="button" class="add" id="court-location" value="List Locations" />
	<input type="button" class="add" id="add-location" value="Add Location" />
	</fieldset>
</form>

<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>