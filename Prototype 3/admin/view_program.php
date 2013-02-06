<?php
$menuarea = "admin";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
?>

<script>
$(function () {
	$( "#previous-program" ).button().click(function() {		});
	$( "#update-program" ).button().click(function() {		});
	$( "#next-program" ).button().click(function() {		});
});
</script>

<div id="control-header">
	
	<div class="left"><h1>Add New Court Program</h1></div>	
	<div class="right">
		<div id="control" class="ui-state-error">
			<button id="previous-program">Previous</button>
			<button id="update-program">Update Court</button>
			<button id="next-program">Next</button>
		</div>
	</div>
	
</div>

<form name="newProgram" id="newProgram" method="post" action="new.php">

<table>
	<tr>
		<td colspan="2">
			
			<fieldset>
				<legend>Court Program Information</legend>
				<table>
					<tr>
						<td>Court Name:</td>
						<td><input type="text" name="name" size="40"/></td>
						<td>Code:</td>
						<td><input type="text" name="code"/></td>
						<td>Timezone:</td>
						<td>
							<select id="timezone" name="timezone">
								<option>Mountain</option>
							</select>
						</td>
					</tr>
				</table>
			</fieldset>
		</td>
	</tr>
	<tr>
		<td style="width:50%;vertical-align:top">
			<fieldset>
				<legend>Program Physical Address</legend>
				<table>
					<tr>
						<td>Street</td>
						<td><input type="text" name="pAddress"/></td>
					</tr>
					<tr>
						<td>City</td>
						<td><input type="text" name="pCity" value="Deadwood"/></td>
					</tr>
					<tr>
						<td>State</td>
						<td><input type="text" name="pState" value="SD"/></td>
					</tr>
					<tr>
						<td>Zip</td>
						<td><input type="text" name="pZip" value="57732"/></td>
					</tr>
				</table>
			</fieldset>
		</td>
		<td style="width:50%">
			<fieldset>
				<legend>Mailing Address</legend>
				<table>
					<tr></tr>
					<tr>
						<td>Street</td>
						<td><input type="text" name="mAddress" value="PO Box 227"/></td>
					</tr>
					<tr>
						<td>City</td>
						<td><input type="text" name="mCity" value="Deadwood"/></td>
					</tr>
					<tr>
						<td>State</td>
						<td><input type="text" name="mState" value="SD"/></td>
					</tr>
					<tr>
						<td>Zip</td>
						<td><input type="text" name="mZip" value="57732"/></td>
					</tr>
				</table>
			</fieldset>
		</td>
	</tr>
</table>

</form>

<?php 
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>