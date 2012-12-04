<?php 

if( $_POST )
{
	header("location: view.php");
}

$menuarea = "defendant";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
?>

<h1>New Defendant</h1>
<div class="info">Enter the primary defendant information before continuing.</div>

<form name="newDefendant" id="newDefendant" method="post" action="new.php">

<fieldset>
	<legend>Primary Defendant Information</legend>
	
	<table>
		<tr>
			<td>Last Name:</td>
			<td><input type="text" name="last-name" /></td>
			<td>Date of Birth:</td>
			<td><input type="text" name="last-name" size="10" /></td>
			<td>Agency Case #:</td>
			<td><input type="text" name="agency-case" size="10" /></td>
		</tr>
		<tr>
			<td>First Name:</td>
			<td><input type="text" name="first-name" /> MI: <input type="text" name="middle" size="5" /></td>
			<td>Home Phone:</td>
			<td><input type="text" name="last-name" /></td>
			<td>Court Case #:</td>
			<td><input type="text" name="court-case" size="10" /></td>
		</tr>
	</table>
	
</fieldset>

<div class="submitrow"><input type="submit" name="submit" id="submit" value="Add Defendant" /></div>

</form>


<?php 
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>