<?php
class Volunteer {

  private $volunteerID;
  private $programID;
  private $firstName;
  private $lastName;
  private $phone;
  private $email;
  private $positions;
  private $active;
  
  public function __construct( $programID )
  {
  	$this->volunteerID = 0;
  	$this->programID = $programID;
  	$this->firstname = NULL;
  	$this->lastname = NULL;
  	$this->phone = NULL;
  	$this->email = NULL;
  	$this->positions = array();
  	$this->active = 1;
  }
	
	/*************************************************************************************************
   function: getVolunteer
   purpose: returns volunteer information based on id
   input: $id = volunteer id to look up
   output: boolean true/false
  *************************************************************************************************/
  public function getVolunteer( $id )
  {		
		// database connection and sql query
		$core = Core::dbOpen();
		$sql = "SELECT * FROM volunteer WHERE volunteerID = :id";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':id', $id);
		Core::dbClose();
  	
  	try
  	{
  		if( $stmt->execute() )
  		{
  			$row = $stmt->fetch();
  			
  			$this->volunteerID = $id;
  			$this->programID = $row["programID"];
  			$this->firstName = $row["firstName"];
  			$this->lastName = $row["lastName"];
  			$this->phone = $row["phone"];
  			$this->email = $row["email"];
  			$this->active = $row["active"];
  		}
  	}
  	catch ( PDOException $e )
  	{
  		echo "Get Volunteer Failed!";
  		return false;
  	}
  	
  	// get position array
  	$core = Core::dbOpen();
  	$sql = "SELECT positionID FROM volunteer_position WHERE volunteerID = :id";
  	$stmt = $core->dbh->prepare($sql);
  	$stmt->bindParam(':id', $id);
  	Core::dbClose();
  	
