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

/****************************************************************************
	UPDATE VOLUNTEER
****************************************************************************/
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
  $mod_volunteer->address = $_POST["address"];
  $mod_volunteer->parentName = $_POST["parentName"];
  $mod_volunteer->grade = $_POST["grade"];
  $mod_volunteer->adultOrTeen = $_POST["adultOrTeen"];

	$mod_volunteer->updateVolunteer();

	//log if successful	
	if( $mod_volunteer->updateVolunteer() )
		$user->addEvent($action, $mod_volunteer->getVolunteerID() );
	
	//redirect to edit page
	header("location: view.php?id=".$mod_volunteer->getVolunteerID() );
}

/****************************************************************************
	DELETE VOLUNTEER
****************************************************************************/
if( $action == "Delete Volunteer" )
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

?>