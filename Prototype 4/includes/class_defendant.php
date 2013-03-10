<?php

class Defendant {
	private $defendantID;
	private $programID;
	private $firstName;
	private $lastName;
	private $middleName;
	private $phoneNumber;
	private $dateOfBirth;
	private $courtCaseNumber;
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
		$this->courtCaseNumber = NULL;
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
    $core = Core::dbOpen();
    $sql = "SELECT d.*, UNIX_TIMESTAMP(added) as added FROM defendant d WHERE d.defendantID = :defendantID";
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
				$this->courtCaseNumber = $row["courtCaseNumber"];
				$this->agencyCaseNumber = $row["agencyCaseNumber"];
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
				$this->added = date("n/j/y h:i a", $row["added"]);
        return true;
      }
    } catch ( PDOException $e ) {
      echo "Set User Information Failed!";
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
			// database connection and sql query
			$core = Core::dbOpen();
			
			if( $this->defendantID == 0 ) // add new defendant
			{
				$sql = "INSERT INTO defendant (programID, firstName, lastName, middleName, homePhone, dob, courtCaseNumber, agencyCaseNumber)
								VALUES (:programID, :firstname, :lastname, :middlename, :homePhone, :dob, :courtCaseNumber, :agencyCaseNumber)";
			}
			else  // update existing record
			{
				$sql = "UPDATE defendant SET programID = :programID, firstName = :firstname, lastName = :lastname, middleName = :middlename,
								homePhone = :homePhone, dob = :dob, courtCaseNumber = :courtCaseNumber, agencyCaseNumber = :agencyCaseNumber
								WHERE defendantID = :defendantID";
			}
			
			$stmt = $core->dbh->prepare($sql);
			if( $this->defendantID > 0 ) { $stmt->bindParam(':defendantID', $this->defendantID); }
			$stmt->bindParam(':programID', $this->programID);
			$stmt->bindParam(':firstname', $this->firstName);
			$stmt->bindParam(':lastname', $this->lastName);
			$stmt->bindParam(':middlename', $this->middleName);
			$stmt->bindParam(':homePhone', $this->phoneNumber);
			$stmt->bindParam(':dob', $this->dateOfBirth);
			$stmt->bindParam(':courtCaseNumber', $this->courtCaseNumber);
			$stmt->bindParam(':agencyCaseNumber', $this->agencyCaseNumber);
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
		// database connection and sql query
		$core = Core::dbOpen();
		$sql = "UPDATE defendant SET pAddress	= :pAddress, pLocationID = :pID, mAddress = :mAddress,	
					  mLocationID	= :mID, schoolID	= :schoolID, schoolContactName	= :schoolContactName, 
						schoolContactPhone	= :schoolContactPhone, schoolGrade	= :schoolGrade, height	= :height, 
						weight	= :weight, eyecolor	= :eyecolor, haircolor	= :haircolor, sex	= :sex, ethnicity	= :ethnicity, 
						licenseNum	= :licenseNum, licenseState = :licenseState	
						WHERE defendantID = :defendantID";
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
			echo "Update Defendant Personal Failed!";
		}
		return false;
	}
	
	// setters
	public function setDefendantID( $str ) { $this->defendantID = $str; }
	public function setProgramID( $str ) { $this->programID = $str; }
	public function setFirstName( $str ) { $this->firstName = $str; }
	public function setLastName( $str ) { $this->lastName = $str; }
	public function setMiddleName( $str ) { $this->middleName = $str; }
	public function setPhoneNumber( $str ) { $this->phoneNumber = $str; }
	public function setDateOfBirth( $str ) { $this->dateOfBirth = $str; }
	public function setCourtCaseNumber( $str ) { $this->courtCaseNumber = $str; }
	public function setAgencyNumber( $str ) { $this->agencyNumber = $str; }
	
	// getters
	public function getDefendantID() { return $this->defendantID; }
	public function getFirstName() { return $this->firstName; }
	public function getLastName() { return $this->lastName; }	
	public function getMiddleName() { return $this->middleName; }
	public function getPhoneNumber() { return $this->phoneNumber; }
	public function getDateOfBirth() { return $this->dateOfBirth; }
	public function getCourtCaseNumber() { return $this->courtCaseNumber; }
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