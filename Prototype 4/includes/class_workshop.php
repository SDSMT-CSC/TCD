<?php
class Workshop {
  private $workshopID;
  private $programID;
	private $date;
	private $title;
	private $description;
	private $instructor;
	private $officerID;
	private $workshopLocationID;
	
	public function __construct( $user_programID )
	{
		$this->workshopID = 0;
		$this->programID = $user_programID;
		$this->date = NULL;
		$this->title = NULL;
		$this->description = NULL;
		$this->instructor = NULL;
		$this->officerID = 0;
		$this->workshopLocationID = 0;
	}
	
	/*************************************************************************************************
		function: updateWorkshop
		purpose: 
		input: none
  	output: boolean true/false
	*************************************************************************************************/
	public function updateWorkshop()
	{
		//open connection and build sql string
		$core = Core::dbOpen();
		
		if( $this->workshopID == 0 ) {
			$sql = "INSERT INTO workshop (programID,date,title,description,instructor,officerID,workshopLocationID)
		        	VALUES (:programID, :date, :title, :description, :instructor, :officerID, :workshopLocationID)";
		} else {
			$sql = "UPDATE workshop SET programID = :programID, date = :date, title = :title, description = :description, 
							instructor = :instructor, officerID = :officerID, workshopLocationID = :workshopLocationID WHERE workshopID = :id";
		}

		//bind values
		$stmt = $core->dbh->prepare($sql);
		if( $this->workshopID > 0 ) { $stmt->bindParam(':id', $this->workshopID); }
		$stmt->bindParam(':programID', $this->programID);
		$stmt->bindParam(':date', $core->convertToServerDate( $this->date, $_SESSION["timezone"] ));
		$stmt->bindParam(':title', $this->title);
		$stmt->bindParam(':description', $this->description);
		$stmt->bindParam(':instructor', $this->instructor);
		$stmt->bindParam(':officerID', $this->officerID);
		$stmt->bindParam(':workshopLocationID', $this->workshopLocationID);
		Core::dbClose();
				
		try {
			if( $stmt->execute() ) {
				if( $this->workshopID == 0 )
					$this->workshopID = $core->dbh->lastInsertId(); 
										
				return true;
			}
		} catch ( PDOException $e ) {
			echo "Update Workshop Failed!";
		}
		return false;
	}
	
	/*************************************************************************************************
		function: deleteWorkshop
		purpose: 
		input: none
  	output: boolean true/false
	*************************************************************************************************/
	public function deleteWorkshop()
	{
		//remove participants first
		$core = Core::dbOpen();
		$sql = "DELETE FROM workshop_roster WHERE workshopID = :id";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':id', $this->workshopID);
		Core::dbClose();
		
		try
		{
			$stmt->execute();
			
		} catch ( PDOException $e ) {
			echo "Delete Workshop Participants Failed!";
			return false;
		}
		
		//delete workshop
		$core = Core::dbOpen();
		$sql = "DELETE FROM workshop WHERE workshopID = :id";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':id', $this->workshopID);
		Core::dbClose();
		
		try
		{
			if ( $stmt->execute() )
				return true;
		} catch ( PDOException $e ) {
			echo "Delete Workshop Failed!";
		}
		return false;
	}
	
	/*************************************************************************************************
		function: getWorkshop
		purpose: 
		input: id of workshop
  	output: boolean true/false
	*************************************************************************************************/
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
				$this->date = $row["date"];
				$this->title = $row["title"];
				$this->description = $row["description"];
				$this->instructor = $row["instructor"];
				$this->officerID = $row["officerID"];
				$this->workshopLocationID = $row["workshopLocationID"];
				
				return true;
			}
		}
		catch ( PDOException $e )
		{
			echo "Get Workshop Failed!";
		}
		return false;
	}
	
	/*************************************************************************************************
		function: addWorkshopParticipant
		purpose: 
		input: none
  	output: boolean true/false
	*************************************************************************************************/
	public function addWorkshopParticipant( $workshopID, $defendantID )
	{
		$core = Core::dbOpen();
		$sql = "INSERT INTO workshop_roster (workshopID,defendantID) VALUES (:workshopID, :defendantID)";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':workshopID', $workshopID);
		$stmt->bindParam(':defendantID', $defendantID);
		Core::dbClose();
		
		try {
			if( $stmt->execute() )
				return true;
		} catch ( PDOException $e ) {
			echo "Add Workshop Participant Failed!";
		}
		return false;
	}
	
	/*************************************************************************************************
		function: removeWorkshopParticipant
		purpose: 
		input: none
  	output: boolean true/false
	*************************************************************************************************/
	public function removeWorkshopParticipant( $workshopID, $defendantID )
	{
		$core = Core::dbOpen();
		$sql = "DELETE FROM workshop_roster WHERE workshopID = :workshopID AND defendantID = :defendantID";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':workshopID', $workshopID);
		$stmt->bindParam(':defendantID', $defendantID);
		Core::dbClose();
		
		try {
			if( $stmt->execute() )
				return true;
		} catch ( PDOException $e ) {
			echo "Remove Workshop Participant Failed!";
		}
		return false;
	}
	
	/*************************************************************************************************
		function: completedWorkshopParticipant
		purpose: 
		input: none
  	output: boolean true/false
	*************************************************************************************************/
	public function completedWorkshopParticipant( $workshopID, $defendantID )
	{
		$core = Core::dbOpen();
		$sql = "UPDATE workshop_roster SET completed = :completed WHERE workshopID = :workshopID AND defendantID = :defendantID";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam('completed', $core->convertToServerDate( date("d-m-Y g:i A"), $_SESSION["timezone"] ));
		$stmt->bindParam(':workshopID', $workshopID);
		$stmt->bindParam(':defendantID', $defendantID);
		Core::dbClose();
		
		try  {
			if( $stmt->execute() )
				return true;
		} catch ( PDOException $e ) {
			echo "Workshop Participant Completed Failed!";
		}
		return false;
	}
	
	/*************************************************************************************************
		function: listWorkshopParticipants
		purpose: 
		input: none
  	output: data string
	*************************************************************************************************/
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
	public function getworkshopLocationID() { return $this->workshopLocationID; }
	
	//setters
	public function setWorkshopID( $val ) { $this->workshopID = $val; }
	public function setProgramID( $val ) { $this->programID = $val; }
	public function setDate( $val ) { $this->date = $val; }
	public function setTitle( $val ) { $this->title = $val; }
	public function setDescription( $val ) { $this->description = $val; }
	public function setInstructor( $val ) { $this->instructor = $val; }
	public function setOfficerID( $val ) { $this->officerID = $val; }
	public function setworkshopLocationID( $val ) { $this->workshopLocationID = $val; }
	
	public function display()
	{
		echo "WorkshopID: " . $this->workshopID . "<br>";
		echo "ProgramID: " . $this->programID . "<br>";
		echo "Date: " . $this->date . "<br>";
		echo "Title: " . $this->title . "<br>";
		echo "Description: " . $this->description . "<br>";
		echo "Instructor: " . $this->instructor . "<br>";
		echo "OfficerID: " . $this->officerID . "<br>";
		echo "WorkshopLocationID: " . $this->workshopLocationID . "<br>";
	}
}
?>