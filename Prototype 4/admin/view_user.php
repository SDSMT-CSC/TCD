<?php
$menuarea = "users";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_data.php");

$id = $_GET["id"];
$error = 0;
$data = new Data();

// make sure logged in user has access to edit this user
if( $user_type > 3 || $user_programID != $program->getProgramID() ) {
  $error = 1;
}
else {
  if( isset($id) ) {
  	$action = "Edit User";
  	
  	$mod_user = new User();
    
    if( $mod_user->getFromID( $id ) ) {
  
      // if user is type 3 and the program doesn't match, don't give access
      if( $user_type == 3 && $mod_user->getProgramID() != $user_programID ) {
        $error = 1;
      }
      else {
        $firstname = $mod_user->getFirstName();
      	$lastname = $mod_user->getLastName();
      	$email = $mod_user->getEmail();
      	$active = $mod_user->isActive();
      	$type = $mod_user->getType();
      	$programID = $mod_user->getProgramID();
      	$timezoneID = $mod_user->getTimezoneID();
      }
    }
    else {
      $error = 1;
    } 
  } 
  else {
  	$action = "Add User";
  	$firstname = "";
  	$lastname = "";
  	$email = "";
  	$active = 0;
  	$type = 5;
  	$programID = 0;
  	$timezoneID = 1;
  }
}
?>

<? if( $error == 1 ) { ?>
<p>You do not have access to this page.</p>
<? } else { ?>
<script>
$(function () {
	
	$("#tabs").tabs();
  $("#tabs").show(); 
	
	$( "#user-list" ).button().click(function() {	window.location.href = "users.php";	});	
	$( "#add-user" ).button().click(function() {	$("#user").submit();	});	
	$( "#update-user" ).button().click(function() {	$("#user").submit();	});
	$( "#delete-user" ).button().click(function(){$('#confirm-dialog').dialog('open');});
	
	$("#user").validate({
		errorElement: "div",
		wrapper: "div",
		errorPlacement: function(error, element) {
			  error.insertAfter(element);
				error.addClass('message');
		},
		rules: {
			email: {
				required: true,
				email: true
			},
			firstname: {
				required: true
			}
			<? if( $action == "Add") { ?>
			, password: {
				required: true
			}
			<? } ?>
			
		}
	});
	
	$("#confirm-dialog").dialog({
				resizable: false,
				autoOpen:false,
				modal: true,
				width:300,
				height:175,
				buttons: {
					'Delete User': function() {
							window.location.href = 'process.php?action=Delete%20User&id=<? echo $id ?>';
						},
					Cancel: function() {
						$(this).dialog('close');
					}
				}
			
			});
			
	
	$("#data-table").dataTable( { 
				"aaSorting": [],
        "sPaginationType": "full_numbers",
				"bProcessing": true,
        "sAjaxSource": '/data/user_history.php?id=<? echo $id ?>'
	} );
	
});
</script>

<div id="confirm-dialog" title="Delete User">
<p>Are you sure you want to delete this user?</p>
</div>

<div id="control-header">
	<div class="left"><h1><? echo $action ?></h1></div>	
	<div class="right">
		<div id="control" class="ui-state-error">
			<button id="user-list">Back to List</button>
			<? if( $action == "Add User" ) { ?>
			<button id="add-user">Add User</button>
			<? } else { ?>
			<button id="update-user">Update User</button>
			<button id="delete-user">Delete User</button>
      <? } ?>
		</div>
	</div>
</div>

<form name="user" id="user" method="post" action="process.php">
<input type="hidden" name="action" value="<? echo $action ?>" />
<input type="hidden" name="userID" value="<? echo $id ?>" />

<div id="tabs">
	<ul>
		<li><a href="#tab-details">User Details</a></li>
		<li><a href="#tab-history">User History</a></li>
  </ul>
  <div id="tab-details">
  <fieldset>
    <legend>User Information</legend>
    <table>
      <tr>
        <td width="200">Active:</td>
        <td>
          <select name="active">
            <option value="1"<? if($active == 1) echo " selected"; ?>>Yes</option>
            <option value="0"<? if($active == 0) echo " selected"; ?>>No</option>
          </select>
        </td>
      </tr>
      <tr>
        <td>First Name:</td>
        <td><input type="text" name="firstname" value="<? echo $firstname ?>" class="wide" /></td>
      </tr>
      <tr>
        <td>Last Name:</td>
        <td><input type="text" name="lastname" value="<? echo $lastname ?>" class="wide" /></td>
      </tr>
      <tr>
        <td>Email Address:</td>
        <td><input type="text" name="email" value="<? echo $email ?>" class="wide" /></td>
      </tr>
      <tr>
        <td>Force Password:</td>
        <td><input type="password" name="password" class="wide" /></td>
      </tr>
    </table>
  </fieldset>
  <fieldset>
    <legend>Program Information</legend>
    <table>
      <tr>
        <td width="200">Program:</td>
        <td>
          <? 
          if( $user_type > 2 ) { 
              echo $program->getName();
          } else {
          ?>
          <select name="programID">
            <? echo $data->fetchProgramDropdown( $programID ); ?>
          </select>
          <? } ?>
        </td>
      </tr>
      <tr>
        <td>Access Level:</td>
        <td>
          <select name="typeID">
            <? echo $data->fetchUserTypeDropdown( $type, $user_type); ?>
          </select>
        </td>
      </tr>
      <tr>
        <td>Timezone:</td>
        <td>
          <select name="timezoneID">
            <? echo $data->fetchTimezoneDropdown( $timezoneID ); ?>
          </select>
        </td>
      </tr>
    </table>
  </fieldset>
  </form>
  </div>
  <div id="tab-history">
    <table id="data-table">
      <thead>
          <tr>
            <th>Date</th>
            <th>Event</th>
            <th>IP Address</th>
          </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
</div>

<?php 
} // end error check

include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>