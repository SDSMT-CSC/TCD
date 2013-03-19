<?php

class courtLocation {
	private $courtLocationID;
	private $locationID;
	private $programID;
	private $name;
	private $address;
	private $city;
	private $state;
	private $zip;
	
	public function __construct()
	{
		$this->courtLocationID = 0;
		$this->locationID = 0;
		$this->programID = 0;
		$this->name = NULL;
		$this->address = NULL;
		$this->city = NULL;
		$this->state = NULL;
		$this->zip = NULL;
	}
	
	public function addCourtLocation()
	{
		$core = Core::dbOpen();
		$sql = "INSERT INTO court_location (programID,name,address,locationID)
		        VALUES (:programID, :name, :address, :locationID)";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':programID', $this->programID);
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':address', $this->address);
		$stmt->bindParam(':locationID', $this->locationID);
		
		Core::dbClose();
		
		try {
			if ( $stmt->execute() ) {
				$this->courtLocationID = $core->dbh->lastInsertId();
				return true;
			}
		} catch ( PDOException $e ) {
			echo "Add Court Location Failed";
		}
		
		return false;
	}
	
	public function editCourtLocation()
	{
		$core = Core::dbOpen();
		$sql = "UPDATE court_location SET name = :name, address = :address, locationID = :locationID WHERE courtLocationID = :courtLocationID";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':name', $this->name );
		$stmt->bindParam(':address', $this->address );
		$stmt->bindParam(':locationID', $this->locationID );
		$stmt->bindParam(':courtLocationID', $this->courtLocationID );
		
		try{
			if( $stmt->execute() )
				return true;
		} catch ( PDOException $e ) {
			echo "Edit Court Location Failed!";
		}
		return false;
	}
	
	public function deleteCourtLocation()
	{
		
	}
	
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
	public function getLocationID() { return $this->locationID; }
	public function getProgramID() { return $this->programID; }
	public function getName() { return $this->name;}
	public function getAddress() { return $this->address; }
	public function getCity() { return $this->city; }
	public function getState() { return $this->state; }
	public function getZip() { return $this->zip; }
	
	//settters
	public function setLocationID( $val ) { $this->locationID = $val; }
	public function setProgramID( $val ) { $this->programID = $val; }
	public function setName( $val ) { $this->name = $val; }
	public function setAddress( $val ) { $this->address = $val; }
	public function setCity( $val ) { $this->city = $val; }
	public function setState( $val ) { $this->state = $val; }
	public function setZip( $val ) { $this->zip = $val; }
}

?>