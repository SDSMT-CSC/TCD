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
	
	//break date and time into a form that can be stored
	//need to ask Andrew on how the validation works, this will break if given in any other format
	$date = $_POST["date"];
	$expDate = explode("/", $date);
	$newDate = $expDate[2] . "/" . $expDate[0] . "/" . $expDate[1];
	$time = $_POST["time"];
	$expTime = explode(":", $time);
	$exp2Time = explode(" ", $expTime[1]);
	if( $exp2Time[1] == "pm" )
		$expTime[0] = (int) $expTime[0] + 12;
	$newTime = $expTime[0] . ":" . $exp2Time[0] . ":00";
	$storeDate = $newDate . " " . $newTime;
	
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
} elseif ( $action == "Add Participant" ) {
	$workshop = new Workshop();
	$workshop->setWorkshopID( $workshopIDP );
	
	if( $workshop->addWorkshopParticipant( $workshopIDP, $add ))
	{
		//log if successful
		$user->addEvent( "Added Workshop Participant: " . $workshop->getWorkshopID() , $workshop->getWorkshopID() );
	}
	
	//redirect to edit page
	header("location:view.php?id=" . $workshop->getWorkshopID());
} elseif ( isset($remove) ) {
	$workshop = new Workshop();
	$workshop->setWorkshopID( $workshopIDP );
	
	if( $workshop->removeWorkshopParticipant( $workshopIDG, $remove ))
	{
		//log if successful
		$user->addEvent( "Removed Workshop Participant: " . $workshop->getWorkshopID() , $workshop->getWorkshopID() );
	}
	
	//redirect to edit page
	header("location:view.php?id=" . $workshop->getWorkshopID());
}

?>