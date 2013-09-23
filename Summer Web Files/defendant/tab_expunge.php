	<script>
	jQuery(function($) {
		
		$("#not-completed-date").datepicker();
		$("#expunge").button();
 	});
	</script>
	
	<?
  switch ($program->expunge) {
    case 0:
      $expunge = "None";
      $info = "No defendants are able to be expunged from the program. All information is kept";
      break;
    case 1:
      $expunge = "Full Expunge";
      $info = "This means all personal data will be removed from the defendant. Citation data and demographics will NOT be kept for statistics generation.";
      break;
    case 2:
      $expunge = "Partial Expunge";
      $info = "This means all personal data will be removed from the defendant. Citation data and demographics will be kept for statistics generation.";
      break;
    case 3:
      $expunge = "Sealed";
      $info = "This means no all personal data will be removed from the defendant. Citation data and demographics will be kept for statistics generation.";
      break;
  }
	?>
<form name="defendant-expunge" id="defendant-expunge" method="post" action="process.php">
<input type="hidden" name="defendantID" value="<? echo $id ?>" />
<input type="hidden" name="action" value="Expunge" />
	<fieldset>
		<legend>Expunge Information</legend>
		<table>
			<tr>
				<td style="width: 350px;">
					<p><input type="checkbox" id="order" name="order"/> Order Signed?</p>
					<p><input type="checkbox" id="letter" name="letter"/> Letter Completed?</p>
					<p><input type="checkbox" id="case" name="case"/> Case Completed?</p>
					<p><input type="checkbox" id="defendant-evaluation" name="defendant-evaluation"/> Defendant Evaluation Completed?</p>
					<p><input type="checkbox" id="parent-evaluation" name="parent-evaluation"/> Parent Evaluation Completed?</p>
					<p><input type="checkbox" id="workshop" name="workshop"/> Workshop Completed?</p>				
				</td>
				<td valign="top">
					<p class="ui-state-error ui-corner-all" style="padding: .8em;"><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>Your Court Program is set to <? echo $expunge.'. '.$info ?></p>
					<p align="center"><button id="expunge">Expunge Defendant</button></p>
				</td>
			</tr>
		</table>
	</fieldset>
</form>