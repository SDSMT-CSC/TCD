<?php
class Data{
	
	public $data;
	
	public function fetchUserListing(  $user_programID, $user_type ) {
		//database connection and SQL query
		$core = Core::dbOpen();
		
		// if user_type == 1 or 2 then display every user, otherwise
		// only get users for that persons program
		if( $user_type == 1 || $user_type == 2 ) {
			$sql = "SELECT u.userID, p.code, ut.type, u.firstName, u.lastName, u.email 
							FROM user u 
							JOIN user_type ut ON u.typeID = ut.typeID
							JOIN program p ON u.programID = p.programID";
			$stmt = $core->dbh->prepare($sql);
		}
		else {
			$sql = "SELECT u.userID, p.code, ut.type, u.firstName, u.lastName, u.email 
							FROM user u 
							JOIN user_type ut ON u.typeID = ut.typeID
							JOIN program p ON u.programID = p.programID WHERE programID = :programID";
			$stmt = $core->dbh->prepare($sql);
			$stmt->bindParam(':programID', $user_programID );
		}
		Core::dbClose();
		
		try {
			if($stmt->execute()) {
				
				while ($aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$row = array();
						
						$row[] = $aRow["code"];
						$row[] = $aRow["type"];
						$row[] = $aRow["firstName"];
						$row[] = $aRow["lastName"];
						$row[] = $aRow["email"];
						$row[] = "<a href=\"/admin/view_user.php?id=". $aRow["userID"] ."\">Edit</a>";				
						
						$output['aaData'][] = $row;
				}
				
				return json_encode($output);				
			}
		}
		catch (PDOException $e) {
      		echo "User Data Read Failed!";
    	}
	}
}
?>