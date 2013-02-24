<?php
class Data{
	
	public $data;
	
	/*************************************************************************************************
	
	*************************************************************************************************/
	public function fetchUserListing(  $user_programID, $user_type ) {
		//database connection and SQL query
		$core = Core::dbOpen();
		
		// if user_type == 1 or 2 then display every user, otherwise
		// only get users for that persons program
		if( $user_type == 1 || $user_type == 2 ) {
			$sql = "SELECT u.userID, p.code, ut.type, u.firstName, u.lastName, u.email, u.active
							FROM user u 
							JOIN user_type ut ON u.typeID = ut.typeID
							JOIN program p ON u.programID = p.programID
							WHERE deleted = 0";
			$stmt = $core->dbh->prepare($sql);
		}
		else {
			$sql = "SELECT u.userID, p.code, ut.type, u.firstName, u.lastName, u.email, u.active 
							FROM user u 
							JOIN user_type ut ON u.typeID = ut.typeID
							JOIN program p ON u.programID = p.programID WHERE programID = :programID AND deleted = 0";
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
						( $aRow["active"] == 1 ) ? $row[] = "Yes" : $row[] = "No";
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

	/*************************************************************************************************
	
	*************************************************************************************************/
	public function fetchProgramListing(  $user_programID, $user_type ) {
		//database connection and SQL query
		$core = Core::dbOpen();
		
		// if user_type == 1 or 2 then display every program, otherwise
		// only get that persons program (should probably return invalid as only admins need this)
		if( $user_type == 1 || $user_type == 2 ) {
			$sql = "SELECT p.programID, p.code, p.name, p.pCity, p.pState, p.pZip
							FROM program p";
			$stmt = $core->dbh->prepare($sql);
		}
		else {
			$sql = "SELECT p.programID, p.code, p.name, p.PAddress, p.pCity, p.pZip
							FROM program p WHERE programID = :programID";
			$stmt = $core->dbh->prepare($sql);
			$stmt->bindParam(':programID', $user_programID );
		}
		Core::dbClose();
		
		try {
			if($stmt->execute()) {
				
				while ($aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$row = array();
						
						$row[] = $aRow["code"];
						$row[] = $aRow["name"];
						$row[] = $aRow["pCity"];
						$row[] = $aRow["pState"];
						$row[] = $aRow["pZip"];
						$row[] = "<a href=\"/admin/view_program.php?id=". $aRow["programID"] ."\">Edit</a>";				
						
						$output['aaData'][] = $row;
				}
				
				return json_encode($output);				
			}
		} 
		catch (PDOException $e) {
      		echo "User Data Read Failed!";
    	}
	}
	
	/*************************************************************************************************
		function: fetchProgramDropdown
		generates a dropdown list of programs that are active
	*************************************************************************************************/
	public function fetchProgramDropdown( $id )
	{
		//database connection and SQL query
		$core = Core::dbOpen();
		$sql = "SELECT p.programID, p.code, p.name FROM program p WHERE active = 1 ORDER BY name";
		$stmt = $core->dbh->prepare($sql);
		
		try {
			if($stmt->execute()) {	
				$data = "";
				while ($aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
					( $id == $aRow["programID"] ) ? $selected = " selected" : $selected = "";
					$data .= '<option value="'.$aRow["programID"].'"'.$selected.'>'.$aRow["name"].'</option>';
				}
			}
		}	
		catch (PDOException $e) {
    	echo "Program dropdown failed!";
    }
		
		return $data;
	}
		
	/*************************************************************************************************
	
	*************************************************************************************************/
	public function fetchUserTypeDropdown( $id, $utype )
	{
		//database connection and SQL query
		$core = Core::dbOpen();
		$sql = "SELECT * FROM user_type WHERE active = 1 AND typeID >= :usertype ORDER BY typeID";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':usertype', $utype );
		
		try {
			if($stmt->execute()) {	
				$data = "";
				while ($aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
					( $id == $aRow["typeID"] ) ? $selected = " selected" : $selected = "";
					$data .= '<option value="'.$aRow["typeID"].'"'.$selected.'>'.$aRow["type"].'</option>';
				}
			}
		}	
		catch (PDOException $e) {
    	echo "User type dropdown failed!";
    }
		
		return $data;
	}
	
	/*************************************************************************************************
	
	*************************************************************************************************/
	public function fetchTimezoneDropdown( $id )
	{
		//database connection and SQL query
		$core = Core::dbOpen();
		$sql = "SELECT timezoneID, display FROM timezone ORDER BY timezoneID";
		$stmt = $core->dbh->prepare($sql);
		
		try {
			if($stmt->execute()) {	
				$data = "";
				while ($aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
					( $id == $aRow["timezoneID"] ) ? $selected = " selected" : $selected = "";
					$data .= '<option value="'.$aRow["timezoneID"].'"'.$selected.'>'.$aRow["display"].'</option>';
				}
			}
		}	
		catch (PDOException $e) {
    	echo "User type dropdown failed!";
    }
		
		return $data;
	}

	/*************************************************************************************************
	
	*************************************************************************************************/
	public function fetchTrialListing(  $user_programID, $user_type ) {
		//database connection and SQL query
		$core = Core::dbOpen();
		
		// if user_type == 1 or 2 then display every user, otherwise
		// only get users for that persons program
		if( $user_type == 1 || $user_type == 2 ) {
			$sql = "SELECT d.courtCaseNumber, d.firstName, d.lastName, c.date, l.name
							FROM court c
							JOIN defendant d ON c.defendantID = d.defendantID
							JOIN court_location l ON c.locationID = l.locationID
							JOIN program p ON c.programID = p.programID";
			$stmt = $core->dbh->prepare($sql);
		}
		else {
			$sql = "SELECT d.courtCaseNumber, d.firstName, d.lastName, c.date, l.name
							FROM court c
							JOIN defendant d ON c.defendantID = d.defendantID
							JOIN court_location l ON c.locationID = l.locationID
							JOIN program p ON c.programID = p.programID WHERE programID = :programID";
			$stmt = $core->dbh->prepare($sql);
			$stmt->bindParam(':programID', $user_programID );
		}
		Core::dbClose();
		
		try {
			if($stmt->execute()) {
				
				while ($aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$row = array();
						
						$row[] = $aRow["courtCaseNumber"];
						$row[] = $aRow["firstName"];
						$row[] = $aRow["lastName"];
						$row[] = $aRow["date"];
						$row[] = $aRow["name"];
						$row[] = "<a href=\"/court/view_court.php?id=". $aRow["courtID"] ."\">Edit</a>";				
						
						$output['aaData'][] = $row;
				}
				
				return json_encode($output);				
			}
		}
		catch (PDOException $e) {
      		echo "User Data Read Failed!";
    	}
	}

	/*************************************************************************************************
	
	*************************************************************************************************/
	public function fetchDefendantListing(  $user_programID, $user_type ) {
		//database connection and SQL query
		$core = Core::dbOpen();
		
		// if user_type == 1 or 2 then display every user, otherwise
		// only get users for that persons program
		if( $user_type == 1 || $user_type == 2 ) {
			$sql = "SELECT c.citationID, d.courtCaseNumber, d.lastName, d.firstName, c.address, c.entered
							FROM defendant d
							JOIN citation c ON d.defendantID = c.defendantID
							JOIN program p ON d.programID = p.programID WHERE programID = :programID";
			$stmt = $core->dbh->prepare($sql);
		}
		else {
			$sql = "SELECT c.citationID, d.courtCaseNumber, d.lastName, d.firstName, c.address, c.entered
							FROM defendant d
							JOIN citation c ON d.defendantID = c.defendantID
							JOIN program p ON d.programID = p.programID WHERE programID = :programID";
			$stmt = $core->dbh->prepare($sql);
			$stmt->bindParam(':programID', $user_programID );
		}
		Core::dbClose();
		
		try {
			if($stmt->execute()) {
				
				while ($aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$row = array();
						
						$row[] = $aRow["citationID"];
						$row[] = $aRow["courtCaseNumber"];
						$row[] = $aRow["lastName"];
						$row[] = $aRow["firstName"];
						$row[] = $aRow["address"];
						$row[] = $aRow["entered"];
						$row[] = "<a href=\"/court/view_court.php?id=". $aRow["courtID"] ."\">Edit</a>";				
						
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