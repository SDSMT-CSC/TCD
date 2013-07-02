<form name="court-members" id="court-members" method="post" action="process.php">
<input type="hidden" name="action" value="Update Court Members" />
<input type="hidden" name="caseID" value="<? echo $id ?>" />
<table style="width:675px">
<?
//TO DO: Both getCourtMembers and getMembersForTime do pretty much the exact same thing
//       remove getCourtMembers and rewrite to just use getMembersForTime function (will need to rewrite function slightly)

// get programs court positions and available members
$positions = $court->getCourtMembers();

// array for existing members
$existing = $court->existingCourtMembers();

// array for hours
$hours = $court->getMembersForTime( "positions" );

foreach( $positions as $key => $row )
{
  $hour = $hours[$key];
 ?>
  <tr>
    <td><? echo $row['position'] ?>: </td>
    <td>
    	<select name="positionID-<? echo $row['id'] ?>" style="width: 175px">
      	<option></option>
				<?
        if( sizeof( $row['members'] ) > 0 )
        {
          foreach( $row['members'] as $volID => $volunteer ) 
          {
						if( array_key_exists( $row['id'], $existing ) )
						{
							$selected = ( $existing[$row['id']] == $volID ) ? " selected" : "";
						}
						?>
						<option value="<? echo $volID ?>"<? echo $selected ?>><? echo $volunteer ?></option>
						<?
          }
        }
        ?>
      </select>
    </td>
    <td><input type="text" name="hours-<? echo $row['id'] ?>" value="<? echo $hour["hours"] ?>"/></td>
  </tr>  
  <?
}
?>
</table>
</form>
<button id="update-court-members">Update Court Members and Hours</button>