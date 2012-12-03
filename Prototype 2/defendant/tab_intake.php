	<script>
 	$(function () {
		
		$("#intake-date").datepicker();
		$("#reschedule-date").datepicker();
		$("#referred-date").datepicker();
		$("#dismissed-date").datepicker();
		
 	});
	</script>
	
	<fieldset>
		<legend>Intake Information</legend>
		<table style="width: 500px;">
			<tr>
				<td>Intake Date: </td>
				<td><input type="text" name="intake-date" id="intake-date" /></td>
			</tr>
			<tr>
				<td>Intake Time: </td>
				<td><input type="text" name="intake-time" id="intake-time" /></td>
			</tr>
			<tr>
				<td>Intake Reschedule Date: </td>
				<td><input type="text" name="reschedule-date" id="reschedule-date" /></td>
			</tr>
			<tr>
				<td>Intake Reschedule Time: </td>
				<td><input type="text" name="reschedule-time" id="reschedule-time" /></td>
			</tr>
			<tr>
				<td>Intake Inteviewer</td>
				<td>
					<select name="intake-inteviewer" id="intake-inteviewer">
						<option>Reilly, Bobby</option>
						<option>Thompson, Andrew</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td>Referred to Juevenile - Not Qualified: </td>
				<td><input type="text" name="referred-date" id="referred-date" /></td>
			</tr>
			<tr>
				<td>Dismissed - No Complaint: </td>
				<td><input type="text" name="dismissed-date" id="dismissed-date" /></td>
			</tr>
		</table>
		
	</fieldset>