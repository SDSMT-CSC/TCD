<?php

class Program {

	private $programID;
	private $code;
	private $name;
	public $phys_address;
	public $phys_city;
	public $phys_state;
	public $phys_zip;
	public $mail_address;
	public $mail_city;
	public $mail_state;
	public $mail_zip;
	public $phone;
	public $expunge;
	public $timezoneID;	
  public $active; 

  /*************************************************************************************************
    function: __construct()
    purpose: class constructor, sets default values when object is created
  *************************************************************************************************/
	public function __construct()
	{
			$this->programID = 0;
			$this->code = NULL;
			$this->name = NULL;
			$this->phys_address = NULL;
			$this->phys_city = NULL;
			$this->phys_state = NULL;
			$this->phys_zip = NULL;
			$this->mail_address = NULL;
			$this->mail_city = NULL;
			$this->mail_state = NULL;
			$this->mail_zip = NULL;
			$this->phone = NULL;
			$this->expunge = NULL;
			$this->timezoneID = NULL;	
      $this->active = 1; 
	}	
  
  /*************************************************************************************************
   function: programExists
	 purpose: checks the database to see if an email address exists for a user
   input: $code = code of the program being looking for
   output: boolean true/false
  *************************************************************************************************/
	public function programExists( $code )
	{
		// database connection and sql query
    $core = Core::dbOpen();
    $sql = "SELECT programID FROM program WHERE code = :code";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':code', $code);
    Core::dbClose();
    
