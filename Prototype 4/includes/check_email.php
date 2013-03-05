<?
header('Content-type: application/json');

include($_SERVER['DOCUMENT_ROOT']."/includes/class_core.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_user.php");

$email = trim(strtolower($_REQUEST['email']));

$user = new User();

if( $user->emailExists( $email ) )
{
	$message = "Email address already exists";
}
else
{
	$message = true;
}
		
echo json_encode($message);

?>