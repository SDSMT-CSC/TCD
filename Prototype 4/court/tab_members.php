<form name="court-members" id="court-members" method="post" action="process.php">	
<input type="hidden" name="courtID" value="<? echo $id ?>" />
<input type="hidden" name="action" value="Update Court Members" />
<table style="width: 400px">
<?

// get programs court positions and available members
$positions = $court->getCourtMembers();

// array for existing members
$existing = $court->existingCourtMembers();

foreach( $positions as $row )
{
 ?>
  <tr>
    <td><? echo $row['position'] ?>: </td>
    <td>
    	<select name="positionID-<? echo $row['id'] ?>" style="width: 175px">
      	<option></option>
				<?
        if( sizeof( $row['members'] ) > 0 )
        {
          foreach( $row['members'] as $id => $volunteer ) 
          {
						if( array_key_exists( $row['id'], $existing ) )
						{
							$selected = ( $existing[$row['id']] == $id ) ? " selected" : "";
						}
						?>
						<option value="<? echo $id ?>"<? echo $selected ?>><? echo $volunteer ?></option>
						<?
          }
        }
        ?>
      </select>
    </td>
  </tr>  
  <?
}
?>
</table>

   
 </form>
<button id="update-court-members">Update Court Members</button>