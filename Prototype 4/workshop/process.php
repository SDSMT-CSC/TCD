<?
include($_SERVER['DOCUMENT_ROOT']."/includes/secure.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_workshop.php");

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

if( $action == "Add Workshop" ) {
	$workshop = new Workshop();
	
	//need to ask Andrew on how the validation works, this will break if given in any other format
	$storeDate = $_POST["date"] . " " . $_POST["time"];
	
	$workshop->setProgramID( $_POST["programID"] );
	$workshop->setDate( $storeDate );
	$workshop->setTitle( $_POST["title"] );
	$workshop->setDescription( $_POST["description"] );
	$workshop->setInstructor( $_POST["instructor"] );
	$workshop->setOfficerID( $_POST["officer"] );
	
	if( $workshop->addWorkshop() )
	{
		//log if successful
		$user->addEvent( "Added Workshop: " . $workshop->getTitle() );
	}
	
	//redirect to edit page
	header("location:view.php?id=" . $workshop->getWorkshopID());
} elseif( $action == "Edit Workshop" ) {
	$workshop = new Workshop();
	
	//need to ask Andrew on how the validation works, this will break if given in any other format
	$storeDate = $_POST["date"] . " " . $_POST["time"];
	
	$workshop->setWorkshopID( $_POST["workshopID"] );
	$workshop->setDate( $storeDate );
	$workshop->setTitle( $_POST["title"] );
	$workshop->setDescription( $_POST["description"] );
	$workshop->setInstructor( $_POST["instructor"] );
	$workshop->setOfficerID( $_POST["officer"] );
	
	if( $workshop->editWorkshop() )
	{
		//log if successful
		$user->addEvent( "Edited Workshop: " . $workshop->getTitle() );
	}
	
	//redirect to edit page
	header("location:view.php?id=" . $workshop->getWorkshopID());
} elseif ( $action == "Add Participant" ) {
	$workshop = new Workshop();
	$workshop->getWorkshop( $workshopIDP );
	
	if( $workshop->addWorkshopParticipant( $workshopIDP, $add ))
	{
		//log if successful
		$user->addEvent( "Added Workshop Participant: " . $workshop->getTitle() , $workshop->getTitle() );
	}
	
	//redirect to edit page
	header("location:view.php?id=" . $workshop->getWorkshopID());
} elseif ( isset($remove) ) {
	$workshop = new Workshop();
	$workshop->getWorkshop( $workshopIDG );
	
	if( $workshop->removeWorkshopParticipant( $workshopIDG , $remove ))
	{
		//log if successful
		$user->addEvent( "Removed Workshop Participant: " . $workshop->getTitle() , $workshop->getTitle() );
	}
	
	//redirect to edit page
	header("location:view.php?id=" . $workshop->getWorkshopID());
} elseif ( isset($completed) ) {
	$workshop = new Workshop();
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