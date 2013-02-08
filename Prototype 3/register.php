<?php 
$areaname = "registration";

include($_SERVER['DOCUMENT_ROOT']."/includes/class_core.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_user.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/header_external.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/recaptchalib.php");

$submit = $_POST["submit"];
$error = 0;
?>

<h1>User Registration</h1>

<? 
if( !$submit ) { 

		// check email

		// check captcha


		$user = new User();
		if( $user->emailExists( $_POST["email"] ) )
		{
			$error = 1;
		}
		
		$privatekey = "6Le_gNsSAAAAAOZkcUElnPjfuceX6fmOFcJgTqB9";
		$resp = recaptcha_check_answer ($privatekey,
																	$_SERVER["REMOTE_ADDR"],
																	$_POST["recaptcha_challenge_field"],
																	$_POST["recaptcha_response_field"]);
		
		/*
		if (!$resp->is_valid) {
			// incorrect CAPTCHA
			die ("The reCAPTCHA wasn't entered correctly. Go back and try it again.");
		} else {
		// successful verification
		}
		*/		
}
?>
<script>
jQuery(function($)
{
	$("#submit").button();
	$('.password').pstrength();
	$("#recaptcha_response_field").css("border-color","#bbbaab");
	$("#recaptcha_response_field").blur();
	
	$("#registerForm").validate({
		errorElement: "div",
		wrapper: "div",
		errorPlacement: function(error, element) {
			  error.insertAfter(element);
				error.addClass('message');
		},
		rules: {
			code: { required: true },
			password1: { required: true },
			email: { required: true, email: true }
		}
	});
});
</script>

<script type="text/javascript">
 var RecaptchaOptions = {
    theme : 'clean'
 };
 </script>

<div class="ui-state-highlight ui-corner-all" style="margin-top: 10px; padding: 0 .7em;">
<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
To gain access to the Teen Court Database, enter the program code given to you
by your program administrator and your login information. An email will be sent
to your account that must be verified before access is granted.</p>
</div>

<div style="padding: .5em; font-style: italic;">Due to sensetive data contained in this website, it is advised you do not use a frequent password. 
Passwords should contain a combination of letters (both upper and lower case) and numbers along with special characters.</div>

<form id="registerForm" name="registerForm" method="post" >

<fieldset class="ui-corner-all">
	<legend>Regsitration Form</legend>
	<table>
		<tr>
			<td align="right">Teen/Youth Court Program Code</td>
			<td><input type="text" name="code" id="code" class="wide" /></td>
		</tr>
		<tr>
			<td align="right">Email Address</td>
			<td><input type="text" name="email" id="email" class="wide" /></td>
		</tr>
		<tr>
			<td align="right" valign="top">Password</td>
			<td><input type="password" name="password1" id="password1"  class="wide password" /></td>
		</tr>
		<tr>
			<td align="right">Retype Password</td>
			<td><input type="password" name="password2" id="password2" class="wide" /></td>
		</tr>
		<tr>
			<td align="right" valign="top" style="padding-bottom:3px;">Prove you are a real person!<br>Retype the characters from the picture</td>			
			<td>
				<?php 
  				$publickey = "6Le_gNsSAAAAAMQuZZBUxdtnFeSWqNLW_AwAxEc4"; 
  				echo recaptcha_get_html($publickey);
				?>
			</td>
		</tr>
		<tr>
			<td></td>
      <td><input type="submit" class="submitButton" name="submit" id="submit" value="Register Account"/></td>
		</tr>
	</table>
	</fieldset>
</form>
	
<?php  
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_external.php");
?>
