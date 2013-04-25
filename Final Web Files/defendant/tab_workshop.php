<?
$workArr = $defendant->checkWorkshop();

if( !$workArr ) {
?>
<p style="padding: 10px">The defendant is not listed in any workshops.</p>
<? } else { ?>
<fieldset>
    <legend>Workshops Attending</legend>
    <table class="listing" id="vehicle-listing">
      <thead>
        <tr>
          <th width="15%">Date</th>
          <th width="20%">Workshop</th>
          <th width="25%">Venue</th>
          <th width="20%">Location</th>
          <th width="10%">Completed</th>
          <th width="8%"></th>
        </tr>
      </thead>
      <tbody>
			<?
      $workshop = new Workshop( $user_programID );
			$workshoploc = new WorkshopLocation( $user_programID );
        
      foreach( $workArr as $row )
      {	
        $workshop->getWorkshop( $row["workshopID"] );
				$workshoploc->getWorkshopLocation( $workshop->getworkshopLocationID() );
				?>
        <tr>
          <td><? echo  date("n/j/y h:i a", $workshop->getDate() ) ?></td>
          <td><? echo  $workshop->getTitle() ?></td>
          <td><? echo  $workshoploc->name ?></td>
          <td><? echo  $workshoploc->city . ", " . $workshoploc->state ?></td>
          <td><? echo  $row["completed"] ?></td>
          <td align="center"><a href="/workshop/view.php?id=<? echo $row["workshopID"] ?>">View</a></td>
        </tr>
        <?
        }
      ?>
      </tbody>
    </table>
</fieldset>
<? } ?>
<button id="create-workshop">Create Workshop</button>

