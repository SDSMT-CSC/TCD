<?
$menuarea = "court";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_location.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_court.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_court_location.php");

$id = $_GET["id"];
$error = 0;

// $court = new Court();

if( isset($id) ) {
	$action = "Edit Court";
	
	$court = new Court( $user_programID );
	$court->getFromID( $id );
	
} 
else {	
	$action = "Add Court";

}
?>

<script type="text/javascript" src="jquery.js"></script>

<div id="court-defendant-dialog" title="Select Defendant">
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

<div id="jury-member-dialog" title="Add New Jury Member">
	<form>
		<table>
			<tr>
				<td>Available Jury Members:
				<td>			
					<select id="jury-members" name="jury-members">
						<option>Gorney, Brandon (Volunteer)</option>
						<option>Drew, Leonard (Volunteer)</option>
						<option>Doe, John (Defendant)</option>
					</select>
				</td>
			</tr>
		</table>		
	</form>
</div>

<div id="control-header">
	<div class="left"><h1><? echo $action ?></h1></div>	
	<div class="right">
		<div id="control" class="ui-state-error">
			<button id="court-list">Back to List</button>
			<? if( $action == "Add Court") { ?>
			<button id="add-court">Add Court</button>
      <? } else { ?>
			<button id="delete-court">Delete Court</button>
			<button id="update-court">Update Court</button>
			<? } ?>
		</div>
	</div>
</div>

<form name="court-primary" id="court-primary" method="post" action="process.php">
	<input type="hidden" name="action" value="<? echo $action ?>" />
  <fieldset>
    <legend>Court Information</legend>
    <table>
      <tr>
        <td width="70%">
          <table>		
            <tr>
              <td width="100">Defendant: </td>
              <td>
              	<input type="hidden" id="court-defendantID" name="court-defendantID" />
                <input type="text" id="court-defendant" name="court-defendant" style="width: 200px;" value="" readonly="readonly" >
                
                <a class="select-item ui-state-default ui-corner-all"  id="court-defendant-select" title="Select Defendant">
                  <span class="ui-icon ui-icon-newwin"></span>
                </a>        
              </td>
            </tr>
            <tr>
              <td>Court Date: </td>
              <td><input type="text" name="court-date" id="court-date" value=""></td>
            </tr>
            <tr>
              <td>Court Time: </td>
              <td><input type="text" name="court-time" id="court-time" value=""></td>
            </tr>
          </table>
        </td>
        <td width="30%" valign="top">
          <table>
            <tr>
              <td width="125">Court Type: </td>
              <td>
                <select id="court-type" name="court-type">
                  <option>Trial</option>
                  <option>Hearing</option>
                </select>
              </td>
            </tr>
            <tr>
              <td>Contract Signed? </td>
              <td>
                <select id="court-contract" name="court-contract">
                  <option>Yes</option>
                  <option>No</option>
                </select>
              </td>
            </tr>
            <tr>
            	<td>Closed: </td>
              <td><input type="checkbox" name="court-closed" value="yes" /></td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </fieldset>

</form>

<?
unset( $action );
if( $id ) { 
?>

<div id="tabs">
	<ul>
		<li><a href="#tabs-location">Court Location</a></li>
		<li><a href="#tabs-members">Court Members</a></li>
		<li><a href="#tabs-jury">Jury Members</a></li>
		<li><a href="#tabs-guardians">Parents/Guardians</a></li>
	</ul>
	<div id="tabs-location">
		<? include("tab_location.php"); ?>	
	</div>
	<div id="tabs-members">
		<? include("tab_members.php"); ?>	
	</div>
	<div id="tabs-jury">
		<? include("tab_jury.php"); ?>	
	</div>
	<div id="tabs-guardians">
		<? include("tab_guardians.php"); ?>	
	</div> 
</div>

<? } ?>

<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>