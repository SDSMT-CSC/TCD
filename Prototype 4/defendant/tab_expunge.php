	<script>
	jQuery(function($) {
		
		$("#not-completed-date").datepicker();
		$("#expunge").button();
 	});
	</script>
	
	<fieldset>
		<legend>Expunge Information</legend>
		<table>
			<tr>
				<td style="width: 350px;">
					<p><input type="checkbox" /> Order Signed?</p>
					<p><input type="checkbox" /> Letter Completed?</p>
					<p><input type="checkbox" /> Case Completed?</p>
					<p><input type="checkbox" /> Defendant Evaluation Completed?</p>
					<p><input type="checkbox" /> Parent Evaluation Completed?</p>
					<p><input type="checkbox" /> Workshop Completed?</p>				
				</td>
				<td valign="top">
					<p>Referred to Juvenile - Sentance Not Completed: <input type="text" name="not-completed-date" id="not-completed-date" /></p>
					<p class="ui-state-error ui-corner-all" style="padding: .8em;"><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>Your Court Program is set to Partial Expunge. This means all personal data will be removed from the defendant. Citation data and demographics will be kept for statistics generation.</p>
					<p align="center"><input type="button" name="expunge" id="expunge" value="Expunge Defendant"></p>
				</td>
			</tr>
		</table>
	</fieldset>
	