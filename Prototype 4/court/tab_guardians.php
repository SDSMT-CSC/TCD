<?
$gList =  $defendant->getGuardianList(); 

if( sizeof( $gList ) == 0 ) {
	echo "<p>No parent or guardian information has been entered.</p>";
} else {
?>
<p>Select which parent or guardian will be present:</p>
<form name="court-guardian" id="court-guardian" method="post" action="process.php">
<input type="hidden" name="action" value="Update Court Guardians" />
<input type="hidden" name="courtID" value="<? echo $id ?>" />
<table style="width: 400px">
<?
	$guardian = new Guardian( $defendantID );
	$check = $court->checkGuardianAttending();

	foreach( $gList as $gID )
	{
		$guardian->getFromID( $gID );
		
		$selected = ( in_array( $guardian->getGuardianID(), $check ) ) ? " selected" : NULL;
		?>
    <tr>
      <td><? echo $guardian->lastName . ", " . $guardian->firstName ?></td>
      <td>
        <select name="guardians[<? echo $guardian->getGuardianID() ?>]">
          <option<? echo $selected ?>>No</option>
          <option<? echo $selected ?>>Yes</option>
        </select>
      </td>
    </tr>      
	<? } ?>
</table>
</form>
<button id="update-court-guardians">Update Parent/Guardians</button>
<? } ?>