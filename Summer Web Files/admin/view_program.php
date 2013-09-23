<?php
$id = $_GET["id"];
if( $user_type > 2 or $id == $user_programID)
  $menuarea = "program";
else
  $menuarea = "programs";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_data.php");

$data = new Data();

if( $user_type > 3  ) 
{ 
?><p>You do not have access to this page.</p><? 
} else { 

  if( isset($id) ) 
	{
  	$action = "Edit Program";
  	
    $mod_program = new Program();
  	if( $mod_program->getFromID( $id ) ) {
    	$name = $mod_program->getName();
    	$code = $mod_program->getCode();
    	$phone = $mod_program->phone;
    	$phys_address = $mod_program->phys_address;
    	$phys_city = $mod_program->phys_city;
    	$phys_state = $mod_program->phys_state;
    	$phys_zip = $mod_program->phys_zip;
    	$mail_address = $mod_program->mail_address;
    	$mail_city = $mod_program->mail_city;
    	$mail_state = $mod_program->mail_state;
    	$mail_zip = $mod_program->mail_zip;
    	$timezoneID = $mod_program->timezoneID;
    	$expunge = $mod_program->expunge;
      $active = $mod_program->active;
    }
    else {
      $error = 1;
    }
  } 
  else {
  	$action = "Add Program";
    $name = NULL;
    $code = NULL;
    $phone = NULL;
    $phys_address = NULL;
    $phys_city = NULL;
    $phys_state = NULL;
    $phys_zip = NULL;
    $mail_address = NULL;
    $mail_city = NULL;
    $mail_state = NULL; 
    $mail_zip = NULL;
    $timezoneID = 1;
    $expunge = 0;
    $active = 1;
  }
?>

<script>
jQuery(function($) {
	$( "#program-list" ).button().click(function() { window.location.href = 'programs.php'; });
	$( "#add-program" ).button().click(function() { $("#program-info").submit();	});
	$( "#update-program" ).button().click(function() { $("#program-info").submit(); });
	$( "#delete-program" ).button().click(function() { 
	  $("#action").val("Delete Program");
	  $("#program-info").submit();
	});
	
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
	<div class="left"><h1><? echo $action ?></h1></div>	
	<div class="right">
		<div id="control" class="ui-state-error">
		  <? if( $user_type < 3)  { ?>
    	<button id="program-list">Back to List</button>
			<? } if( $action == "Add Program" ) { ?>
			<button id="add-program">Add Program</button>
			<? } else { ?>
			<button id="update-program">Update Program</button>
			<button id="delete-program">Delete Program</button>
      <? } ?>
		</div>
	</div>
</div>

<form name="program" id="program-info" method="post" action="process.php">
<input type="hidden" name="action" id="action" value="<? echo $action ?>" />
<input type="hidden" name="programID" value="<? echo $id ?>" />
<table>
	<tr>
		<td colspan="2">			
			<fieldset>
				<legend>Program Information</legend>
				<table>
          <tr>
            <td>Active:</td>
            <td>
              <select name="active">
                <option value="1"<? if($active == 1) echo " selected"; ?>>Yes</option>
                <option value="0"<? if($active == 0) echo " selected"; ?>>No</option>
              </select>
            </td>
          </tr>
					<tr>
						<td width="200">Court Name:</td>
						<td><input type="text" name="name" class="wide" value="<? echo $name ?>"/></td>
          </tr>
          <tr>
						<td>Code:</td>
						<td><input type="text" name="code" class="wide" value="<? echo $code ?>"/></td>
          </tr>
          <tr>
            <td>Phone Number:</td>
            <td><input type="text" name="phone" class="wide" value="<? echo $phone ?>"/></td>
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
                <option value="0"<? if($expunge == 0) echo " selected"; ?>>None</option>
              	<option value="1"<? if($expunge == 1) echo " selected"; ?>>Full</option>
                <option value="2"<? if($expunge == 2) echo " selected"; ?>>Partial</option>
                <option value="3"<? if($expunge == 3) echo " selected"; ?>>Sealed</option>
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
				<legend>Physical Address</legend>
				<table>
					<tr>
						<td>Street</td>
						<td><input type="text" name="pAddress" value="<? echo $phys_address ?>"/></td>
					</tr>
					<tr>
						<td>City</td>
						<td><input type="text" name="pCity" value="<? echo $phys_city ?>"/></td>
					</tr>
					<tr>
						<td>State</td>
						<td><input type="text" name="pState" value="<? echo $phys_state ?>"/></td>
					</tr>
					<tr>
						<td>Zip</td>
						<td><input type="text" name="pZip" value="<? echo $phys_zip ?>"/></td>
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
						<td><input type="text" name="mAddress" value="<? echo $mail_address ?>"/></td>
					</tr>
					<tr>
						<td>City</td>
						<td><input type="text" name="mCity" value="<? echo $mail_city ?>"/></td>
					</tr>
					<tr>
						<td>State</td>
						<td><input type="text" name="mState" value="<? echo $mail_state ?>"/></td>
					</tr>
					<tr>
						<td>Zip</td>
						<td><input type="text" name="mZip" value="<? echo $mail_zip ?>"/></td>
					</tr>
				</table>
			</fieldset>
		</td>
	</tr>
</table>
</form>

<?php 
} // ends error check

include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>