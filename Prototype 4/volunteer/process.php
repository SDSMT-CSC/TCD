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

if( $action == "Add Volunteer" || $action == "Edit Volunteer" )
{
	$mod_volunteer = new Volunteer(  $user->getProgramID() );
	
	if( $_POST["volunteerID"] > 0 ) { $mod_volunteer->setVolunteerID( $_POST["volunteerID"] ); }
	$mod_volunteer->setFirstName( $_POST["firstName"] );
	$mod_volunteer->setLastName( $_POST["lastName"] );
	$mod_volunteer->setPhone( $_POST["phone"] );
	$mod_volunteer->setEmail( $_POST["email"] );
	$mod_volunteer->setPositions( $_POST["position"] );
	$mod_volunteer->setActive( $_POST["active"] );

	$mod_volunteer->updateVolunteer();

	//log if successful	
	if( $mod_volunteer->updateVolunteer() )
		$user->addEvent($action, $mod_volunteer->getVolunteerID() );
	
	//redirect to edit page
	header("location:view.php?id=".$mod_volunteer->getVolunteerID() );
}
elseif( $action == "Delete Volunteer" )
{
	$id = $_GET["id"];
	$volunteer = new Volunteer( $user->getProgramID() );
	$volunteer->getVolunteer( $id );
	
	if( $user_type < 5 && $user->getProgramID() == $volunteer->getProgramID() )
	{
		if( $volunteer->deleteVolunteer() )
		{
			//record if successful
			$user->addEvent("Deleted Volunteer" . $volunteer->getLastName(), $volunteer->getVolunteerID());
		}
	}
	
	header("location:index.php");
}
else
{
	//should not be here, return to main
	header("location:index.php");
}
  ?>