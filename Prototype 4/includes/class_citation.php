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
		
	/*************************************************************************************************
    function: __construct
    purpose:
    input:
    output: 
  ************************************************************************************************/
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
		
	/*************************************************************************************************
    function: updateCitation
    purpose:
    input:
    output: 
  ************************************************************************************************/
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
	
	/*************************************************************************************************
    function: getStatuteList
    purpose:
    input:
    output: 
  ************************************************************************************************/
	public function getOffenseList( $user_type )
	{
		$output = array();
		
		 // database connection and sql query
    $core = Core::dbOpen();
    $sql = "SELECT offenseID, statute, title, description
						FROM citation_offense c, program_statutes ps
						WHERE defendantID = :defendantID AND ps.statuteID = c.statuteID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':defendantID', $this->defendantID);
    Core::dbClose();
		
		try {
			if($stmt->execute() && $stmt->rowCount() > 0) {
				while ($aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$row = array();
					$row[] = $aRow["offenseID"];
					$row[] = $aRow["statute"];
					$row[] = '<strong>'.$aRow["title"].'</strong><br />'.$aRow["description"];
					
					if( $user_type != 5 )
						$row[] = '<a class="editor_remove" name="process.php?action=Delete Offense&defendantID='.
										$this->defendantID.'&offenseID='.$aRow["offenseID"].'">Delete</a>';
					else
						$row[] = '';										
										
					$output['aaData'][] = $row;
				}
				return json_encode($output);	
			}
		} 
		catch (PDOException $e) {
      		echo "Offense list fetch Failed!";
    }
		return '{"aaData":[]}';
	}
	
	/*************************************************************************************************
    function: addOffense
    purpose:
    input:
    output: 
  ************************************************************************************************/
	public function addOffense( $statuteID )
	{	
		 $offenseID == NULL;
	
		if( $statuteID )
		{		
			$core = Core::dbOpen();
			$sql = "INSERT INTO citation_offense (defendantID,statuteID) VALUES (:defendantID,:statuteID)";
			$stmt = $core->dbh->prepare($sql);
			$stmt->bindParam(':defendantID', $this->defendantID);
			$stmt->bindParam(':statuteID', $statuteID);
			Core::dbClose();
			
			try {
				if($stmt->execute())
					$offenseID = $core->dbh->lastInsertId();
			} catch (PDOException $e) {
				echo "Offense add failed!";
			}
		}
		else {
			$statuteID = $this->statuteID;
		}
    return $offenseID;
	}
	
	/*************************************************************************************************
    function: removeOffense
    purpose:
    input:
    output: 
  ************************************************************************************************/
	public function removeOffense( $offenseID )
	{
		if( $offenseID )
		{		
			$core = Core::dbOpen();
			$sql = "DELETE FROM citation_offense WHERE offenseID = :offenseID";
			$stmt = $core->dbh->prepare($sql);
			$stmt->bindParam(':offenseID', $offenseID);
			Core::dbClose();
			
			try {
				if($stmt->execute())
    			return true;
			} catch (PDOException $e) {
				echo "Offense add failed!";
			}
		}
    return false;
	}
	
	/*************************************************************************************************
    function: addStolenItem
    purpose:
    input:
    output: 
  ************************************************************************************************/
	public function getStolenItems()
	{
		$output = array();
		
		 // database connection and sql query
    $core = Core::dbOpen();
    $sql = "SELECT itemID, name, value FROM citation_stolen_items WHERE citationID = :citationID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':citationID', $this->citationID);
    Core::dbClose();
		
		try {
			if($stmt->execute() && $stmt->rowCount() > 0) {
				while ($aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$row = array();
					$row["itemID"] = $aRow["itemID"];
					$row["name"] = $aRow["name"];
					
					if( $aRow["value"] == 0 )
						$row["value"] = '';
					else
						$row["value"] = '$' . $aRow["value"];
					
					$output[] = $row;
				}
			}
		} catch (PDOException $e) {
      		echo "Stolen item list fetch Failed!";
    }
		
		return $output;
	}
	
	/*************************************************************************************************
    function: addStolenItem
    purpose:
    input:
    output: 
  ************************************************************************************************/
	public function addStolenItem( $name, $value )
	{
		$core = Core::dbOpen();
		$sql = "INSERT INTO citation_stolen_items (citationID,name,value) VALUES (:citationID,:name,:value)";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':citationID', $this->citationID);
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':value', $value);
		Core::dbClose();
		
		try {
			if($stmt->execute())
				return true;
		} catch (PDOException $e) {
			echo "Stolen item add failed!";
		}
		return false;
	}
	
	/*************************************************************************************************
    function: removeStolenItem
    purpose:
    input:
    output: 
  ************************************************************************************************/
	public function removeStolenItem( $itemID )
	{
		 // database connection and sql query
    $core = Core::dbOpen();
    $sql = "DELETE FROM citation_stolen_items WHERE itemID = :itemID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':itemID', $itemID);
    Core::dbClose();
		
		try {
			if($stmt->execute())
				return true;
		} catch (PDOException $e) {
      		echo "Delete stolen item Failed!";
    }
		return false;
	}

	/*************************************************************************************************
    function: getVehicles
    purpose:
    input:
    output: 
  ************************************************************************************************/
	public function getVehicles()
	{
		$output = array();
		
		 // database connection and sql query
    $core = Core::dbOpen();
    $sql = "SELECT * FROM citation_vehicle WHERE citationID = :citationID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':citationID', $this->citationID);
    Core::dbClose();
		
		try {
			if($stmt->execute() && $stmt->rowCount() > 0) {
				while ($aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$row = array();
					$row["vehicleID"] = $aRow["vehicleID"];
					$row["license"] = $aRow["licenseNumber"];
					$row["state"] = $aRow["licenseState"];
					$row["year"] = $aRow["year"];
					$row["make"] = $aRow["make"];
					$row["model"] = $aRow["model"];
					$row["color"] = $aRow["color"];
					$row["comment"] = $aRow["comment"];
										
					$output[] = $row;
				}
			}
		} catch (PDOException $e) {
      		echo "Vehicle list fetch Failed!";
    }
		
		return $output;
	}
	/*************************************************************************************************
    function: addVehicle
    purpose:
    input:
    output: 
  ************************************************************************************************/
	public function addVehicle( $year, $make, $model, $color, $license, $state, $comment )
	{
		$core = Core::dbOpen();
		$sql = "INSERT INTO citation_vehicle (citationID, licenseNumber, licenseState, make, model, year, color, comment) 
						VALUES (:citationID, :license, :state, :make, :model, :year, :color, :comment)";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':citationID', $this->citationID);
		$stmt->bindParam(':license', $license);
		$stmt->bindParam(':state', $state);
		$stmt->bindParam(':make', $make);
		$stmt->bindParam(':model', $model);
		$stmt->bindParam(':year', $year);
		$stmt->bindParam(':color', $color);
		$stmt->bindParam(':comment', $comment);
		Core::dbClose();
		
		try {
			if($stmt->execute())
				return true;				
		} catch (PDOException $e) {
			echo "Vehicle add failed!";
		}
		return false;
	}
	
	/*************************************************************************************************
    function: removeVehicle
    purpose:
    input:
    output: 
  ************************************************************************************************/
	public function removeVehicle( $vehicleID )
	{
		 // database connection and sql query
    $core = Core::dbOpen();
    $sql = "DELETE FROM citation_vehicle WHERE vehicleID = :vehicleID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':vehicleID', $vehicleID);
    Core::dbClose();
		
		try {
			if($stmt->execute())
				return true;
		} catch (PDOException $e) {
      		echo "Delete vehicle Failed!";
    }
		return false;		
	}
		
	// getters
	public function getDefendantID() { return $this->defendantID; }
	public function getCitationID() { return $this->citationID; }
	
}

?>