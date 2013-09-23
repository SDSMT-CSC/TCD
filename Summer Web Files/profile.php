<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_data.php");

$data = new Data();

$action = $_REQUEST["action"];

if( $action == "Update Profile" )
{
	$user->setEmail( $_POST["email"] );
	$user->setFirstName( $_POST["firstname"] );
	$user->setLastName( $_POST["lastname"] );
	$user->setTimezoneID( $_POST["timezoneID"] );
	
	if( $_POST["password1"] )
		$user->setPassword( $_POST["password1"] );
	
  // log the event on success
  if( $user->updateUser() )
    $user->addEvent($action, $user->getUserID() );	
}

if( $action == "Add Phone" )
{
  // log the event on success
  if($user->addPhone( $_POST["type"], $_POST["number"], $_POST["ext"] ) )
    $user->addEvent($action, $user->getUserID() );
}

if( $action == "Delete Phone" )
{
  // log the event on success
  if( $user->removePhone( $_GET["id"] ) )
    $user->addEvent($action, $user->getUserID() );	
}

?>

<script src="/includes/js/jquery.pwstrength.min.js" type="text/javascript"></script>
<script>
jQuery(function($) {

	$("#password1").pwstrength();
	$("#update-profile").button();
	$("#update-profile").click(function(){ $('#user-profile').submit(); });
	
	$("#phone-dialog").dialog({
		resizable: false,
		autoOpen:false,
		modal: true,
		width:400,
		buttons: {
			'Add Number': function() {
				$(this).dialog('close');
				$("#phone-number").submit();
				},
			Cancel: function() {
				$(this).dialog('close');
			}
		}
	});
	
	$("#user-profile").validate({
		errorElement: "div",
		wrapper: "div",
		errorPlacement: function(error, element) {
			  error.insertAfter(element);
				error.addClass('message');
		},
		rules: {
			firstname: { required: true },
      password1: { minlength: 6 },
      password2: { minlength: 6, equalTo: "#password1" },
			email: { required: true, email: true }
		}
	});
	
	// phone number dialog
	$('#add-number').click(function(){ $('#phone-dialog').dialog('open'); });
	
	// Delete an phone
	$("a.delete-phone").click(function() {
		dTitle = 'Delete Phone';
		dMsg = 'Are you sure you want to delete this phone number?';
		dHref = $(this).attr("href");
		popupDialog( dTitle, dMsg, dHref );
		return false;
	});
	
});
</script>

<div id="control-header">
	<div class="left"><h1>User Profile</h1></div>	
	<div class="right">
		<div id="control" class="ui-state-error">
			<button id="update-profile">Update Profile</button>
		</div>
	</div>
</div>


<div id="phone-dialog" title="Add Phone Number">
	<form name="phone-number" id="phone-number" method="post">
  	<input type="hidden" name="action" value="Add Phone" />
		<table>
			<tr>
				<td>Type:</td>
				<td><input type="text" name="type" /></td>
			</tr>
			<tr>
				<td>Number:</td>
				<td><input type="text" name="number" /></td>
			</tr>
			<tr>
				<td>Extension:</td>
				<td><input type="text" name="ext" /></td>
			</tr>
		</table>
	</form>
</div>

<form name="user-profile" id="user-profile" method="post">
<input type="hidden" name="action" value="Update Profile" />
<fieldset>
	<legend>Login Information</legend>
	<table>
		<tr>
			<td width="200">Email Address: </td>
			<td><input type="text" name="email" id="email" value="<? echo $user->getEmail() ?>" class="wide" /></td>
		</tr>
		<tr>
			<td valign="top">Reset Password: </td>
			<td><input type="password" name="password1" id="password1" class="wide password"  data-indicator="pwindicator" />
        <div id="pwindicator">
            <div class="bar"></div>
            <div class="label"></div>
        </div>
      </td>
		</tr>
		<tr>
			<td>Retype Password: </td>
			<td><input type="password" name="password2" id="password2"  class="wide"/></td>
		</tr>			
	</table>	
</fieldset>
<fieldset>
	<legend>Personal Information</legend>
	<table>
		<tr>
			<td width="200">First Name: </td>
			<td><input type="text" name="firstname" id="firstname" value="<? echo $user->getFirstName() ?>" /></td>
		</tr>
		<tr>
			<td>Last Name: </td>
			<td><input type="text" name="lastname" id="lastname" value="<? echo $user->getLastName() ?>" /></td>
		</tr>
		<tr>
			<td>Timezone: </td>
			<td>
        <select name="timezoneID">
          <? echo $data->fetchTimezoneDropdown( $user->getTimezoneID() ); ?>
        </select>
      </td>
		</tr>
	</table>
</fieldset>
</form>

<fieldset>
		<legend>Phone Numbers</legend>
		<table class="listing">
			<thead>
				<tr>
					<th width="20%">Type</th>
					<th width="50%">Number</th>
					<th width="20%">Extension</th>
					<th width="10%"></th>
				</tr>
			</thead>
			<tbody>
				<?
				$phoneArray = $user->fetchPhoneNumbers();
				if( $phoneArray )
				{
					foreach( $user->fetchPhoneNumbers() as $row )
					{
						echo '<tr>';
						echo '<td>' . $row["type"] . '</td>';
						echo '<td>' . $row["phoneNum"] . '</td>';
						echo '<td>' . $row["ext"] . '</td>';
						echo '<td><a class="delete-phone" href="profile.php?action=Delete Phone&id=' . $row["phoneID"] . '">Remove</a></td>';
						echo '</tr>';
					}
				}
				else {
					echo '<tr><td align="center" colspan="4">No phone number entered</td></tr>';
				}
				?>
			</tbody>
		</table>
		<div>
			<input type="button" class="add" id="add-number" value="Add Phone Number" />
		</div>
</fieldset>




<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>