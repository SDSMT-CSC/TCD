<?
include($_SERVER['DOCUMENT_ROOT']."/includes/secure.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_court.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_court_location.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_location.php");

$action = $_REQUEST["action"];

/*********************************************************************************************
	Update Court
*********************************************************************************************/
if( $action == "Add Court" || $action == "Edit Court" )
{

	$court = new Court( $user_programID );
	
	if( $_POST["courtID"] > 0 ) { $court->setCourtID( $_POST["courtID"] ); }	
	$court->courtDate = $_POST["court-date"] . " " . $_POST["court-time"];
	//$court->type = $_POST["court-type"];

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

/*********************************************************************************************
	Update Court Members
*********************************************************************************************/
if( $action == "Update Court Members" )
{
	$court = new Court( $user_programID );
	$court->getFromCaseID( $_POST["caseID"] );
	
	$members = array();
	$hours = array();
	
	foreach ( $_POST as $posID => $volID )
	{
	  //using strpos to spot the h and p in hours and position, === for difference between 0 and false
		if( $posID != "caseID" && $posID != "action" )
    {
      if( strpos($posID, "h") === FALSE )
  		{
  		  $positionID = str_replace( "positionID-" , "", $posID );
  			$members[$positionID] = $volID;
  		}
      if( strpos($posID, "p") === FALSE )
      {
        $hourID = str_replace( "hours-" , "", $posID);
        $hours[$hourID] = $volID;
      }
    }
	}
  
	// update the court members and add	log the event
	if( $court->updateCourtMembers( $members, $hours ) )
		$user->addEvent( "Court Case: " . $action, $court->getCourtCaseID() );
		
	// redirect to court page
	header("location: hour_entry.php?id=".$court->getCourtCaseID() );	
}

/*********************************************************************************************
	Add Jury Members
*********************************************************************************************/
if( $action == "Add Jury Members" )
{
	$court = new Court( $user_programID );
	$court->getFromCaseID( $_POST["caseID"] );
	
	$members = split(",",$_POST["members"]);
		
	// update the court members and add	log the event
	if( $court->updateJuryMembers( $members ) )
		$user->addEvent( "Court Case: " . $action, $court->getCourtCaseID() );
		
	// redirect to court page
	header("location: hour_entry.php?id=".$court->getCourtCaseID() );	
}

/*********************************************************************************************
	Delete Jury Member
*********************************************************************************************/
if( $action == "Delete Jury Member" )
{
	$court = new Court( $user_programID );
	$court->getFromCaseID( $_GET["caseID"] );
			
	// update the court members and add	log the event
	if( $court->deleteJuryMember( $_GET["id"], $_GET["type"] ) )
		$user->addEvent( "Court: " . $action, $court->getCourtCaseID() );
		
	// redirect to court page
	header("location: hour_entry.php?id=".$court->getCourtCaseID() );	
}

/*********************************************************************************************
  Update Jury Hours
*********************************************************************************************/
if( $action == "Update Jury Hours" )
{
  $court = new Court( $user_programID );
  $court->getFromCaseID( $_POST["caseID"] );
  
  // update the court jury hours and log
  if( $court->setCaseJuryTime( $_POST["jury"]) )
    $user->addEvent( "Court: " . $action, $court->getCourtCaseID() );
  
  // redirect to court page
  header("location: hour_entry.php?id=".$court->getCourtCaseID() );
}

/*********************************************************************************************
  Update All Hours
*********************************************************************************************/
if( $action == "Set Global Hours" )
{
  $court = new Court( $user_programID );
  $court->getFromCaseID( $_POST["caseID"] );
    
  // update the court jury hours and log
  if( $court->setCaseGlobalTime( $_POST["global-hours"]) )
    $user->addEvent( "Court: " . $action, $court->getCourtCaseID() );
  
  // redirect to court page
  header("location: hour_entry.php?id=".$court->getCourtCaseID() );
}

/*********************************************************************************************
	Update Court Guardians
*********************************************************************************************/
if( $action == "Update Court Guardians" )
{
	$court = new Court( $user_programID );
	$court->getFromID( $_POST["courtID"] );
	
	// update the court members and add	log the event
	$court->updateCourtGuardians( $_POST["guardians"] );
	$user->addEvent( "Court: " . $action, $court->getCourtID() );
		
	// redirect to court page
	header("location: view.php?id=".$court->getCourtID() );	
}

/*********************************************************************************************
	Delete Court
*********************************************************************************************/
if( $action == "Delete Court" )
{
	$court = new Court( $user_programID );
	$court->getFromID( $_GET["id"] );

	// delete court and add event
	$court->deleteCourt();
	$user->addEvent( "Court: " . $action, $_GET["id"] );
		
	// redirect to court page
	header("location: index.php");		
}

/*********************************************************************************************
	Update Court Hours
*********************************************************************************************/
if( $action == "Update Court Hours" )
{
	$court = new Court( $user_programID );
	$court->getFromID( $_POST["courtID"] );

	// update times and add event
	$court->setMembersTime( $_POST["global-hours"], $_POST["members"], $_POST["jury"] );
	$user->addEvent( "Court: " . $action, $_POST["courtID"] );
		
	// redirect to court page
	header("location: hours.php");
}

/*********************************************************************************************
  Add Defendant Case
*********************************************************************************************/
if( $action == "Add Participant")
{
  $court = new Court( $user_programID );
  $court->getFromID( $_POST["courtID"] );
  
  if( $court->addCase( $_POST["add"]) )
    $user->addEvent( "Add Court Case: " . $court->getCourtID() );

  // redirect to court page
  header("location: view.php?id=".$court->getCourtID() ); 
}

/*********************************************************************************************
  Add Case Type
*********************************************************************************************/
if( $action == "Add Case Type")
{
  $court = new Court( $user_programID );
  $court->getFromCaseID( $_POST["caseID"]);
  
  if( $court->updateCaseType($_POST["court-type"]) )
    $user->addEvent( "Update Cast Type: ". $court->getCourtCaseID() );
    
  // redirect to case page
  header("location: hour_entry.php?id=". $court->getCourtCaseID() );
}

/*********************************************************************************************
  Delete Defendant Case
*********************************************************************************************/
if( $action == "Delete Case")
{
  $court = new Court( $user_programID );
  $court->getFromID( $_GET["courtID"] );
  
  if( $court->deleteCase($id))
    $user->addEvent( "Delete Court Case: ". $id );
  
  // redirect to court page
  header("location: view.php?id=".$court->getCourtID() );
}
?>