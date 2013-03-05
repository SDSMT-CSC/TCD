<?
session_set_cookie_params(3600);
include($_SERVER['DOCUMENT_ROOT']."/includes/class_core.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_user.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_program.php");

session_start();
date_default_timezone_set($_SESSION['timezone']);

$cur_time = new DateTime();
$out_time = new DateTime($_SESSION["timestamp"]);
$out_time->modify("+1 hour");

if( ($cur_time > $out_time) || (!isset($_SESSION["valid"]) && !$_SESSION["valid"]) )
{
		session_unset(); 
        session_destroy(); 
		header("location: /index.php");
		die();
}
else
{
		// update session timestamp to keep user logged in as long as they are active
		$_SESSION["timestamp"] = date( 'Y-m-d H:i:s', time() );
		
		// get user information
		$user = new User();
		$user->getFromID( $_SESSION["userID"] );
		$user_programID = $user->getProgramID();
		$user_type = $user->getType();
		
		// get user's program information
		$program = new Program();
		$program->getFromID( $user->getProgramID() );
}
?>