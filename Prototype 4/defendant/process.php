<?
include($_SERVER['DOCUMENT_ROOT']."/includes/secure.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_defendant.php");

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
		
	if( $defendant->updateDefendant() )
	{
		// log the event
		$user->addEvent($action . ": " . $defendant->getLastName() . ", " . $defendant->getFirstName() . " (" . $defendant->getCourtCaseNumber() . ")" );
	}
	
	// redirect to the user page	
	header("location: view.php?id=".$defendant->getDefendantID() );
}


if( $action == "Update Personal" )
{
	$defendant = new Defendant();
	$defendant->getFromID( $_POST["defendantID"] );
	
	echo "<pre>";
	print_r($_POST);
	echo "<pre>";
	
/*
   [defendantID] => 1
    [action] => Update Personal
    [physical-address] => 12 South St
    [physical-locationID] => 1
    [physical-city] => Deadwood
    [physical-state] => SD
    [physical-zip] => 57732
    [mailing-address] => 12 South St
    [mailing-locationID] => 1
    [mailing-city] => Deadwood
    [mailing-state] => SD
    [mailing-zip] => 57732
    [school-name] => Central High School
    [grade] => 11
    [school-address] => 1246 Main Blvd.
    [schoolID] => 0
    [school-city] => Deadwood
    [school-state] => SD
    [school-zip] => 57732
    [contact] => Bob Jones
    [contact-phone] => 954-4564
    [height] => 5'10"
    [weight] => 125
    [eye] => Blue
    [hair] => Brown
    [ethnicity] => Caucasian
    [dl-number] => 1002546
    [dl-state] => SD
*/

}



if( $action == "Add School" )
{
  echo $program->addSchool( $_POST["school"] );
}
?>