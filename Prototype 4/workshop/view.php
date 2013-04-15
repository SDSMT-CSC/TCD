<?php
$menuarea = "workshop";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_workshop.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_workshop_location.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_data.php");

$id = $_GET["id"];
$workshop = new Workshop( $user_programID );
$data = new Data();
	
if( isset($id) )
{
	$action = "Edit Workshop";
	
	$workshop->getWorkshop($id);
		
	$date =  date("m/d/Y", $workshop->getDate() );
	$time = date("h:i A", $workshop->getDate() );
	$title = $workshop->getTitle();
	$instructor = $workshop->getInstructor();
	$description = $workshop->getDescription();
	$officerID = $workshop->getOfficerID();
	$workshopLocationID = $workshop->getworkshopLocationID();
	
	$courtLocation = new WorkshopLocation( $user_programID );
	$courtLocation->getWorkshopLocation( $workshopLocationID );
	
	$locationID = $courtLocation->locationID;
	$locationName = $courtLocation->name;
	$locationAddress = $courtLocation->address;
	$locationCity = $courtLocation->city;
	$locationState = $courtLocation->state;
	$locationZip = $courtLocation->zip;
}
else
{
	$action = "Add Workshop";
	$date = date("m/d/Y");
	$time = date("h:i A");
	$title = "";
	$instructor = "";
	$description = "";
	$officerID = 0;
	$workshopLocationID = 0;
	$programID = 0;
	
	$locationID = 0;
	$locationName = "";
	$locationAddress = "";
	$locationCity = "";
	$locationState = "";
	$locationZip = "";
}
?>

<? if( $user_type == 5 ) { ?>
<script type="text/javascript">
jQuery(function($) {  
  $('form :input').attr ( 'disabled', true );
  $('#workshop-location-dialog').css("display","none");
  $('#program-location-dialog').css("display","none");
  $('#participant-dialog').css("display","none");
  $('#delete-workshop').css("display","none");
  $('#workshop-location').css("display","none");
  $('#program-location').css("display","none");
  $('#add-participant').css("display","none");  
     
  $('#update-workshop').attr ( 'disabled', true );
  
});
</script>
<? } ?>

<script type="text/javascript" src="jquery.js"></script>

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

<div id="workshop-location-dialog" title="Select Existing Location">
	<table id="workshop-location-table">
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

<div id="program-location-dialog" title="Select Existing Location">
  <table id="program-location-table">
    <thead>
        <tr>
          <th>City</th>
          <th>State</th>
          <th>Zip</th>
        </tr>
    </thead>
    <tbody></tbody>
  </table>
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
<input type="hidden" name="action" value="<? echo $action ?>" />
<? if ( $action == "Edit Workshop" ) { ?>
<input type="hidden" name="workshopID" value="<? echo $workshop->getWorkshopID() ?>" />
<? } ?>

<fieldset>
	<legend>Workshop Information</legend>
  <table>
  	<tr>
    	<td colspan="2">
      	<table>
          <tr>
            <td width="75">Title:</td>
            <td><input type="text" name="title" id="title" style="width: 350px" value="<? echo $title ?>" /></td>
          </tr>
        </table>
      </td>
    </tr>
  	<tr>
    	<td valign="top" width="50%">
      	<table>
          <tr>
            <td>Date:</td>
            <td><input type="text" class="date" name="date" id="date" value="<? echo $date ?>"/></td>
          </tr>
          <tr>
            <td>Time:</td>
            <td><input type="text" class="time" name="time" id="time" value="<? echo $time ?>"/></td>
          </tr>
          <tr>
            <td width="75">Instructor:</td>
            <td><input type="text" name="instructor" id="instructor" value="<? echo $instructor ?>"/></td>
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
    	<td valign="top" width="50%">
      	<table>
          <tr>
            <td valign="top">Description:</td>
            <td><textarea style="width: 250px; height: 120px; font-size: 12px;" name="description" id="description" /><? echo $description ?></textarea></td>
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
      <td width="75">Name:</td>
      <td>
        <input type="text" name="locationName" id="workshop-name" style="width: 250px;" value="<? echo $locationName ?>"/>
        
        <a class="select-item ui-state-default ui-corner-all"  id="workshop-location" title="Select Existing Location">
          <span class="ui-icon ui-icon-newwin"></span>
        </a>        
      </td>
    </tr>
    <tr>
      <td>Address:</td>
      <td><input type="text" name="address" id="workshop-address" style="width: 250px;" value="<? echo $locationAddress ?>"/></td>
    </tr>
    <tr>
      <td>City:</td>
      <td>     
        <input type="text" name="workshop-city" id="workshop-city" value="<? echo $locationCity ?>" />
        State: <input type="text" name="workshop-state" id="workshop-state" size="2" value="<? echo $locationState ?>" />
        Zip: <input type="text" name="workshop-zip" id="workshop-zip" size="7" value="<? echo $locationZip ?>" />
        
        <a class="select-item ui-state-default ui-corner-all"  id="program-location" title="Select Existing Location">
          <span class="ui-icon ui-icon-newwin"></span>
        </a>
      </td>
    </tr>
  </table>
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
    <? 
		$data = $workshop->listWorkshopParticipants( $id, $user->getType() ) ;
		if( !$data ) {		
		?>
    <tr><td align="center" colspan="5">No Participants</td></tr>
    <? } else {  echo $data;	}	?>
	  </tbody>
	</table>
	<input type="button" class="add" id="add-participant" value="Add Participant" />
</fieldset>
<? }?>

</form>

<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>