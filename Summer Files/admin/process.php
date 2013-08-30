<?
//BUG: Forms on program_data.php are submitting twice and the action isn't being
//updated. Checking to see if 'submit' is included instead of looking at action.
include($_SERVER['DOCUMENT_ROOT']."/includes/secure.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_location.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_school.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_citation.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_sentence.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_court_location.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_workshop_location.php");

// make sure only certain levels of user get access to this area
if( $user_type > 3 )
	header("location: /main.php");

$action = $_REQUEST["action"];

// Add/Edit user
if( $action == "Add User" || $action == "Edit User" )
{
	$mod_user = new User();
		
	if($action == "Edit User") { $mod_user->setUserID( $_POST["userID"] ); }
	$mod_user->setFirstName( $_POST["firstname"] );
	$mod_user->setLastName( $_POST["lastname"] );
	$mod_user->setProgramID( $_POST["programID"] );
	$mod_user->setType( $_POST["typeID"] );
	$mod_user->setEmail( $_POST["email"] );
	$mod_user->setTimezoneID( $_POST["timezoneID"] );
	$mod_user->setActive( $_POST["active"] );
	$mod_user->setPassword( $_POST["password"] );

	// log the event on success	
	if( $mod_user->updateUser() )
		$user->addEvent($action . ": " . $mod_user->getEmail(), $mod_user->getUserID() );
	
	// redirect to the user page	
	header("location: view_user.php?id=".$mod_user->getUserID() );
}

// Delete user (sets delete flag in db)
if( $action == "Delete User" )
{
	$mod_user = new User();
	$mod_user->getFromID($_GET["id"]);
	$email = $mod_user->getEmail(); // get the email address before removing
	
	// log the event on success	
	if( $mod_user->removeUser($_GET["id"]) )
		$user->addEvent( $action . ": " . $email, $mod_user->getUserID() );
	
	// redirect to user list
	header("location: users.php");
}

// Add/Edit program
if( $action == "Add Program" || $action == "Edit Program" )
{
	$mod_program = new Program();
  
  if($action == "Edit Program") { $mod_program->setProgramID( $_POST["programID"] ); }
  $mod_program->setCode( $_POST["code"] );
  $mod_program->setName( $_POST["name"]);
  $mod_program->phys_address = $_POST["pAddress"];
  $mod_program->phys_city = $_POST["pCity"];
  $mod_program->phys_state = $_POST["pState"];
  $mod_program->phys_zip = $_POST["pZip"];
  $mod_program->mail_address = $_POST["mAddress"];
  $mod_program->mail_city = $_POST["mCity"];
  $mod_program->mail_state = $_POST["mState"];
  $mod_program->mail_zip = $_POST["mZip"];
  $mod_program->phone = $_POST["phone"];
  $mod_program->expunge = $_POST["expunge"];
  $mod_program->timezoneID = $_POST["timezoneID"];
  $mod_program->active = $_POST["active"];
  
    
  // log the event on success
  if( $mod_program->updateProgram() )
    $user->addEvent($action . ": " . $mod_program->getName() );  
  
  // redirect to the user page  
  header("location: view_program.php?id=".$mod_program->getProgramID() );
}

///////////////////////////////////////////////////////////////////////////////

if( $action == "Edit Location") {
  if (isset($_POST["submit"])) {
    $location = new Location( $user_programID );
    $location->city = $_POST["location-city"];
    $location->state = $_POST["location-state"];
    $location->zip = $_POST["location-zip"];
    if( $_POST["location-id"] == '')
      $location->addLocation( $location->city, $location->state, $location->zip);
    else {
      $location->locationID = $_POST["location-id"];
      $location->updateLocation();
    }
  }
  else {
    $location = new Location( $user_programID );
    $location->deleteLocation( $_POST["location-id"] );
  }
  
  header("location: program_data.php?action=Edit%20Location");
}

///////////////////////////////////////////////////////////////////////////////

if( $action == "Edit Common Location") {
  if (isset($_POST["submit"] ) ) {
    if( $_POST["common-locationID"] != '') {
      $program->editCommonLocation( $_POST["common-locationID"], $_POST["common-location"] );
      $user->addEvent($action); 
    } else {
      $program->addCommonLocation( $_POST["common-location"] );
      $user->addEvent($action); 
    }
  } else {
    $program->deleteCommonLocation( $_POST["common-locationID"] );
  }
  
  header("location: program_data.php?action=Edit%20Common%20Location");
}

///////////////////////////////////////////////////////////////////////////////

if( $action == "Edit Officers") {
  if (isset($_POST["submit"] ) ) {
    if( $_POST["officer-id"] != '') {
      $program->editOfficer( $_POST["officer-firstname"], $_POST["officer-lastname"], 
      $_POST["officer-idNumber"], $_POST["officer-phone"], $_POST["officer-id"]);
    } else {
      $program->addOfficer( $_POST["officer-firstname"], $_POST["officer-lastname"], 
      $_POST["officer-idNumber"], $_POST["officer-phone"]);
    }
  } else {
    $program->deleteOfficer( $_POST["officer-id"]);
  }
  
  header("location: program_data.php?action=Edit%20Officers");
}

