<?php
$menuarea = "admin";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_data.php");

$id = $_GET["id"];
$mod_program = new Program();
$data = new Data();

if( isset($id) ) {
	$action = "Edit Program";
	$mod_program->getFromID( $id );
	
} else {
	$action = "Add Program";

}
?>

<script>
$(function () {
	$( "#program-list" ).button().click(function() { window.location.href = 'programs.php'; });
	$( "#add-program" ).button().click(function() { $("#program").submit();	});
	$( "#update-program" ).button().click(function() { $("#program").submit(); });
	$( "#delete-program" ).button().click(function() { 	});
	
	
	$("#program").validate({
		errorElement: "div",
		wrapper: "div",
		errorPlacement: function(error, element) {
			  error.insertAfter(element);
				error.addClass('message');
		},
		rules: {
			name: { required: true },
			code: {	required: true }
		}
	});
	
	
});
</script>

<div id="control-header">
	
	<div class="left"><h1>Add New Court Program</h1></div>	
	<div class="right">
		<div id="control" class="ui-state-error">
    	<button id="program-list">Back to List</button>
			<? if( $action == "Add Program" ) { ?>
			<button id="add-program">Add Program</button>
			<? } else { ?>
			<button id="update-program">Update Program</button>
			<button id="delete-program">Delete Program</button>
      <? } ?>
		</div>
	</div>
	
</div>

<form name="program" id="program" method="post" action="process.php">
<input type="hidden" name="action" value="<? echo $action ?>" />

<table>
	<tr>
		<td colspan="2">
			
			<fieldset>
				<legend>Court Program Information</legend>
				<table>
					<tr>
						<td width="200">Court Name:</td>
						<td><input type="text" name="name" class="wide"/></td>
          </tr>
          <tr>
						<td>Code:</td>
						<td><input type="text" name="code" class="wide"/></td>
          </tr>
          <tr>
						<td>Timezone:</td>
						<td>
              <select name="timezoneID">
                <? echo $data->fetchTimezoneDropdown( $timezoneID ); ?>
              </select>
						</td>
					</tr>
          <tr>
						<td>Expunge Type:</td>
						<td>
              <select name="expunge">
              	<option value="1">Full</option>
                <option value="2">Partial</option>
                <option value="3">Sealed</option>
              </select>
						</td>
					</tr>
				</table>
			</fieldset>
		</td>
	</tr>
	<tr>
		<td>
			<fieldset>
				<legend>Program Physical Address</legend>
				<table>
					<tr>
						<td>Street</td>
						<td><input type="text" name="pAddress"/></td>
					</tr>
					<tr>
						<td>City</td>
						<td><input type="text" name="pCity" value=""/></td>
					</tr>
					<tr>
						<td>State</td>
						<td><input type="text" name="pState" value=""/></td>
					</tr>
					<tr>
						<td>Zip</td>
						<td><input type="text" name="pZip" value=""/></td>
					</tr>
				</table>
			</fieldset>
		</td>
		<td>
			<fieldset>
				<legend>Mailing Address</legend>
				<table>
					<tr></tr>
					<tr>
						<td>Street</td>
						<td><input type="text" name="mAddress" value=""/></td>
					</tr>
					<tr>
						<td>City</td>
						<td><input type="text" name="mCity" value=""/></td>
					</tr>
					<tr>
						<td>State</td>
						<td><input type="text" name="mState" value=""/></td>
					</tr>
					<tr>
						<td>Zip</td>
						<td><input type="text" name="mZip" value=""/></td>
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