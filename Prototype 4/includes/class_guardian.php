<?php
class Guardian {

	private $defendantID;
	private $guardianID;
	public $relation;
	public $firstName;
	public $lastName;
	public $homePhone;
	public $workPhone;
	public $employer;
	public $email;
	public $pID;
	public $pAddress;
	public $mID;
	public $mAddress;
	public $livesWith;
	
	public function __construct( $defendantID )
	{		
		$this->defendantID = $defendantID;
		$this->guardianID = 0;
		$this->relation = NULL;
		$this->firstName = NULL;
		$this->lastName = NULL;
		$this->homePhone = NULL;
		$this->workPhone = NULL;
		$this->employer = NULL;
		$this->email = NULL;
		$this->physicalAddress = NULL;
		$this->pID = NULL;
		$this->mailingAddress = NULL;
		$this->mID = NULL;
		$this->livesWith = NULL;
	}
	
	public function updateGuardian()
	{
		 // database connection and sql query
    $core = Core::dbOpen();
		
		if( $this->guardianID == 0 ) // add new guardian
		{
	    $sql = "INSERT INTO guardian (defendantID, relation, firstName, lastName, homePhone,
							workPhone, email, employer, pAddress, mAddress, pLocationID, mLocationID, livesWith)
							VALUES(:defendantID, :relation, :firstName, :lastName, :homePhone, :workPhone, 
							:email, :employer, :pAddress, :mAddress, :pID, :mID, :livesWith)";
		}
		else // update existing guardian
		{
	    $sql = "UPDATE guardian SET defendantID = :defendantID, relation = :relation, firstName = :firstName, 
							lastName = :lastName, homePhone = :homePhone,	workPhone = :workPhone, email = :email,
							employer = :employer, pAddress = :pAddress, mAddress = :mAddress, pLocationID = :pID, 
							mLocationID = :mID, livesWith = :livesWith WHERE guardianID = :guardianID";
		}
    $stmt = $core->dbh->prepare($sql);
		if( $this->guardianID > 0 ) {	$stmt->bindParam(':guardianID', $this->guardianID);	}
		$stmt->bindParam(':defendantID', $this->defendantID);
		$stmt->bindParam(':relation', $this->relation);
		$stmt->bindParam(':firstName', $this->firstName);
		$stmt->bindParam(':lastName', $this->lastName);
		$stmt->bindParam(':homePhone', $this->homePhone);
		$stmt->bindParam(':workPhone', $this->workPhone);
		$stmt->bindParam(':employer', $this->employer);
		$stmt->bindParam(':email', $this->email);
		$stmt->bindParam(':pAddress', $this->pAddress);
		$stmt->bindParam(':mAddress', $this->mAddress);
		$stmt->bindParam(':pID', $this->pID);
		$stmt->bindParam(':mID', $this->mID);
		$stmt->bindParam(':livesWith', $this->livesWith);
    Core::dbClose();
		
		try {
			if($stmt->execute())
			{
				// if it's a new guardian, get the last insertId
				if( $this->guardianID == 0 )
					$this->guardianID = $core->dbh->lastInsertId(); 
					
				return true;
			}
			print_r( $stmt->errorInfo() );
		} 
		catch (PDOException $e) {
    	echo "Guardian update failed!";
    }
		return false;		
	}
	
//	private function removeGuardian();

	// setters
	public function setGuardianID( $str ) { $this->guardianID = $str; }
	public function setParentID( $str ) { $this->parentID = $str; }
	
	// getters
	public function getGuardianID() { return $this->guardianID; }
	public function getParentID() { return $this->parentID; }

}
