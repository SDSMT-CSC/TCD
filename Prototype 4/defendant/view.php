<?php 
$menuarea = "defendant";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_defendant.php");

$id = $_GET["id"];
$error = 0;
$defendant = new Defendant();

if( isset($id) ) {
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

<? if( $error == 1 ) { ?>
<p>You do not have access to this page.</p>
<? } else { ?>

<script>
$(function () {

	$("#tabs").tabs();
  $("#tabs").show(); 

	$("#defendant-list").button().click(function() {	window.location.href = "index.php";	});	
	$("#add-defendant").button().click(function() { $("#defendant-primary").submit(); });
	
	$("#previous-defendant").button();
	$("#update-defendant").button().click(function() { $("#defendant-primary").submit(); });
	$("#delete-defendant").button().click(function() {  });
	$("#next-defendant").button().click(function() {	});
	
	$("#dob").datepicker();
	$("#citation-date").datepicker();
		
	$("#defendant-primary").validate({
		errorElement: "div",
		wrapper: "div",
		errorPlacement: function(error, element) {
			  error.insertAfter(element);
				error.addClass('message');
		},
		rules: {
			lastname: { required: true },
			firstname: { required: true },
			dob: { required: true },
			courtcase: { required: true }
		}
	});	
		
});

</script>


<div id="control-header">	
	<div class="left"><h1><? echo $action ?></h1></div>	
	<div class="right">
		<div id="control" class="ui-state-error">
			<button id="defendant-list">Back to List</button>
			<? if( $action == "Add Defendant") { ?>
			<button id="add-defendant">Add Defendant</button>
      <? } else { ?>
			<button id="previous-defendant">Previous</button>
			<button id="delete-defendant">Delete Defendant</button>
			<button id="update-defendant">Update Defendant</button>
			<button id="next-defendant">Next</button>
			<? } ?>
		</div>
	</div>
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
            <td><input type="text" name="dob" id="dob" size="10" value="<? echo $DOB ?>" /></td>
          </tr>          
          <tr>
            <td>Phone Number:</td>
            <td><input type="text" name="phoneNumber" value="<? echo $PhoneNumber ?>" /></td>
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

<? if( isset($id) ) { ?>
<div id="tabs">
	<ul>
		<li><a href="#tab-personal">Personal</a></li>
		<li><a href="#tab-parental">Parent</a></li>
		<li><a href="#tab-citation">Citation</a></li>
		<li><a href="#tab-intake">Intake</a></li>
		<li><a href="#tab-court">Court</a></li>
		<li><a href="#tab-sentance">Sentance</a></li>
		<li><a href="#tab-workshop">Workshop</a></li>
		<li><a href="#tab-expunge">Expunge</a></li>
		<li><a href="#tab-forms">Forms</a></li>
		<li><a href="#tab-notes">Case Notes</a></li>
	</ul>
	<div id="tab-personal">
		<? include("tab_personal.php"); ?>	
	</div>
	<div id="tab-parental">
		<? include("tab_parent.php"); ?>
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
	<div id="tab-sentance">
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
<? } ?>

<?php 
} // end error check

include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>