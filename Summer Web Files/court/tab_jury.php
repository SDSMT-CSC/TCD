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

<form name="jury" id="court-jury" method="post" action="process.php">
  <input type="hidden" name="caseID" value="<? echo $id ?>" />
  <input type="hidden" name="action" value="Add Jury Members" />
  <input type="hidden" name="members" id="members" />
</form>

<form name="jury-hours" id="jury-hours" method="post" action="process.php">
  <input type="hidden" name="caseID" value="<? echo $id ?>" />
  <input type="hidden" name="action" value="Update Jury Hours" />
  <table class="listing">
    <thead>
      <tr>
        <th width="20%">Type</th>
        <th width="25%">Last Name</th>
        <th width="25%">First Name</th>
        <th width="20%">Hours</th>
        <th width="10%"></th>
      </tr>
    </thead>
    <tbody>
    <?
  	$members = $court->getJuryMembers();
    //var_dump($members);
    //TO DO: Check members to get type, include that with what you pass along. Still need to get global hours set, but that's just checking everyone for the caseID
  	
  	if( sizeof( $members ) == 0 ) {
  		echo '<tr><td align="center" colspan="5">No Jury Members Listed</td></tr>';
  	} else {
  	  $count = 1;
  		foreach( $members as $row ) {
    		echo '<tr>';
  				echo '<td>'.$row["type"].'</td>';
  				echo '<td>'.$row["lastName"].'</td>';
  				echo '<td>'.$row["firstName"].'</td>';
  				echo '<td>';
            echo '<input type="hidden" name="jury['.$count.'][id]" value="'.$row['id'].'"  />';
            echo '<input type="hidden" name="jury['.$count.'][type]" value="'.$row['type'].'"  />';
  				  echo '<input type="text" name="jury['.$count.'][hours]" value="'.$row["hours"].'"/>';
  				echo '</td>';
  				echo '<td>';
  				if( $user_type != 5 )
  					echo '<a class="delete-juror" href="process.php?action=Delete+Jury+Member&caseID='.
  							 $id.'&id='.$row["id"].'&type='.$row["type"].'">Delete</a>';
  				
  				echo '</td>';
    		echo '</tr>';
        $count += 1;
  		}
  	} 
  	?>
    </tbody>
  </table>
</form>

<button id="add-jury-members">Add Jury Member</button> <button id="update-jury-hours">Update Jury Hours</button>
