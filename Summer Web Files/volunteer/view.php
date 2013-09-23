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
          <tr>
            <td>Adult or Teen:</td>
            <td>
              <select name="adultOrTeen">
                <option <? if( $volunteer->adultOrTeen == "Teen" ) echo " selected"; ?>>Teen</option>
                <option <? if( $volunteer->adultOrTeen == "Adult" ) echo " selected"; ?>>Adult</option>
              </select>
            </td>
          </tr>
          <tr>
            <td>Grade:</td>
            <td>
              <select name="grade">
                <option></option>
                <option <? if( $volunteer->grade == "6") echo " selected"; ?>>6</option>
                <option <? if( $volunteer->grade == "7") echo " selected"; ?>>7</option>
                <option <? if( $volunteer->grade == "8") echo " selected"; ?>>8</option>
                <option <? if( $volunteer->grade == "9") echo " selected"; ?>>9</option>
                <option <? if( $volunteer->grade == "10") echo " selected"; ?>>10</option>
                <option <? if( $volunteer->grade == "11") echo " selected"; ?>>11</option>
                <option <? if( $volunteer->grade == "12") echo " selected"; ?>>12</option>
              </select>
            </td>
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
            <td><input type="text" name="email" value="<? echo $email ?>"/></td>
          </tr>
          <tr>
            <td>Address:</td>
            <td><input type="text" name="address" value="<? echo $volunteer->address ?>"</td>
          </tr>
          <tr>
            <td>Parent Name:</td>
            <td><input type="text" name="parentName" value="<? echo $volunteer->parentName ?>"</td>
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
		        <th width="50%">Position</th>
            <th width="30%">Hours</th>
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
            <td><? echo $row["position"] ?></td>
            <td><? echo $row["hours"] ?></td>
            <td><a href="/court/hour_entry.php?id=<? echo $row["court_caseID"] ?>">Hours</a></td>
            <td align="center"><a href="/court/view.php?id=<? echo $row["court_caseID"] ?>">View</a></td>
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