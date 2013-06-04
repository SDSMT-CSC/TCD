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
        <td>Additional Text Name:</td>
        <td><input type="text" name="sentence-additional" /></td>
      </tr>
    </table>
  </form>
</div>

<form name="sentence-add-items" id="sentence-add-items" action="process.php" method="post">
  <input type="hidden" name="action" value="Add Sentence Items" />
  <input type="hidden" name="defendantID" value="<? echo $defendant->getDefendantID() ?>" />
	<input type="hidden" name="items" id="items" />
</form>
  
<form name="sentence" id="sentence" action="process.php" method="post">
  <input type="hidden" name="action" value="Update Sentencing" />
  <input type="hidden" name="defendantID" value="<? echo $defendant->getDefendantID() ?>" />
    
  <fieldset>
    <legend>Sentence Requirements</legend>
    <table class="listing" id="sentence-listing">
      <thead>
        <tr>
          <th width="20%">Sentence</th>
          <th width="60%" colspan="2">Requirements</th>
          <th width="15%">Complete</th>
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
				
				$sentence = new Sentence( $defendant->getDefendantID() );
				foreach( $sentences as $key => $row ) {
	      
					$sentence->getFromID( $row["defsentID"] );
				?>
      <tr>
      	<td><? echo $sentence->name ?></td>
        <td><? echo $sentence->description ?>:</td>
        <td>
          <input type="hidden" name="sentence[<? echo $key ?>][defsentID]" value="<? echo $row["defsentID"] ?>" />
        	<input type="text" name="sentence[<? echo $key ?>][value]" size="5" value="<? echo $sentence->value ?>" />
        	<?
					if( $sentence->additional ) { ?>
          <? echo $sentence->additional ?>: 
          <input type="text" size="30" name="sentence[<? echo $key ?>][additional]" value="<? echo $sentence->additionalValue ?>" />
          <? } ?>
         </td>
      	<td>
        	<input type="text" class="date complete" size="10" 
          				name="sentence[<? echo $key ?>][date]" value="<? if( $sentence->completeDate ) echo date( "m/d/Y", $sentence->completeDate ) ?>" />
        </td>
        <? if ($user_type != 5) { ?>
      	<td>
        	<a class="delete-sentence" 
          	 href="process.php?action=Delete+Sentence&defendantID=<? echo $defendant->getDefendantID() ?>&id=<? echo $row["defsentID"] ?>">Delete</a>
        </td>
        <? } else { ?>
         <td></td>
        <? } ?>
      </tr>
      	<?  
				}
      }
      ?>
      </tbody>
    </table>
    <div class="belowListing">
			<button id="update-sentencing">Update Sentencing</button>
      <button id="add-existing-sentence">Add Existing Sentence</button>
      <button id="add-new-sentence">Add New Sentence</button>
    </div>
  </fieldset>
  
  <!--
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
  -->
</form>