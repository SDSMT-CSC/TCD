<?php 
$menuarea = "defendant";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
?>

<script>
 $(function () {
	 
		$( "#previous-defendant" ).button().click(function() {		});
		$( "#update-defendant" ).button().click(function() {		});
		$( "#next-defendant" ).button().click(function() {		});
		
		
		$( ".delete" ).button();
		$( ".add" ).button();
		
		$("#expunged").datepicker();
		$("#closed").datepicker();
		$("#citation-date").datepicker();
		$(".listing tbody tr:even").css("background-color", "#EFF4F6");
		
		$("#school-dialog").dialog({
				resizable: true,
				autoOpen:false,
				modal: true,
				width:400,
				height:200,
				buttons: {
					'Add School': function() {
						$(this).dialog('close');
							// TO DO: add school
						},
					Cancel: function() {
						$(this).dialog('close');
					}
				}
			
			});
			
			$("#officer-dialog").dialog({
				resizable: true,
				autoOpen:false,
				modal: true,
				width:400,
				height:300,
				buttons: {
					'Add Officer': function() {
						$(this).dialog('close');
							// TO DO: add school
						},
					Cancel: function() {
						$(this).dialog('close');
					}
				}
			
			});
			
			$("#common-locatio-dialog").dialog({
				resizable: true,
				autoOpen:false,
				modal: true,
				width:400,
				height:200,
				buttons: {
					'Add Location': function() {
						$(this).dialog('close');
							// TO DO: add school
						},
					Cancel: function() {
						$(this).dialog('close');
					}
				}
			
			});
		
		$('#add-school').click(function(){
				$('#school-dialog').dialog('open');
		});
		
		$('#add-officer').click(function(){
				$('#officer-dialog').dialog('open');
		});
		
		$('#add-common-location').click(function(){
				$('#common-location-dialog').dialog('open');
		});
		
});
</script>

<div id="school-dialog" title="Add New School">
	<form>
		<label>School Name</label>
		<input type="text" name="school-name" />
	</form>
</div>

<div id="officer-dialog" title="Add New Officer">
	<form>
		<label>Officer ID</label>
		<input type="text" name="officer-id" /><br />
		<label>Last Name</label>
		<input type="text" name="officer-last-name" /><br />
		<label>First Initial</label>
		<input type="text" name="officer-first-name" />
	</form>
</div>

<div id="common-location-dialog" title="Add New Common Location">
	<form>
		<label>Common Location</label>
		<input type="text" name="common-location-name" />
	</form>
</div>

<form name="updateDefendant" id="updateDefendant" method="post">

<div id="control-header">
	
	<div class="left"><h1>Defendant Information</h1></div>	
	<div class="right">
		<div id="control" class="ui-state-error">
			<button id="previous-defendant">Previous</button>
			<button id="update-defendant">Update Defendant</button>
			<button id="next-defendant">Next</button>
		</div>
	</div>

</div>

<fieldset>
	<legend>Primary Defendant Information</legend>
	
	<table>
		<tr>
			<td>Last Name:</td>
			<td><input type="text" name="last-name" value="Doe" /></td>
			<td>Date of Birth:</td>
			<td><input type="text" name="last-name" size="10" value="05/25/1997" /></td>
			<td>Agency Case #:</td>
			<td><input type="text" name="agency-case" size="10" /></td>
		</tr>
		<tr>
			<td>First Name:</td>
			<td><input type="text" name="first-name" value="John" /> MI: <input type="text" name="middle" size="5" /></td>
			<td>Home Phone:</td>
			<td><input type="text" name="last-name" value="(605) 555-5555" /></td>
			<td>Court Case #:</td>
			<td><input type="text" name="court-case" size="10" value="1234" /></td>
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

	</div>
	<div id="tabs-court">

	</div>
	<div id="tabs-sentance">

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