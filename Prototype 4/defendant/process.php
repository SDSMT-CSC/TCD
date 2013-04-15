<?
include($_SERVER['DOCUMENT_ROOT']."/includes/secure.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_defendant.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_school.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_location.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_guardian.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_citation.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_sentence.php");

$action = $_REQUEST["action"];

/*********************************************************************************************
	PRIMARY INFORMATION
*********************************************************************************************/
if( $action == "Add Defendant" || $action == "Edit Defendant" )
{
	$defendant = new Defendant();
	
	if( $_POST["defendantID"] > 0 ) { $defendant->setDefendantID( $_POST["defendantID"] ); }
	$defendant->setProgramID($program->getProgramID());
	$defendant->setFirstName($_POST["firstname"]);
	$defendant->setLastName($_POST["lastname"]);
	$defendant->setMiddleName($_POST["middlename"]);
	$defendant->setDateOfBirth($_POST["dob"]);
	$defendant->setPhoneNumber($_POST["phoneNumber"]);
	$defendant->setCourtCaseNumber($_POST["courtcase"]);
	$defendant->setAgencyNumber($_POST["agencycase"]);

	// update the defendant information and add	log the event
	if( $defendant->updateDefendant() )
		$user->addEvent("Defendant: ".$action, $defendant->getDefendantID() );
	
	// redirect to the defendant page	
	header("location: view.php?id=".$defendant->getDefendantID() );
}

/*********************************************************************************************
	TAB1: UPDATE PERSONAL INFORMATION
*********************************************************************************************/
if( $action == "Update Personal" )
{	
	$defendant = new Defendant();
	$defendant->getFromID( $_POST["defendantID"] );
	
	// add physical address and new physical location if not set
  $defendant->pAddress = $_POST["physical-address"];
  $defendant->mAddress = $_POST["mailing-address"];
		
	$location = new Location( $user_programID );
	$defendant->pID = $location->addLocation( $_POST["physical-city"], $_POST["physical-state"], $_POST["physical-zip"] );
	$defendant->mID = $location->addLocation( $_POST["mailing-city"], $_POST["mailing-state"], $_POST["mailing-zip"] );	
		
	// add school or return id of existing school
	$school = new School( $user_programID );
	$defendant->schoolID = $school->addSchool( $_POST["school-name"], $_POST["school-address"], $_POST["school-city"], $_POST["school-state"], $_POST["school-zip"] );
	
	// add the school grade and contact information
  $defendant->schoolGrade = $_POST["grade"];
  $defendant->schoolContactName = $_POST["contact"];
  $defendant->schoolContactPhone = $_POST["contact-phone"];

	// update the rest
	$defendant->sex = $_POST["sex"];
	$defendant->height = $_POST["height"];
	$defendant->weight = $_POST["weight"];
	$defendant->eyecolor = $_POST["eye"];
	$defendant->haircolor = $_POST["hair"];
	$defendant->ethnicity = $_POST["ethnicity"];
	$defendant->licenseNum = $_POST["dl-number"];
	$defendant->licenseState = $_POST["dl-state"];
		
	// update the personal information and log the event
	if( $defendant->updatePersonal() )
		$user->addEvent("Defendant: ".$action, $defendant->getDefendantID() );
		
	// redirect to the defendant page	
	header("location: view.php?id=".$defendant->getDefendantID() );
}

/*********************************************************************************************
	TAB2: GUARDIAN INFORMATION
*********************************************************************************************/
if( $action == "Add Guardian" || $action == "Update Guardian" )
{
	$guardian = new Guardian( $_POST["defendantID"] );
	
	if( $_POST["guardianID"] > 0 ) { $guardian->setGuardianID( $_POST["guardianID"] ); }
	$guardian->relation = $_POST["relationship"];
	$guardian->firstName = $_POST["first-name"];
	$guardian->lastName = $_POST["last-name"];
	$guardian->homePhone = $_POST["home-phone"];
	$guardian->workPhone = $_POST["work-phone"];
	$guardian->employer = $_POST["employer"];
	$guardian->email = $_POST["email"];
	$guardian->liveswith = $_POST["liveswith"];

	$guardian->pAddress = $_POST["guardian-physical-address"];
	$guardian->mAddress = $_POST["guardian-mailing-address"];
	
	$location = new Location( $user_programID );
	$guardian->pID = $location->addLocation( $_POST["guardian-physical-city"], $_POST["guardian-physical-state"], $_POST["guardian-physical-zip"] );
	$guardian->mID = $location->addLocation( $_POST["guardian-mailing-city"], $_POST["guardian-mailing-state"], $_POST["guardian-mailing-zip"] );	
	
	if( $guardian->updateGuardian() )
		$user->addEvent("Defendant: ".$action, $guardian->getGuardianID() );
	
	// redirect to the defendant page	
	header("location: view.php?id=".$guardian->getDefendantID() );
}

if( $action == "Delete Guardian" )
{
	$guardian = new Guardian( $_GET["id"] );
	$guardian->getFromID( $_GET["gid"] );
  $defendant = new Defendant();
  $defendant->getFromID( $guardian->getDefendantID() );
	
	// check access
	if( $user_type < 5 && $user->getProgramID() == $defendant->getProgramID() )
	{		
		if( $guardian->removeGuardian() )
			$user->addEvent("Defendant: ".$action, $guardian->getGuardianID() );
		
		// redirect to the defendant page	
		header("location: view.php?id=".$_GET["id"] );
	}
  else {
    // redirect to the defendant page 
    header("location: view.php?id=".$_GET["id"] );
  }
}

