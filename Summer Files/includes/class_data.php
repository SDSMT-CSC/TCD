<?php
class Data {
	
	/*************************************************************************************************
   function: fetchUserListing
   purpose: fetches all users or only users in the program depending on user type into JSON encoding
   input: $user_programID = used to pull only members from that programID
          $user_type = to determine if you pull everyone or only a specific program
   output: JSON object
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
						$row[] = "<a href=\"/admin/view_user.php?id=". $aRow["userID"] ."\">View</a>";				
						
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
   function: fetchProgramlisting
   purpose: fetches all programs into JSON encoding
   input: none
   output: JSON object
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
						$row[] = "<a href=\"/admin/view_program.php?id=". $aRow["programID"] ."\">View</a>";				
						
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
   function: fetchProgramLocations
   purpose: fetches locations for the given program into a JSON object
   input: $user_programID = program to fetch locations for
   output: JSON object
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
						$row[] = $aRow["locationID"];
						
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
   function: fetchProgramSchools
   purpose: fetches schools for the given program into a JSON object
   input: $user_programID = program to fetch schools for
   output: JSON object
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
            $row[] = $aRow["schoolID"];
						
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
   function: fetchProgramStatutes
   purpose: fetches statutes for the given program into a JSON object
   input: $user_programID = program to fetch statutes for
   output: JSON object
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
						$row[] = "<b>".$aRow["title"]."</b><br />".$aRow["description"];
            $row[] = $aRow["title"];
            $row[] = $aRow["description"];
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
   function: fetchProgramSentences
   purpose: fetches sentence for the given program into a JSON object
   input: $user_programID = program to fetch statutes for
   output: JSON object
  *************************************************************************************************/
	public function fetchProgramSentences( $user_programID ) 
	{
		 // database connection and sql query
    $core = Core::dbOpen();
    $sql = "SELECT * FROM program_sentences WHERE programID = :programID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':programID', $user_programID);
    Core::dbClose();
		
		try {
			if($stmt->execute() && $stmt->rowCount() > 0) {
				
				while ($aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$row = array();
						$row[] = $aRow["sentenceID"];
						$row[] = $aRow["name"];
						$row[] = $aRow["description"];
						
						switch( $aRow["type"] ) {
							case 1: $type = "Money"; break;
							case 2: $type = "Numeric"; break;
							case 3: $type = "Text"; break;
							default: $type = "None";
						}
						
						$row[] = $type;
						
						$output['aaData'][] = $row;
				}
				return json_encode($output);				
			}
		} 
		catch (PDOException $e) {
      		echo "Program Sentence Read Failed!";
    }
		return '{"aaData":[]}';
	}
  
  public function fetchProgramPositions( $user_programID )
  {
    $core = Core::dbOpen();
    $sql = "SELECT * FROM court_position WHERE programID = :programID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':programID', $user_programID);
    Core::dbClose();
    
    try {
      if( $stmt->execute() && $stmt->rowCount() > 0) {
        while( $aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $row = array();
          $row[] = $aRow["position"];
          $row[] = $aRow["positionID"];
          
          $output['aaData'][] = $row;
        }
        return json_encode($output);
      }
    } catch (PDOException $e) {
      echo "Program Position Fetch Failed!";
    }
    return '{"aaData":[]}';
  }
	
