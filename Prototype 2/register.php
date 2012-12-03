<?php 
$areaname = "registration";
require($_SERVER['DOCUMENT_ROOT']."/BotDetect.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/header_external.php");

$submit = $_POST["submit"];

// setup captcha
$RegisterCaptcha = new Captcha("RegisterCaptcha");
$RegisterCaptcha->UserInputID = "CaptchaCode";
?>


<h1>User Registration</h1>

<? if( !$_POST ) { ?>
<script>
jQuery(function($)
{
	$("#submit").button();
	$('.password').pstrength();
});
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
			<td><input type="text" name="program-code" id="program-code" class="input wide" /></td>
		</tr>
		<tr>
			<td align="right">Email Address</td>
			<td><input type="text" name="email" id="email" class="input wide" /></td>
		</tr>
		<tr>
			<td align="right" valign="top">Password</td>
			<td valign="top" height="50">
				<div style="width: 250px;">
				<input type="password" name="password1" id="password1"  class="input password wide" />
				</div>
			</td>
		</tr>
		<tr>
			<td align="right">Retype Password</td>
			<td><input type="password" name="password2" id="password2" class="input wide" /></td>
		</tr>
		<tr>
			<td align="right" valign="bottom" style="padding-bottom:3px;">Prove you are a real person!<br>Retype the characters from the picture</td>			
			<td>
			<?php echo $RegisterCaptcha->Html(); ?>
			<input name="CaptchaCode" id="CaptchaCode" type="text" class="input wide" />
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right"><input type="submit" class="submitButton" name="submit" id="submit" value="Register Account" style="margin-right: 25px;" /></td>
		</tr>
	</table>
	</fieldset>
</form>
<? } else {
	
	 // validate the Captcha to check we're not dealing with a bot
    $isHuman = $RegisterCaptcha->Validate();
    		
    if (!$isHuman) {
      // Captcha validation failed, show error message
      ?>
			<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
			<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
			<strong>Alert:</strong> Captcha error, please <a href="/register.php">resubmit the form</a> .</p>
			</div>
			<?
    } else {
      // Captcha validation passed, perform protected action
      ?>
			<div class="ui-state-highlight ui-corner-all" style="margin-top: 10px; padding: 0 .7em;">
			<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
			An email has been sent to your account, please verify it by clicking on the link. You will then have access to Teen Court Database. Thank you for registering!</p>
			</div>
			<?
    } 
}?>
	
<?php  
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_external.php");
?>
