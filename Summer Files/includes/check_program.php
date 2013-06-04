<?
header('Content-type: application/json');

include($_SERVER['DOCUMENT_ROOT']."/includes/class_core.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_program.php");

$email = trim(strtoupper($_REQUEST['code']));

$program = new Program();

if( $program->programExists( $code ) )
{
	$message = true;
}
else
{
	$message = "Program dosn't exists";
}
		
echo json_encode($message);

?>