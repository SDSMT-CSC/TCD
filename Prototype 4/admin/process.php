<?
include($_SERVER['DOCUMENT_ROOT']."/includes/secure.php");

// make sure only certain levels of user get access to this area
if( $user_type > 3 )
	header("location: /main.php");

$action = $_REQUEST["action"];

// Add/Edit user
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

	// log the event on success	
	if( $mod_user->updateUser() )
		$user->addEvent($action . ": " . $mod_user->getEmail(), $mod_user->getUserID() );
	
	// redirect to the user page	
	header("location: view_user.php?id=".$mod_user->getUserID() );
}

// Delete user (sets delete flag in db)
if( $action == "Delete User" )
{
	$mod_user = new User();
	$mod_user->getFromID($_GET["id"]);
	$email = $mod_user->getEmail(); // get the email address before removing
	
	// log the event on success	
	if( $mod_user->removeUser($_GET["id"]) )
		$user->addEvent( $action . ": " . $email, $mod_user->getUserID() );
	
	// redirect to user list
	header("location: users.php");
}

// Add/Edit program
if( $action == "Add Program" || $action == "Edit Program" )
{
	$mod_program = new Program();
  
  if($action == "Edit Program") { $mod_program->setProgramID( $_POST["programID"] ); }
  $mod_program->setCode( $_POST["code"] );
  $mod_program->setName( $_POST["name"]);
  $mod_program->phys_address = $_POST["pAddress"];
  $mod_program->phys_city = $_POST["pCity"];
  $mod_program->phys_state = $_POST["pState"];
  $mod_program->phys_zip = $_POST["pZip"];
  $mod_program->mail_address = $_POST["mAddress"];
  $mod_program->mail_city = $_POST["mCity"];
  $mod_program->mail_state = $_POST["mState"];
  $mod_program->mail_zip = $_POST["mZip"];
  $mod_program->phone = $_POST["phone"];
  $mod_program->expunge = $_POST["expunge"];
  $mod_program->timezoneID = $_POST["timezoneID"];
  
  // log the event on success
  if( $mod_program->updateProgram() )
    $user->addEvent($action . ": " . $mod_program->getName() );  
  
  // redirect to the user page  
  header("location: view_program.php?id=".$mod_program->getProgramID() );
}



?>