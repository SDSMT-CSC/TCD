<?php
class School {
	
	private $programID;
	public $schoolID;
	public $name;
	public $address;
	public $city;
	public $state;
	public $zip;	
	
	 // constructor for location object
  public function __construct( $programID )
  {
		$this->programID = $programID;
    $this->schoolID = 0;
		$this->name = NULL;
		$this->address = NULL;
		$this->city = NULL;
		$this->state = NULL;
    $this->zip = NULL;
  }

	/*************************************************************************************************
    function: getFromID
    purpose: loads the school information that matches
    input: $id = schoolID
    output: boolean true/false
  ************************************************************************************************/
	public function getFromID( $id )
	{
		$core = Core::dbOpen();
		$sql = "SELECT * FROM program_schools WHERE programID = :programID AND schoolID = :schoolID";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':programID', $this->programID);
		$stmt->bindParam(':schoolID', $id);
		Core::dbClose();
		
		try {
			// if the location is found, set id otherwise add it
			if( $stmt->execute() && $stmt->rowCount() > 0 )
			{
				$row = $stmt->fetch();
				$this->schoolID = $row["schoolID"];
				$this->name = $row["schoolName"];
				$this->address = $row["address"];
				$this->city = $row["city"];
				$this->state = $row["state"];
				$this->zip = $row["zip"];
				return true;
			}
		} catch (PDOException $e) {
			echo "School get from id failed!";
		}
		return false;
	}	
	
	/*************************************************************************************************
    function: findSchool
    purpose: return a school object that matches all fields
    input: $name = name of the school
           $address = address of the school
           $city = city where school is located
           $state = state where school is located
           $zip = zip code of school
    output: 
  ************************************************************************************************/
	public function findSchool( $name, $address, $city, $state, $zip )
	{
	  // check to see if the school exists
    $core = Core::dbOpen();
    $sql = "SELECT schoolID FROM program_schools WHERE programID = :programID AND schoolName = :name 
						AND address = :address AND city = :city AND state = :state AND zip = :zip";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':programID', $this->programID);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':city', $city);
    $stmt->bindParam(':state', $state);
    $stmt->bindParam(':zip', $zip);
    Core::dbClose();
    
    try {
			// if the school is found, set id otherwise add it
			if( $stmt->execute() && $stmt->rowCount() > 0 )
			{
				$row =  $stmt->fetch(PDO::FETCH_ASSOC);
				$this->schoolID = $row["schoolID"];
				$this->name = $row["name"];
				$this->address = $row["address"];
				$this->city = $row["city"];
				$this->state = $row["state"];
				$this->zip = $row["zip"];
			}
    } catch (PDOException $e) {
      echo "School lookup failed!";
    }
		return false;	
	}
	
	 /*************************************************************************************************
    function: addSchool
    purpose: this function looks up a school based on name, address, city, state and zip code. if
		  it is found, the id is returned. If not, it is added to the school table. This prevents any
			duplicate information in the database.
    input: $name = name of the school
		 			 $address = address of the school
					 $city = city where school is located
					 $state = state where school is located
					 $zip = zip code of school
    output: returns the school id of the found or the newly entered school
  ************************************************************************************************/
  public function addSchool( $name, $address, $city, $state, $zip )
  {
    $schoolID = NULL;
		
		if( $name != "" && $address != "" && $city != "" && $state != "" && $zip != "" )
		{
			$this->findSchool( $name, $address, $city, $state, $zip );
			
			if( $this->schoolID == 0 )
			{	
				$core = Core::dbOpen();
				$sql = "INSERT INTO program_schools ( programID, schoolName, address, city, state, zip ) 
								VALUES ( :programID, :name, :address, :city, :state, :zip )";
				$stmt = $core->dbh->prepare($sql);
				$stmt->bindParam(':programID', $this->programID);
				$stmt->bindParam(':name', $name);
				$stmt->bindParam(':address', $address);
				$stmt->bindParam(':city', $city);
				$stmt->bindParam(':state', $state);
				$stmt->bindParam(':zip', $zip);
				Core::dbClose();
				
				try {
					if($stmt->execute())
						$schoolID = $core->dbh->lastInsertId(); 
				} catch (PDOException $e) {
					echo "Program school add failed!";
				}
			}		
			else
			{
				$schoolID = $this->schoolID;
			}
		}
    return $schoolID;
  }
  
  public function editSchool( $name, $address, $city, $state, $zip, $id ) {
    $core = Core::dbOpen();
    $sql = "UPDATE program_schools SET schoolName = :name, address = :address,
            city = :city, state = :state, zip = :zip WHERE schoolID = :id";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':city', $city);
    $stmt->bindParam(':state', $state);
    $stmt->bindParam(':zip', $zip);
    $stmt->bindparam(':id', $id);
    Core::dbClose();
    
    try {
      if( $stmt->execute() )
        return true;
    } catch (PDOException $e) {
      echo "Edit School Failed!";
    }
    return false;
  }
} // end class
?>