	/*************************************************************************************************
		function: fetchProgramDropdown
		purpose: generates a dropdown list of programs that are active
    input: $id = program to default as selected
    output: Dropdown options
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
   function: fetchUserTypeDropdown
   purpose: fetches the possible user types that a user could be assigned into a JSON object
   input: $id = type to default to
          $utype = user's current type
   output: Dropdown options
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
   function: fetchTimezoneDropdown
   purpose: generates a dropdown list of possible timezones
   input: $id = timezone to default to
   output: Dropdown options
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
   function: fetchCourtListing
   purpose: fetches all courts for the given program into a JSON object
   input: $user_programID = program to fetch courts for
   output: JSON object
  *************************************************************************************************/
	public function fetchCourtListing(  $user_programID, $type ) 
	{
		//database connection and SQL query
		$core = Core::dbOpen();
		
		if( $type == 'time' ) {
		$sql = "SELECT cc.courtID, cc.court_caseID, cc.type, UNIX_TIMESTAMP(c.date) as date, cl.name, l.city, l.state, cc.timeEntered
						FROM court_case cc
						LEFT JOIN court c ON c.courtID = cc.courtID
						LEFT JOIN court_location cl ON c.courtLocationID = cl.courtLocationID
						LEFT JOIN program_locations l ON l.locationID = cl.locationID
						WHERE cc.programID = :programID";
    } else {
    $sql = "SELECT c.courtID, UNIX_TIMESTAMP(c.date) as date, cl.name, l.city, l.state
            FROM court c
            LEFT JOIN court_location cl ON c.courtLocationID = cl.courtLocationID
            LEFT JOIN program_locations l ON l.locationID = cl.locationID
            WHERE c.programID = :programID";
    }
	
		// additional sql command if different type of data wanted
		if( $type == 'upcoming' ) {  $sql .= " AND c.date > now()"; }
		if( $type == 'current' ) { $sql .= " AND c.date >= now() - INTERVAL 1 DAY"; };
		if( $type == 'time' ) { $sql .= " AND cc.timeEntered = 0"; };
		
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':programID', $user_programID );
		
