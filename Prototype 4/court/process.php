<?
include($_SERVER['DOCUMENT_ROOT']."/includes/secure.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_court.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_court_location.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_location.php");

$action = $_REQUEST["action"];


/*********************************************************************************************
	PRIMARY INFORMATION
*********************************************************************************************/
if( $action == "Add Court" || $action == "Edit Court" )
{

	$court = new Court( $user_programID );
	
	if( $_POST["courtID"] > 0 ) { $court->setCourtID( $_POST["courtID"] ); }	
	$court->setDefendantID( $_POST["court-defendantID"] );
	$court->courtDate = $_POST["court-date"] . " " . $_POST["court-time"];
	$court->type = $_POST["court-type"];
	$court->contractSigned = ( $_POST["court-contract"] == "Yes") ? 1 : 0;
	$court->closed = ( $_POST["court-closed"] ) ? date( 'Y-m-d H:i:s', time() ) : NULL;

	// check court location
	$courtLocation = new courtLocation( $user_programID );
	$courtLocation->name = $_POST["court-name"];
	$courtLocation->address = $_POST["court-address"];
	$courtLocation->city = $_POST["court-city"];
	$courtLocation->state = $_POST["court-state"];
	$courtLocation->zip = $_POST["court-zip"];
	
	// add/get program location id
	$location = new Location( $user_programID );
	$courtLocation->locationID = $location->addLocation( $_POST["court-city"], $_POST["court-state"], $_POST["court-zip"] );
  
	// update the court location and get id
	$courtLocation->updateCourtLocation();
	$court->courtLocationID = $courtLocation->getCourtLocationID();

	// update the court information and add	log the event
	if( $court->updateCourt() )
		$user->addEvent( "Court: " . $action, $court->getCourtID() );
		
	// redirect to court page
	header("location: view.php?id=".$court->getCourtID() );
}

if( $action == "Update Court Members" )
{
	$court = new Court( $user_programID );
	$court->getFromID( $_POST["courtID"] );
	
	$members = array();
	
	foreach ( $_POST as $posID => $volID )
	{
		if( $posID != "courtID" && $posID != "action"  )
		{
		  $positionID = str_replace( "positionID-" , "", $posID );
			$members[$positionID] = $volID;
		}
	}
		
	// update the court members and add	log the event
	if( $court->updateCourtMembers( $members ) )
		$user->addEvent( "Court: " . $action, $court->getCourtID() );
		
	// redirect to court page
	header("location: view.php?id=".$court->getCourtID() );	
}

?>





