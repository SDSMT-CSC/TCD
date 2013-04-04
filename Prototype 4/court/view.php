<?
$menuarea = "court";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");

$id = $_GET["id"];
$error = 0;

// $court = new Court();

if( isset($id) ) {
	$action = "Edit Court";
	
	
} 
else {	
	$action = "Add Court";

}
?>

<? if( $error == 1 ) { ?>
<p>You do not have access to this page.</p>
<? } else { ?>

<script type="text/javascript" src="jquery.js"></script>

<div id="court-location-dialog" title="Select Existing Location">
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



<div id="jury-member-dialog" title="Add New Jury Member">
	<form>
		<table>
			<tr>
				<td>Available Jury Members:
				<td>			
					<select id="court-defendant" name="court-defendant">
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

<form name="updateCourt" id="updateCourt" >
  <fieldset>
    <legend>Court Information</legend>
    <table>
      <tr>
        <td>
          <table>		
            <tr>
              <td>Defendant: </td>
              <td>
                <select id="court-defendant" name="court-defendant">
                	<option></option>
                </select>
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
        <td>
          <table>
            <tr>
              <td>Court Type: </td>
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
              <td>Court Location: </td>
              <td>
                <select id="court-location" name="court-location">
                
                </select>
                <a id="add-location" style="cursor:pointer;">+</a>
              </td>
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
		<li><a href="#tabs-members">Court Members</a></li>
		<li><a href="#tabs-jury">Jury Members</a></li>
		<li><a href="#tabs-guardians">Parents/Guardians</a></li>
	</ul>
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
} // end error check

include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>