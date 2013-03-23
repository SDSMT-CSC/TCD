<?php

class courtLocation {
	private $workshopLocationID;
	private $locationID;
	private $programID;
	private $name;
	private $address;
	private $city;
	private $state;
	private $zip;
	
	public function __construct()
	{
		$this->workshopLocationID = 0;
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
		//get locationID to insert
		$core = Core::dbOpen();
		$sql = "SELECT locationID FROM program_locations WHERE programID = :programID AND
		        city = :city AND state = :state AND zip = :zip";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':programID', $this->programID);
		$stmt->bindParam(':city', $this->city);
		$stmt->bindParam(':state', $this->state);
		$stmt->bindParam(':zip', $this->zip);
		
		Core::dbClose();
		
		try {
			if ( $stmt->execute() ) {
				$row = $stmt->fetch();
				$this->locationID = $row["locationID"];
			}
		} catch ( PDOException $e ) {
			echo "Get LocationID Failed";
		}
		
		$core = Core::dbOpen();
		$sql = "INSERT INTO workshop_location (programID,name,address,locationID)
		        VALUES (:programID, :name, :address, :locationID)";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':programID', $this->programID);
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':address', $this->address);
		$stmt->bindParam(':locationID', $this->locationID);
		
		Core::dbClose();
		
		try {
			if ( $stmt->execute() ) {
				$this->workshopLocationID = $core->dbh->lastInsertId();
				return true;
			}
		} catch ( PDOException $e ) {
			echo "Add Workshop Location Failed";
		}
		
		return false;
	}
	
	public function editCourtLocation()
	{
		$core = Core::dbOpen();
		$sql = "UPDATE workshop_location SET name = :name, address = :address, locationID = :locationID WHERE workshopLocationID = :workshopLocationID";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':name', $this->name );
		$stmt->bindParam(':address', $this->address );
		$stmt->bindParam(':locationID', $this->locationID );
		$stmt->bindParam(':workshopLocationID', $this->workshopLocationID );
		
		try{
			if( $stmt->execute() )
				return true;
		} catch ( PDOException $e ) {
			echo "Edit Workshop Location Failed!";
		}
		return false;
	}
	
	public function deleteCourtLocation()
	{
		
	}
	
	public function getCourtLocation( $workshopLocID )
	{
		$core = Core::dbOpen();
		$sql = "SELECT wl.name, wl.address, l.city, l.state, l.zip, l.locationID FROM workshop_location wl
		        JOIN program_locations l ON wl.workshopLocationID = :workshopLocID AND wl.locationID = l.locationID";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':workshopLocID', $workshopLocID );
		
		try{
			if($stmt->execute()) {
					$row = $stmt->fetch();
					
					$this->workshopLocationID = $workshopLocID;
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