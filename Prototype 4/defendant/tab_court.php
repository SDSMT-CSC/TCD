<?
$courtID = $defendant->checkCourt();

if( !$courtID ) { ?>
<p style="padding: 10px">The defendant is not listed in any courts.</p>
<button id="create-court">Create Court</button>
<? 
} else { 

	$court = new Court( $user_programID );
	$court->getFromID( $courtID );
	
	$courtloc = new CourtLocation( $user_programID );
	$courtloc->getCourtLocation( $court->courtLocationID );
?>
<fieldset>
    <legend>Courts Attending</legend>
    <table class="listing" id="vehicle-listing">
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
</fieldset>
<? } ?>

<fieldset>
    <legend>Jury Duty</legend>
    
    
    
    
</fieldset>