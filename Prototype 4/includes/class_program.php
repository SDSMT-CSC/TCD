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
	
	*************************************************************************************************/
	public function addStatute( $programID,	$code,	$title, $description )
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
	
	*************************************************************************************************/
  public function getProgramPositions()
  {
  	// database connection and sql query
  	$core = Core::dbOpen();
  	$sql = "SELECT c.position, c.positionID FROM court_position c WHERE c.programID = :id";
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
	
  // public function removeProgram() { }  --- set deleted flag
	
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