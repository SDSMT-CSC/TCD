<?php
class Workshop {
	private $workshopID;
	private $programID;
	private $date;
	private $title;
	private $description;
	private $instructor;
	private $officerID;
	
	public function __construct()
	{
		$this->workshopID = 0;
		$this->programID = 0;
		$this->date = NULL;
		$this->title = NULL;
		$this->description = NULL;
		$this->instructor = NULL;
		$this->officerID = NULL;
	}
	
	public function addWorkshop()
	{
		//open connection and build sql string
		$core = Core::dbOpen();
		$sql = "INSERT INTO workshop (programID,date,title,description,instructor,officerID)
		        VALUES (:programID, :date, :title, :description, :instructor, :officerID)";
		$stmt = $core->dbh->prepare($sql);
		
		//bind values
		$stmt->bindParam(':programID', $this->programID);
		$stmt->bindParam(':date', $core->convertToServerDate( $this->date, $_SESSION["timezone"] ));
		$stmt->bindParam(':title', $this->title);
		$stmt->bindParam(':description', $this->description);
		$stmt->bindParam(':instructor', $this->instructor);
		$stmt->bindParam(':officerID', $this->officerID);
		
		Core::dbClose();
		
		try
		{
			if( $stmt->execute() )
			{
				$this->workshopID = $core->dbh->lastInsertId(); 
				return true;
			}
		} 
		catch ( PDOException $e )
		{
			echo "Add Workshop Failed!";
		}
		return false;
	}
	
	public function editWorkshop()
	{
		//open connection and build sql string
		$core = Core::dbOpen();
		$sql = "UPDATE workshop SET date = :date, title = :title, description = :description, instructor = :instructor, officerID = :officerID
		        WHERE workshopID = :id";
		$stmt = $core->dbh->prepare($sql);
		
		//bind values
		$stmt->bindParam(':date', $core->convertToServerDate( $this->date, $_SESSION["timezone"] ));
		$stmt->bindParam(':title', $this->title);
		$stmt->bindParam(':description', $this->description);
		$stmt->bindParam(':instructor', $this->instructor);
		$stmt->bindParam(':officerID', $this->officerID);
		$stmt->bindParam(':id', $this->workshopID);
		
		Core::dbClose();
		
		try
		{
			if( $stmt->execute() )
			{
				return true;
			}
		} 
		catch ( PDOException $e )
		{
			echo "Edit Workshop Failed!";
		}
		return false;
	}
	
	private function deleteWorkshop()
	{
		
	}
	
	private function printWorkshopInformation()
	{
		
	}
	
	public function getWorkshop( $id )
	{
		//database connection and sql query
		$core = Core::dbOpen();
		$sql = "SELECT w.*, UNIX_TIMESTAMP(date) AS date FROM workshop w WHERE w.workshopID = :id";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':id', $id);
		Core::dbClose();
		
		try
		{
			if( $stmt->execute() )
			{
				$row = $stmt->fetch();
				
				$this->workshopID = $id;
				$this->programID = $row["programID"];
				$this->date = date("m/d/Y h:i A", $row["date"]);
				$this->title = $row["title"];
				$this->description = $row["description"];
				$this->instructor = $row["instructor"];
				$this->officerID = $row["officerID"];
			}
		}
		catch ( PDOException $e )
		{
			echo "Get Workshop Failed!";
		}
	}
	
	public function addWorkshopParticipant( $workshopID, $defendantID )
	{
		$core = Core::dbOpen();
		$sql = "INSERT INTO workshop_roster (workshopID,defendantID) VALUES (:workshopID, :defendantID)";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':workshopID', $workshopID);
		$stmt->bindParam(':defendantID', $defendantID);
		Core::dbClose();
		
		try
		{
			if( $stmt->execute() )
			{
				return true;
			}
		}
		catch ( PDOException $e )
		{
			echo "Add Workshop Participant Failed!";
		}
	}
	
	public function removeWorkshopParticipant( $workshopID, $defendantID )
	{
		$core = Core::dbOpen();
		$sql = "DELETE FROM workshop_roster WHERE workshopID = :workshopID AND defendantID = :defendantID";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':workshopID', $workshopID);
		$stmt->bindParam(':defendantID', $defendantID);
		Core::dbClose();
		
		try
		{
			if( $stmt->execute() )
			{
				return true;
			}
		}
		catch ( PDOException $e )
		{
			echo "Remove Workshop Participant Failed!";
		}
	}
	
	public function completedWorkshopParticipant( $workshopID, $defendantID )
	{
		$core = Core::dbOpen();
		$sql = "UPDATE workshop_roster SET completed = :completed WHERE workshopID = :workshopID AND defendantID = :defendantID";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam('completed', $core->convertToServerDate( date("d-m-Y g:i A"), $_SESSION["timezone"] ));
		$stmt->bindParam(':workshopID', $workshopID);
		$stmt->bindParam(':defendantID', $defendantID);
		Core::dbClose();
		
		try
		{
			if( $stmt->execute() )
			{
				return true;
			}
		}
		catch ( PDOException $e )
		{
			echo "Workshop Participant Completed Failed!";
		}
	}
	
	public function listWorkshopParticipants( $id )
	{
		$core = Core::dbOpen();
		$sql = "SELECT d.firstName, d.lastName, d.homePhone, d.defendantID, UNIX_TIMESTAMP(w.completed) AS completed FROM defendant d
				JOIN workshop_roster w ON d.defendantID = w.defendantID AND w.workshopID = :id";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':id', $id);
		Core::dbClose();
		
		try
		{
			if( $stmt->execute() )
			{
				$data = "";
				while ($aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
					if(is_null($aRow["completed"]))
						$completed = "Not completed";
					else
						$completed = date( "m-d-Y g:i A", $aRow["completed"]);
					$data .= '<tr><td>'.$aRow["lastName"].', '.$aRow["firstName"].
							 '</td><td>'.$aRow["homePhone"].
							 '</td><td>'.$completed.
							 '</td><td><a href="process.php?remove='.$aRow["defendantID"].'&workshopID='.$id.'">Remove</a></td>
							 <td><a href="process.php?completed='.$aRow["defendantID"].'&workshopID='.$id.'">Completed</a></td></tr>';
				}
			}
		}
		catch ( PDOException $e )
		{
			echo "Get Workshop Participants Failed!";
			return false;
		}
		return $data;
	}
	
	//getters
	public function getWorkshopID() { return $this->workshopID; }
	public function getProgramID() { return $this->programID; }
	public function getDate() { return $this->date; }
	public function getTitle() { return $this->title; }
	public function getDescription() { return $this->description; }
	public function getInstructor() { return $this->instructor; }
	public function getOfficerID() { return $this->officerID; }
	
	//setters
	public function setWorkshopID( $val ) { $this->workshopID = $val; }
	public function setProgramID( $val ) { $this->programID = $val; }
	public function setDate( $val ) { $this->date = $val; }
	public function setTitle( $val ) { $this->title = $val; }
	public function setDescription( $val ) { $this->description = $val; }
	public function setInstructor( $val ) { $this->instructor = $val; }
	public function setOfficerID( $val ) { $this->officerID = $val; }
	
	public function display()
	{
		echo "WorkshopID: " . $this->workshopID . "<br>";
		echo "ProgramID: " . $this->programID . "<br>";
		echo "Date: " . $this->date . "<br>";
		echo "Title: " . $this->title . "<br>";
		echo "Description: " . $this->description . "<br>";
		echo "Instructor: " . $this->instructor . "<br>";
		echo "OfficerID: " . $this->officerID . "<br>";
	}
}
?>