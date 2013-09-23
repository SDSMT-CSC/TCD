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
    purpose: load the location object with information based off the given ID
    input: $id = locationID
    output: boolean true/false
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
    purpose: return location object based off programID, city, state, and zip
    input: $city = location city
           $state = location state
           $zip = location zip
    output: boolean true/false
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
    purpose: if the location city, state, and zip is not in the database, adds the location to the database.
    Otherwise retrieves the locationID
    input: $city = location city
           $state = location state
           $zip = location zip
    output: locationID
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
  
  /*************************************************************************************************
    function: updateLocation
    purpose: updates the existing location
    input: none
    output: boolean true/false
  ************************************************************************************************/
  public function updateLocation()
  {
    $core = Core::dbOpen();
    $sql = "UPDATE program_locations SET city = :city, state = :state, zip = :zip
            WHERE locationID = :id";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':city', $this->city);
    $stmt->bindParam(':state', $this->state);
    $stmt->bindParam(':zip', $this->zip);
    $stmt->bindParam(':id', $this->locationID);
    
    Core::dbClose();
    
    try {
      if($stmt->execute()) {
        return true;
      }
    } catch (PDOException $e) {
      return false;
    }
  }
  
  public function deleteLocation( $locationID )
  {
    $core = Core::dbOpen();
    //don't delete if locationID comes up anywhere
    $sql = "SELECT locationID FROM court_location WHERE programID = :programID AND locationID = :locationID
            UNION
            SELECT locationID FROM workshop_location WHERE programID = :programID AND locationID = :locationID
            UNION
            SELECT defendantID FROM defendant WHERE programID = :programID AND (plocationID = :locationID OR mlocationID = :locationID)";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':programID', $this->programID);
    $stmt->bindParam(':locationID', $locationID);
    Core::dbClose();
    
    try {
      if( $stmt->execute() ) {
        if( $stmt->rowCount() == 0 ) {
          $core = Core::dbOpen();
          $sql2 = "DELETE FROM program_locations WHERE locationID = :locationID";
          $stmt2 = $core->dbh->prepare($sql2);
          $stmt2->bindParam(':locationID', $locationID);
          Core::dbClose();
          
          try {
            if ($stmt2->execute()) {
              return true;
            }
          } catch (PDOException $e) {
            return false;
          }
        }
      } else {
        return false;
      }
    } catch (PDOException $e) {
      return false;
    }
  }
}
?>