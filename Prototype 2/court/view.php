<?
$menuarea = "court";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
?>

<script>
jQuery(function($)
{	
	$("#tabs").tabs();
	$("#tabs").show(); 
	
	$("#previous-court").button();
	$("#close-court").button();
	$("#delete-court").button();
	$("#update-court").button();
	$("#next-court").button();
	$("#court-date").datepicker();
	
	$("#location-dialog").dialog({
		resizable: false,
		autoOpen:false,
		modal: true,
		width:450,
		height:250,
		buttons: {
			'Add Location': function() {
				$(this).dialog('close');
					// TO DO: add location
				},
			Cancel: function() {
				$(this).dialog('close');
			}
		}
	});

	$("#jury-member-dialog").dialog({
		resizable: false,
		autoOpen:false,
		modal: true,
		width:450,
		height:165,
		buttons: {
			'Add Jury Member': function() {
				$(this).dialog('close');
					// TO DO: add jury member
				},
			Cancel: function() {
				$(this).dialog('close');
			}
		}
	});
	
	$('#add-location').click(function(){ $('#location-dialog').dialog('open'); });
	$('#add-jury-member').click(function(){ $('#jury-member-dialog').dialog('open'); });
	
});
</script>

<div id="location-dialog" title="Add New Location">
	<form>
		<table>
			<tr>
				<td>Location Name</td>
				<td><input type="text" name="location-name" size="30" /></td>
			</tr>
			<tr>
				<td>Address:</td>
				<td><input type="text" name="location-address" size="30" /></td>
			</tr>
			<tr>
				<td>City:</td>
				<td>
					<input type="text" name="location-city" /> State: 
					<select name="location-state">
						<option>ND</option>
						<option selected="selected">SD</option>
						<option>WY</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Zip:</td>
				<td><input type="text" name="location-zip" /></td>
			</tr>
		</table>		
	</form>
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
	
	<div class="left"><h1>Court Information</h1></div>	
	<div class="right">
		<div id="control" class="ui-state-error">
			<button id="previous-court">Previous</button>
			<button id="delete-court">Delete</button>
			<button id="update-court">Update</button>
			<button id="close-court">Close</button>
			<button id="next-court">Next</button>
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
								<option>Smith, Mike (12320)</option>
								<option>Adams, Sam (1000)</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Court Date: </td>
						<td><input type="text" name="court-date" id="court-date" value="11/15/2012"></td>
					</tr>
					<tr>
						<td>Court Time: </td>
						<td><input type="text" name="court-time" id="court-time" value="11:00am"></td>
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
								<option>Deadwood Court House</option>
								<option>Spearfish Community Center</option>
							</select>
							<a id="add-location" style="cursor:pointer;">+</a>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</fieldset>

<div id="tabs">
	<ul>
		<li><a href="#tabs-members">Court Members</a></li>
		<li><a href="#tabs-jury">Jury Members</a></li>
		<li><a href="#tabs-parents">Parents/Guardians</a></li>
	</ul>
	
	<div id="tabs-members">
		<table style="width: 400px">
			<tr>
				<td>Judge: </td>
				<td>
					<select id="judge" name="judge">
						<option selected="selected">Mason, James</option>
						<option>Baxter, Mary</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Defense Attorney: </td>
				<td>
					<select id="defense-attorney" name="defense-attorney">
						<option selected="selected">Baxter, Mary</option>
						<option>Smith, Allen</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Prosecuting Attorney: </td>
				<td>
					<select id="prosecuting-attorney" name="prosecuting-attorney">
						<option>Baxter, Mary</option>
						<option selected="selected">Smith, Allen</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Bailiff: </td>
				<td>
					<select id="defense-attorney" name="defense-attorney">
						<option selected="selected">Jones, Cheryl</option>
						<option>Smith, Allen</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Court Clerk: </td>
				<td>
					<select id="defense-attorney" name="defense-attorney">
						<option selected="selected">Adams, Henry</option>
						<option>Smith, Allen</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Exit Interviewer: </td>
				<td>
					<select id="defense-attorney" name="defense-attorney">
						<option selected="selected">Sanders, Cindy</option>
						<option>Jones, Cheryl</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Advisor: </td>
				<td>
					<select id="defense-attorney" name="defense-attorney">
						<option>Baxter, Mary</option>
						<option selected="selected">Sanders, Cindy</option>
					</select>
				</td>
			</tr>
		</table>
	</div>
	
	<div id="tabs-jury">
		<table class="listing">
			<thead>
				<tr>
					<th width="60%">Jury Member</th>
					<th width="30%">Type</th>
					<th width="10%"></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Smith, Tom</td>
					<td>Volunteer</td>
					<td><a href="view.php">Remove</a></td>
				</tr>
				<tr>
					<td>Adams, Sam</td>
					<td>Defendant</td>
					<td><a href="view.php">Remove</a></td>
				</tr>
				<tr>
					<td>Katz, Callie</td>
					<td>Volunteer</td>
					<td><a href="view.php">Remove</a></td>
				</tr>
				<tr>
					<td>Nelson, Anthony</td>
					<td>Volunteer</td>
					<td><a href="view.php">Remove</a></td>
				</tr>
				<tr>
					<td>Goodwin, Louise</td>
					<td>Volunteer</td>
					<td><a href="view.php">Remove</a></td>
				</tr>
				<tr>
					<td>Swan, Tammy</td>
					<td>Defendant</td>
					<td><a href="view.php">Remove</a></td>
				</tr>
			</tbody>
		</table>
		<div>
			<input type="button" class="add" id="add-jury-member" value="Add Jury Member" />
		</div>
	</div>
	
	<div id="tabs-parents">
		<table style="width: 400px">
			<tr>
				<td>John Smith</td>
				<td>
					<select id="parent1" name="parent1">
						<option>Yes</option>
						<option>No</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Mary Smith</td>
				<td>
					<select id="parent2" name="parent2">
						<option>Yes</option>
						<option selected="selected">No</option>
					</select>
				</td>
			</tr>
		</table>
	</div> 
</div>



</form>

<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>