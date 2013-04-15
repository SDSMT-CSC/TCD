<div id="sentence-existing-dialog" title="Add Existing Sentence">
  <table id="sentence-table">
    <thead>
        <tr>
        	<th>SentenceID</th>
          <th>Sentence</th>
          <th>Description</th>
          <th>Type</th>
        </tr>
    </thead>
    <tbody></tbody>
  </table> 
</div>

<div id="sentence-new-dialog" title="Add New Sentence">
  <form id="sentence-new" action="process.php" method="post">
    <input type="hidden" name="action" value="Add Sentence" />
  	<input type="hidden" name="defendantID" value="<? echo $defendant->getDefendantID() ?>" />
     <table>
      <tr>
        <td width="150">Sentence:</td>
        <td><input type="text" name="sentence-name" /></td>
      </tr>
      <tr>
        <td>Description:</td>
        <td><input type="text" name="sentence-description" /></td>
      </tr>
      <tr>
        <td valign="top">Type:</td>
        <td>
        	<select name="sentence-type" id="statute-type">
          	<option value="1">Money</option>
          	<option value="2">Numeric</option>
          	<option value="3">Text</option>
        	</select>  
        </td>
      </tr>
      <tr>
        <td>Additional Text Name:</td>
        <td><input type="text" name="sentence-additional" /></td>
      </tr>
    </table>
  </form>
</div>

<form name="sentence" id="sentence" action="process.php" method="post">
  <input type="hidden" name="action" value="Update Sentencing" />
  <input type="hidden" name="defendantID" value="<? echo $defendant->getDefendantID() ?>" />
  <fieldset>
    <legend>Sentence Requirements</legend>
    <table class="listing" id="sentence-listing">
      <thead>
        <tr>
          <th width="60%" colspan="3">Sentence</th>
          <th width="30%">Complete</th>
          <th width="10%"></th>
        </tr>
      </thead>
      <tbody>
      <?
      $sentences = $defendant->checkSentence();
      if( !$sentences ) {
      ?>
      <tr><td colspan="5" align="center">No sentencing information listed.</td></tr>
      <?
      }	else {
				
				foreach( $sentences as $key => $row ) {
	      ?>
      <tr>
      	<td><? echo $row["name"] ?></td>
      	<td align="right"><? echo $row["description"] ?>:</td>
      	<td>
        	<?
						switch( $row["type"] ) {
							case 1: $value = $row["money"]; break;
							case 2: $value = $row["numbers"]; break;
							case 3: $value = $row["text"]; break;
						}
					?>
          <input type="hidden" name="sentence[<? echo $key ?>][sentenceID]" value="<? echo $row["sentenceID"] ?>" />
        	<input type="text" name="sentence[<? echo $key ?>][value]" size="5" value="<? echo $value ?>" />
         </td>
      	<td><input type="text" class="date complete" size="10" name="sentence[<? echo $key ?>][date]" value=""  /></td>
      	<td>Remove</td>
      </tr>
      	<?  
				}
      }
      ?>
      </tbody>
    </table>
    <div class="belowListing">
      <button id="add-existing-sentence">Add Existing Sentence</button>
      <button id="add-new-sentence">Add New Sentence</button>
    </div>
  </fieldset>
  
  <fieldset>
    <legend>Sentence Information</legend>
    <table>
      <tr>
        <td>Sentence Complete:</td>
        <td><input type="text" class="date" name="sentence-complete" id="sentence-complete" /></td>
      </tr>
      <tr>
        <td>Reason For Sentence:</td>
        <td><textarea name="sentence-reason" rows="2" cols="40"></textarea></td>
      </tr>
    </table>
  </fieldset>
  <button id="update-sentencing">Update Sentencing</button>

</form>