<?php

class courtLocation {
	private $locationID;
	private $programID;
	private $name;
	private $address;
	private $city;
	private $state;
	private $zip;
	
	public function __construct()
	{
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
		$sql = "INSERT INTO court_location (programID,name,address,city,state,zip)
		        VALUES (:programID, :name, :address, :city, :state, :zip)";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':programID', $this->programID);
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':address', $this->address);
		$stmt->bindParam(':city', $this->city);
		$stmt->bindParam(':state', $this->state);
		$stmt->bindParam(':zip', $this->zip);
		
		Core::dbClose();
		
		try {
			if ( $stmt->execute() ) {
				$this->locationID = $core->dbh->lastInsertId();
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
		$sql = "UPDATE court_location SET name = :name, address = :address, city = :city,
		        state = :state, zip = :zip WHERE locationID = :locationID";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':address', $this->address);
		$stmt->bindParam(':city', $this->city);
		$stmt->bindParam(':state', $this->state);
		$stmt->bindParam(':zip', $this->zip);
		$stmt->bindParam(':locationID', $this->locationID);
		
		Core::dbClose();
		
		try {
			if ( $stmt->execute() ) {
				return true;
			}
		} catch ( PDOException $e ) {
			echo "Edit Court Location Failed";
		}
		return false;
	}
	
	public function deleteCourtLocation()
	{
		$core = Core::dbOpen();
		$sql = "DELETE FROM court_location WHERE locationID = :locationID";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':locationID', $this->locationID);
		
		Core::dbClose();
		
		try {
			if ( $stmt->execute() ) {
				return true;
			}
		} catch ( PDOException $e ) {
			echo "Delete Court Location Failed";
		}
		return false;
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