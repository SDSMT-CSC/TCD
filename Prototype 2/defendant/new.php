<?php

if( $_POST )
{
	header("location: view.php");
}

$menuarea = "defendant";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
?>

<script>
jQuery(function($) {
	$("#add-defendant").button().click(function(){ window.location.href = "view.php"; });
	$("#tabs").tabs();
	
	$("#school-dialog").dialog({
				resizable: true,
				autoOpen:false,
				modal: true,
				width:400,
				height:150,
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
	
	$('#add-school').click(function(){
			$('#school-dialog').dialog('open');
	});
	
});
</script>

<div id="school-dialog" title="Add New School">
	<form>
		<label>School Name</label>
		<input type="text" name="school-name" />
	</form>
</div>

<div id="control-header">
	
	<div class="left"><h1>Add New Defendant</h1></div>	
	<div class="right">
		<div id="control" class="ui-state-error">
			<button id="add-defendant">Add Defendant</button>
		</div>
	</div>

</div>

<form name="newDefendant" id="newDefendant" method="post" action="new.php" >

<fieldset>
	<legend>Primary Defendant Information</legend>
	
	<table>
		<tr>
			<td>Last Name:</td>
			<td><input type="text" name="last-name" /></td>
			<td>Date of Birth:</td>
			<td><input type="text" name="last-name" size="10" /></td>
			<td>Court Case #:</td>
			<td><input type="text" name="court-case" size="10" /></td>
		</tr>
		<tr>
			<td>First Name:</td>
			<td><input type="text" name="first-name" /> MI: <input type="text" name="middle" size="5" /></td>
			<td>Home Phone:</td>
			<td><input type="text" name="last-name" /></td>
			<td>Agency Case #:</td>
			<td><input type="text" name="agency-case" size="10" /></td>
		</tr>
	</table>
	
</fieldset>

<div id="tabs">
	<ul>
		<li><a href="#tabs-personal">Personal</a></li>
	</ul>
	<div id="tabs-personal">
	<table>
		<tr>
			<td width="600" valign="top">
				<fieldset>
					<legend>Physical Address</legend>
					<table>
						<tr>
							<td>Street:</td>
							<td><input type="text" name="physical-street" size="40" /></td>
						</tr>
						<tr>
							<td>City:</td>
							<td>
								<input type="text" name="physical-city" /> State: 
								<select name="physical-state">
									<option>ND</option>
									<option selected="selected">SD</option>
									<option>WY</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Zip:</td>
							<td><input type="text" name="physical-zip" /></td>
						</tr>
						
					</table>
				</fieldset>
				
				<fieldset>
					<legend>Mailing Address</legend>
					<table>
						<tr>
							<td></td>
							<td><input type="checkbox" />  Same as physical address</td>
						</tr>
						<tr>
							<td>Street:</td>
							<td><input type="text" name="mailing-street" size="40" /></td>
						</tr>
						<tr>
							<td>City:</td>
							<td>
								<input type="text" name="mailing-city" value="Deadwood" /> State: 
								<select name="mailing-state">
									<option>ND</option>
									<option>SD</option>
									<option>WY</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Zip:</td>
							<td><input type="text" name="mailing-zip" /></td>
						</tr>						
					</table>
				</fieldset>
				
				<fieldset>
					<legend>School</legend>
					<table>
						<tr>
							<td>School:</td>
							<td>
								<select name="ethnicity" style="width: 300px;">
									<option>Deadwood Junior High</option>
									<option>Deadwood High School</option>
								</select>
								<a id="add-school" style="cursor:pointer;">+</a>
							</td>
						</tr>
						<tr>
							<td>Grade:</td>
							<td><input type="text" name="first-name" size="5" /></td>
						</tr>
					</table>
				</fieldset>
			</td>
			<td valign="top">
				<fieldset>
					<legend>Description</legend>
					<table>
						<tr>
							<td>Height:</td>
							<td><input type="text" name="first-name" size="10" /></td>
						</tr>
						<tr>
							<td>Weight:</td>
							<td><input type="text" name="first-name" size="10" /></td>
						</tr>
						<tr>
							<td>Eye Color:</td>
							<td>
								<select name="eye" style="width: 100px;">
									<option>Brown</option>
									<option>Blue</option>
									<option>Green</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Hair Color:</td>
							<td>
								<select name="hair" style="width: 100px;">
									<option>Black</option>
									<option>Brown</option>
									<option>Blond</option>
									<option>Red</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Ethnicity:</td>
							<td>
								<select name="ethnicity" style="width: 100px;">
									<option>Asian</option>
									<option>African-American</option>
									<option>Caucasian</option>
									<option>Hispanic</option>
									<option>Native American</option>
								</select>
								</td>
						</tr>
					</table>
				</fieldset>
				
				<fieldset>
					<legend>Drivers License</legend>
					<table>
						<tr>
							<td>Number:</td>
							<td><input type="text" name="first-name" size="10" /></td>
						</tr>
						<tr>
							<td>State:</td>
							<td>
								<select name="state">
									<option>ND</option>
									<option selected="selected">SD</option>
									<option>WY</option>
								</select>
							</td>
						</tr>
					</table>
				</fieldset>
			</td>
		</tr>
	</table>
	</div>
</div>


</form>


<?php 
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>