<?
include($_SERVER['DOCUMENT_ROOT']."/includes/secure.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_volunteer.php");

// make sure only certain levels of user get access to this area
if( $user_type == 1 )
{
	header("location: /main.php");
}

//get the action to be taken
$action = $_REQUEST["action"];

if( $action == "Add Volunteer")
{
	$new_volunteer = new Volunteer();
	
	$new_volunteer->setProgramID( $_POST["programID"] );
	$new_volunteer->setFirstName( $_POST["firstName"] );
	$new_volunteer->setLastName( $_POST["lastName"] );
	$new_volunteer->setPhone( $_POST["phone"] );
	$new_volunteer->setEmail( $_POST["email"] );
	$new_volunteer->setPositions( $_POST["position"] );
	
	if( $new_volunteer->addVolunteer() )
	{
		//log if successful
		$user->addEvent("Added Volunteer: " . $new_volunteer->getLastName() );
	}
	
	//redirect to edit page
	header("location:view.php?id=".$new_volunteer->getVolunteerID() );
}

elseif( $action == "Edit Volunteer")
{
	$edit_volunteer = new Volunteer();
	
	$edit_volunteer->setVolunteerID( $_POST["volunteerID"]);
	$edit_volunteer->setFirstName( $_POST["firstName"]);
	$edit_volunteer->setLastName( $_POST["lastName"] );
	$edit_volunteer->setPhone( $_POST["phone"] );
	$edit_volunteer->setEmail( $_POST["email"] );
	$edit_volunteer->setPositions( $_POST["position"] );
	$edit_volunteer->setActive( $_POST["active"] );
	
	if( $edit_volunteer->editVolunteer() )
	{
		//log if successful
		$user->addEvent("Edited Volunteer: " . $edit_volunteer->getLastName() );
	}
	
	//redirect to edit page
	header("location:view.php?id=".$edit_volunteer->getVolunteerID() );
}

else
{
	//should not be here, return to main
	header("location:index.php");
}
?>