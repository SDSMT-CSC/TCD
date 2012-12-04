<?php
include("includes/class_core.php");
session_start();

if($_POST["submit"] == "Enter")
{
	$email = $_POST["email"];
	$password = $_POST["password"];
	
	if($email)
	{
		header("location: /index.php?error");
	}
	else
	{	
		$_SESSION["valid"] = true;
		header("location: /main.php");
	}
}

if(isset($_GET["error"])) { $message = "Unable to login"; }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Teen Court Database</title>
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" type="text/css" href="/includes/css/site.css" />
<link type="text/css" href="/includes/css/jquery-ui-teencourt.css" rel="Stylesheet" />
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
	<div class="register"><a href="/register.php">Register Your Account</a></div>
</div>
</form>
 
 
</body>
</html>