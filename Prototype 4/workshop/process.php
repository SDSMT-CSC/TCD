<?
include($_SERVER['DOCUMENT_ROOT']."/includes/secure.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_workshop.php");

// make sure only certain levels of user get access to this area
if( $user_type == 1 )
{
	header("location: /main.php");
}

//get the action to be taken
$action = $_REQUEST["action"];

if( $action == "Add Workshop" )
{
	$new_workshop = new Workshop();
	
	$new_workshop->setProgramID( $_POST["programID"] );
	//NEED TO EDIT DATE AND TIME FIELDS TO BE A VALID DATETIME UNIT
	//date is handled mm/dd/yyyy
	//time is handled hh:mm am/pm
	//datetime is handled yyyy/mm/dd hh:mm:ss
	$new_workshop->setDate( $_POST["date"] );
	$new_workshop->setTitle( $_POST["title"] );
	$new_workshop->setDescription( $_POST["description"] );
	$new_workshop->setInstructor( $_POST["instructor"] );
	$new_workshop->setOfficerID( $_POST["officer"] );
	
	if( $new_workshop->addWorkshop() )
	{
		//log if successful
		$user->addEvent( "Added Workshop: " . $new_workshop->getTitle() );
	}
	
	//redirect to edit page
	header("location:view.php?id=" . $new_workshop->getWorkshopID());
}
?>