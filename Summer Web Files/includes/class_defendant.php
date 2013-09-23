<?php

class Defendant {
	private $defendantID;
	private $programID;
	private $firstName;
	private $lastName;
	private $middleName;
	private $phoneNumber;
	private $dateOfBirth;
	private $courtFileNumber;
	private $agencyNumber;
	private $expungeDate;
	private $closeDate;
	public $pID;
	public $pAddress;
	public $pCity;
	public $pState;
	public $pZip;
	public $mID;
	public $mAddress;
	public $mCity;
	public $mState;
	public $mZip;
	public $schoolID;
	public $schoolContactName;
	public $schoolContactPhone;	
	public $schoolGrade;
	public $height;
	public $weight;
	public $eyecolor;
	public $haircolor;
	public $sex;
	public $ethnicity;
	public $licenseNum;
	public $licenseState;
	public $notes;
	public $intake;
	public $reschedule;
	public $inteviewer;
	public $referred;
	public $dismissed;
	public $added;
	
	public function __construct()
	{
		$this->defendantID = 0;
		$this->programID = NULL;
		$this->firstName = NULL;
		$this->lastName = NULL;
		$this->middleName = NULL;
		$this->phoneNumber = NULL;
		$this->dateOfBirth = NULL;
		$this->courtFileNumber = NULL;
		$this->agencyNumber = NULL;
		$this->expungeDate = NULL;
		$this->closeDate = NULL;
		$this->pID = 0;
		$this->pAddress = NULL;
		$this->pCity = NULL;
		$this->pState = NULL;
		$this->pZip = NULL;
		$this->mID = 0;
		$this->mAddress = NULL;
		$this->mCity = NULL;
		$this->mState = NULL;
		$this->mZip = NULL;
		$this->schoolID = 0;
		$this->schoolContactName = NULL;
		$this->schoolContactPhone = NULL;	
		$this->schoolGrade = NULL;
		$this->height = NULL;
		$this->weight = NULL;
		$this->eyecolor = NULL;
		$this->haircolor = NULL;
		$this->sex = NULL;
		$this->ethnicity = NULL;
		$this->licenseNum = NULL;
		$this->licenseState = NULL;
		$this->notes = NULL;
		$this->intake = NULL;
		$this->reschedule = NULL;
		$this->inteviewer = NULL;
		$this->referred = NULL;
		$this->dismissed = NULL;
		$this->added = NULL;
	}
	
	/*************************************************************************************************
		function: getFromID
		purpose: gets defendant information from a defendant id
    input: $id = defendant id
		output: boolean true/false
	*************************************************************************************************/
  public function getFromID( $id )
  {
    // database connection and sql query
    $sql = "SELECT d.*, UNIX_TIMESTAMP( added ) AS added, UNIX_TIMESTAMP( intake ) AS intake,
							 UNIX_TIMESTAMP( reschedule ) AS reschedule, UNIX_TIMESTAMP( referred ) AS referred, UNIX_TIMESTAMP( dismissed ) AS dismissed 
						FROM defendant d 
						LEFT JOIN intake_information i ON d.defendantID = i.defendantID
						WHERE d.defendantID = :defendantID";
    $core = Core::dbOpen();
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':defendantID', $id);
    Core::dbClose();
    
    try
    {
      if( $stmt->execute())
      {
        $row = $stmt->fetch();
        $this->defendantID = $id;
        $this->programID = $row["programID"];
        $this->firstName = $row["firstName"];
        $this->lastName = $row["lastName"];
				$this->middleName = $row["middleName"];
				$this->phoneNumber = $row["homePhone"];
				$this->dateOfBirth = $row["dob"];
				$this->courtFileNumber = $row["courtFileNumber"];
				$this->agencyNumber = $row["agencyCaseNumber"];
				$this->expungeDate = $row["expungeDate"];
				$this->closedate = $row["closedate"];
				$this->pID = $row["pLocationID"];
				$this->pAddress = $row["pAddress"];
				$this->mID = $row["mLocationID"];
				$this->mAddress = $row["mAddress"];
				$this->schoolID = $row["schoolID"];
				$this->schoolContactName = $row["schoolContactName"];
				$this->schoolContactPhone = $row["schoolContactPhone"];	
				$this->schoolGrade = $row["schoolGrade"];
				$this->height = $row["height"];
				$this->weight = $row["weight"];
				$this->eyecolor = $row["eyecolor"];
				$this->haircolor = $row["haircolor"];
				$this->sex = $row["sex"];
				$this->ethnicity = $row["ethnicity"];
				$this->licenseNum = $row["licenseNum"];
				$this->licenseState = $row["licenseState"];
				$this->notes = $row["notes"];
				$this->intake = $row["intake"];
				$this->reschedule = $row["reschedule"];
				$this->inteviewer = $row["inteviewer"];
				$this->referred = $row["referred"];
				$this->dismissed = $row["dismissed"];				
				$this->added = date("n/j/y h:i a", $row["added"]);
								
        return true;
      }
    } catch ( PDOException $e ) {
      echo "Set User Information Failed!";
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
    $sql = "SELECT programID FROM defendant WHERE defendantID = :defendantID AND programID = :programID";
    $core = Core::dbOpen();
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':defendantID', $id);
    $stmt->bindParam(':programID', $user_program);
    Core::dbClose();
    
