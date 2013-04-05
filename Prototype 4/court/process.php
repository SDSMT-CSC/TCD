<?
include($_SERVER['DOCUMENT_ROOT']."/includes/secure.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_court.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_court_location.php");

$action = $_REQUEST["action"];


/*********************************************************************************************
	PRIMARY INFORMATION
*********************************************************************************************/
if( $action == "Add Court" || $action == "Edit Court" )
{

	$court = new Court( $user_programID );
	
	$court->setDefendantID( $_POST["court-defendantID"] );
	$court->courtDate = $_POST["court-date"] . " " . $_POST["court-time"];
	$court->type = $_POST["court-type"];
	$court->contractSigned = ( $_POST["court-contract"] == "Yes") ? 1 : 0;
	$court->closed = ( $_POST["court-closed"] ) ? date( 'Y-m-d H:i:s', time() ) : NULL;

	// update the court information and add	log the event
	if( $court->updateCourt() )
		$user->addEvent( "Court: " . $action, $court->getCourtID() );
		
	// redirect to court page
	header("location: view.php?id=".$court->getCourtID() );
	
}

?>