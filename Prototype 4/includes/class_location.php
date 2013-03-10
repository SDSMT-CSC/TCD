<?php
class Location {
	
	private $programID;
	public $locationID;
	public $city;
	public $state;
	public $zip;	
	
	 // constructor for location object
  public function __construct( $programID )
  {
		$this->programID = $programID;
    $this->locationID = 0;
		$this->city = NULL;
		$this->state = NULL;
    $this->zip = NULL;
  }
	
	/*************************************************************************************************
    function: getFromID
    purpose:
    input:
    output: 
  ************************************************************************************************/
	public function getFromID( $id )
	{		
		$core = Core::dbOpen();
		$sql = "SELECT * FROM program_locations WHERE programID = :programID AND locationID = :locationID";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':programID', $this->programID);
		$stmt->bindParam(':locationID', $id);
		Core::dbClose();
		
		try {
			// if the location is found, set id otherwise add it
			if( $stmt->execute() && $stmt->rowCount() > 0 )
			{
				$row = $stmt->fetch();
				$this->locationID = $row["locationID"];
				$this->city = $row["city"];
				$this->state = $row["state"];
				$this->zip = $row["zip"];
				return true;
			}
		} catch (PDOException $e) {
			echo "Location get from id failed!";
		}
		return false;
	}
	
	/*************************************************************************************************
    function: findLocation
    purpose:
    input:
    output: 
  ************************************************************************************************/
  public function findLocation( $city, $state, $zip )
	{		 
		// check to see if the location exists
		$core = Core::dbOpen();
		$sql = "SELECT locationID FROM program_locations WHERE programID = :programID 
						AND city = :city AND state = :state AND zip = :zip";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':programID', $this->programID);
		$stmt->bindParam(':city', $city);
		$stmt->bindParam(':state', $state);
		$stmt->bindParam(':zip', $zip);
		Core::dbClose();
			
		try {
			// if the location is found, set id otherwise add it
			if( $stmt->execute() && $stmt->rowCount() > 0 )
			{
				$row = $stmt->fetch();
				$this->locationID = $row["locationID"];
				$this->city = $row["city"];
				$this->state = $row["state"];
				$this->zip = $row["zip"];
				return true;			
			}
		} catch (PDOException $e) {
			echo "Location lookup failed!";
		}
		return false;			
	}
	
	/*************************************************************************************************
    function: addLocation
    purpose:
    input:
    output: 
  ************************************************************************************************/
  public function addLocation( $city, $state, $zip )
  {
    $locationID = NULL;
				
		if( $city != "" && $state != "" && $zip != "" )
		{		
			$this->findLocation( $city, $state, $zip );
			
			if( $this->locationID == 0 )
			{		
				$core = Core::dbOpen();
				$sql = "INSERT INTO program_locations (programID,city,state,zip)
								VALUES (:programID, :city, :state, :zip )";
				$stmt = $core->dbh->prepare($sql);
				$stmt->bindParam(':programID', $this->programID);
				$stmt->bindParam(':city', $city);
				$stmt->bindParam(':state', $state);
				$stmt->bindParam(':zip', $zip);
				Core::dbClose();
				
				try {
					if($stmt->execute())
						$locationID = $core->dbh->lastInsertId();    
				} catch (PDOException $e) {
					echo "Location add failed!";
				}
			}
			else
			{
				$locationID = $this->locationID;
			}
		}
    return $locationID;
  }
}
?>