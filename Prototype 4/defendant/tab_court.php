<fieldset>
	<legend>Court Assigned</legend>
	<?
  $courtID = $defendant->checkCourt();
  
  if( !$courtID ) { ?>
  <p>The defendant has not been assigned to any courts.</p>
  <button id="create-court">Create Court</button>
  <? 
  } else { 
  
    $court = new Court( $user_programID );
    $court->getFromID( $courtID );
    
    $courtloc = new CourtLocation( $user_programID );
    $courtloc->getCourtLocation( $court->courtLocationID );
  ?>
  <table class="listing" id="court-listing">
    <thead>
      <tr>
        <th width="15%">Date</th>
        <th width="10%">Type</th>
        <th width="25%">Venue</th>
        <th width="20%">Location</th>
        <th width="15%">Closed</th>
        <th width="5%"></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><? echo date("n/j/y h:i a", $court->courtDate ) ?></td>
        <td><? echo $court->type ?></td>
        <td><? echo $courtloc->name ?></td>
        <td><? echo $courtloc->city . ", " . $courtloc->state ?></td>
        <td><? echo ( $court->closed ) ? date("n/j/y h:i a", $court->closed ) : NULL ?></td>
        <td align="center"><a href="/court/view.php?id=<? echo $courtID ?>">View</a></td>
       </tr>
    </tbody>
  </table>
	<? } ?>
</fieldset>

<fieldset>
	<legend>Jury Duty</legend>
  <? 
	$juryArr = $defendant->checkJury();
	
	if( !$juryArr ) { ?>
  <p>The defendant has not been assigned as a member of any jury.</p>
  <?   
  } else { 

//	hours	courtID	date	closed	courtLocationID

  ?>
   <table class="listing" id="jury-listing">
    <thead>
      <tr>
        <th width="15%">Date</th>
        <th width="25%">Venue</th>
        <th width="20%">Location</th>
        <th width="15%">Closed</th>
        <th width="10%">Hours</th>
        <th width="5%"></th>
        <th width="5%"></th>
      </tr>
    </thead>
    <tbody>
    	<?
			foreach( $juryArr as $key => $row )
			{
				$courtloc = new CourtLocation( $user_programID );
				$courtloc->getCourtLocation( $row["courtLocationID"] );
			?>
      <tr>
        <td><? echo date("n/j/y h:i a", $row["date"] ) ?></td>
        <td><? echo $courtloc->name ?></td>
        <td><? echo $courtloc->city . ", " . $courtloc->state ?></td>
        <td><? echo ( $row["closed"] ) ? date("n/j/y h:i a", $row["closed"] ) : NULL ?></td>
        <td><? echo $row["hours"] ?></td>
        <td align="center"><a href="/volunteer/enter_hours.php?id=<? echo $row["courtID"] ?>">Hours</a></td>
        <td align="center"><a href="/court/view.php?id=<? echo $row["courtID"] ?>">View</a></td>
       </tr>
      <? 
			}
			?>
    </tbody>
  </table>
  <? } ?>    
</fieldset>