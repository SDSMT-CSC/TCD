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
		<li><a href="#tabs-personal">Personal</a></li>
		<li><a href="#tabs-parental">Parent</a></li>
		<li><a href="#tabs-citation">Citation</a></li>
		<li><a href="#tabs-intake">Intake</a></li>
		<li><a href="#tabs-court">Court</a></li>
		<li><a href="#tabs-sentance">Sentance</a></li>
		<li><a href="#tabs-expunge">Expunge</a></li>
		<li><a href="#tabs-forms">Forms</a></li>
		<li><a href="#tabs-notes">Case Notes</a></li>
	</ul>
	<div id="tabs-personal">
		<? include("tab_personal.php"); ?>	
	</div>
	<div id="tabs-parental">
		<? include("tab_parent.php"); ?>
	</div>
	<div id="tabs-citation">
		<? include("tab_citation.php"); ?>
	</div>
	<div id="tabs-intake">
		<? include("tab_intake.php"); ?>
	</div>
	<div id="tabs-court">
		<? include("tab_court.php"); ?>
	</div>
	<div id="tabs-sentance">
		<? include("tab_sentence.php"); ?>
	</div>	
	<div id="tabs-expunge">

	</div>
	<div id="tabs-forms">

	</div>
	<div id="tabs-notes">

	</div>
</div>


</form>

<?php 
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>