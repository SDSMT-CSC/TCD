<script>
jQuery(function($) {
	$("#defendant-form").button();	
	$("#verdict-form").button();
	$("#officer-form").button();
	$("#expunge-form").button();
	$("#sentence-form").button();
	$("#defendant-hearing-form").button();
	$("#parent-hearing-form").button();
	$("#notes-form").button();
});
</script>

<table>
	<tr>
		<td valign="top" style="width: 350px;" >
			<p><input type="button" style="width: 250px;" id="defendant-form" value="Print Defendant Information" /></p>
			<p><input type="button" style="width: 250px;" id="verdict-form" value="Print Verdict Form" /></p>
			<p><input type="button" style="width: 250px;" id="officer-form" value="Print Officer Status" /></p>
			<p><input type="button" style="width: 250px;" id="expunge-form" value="Print Expunge Order" /></p>
		</td>
		<td>
			<p><input type="button" style="width: 250px;" id="sentence-form" value="Print Sentence Report" /></p>
			<p><input type="button" style="width: 250px;" id="defendant-hearing-form" value="Print Defendant Hearing Notes" /></p>
			<p><input type="button" style="width: 250px;" id="parent-hearing-form" value="Print Parent Hearing Notes" /></p>
			<p><input type="button" style="width: 250px;" id="notes-form" value="Print Case Notes" /></p>
		</td>
	</tr>
</table>