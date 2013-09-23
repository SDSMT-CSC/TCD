<?php 
include($_SERVER['DOCUMENT_ROOT']."/includes/header_external.php");

$submit = $_POST["submit"];
?>


<h1>Forgot your password?</h1>

<? if( !$_POST ) { ?>
<script>
jQuery(function($)
{
	$("#submit").button();
	
  $("#passwordRecover").validate({
    errorElement: "div",
    wrapper: "div",
    errorPlacement: function(error, element) {
        error.insertAfter(element);
        error.addClass('message');
    },
    rules: {
      email: { required: true, email: true, remote: "/includes/check_email.php?type=false" }
    }
  });
});
</script>

<div style="padding: .7em">
  If you can't remember your password, enter your registered email address 
  and a new one will be created and sent to you. Once you login, visit your profile page to change it.
</div>

<form id="passwordRecover" name="passwordRecover" method="post" action="#">
<fieldset class="ui-corner-all" style="width: 600px; margin: 0 auto;">
	<legend>Password Recovery Form</legend>
	<table style="width: 650px">
		<tr>
			<td>Email Address: <input type="text" name="email" id="email" class="input wide" /></td>
		</tr>
		<tr>
			<td><input style="left: 225px;" type="submit" id="submit" value="Send Password" /></td>
		</tr>
	</table>
	</fieldset>
</form>


<? 
} else { 
  
  
?>
<div class="ui-state-highlight ui-corner-all" style="margin-top: 10px; padding: 0 .7em;">
<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
An email has been sent to your account, please check it for your lost password!</p>
</div>
<? }?>
	
<?php  
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_external.php");
?>
