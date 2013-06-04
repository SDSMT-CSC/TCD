<?
$menuarea = "court";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_defendant.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_location.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_court.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_court_location.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_guardian.php");

$id = $_GET["id"];
$court = new Court( $user_programID );

if( isset($id) && $court->compareProgramID( $id, $user_programID) ){
  	$action = "Edit Court";
  	
  	$court->getFromID( $id );
  	
  	$courtDate = date("m/d/Y", $court->courtDate );
  	$courtTime = date("h:i A", $court->courtDate );
  	$courtType = $court->type;
  	$courtLocationID = $court->courtLocationID;
    $courtCases = $court->checkCases();
  	
  	// location name
  	$courtLocation = new CourtLocation( $user_programID );
  	$courtLocation->getCourtLocation( $courtLocationID );
  	$locationName = $courtLocation->name;
  	$locationAddress = $courtLocation->address;
  	$locationCity = $courtLocation->city;
  	$locationState = $courtLocation->state;
  	$locationZip = $courtLocation->zip;
  	unset( $courtLocation );	
}
else {	
	$action = "Add Court";

	$defendantID = NULL;
	$defendantName = NULL;
	$courtDate = NULL;
	$courtType = NULL;
	$contract = NULL;
	$closedDate = NULL;
	$courtLocationID = NULL;
	$locationName = NULL;
	$locationAddress = NULL;
	$locationCity = NULL;
	$locationState = NULL;
	$locationZip = NULL;
}
?>

<? if( $user_type == 5 ) { ?>
<script type="text/javascript">
jQuery(function($) {  
  $('form :input').attr ( 'disabled', true );
  $('#court-defendant-select').css("display","none");
  $('#court-location').css("display","none");
  $('#program-location').css("display","none");
  $('#update-court-members').css("display","none");
  $('.add').css("display","none");
  $('#add-jury-members').css("display","none");
  $('#update-court-guardians').css("display","none");
     
  $('#add-court').attr ( 'disabled', true );
  $('#update-court').attr ( 'disabled', true );
  $('#delete-court').attr ( 'disabled', true );
  $('a.delete-juror').attr ( 'disabled', true );
  
});
</script>
<? } ?>

<script type="text/javascript" src="jquery.js"></script>

<div id="court-defendant-dialog" title="Select Defendant">
  <form name="add-defendant" id="add-defendant" method="post" action="process.php">
  <input type="hidden" name="courtID" value="<? echo $court->getCourtID() ?>" />
  <input type="hidden" name="action" value="Add Participant" />
  <input type="hidden" name="add" id="add" value="" />
	<table id="court-defendant-table">
		<thead>
			<tr>
				<th>ID</th>
				<th>Court Case#</th>
				<th>Last Name</th>
				<th>First Name</th>
				<th>Location</th>
				<th>Added</th>
				<th>View</th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
	</form>
</div>

<div id="court-location-dialog" title="Select Existing Location">
	<table id="court-location-table">
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

<div id="location-dialog" title="Select Existing Location">
  <table id="location-table">
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
			<button id="court-list">Back to List</button>
			<? if( $action == "Add Court") { ?>
			<button id="add-court">Add Court</button>
      <? } else { ?>
      <button id="delete-court" value="process.php?action=Delete+Court&id=<? echo $id  ?>">Delete Court</button>
      <button id="court-hours">Court Hours</button>
			<button id="update-court">Update Court</button>
			<? } ?>
		</div>
	</div>
</div>

<form name="court-primary" id="court-primary" method="post" action="process.php">
	<input type="hidden" name="action" value="<? echo $action ?>" />
  <? if( isset($id) && $court->compareProgramID( $id, $user_programID) ) { ?>
  <input type="hidden" name="courtID" id="courtID" value="<? echo $id ?>" />
  <? } ?>
  <fieldset>
    <legend>Court Information</legend>
    <table>
      <tr>
        <td width="100">Name:</td>
        <td>
          <input type="text" name="court-name" id="court-name" style="width: 250px;" value="<? echo $locationName ?>"/>
          
          <a class="select-item ui-state-default ui-corner-all"  id="court-location" title="Select Existing Location">
            <span class="ui-icon ui-icon-newwin"></span>
          </a>        
        </td>
        <td>Court Date: </td>
        <td><input type="text" class="date" name="court-date" id="court-date" value="<? echo $courtDate ?>"></td>
      </tr>
      <tr>
        <td>Address:</td>
        <td><input type="text" name="court-address" id="court-address" style="width: 250px;" value="<? echo $locationAddress ?>"/></td>
        <td>Court Time: </td>
        <td><input type="text" class="time" name="court-time" id="court-time" value="<? echo $courtTime ?>"></td>
      </tr>
      <tr>
        <td>City:</td>
        <td>     
          <input type="text" name="court-city" id="court-city" value="<? echo $locationCity ?>" />
          State: <input type="text" name="court-state" id="court-state" size="2" value="<? echo $locationState ?>" />
          Zip: <input type="text" name="court-zip" id="court-zip" size="7" value="<? echo $locationZip ?>" />
          
          <a class="select-item ui-state-default ui-corner-all"  id="program-location" title="Select Existing Location">
            <span class="ui-icon ui-icon-newwin"></span>
          </a>
        </td>
        <td width="125">Court Type: </td>
        <td>
          <select id="court-type" name="court-type">
            <option<? if($courtType == "Trial/Hearing") echo " selected"; ?>>Trial/Hearing</option>
            <option<? if($courtType == "Truancy") echo " selected"; ?>>Truancy</option>
            <option<? if($courtType == "Peer Bond") echo " selected"; ?>>Peer Bond</option>
          </select>
        </td>
      </tr>
    </table>
  </fieldset>
</form>

<?
unset( $action );
if( isset($id) && $court->compareProgramID( $id, $user_programID) ){
//check if cases exist
if( !$courtCases ) {
?>
<p style="padding: 10px">This court has no assigned cases.</p>
<? } else { ?>
<fieldset>
  <legend>Court Cases</legend>
  <table class="listing" id="case-listing">
    <thead>
      <tr>
        <th width="20%">First Name</th>
        <th width="20%">Last Name</th>
        <th width="20%">Positions Entered?</th>
        <th width="20%">View</th>
        <th width="20%">Remove</th>
      </tr>
    </thead>
    <tbody>
    <?
    foreach( $courtCases as $row )
    { ?>
      <tr>
        <td><? echo $row["firstName"]; ?></td>
        <td><? echo $row["lastName"]; ?></td>
        <td><? if ($row["timeEntered"] != 0) 
                 echo "YES";
               else
	               echo "No"; ?></td>
	      <td><? echo '<a class="view-case" href="hour_entry.php?id='.$row["court_caseID"].'">View</a>'?></td>
	      <td>
	      <?  if ($user_type != 5) 
                 echo '<a class="delete-case" href="process.php?action=Delete+Case&courtID='.$id.'&id='.$row["court_caseID"].'">Delete</a>' 
	      ?>
	      </td>
      </tr>
    <? } ?>
    </tbody>
  </table>
</fieldset>
<? } ?>
<button id="court-defendant-select">Assign Defendant</button>
<?

}
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>