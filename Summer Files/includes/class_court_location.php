<?php

class courtLocation {
	
	private $courtLocationID;
	private $programID;
	public $locationID;
	public $name;
	public $address;
	public $city;
	public $state;
	public $zip;
	
  /*************************************************************************************************
   function: __construct
   purpose: class constructor
   input: $user_programID = programID
   output: empty courtLocation object
  *************************************************************************************************/
	public function __construct( $user_programID )
	{
		$this->courtLocationID = 0;
		$this->programID = $user_programID;
		$this->locationID = NULL;
		$this->name = NULL;
		$this->address = NULL;
		$this->city = NULL;
		$this->state = NULL;
		$this->zip = NULL;
	}
	
  /*************************************************************************************************
   function: updateCourtLocation
   purpose: adds a new court location to database if it doesn’t exist in the database, otherwise updates the location if they don’t match
   input: none
   output: none
  *************************************************************************************************/
	public function updateCourtLocation()
	{
		
		$core = Core::dbOpen();
		
		//  get courtLocationID if exists
		$sql = "SELECT courtLocationID, locationID FROM court_location 
						WHERE programID	= :programID AND name	= :name AND address = :address";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':programID', $this->programID);
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':address', $this->address);
		
		try {
			if ( $stmt->execute() && $stmt->RowCount() > 0 ) // location exists
			{
				$row = $stmt->fetch();
				$this->courtLocationID = $row["courtLocationID"];
				
				// if the current location ID differs than what is in the location, update it
				if( $this->locationID != $row["locationID"] ) {				
						$sql = "UPDATE court_location SET locationID = :locationID WHERE courtLocationID = :id";
						$stmt = $core->dbh->prepare($sql);
						$stmt->bindParam(':locationID', $this->locationID);
						$stmt->bindParam(':id', $this->courtLocationID);
						$stmt->execute();
				}
				
				return true;
			}
			else // add it
			{
				$sql = "INSERT INTO court_location (programID,name,address,locationID)
		    	   	  VALUES (:programID, :name, :address, :locationID)";
				$stmt = $core->dbh->prepare($sql);
				$stmt->bindParam(':programID', $this->programID);
				$stmt->bindParam(':locationID', $this->locationID);
				$stmt->bindParam(':name', $this->name);
				$stmt->bindParam(':address', $this->address);
				Core::dbClose();
				
				try {
					if ( $stmt->execute() )
						$this->courtLocationID = $core->dbh->lastInsertId(); 		
					return true;
				} catch ( PDOException $e ) {
					echo "Add Court Location Failed";
				}
			}
		} catch ( PDOException $e ) {
			echo "Get Court Location ID Failed";
		}
		return false;
	}
	
	public function editCourtLocation()
	{
	  $core = Core::dbOpen();
    $sql = "UPDATE court_location SET name = :name, address = :address,
            locationID = :locationID WHERE courtLocationID = :id";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':locationID', $this->locationID);
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':address', $this->address);
    $stmt->bindParam(':id', $this->courtLocationID);
    Core::dbClose();
    
    try {
      if( $stmt->execute() )
        return true;
    } catch (PDOException $e) {
      echo "Edit Court Location Failed!";
    }
    return false;
	}

	/*************************************************************************************************
   function: getCourtLocation
   purpose: loads court location object with data based on courtLocID
   input: $courtLocID
   output: none
  *************************************************************************************************/
	public function getCourtLocation( $courtLocID )
	{
		$core = Core::dbOpen();
		$sql = "SELECT cl.name, cl.address, l.city, l.state, l.zip, l.locationID FROM court_location cl
		        JOIN program_locations l ON cl.courtLocationID = :courtLocID AND cl.locationID = l.locationID";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':courtLocID', $courtLocID );
		
		try{
			if($stmt->execute()) {
					$row = $stmt->fetch();
					
					$this->courtLocationID = $courtLocID;
					$this->name = $row["name"];
					$this->address = $row["address"];
					$this->city = $row["city"];
					$this->state = $row["state"];
					$this->zip = $row["zip"];
					$this->locationID = $row["locationID"];
			}
		} catch ( PDOException $e ) {
			echo "Get Court Location Failed!";
		}
	}
	
	//getters
	public function getCourtLocationID() { return $this->courtLocationID; }
	public function getProgramID() { return $this->programID; }
	
	//settters
	public function setCourtLocationID( $val ) { $this->courtLocationID = $val; }
	public function setProgramID( $val ) { $this->programID = $val; }
}

?>