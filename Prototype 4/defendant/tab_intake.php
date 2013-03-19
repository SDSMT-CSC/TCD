<?

	$intake_date = date("m/j/Y");
	$intake_time = date("g:i A");
	
?>
<form id="intake" method="post" action="process.php">
	<input type="hidden" name="action" value="Update Intake" />
	<input type="hidden" name="defendantID" value="<? $defendant->getDefendantID(); ?>" />
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
				<td><input type="text" name="reschedule-date" id="reschedule-date" value="" /></td>
			</tr>
			<tr>
				<td>Intake Reschedule Time: </td>
				<td><input type="text" name="reschedule-time" id="reschedule-time" value="" /></td>
			</tr>
			<tr>
				<td>Intake Inteviewer</td>
				<td>
					<select name="intake-inteviewer" id="intake-inteviewer">
						<? echo $program->fetchUserDropdown( $user->getUserID() ); ?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td>Referred to Juevenile - Not Qualified: </td>
				<td><input type="checkbox" name="referred-date" id="referred-date" /></td>
			</tr>
			<tr>
				<td>Dismissed - No Complaint: </td>
				<td><input type="checkbox" name="dismissed-date" id="dismissed-date" /></td>
			</tr>
      <tr><td colspan="2" align="right"><button id="intake-submit">Update Intake Information</button></td></tr>
		</table>
	</fieldset>
</form>