<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_data.php");

$data = new Data();

?>

<script src="/includes/js/jquery.pstrength.js" type="text/javascript"></script>
<script>
jQuery(function($) {

	$('.password').pstrength();
	$("#update-profile").button();
	
	$("#phone-dialog").dialog({
		resizable: false,
		autoOpen:false,
		modal: true,
		width:400,
		height:215,
		buttons: {
			'Add Number': function() {
				$(this).dialog('close');
					// TO DO: add number
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
			password1: { required: true, minlength: 6 },
			password2: { required: true, minlength: 6, equalTo: "#password1" },
			email: { required: true, email: true }
		}
	});
	
	
	$('#add-number').click(function(){ $('#phone-dialog').dialog('open'); });
	
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
	<form name="phone-number" id="phone-number">
		<table>
			<tr>
				<td>Type:</td>
				<td><input type="text" name="item" /></td>
			</tr>
			<tr>
				<td>Number:</td>
				<td><input type="text" name="item" /></td>
			</tr>
			<tr>
				<td>Extension:</td>
				<td><input type="text" name="item" /></td>
			</tr>
		</table>
	</form>
</div>

<form name="user-profile" id="user-profile">
<fieldset>
	<legend>Login Information</legend>
	<table>
		<tr>
			<td>Email Address: </td>
			<td><input type="text" name="email" id="email" value="<? echo $user->getEmail() ?>" class="wide" /></td>
		</tr>
		<tr>
			<td valign="top">Reset Password: </td>
			<td><input type="password" name="password1" id="password1" class="wide password" /></td>
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
			<td>First Name: </td>
			<td><input type="text" name="first-name" id="first-name" value="<? echo $user->getFirstName() ?>" /></td>
		</tr>
		<tr>
			<td>Last Name: </td>
			<td><input type="text" name="last-name" id="last-name" value="<? echo $user->getLastName() ?>" /></td>
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
				<tr>
					<td>Work</td>
					<td>605-555-5555</td>
					<td>34</td>
					<td><a href="view.php">Remove</a></td>
				</tr>
				<tr>
					<td>Cell</td>
					<td>605-949-1234</td>
					<td></td>
					<td><a href="view.php">Remove</a></td>
				</tr>
			</tbody>
		</table>
		<div>
			<input type="button" class="add" id="add-number" value="Add Phone Number" />
		</div>
</fieldset>

</form>



<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>