  	try
  	{
  		if( $stmt->execute() )
  		{
  			$this->positions = $stmt->fetchAll(PDO::FETCH_COLUMN);
  			
  			return true;
  		}
  	}
  	catch ( PDOException $e )
  	{
  		echo "Get Volunteer Positions Failed!";
  	}
  	return false;
  }

  /*************************************************************************************************
    function: compareProgramID
    purpose: compares defendant's programID to user's programID to determine if it should be listed
    input: $id = defendant id
           $user_program = program id for user trying to view defendant
    output: boolean true/false
  *************************************************************************************************/
  public function compareProgramID( $id, $user_program )
  {
    // database connection and sql query
    $sql = "SELECT programID FROM volunteer WHERE volunteerID = :volunteerID";
    $core = Core::dbOpen();
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':volunteerID', $id);
    Core::dbClose();
    
    try
    {
      if( $stmt->execute() )
      {
        $row = $stmt->fetch();
        if( $user_program == $row["programID"] )
          return true;
      }
    } catch( PDOException $e ) {
      echo "ProgramID Compare Failed!";
    }
    return false;
  }
		
	/*************************************************************************************************
   function: updateVolunteer
   purpose: if volunteerID is empty, inserts volunteer into database. Otherwise updates volunteer information.
   After insert/update, clears all positions the volunteer holds in the database and inserts new positions
   input: none
   output: boolean false
  *************************************************************************************************/
  public function updateVolunteer()
  {
  	// database connection and sql query to update volunteer
  	$core = Core::dbOpen();
				
		if( $this->volunteerID == 0 ) { // add volunteer
			$sql = "INSERT INTO volunteer ( programID, firstName, lastName, phone, email, active )
							VALUES (:programID, :firstName, :lastName, :phone, :email, :active)";
		
		} else { // update volunteer
			$sql = "UPDATE volunteer SET firstName = :firstName, lastName = :lastName, phone = :phone, email = :email, active = :active
							WHERE volunteerID = :id";
		}
		
  	$stmt = $core->dbh->prepare($sql);
  	
		if( $this->volunteerID == 0 ) { 
			$stmt->bindParam(':programID', $this->programID); 
		} else { 
			$stmt->bindParam(':id', $this->volunteerID); 
		}
		
		$stmt->bindParam(':firstName', $this->firstName);
  	$stmt->bindParam(':lastName', $this->lastName);
  	$stmt->bindParam(':phone', $this->phone);
  	$stmt->bindParam(':email', $this->email);
  	$stmt->bindParam(':active', $this->active);
  	Core::dbClose();
  	
  	// execute stmt
  	try
  	{
  		if( $stmt->execute() )
			{
				if( $this->volunteerID == 0 )
					 $this->volunteerID = $core->dbh->lastInsertId(); 
			}
  	}
  	catch (PDOException $e )
  	{
  		echo "Update volunteer failed";
  	}
		
		// clear previous volunteer positions
		$this->clearPositions();
  	
  	// add positions
  	if($this->positions != null)
    {
  		$core = Core::dbOpen();
  		$sql = "INSERT INTO volunteer_position (volunteerID, positionID) VALUES (:volunteerID, :positionID)";
  		$stmt = $core->dbh->prepare($sql);
  		
    	foreach ( $this->positions as $value )
    	{
    		$stmt->bindParam(':volunteerID', $this->volunteerID);
    		$stmt->bindParam(':positionID', $value);
    		
  			try {
  				$stmt->execute();
  			} catch( PDOException $e ) {
    			echo "Add volunteer positons Failed!";
  			}
  		}
  		
   		Core::dbClose();
    }

  	return false;
  }
	
	/*************************************************************************************************
   function: clearPositions
   purpose: deletes all positions that the volunteer is currently assigned
   input: none
   output: boolean true/false
  *************************************************************************************************/
	 public function clearPositions()
  {
		//delete old positions
  	$core = Core::dbOpen();
  	$sql = "DELETE FROM volunteer_position WHERE volunteerID = :id";
  	$stmt = $core->dbh->prepare($sql);
  	$stmt->bindParam(':id', $this->volunteerID);
  	Core::dbClose();
  	
  	try
  	{
  		if( $stmt->execute() )
				return true;
  	}
  	catch ( PDOException $e )
  	{
  		echo "Delete existing volunteer positions failed!";
  	}
  	return false;
	}
	
	/*************************************************************************************************
   function: deleteVolunteer
   purpose: sets volunteer to inactive
   input: none
   output: boolean true/false
  *************************************************************************************************/
  public function deleteVolunteer()
  {  	
  	// delete volunteer - actually flag them in the database
  	$core = Core::dbOpen();
  	$sql = "UPDATE volunteer SET active = 'N' WHERE volunteerID = :id";
  	$stmt = $core->dbh->prepare($sql);
  	$stmt->bindParam(':id', $this->volunteerID);
  	Core::dbClose();
  	
  	try
  	{
  		if( $stmt->execute() )
				return true;
  	}
  	catch ( PDOException $e )
  	{
  		echo "Delete Volunteer Failed!";
  	}
		return false;
  }
	  
  //getter
  public function getVolunteerID() { return $this->volunteerID; }
  public function getProgramID() { return $this->programID; }
  public function getFirstName() { return $this->firstName; }
  public function getLastName() { return $this->lastName; }
  public function getPhone() { return $this->phone; }
  public function getEmail() { return $this->email; }
  public function getPositions() { return $this->positions; }
  public function getActive() { return $this->active; }
  
  //setter
  public function setVolunteerID( $val ) { $this->volunteerID = $val; }
  public function setProgramID( $val ) { $this->programID = $val; }
  public function setFirstName( $val ) { $this->firstName = $val; }
  public function setLastName( $val ) { $this->lastName = $val; }
  public function setPhone( $val ) { $this->phone = $val; }
  public function setEmail( $val ) { $this->email = $val; }
  public function setPositions( $val ) { $this->positions = $val; }
  public function setActive( $val ) { $this->active = $val; }

}

?>
