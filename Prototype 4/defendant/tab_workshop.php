<?
$workArr = $defendant->checkWorkshop();

if( $workArr ) {
?>
<fieldset>
    <legend>Workshops Attending</legend>
    <table class="listing" id="vehicle-listing">
      <thead>
        <tr>
          <th width="10%">Workshop</th>
          <th width="10%">Date</th>
          <th width="10%">Instructor</th>
          <th width="10%">Completed</th>
          <th width="5%"></th>
        </tr>
      </thead>
      <tbody>
			<?
        $workshop = new Workshop();
        
        foreach( $workArr as $row )
        {	
          $workshop->getWorkshop( $row["workshopID"] );
          echo "<tr>";
          echo "<td>" . $workshop->getTitle() . "</td>";
          echo "<td>" . $workshop->getDate() . "</td>";
          echo "<td>" . $workshop->getInstructor . "</td>";
          echo "<td>" . $row["completed"] . "</td>";
          echo '<td><a href="/workshop/view.php?id=' . $row["workshopID"] . '">View</a></td>';
          echo "</tr>";
        }        
      ?>
      </tbody>
    </table>
</fieldset>
<? } else { ?>
<p style="padding: 10px">The defendant is not listed in any workshops.</p>
<? } ?>
<button id="create-workshop">Create Workshop</button>

