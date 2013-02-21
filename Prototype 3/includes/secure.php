<?
session_set_cookie_params(3600);
include($_SERVER['DOCUMENT_ROOT']."/includes/class_core.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_user.php");

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
		$user = new User();
		$user->getFromID( $_SESSION["userID"] );
		$user_programID = $user->getProgramID();
		$user_type = $user->getType();
}
?>