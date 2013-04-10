<div id="jury-member-dialog" title="Add Jury Members">
	<table id="court-jury-table">
		<thead>
			<tr>
      	<th>ID</th>
				<th>Type</th>
				<th>Last Name</th>
				<th>First Name</th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
</div>

<form name="jury" id="jury" method="post" action="process.php">
	<input type="hidden" name="courtID" value="<? echo $id ?>" />
	<input type="hidden" name="action" value="Add Jury Members" />
	<input type="hidden" name="members" id="members" />
</form>
  
<table class="listing">
  <thead>
    <tr>
      <th width="30%">Type</th>
      <th width="30%">Last Name</th>
      <th width="30%">First Name</th>
      <th width="10%"></th>
    </tr>
  </thead>
  <tbody>
  <?
	$members = $court->getJuryMembers();
	
	if( sizeof( $members ) == 0 ) {
  ?>
  <tr><td align="center" colspan="4">No Jury Members Listed</td></tr>
  <?
	} else {
		
		foreach( $members as $row ) {
  	?>
  <tr>
  	<td><? echo $row["type"] ?></td>
  	<td><? echo $row["lastName"] ?></td>
  	<td><? echo $row["firstName"] ?></td>
  	<td><a href="process.php?action=Delete+Jury+Member&courtID=<? echo $id ?>&id=<? echo $row["id"] ?>&type=<? echo $row["type"] ?>">Delete</a></td>
  </tr>
  	<? 
		}
	} 
	?>
  </tbody>
</table>

<button id="add-jury-members">Add Jury Member</button>
