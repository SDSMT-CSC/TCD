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
	$( "#add-workshop" ).button().click(function(){ $("#newWorkshop").submit(); });
	$("#date").datepicker();
});
</script>

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
<input type="hidden" name="courtLocationID" id="courtLocationID" value="" />
	
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
</form>

<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>