<?
include($_SERVER['DOCUMENT_ROOT']."/includes/secure.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_defendant.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_school.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_location.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_guardian.php");

$action = $_REQUEST["action"];

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


if( $action == "Add Parent" || $action == "Update Parent" )
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
	$guardian->livesWith = $_POST["liveswith"];

	$guardian->pAddress = $_POST["guardian-physical-address"];
	$guardian->mAddress = $_POST["guardian-mailing-address"];
	
	$location = new Location( $user_programID );
	$guardian->pID = $location->addLocation( $_POST["guardian-physical-city"], $_POST["guardian-physical-state"], $_POST["guardian-physical-zip"] );
	$guardian->mID = $location->addLocation( $_POST["guardian-mailing-city"], $_POST["guardian-mailing-state"], $_POST["guardian-mailing-zip"] );	
	
	//if( $guardian->updateGuardian() )
	//	$user->addEvent("Defendant: ".$action, $guardian->getGuardianID() );
	
	echo $guardian->getGuardianID();
}

?>