		try {
			if($stmt->execute() && $stmt->rowCount() > 0) {
				while ($aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $row = array();
					if( $type == 'time' )
					  $row[] = $aRow["type"];
          else {
            //inner sql for row count
            $sql2 = "SELECT courtID, COUNT(*) FROM court_case WHERE courtID = :courtID GROUP BY courtID";
            $stmt2 = $core->dbh->prepare($sql2);
            $stmt2->bindParam(':courtID', $aRow["courtID"]);
            try {
              if($stmt2->execute()) {
                $bRow = $stmt2->fetch(PDO::FETCH_ASSOC);
                $row[] = ($bRow["COUNT(*)"]) ? $bRow["COUNT(*)"] : 0;
              }
            } catch (PDOException $e) {
              $row[] = "0";
            }
          }
					$row[] = date("n/j/y h:i a",$aRow["date"]);
					$row[] = $aRow["name"];
					$row[] = ($aRow["city"]) ? $aRow["city"] . ", " . $aRow["state"] : NULL;
					
					if( $type == 'time' ) // change the link to go to time entry
						$row[] = '<a href="/court/hour_entry.php?id='. $aRow["court_caseID"] .'">View</a>';						
					else
						$row[] = '<a href="/court/view.php?id='. $aRow["courtID"] .'">View</a>';
					
					$output['aaData'][] = $row;
				}
				//closing here for inner sql search
				Core::dbClose();
				return json_encode($output);				
			}
		}
		catch (PDOException $e) {
      		echo "Court Data Read Failed!";
    }
    //close here if search failed
    Core::dbClose();
		return '{"aaData":[]}';
	}

  public function fetchCourtSearchListing( $user_programID, $courtName, $courtAddress, $courtTime, $courtDate ) 
  {
    //database connection and SQL query
    $core = Core::dbOpen();
    
    //get location first if it exists
    if( $courtName != '' && $courtAddress != '' ) {
      $sql = "SELECT courtLocationID FROM court_location 
              WHERE programID = :programID AND name = :name AND address = :address";
      $stmt = $core->dbh->prepare($sql);
      $stmt->bindParam(':programID', $user_programID);
      $stmt->bindParam(':name', $courtName);
      $stmt->bindParam(':address', $courtAddress);
      
      try{
        if($stmt->execute()) {
          $courtID = $stmt->fetch(PDO::FETCH_ASSOC);
          $courtID = $courtID["courtLocationID"];
        }
      } catch (PDOException $e) {
        $courtID = NULL;
      }
    }
    
    $sql = "SELECT c.courtID, UNIX_TIMESTAMP(c.date) as date, cl.name, l.city, l.state
            FROM court c
            LEFT JOIN court_location cl ON c.courtLocationID = cl.courtLocationID
            LEFT JOIN program_locations l ON l.locationID = cl.locationID
            WHERE c.programID = :programID";
            
    //add on extra limits, limit date/time within loop
    if( $courtName != '' )
      $sql = $sql." AND c.courtLocationID = :courtID";
    
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':programID', $user_programID );
    
    if( $courtName != '' )
      $stmt->bindParam(':courtID', $courtID);
    
    try {
      if($stmt->execute() && $stmt->rowCount() > 0) {
        while ($aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
          if( $courtTime != '' && date("h:i A", $aRow["date"]) != $courtTime) 
            continue;
          if( $courtDate != '' && date("m/j/Y", $aRow["date"]) != $courtDate) 
            continue;
          $row = array();
            //inner sql for row count
            $sql2 = "SELECT courtID, COUNT(*) FROM court_case WHERE courtID = :courtID GROUP BY courtID";
            $stmt2 = $core->dbh->prepare($sql2);
            $stmt2->bindParam(':courtID', $aRow["courtID"]);
            try {
              if($stmt2->execute()) {
                $bRow = $stmt2->fetch(PDO::FETCH_ASSOC);
                $row[] = ($bRow["COUNT(*)"]) ? $bRow["COUNT(*)"] : 0;
              }
            } catch (PDOException $e) {
              $row[] = "0";
            }
          
          $row[] = date("n/j/y h:i a",$aRow["date"]);
          $row[] = $aRow["name"];
          $row[] = ($aRow["city"]) ? $aRow["city"] . ", " . $aRow["state"] : NULL;
          $row[] = '<a href="/court/view.php?id='. $aRow["courtID"] .'">View</a>';
          
          $output['aaData'][] = $row;
        }
        //closing here for inner sql search
        Core::dbClose();
        if($output == NULL)
          return '{"aaData":[]}';
        else
          return json_encode($output);
      } 
    }
    catch (PDOException $e) {
          echo "Court Data Read Failed!";
    }
    //close here if search failed
    Core::dbClose();
    return '{"aaData":[]}';
  }

	/*************************************************************************************************
   function: fetchCourtLocation
   purpose: fetches court locations for the given program into a JSON object
   input: $user_programID = program to fetch court locations for
   output: JSON object
  *************************************************************************************************/
	public function fetchCourtLocation ( $user_programID ) 
	{
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
   function: fetchCourtJuryPool
   purpose: fetches possible jury pool members for the given program into a JSON object
   input: $user_programID = program to fetch jury pool for
   output: JSON object
  *************************************************************************************************/
	public function fetchCourtJuryPool( $user_programID, $court_caseID )
	{
		//database connection and SQL query
		$core = Core::dbOpen();
		$sql = "( SELECT vp.volunteerID as id, 'Volunteer' as type, v.lastName, v.firstName
						FROM volunteer_position vp
						LEFT JOIN volunteer v ON v.volunteerID = vp.volunteerID AND v.active = 1
						LEFT JOIN court_position cp ON cp.positionID = vp.positionID
						WHERE cp.position = 'Jury' AND v.programID = :programID )
						UNION
						( SELECT defendantID as id, 'Defendant' as type, lastName, firstName FROM defendant 
						WHERE programID = :programID )";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':programID', $user_programID );
		
		try {
			if($stmt->execute() && $stmt->rowCount() > 0) {
				while ($aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
					
					// check if the jury person is available
					if( $this->checkJuror( $court_caseID, $aRow["id"], $aRow["type"] ) )
					{
						$row = array();
						
						$row[] = $aRow["id"];
						$row[] = $aRow["type"];
						$row[] = $aRow["lastName"];
						$row[] = $aRow["firstName"];
						
						$output['aaData'][] = $row;
					}
				}
				return json_encode($output);
			}
		} catch ( PDOException $e ) {
			echo "Court Jury Pool Read Failed!";
		}
		return '{"aaData":[]}';
	}
	
	/*************************************************************************************************
   function: checkJuror
   purpose: checks a juror to see if they are available for the court listing or not
   input: $courtID = id of court
	 			  $jurorID = id of juror to lookup
					$type = type of juror
   output: boolean true = juror is ok for listing
	         boolean false = juror already belongs to the court
	 todo: could check time on court and make sure the juror isn't already listed in another court
	       at the same time
  *************************************************************************************************/
	private function checkJuror( $court_caseID, $jurorID, $type )
	{
		//database connection and SQL query
		$core = Core::dbOpen();
		
		// see if they are already listed - or if defendant, it isn't their court
		if( $type == 'Volunteer' )
			$sql = "( SELECT volunteerID FROM court_jury_volunteer WHERE court_caseID = :court_caseID AND volunteerID = :jurorID )
							UNION ( SELECT volunteerID FROM court_member WHERE court_caseID = :court_caseID AND volunteerID = :jurorID )";
		else
			$sql = "( SELECT defendantID FROM court_jury_defendant WHERE court_caseID = :court_caseID AND defendantID = :jurorID )
		 					UNION ( SELECT defendantID FROM court WHERE court_caseID = :court_caseID AND defendantID = :jurorID )";
		
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':court_caseID', $court_caseID );
		$stmt->bindParam(':jurorID', $jurorID );
		
		if( $stmt->execute() && $stmt->rowCount() > 0 ) 
			return false;

		
		return true;
	}

	/*************************************************************************************************
   function: fetchDefendantListing
   purpose: fetches defendants for the given program who are still going through the Teen Court program into a JSON object
   input: $user_programID = program to fetch defendants for
   output: JSON object
  *************************************************************************************************/
	public function fetchDefendantListing(  $user_programID ) 
	{
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
						
						$row[] = $aRow["defendantID"];
						$row[] = $aRow["courtCaseNumber"];
						$row[] = $aRow["lastName"];
						$row[] = $aRow["firstName"];
						$row[] = ($aRow["city"]) ? $aRow["city"] . ", " . $aRow["state"] : NULL;					
						$row[] = date("n/j/y h:i a",$aRow["added"]);					
						$row[] = '<a href="/defendant/view.php?id='. $aRow["defendantID"] .'">View</a>';				
						
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
	
	public function fetchDefendantSearchListing( $user_programID, $lastName, $firstName,
	                                             $location, $dateOfBirth, $homePhone,
                                               $courtFileNumber, $agencyNumber )
  {
    //set up sql
    $core = Core::dbOpen();
    $sql = "SELECT defendantID, courtCaseNumber, lastName, firstName, pLocationID, city, state, UNIX_TIMESTAMP( added ) AS added, dob, homePhone, agencyCaseNumber
            FROM defendant d
            LEFT JOIN program_locations pl ON pl.locationID = d.pLocationID
            WHERE closeDate IS NULL AND d.programID = :programID";
    
    //add extra limits
    if( $lastName != '' ) 
      $sql = $sql." AND d.lastName LIKE :lastName";
    if( $firstName != '' )
      $sql = $sql." AND d.firstName LIKE :firstName";
    if( $location != '' )
      $sql = $sql." AND ( city LIKE :location OR state LIKE :location)";
    if( $dateOfBirth != '' )
      $sql = $sql." AND dob LIKE :dateOfBirth";
    if( $homePhone != '' )
      $sql = $sql." AND homePhone LIKE :homePhone";
    if( $courtFileNumber != '' )
      $sql = $sql." AND courtCaseNumber LIKE :courtFileNumber";
    if( $agencyNumber != '')
      $sql = $sql." AND agencyCaseNumber LIKE :agencyNumber";
            
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':programID', $user_programID );
    
    //bind per item, rewrite is so LIKE works after it gets passed
    if( $lastName != '' ) {
      $lastName = "%$lastName%";
      $stmt->bindParam(':lastName', $lastName );
    }
    if( $firstName != '') {
      $firstName = "%$firstName%";
      $stmt->bindParam(':firstName', $firstName );
    }
    if( $location != '') {
      $location = "%$location%";
      $stmt->bindParam(':location', $location);
    }
    if( $dateOfBirth != '') {
      $dateOfBirth = "%$dateOfBirth%";
      $stmt->bindParam(':location', $location);
    }
    if( $homePhone != '') {
      $homePhone = "%$homePhone%";
      $stmt->bindParam(':homePhone', $homePhone);
    }
    if( $courtFileNumber != '') {
      $courtFileNumber = "%$courtFileNumber%";
      $stmt->bindParam(':courtFileNumber', $courtFileNumber);
    }
    if( $agencyNumber != '') {
      $agencyNumber = "%$agencyNumber%";
      $stmt->bindParam(':agencyCaseNumber', $agencyNumber);
    }
    
    Core::dbClose();
    
    try {
      if($stmt->execute() && $stmt->rowCount() > 0) {
        
        while ($aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $row = array();
            
            $row[] = $aRow["defendantID"];
            $row[] = $aRow["courtCaseNumber"];
            $row[] = $aRow["lastName"];
            $row[] = $aRow["firstName"];
            $row[] = ($aRow["city"]) ? $aRow["city"] . ", " . $aRow["state"] : NULL;          
            $row[] = date("n/j/y h:i a",$aRow["added"]);          
            $row[] = '<a href="/defendant/view.php?id='. $aRow["defendantID"] .'">View</a>';        
            
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
   function: fetchVolunteerListing
   purpose: fetches active volunteers for the given program into a JSON object
   input: $user_programID = program to fetch volunteers for
   output: JSON object
  *************************************************************************************************/
	public function fetchVolunteerListing(  $user_programID ) 
	{
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
						$row[] = '<a href="/volunteer/view.php?id='. $aRow["volunteerID"] .'">View</a>';				
						
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

  public function fetchVolunteerSearchListing( $user_programID, $firstName, $lastName, $phone, $email, $active ) 
  {
    //database connection and SQL query
    $core = Core::dbOpen();
    
    //get according to program
    $sql = "SELECT v.volunteerID, v.firstName, v.lastName, v.phone, v.email
            FROM volunteer v WHERE v.programID = :programID";
    
    //add extra limits
    if ($firstName != '')
      $sql = $sql." AND firstName LIKE :firstName";
    if ($lastName != '')
      $sql = $sql." AND lastName LIKE :lastName";
    if ($phone != '')
      $sql = $sql." AND phone LIKE :phone";
    if ($email != '')
      $sql = $sql." AND email LIKE :email";
    if ($active != '')
      $sql = $sql." AND active LIKE :active";
    $stmt = $core->dbh->prepare($sql);
    
    $stmt->bindParam(':programID', $user_programID );
    //add extra binds
    if ($firstName != '') {
      $firstName = "%$firstName%";
      $stmt->bindParam(':firstName', $firstName);
    }
    if ($lastName != '') {
      $lastName = "%$lastName%";
      $stmt->bindParam(':lastName', $lastName);
    }
    if ($phone != '') {
      $phone = "%$phone%";
      $stmt->bindParam(':phone', $phone);
    }
    if ($email != '') {
      $email = "%$email%";
      $stmt->bindParam(':email', $email);
    }
    if ($active != '') {
      ($active = "Yes") ? $active = 1 : $active = 0;
      $stmt->bindParam(':active', $active);
    }
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
            $row[] = '<a href="/volunteer/view.php?id='. $aRow["volunteerID"] .'">View</a>';        
            
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
   function: fetchWorkshopListing
   purpose: fetches workshops for the given program into a JSON object
   input: $user_programID = program to fetch workshops for
   output: JSON object
  *************************************************************************************************/
	public function fetchWorkshopListing(  $user_programID ) 
	{
		//database connection and SQL query
		$core = Core::dbOpen();
		
		$sql = "SELECT w.workshopID, UNIX_TIMESTAMP(w.date) AS date, w.title, w.instructor, name, city, state
						FROM workshop w
						LEFT JOIN workshop_location wl ON wl.workshopLocationID = w.workshopLocationID
						LEFT JOIN program_locations pl ON pl.locationID = wl.locationID
						WHERE w.programID = :programID";
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
						$row[] = $aRow["name"];
						$row[] = ($aRow["city"]) ? $aRow["city"] . ", " . $aRow["state"] : NULL;
						$row[] = '<a href="/workshop/view.php?id='. $aRow["workshopID"] .'">View</a>';				
						
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
	
	public function fetchWorkshopSearchListing( $user_programID, $date, $instructor, $location, $time, $topic ) 
  {
    //database connection and SQL query
    $core = Core::dbOpen();
    
    $sql = "SELECT w.workshopID, UNIX_TIMESTAMP(w.date) AS date, w.title, w.instructor, name, city, state
            FROM workshop w
            LEFT JOIN workshop_location wl ON wl.workshopLocationID = w.workshopLocationID
            LEFT JOIN program_locations pl ON pl.locationID = wl.locationID
            WHERE w.programID = :programID";
            
    //add extra limits
    if( $instructor != '')
      $sql = $sql." AND w.instructor LIKE :instructor";
    if( $location != '')
      $sql = $sql." AND w.workshopLocationID = :location";
    if( $topic != '')
      $sql = $sql." AND w.title LIKE :title";
    
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':programID', $user_programID );
    
    //add extra bindings
    if( $instructor != '') {
      $instructor = "%$instructor%";
      $stmt->bindParam(':instructor', $instructor);
    }
    if( $location != '')  //location is the ID, no need for extra search
      $stmt->bindparam(':location', $location);
    if( $topic != '') {
      $topic = "%$topic%";
      $stmt->bindParam(':title', $topic);
    }
    Core::dbClose();
    
    try {
      if($stmt->execute() && $stmt->rowCount() > 0) {
        
        while ($aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $row = array();
            if( $time != '' && date("h:i A", $aRow["date"]) != $time) 
              continue;
            if( $date != '' && date("m/j/Y", $aRow["date"]) != $date) 
              continue;
            
            $row[] = date("n/j/y h:i a", $aRow["date"]);
            $row[] = $aRow["title"];
            $row[] = $aRow["instructor"];
            $row[] = $aRow["name"];
            $row[] = ($aRow["city"]) ? $aRow["city"] . ", " . $aRow["state"] : NULL;
            $row[] = '<a href="/workshop/view.php?id='. $aRow["workshopID"] .'">View</a>';        
            
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
   function: fetchWorkshopDefendantsListing
   purpose: fetches defendants from the given program to be workshop participants into a JSON object
   input: $user_programID = program to fetch defendants for
   output: JSON object
  *************************************************************************************************/
	public function fetchWorkshopDefendantsListing( $user_programID ) 
	{
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
	
	/*************************************************************************************************
   function: fetchWorkshopLocation
   purpose: , fetches workshop locations for the given program into a JSON object
   input: $user_programID = program to fetch workshop locations for
   output: JSON object
  *************************************************************************************************/
	public function fetchWorkshopLocation ( $user_programID ) 
	{
		//database connection and SQL query
		$core = Core::dbOpen();
		$sql = "SELECT wl.name, wl.address, l.city, l.state, l.zip, wl.workshopLocationID FROM workshop_location wl
		        JOIN program_locations l ON wl.programID = :programID AND wl.locationID = l.locationID";
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
					$row[] = $aRow["workshopLocationID"];
					
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
   function: fetchProgramCommonLocations
   purpose: fetches common places for the given program into a JSON object
   input: $user_programID = program to fetch common places for
   output: JSON object
  *************************************************************************************************/
	public function fetchProgramCommonLocations( $user_programID )
	{
	  $data = NULL; 
    
		//database connection and SQL query
		$core = Core::dbOpen();
		$sql = "SELECT commonPlace, commonPlaceID FROM program_common_location 
						WHERE programID = :programID ORDER BY commonPlace";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':programID', $user_programID );
    Core::dbClose();
		
		try {
			if($stmt->execute() && $stmt->rowCount() > 0) {
				while ($aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$row = array();
					$row[] = $aRow["commonPlace"];
          $row[] = $aRow["commonPlaceID"];
					$output['aaData'][] = $row;
				}
				return json_encode($output);
			}
		} catch ( PDOException $e ) {
			echo "Common location read failed!";
		}
		return '{"aaData":[]}';
	}
	
	public function fetchOfficerListing( $user_programID ) {
	  $core = Core::dbOpen();
    $sql = "SELECT firstName, lastName, idNumber, phone, officerID FROM program_officers
            WHERE programID = :programID ORDER BY lastName";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':programID', $user_programID);
    Core::dbClose();
    
    try {
      if( $stmt->execute() && $stmt->rowCount() > 0) {
        while( $aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $row = array();
          $row[] = $aRow["firstName"];
          $row[] = $aRow["lastName"];
          $row[] = $aRow["idNumber"];
          $row[] = $aRow["phone"];
          $row[] = $aRow["officerID"];
          
          $output['aaData'][] = $row;
        }
        return json_encode($output);
      }
    } catch (PDOException $e) {
      echo "Officer Read Failed!";
    }
    return '{"aaData":[]}';
	}
} // end class
?>