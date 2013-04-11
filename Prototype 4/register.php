<?php 
$areaname = "registration";

include($_SERVER['DOCUMENT_ROOT']."/includes/class_core.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_user.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_program.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/header_external.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/recaptchalib.php");

$submit = $_POST["submit"];
$error = 0;
?>

<h1>User Registration</h1>
<div class="ui-state-highlight ui-corner-all" style="margin-top: 10px; padding: 0 .7em;">
<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
To gain access to the Teen Court Database, enter the program code given to you
by your program administrator and your login information. An email will be sent
to your account that must be verified before access is granted.</p>
</div>

<? 
if( !$submit ) { 
?>
<script type="text/javascript">
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
			code: { required: true,  remote: "/includes/check_program.php" },
			firstname: { required: true },
			password1: { required: true, minlength: 6 },
			password2: { required: true, minlength: 6, equalTo: "#password1" },
			email: { required: true, email: true, remote: "/includes/check_email.php?type=true" },
			recaptcha_response_field: { required: true }
		}
	});
});
</script>



<script type="text/javascript">

var RecaptchaOptions = {
    theme : 'custom',
    custom_theme_widget: 'recaptcha_widget'
};

 function showRecaptcha(element) {
	 Recaptcha.create("6Le_gNsSAAAAAMQuZZBUxdtnFeSWqNLW_AwAxEc4", element, {
		 theme: "custom",
		 callback: Recaptcha.focus_response_field});
 }
</script>

<div style="padding: .5em; font-style: italic;">Due to sensitive data contained in this website, it is advised you do not use a frequent password. 
Passwords should contain a combination of letters (both upper and lower case) and numbers along with special characters.</div>

<form id="registerForm" name="registerForm" method="post" action="#">

<fieldset class="ui-corner-all">
	<legend>Regsitration Form</legend>
	<table>
		<tr>
			<td align="right">Teen/Youth Court Program Code</td>
			<td><input type="text" name="code" id="code" class="wide" /></td>
		</tr>
		<tr>
			<td align="right">First Name</td>
			<td><input type="text" name="firstname" id="firstname" class="wide" /></td>
		</tr>
		<tr>
			<td align="right">Last Name</td>
			<td><input type="text" name="lastname" id="lastname" class="wide" /></td>
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
			<td align="right" valign="top" style="padding-bottom:3px;">Prove you are a real person!<br /> Enter the characters from the picture.</td>			
			<td>
        <div id="recaptcha_widget" style="display:none">

         <div id="recaptcha_image" style="border: 1px solid #ababab"></div>
         <div class="recaptcha_only_if_incorrect_sol" style="color:red">Incorrect please try again</div>
            
         <input type="text" id="recaptcha_response_field" name="recaptcha_response_field" class="wide" style="margin-top: 5px;" />
      
         <div><a href="javascript:Recaptcha.reload()">Can't read it? Get another CAPTCHA</a></div>
         <div class="recaptcha_only_if_audio">
         	<a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a>
         	<a href="javascript:Recaptcha.showhelp()">Help</a>
         </div>
      
       </div>
       
       <script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=6Le_gNsSAAAAAMQuZZBUxdtnFeSWqNLW_AwAxEc4"></script>
			 <noscript>
				 <iframe src="http://www.google.com/recaptcha/api/noscript?k=6Le_gNsSAAAAAMQuZZBUxdtnFeSWqNLW_AwAxEc4" height="300" width="500" frameborder="0"></iframe><br />
				 <textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
				 <input type="hidden" name="recaptcha_response_field"	value="manual_challenge" />
			 </noscript>
       
			</td>
		</tr>
		<tr>
			<td></td>
      <td><input type="submit" class="submitButton" name="submit" id="submit" value="Register Account"/></td>
		</tr>
	</table>
	</fieldset>
</form>
<?
}
else
{
		$privatekey = "6Le_gNsSAAAAAOZkcUElnPjfuceX6fmOFcJgTqB9";
		$resp = recaptcha_check_answer ($privatekey,
																		$_SERVER["REMOTE_ADDR"],
																		$_REQUEST["recaptcha_challenge_field"],
																		$_REQUEST["recaptcha_response_field"]);
		
		if (!$resp->is_valid) 
		{
			die("<p>ReCaptcha was entered wrong, please go <a href=\"/register.php\">back</a> and fill out the form.</p>");
		} 
		else 
		{
			$mod_program = new Program;
			$mod_program->getFromCode( $_POST["code"] );
			
			$mod_user = new User;
			$mod_user->setFirstName( $_POST["firstname"] );
			$mod_user->setLastName( $_POST["lastname"] );
			$mod_user->setEmail( $_POST["email"] );
			$mod_user->setPassword( $_POST["password1"] );
			$mod_user->setProgramID( $mod_program->getProgramID() );
			$mod_user->setTimezoneID( $mod_program->timezoneID );
			$mod_user->setActive( 0 );
			$mod_user->setType( 5 );
			
			$mod_user->updateUser();
			
			echo "<p>Thank you for registering. Your program administrator will review and activate your account.<br>
						If you have any questions, contact them or the site administrator</p>";
		}
}
?>

<?php  
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_external.php");
?>
