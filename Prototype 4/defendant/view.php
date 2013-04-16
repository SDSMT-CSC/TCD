<?php
ob_start();
$menuarea = "defendant";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_data.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_defendant.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_location.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_school.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_guardian.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_citation.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_workshop.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_workshop_location.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_court.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_court_location.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_sentence.php");

$id = $_GET["id"];
$error;

$defendant = new Defendant();

// if the user is trying to go to a defendant that doesn't belong to
// their program, dont let them get the info
if( !$defendant->compareProgramID( $id, $user_programID) ) {
	echo "No defendant data to display";
}
else {
	if( isset($id) && !$error )
	{
			$action = "Edit Defendant";
			
			$defendant->getFromID( $id );
			$FirstName = $defendant->getFirstName();
			$LastName = $defendant->getLastName();
			$MiddleName = $defendant->getMiddleName();
			$PhoneNumber = $defendant->getPhoneNumber();
			$DOB = $defendant->getDateOfBirth();
			$CourtCaseNumber = $defendant->getCourtCaseNumber();
			$AgencyNumber = $defendant->getAgencyNumber();	
	} 
	else {	
		$action = "Add Defendant";
		$FirstName = NULL;
		$LastName = NULL;
		$MiddleName = NULL;
		$PhoneNumber = NULL;
		$DOB = NULL;
		$CourtCaseNumber = NULL;
		$AgencyNumber = NULL;
	}
?>

<? if( $user_type == 5 ) { ?>
<script type="text/javascript">
jQuery(function($) {	
	$('form :input').attr ( 'disabled', true );
	$('.select-location').css("display","none");
	$('#select-school-location').css("display","none");
	$('#add-common-location').css("display","none");
	$('#add-officer').css("display","none");
	$('.add').css("display","none");
	$('#add-existing-offense').css("display","none");
	$('#add-new-statute').css("display","none");
	$('#add-item').css("display","none");
	$('#add-vehicle').css("display","none");	
		 
	$('#add-defendant').attr ( 'disabled', true );
	$('#delete-defendant').attr ( 'disabled', true );
	$('#update-defendant').attr ( 'disabled', true );
	
});
</script>
<? } ?>

<script type="text/javascript" src="jquery.js"></script>

<div id="control-header">	
	<div class="left"><h1><? echo $action ?></h1></div>	
	<div class="right">
		<div id="control" class="ui-state-error">
			<button id="defendant-list">Back to List</button>
			<? if( $action == "Add Defendant") { ?>
			<button id="add-defendant">Add Defendant</button>
      <? } else { ?>
			<button id="delete-defendant">Delete Defendant</button>
			<button id="update-defendant">Update Defendant</button>
			<? } ?>
		</div>
	</div>
</div>

<div id="school-dialog" title="Add New School">
  <table id="school-table">
    <thead>
        <tr>
          <th>School</th>
          <th>Address</th>
          <th>City</th>
          <th>State</th>
          <th>Zip</th>
        </tr>
    </thead>
    <tbody></tbody>
  </table> 
</div>

<div id="location-dialog" title="Select Location">
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

<form name="defendant-primary" id="defendant-primary" method="post" action="process.php">
<input type="hidden" name="action" value="<? echo $action ?>" />
<input type="hidden" name="defendantID" value="<? echo $defendant->getDefendantID() ?>" />
<fieldset>
	<legend>Primary Defendant Information</legend>
  <table>
  	<tr>
    	<td width="50%" valign="top">
        <table width="100%">
          <tr>
            <td width="125">First Name:</td>
            <td><input type="text" name="firstname" value="<? echo $FirstName ?>" /></td>
          </tr>
          <tr>
            <td>Last Name:</td>
            <td><input type="text" name="lastname" value="<? echo $LastName ?>" /></td>
          </tr>
          <tr>
            <td>Middle Name:</td>
            <td><input type="text" name="middlename" value="<? echo $MiddleName ?>" /></td>
          </tr>
          <tr>
            <td>Date of Birth:</td>
            <td><input type="text" class="date" id="dob" name="dob" size="10" value="<? echo $DOB ?>" /></td>
          </tr>          
          <tr>
            <td>Phone Number:</td>
            <td><input type="text" class="phone" name="phoneNumber" value="<? echo $PhoneNumber ?>" /></td>
          </tr>
        </table>  
      </td>
      <td width="50%" valign="top">
        <table width="100%">
        	<? if( $defendant->added ) { 
					?>
          <tr>
          	<td height="28">Added: </td>
            <td><? echo $defendant->added; ?></td>
          </tr>
          <? } ?>
          <tr>
            <td width="125">Court Case #:</td>
            <td><input type="text" name="courtcase" size="10" value="<? echo $CourtCaseNumber ?>" /></td>
          </tr>
          <tr>
            <td>Agency Case #:</td>
            <td><input type="text" name="agencycase" size="10" value="<? echo $AgencyNumber ?>" /></td>
          </tr>
          <tr>
            <td height="28">Closed:</td>
            <td><? echo $defendant->getCloseDate(); ?></td>
          </tr>
          <tr>
            <td height="28">Expunged:</td>
            <td><? echo $defendant->getExpungeDate(); ?></td>
          </tr>
        </table>   
      </td>
     </tr>
  </table>
</fieldset>
</form>

<? 
unset( $action );
if( isset($id) ) { 
?>

<div id="tabs">
	<ul>
		<li><a href="#tab-personal">Personal</a></li>
		<li><a href="#tab-guardian">Guardian</a></li>
		<li><a href="#tab-citation">Citation</a></li>
		<li><a href="#tab-intake">Intake</a></li>
		<li><a href="#tab-court">Court</a></li>
		<li><a href="#tab-sentence">Sentence</a></li>
		<li><a href="#tab-workshop">Workshop</a></li>
		<li><a href="#tab-expunge">Expunge</a></li>
		<li><a href="#tab-forms">Forms</a></li>
		<li><a href="#tab-notes">Case Notes</a></li>
	</ul>
	<div id="tab-personal">
		<? include("tab_personal.php"); ?>	
	</div>
	<div id="tab-guardian">
		<? include("tab_guardian.php"); ?>
	</div>
	<div id="tab-citation">
		<? include("tab_citation.php"); ?>
	</div>
	<div id="tab-intake">
		<? include("tab_intake.php"); ?>
	</div>
	<div id="tab-court">
		<? include("tab_court.php"); ?>
	</div>
	<div id="tab-sentence">
		<? include("tab_sentence.php"); ?>
	</div>	
	<div id="tab-workshop">
		<? include("tab_workshop.php"); ?>
	</div>	
	<div id="tab-expunge">
		<? include("tab_expunge.php"); ?>
	</div>
	<div id="tab-forms">
		<? include("tab_forms.php"); ?>
	</div>
	<div id="tab-notes">
		<? include("tab_notes.php"); ?>
	</div>
</div>

<?
	} 
}
?>

<?php 
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>