    try
    {
      if( $stmt->execute()) 
			{
        $row = $stmt->fetch();
        if( $stmt->rowCount() > 0 ) {				
        	return true;
				}
      }
    } catch ( PDOException $e ) {
      echo "Search for program failed!";
    }
		return false;
	}
	
  /*************************************************************************************************
    function: getFromCode
    purpose: gets program information from an existing program code
    input: $code = code of a program being looked for
    output: boolean true/false
  *************************************************************************************************/
	public function getFromCode( $code )
	{
		// database connection and sql query
    $core = Core::dbOpen();
    $sql = "SELECT * FROM program WHERE code = :code";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':code', $code);
    Core::dbClose();
		 try
    {
      if( $stmt->execute()) 
			{
				$row = $stmt->fetch();
				 
				if( $stmt->rowCount() > 0 )
        {
  				$this->programID = $row["programID"];
  				$this->code = $row["code"];
  				$this->name = $row["name"];
  				$this->phys_address = $row["PAddress"];
  				$this->phys_city = $row["pCity"];
  				$this->phys_state = $row["pState"];
  				$this->phys_zip = $row["pZip"];
  				$this->mail_address = $row["mAddress"];
  				$this->mail_city = $row["mCity"];
  				$this->mail_state = $row["mState"];
  				$this->mail_zip = $row["mZip"];
					$this->timezoneID = $row["timezoneID"];	
  				$this->expunge = $row["expunge"];
          $this->active = $row["active"];
  				return true;
        }
			}
		} catch ( PDOException $e ) {
      echo "Get program by code failed!";
    }		
		return false;
	}

  /*************************************************************************************************
    function: getFromID
    purpose: get program data from an id
    input: $id = program id being looked up
    output: boolean true/false
  *************************************************************************************************/
	public function getFromID( $id )
	{
		// database connection and sql query
    $core = Core::dbOpen();
    $sql = "SELECT * FROM program WHERE programID = :id";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':id', $id);
    Core::dbClose();
		
	  try
    {
      if( $stmt->execute()) 
			{
			   $row = $stmt->fetch();
				 
         if( $stmt->rowCount() > 0 )
         {
  					$this->programID = $row["programID"];
  					$this->code = $row["code"];
  					$this->name = $row["name"];
  					$this->phys_address = $row["PAddress"];
  					$this->phys_city = $row["pCity"];
  					$this->phys_state = $row["pState"];
  					$this->phys_zip = $row["pZip"];
  					$this->mail_address = $row["mAddress"];
  					$this->mail_city = $row["mCity"];
  					$this->mail_state = $row["mState"];
  					$this->mail_zip = $row["mZip"];
  					$this->phone = $row["phone"];
  					$this->timezoneID = $row["timezoneID"];	
  					$this->expunge = $row["expunge"];
            $this->active = $row["active"];
  					return true;
         }
			}
		} catch ( PDOException $e ) {
      echo "Get program by id failed!";
    }		
		return false;
	}

  /*************************************************************************************************
    function: updateProgram
    purpose: updates or adds the program based on current information. If the program ID is 0,
      the program is added as a new one and the program id gets set. If there is an existing program
      id, it gets updated in the database. If the program is new, the location also gets set in
      the program_locations table.
    input: none
    output: boolean true/false
  *************************************************************************************************/
	public function updateProgram()
  {
    // database connection and sql query
    $core = Core::dbOpen();
    
    if( $this->programID == 0 ) // add new program
    {
      $sql = "INSERT INTO program (code,name,pAddress,pCity,pState,pZip,mAddress,mCity,mState,mZip,phone,expunge,timezoneID,active)
              VALUES (:code, :name, :pAddress, :pCity, :pState, :pZip, :mAddress, :mCity, :mState, :mZip, :phone, :expunge, :timezoneID, :active )";
    }
    else // update existing record
    {
      $sql = "UPDATE program SET code = :code, name = :name, pAddress = :pAddress, pCity = :pCity, pState = :pState, pZip = :pZip,
              mAddress = :mAddress, mCity = :mCity, mState = :mState, mZip = :mZip, phone = :phone, expunge = :expunge,
              timezoneID = :timezoneID, active = :active WHERE programID = :programID";
    }
    //echo "test1";
    $stmt = $core->dbh->prepare($sql);
    if( $this->programID > 0 ) { $stmt->bindParam(':programID', $this->programID); }
    $stmt->bindParam(':code', $this->code);
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':pAddress', $this->phys_address);
    $stmt->bindParam(':pCity', $this->phys_city);
    $stmt->bindParam(':pState', $this->phys_state);
    $stmt->bindParam(':pZip', $this->phys_zip);
    $stmt->bindParam(':mAddress', $this->mail_address);
    $stmt->bindParam(':mCity', $this->mail_city);
    $stmt->bindParam(':mState', $this->mail_state);
    $stmt->bindParam(':mZip', $this->mail_zip);
    $stmt->bindParam(':phone', $this->phone);
    $stmt->bindParam(':expunge', $this->expunge);    
    $stmt->bindParam(':timezoneID', $this->timezoneID);
    $stmt->bindParam(':active', $this->active);
    Core::dbClose();
    
    try
      {   
        if( $stmt->execute()) {
          
          // if it's a new program, get the last insertId
					// and add default court positions (stored procedure)
          if( $this->programID == 0 )
          {
            $this->programID = $core->dbh->lastInsertId(); 
            
            // also insert the city/state into the program locations table
            $core = Core::dbOpen();
            $sql = "INSERT INTO program_locations (programID, city, state, zip) 
                    VALUES(:programID, :city, :state, :zip)";
            $stmt = $core->dbh->prepare($sql);
            $stmt->bindParam(':programID', $this->programID);
            $stmt->bindParam(':city', $this->phys_city);
            $stmt->bindParam(':state', $this->phys_state);
            $stmt->bindParam(':zip', $this->phys_zip);

            try
            {
              $stmt->execute();
            } catch ( PDOException $e ) {
              echo "Set Program Location Failed!";
              return false;
            }
						
						// add default court positions
						$stmt = $core->dbh->prepare("CALL addCourtPositions(:id)");
						$stmt->bindParam(':id', $this->programID); 
						$stmt->execute();

            Core::dbClose();
          }
          return true;
        }
        
      } catch ( PDOException $e ) {
        echo "Set Program Information Failed!";
      }
      return false;
  }
  	
	/*************************************************************************************************
   function: fetchUserDropdown
   purpose: returns dropdown options of users in the program. Will return with a user selected if userID matches
   input: $userID = user to preselect
   output: Dropdown options
  *************************************************************************************************/
	public function fetchUserDropdown( $userID  )
	{
		$data = NULL;
					
		//database connection and SQL query
		$core = Core::dbOpen();
		$sql = "SELECT userID, firstName, lastName FROM user WHERE programID = :programID ORDER BY lastName";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':programID', $this->programID );
    Core::dbClose();
		
		try {
			if( $stmt->execute() ) {
				$data = "";
				while ($aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
					( $userID == $aRow["userID"] ) ? $selected = " selected" : $selected = "";
					$data .= '<option value="'.$aRow["userID"].'"'.$selected.'>'.$aRow["lastName"].", ".$aRow["firstName"].'</option>';
				}
			}			
		} catch ( PDOException $e ) {
			echo "User dropdown failed!";
		}
		return $data;
	}
	
	/*************************************************************************************************
   function: fetchOfficerDropdown
   purpose: returns dropdown options of officers in the program. Will return with an officer selected if officerID matches
   input: $officerID = officer to preselect
   output: Dropdown options
  *************************************************************************************************/
	public function fetchOfficerDropdown( $officerID )
	{
	  $data = NULL; 
    
		//database connection and SQL query
		$core = Core::dbOpen();
		$sql = "SELECT programID, officerID, lastName, firstName FROM program_officers 
						WHERE programID = :programID ORDER BY lastName";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':programID', $this->programID );
    Core::dbClose();
		
		try {
			if( $stmt->execute() ) {
				$data = "";
				while ($aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
					( $officerID == $aRow["officerID"] ) ? $selected = " selected" : $selected = "";
					$data .= '<option value="'.$aRow["officerID"].'"'.$selected.'>'.$aRow["lastName"].", ".$aRow["firstName"].'</option>';
				}
			}
		} catch ( PDOException $e ) {
			echo "Officer dropdown failed!";
		}
		return $data;
	}
	
	 /*************************************************************************************************
   function: fetchCommonLocation
   purpose: inserts a new common place if location is new and returns the commonplaceID, otherwise just returns the commonplaceID
   input: $location = name for the common location
   output: common location ID
  *************************************************************************************************/
		public function addCommonLocation( $location )
		{
			$commonID = NULL;
				
			$core = Core::dbOpen();
			$sql = "SELECT commonPlaceID FROM program_common_location WHERE programID = :programID AND commonPlace = :location";
			$stmt = $core->dbh->prepare($sql);
			$stmt->bindParam(':programID', $this->programID);
			$stmt->bindParam(':location', $location);
			
			try
			{
				if( $stmt->execute() )
				{
						if( $stmt->rowCount() == 0 ) // if it doesn't exist, then add it
						{
							$sql = "INSERT INTO program_common_location (programID, commonPlace) VALUES(:programID, :location)";
							$stmt = $core->dbh->prepare($sql);
							$stmt->bindParam(':programID', $this->programID);
							$stmt->bindParam(':location', $location);
							
							try
							{
								if( $stmt->execute() )
										$commonID = $core->dbh->lastInsertId(); 
							} catch ( PDOException $e ) {
								echo "Add common location Failed!";
							}
							
						} 
						else // look it up
						{
							$row = $stmt->fetch(PDO::FETCH_ASSOC);
							$commonID = $row["commonPlaceID"];	 
						}					
				}
				
			} catch ( PDOException $e ) {
					echo "Lookup common location failed!";
			}
			
			Core::dbClose();
			return $commonID;
		}

  /*************************************************************************************************
   function: editCommonLocation
   purpose: edit name of common location
   input: $locationID = id of common location
          $location = common location name
   output: Location name string
  *************************************************************************************************/
  public function editCommonLocation( $locationID, $location ) {
    $core = Core::dbOpen();
    $sql = "UPDATE program_common_location SET commonPlace = :location WHERE commonPlaceID = :id";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':id', $locationID);
    
    Core::dbClose();
    
    try {
      if( $stmt->execute() ) {
        return true;
      } else {
        return false;
      }
    } catch (PDOException $e) {
      return false;
    }
  }
		
  /*************************************************************************************************
   function: getCommonLocation
   purpose: returns the common place name
   input: $commonLocationID = location to retrieve
   output: Location name string
  *************************************************************************************************/
  public function getCommonLocation( $commonLocationID )
  {
    $commonPlaceName = NULL;

    $core = Core::dbOpen();
    $sql = "SELECT commonPlace FROM program_common_location WHERE programID = :programID AND commonPlaceID = :commonPlaceID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':programID', $this->programID);
    $stmt->bindParam(':commonPlaceID', $commonLocationID );

    try
    {
      if( $stmt->execute() )
      {
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$commonPlaceName = $row["commonPlace"];
			}
		} catch ( PDOException $e ) {
			echo "GEt common location Failed!";
		}
			
		return $commonPlaceName;
	}
  
  /*************************************************************************************************
   function: deleteCommonLocation
   purpose: check to see if a location is in use, delete if not in use
   input: $commonLocationID = id of the common location to be deleted
   output: Boolean true/false
  *************************************************************************************************/
  public function deleteCommonLocation( $commonLocationID )
  {
    $core = Core::dbOpen();
    
    $sql = "SELECT commonPlaceID FROM citation WHERE commonPlaceID = :commonPlaceID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':commonPlaceID', $commonLocationID);
    Core::dbClose();
    
    try {
      if( $stmt->execute() ) {
        if( $stmt->rowCount() == 0 ) {
          //safe to delete
          $core = Core::dbOpen();
          $sql2 = "DELETE FROM program_common_location WHERE commonPlaceID = :commonPlaceID";
          $stmt2 = $core->dbh->prepare($sql2);
          $stmt2->bindParam(':commonPlaceID', $commonLocationID);
          Core::dbClose();
          
          try {
            if( $stmt2->execute() ) {
              return true;
            } else {
              return false;
            }
          } catch (PDOException $e) {
            return false;
          }
        } else {
          return false;
        }
      } else {
        return false;
      }
    } catch (PDOException $e) {
      return false;
    }
  }
		
  /*************************************************************************************************
   function: addOfficer
   purpose: inserts the officer into the database
   input: $firstname = officer's first name
          $lastname = officer's last name
          $idNumber = officer's ID number
          $phone = phone number to contact officer
   output: ID of added officer
  *************************************************************************************************/
	public function addOfficer( $firstname, $lastname, $idNumber, $phone )
		{
			$officerID = NULL;
						
			if( $firstname && $lastname )
			{
				$core = Core::dbOpen();
				$sql = "INSERT INTO program_officers (programID, firstname, lastname, idNumber, phone) 
								VALUES(:programID, :firstname, :lastname, :idNumber, :phone)";
				$stmt = $core->dbh->prepare($sql);
				$stmt->bindParam(':programID', $this->programID);
				$stmt->bindParam(':firstname', $firstname);
				$stmt->bindParam(':lastname', $lastname);
				$stmt->bindParam(':idNumber', $idNumber);
				$stmt->bindParam(':phone', $phone);
				Core::dbClose();
				
				try
				{
					if( $stmt->execute() )
							$officerID = $core->dbh->lastInsertId();	
				} catch ( PDOException $e ) {
					echo "Add officer Failed!";
				}         
			}			
			return $officerID;
		}
  
  /*************************************************************************************************
   function: editOfficer
   purpose: edit existing officer
   input: $firstName = officer first name
          $lastName = officer last name
          $idNumber = officer ID number
          $phone = officer phone number
          $id = officer database ID number
   output: Location name string
  *************************************************************************************************/
  public function editOfficer( $firstName, $lastName, $idNumber, $phone, $id ) {
    $core = Core::dbOpen();
    $sql = "UPDATE program_officers SET firstname = :firstname, lastname = :lastname,
            idNumber = :idNumber, phone = :phone WHERE officerID = :id";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':firstname', $firstName);
    $stmt->bindParam(':lastname', $lastName);
    $stmt->bindParam(':idNumber', $idNumber);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindparam(':id', $id);
    Core::dbClose();
    
    try {
      if( $stmt->execute() ) {
        return true;
      }
    } catch (PDOException $e) {
      echo "Edit Officer Failed!";
    }
    return false;
  }

  /*************************************************************************************************
   function: deleteOfficer
   purpose: check if an officer is in use within the program, delete if not in use
   input: $id = id of officer to be deleted
   output: Boolean true/false
  *************************************************************************************************/
  public function deleteOfficer ( $id ) {
    $core = Core::dbOpen();
    $sql = "SELECT officerID FROM citation WHERE officerID = :id
            UNION
            SELECT officerID FROM workshop WHERE officerID = :id";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':id', $id);
    Core::dbClose();
    
    try {
      if( $stmt->execute() ) {
        if( $stmt->rowCount == 0) {
          $core = Core::dbOpen();
          $sql2 = "DELETE FROM program_officers WHERE officerID = :id";
          $stmt2 = $core->dbh->prepare($sql2);
          $stmt2->bindParam(':id', $id);
          Core::dbClose();
          
          try {
            if( $stmt2->execute() )
              return true;
            else
              return false;
          } catch (PDOException $e) {
            return false;
          }
        }
        return false;
      }
      return false;
    } catch (PDOException $e) {
      return false;
    }
  }
  
	/*************************************************************************************************
   function: addStatute
   purpose: inserts the statute into the database
   input: $programID = unused variable, uses object's programID
          $code = statute code
          $title = title of statute
          $description = details of the statute
   output: ID of added statute
  *************************************************************************************************/
	public function addStatute( $code,	$title, $description )
	{
		$statuteID = NULL;
				
		if( $code && $title )
		{
			$core = Core::dbOpen();
			$sql = "INSERT INTO program_statutes (programID, statute, title, description) 
							VALUES(:programID, :code, :title, :description)";
			$stmt = $core->dbh->prepare($sql);
			$stmt->bindParam(':programID', $this->programID);
			$stmt->bindParam(':code', $code);
			$stmt->bindParam(':title', $title);
			$stmt->bindParam(':description', $description);
			Core::dbClose();
			
			try
			{
				if( $stmt->execute() )
						$statuteID = $core->dbh->lastInsertId();	
			} catch ( PDOException $e ) {
				echo "Add statute Failed!";
			}         
		}			
		return $statuteID;
	}

  /*************************************************************************************************
   function: editStatute
   purpose: edit existing statute
   input: $code = statute code
          $title = title of statute
          $description = details of the statute
          $statuteID = id of statute in database
   output: ID of added statute
  *************************************************************************************************/
  public function editStatute( $code, $title, $description, $statuteID ) {
    $core = Core::dbOpen();
    $sql = "UPDATE program_statutes SET statute = :statute, title = :title,
            description = :description WHERE statuteID = :id";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':statute', $code);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':id', $statuteID);
    Core::dbClose();
    
    try {
      if( $stmt->execute() ) {
        return true;
      }
    } catch (PDOException $e) {
      echo "Edit Officer Failed!";
    }
    return false;
  }
  
  /*************************************************************************************************
   function: deleteStatute
   purpose: check to see if a statute is in use within the program, delete if not in use
   input: $statuteID = id of statute to be deleted
   output: Boolean true/false
  *************************************************************************************************/
  public function deleteStatute( $statuteID ) {
    $core = Core::dbOpen();
    $sql = "SELECT statuteID FROM citation_offense WHERE statuteID = :id";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':id', $statuteID);
    Core::dbClose();
    
    try {
      if( $stmt->execute() ) {
        if( $stmt->rowCount() == 0 ) {
          $core = Core::dbOpen();
          $sql2 = "DELETE FROM program_statutes WHERE statuteID = :id";
          $stmt2 = $core->dbh->prepare($sql2);
          $stmt2->bindParam(':id', $statuteID);
          Core::dbClose();
          
          try {
            if( $stmt2->execute() )
              return true;
            else
              return false;
          } catch (PDOException $e) {
            return false;
          }
        }
        return false;
      }
    } catch (PDOException $e) {
      return false;
    }
    return false;
  }
	
	/*************************************************************************************************
   function: getProgramPositions
   purpose: returns key and ID of court positions
   input: none
   output: array of positions as key and ID as value
  *************************************************************************************************/
  public function getProgramPositions()
  {
  	// database connection and sql query
  	$core = Core::dbOpen();
  	$sql = "SELECT c.position, c.positionID FROM court_position c WHERE c.programID = :id ORDER BY c.position";
  	$stmt = $core->dbh->prepare($sql);
  	$stmt->bindParam(':id', $this->programID );
  	Core::dbClose();
  	
  	try
  	{
  		if( $stmt->execute() )
  		{
  			//returns position as key and ID as value
  			$positions = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
  			return $positions;
  		}
  	}
  	catch ( PDOException $e )
  	{
  		echo "Get court positions failed";
  	}
  	
  	return false;
  }
  
  /*************************************************************************************************
   function: addPosition
   purpose: add new position for the program to the database
   input: $programID = id of program
          $position = name of position
   output: boolean true/false
  *************************************************************************************************/
  public function addPosition( $programID, $position )
  {
    $core = Core::dbOpen();
    $sql = "INSERT INTO court_position (programID, position) VALUES (:programID, :position)";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':programID', $programID);
    $stmt->bindParam(':position', $position);
    Core::dbClose();
    
    try {
      if( $stmt->execute() )
        return true;
    } catch (PDOException $e) {
      echo "Add Position Failed!";
    }
    return false;
  }
  
  /*************************************************************************************************
   function: editPosition
   purpose: edit existing position in database
   input: $programID = id of program
          $position = name of position
          $positionID = id in database of position
   output: boolean true/false
  *************************************************************************************************/
  public function editPosition( $programID, $position, $positionID )
  {
    $core = Core::dbOpen();
    $sql = "UPDATE court_position SET position = :position
            WHERE programID = :programID AND positionID = :positionID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':programID', $programID);
    $stmt->bindParam(':position', $position);
    $stmt->bindParam(':positionID', $positionID);
    Core::dbClose();
    
    try {
      if( $stmt->execute() )
        return true;
    } catch (PDOException $e) {
      echo "Edit Position Failed!";
    }
    return false;
  }
  
  /*************************************************************************************************
   function: deletePosition
   purpose: check to see if a court position is in use within the program, delete if not in use
   input: $id = id of court position to be deleted
   output: Boolean true/false
  *************************************************************************************************/
  public function deletePosition( $id )
  {
    $core = Core::dbOpen();
    $sql = "SELECT positionID FROM volunteer_position WHERE positionID = :id";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':id', $id);
    Core::dbClose();
    
    try {
      if( $stmt->execute() ) {
        if( $stmt->rowCount() == 0) {
          $core = Core::dbOpen();
          $sql2 = "DELETE FROM court_position WHERE positionID = :id";
          $stmt2 = $core->dbh->prepare($sql2);
          $stmt2->bindParam(':id', $id);
          Core::dbClose();
          
          try {
            if( $stmt2->execute() )
              return true;
            else
              return false;
          } catch (PDOException $e) {
            return false;
          }
        }
      } return false;
    } catch (PDOException $e) {
      return false;
    }
  }
  
	/*************************************************************************************************
   function: addSentence
   purpose: inserts the sentence into the database
   input: $name = sentence name
          $description = description of sentence
          $additional = addition field for sentence
   output: ID of added sentence
  *************************************************************************************************/
	public function addSentence( $name,	$description, $additional )
	{						
		if( $name )
		{
			$core = Core::dbOpen();
			$sql = "INSERT INTO program_sentences (programID, name, description, additional) 
							VALUES(:programID, :name, :description, :additional)";
			$stmt = $core->dbh->prepare($sql);
			$stmt->bindParam(':programID', $this->programID);
			$stmt->bindParam(':name', $name);
			$stmt->bindParam(':description', $description);
			$stmt->bindParam(':additional', $additional);
			Core::dbClose();
			
			try
			{
				if( $stmt->execute() )
						$sentenceID = $core->dbh->lastInsertId();	
			} catch ( PDOException $e ) {
				echo "Add Sentence Failed!";
			}         
		}			
		return $sentenceID;
	}

  /*************************************************************************************************
   function: editSentence
   purpose: edit existing sentence in database
   input: $name = sentence name
          $description = description of sentence
          $additional = addition field for sentence
          $sentenceID = id of sentence in database
   output: boolean true/false
  *************************************************************************************************/
  public function editSentence( $name, $description, $additional, $sentenceID )
  {
    $core = Core::dbOpen();
    $sql = "UPDATE program_sentences SET name = :name, description = :description,
            additional = :additional WHERE sentenceID = :sentenceID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':additional', $additional);
    $stmt->bindParam(':sentenceID', $sentenceID);
    Core::dbClose();
    
    try {
      if( $stmt->execute() )
        return true;
    } catch (PDOException $e) {
      echo "Edit Sentence Failed!";
    }
    return false;
  }
  
  /*************************************************************************************************
   function: deleteSentence
   purpose: check to see if a sentence is in use within the program, delete if not in use
   input: $id = id of sentence to be deleted
   output: Boolean true/false
  *************************************************************************************************/
  public function deleteSentence( $id )
  {
    $core = Core::dbOpen();
    $sql = "SELECT sentenceID FROM defendant_sentence WHERE sentenceID = :id";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':id', $id);
    Core::dbClose();
    
    try {
      if( $stmt->execute() ) {
        if( $stmt->rowCount() == 0) {
          $core = Core::dbOpen();
          $sql2 = "DELETE FROM program_sentences WHERE sentenceID = :id";
          $stmt2 = $core->dbh->prepare($sql2);
          $stmt2->bindParam(':id', $id);
          Core::dbClose();
          
          try {
            if( $stmt2->execute() )
              return true;
          } catch (PDOException $e) {
            return false;
          }
        }
      } return false;
    } catch (PDOException $e) {
      return false;
    }
  }
  
  /*************************************************************************************************
   function: addProgramAccess
   purpose: give another program the ability to generate reports using your data
   input: $code = code of the program allowed to access data
   output: Boolean true/false
  *************************************************************************************************/
  public function addProgramAccess( $code )
  {
    $core = Core::dbOpen();
    $sql = "SELECT programID FROM program WHERE code = :code AND programID != :programID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':code', $code);
    $stmt->bindParam(':programID', $this->programID);
    Core::dbClose();
    
    try {
      if( $stmt->execute() ) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $id = $row["programID"];
        $core = Core::dbOpen();
        $sql2 = "INSERT INTO report_access (programID, access_program) VALUES
                 (:programID, :access_program)";
        $stmt2 = $core->dbh->prepare($sql2);
        $stmt2->bindParam(':programID', $id);
        $stmt2->bindParam(':access_program', $this->programID);
        Core::dbClose();
        
        try {
          if( $stmt2->execute() )
            return true;
        } catch (PDOException $e) {
          return false;
        }
      }
    } catch (PDOException $e) {
      return false;
    }
    return false;
  }
  
  /*************************************************************************************************
   function: getProgramAccess
   purpose: retrieve programs that can access your program's data
   input: None
   output: PHP array
  *************************************************************************************************/
  public function getProgramAccess()
  {
    // database connection and sql query
    $core = Core::dbOpen();
    $sql = "SELECT p.name, ra.access_program
            FROM report_access ra
            JOIN program p ON p.programID = ra.access_program
            WHERE ra.programID = :programID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':programID', $this->programID );
    Core::dbClose();
    
    try
    {
      if( $stmt->execute() )
      {
        //returns position as key and ID as value
        $positions = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        return $positions;
      }
    }
    catch ( PDOException $e )
    {
      echo "Get court positions failed";
    }
    
    return false;
  }
  
  /*************************************************************************************************
   function: deleteProgramAccess
   purpose: remove a program from being able to access your program's data
   input: $id = id of the program to be removed
   output: Boolean true/false
  *************************************************************************************************/
  public function deleteProgramAccess( $id )
  {
    $core = Core::dbOpen();
    $sql = "DELETE FROM report_access 
            WHERE programID = :programID AND access_program = :access_program";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':programID', $id);
    $stmt->bindParam(':access_program', $this->programID);
    Core::dbClose();
    
    if( $stmt->execute() )
      return true;
    else
      return false;
  }
	
  /*************************************************************************************************
   function: removeProgram
   purpose: set the 'active' flag to false for the given program
   input: None
   output: Boolean true/false
  *************************************************************************************************/
  public function removeProgram()
  {
    $active = 0;
    $core = Core::dbOpen();
    $sql = "UPDATE program SET active = :active WHERE programID = :programID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':active', $active);
    $stmt->bindParam(':programID', $this->programID);
    Core::dbClose();
    
    if( $stmt->execute() )
      return true;
    else
      return false;
  }
  
  /*************************************************************************************************
   function: deleteProgram
   purpose: delete a program from the database
   input: None
   output: Boolean true/false
  *************************************************************************************************/
  public function deleteProgram()
  {
    $core = Core::dbOpen();
    
    $sql = "DELETE FROM court_position WHERE programID = :programID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':programID', $this->programID);
    $stmt->execute();
    
    $sql = "DELETE FROM program_locations WHERE programID = :programID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':programID', $this->programID);
    $stmt->execute();
    
    $sql = "DELETE FROM program WHERE programID = :programID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':programID', $this->programID);
    $stmt->execute();
  }
	
	// getters
	public function getProgramID() { return $this->programID; }
	public function getName() { return $this->name; }
  public function getCode() { return $this->code; }
	public function getFullAddress() { 
		$str = $this->phys_address . "<br>";
		if( $this->phys_city ) $str .= $this->phys_city . ", ";
		if( $this->phys_state ) { $str .= $this->phys_state . "  "; }
		if( $this->phys_zip ) { $str .= $this->phys_zip; }
		return $str;
	}
	
	// setters
	public function setProgramID( $str ) { $this->programID = $str; }
	public function setName( $str ) { $this->name = $str; }
  public function setCode( $str ) { $this->code = $str; }

} // end class
?>