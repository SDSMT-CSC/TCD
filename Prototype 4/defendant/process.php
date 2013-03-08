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
	echo "<pre>";
	print_r($_POST);
	echo "</pre>";


}



if( $action == "Add School" )
{
  echo $program->addSchool( $_POST["school"] );
}
?>