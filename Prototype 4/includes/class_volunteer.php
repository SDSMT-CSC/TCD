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
	
	public function __construct()
	{
		$this->volunteerID = 0;
		$this->programID = NULL;
		$this->firstname = NULL;
		$this->lastname = NULL;
		$this->phone = NULL;
		$this->email = NULL;
		$this->positions = 0;
		$this->active = 1;
	}
	
	public function addVolunteer()
	{
		//open connection
		$core = Core::dbOpen();
		
		//mysql to add user
		$sql = "INSERT INTO volunteer (programID,firstName,lastName,phone,email)
		        VALUES (:programID, :firstName, :lastName, :phone, :email)";
		$stmt = $core->dbh->prepare($sql);
		
		//bind values
		$stmt->bindParam(':programID', $this->programID);
		$stmt->bindParam(':firstName', $this->firstName);
		$stmt->bindParam(':lastName', $this->lastName);
		$stmt->bindParam(':phone', $this->phone);
		$stmt->bindParam(':email', $this->email);
		
		Core::dbClose();
		
		//execute stmt
		try
		{			
			if( $stmt->execute() )
			{
				$this->volunteerID = $core->dbh->lastInsertId(); 
			}
		}
		catch ( PDOException $e )
		{
			echo "Add Volunteer Failed!";
			return false;
		}
		//add positions
		foreach ( $this->positions as $key => $value)
		{
			$core = Core::dbOpen();
			$sql = "INSERT INTO volunteer_position (volunteerID, positionID) 
					VALUES (:volunteerID, :positionID)";
			$stmt2 = $core->dbh->prepare($sql);
			$stmt2->bindParam(':volunteerID', $this->volunteerID);
			$stmt2->bindParam(':positionID', $value);
			Core::dbClose();
			
			try
			{
			$stmt2->execute();
			}
			catch ( PDOException $e )
			{
				echo "Add Volunteer Positons Failed!";
				return false;
			}
		}
		//both add volunteer and position were successful
		return true;
	}
	
	public function editVolunteer()
	{
		// database connection and sql query to update volunteer
		$core = Core::dbOpen();
		$sql = "UPDATE volunteer SET firstName = :firstName, lastName = :lastName, phone = :phone, email = :email, active = :active
		        WHERE volunteerID = :id";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':firstName', $this->firstName);
		$stmt->bindParam(':lastName', $this->lastName);
		$stmt->bindParam(':phone', $this->phone);
		$stmt->bindParam(':email', $this->email);
		$stmt->bindParam(':id', $this->volunteerID);
		$stmt->bindParam(':active', $this->active);
		Core::dbClose();
		
		//execute stmt
		try
		{
			$stmt->execute();
		}
		catch (PDOException $e )
		{
			echo "Edit Volunteer Failed";
		}
		
		//delete old positions
		$core = Core::dbOpen();
		$sql = "DELETE FROM volunteer_position WHERE volunteerID = :id";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':id', $this->volunteerID);
		Core::dbClose();
		
		try
		{
			$stmt->execute();
		}
		catch ( PDOException $e )
		{
			echo "Delete Old Volunteer Positions Failed!";
		}
		
		//add positions
		foreach ( $this->positions as $key => $value)
		{
			$core = Core::dbOpen();
			$sql = "INSERT INTO volunteer_position (volunteerID, positionID) 
					VALUES (:volunteerID, :positionID)";
			$stmt2 = $core->dbh->prepare($sql);
			$stmt2->bindParam(':volunteerID', $this->volunteerID);
			$stmt2->bindParam(':positionID', $value);
			Core::dbClose();
			
			try
			{
			$stmt2->execute();
			}
			catch ( PDOException $e )
			{
				echo "Add Volunteer Positons Failed!";
				return false;
			}
		}
		return false;
	}
	public function deleteVolunteer() {}
	public function editVolunteerHours() {}
	public function printVolunteerHours() {}
	
	public function getVolunteer( $id )
	{
		// database connection and sql query
    	$core = Core::dbOpen();
    	$sql = "SELECT v.* FROM volunteer v WHERE v.volunteerID = :id";
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
		$sql = "SELECT p.positionID FROM volunteer_position p WHERE p.volunteerID = :id";
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
	
	public function getProgramPositions( $programID )
	{
		// database connection and sql query
		$core = Core::dbOpen();
		// might need to add 'OR c.programID = default' clause to add the default position list
		// talk to Andrew about that Tuesday
		$sql = "SELECT c.position, c.positionID FROM court_position c WHERE c.programID = :id OR c.programID = 0";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':id', $programID );
		Core::dbClose();
		
		try
		{
			if( $stmt->execute() )
			{
				//returns position as key and ID as value
				$positions = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
				return $positions;
			}
		}
		catch ( PDOException $e )
		{
			echo "Get Positions Failed";
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
	
	public function display()
	{
		echo "ProgramID: " . $this->programID . "<br>";
    	echo "Firstname: " . $this->firstName . "<br>";
    	echo "Lastname: " . $this->lastName . "<br>";
		echo "Phone: " . $this->phone . "<br>";
    	echo "Email: " . $this->email . "<br>";
		echo "Positions: "; var_dump($this->positions); echo "<br>";
	}
}
?>
