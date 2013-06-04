<?php
$menuarea = "volunteer";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_volunteer.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_court_location.php");

$id = $_GET["id"];
$volunteer = new Volunteer( $user->getProgramID() );
	
if( isset($id) && $volunteer->compareProgramID( $id, $user_programID ) ){
  	$action = "Edit Volunteer";
  	
  	$volunteer->getVolunteer( $id );
  	$firstName = $volunteer->getFirstName();
  	$lastName = $volunteer->getLastName();
  	$phone = $volunteer->getPhone();
  	$email = $volunteer->getEmail();
  	$positions = $volunteer->getPositions();
  	$active = $volunteer->getActive();
  	$programPositions = $program->getProgramPositions();
}
else
{
	$action = "Add Volunteer";
	$firstName = $volunteer->getFirstName();
	$lastName = $volunteer->getLastName();
	$phone = $volunteer->getPhone();
	$email = $volunteer->getEmail();
	$positions = $volunteer->getPositions();
	$active = $volunteer->getActive();
	$programPositions = $program->getProgramPositions();
}
?>

<script>
$(function () {
	$("#tabs").tabs({ cookie: { expires: 5 } });
	$("#tabs").show(); 
	
	$( "#volunteer-list" ).button().click(function() { window.location.href = "index.php";});
	$( "#update-volunteer" ).button().click(function() { $("#updateVolunteer").submit(); });
	$( "#add-volunteer" ).button().click(function(){ $("#updateVolunteer").submit(); });
	
	$("#updateVolunteer").validate({
		errorElement: "div",
		wrapper: "div",
		errorPlacement: function(error, element) {
			error.insertAfter(element);
			error.addClass('message');
		},
		rules: {
			lastName: {
				required: true
			},
			phone: {
				required: true
			}
		}
	} );
	
	$("#delete-volunteer").button().click(function() {
		dTitle = 'Delete Volunteer';
		dMsg = 'Are you sure you want to delete this volunteer?';
		dHref = $(this).val();
		popupDialog( dTitle, dMsg, dHref );
		return false
	});
});
</script>

<? if( $user_type == 5 ) { ?>
<script type="text/javascript">
jQuery(function($) {  
  $('form :input').attr ( 'disabled', true );
     
  $('#add-volunteer').attr ( 'disabled', true );
  $('#delete-volunteer').attr ( 'disabled', true );
  $('#update-volunteer').attr ( 'disabled', true );
  
});
</script>
<? } ?>

<div id="control-header">
	<div class="left"><h1><? echo $action ?></h1></div>	
	<div class="right">
		<div id="control" class="ui-state-error">
			<button id="volunteer-list">Back to List</button>
      <? if( $action == "Add Volunteer" ) { ?>
			<button id="add-volunteer">Add Volunteer</button>
      <? } else { ?>
			<button class="delete-volunteer" id="delete-volunteer" value="process.php?action=Delete%20Volunteer&id=<? echo $id; ?>" \>Delete Volunteer</button>
			<button id="update-volunteer">Update Volunteer</button>
      <? } ?>
		</div>
	</div>
</div>

<form name="updateVolunteer" id="updateVolunteer" method="post" action="process.php">
<input type="hidden" name="action" value="<? echo $action ?>" />

<? if( $action == "Edit Volunteer" ) { ?>
<input type="hidden" name="volunteerID" value="<? echo $id ?>" />
<? } ?>

<fieldset>
	<legend>Volunteer Information</legend>
  <table>
    <tr>
      <td valign="top" width="50%">
        <table>
          <tr>
            <td width="75">Active?</td>
            <td>
              <select name="active">
                <option value="1" <? if($active == 1) echo 'selected="true"' ?> >Yes</option>
                <option value="0" <? if($active == 0) echo 'selected="true"' ?>>No</option>
              </select>
            </td>
          </tr>
          <tr>
            <td width="100">First Name:</td>
            <td><input type="text" name="firstName" value="<? echo $firstName ?>"/></td>
          </tr>
          <tr>
            <td>Last Name:</td>
            <td><input type="text" name="lastName" value="<? echo $lastName ?>"/></td>
          </tr>
        </table>
      </td>
      <td valign="top" width="50%">
        <table>
          <tr><td colspan="2"></td></tr>        
          <tr>
            <td width="75">Phone #:</td>
            <td><input type="text" class="phone" name="phone" value="<? echo $phone?>"/></td>
          </tr>
          <tr>
            <td>Email:</td>
            <td><input type="text" name ="email" value="<? echo $email ?>"/></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</fieldset>

<? if( $action == "Edit Volunteer" ) { ?>
<div id="tabs">
	<ul>
		<li><a href="#tabs-position">Positions</a></li>
		<li><a href="#tabs-hours">Hours</a></li>
	</ul>
	<div id="tabs-position">
		<fieldset>
      <legend>Select Position(s)</legend>
      <table>
        <? foreach( $programPositions as $key => $value) { ?>
        <tr>
          <td width="250"><? echo $key ?></td>
          <td>
            <? $checked = in_array( $value, $volunteer->getPositions() ) ? " checked" : ""; ?>
            <input type="checkbox" name="position[]" value="<? echo $value ?>"<? echo $checked ?> />
          </td>
        </tr>
        <? } ?>
      </table>
    </fieldset>
	</div>
	<div id="tabs-hours">
		<fieldset>
		  <legend>Volunteer Hours</legend>
		  <?
		  $volunteerHours = $volunteer->fetchVolunteerHours();
      
		  if( !$volunteerHours) { ?>
		  <p>This volunteer has yet to work any courts.</p>
		  <? 
		  } else {
		  ?>
		  <table class="listing" id="volunteer-hours">
		    <thead>
		      <tr>
		        <th width="20%">Date</th>
		        <th width="30%">Venue</th>
            <th width="20%">Location</th>
            <th width="10%">Hours</th>
            <th width="10%"></th>
            <th width="10%"></th>
		      </tr>
		    </thead>
		    <tbody>
		      <?
          foreach( $volunteerHours as $key => $row ) {
            
            $courtloc = new CourtLocation( $user_programID );
            $courtloc->getCourtLocation( $row["courtLocationID"] );
          ?>
          <tr>
            <td><? echo date("n/j/y h:i a", $row["date"] ) ?></td>
            <td><? echo $courtloc->name ?></td>
            <td><? echo $courtloc->city . ", " . $courtloc->state ?></td>
            <td><? echo $row["hours"] ?></td>
            <td><a href="/court/hour_entry.php?id=<? echo $row["courtID"] ?>">Hours</a></td>
            <td align="center"><a href="/court/view.php?id=<? echo $row["courtID"] ?>">View</a></td>
           </tr>
          <? 
          }
          ?>
		    </tbody>
		  </table>
		  <? } ?>
		</fieldset>
	</div>
</div>
<? } ?>

</form>

<?php 
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>