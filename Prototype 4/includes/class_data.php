<?php
class Data {
	
	/*************************************************************************************************
	
	*************************************************************************************************/
	public function fetchUserListing(  $user_programID, $user_type ) 
	{
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
							JOIN program p ON u.programID = p.programID WHERE p.programID = :programID AND deleted = 0";
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
		return '{"aaData":[]}';
	}

	/*************************************************************************************************
	
	*************************************************************************************************/
	public function fetchProgramListing() 
	{
		//database connection and SQL query
		$core = Core::dbOpen();
		$sql = "SELECT p.programID, p.code, p.name, p.pCity, p.pState, p.pZip, p.active 
						FROM program p";
		$stmt = $core->dbh->prepare($sql);
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
            ( $aRow["active"] == 1 ) ? $row[] = "Yes" : $row[] = "No";
						$row[] = "<a href=\"/admin/view_program.php?id=". $aRow["programID"] ."\">Edit</a>";				
						
						$output['aaData'][] = $row;
				}
				
				return json_encode($output);				
			}
		} 
		catch (PDOException $e) {
      		echo "Program Data Read Failed!";
    }
		return '{"aaData":[]}';
	}
	
	/*************************************************************************************************
	
	*************************************************************************************************/
	public function fetchProgramLocations( $user_programID ) 
	{
		 // database connection and sql query
    $core = Core::dbOpen();
    $sql = "SELECT * FROM program_locations WHERE programID = :programID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':programID', $user_programID);
    Core::dbClose();
		
		try {
			if($stmt->execute() && $stmt->rowCount() > 0) {
				
				while ($aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$row = array();
						
						$row[] = $aRow["city"];
						$row[] = $aRow["state"];
						$row[] = $aRow["zip"];
						
						$output['aaData'][] = $row;
				}
				
				return json_encode($output);				
			}
		} 
		catch (PDOException $e) {
      		echo "Program Locations Read Failed!";
    }
		return '{"aaData":[]}';
	}
	
	/*************************************************************************************************
	
	*************************************************************************************************/
	public function fetchProgramSchools( $user_programID ) 
	{
		 // database connection and sql query
    $core = Core::dbOpen();
    $sql = "SELECT * FROM program_schools WHERE programID = :programID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':programID', $user_programID);
    Core::dbClose();
		
		try {
			if($stmt->execute() && $stmt->rowCount() > 0) {
				
				while ($aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$row = array();
						
						$row[] = $aRow["schoolName"];
						$row[] = $aRow["address"];
						$row[] = $aRow["city"];
						$row[] = $aRow["state"];
						$row[] = $aRow["zip"];
						
						$output['aaData'][] = $row;
				}
				return json_encode($output);				
			}
		} 
		catch (PDOException $e) {
      		echo "Program School Read Failed!";
    }
		return '{"aaData":[]}';
	}
	
	/*************************************************************************************************
	
	*************************************************************************************************/
	public function fetchProgramStatutes( $user_programID ) 
	{
		 // database connection and sql query
    $core = Core::dbOpen();
    $sql = "SELECT * FROM program_statutes WHERE programID = :programID ORDER BY  statute";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':programID', $user_programID);
    Core::dbClose();
		
		try {
			if($stmt->execute() && $stmt->rowCount() > 0) {
				
				while ($aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$row = array();
						$row[] = $aRow["statuteID"];
						$row[] = $aRow["statute"];
						$row[] = "<b>".$aRow["title"]."</b><br />".$aRow["description"];;
						$output['aaData'][] = $row;
				}
				return json_encode($output);				
			}
		} 
		catch (PDOException $e) {
      		echo "Program Statutes Read Failed!";
    }
		return '{"aaData":[]}';
	}
	
	/*************************************************************************************************
		function: fetchProgramDropdown
		generates a dropdown list of programs that are active
	*************************************************************************************************/
	public function fetchProgramDropdown( $id )
	{
	  $data = NULL;
    
		//database connection and SQL query
		$core = Core::dbOpen();
		$sql = "SELECT p.programID, p.code, p.name FROM program p WHERE active = 1 ORDER BY name";
		$stmt = $core->dbh->prepare($sql);
    Core::dbClose();
		
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
	  $data = NULL;
    
		//database connection and SQL query
		$core = Core::dbOpen();
		$sql = "SELECT * FROM user_type WHERE active = 1 AND typeID >= :usertype ORDER BY typeID";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':usertype', $utype );
    Core::dbClose();
		
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
	  $data = NULL;
    
		//database connection and SQL query
		$core = Core::dbOpen();
		$sql = "SELECT timezoneID, display FROM timezone ORDER BY timezoneID";
		$stmt = $core->dbh->prepare($sql);
    Core::dbClose();
		
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
	public function fetchCourtListing(  $user_programID ) {
		//database connection and SQL query
		$core = Core::dbOpen();
		$sql = "SELECT d.courtCaseNumber, d.firstName, d.lastName, c.date, l.name
						FROM court c
						JOIN defendant d ON c.defendantID = d.defendantID
						JOIN court_location l ON c.locationID = l.locationID
						JOIN program p ON c.programID = p.programID WHERE programID = :programID";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':programID', $user_programID );
		Core::dbClose();
		
		try {
			if($stmt->execute() && $stmt->rowCount() > 0) {
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
      		echo "Trial Data Read Failed!";
    }	
		return '{"aaData":[]}';
	}

	/*************************************************************************************************
	
	*************************************************************************************************/

	public function fetchCourtLocation ( $user_programID ) {
		//database connection and SQL query
		$core = Core::dbOpen();
		$sql = "SELECT cl.name, cl.address, l.city, l.state, l.zip, cl.courtLocationID FROM court_location cl
		        JOIN program_locations l ON cl.programID = :programID AND cl.locationID = l.locationID";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':programID', $user_programID );
		
		try{
			if($stmt->execute() && $stmt->rowCount() > 0) {
				while ($aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$row = array();
					
					$row[] = $aRow["name"];
					$row[] = $aRow["address"];
					$row[] = $aRow["city"];
					$row[] = $aRow["state"];
					$row[] = $aRow["zip"];
					$row[] = $aRow["courtLocationID"];
					
					$output['aaData'][] = $row;
				}
				return json_encode($output);
			}
		} catch ( PDOException $e ) {
			echo "Court Location Read Failed!";
		}
		return '{"aaData":[]}';
	}

	/*************************************************************************************************
	
	*************************************************************************************************/
	public function fetchDefendantListing(  $user_programID ) {
		//database connection and SQL query
		$core = Core::dbOpen();
		
		$sql = "SELECT defendantID, courtCaseNumber, lastName, firstName, pLocationID, city, state, UNIX_TIMESTAMP( added ) AS added
            FROM defendant d
						LEFT JOIN program_locations pl ON pl.locationID = d.pLocationID
            WHERE closeDate IS NULL AND d.programID =:programID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':programID', $user_programID );
		Core::dbClose();
		
		try {
			if($stmt->execute() && $stmt->rowCount() > 0) {
				
				while ($aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$row = array();
						
						$row[] = $aRow["courtCaseNumber"];
						$row[] = $aRow["lastName"];
						$row[] = $aRow["firstName"];
						
						if( $aRow["pLocationID"] > 0 )
							$row[] = $aRow["city"] . ", " . $aRow["state"];
            else
							$row[] = "";
						
						$row[] = date("n/j/y h:i a",$aRow["added"]);					
						$row[] = "<a href=\"/defendant/view.php?id=". $aRow["defendantID"] ."\">Edit</a>";				
						
						$output['aaData'][] = $row;
				}
				
				return json_encode($output);				
			}
		}
		catch (PDOException $e) {
      		echo "Defendant Data Read Failed!";
    }
		return '{"aaData":[]}';
	}

	/*************************************************************************************************
	
	*************************************************************************************************/
	public function fetchVolunteerListing(  $user_programID ) {
		//database connection and SQL query
		$core = Core::dbOpen();
		
		//not worried about type, just get according to program
		$sql = "SELECT v.volunteerID, v.firstName, v.lastName, v.phone, v.email
						FROM volunteer v WHERE v.programID = :programID AND v.active = 1";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':programID', $user_programID );
		Core::dbClose();
		Core::dbClose();
		
		try {
			if($stmt->execute() && $stmt->rowCount() > 0) {
				
				while ($aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$row = array();
						
						$row[] = $aRow["volunteerID"];
						$row[] = $aRow["firstName"];
						$row[] = $aRow["lastName"];
						$row[] = $aRow["phone"];
						$row[] = $aRow["email"];
						$row[] = "<a href=\"/volunteer/view.php?id=". $aRow["volunteerID"] ."\">Edit</a>";				
						
						$output['aaData'][] = $row;
				}
				
				return json_encode($output);				
			}
		}
		catch (PDOException $e) {
      		echo "Volunteer Data Read Failed!";
    }
		return '{"aaData":[]}';
	}

	/*************************************************************************************************
	
	*************************************************************************************************/
	public function fetchWorkshopListing(  $user_programID ) {
		//database connection and SQL query
		$core = Core::dbOpen();
		
		$sql = "SELECT w.workshopID, UNIX_TIMESTAMP(w.date) AS date, w.title, w.instructor, o.lastName 
				FROM workshop w JOIN program_officers o ON w.officerID = o.officerID AND w.programID = :programID";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':programID', $user_programID );
		Core::dbClose();
		
		try {
			if($stmt->execute() && $stmt->rowCount() > 0) {
				
				while ($aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$row = array();
						
						$row[] = date("n/j/y h:i a", $aRow["date"]);
						$row[] = $aRow["title"];
						$row[] = $aRow["instructor"];
						$row[] = $aRow["lastName"];
						$row[] = "<a href=\"/workshop/view.php?id=". $aRow["workshopID"] ."\">Edit</a>";				
						
						$output['aaData'][] = $row;
				}
				
				return json_encode($output);				
			}
		}
		catch (PDOException $e) {
      		echo "Workshop Data Read Failed!";
    }
		return '{"aaData":[]}';
	}
	
	/*************************************************************************************************
	
	*************************************************************************************************/
	public function fetchWorkshopDefendantsListing( $user_programID ) {
		$core = Core::dbOpen();
		$sql = "SELECT d.firstName, d.lastName, d.defendantID FROM defendant d WHERE d.programID = :programID";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':programID', $user_programID );
		Core::dbClose();
		
		try {
			if( $stmt->execute() && $stmt->rowCount() > 0) {
				while( $aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$row = array();
					
					$row[] = $aRow["firstName"];
					$row[] = $aRow["lastName"];
					$row[] = $aRow["defendantID"];
					
					$output['aaData'][] = $row;
				}
				return json_encode($output);
			}
		}
		catch (PDOException $e ) {
			echo "Workshop Defendant Read Failed!";
		}
		
		return '{"aaData":[]}';
	}
} // end class
?>