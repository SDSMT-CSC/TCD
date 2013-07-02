<?
include($_SERVER['DOCUMENT_ROOT']."/includes/secure.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_reports.php");

$report = new Reports();
$action = $_POST["report_type"];

//return user to reports page if type not selected (verify later)
if ( $_POST["report_type"] == NULL)
header("location: index.php");

//get header information
$report->buildHeader( $_POST["programID"], $_POST["report_type"], $_POST["start-date"], $_POST["end-date"]);
$report->printHeader();

//get report information, pass off to next page to generate report
if( $action == "Volunteer Hours" ) {
  $volunteers = $report->getVolunteers( $_POST["start-date"], $_POST["end-date"], $_POST["programID"] );
  $report->printVolunteers( $volunteers );
}

if( $action == "Demographics") {
  $defendants = $report->getDemographics( $_POST["start-date"], $_POST["end-date"], $_POST["programID"]);
  $report->printDemographics( $defendants );
}

?>