<?php 
$menuarea = "defendant";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
?>

<script>
jQuery(function($)
{
	$("#tabs").tabs();
  $("#tabs").show(); 

	$("#previous-defendant").button();
	$("#update-defendant").button().click(function() {  });
	$("#delete-defendant").button().click(function() {  });
	$("#next-defendant").button().click(function() {	});
		
	$("#expunged").datepicker();
	$("#closed").datepicker();
	$("#citation-date").datepicker();
		
});

</script>


<div id="control-header">	
	<div class="left"><h1>Defendant Information</h1></div>	
	<div class="right">
		<div id="control" class="ui-state-error">
			<button id="previous-defendant">Previous</button>
			<button id="delete-defendant">Delete</button>
			<button id="update-defendant">Update</button>
			<button id="next-defendant">Next</button>
		</div>
	</div>
</div>

<form name="updateDefendant" id="updateDefendant" method="post">

<fieldset>
	<legend>Primary Defendant Information</legend>
	
	<table>
		<tr>
			<td>Last Name:</td>
			<td><input type="text" name="last-name" value="Doe" /></td>
			<td>Date of Birth:</td>
			<td><input type="text" name="last-name" size="10" value="05/25/1997" /></td>
			<td>Court Case #:</td>
			<td><input type="text" name="court-case" size="10" value="1234" /></td>
		</tr>
		<tr>
			<td>First Name:</td>
			<td><input type="text" name="first-name" value="John" /> MI: <input type="text" name="middle" size="5" /></td>
			<td>Home Phone:</td>
			<td><input type="text" name="last-name" value="(605) 555-5555" /></td>
			<td>Agency Case #:</td>
			<td><input type="text" name="agency-case" size="10" /></td>
		</tr>
		<tr>
			<td colspan="2"></td>
			<td>Expunged:</td>
			<td><input type="text" name="expunged" id="expunged" /></td>
			<td>Closed:</td>
			<td><input type="text" name="closed" id="closed" /></td>
		</tr>
	</table>
	
</fieldset>

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


</form>

<?php 
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>