<?
header('Content-type: application/json');

include($_SERVER['DOCUMENT_ROOT']."/includes/class_core.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_user.php");

$type = $_GET['type'];
$email = trim(strtolower($_GET['email']));

$user = new User();
$exists = $user->emailExists( $email );

if( $type == "true" && $exists )
{
	$message = "Email address already exists";
}
else if( !$exists && $type == "false" )
{
  $message = "Email address doesnt exists";
}
else 
{
  $message = true;	
}
		
echo json_encode($message);

?>