    try
    {
			// if there is a record, they must be ok to access this defendant
      if( $stmt->execute() && $stmt->rowCount() > 0 )
          return true;
    } catch( PDOException $e ) {
      echo "ProgramID Compare Failed!";
    }
    return false;
  }
	
	/*************************************************************************************************
		function: updateDefendant
		purpose: adds the defendant if userid is 0, otherwise updates the defendant record
		input: none
  	output: boolean true/false
	*************************************************************************************************/
  public function updateDefendant()
  {
		// add new defendant or update existing record
		if( $this->defendantID == 0 ) {
			$sql = "INSERT INTO defendant (programID, firstName, lastName, middleName, homePhone, dob, courtFileNumber, agencyCaseNumber)
							VALUES (:programID, :firstname, :lastname, :middlename, :homePhone, :dob, :courtFileNumber, :agencyCaseNumber)";
		} else {
		  //make no changes if defendant is expunged
		  if( $this->checkIfExpunged() ) {
		    return false;
		  }
			$sql = "UPDATE defendant SET programID = :programID, firstName = :firstname, lastName = :lastname, middleName = :middlename,
							homePhone = :homePhone, dob = :dob, courtFileNumber = :courtFileNumber, agencyCaseNumber = :agencyCaseNumber
							WHERE defendantID = :defendantID";
		}
		
		// database connection and sql query			
		$core = Core::dbOpen();
		$stmt = $core->dbh->prepare($sql);
		if( $this->defendantID > 0 ) { $stmt->bindParam(':defendantID', $this->defendantID); }
		$stmt->bindParam(':programID', $this->programID);
		$stmt->bindParam(':firstname', $this->firstName);
		$stmt->bindParam(':lastname', $this->lastName);
		$stmt->bindParam(':middlename', $this->middleName);
		$stmt->bindParam(':homePhone', $this->phoneNumber);
		$stmt->bindParam(':dob', $this->dateOfBirth);
		$stmt->bindParam(':courtFileNumber', $this->courtFileNumber);
		$stmt->bindParam(':agencyCaseNumber', $this->agencyNumber);
		Core::dbClose();
		
		try
		{
			if( $stmt->execute()) {
				// if it's a new defendant, get the last insertId
				if( $this->defendantID == 0 )
					$this->defendantID = $core->dbh->lastInsertId(); 
				return true;
			}
		} catch ( PDOException $e ) {
			echo "Set Defendant Information Failed!";
		}
		return false;
  }
	
	/*************************************************************************************************
		function: updatePersonal
		purpose: updates the defendant's personal information. this is done after initially adding
			a defendant to the database or when editing one
		input: none
  	output: boolean true/false
	*************************************************************************************************/
  public function updatePersonal()
	{
	  //make no changes if defendant is expunged
	  if( $this->checkIfExpunged() ) {
      return false;
    }
		// database connection and sql query
		$sql = "UPDATE defendant SET pAddress	= :pAddress, pLocationID = :pID, mAddress = :mAddress,	
					  mLocationID	= :mID, schoolID	= :schoolID, schoolContactName	= :schoolContactName, 
						schoolContactPhone	= :schoolContactPhone, schoolGrade	= :schoolGrade, height	= :height, 
						weight	= :weight, eyecolor	= :eyecolor, haircolor	= :haircolor, sex	= :sex, ethnicity	= :ethnicity, 
						licenseNum	= :licenseNum, licenseState = :licenseState	
						WHERE defendantID = :defendantID";
		$core = Core::dbOpen();
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':defendantID', $this->defendantID);
		$stmt->bindParam(':pID', $this->pID);
		$stmt->bindParam(':pAddress', $this->pAddress);
		$stmt->bindParam(':mID', $this->mID);
		$stmt->bindParam(':mAddress', $this->mAddress);
		$stmt->bindParam(':schoolID', $this->schoolID);
		$stmt->bindParam(':schoolContactName', $this->schoolContactName);
		$stmt->bindParam(':schoolContactPhone', $this->schoolContactPhone);
		$stmt->bindParam(':schoolGrade', $this->schoolGrade);
		$stmt->bindParam(':height', $this->height);
		$stmt->bindParam(':weight', $this->weight);
		$stmt->bindParam(':eyecolor', $this->eyecolor);
		$stmt->bindParam(':haircolor', $this->haircolor);
		$stmt->bindParam(':sex', $this->sex);
		$stmt->bindParam(':ethnicity', $this->ethnicity);
		$stmt->bindParam(':licenseNum', $this->licenseNum);
		$stmt->bindParam(':licenseState', $this->licenseState);
		Core::dbClose();
		
		try
			{
				if( $stmt->execute())
					return true;
		} catch ( PDOException $e ) {
			echo "Update defendant personal information failed!";
		}
		return false;
	}
	
	/*************************************************************************************************
		function: updateIntake
		purpose: updates the defendant’s intake information. This is done after initially adding a defendant to the database
		input: $intake = date and time of intake interview
	 		   $reschedule = date and time of rescheduled interview
	 		   $interview = ID of person conducting interview
	 		   $referred = date and time of when defendant was referred to juvenile system
	 		   $dismissed = date and time of when defendant was dismissed from Teen Court system
  	output: boolean true/false
	*************************************************************************************************/
	public function updateIntake( $intake, $reschedule, $inteviewer, $referred, $dismissed )
	{
	  //make no changes if defendant is expunged
    if( $this->checkIfExpunged() ) {
      return false;
    }
    		
		// database connection and sql query
    $core = Core::dbOpen();
		
		// if options checked, set to timestamp	otherwise leave them as current or if toggled set to null
		$timestamp = date( 'Y-m-d H:i:s', time() );	// current time

		if( $referred == 'on' && $this->referred ) { // checked, class set - stays the same
			$referred = $core->convertToServerDate( date( 'Y-m-d H:i:s', $this->referred ), $_SESSION["timezone"] );  // set to class time
		}
		else if ( $referred == 'on' && !$this->referred ) { // checked, class not set - update
			$referred = $core->convertToServerDate( $timestamp, $_SESSION["timezone"] );   // set to current time
		}
	  else { // toggled off - set to null
			$referred = NULL;			
		}
		
		if( $dismissed == 'on' && $this->referred ) {  // checked, class set - stays the same
			$dismissed = $core->convertToServerDate( date( 'Y-m-d H:i:s', $this->referred ), $_SESSION["timezone"] );  // set to class time
		}
		else if ( $dismissed == 'on' && !$this->referred ) { // checked, class not set - update
			$dismissed = $core->convertToServerDate( $timestamp, $_SESSION["timezone"] );   // set to current time
		}
	  else { // toggled off - set to null
			$dismissed = NULL;			
		}

		// if rescheduled is set, adjust time
		if( $reschedule ) { $reschedule = $core->convertToServerDate( $reschedule, $_SESSION["timezone"] ); }
		
		// update if existing, otherwise insert it
		if( !$this->intake ) {
			$sql = "INSERT INTO intake_information (defendantID, intake, reschedule, inteviewer, referred, dismissed) 
							VALUES(:defendantID, :intake, :reschedule, :inteviewer, :referred, :dismissed)";
		}	else {
			$sql = "UPDATE intake_information SET intake = :intake, reschedule = :reschedule, inteviewer = :inteviewer, 
							referred = :referred, dismissed = :dismissed WHERE defendantID = :defendantID";			
		}

		$stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':defendantID', $this->defendantID);
    $stmt->bindParam(':intake', $core->convertToServerDate( $intake, $_SESSION["timezone"] ) );
    $stmt->bindParam(':reschedule',  $reschedule );
    $stmt->bindParam(':inteviewer', $inteviewer );
    $stmt->bindParam(':referred', $referred );
    $stmt->bindParam(':dismissed', $dismissed );
    Core::dbClose();
		
		try {
			if( $stmt->execute() )
				return true;
		} 
		catch (PDOException $e) {
      		echo "Program intake update Failed!";
    }
		return false;
	}
	
	/*************************************************************************************************
		function: getGuardianList
		purpose: returns an array of guardianIDs for the defendant
		input: none
  		output: array of guardian IDs
	*************************************************************************************************/
	public function getGuardianList()
	{
		$output = array();
		
		 // database connection and sql query
    $sql = "SELECT guardianID FROM guardian WHERE defendantID = :defendantID";
    $core = Core::dbOpen();
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':defendantID', $this->defendantID);
    Core::dbClose();
		
		try {
			if($stmt->execute() && $stmt->rowCount() > 0)
				while ($aRow = $stmt->fetch(PDO::FETCH_ASSOC))
						$output[] = $aRow["guardianID"];
		} 
		catch (PDOException $e) {
      		echo "Program guardian read Failed!";
    }
		return $output;
	}
	
	/*************************************************************************************************
		function: totalGuardians
		purpose: returns a count of guardians for the defendant
		input: none
  		output: int count of guardians
	*************************************************************************************************/
	public function totalGuardians()
	{
		$count = 0;
		
		 // database connection and sql query
    $core = Core::dbOpen();
    $sql = "SELECT COUNT(guardianID) FROM guardian WHERE defendantID = :defendantID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':defendantID', $this->defendantID);
    Core::dbClose();
		
		try {
			if( $stmt->execute() )
				$count = $stmt->rowCount();
		} 
		catch (PDOException $e) {
      		echo "Program School Read Failed!";
    }
		return $count;
	}
	
	/*************************************************************************************************
		function: checkWorkshop
		purpose: returns if the defendant is in a workshop and if they have completed it
		input: none
  	output: array of workshops and completion times
	*************************************************************************************************/
	public function checkWorkshop()
	{
		$output = array();
		
		// database connection and sql query
    $core = Core::dbOpen();
    $sql = "SELECT workshopID, UNIX_TIMESTAMP( completed ) as completed FROM workshop_roster WHERE defendantID = :defendantID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':defendantID', $this->defendantID);
    Core::dbClose();
		
		try {
			if( $stmt->execute() && $stmt->rowCount() > 0 )
			{
				while ($aRow = $stmt->fetch(PDO::FETCH_ASSOC))
				{
					$row = array();
					$row["workshopID"] = $aRow["workshopID"];
					$row["completed"] = ( $aRow["completed"] ) ?  date("n/j/y h:i a", $aRow["completed"] ) : NULL;
					$output[] = $row;				
				}
			}
		} 
		catch (PDOException $e) {
      		echo "Workshop check failed!";
    }
		return $output;
	}

	/*************************************************************************************************
		function: checkCourt
		purpose: returns if the defendant has been assigned to a court and if they have completed it
		input: none
  	output: courtID if exists
	*************************************************************************************************/
	public function checkCourt()
	{
		$courtID = array();
		
		// database connection and sql query
    $core = Core::dbOpen();
    $sql = "SELECT court_caseID FROM court_case WHERE defendantID = :defendantID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':defendantID', $this->defendantID);
    Core::dbClose();
		
		try {
			if( $stmt->execute() && $stmt->rowCount() > 0 )
			{
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
				  $courtID[] = $row;
			}
		} 
		catch (PDOException $e) {
      		echo "Court check failed!";
    }
		return $courtID;
	}
	
	/*************************************************************************************************
		function: checkJury
		purpose: returns if the defendant has been assigned to any courts as a jury member and hours
						 assigned so far
		input: none
  	output: array of courts and hours as jury member
	*************************************************************************************************/
	public function checkJury()
	{
		$output = array();
		
		// database connection and sql query
    $core = Core::dbOpen();
    $sql = "SELECT cjd.hours, cjd.courtID, UNIX_TIMESTAMP( c.date ) as date, UNIX_TIMESTAMP( c.closed) as closed, courtLocationID, timeEntered
						FROM court_jury_defendant cjd, court c
						WHERE cjd.defendantID = :defendantID AND cjd.courtID = c.courtID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':defendantID', $this->defendantID);
    Core::dbClose();
		
		try {
			if( $stmt->execute() && $stmt->rowCount() > 0 )
			{
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
					$output[] = $row;
			}
		} 
		catch (PDOException $e) {
      		echo "Jury check failed!";
    }
		return $output;
	}
	
	/*************************************************************************************************
		function: checkSentence
		purpose: returns list of sentences that have been assigned to the defendant
		input: none
  	output: array of sentence options and information
	*************************************************************************************************/
	public function checkSentence()
	{
		$output = array();
		
		// database connection and sql query
    $core = Core::dbOpen();
    $sql = "SELECT defsentID FROM defendant_sentence WHERE defendantID = :defendantID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':defendantID', $this->defendantID);
    Core::dbClose();
		
		try {
			if( $stmt->execute() && $stmt->rowCount() > 0 )
			{
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
					$output[] = $row;
			}
		} 
		catch (PDOException $e) {
      		echo "Sentence check failed!";
    }
		return $output;
	}
	
	/*************************************************************************************************
		function: updateNotes
		purpose: updates defendant notes
		input: none
  	output: none
	*************************************************************************************************/
	public function updateNotes()
	{
	  //make no changes if defendant is expunged
    if( $this->checkIfExpunged() ) {
      return false;
    }
    
		// database connection and sql query
    $core = Core::dbOpen();
    $sql = "UPDATE defendant SET notes = :notes WHERE defendantID = :defendantID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':defendantID', $this->defendantID);
    $stmt->bindParam(':notes', $this->notes);
    Core::dbClose();
		
		try {
			$stmt->execute();
		} 
		catch (PDOException $e) {
      		echo "Program Update Notes Failed!";
    }
	}
  
  /*************************************************************************************************
   function: deleteDefendant
   purpose: delete a defendant from the program
   input: None
   output: Boolean true/false
  *************************************************************************************************/
  public function deleteDefendant()
  {
    $core = Core::dbOpen();
    $citationID;
    $court_caseID;
    $sql = "SELECT citationID FROM citation
            WHERE defendantID = :defendantID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':defendantID', $this->defendantID);
    
    try {
      if( $stmt->execute() ) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $citationID = $row["citationID"];
      }
    } catch (PDOException $e) {
      return false;
    }
    
    $sql = "SELECT court_caseID FROM court_case
            WHERE defendantID = :defendantID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':defendantID', $this->defendantID);
    
    try {
      if( $stmt->execute() ) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $court_caseID = $row["court_caseID"];
      }
    } catch (PDOException $e) {
      return false;
    }
    
    $sql = "DELETE FROM citation WHERE defendantID = :defendantID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':defendantID', $this->defendantID);
    $stmt->execute();
  
    $sql = "DELETE FROM citation_offense WHERE defendantID = :defendantID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':defendantID', $this->defendantID);
    $stmt->execute();
   
    if( $citationID != NULL) {
      $sql = "DELETE FROM citation_stolen_items WHERE citationID = :citationID";
      $stmt = $core->dbh->prepare($sql);
      $stmt->bindParam(':citationID', $citationID);
      $stmt->execute();
    
      $sql = "DELETE FROM citation_vehicle WHERE citationID = :citationID";
      $stmt = $core->dbh->prepare($sql);
      $stmt->bindParam(':citationID', $citationID);
      $stmt->execute();
    }
  
    $sql = "DELETE FROM court_case WHERE defendantID = :defendantID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':defendantID', $this->defendantID);
    $stmt->execute();
   
    $sql = "DELETE FROM court_jury_defendant WHERE defendantID = :defendantID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':defendantID', $this->defendantID);
    $stmt->execute();
   
    if( $court_caseID != NULL) {
      $sql = "DELETE FROM court_jury_defendant WHERE court_caseID = :court_caseID";
      $stmt = $core->dbh->prepare($sql);
      $stmt->bindParam(':court_caseID', $court_caseID);
      $stmt->execute();
    
      $sql = "DELETE FROM court_jury_volunteer WHERE court_caseID = :court_caseID";
      $stmt = $core->dbh->prepare($sql);
      $stmt->bindParam(':court_caseID', $court_caseID);
      $stmt->execute();
     
      $sql = "DELETE FROM court_member WHERE court_caseID = :court_caseID";
      $stmt = $core->dbh->prepare($sql);
      $stmt->bindParam(':court_caseID', $court_case);
      $stmt->execute();
    }
  
    $sql = "DELETE FROM defendant_sentence WHERE defendantID = :defendantID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':defendantID', $this->defendantID);
    $stmt->execute();
   
    $sql = "DELETE FROM guardian WHERE defendantID = :defendantID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':defendantID', $this->defendantID);
    $stmt->execute();
    
    $sql = "DELETE FROM intake_information WHERE defendantID = :defendantID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':defendantID', $this->defendantID);
    $stmt->execute();
    
    $sql = "DELETE FROM workshop_roster WHERE defendantID = :defendantID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':defendantID', $this->defendantID);
    $stmt->execute();
 
    $sql = "DELETE FROM defendant WHERE defendantID = :defendantID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':defendantID', $this->defendantID);
    $stmt->execute();
    
    Core::dbClose();
    
    return true;
  }
  
  /*************************************************************************************************
   function: expungeDefendant
   purpose: expunge a defendant from the program based on program's expunge level
   input: $programExpunge = Expunge level of the program
   output: Boolean true/false
   * NOTE: 0 = No Expunge
           1 = Full Expunge
           2 = Partial Expunge
           3 = Sealed
  *************************************************************************************************/
  public function expungeDefendant( $programExpunge )
  {
    $empty = NULL;
    $core = Core::dbOpen();
    //remove information from defendant if needed
    if( $programExpunge == 1 ) {        //full expunge, delete from system
      $this->deleteDefendant();
      return true;
    }
    if( $programExpunge == 2 ) {      //partial expunge, remove identifying information
      $sql = "UPDATE defendant SET firstName = :firstName, lastName = :lastName,
              middleName = :middleName, homePhone = :homePhone, 
              pAddress = :pAddress, mAddress = :mAddress, licenseNum = :licenseNum
              WHERE defendantID = :defendantID";
      $stmt = $core->dbh->prepare($sql);
      $stmt->bindParam(':firstName', $empty);
      $stmt->bindParam(':lastName', $empty);
      $stmt->bindParam(':middleName', $empty);
      $stmt->bindParam(':homePhone', $empty);
      $stmt->bindParam(':dob', $empty);
      $stmt->bindParam(':pAddress', $empty);
      $stmt->bindParam(':mAddress', $empty);
      $stmt->bindParam(':licenseNum', $empty);
      $stmt->bindParam(':defendantID', $this->defendantID);
      $stmt->execute();
      
      $sql = "DELETE FROM guardian WHERE defendantID = :defendantID";
      $stmt = $core->dbh->prepare($sql);
      $stmt->bindParam(':defendantID', $this->defendantID);
      $stmt->execute();
    }
    //set date for both partial and seal
    $sql = "UPDATE defendant SET expungeDate = :expungeDate WHERE defendantID = :defendantID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':expungeDate', $core->convertToServerDate( date("m/d/y h:i A"), $_SESSION["timezone"] ));
    $stmt->bindParam(':defendantID', $this->defendantID);
    $stmt->execute();
    
    Core::dbClose();
    return true;
  }
  
  public function checkIfExpunged()
  {
    $core = Core::dbOpen();
    $sql = "SELECT expungeDate IS NULL FROM defendant WHERE defendantID = :defendantID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':defendantID', $this->defendantID);
    try {
      if( $stmt->execute() ) {
        $row = $stmt->fetch();
        if( $row == 0 )
          return true;
        else
          return false;
      }
    } catch(PDOException $e) {
      return false;
    }
  }
	
	// setters
	public function setDefendantID( $str ) { $this->defendantID = $str; }
	public function setProgramID( $str ) { $this->programID = $str; }
	public function setFirstName( $str ) { $this->firstName = $str; }
	public function setLastName( $str ) { $this->lastName = $str; }
	public function setMiddleName( $str ) { $this->middleName = $str; }
	public function setPhoneNumber( $str ) { $this->phoneNumber = $str; }
	public function setDateOfBirth( $str ) { $this->dateOfBirth = $str; }
	public function setcourtFileNumber( $str ) { $this->courtFileNumber = $str; }
	public function setAgencyNumber( $str ) { $this->agencyNumber = $str; }
	
	// getters
	public function getDefendantID() { return $this->defendantID; }
	public function getProgramID() { return $this->programID; }
	public function getFirstName() { return $this->firstName; }
	public function getLastName() { return $this->lastName; }	
	public function getMiddleName() { return $this->middleName; }
	public function getPhoneNumber() { return $this->phoneNumber; }
	public function getDateOfBirth() { return $this->dateOfBirth; }
	public function getcourtFileNumber() { return $this->courtFileNumber; }
	public function getAgencyNumber() { return $this->agencyNumber; }
	
	public function getExpungeDate()
	{
		if( $this->expungeDate == NULL )
			return "N/A";
		else
			return $this->expungeDate;
	}
	
	public function getCloseDate()
	{
		if( $this->closeDate == NULL )
			return "N/A";
		else
			return $this->closeDate;
	}


}
?>