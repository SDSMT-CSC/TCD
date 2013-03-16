<?php

class Citation {

	private $citationID;
	private $defendantID;
	public $officerID;
	public $citationDate;
	public $address;
	public $locationID;
	public $commonLocationID;
	public $mirandized;
	public $drugsOrAlcohol;
		
	public function __construct( $defendantID )
	{		
		// database connection and sql query
		$core = Core::dbOpen();
		$sql = "SELECT *, UNIX_TIMESTAMP(date) as citationDate FROM citation WHERE defendantID = :defendantID";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':defendantID', $defendantID );
		Core::dbClose();
		
		try
		{
			if( $stmt->execute() && $stmt->rowCount() > 0 )
			{
				$row = $stmt->fetch();
				$this->citationID = $row["citationID"];
				$this->defendantID = $defendantID;
				$this->officerID = $row["officerID"];
				$this->citationDate = $row["citationDate"];
				$this->address = $row["address"];
				$this->locationID = $row["locationID"];
				$this->commonLocationID = $row["commonPlaceID"];
				$this->mirandized = $row["mirandized"];
				$this->drugsOrAlcohol = $row["drugsOrAlcohol"];			
			}
			else
			{
				$this->citationID = 0;
				$this->defendantID = $defendantID;
				$this->officerID = NULL;
				$this->citationDate = NULL;
				$this->address = NULL;
				$this->locationID = NULL;
				$this->commonLocationID = NULL;
				$this->mirandized = 0;
				$this->drugsOrAlcohol = 0;				
			}			
		} catch ( PDOException $e ) {
			echo "Set Citation Information Failed!";
		}
		return false;
	}
		
	public function updateCitation()
	{
			// database connection and sql query
			$core = Core::dbOpen();
			
			if( $this->citationID == 0 ) // add new defendant
			{
				$sql = "INSERT INTO citation (defendantID, officerID, date, address, locationID, mirandized, drugsOrAlcohol, commonPlaceID)
								VALUES (:defendantID, :officerID, :date, :address, :locationID, :mirandized, :drugsOrAlcohol, :commonPlaceID)";
			}
			else  // update existing record
			{
				$sql = "UPDATE citation SET defendantID = :defendantID, officerID = :officerID, date = :date, address = :address,
								locationID = :locationID, mirandized = :mirandized, drugsOrAlcohol = :drugsOrAlcohol, commonPlaceID = :commonPlaceID
								WHERE citationID = :citationID";
			}
						
			$stmt = $core->dbh->prepare($sql);
			if( $this->citationID > 0 ) { $stmt->bindParam(':citationID', $this->citationID); }
			$stmt->bindParam(':defendantID', $this->defendantID);
			$stmt->bindParam(':officerID', $this->officerID );
			$stmt->bindParam(':date', $core->convertToServerDate( $this->citationDate, $_SESSION["timezone"] ) );
			$stmt->bindParam(':address', $this->address);
			$stmt->bindParam(':locationID', $this->locationID);
			$stmt->bindParam(':mirandized', $this->mirandized);
			$stmt->bindParam(':drugsOrAlcohol', $this->drugsOrAlcohol);
			$stmt->bindParam(':commonPlaceID', $this->commonLocationID);
			Core::dbClose();
			
			try
			{
				if( $stmt->execute()) {
					// if it's a new defendant, get the last insertId
					if( $this->citationID == 0 )
						$this->citationID = $core->dbh->lastInsertId(); 
					return true;
				}
				
				print_r( $stmt->errorInfo() );
					
			} catch ( PDOException $e ) {
				echo "Set Citation Information Failed!";
			}
		return false;
	}
	
	public function removeCitation()
	{
		
	}
	
	public function addStolenItem()
	{
		
	}
	
	public function removeStolenItem()
	{
		
	}

	public function addVehicle()
	{
		
	}
	
	public function removeVehicle()
	{
		
	}
		
	// getters
	public function getDefendantID() { return $this->defendantID; }
}

?>