<?php

class Court {

	private $courtID;
	private $programID;
	private $defendantID;
	public $courtDate;
	public $type;
	public $contractSigned;

	public $closed;
	public $courtLocationID;
	
	public function __construct( $user_programID )
	{
		$this->courtID = 0;
		$this->programID = $user_programID;
		$this->courtDate = NULL;
		$this->type = NULL;
		$this->contractSigned = NULL;
		$this->closed = NULL;
		$this->courtLocationID = NULL;
	}
	
	/*************************************************************************************************
		function: updateCourt
		purpose: 
		input: none
  	output: boolean true/false
	*************************************************************************************************/
	public function updateCourt()
	{
			
		// add new defendant or update existing record
		if( $this->courtID == 0 ) {
			$sql = "INSERT INTO court (programID, defendantID, courtLocationID, type, contract, date, closed)
							VALUES (:programID, :defendantID, :courtLocationID, :type, :contract, :date, :closed )";
		} else {
			$sql = "UPDATE court SET programID = :programID, defendantID = :defendantID, courtLocationID = :courtLocationID, 
							type = :type,	contract = :contract, date = :date, closed = :closed
							WHERE courtID = :courtID";
		}
		
		// database connection and sql query			
		$core = Core::dbOpen();
		$stmt = $core->dbh->prepare($sql);
		if( $this->courtID > 0 ) { $stmt->bindParam(':courtID', $this->courtID); }
		$stmt->bindParam(':programID', $this->programID);
		$stmt->bindParam(':defendantID', $this->defendantID);
		$stmt->bindParam(':courtLocationID', $this->courtLocationID);
		$stmt->bindParam(':type', $this->type);
		$stmt->bindParam(':contract', $this->contractSigned);
		$stmt->bindParam(':date', $core->convertToServerDate( $this->courtDate, $_SESSION["timezone"] ));
		$stmt->bindParam(':closed', $this->closed);
		Core::dbClose();
				
		try
		{
			if( $stmt->execute()) {
				// if it's a new defendant, get the last insertId
				if( $this->courtID == 0 )
					$this->courtID = $core->dbh->lastInsertId(); 
				return true;
			}
		} catch ( PDOException $e ) {
			echo "Update Court information failed!";
		}
		return false;			
	}
	
	/*************************************************************************************************
		function: getFromID
		purpose: 
		input: none
  	output: boolean true/false
	*************************************************************************************************/
	public function getFromID( $id )
	{
		 // database connection and sql query
    $sql = "SELECT *, UNIX_TIMESTAMP( date ) AS date, UNIX_TIMESTAMP( closed ) AS closed
						FROM court 
						WHERE courtID = :courtID";
    $core = Core::dbOpen();
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':courtID', $id);
    Core::dbClose();
    
    try
    {
      if( $stmt->execute())
      {
        $row = $stmt->fetch();
        $this->courtID = $id;
        $this->programID = $row["programID"];
        $this->defendantID = $row["defendantID"];
				$this->courtDate =  $row["date"];
				$this->type = $row["type"];
				$this->contractSigned = ($row["contract"] == 1) ? "Yes": "No";
				$this->closed = ( $row["closed"] ) ? date("n/j/y h:i A", $row["closed"]) : NULL;
				$this->courtLocationID =  $row["courtLocationID"];
				
			}
		} catch ( PDOException $e ) {
      echo "Get court information failed!";
    }
    return false;
	}

	// setters
	public function setDefendantID( $val ) { $this->defendantID = $val; }
	public function setCourtID( $val ) { $this->courtID = $val; }

	// getters
	public function getDefendantID() { return $this->defendantID; }
	public function getCourtID() { return $this->courtID; }
}

?>