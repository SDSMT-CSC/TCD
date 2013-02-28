<?
include($_SERVER['DOCUMENT_ROOT']."/includes/secure.php");

$action = $_REQUEST["action"];

if( $action == "Add User" || $action == "Edit User" )
{
	
	$mod_user = new User();
		
	if($action == "Edit User") { $mod_user->setUserID( $_POST["userID"] ); }
	$mod_user->setFirstName( $_POST["firstname"] );
	$mod_user->setLastName( $_POST["lastname"] );
	$mod_user->setProgramID( $_POST["programID"] );
	$mod_user->setType( $_POST["typeID"] );
	$mod_user->setEmail( $_POST["email"] );
	$mod_user->setTimezoneID( $_POST["timezoneID"] );
	$mod_user->setActive( $_POST["active"] );
	$mod_user->setPassword( $_POST["password"] );
	
	if( $mod_user->updateUser() )
	{
		// log the event
		$user->addEvent("Updated user: " . $mod_user->getEmail() );
	}
	
	// redirect to the user page	
	header("location: view_user.php?id=".$mod_user->getUserID() );
}

if( $action == "Delete User" )
{
	$mod_user = new User();
	$mod_user->getFromID($_GET["id"]);
	$email = $mod_user->getEmail(); // get the email address before removing
	
	if( $mod_user->removeUser($_GET["id"]) )
	{
		// log the event
		$user->addEvent("Updated user: " . $email );
	}
	
	// redirect to user list
	header("location: users.php");
}
?>