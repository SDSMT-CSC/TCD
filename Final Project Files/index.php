<?php
include("includes/class_core.php");
session_start();

if($_POST["submit"] == "Enter")
{
	$email = $_POST["email"];
	$password = $_POST["password"];
	
		$_SESSION["valid"] = true;
		header("location: /main.php");
	/*
	if($email)
	{
		header("location: /index.php?error");
	}
	else
	{	
		$_SESSION["valid"] = true;
		header("location: /main.php");
	}
	*/
}

if(isset($_GET["error"])) { $message = "Unable to login"; }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Teen Court Database</title>
	<meta http-equiv="content-type" content="text/html;charset=UTF-8">
	<meta http-equiv="Content-type" content="text/html">
	<meta http-equiv="Cache-Control" content="must-revalidate">
	<meta http-equiv="Cache-Control" content="no-store">
	<meta http-equiv="Cache-Control" content="no-cache">
	<meta http-equiv="Cache-Control" content="private">
	<meta http-equiv="Pragma" content="no-cache">
	
	<link rel="shortcut icon" href="favicon.ico">
	<style type="text/css" media="screen">
		@import "/includes/css/site.css";
		@import "/includes/css/jquery-ui-teencourt.css";
	</style>
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/jquery-ui.min.js" type="text/javascript"></script>
	<script src="/includes/js/jquery.corner.js" type="text/javascript"></script>
</head>

<body>

<script>
$(function() {
	$("#username").focus();
	$("#submit").button();
	$("#login-container").corner("20px");
});
</script>

<form id="loginForm" name="loginForm" method="post"action="index.php">
<div id="login-container">
	<div class="header"></div>
	<div id="login">
		<ul>
    	<li class="form-row">
				<label for="username">Email Address</label>
				<input type="text" name="email" id="email" class="input" />
			</li>
			<li class="form-row">
				<label for="password">Password</label>
				<input type="password" name="password" id="password" class="input" />
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
 
 
</body>
</html>