///////////////////////////////////////////////////////////////////////////////

if( $action == "Edit Statutes") {
  if( isset( $_POST["submit"] ) ) {
    if( $_POST["statuteID"] != '') {
      $program->editStatute( $_POST["statute-code"], $_POST["statute-title"],
      $_POST["statute-description"], $_POST["statuteID"] );
    } else {
      $program->addStatute( $_POST["statute-code"],
      $_POST["statute-title"], $_POST["statute-description"] );
    }
  } else {
    $program->deleteStatute( $_POST["statuteID"] );
  }

  header("location: program_data.php?action=Edit%20Statutes");
}

///////////////////////////////////////////////////////////////////////////////

if( $action == "Edit Schools") {
  $school = new School( $user_programID );
  if( isset( $_POST["submit"] ) ) {
    if( $_POST["schoolID"] != '') {
      $school->editSchool( $_POST["school-name"], $_POST["school-address"],
      $_POST["school-city"], $_POST["school-state"], $_POST["school-zip"],
      $_POST["schoolID"] );
    } else {
      $school->addSchool( $_POST["school-name"], $_POST["school-address"],
      $_POST["school-city"], $_POST["school-state"], $_POST["school-zip"] );
    }
  } else {
    $school->deleteSchool( $_POST["schoolID"] );
  }
  
  header("location: program_data.php?action=Edit%20Schools");
}

///////////////////////////////////////////////////////////////////////////////

if( $action == "Edit Positions") {
  if( isset( $_POST["submit"] ) ) {
    if( $_POST["positionID"] != '' ){
      $program->editPosition( $user_programID, $_POST["position"], $_POST["positionID"] );
    } else {
      $program->addPosition( $user_programID, $_POST["position"] );
    }
  } else {
    $program->deletePosition( $_POST["positionID"] );
  }
  
  header("location: program_data.php?action=Edit%20Positions");
}

///////////////////////////////////////////////////////////////////////////////

if( $action == "Edit Court Locations") {
  $courtLocation = new courtLocation( $user_programID );
  $courtLocation->name = $_POST["court-name"];
  $courtLocation->address = $_POST["court-address"];
  $courtLocation->city = $_POST["court-city"];
  $courtLocation->state = $_POST["court-state"];
  $courtLocation->zip = $_POST["court-zip"];
  
  $location = new Location( $user_programID );
  $courtLocation->locationID = $location->addLocation( $_POST["court-city"], $_POST["court-state"], $_POST["court-zip"] );
  
  if( isset( $_POST["submit"] ) ) {
    if( $_POST["court-location-id"] != '') {
      $courtLocation->setCourtLocationID( $_POST["court-location-id"] );
      $courtLocation->editCourtLocation();
    } else {
      $courtLocation->updateCourtLocation();
    }
  } else {
    $courtLocation->setCourtLocationID( $_POST["court-location-id"] );
    $courtLocation->deleteCourtLocation();
  }
  
  header("location: program_data.php?action=Edit%20Court%20Locations");
}

///////////////////////////////////////////////////////////////////////////////

if( $action == "Edit Sentence") {
  if( isset( $_POST["submit"] ) ) {
    if( $_POST["sentenceID"] != '') {
      $program->editSentence( $_POST["sentence-name"], $_POST["sentence-description"],
      $_POST["sentence-additional"], $_POST["sentenceID"] );
    } else {
      $program->addSentence( $_POST["sentence-name"], $_POST["sentence-description"],
      $_POST["sentence-additional"] );
    }
  } else {
    $program->deleteSentence( $_POST["sentenceID"] );
  }
  
  header("location: program_data.php?action=Edit%20Sentence");
}

///////////////////////////////////////////////////////////////////////////////

if( $action == "Edit Workshop") {
  $workshop = new WorkshopLocation( $user_programID );
  $workshop->name = $_POST["workshop-name"];
  $workshop->address = $_POST["workshop-address"];
  $workshop->locationID = $_POST["location-id"];
  
  if( $_POST["workshop-location-id"] == '') {
    $workshop->updateWorkshopLocation();
  } else {
    $workshop->editWorkshopLocation( $_POST["workshop-location-id"] );
  }
  
  header("location: program_data.php?action=Edit%20Workshop%20Location" );
}
if( $action == "Delete Workshop") {
  $workshop = new WorkshopLocation( $user_programID );
  $workshop->deleteWorkshopLocation( $_POST["workshop-location-id"] );
  
  header("location: program_data.php?action=Edit%20Workshop%20Location" );
}

///////////////////////////////////////////////////////////////////////////////

if( $action == "Program Access") {
  $program->addProgramAccess( $_POST["program-code"] );
  header("location: program_data.php?action=Record%20Access" );
}
if( $action == "Delete Program Access") {
  $program->deleteProgramAccess( $_POST["programID"] );
  header("location: program_data.php?action=Record%20Access" );
}

if( $action == "Delete Program" ) {
  $mod_program = new Program();
  $mod_program->getFromID($_POST["programID"]);
  $mod_program->removeProgram();
  //$mod_program->deleteProgram(); //DO NOT USE, FULL DELETE
  header("location: view_program.php?id=".$mod_program->getProgramID() );
}
?>