/*********************************************************************************************
	TAB3: CITATION INFORMATION
*********************************************************************************************/
if( $action == "Update Citation")
{
	$citation = new Citation( $_POST["defendantID"] );
	$citation->citationDate = $_POST["citation-date"] . " " . $_POST["citation-time"];
	$citation->officerID = $_POST["officerID"];
	$citation->mirandized = $_POST["miranda"];
	$citation->address = $_POST["citation-address"];
	$citation->drugsOrAlcohol = $_POST["drugs-alcohol"];
	$citation->commonLocationID = $program->addCommonLocation( $_POST["common-location"] );

	$location = new Location( $user_programID );
	$citation->locationID = $location->addLocation( $_POST["citation-city"], $_POST["citation-state"], $_POST["citation-zip"] );
	
	if( $citation->updateCitation() )
		$user->addEvent("Defendant: ".$action, $citation->getDefendantID() );
	
 	// redirect to the defendant page	
	header("location: view.php?id=".$citation->getDefendantID() );
}

// Add common location
if( $action == "Add Common Location")
{
	echo $program->addCommonLocation( $_POST["common-location-name"] );
}

// Add new officer
if( $action == "Add Officer")
{
	 echo $program->addOfficer( $_POST["officer-firstname"], $_POST["officer-lastname"], $_POST["officer-idNumber"], $_POST["officer-phone"] );
}

// Add existing statute as an offense
if( $action == "Add Offense")
{	
	$citation = new Citation( $_POST["defendantID"] );
	$citationID = $citation->addOffense( $_POST["statuteID"] );
	
	if( $citationID )
		$user->addEvent("Defendant: ".$action, $citation->getDefendantID() );
	
	echo $citationID;
}

// Remove an offense
if( $action == "Delete Offense")
{
	$citation = new Citation( $_GET["defendantID"] );
		
	if( $citation->removeOffense( $_GET["offenseID"] ) )
		$user->addEvent("Defendant: ".$action, $citation->getDefendantID() );
	
 	// redirect to the defendant page	
	header("location: view.php?id=".$citation->getDefendantID() );
}

// Add new statute
if( $action == "Add Statute" )
{
	$citation = new Citation( $_POST["defendantID"] );
	
	// add statute to program_statutes
	$statuteID = $program->addStatute( $_POST["statute-code"],	$_POST["statute-title"], $_POST["statute-description"] );
	
	if( $citation->addOffense( $statuteID ) )
		$user->addEvent("Defendant: ".$action, $statuteID );
	
 	// redirect to the defendant page	
	header("location: view.php?id=".$citation->getDefendantID() );
}

// Add stolen items
if( $action == "Add Stolen Item" )
{
	$citation = new Citation( $_POST["defendantID"] );
	
	if( $citation->addStolenItem( $_POST["item-name"], $_POST["item-value"] ) )
		$user->addEvent("Defendant: ".$action." (".$_POST["item-name"].")", $citation->getDefendantID() );
	
 	// redirect to the defendant page	
	header("location: view.php?id=".$citation->getDefendantID() );
}

// delete stolen item
if( $action == "Delete Stolen Item" )
{
	$citation = new Citation( $_GET["defendantID"] );
	
	if( $citation->removeStolenItem( $_GET["itemID"] ) )
		$user->addEvent("Defendant: ".$action, $citation->getDefendantID() );
	
 	// redirect to the defendant page	
	header("location: view.php?id=".$citation->getDefendantID() );
}

// add vehicle
if( $action == "Add Vehicle" )
{
	$citation = new Citation( $_POST["defendantID"] );

	if( $citation->addVehicle( $_POST["vehicle-year"], $_POST["vehicle-make"], $_POST["vehicle-model"], 
														 $_POST["vehicle-color"], $_POST["vehicle-license"], $_POST["vehicle-state"], $_POST["vehicle-comment"] ) )
		$user->addEvent("Defendant: ".$action." (".$_POST["item-name"].")", $citation->getDefendantID() );
	
 	// redirect to the defendant page	
	header("location: view.php?id=".$citation->getDefendantID() );
}

// delete vehicle
if( $action == "Delete Vehicle" )
{
	$citation = new Citation( $_GET["defendantID"] );
	
	if( $citation->removeVehicle( $_GET["vehicleID"] ) )
		$user->addEvent("Defendant: ".$action, $citation->getDefendantID() );
		
 	// redirect to the defendant page	
	header("location: view.php?id=".$citation->getDefendantID() );
}

/*********************************************************************************************
	TAB4: INTAKE INFORMATION
*********************************************************************************************/
if( $action == "Update Intake" )
{	
	$intake = $_POST["intake-date"]. " " . $_POST["intake-time"];
	$reschedule = ( $_POST["reschedule-date"] ) ? $_POST["reschedule-date"] . " " . $_POST["reschedule-time"] : NULL;
	
	$defendant = new Defendant();
	$defendant->getFromID( $_POST["defendantID"] );

	if( $defendant->updateIntake( $intake, $reschedule, $_POST["intake-inteviewer"], $_POST["intake-referred"], $_POST["intake-dismissed"] ) )
		$user->addEvent("Defendant: ".$action, $defendant->getDefendantID() );
	
 	// redirect to the defendant page	
	header("location: view.php?id=".$defendant->getDefendantID() );
}

/*********************************************************************************************
	TAB5: INTAKE INFORMATION
*********************************************************************************************/
if( $action == "Add Sentence" )
{
	$sentence = new Sentence( $_POST["defendantID"] );
	
	// add statute to program_statutes
	$sentenceID = $program->addSentence( $_POST["sentence-name"],	$_POST["sentence-description"], $_POST["sentence-type"], $_POST["sentence-additional"] );
	
	if( $sentence->addSentence( $sentenceID ) )
	$user->addEvent("Defendant: ".$action, $sentenceID );

	// redirect to the defendant page	
	header("location: view.php?id=".$sentence->getDefendantID() );
}

?>
