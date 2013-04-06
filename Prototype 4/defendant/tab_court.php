<?
//$courtArr = $defendant->checkCourt();

if( $courtArr ) {
?>
<fieldset>
    <legend>Courts Attending</legend>
    <table class="listing" id="vehicle-listing">
      <thead>
        <tr>
          <th width="10%">Date</th>
          <th width="10%">Type</th>
          <th width="10%">Place</th>
          <th width="10%">Location</th>
          <th width="10%">Closed</th>
          <th width="5%"></th>
        </tr>
      </thead>
      <tbody>
			<?
        $court = new Court( $user_programID );
/*        
        foreach( $courtArr as $row )
        {	
          $court->getFromID( $row["workshopID"] );
          echo "<tr>";
          echo "<td>" . $court->getTitle() . "</td>";
          echo "<td>" . $court->getDate() . "</td>";
          echo "<td>" . $court->getInstructor() . "</td>";
          echo "<td>" . $row["completed"] . "</td>";
          echo '<td><a href="/court/view.php?id=' . $row["workshopID"] . '">View</a></td>';
          echo "</tr>";
        }
*/
      ?>
      </tbody>
    </table>
</fieldset>
<? } else { ?>
<p style="padding: 10px">The defendant is not listed in any courts.</p>
<? } ?>
<button id="create-court">Create Court</button>

<fieldset>
    <legend>Jury Duty</legend>
</fieldset>