<?
include($_SERVER['DOCUMENT_ROOT']."/includes/secure.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_location.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_workshop.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_workshop_location.php");

// make sure only certain levels of user get access to this area
if( $user_type == 1 || $user_type == 5)
{
	header("location: /main.php");
}

//get the action to be taken
$action = $_REQUEST["action"];
$workshopIDG = $_GET["workshopID"];
$workshopIDP = $_POST["workshopID"];
$remove = $_GET["remove"];
$completed = $_GET["completed"];
$add = $_POST["add"];

if( $action == "Add Workshop" || $action == "Edit Workshop"  ) {

	// set workshop information
	$workshop = new Workshop( $user_programID );
	
	if( $_POST["workshopID"] > 0 ) { $workshop->setWorkshopID( $_POST["workshopID"] ); }
	
	$workshop->setDate( $_POST["date"] . " " . $_POST["time"] );
	$workshop->setTitle( $_POST["title"] );
	$workshop->setDescription( $_POST["description"] );
	$workshop->setInstructor( $_POST["instructor"] );
	$workshop->setOfficerID( $_POST["officer"] );
	
	// check workshop location
	$workshopLocation = new workshopLocation( $user_programID );
	$workshopLocation->name = $_POST["locationName"];
	$workshopLocation->address = $_POST["address"];
	$workshopLocation->city = $_POST["workshop-city"];
	$workshopLocation->state = $_POST["workshop-state"];
	$workshopLocation->zip = $_POST["workshop-zip"];
	
	// add/get program location id
	$location = new Location( $user_programID );
	$workshopLocation->locationID = $location->addLocation( $_POST["workshop-city"], $_POST["workshop-state"], $_POST["workshop-zip"] );
  
	// update the workshop location and get id
	$workshopLocation->updateWorkshopLocation();
	$workshop->setworkshopLocationID( $workshopLocation->getWorkshopLocationID() );
		
	//log if successful
	if( $workshop->updateWorkshop() )
		$user->addEvent( "Added Workshop: " . $workshop->getTitle() );
	
	//redirect to edit page
	header("location:view.php?id=" . $workshop->getWorkshopID());
} 
elseif ( $action == "Add Participant" )
{
	$workshop = new Workshop( $user_programID );
	$workshop->getWorkshop( $workshopIDP );
	
	if( $workshop->addWorkshopParticipant( $workshopIDP, $add ))
	{
		//log if successful
		$user->addEvent( "Added Workshop Participant: " . $workshop->getTitle() , $workshop->getTitle() );
	}
	
	//redirect to edit page
	header("location:view.php?id=" . $workshop->getWorkshopID());
} 
elseif ( $action == "Delete Workshop" )
{
	$id = $_GET["id"];
	$workshop = new Workshop();
	$workshop->getWorkshop( $id );
	
	if( $user_type < 5 && $user->getProgramID() == $workshop->getProgramID() )
	{
		if( $workshop->deleteWorkshop($id))
		{
			//record if successful
			$user->addEvent("Deleted Workshop" . $id);
		}
	}
	
	header("location: index.php");
}
elseif ( isset($remove) )
{
	$workshop = new Workshop( $user_programID );
	$workshop->getWorkshop( $workshopIDG );
	
	if( $workshop->removeWorkshopParticipant( $workshopIDG , $remove ))
	{
		//log if successful
		$user->addEvent( "Removed Workshop Participant: " . $workshop->getTitle() , $workshop->getTitle() );
	}
	
	//redirect to edit page
	header("location:view.php?id=" . $workshop->getWorkshopID());
}
elseif( isset($completed) )
{
	$workshop = new Workshop( $user_programID );
	$workshop->getWorkshop( $workshopIDG );
	
	if( $workshop->completedWorkshopParticipant( $workshopIDG, $completed ))
	{
		//log if successful
		$user->addEvent( "Workshop Participant Completed: " . $workshop->getTitle() , $workshop->getTitle() );
	}
	
	//redirect to edit page
	header("location:view.php?id=" . $workshop->getWorkshopID());
}

?>