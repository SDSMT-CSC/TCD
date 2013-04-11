<?

	if( $defendant->intake ) {
		$intake_date = date("m/j/Y", $defendant->intake );
		$intake_time = date("g:i A", $defendant->intake );
	} else {
		$intake_date = date("m/j/Y");
		$intake_time = date("g:i A");
	}
	
	if( $defendant->reschedule ) {
		$reschedule_date = date("m/j/Y", $defendant->reschedule );
		$reschedule_time = date("g:i A", $defendant->reschedule );
	}
	
	$inteviewer = ( $defendant->inteviewer ) ? $defendant->inteviewer : $user->getUserID();
	
	$referred_date = ( $defendant->referred ) ?  " on " . date("m/j/Y g:i A", $defendant->referred ) : NULL;
	$dismissed_date = ( $defendant->dismissed ) ?  " on " . date("m/j/Y g:i A", $defendant->dismissed ) : NULL;
	
?>
<form id="intake" method="post" action="process.php">
	<input type="hidden" name="action" value="Update Intake" />
	<input type="hidden" name="defendantID" value="<? echo $defendant->getDefendantID(); ?>" />
	<fieldset>
		<legend>Intake Information</legend>
		<table>
			<tr>
				<td width="250">Intake Date: </td>
				<td><input type="text" name="intake-date" id="intake-date" value="<? echo $intake_date ?>" /></td>
			</tr>
			<tr>
				<td>Intake Time: </td>
				<td><input type="text" name="intake-time" id="intake-time" value="<? echo $intake_time ?>" /></td>
			</tr>
			<tr>
				<td>Intake Reschedule Date: </td>
				<td><input type="text" name="reschedule-date" id="reschedule-date" value="<? echo $reschedule_date ?>" /></td>
			</tr>
			<tr>
				<td>Intake Reschedule Time: </td>
				<td><input type="text" name="reschedule-time" id="reschedule-time" value="<? echo $reschedule_time ?>" /></td>
			</tr>
			<tr>
				<td>Intake Inteviewer</td>
				<td>
					<select name="intake-inteviewer" id="intake-inteviewer">
						<? echo $program->fetchUserDropdown( $inteviewer ); ?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td>Referred to Juvenile - Not Qualified: </td>
				<td><input type="checkbox" name="intake-referred" id="intake-referred"<? if( $defendant->referred ) echo " checked"; ?>/><? echo $referred_date ?></td>
			</tr>
			<tr>
				<td>Dismissed - No Complaint: </td>
				<td><input type="checkbox" name="intake-dismissed" id="intake-dismissed"<? if( $defendant->dismissed ) echo " checked"; ?>/><? echo $dismissed_date ?></td>
			</tr>
      <tr><td colspan="2" align="right"><button id="intake-submit">Update Intake Information</button></td></tr>
		</table>
	</fieldset>
</form> 