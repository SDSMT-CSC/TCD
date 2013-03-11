<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/class_core.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_user.php");

session_start();

if($_POST["submit"] == "Enter")
{
	$email = $_POST["email"];
	$password = $_POST["password"];
	
	$user = new User();
	
	if( $user->getFromLogin( $email, $password ) )
	{
		$_SESSION["valid"] = true;
		$_SESSION["userID"] = $user->getUserID();
		$_SESSION["timezone"] = $user->getTimezone();
		$_SESSION["timestamp"] = date( 'Y-m-d H:i:s', time() );

		$user->addEvent("Login");
				
		// if user is an admin, send them to admin landing page
		// otherwise to main landing page
		if( $user->getType() == 1 )
		{
			header("location: /admin/programs.php");
		}
		else 
		{
			header("location: /main.php");	
		}
	}
	else
	{	
		header("location: /index.php?error");
	}
	
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="en" lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Teen Court Database</title>
	<meta http-equiv="content-type" content="text/html;charset=UTF-8">
	<meta http-equiv="Content-type" content="text/html">
	<meta http-equiv="Cache-Control" content="must-revalidate">
	<meta http-equiv="Cache-Control" content="no-store">
	<meta http-equiv="Cache-Control" content="no-cache">
	<meta http-equiv="Cache-Control" content="private">
	<meta http-equiv="Pragma" content="no-cache">
	
	<link rel="shortcut icon" href="/favicon.ico">
	<style type="text/css" media="screen">
		@import "/includes/css/site.css";
		@import "/includes/css/jquery-ui-teencourt.css";
	</style>
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/jquery-ui.min.js" type="text/javascript"></script>
	<script src="/includes/js/jquery.validate.min.js" type="text/javascript"></script>
</head>

<body>

<script>
$(function() {
	$("#email").focus();
	$("#submit").button();
	
	$("#loginForm").validate({
		errorElement: "div",
		wrapper: "div",
		errorPlacement: function(error, element) {
			  error.insertAfter(element);
				error.addClass('message');
				error.addClass('message-login');
		},
		rules: {
			email: {
				required: true,
				email: true
			},
			password: {
				required: true
			}
		}
	});

});
</script>


<form id="loginForm" name="loginForm" method="post"action="index.php">
<div id="login-container">
	<div class="header"></div>
	<div id="login">
		<ul>
    	<li class="form-row">
				<label for="email">Email Address</label>
				<input type="text" name="email" id="email" />
			</li>
			<li class="form-row">
				<label for="password">Password</label>
				<input type="password" name="password" id="password" />
			</li>
			<li class="button-row">
				<input type="submit" class="submitButton" name="submit" id="submit" value="Enter" />
			</li>
		</ul>
  </div>
</div>
</form>

<div class="register">
<a href="/register.php">Register Your Account</a> | <a href="/recover_password.php">Forgot Password</a>
</div>

<? if(isset($_GET["error"])) {  ?>
<div class="ui-state-error login-error">
	<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
	There was a problem with your login. Contact your program administrator if the problem persists.
</div>
<? } ?> 
 
</body>
</html>