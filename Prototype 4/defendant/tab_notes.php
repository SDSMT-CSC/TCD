
<form name="notes" id="notes" method="post" action="process.php">
<input type="hidden" name="action" value="Update Notes" />
<input type="hidden" name="defendantID" value="<? echo $defendant->getDefendantID() ?>" />
<textarea style="width: 100%; height: 250px;" name="notes">
<? echo $defendant->notes ?>
</textarea>
<button id="update-notes">Update Notes</button>