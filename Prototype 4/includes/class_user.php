<?php
class User {
	
  private $userID;
  private $programID;
  private $typeID;
  private $firstName;
  private $lastName;
  private $email;
  private $password;
  private $lastLogin;
	private	$timezoneID;
	private	$timezone;
	private $active;
  
  // constructor for user object
  public function __construct()
  {
    $this->userID = 0;
    $this->programID = NULL;
    $this->typeID = NULL;
    $this->firstName = NULL;
    $this->lastName = NULL;
    $this->email = NULL;
    $this->password = NULL;
		$this->timezoneID = NULL;
		$this->timezone = NULL;
    $this->lastLogin = NULL;
		$this->active = 0;
  }
  
	/*************************************************************************************************
  	function: getFromLogin
    purpose: Checks the email and password the user entered at login
        with record in the database. If the email address exists, the
        password is checked with the current hash. If the hash is the
        same, proceed with user access and login.
    input: $email = email address user entered at login
           $password = password user entered at login
    output: boolean true/false
	*************************************************************************************************/
  public function getFromLogin( $email, $password )
  {
    // values entered from the login form
    $this->email = $email;
    $this->password = $password;
    
    // database connection and sql query
    $core = Core::dbOpen();
    $sql = "SELECT userID, hash FROM user WHERE email = :email AND active = 1";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':email', $email);
    Core::dbClose();
    
    try
    {
      // if record returned, check hash
      if ($stmt->execute()) {
        
        $row = $stmt->fetch();
        $userID = $row["userID"];
        $hash = $row["hash"];
      
        if( $this->checkHash($hash) == true )
        {
          // populate user data from id
          $this->getFromID($userID);
          
          // generate a new hash and update it in the database along with login time
          $core = Core::dbOpen();
          $sql = "UPDATE user SET hash = :hash, lastLogin = now() WHERE userID = :userID";
          $stmt = $core->dbh->prepare($sql);
          $stmt->bindParam(':hash', $this->newHash());
          $stmt->bindParam(':userID', $this->userID);
          $stmt->execute();
          Core::dbClose();
          
          return true;
        }
      }
    } catch (PDOException $e) {
      echo "User Authentication Failed!";
    }
    
    return false;
  }
  
	/*************************************************************************************************
		function: getFromID
		purpose: gets user information from a user id
    input: $id = user id
		output: boolean true/false
	*************************************************************************************************/
  public function getFromID( $id )
  {
    // database connection and sql query
    $core = Core::dbOpen();
    $sql = "SELECT u.*, tz.timezone FROM user u JOIN timezone tz ON u.timezoneID = tz.timezoneID WHERE u.userID = :userID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':userID', $id);
    Core::dbClose();
    
    try
    {
      if( $stmt->execute())
      {
        $row = $stmt->fetch();
        
        $this->userID = $id;
        $this->programID = $row["programID"];
        $this->typeID = $row["typeID"];
        $this->firstName = $row["firstName"];
        $this->lastName = $row["lastName"];
        $this->email = $row["email"];
        $this->timezone = $row["timezone"];
        $this->timezoneID = $row["timezoneID"];
        $this->hash = $row["hash"];
        $this->lastLogin = $row["loginDate"];
        $this->active = $row["active"];
        
        return true;
      }
    } catch ( PDOException $e ) {
      echo "Set User Information Failed!";
    }

    return false;
  }
  
	/*************************************************************************************************
     function: checkHash
     purpose: checks a current hash against the algorithm to verify integrity
     input: $hash = 128 character hashed string
     output: boolean true/false
	*************************************************************************************************/
  private function checkHash( $hash )
  {
    // The first 64 characters of the hash is the salt
    $salt = substr($hash, 0, 64);
    
    // create a new hash by append the password to the salt string
    $hashToCheck = $salt . $this->password;
    
    // Hash the password a bunch of times
    for ( $i = 0; $i < 100000; $i ++ ) {
      $hashToCheck = hash('sha256', $hashToCheck);
    }
    
    $hashToCheck = $salt . $hashToCheck;
    
    // check the local hash with the database hash
    if( $hash == $hashToCheck )
      return true;
    
    // return false if no match
    return false;
  }

	/*************************************************************************************************
     function: newHash
     purpose: generate a new hash based on email and password
     input: none
     output: 128 character hash string
	*************************************************************************************************/
  private function newHash()
  {
    $salt = hash('sha256', uniqid(mt_rand(), true) . 't33nh4sh' . strtolower($this->email));

    // Prefix the password with the salt
    $hash = $salt . $this->password;
    
    // Hash the salted password a bunch of times
    for ( $i = 0; $i < 100000; $i ++ ) {
      $hash = hash('sha256', $hash);
    }
    
    // Prefix the hash with the salt so we can find it back later
    $hash = $salt . $hash;
    
    return $hash;
  }
  
	/*************************************************************************************************
		function: updateUser
		purpose: adds the user if userid is 0, otherwise updates the user record
		input: none
  	output: boolean true/false
	*************************************************************************************************/
  public function updateUser()
  {		
			// database connection and sql query
			$core = Core::dbOpen();
			
			if( $this->userID == 0 ) // add new user
			{
				$sql = "INSERT INTO user (programID,typeID,firstName,lastName,email,timezoneID,hash,active)
								VALUES (:programID, :typeID, :firstname, :lastname, :email, :timezoneID, :hash, :active)";
			}
			else  // update existing record
			{
				$sql = "UPDATE user SET programID = :programID, typeID = :typeID, firstName = :firstname, 
								lastName = :lastname, email = :email, timezoneID = :timezoneID, active = :active ";

				 if( $this->password != "" ) { $sql .= ", hash = :hash "; }
				 
				$sql .= " WHERE userID = :userID";
			}
			
			$stmt = $core->dbh->prepare($sql);
			if( $this->userID > 0 ) { $stmt->bindParam(':userID', $this->userID); }
			if( $this->password != "" ) { $stmt->bindParam(':hash', $this->newHash() ); }
			$stmt->bindParam(':programID', $this->programID);
			$stmt->bindParam(':typeID', $this->typeID);
			$stmt->bindParam(':firstname', $this->firstName);
			$stmt->bindParam(':lastname', $this->lastName);
			$stmt->bindParam(':email', $this->email);
			$stmt->bindParam(':timezoneID', $this->timezoneID);
			$stmt->bindParam(':active', $this->active);
			Core::dbClose();
			
			try
			{			
				if( $stmt->execute()) {

					// if it's a new user, get the last insertId
					if( $this->userID == 0 )
						$this->userID = $core->dbh->lastInsertId(); 

					return true;
				}
				
			} catch ( PDOException $e ) {
				echo "Set User Information Failed!";
			}
			return false;
  }
	
	/*************************************************************************************************
		function: removeUser
		purpose: marks the user as deleted and inactive in the database,
						 doesn't actually remove the user
		input: $id = user id
    output: boolean true/false
	*************************************************************************************************/
  public function removeUser( $id )
  {
			// database connection and sql query
			$core = Core::dbOpen();
			$sql = "UPDATE user SET active = 0, deleted = 1 WHERE userid = :userid";
    	$stmt = $core->dbh->prepare($sql);
			$stmt->bindParam(':userid', $id);
			Core::dbClose();
			
			try
			{			
				if( $stmt->execute())
					return true;
			} catch ( PDOException $e ) {
				echo "Set User Information Failed!";
			}			
			return false;
  }
  
	/*************************************************************************************************
		function: emailExists
	 	purpose: checks the database to see if an email address exists for a user
		input: $email = email address to check
    output: boolean true/false
	*************************************************************************************************/
	public function emailExists( $email )
	{
		// database connection and sql query
    $core = Core::dbOpen();
    $sql = "SELECT userID FROM user WHERE email = :email";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':email', $email);
    Core::dbClose();
    
    try
    {
      if( $stmt->execute()) 
			{
        $row = $stmt->fetch();
        if( $stmt->rowCount() > 0 )
        	return true;
      }
    } catch ( PDOException $e ) {
      echo "Search for email failed!";
    }		
		return false;
	}
	
	/*************************************************************************************************
		function: fetchPhoneNumbers
	 	purpose: gets the users phone numbers
		input: none
    output: array of numbers or NULL if empty
	*************************************************************************************************/
	public function fetchPhoneNumbers()
	{
		// database connection and sql query
    $core = Core::dbOpen();
    $sql = "SELECT * FROM user_phone WHERE userID = :userID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':userID', $this->userID);
    Core::dbClose();
		
		try
    {
      if( $stmt->execute()) 
			{
				$ouput = array();
        while ($aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$row = array();
						$row["phoneID"] = $aRow["phoneID"];
						$row["phoneNum"] = $aRow["phoneNum"];
						$row["ext"] = $aRow["ext"];
						$row["type"] = $aRow["type"];
						$output[] = $row;
				}
				return $output;
      }
    } catch ( PDOException $e ) {
      echo "Fetch phone numbers failed!";
    }
		return NULL;
	}
	
	/*************************************************************************************************
		function: addPhone
		purpose: to add a phone number to the user
		intput: $type = the type of phone number cell, work, home, etc
						$number = the phone number
						$ext = extension if any
		output: boolean true/false
	*************************************************************************************************/
	public function addPhone( $type, $number, $ext )
	{
		// database connection and sql query
    $core = Core::dbOpen();
    $sql = "INSERT INTO user_phone (type, userID, phoneNum, ext ) VALUES ( :type, :userID, :number, :ext )";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':userID', $this->userID);
    $stmt->bindParam(':number', $number);
    $stmt->bindParam(':ext', $ext);
    Core::dbClose();

		try
    {
      if( $stmt->execute())
				return true;
		} catch ( PDOException $e ) {
      echo "Add phone number failed!";
    }
		return false;
	}
	
	/*************************************************************************************************
		function: removePhone
		purpose: to remove a phone number from the user
		input: $id = phone number ID
		output: boolean true/false
	*************************************************************************************************/
	public function removePhone( $id )
	{
		// database connection and sql query
    $core = Core::dbOpen();
    $sql = "DELETE FROM user_phone WHERE phoneID = :id";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':id', $id);
    Core::dbClose();

		try
    {			
      if( $stmt->execute())
				return true;
		} catch ( PDOException $e ) {
      echo "Remove phone number failed!";
    }
		return false;
	}
	
	/*************************************************************************************************
		function: addEvent
		purpose: logs a user action
		input: $id = user's id
		       $event = what the user did
		output: boolean true/false
	*************************************************************************************************/
	public function addEvent( $event )
	{
		// database connection and sql query
    $core = Core::dbOpen();
    $sql = "INSERT INTO user_log (userID, action, ip_address ) VALUES ( :userID, :event, :ip )";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':userID', $this->userID);
    $stmt->bindParam(':event', $event);
    $stmt->bindParam(':ip', $_SERVER['REMOTE_ADDR']);
    Core::dbClose();

		try
    {
      if( $stmt->execute())
				return true;
		} catch ( PDOException $e ) {
      echo "Add history event failed!";
    }
		return false;		
	}	
	
	/*************************************************************************************************
		function: fetchHistory
		purpose: gets a list of user's actions
		input: $id = userID
		output: boolean true/false
	*************************************************************************************************/
	public function fetchHistory( $id )
	{
		// database connection and sql query
    $core = Core::dbOpen();
    $sql = "SELECT UNIX_TIMESTAMP(date) as date, action, ip_address FROM user_log WHERE userID = :userID ORDER BY date";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':userID', $id);
    Core::dbClose();
				
		try
    {
      if( $stmt->execute() && $stmt->rowCount() > 0 ) 
			{
       while ($aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$row = array();						
						
						$row[] = date("n/j/y h:i a",$aRow["date"]);
						$row[] = $aRow["action"];
						$row[] = $aRow["ip_address"];	
								
						$output['aaData'][] = $row;
				}
				return json_encode($output);	
      }
    } catch ( PDOException $e ) {
      echo "Fetch user history failed!";
    }
		return '{"aaData":[]}';			
	}
		
	// getters
  public function getUserID() { return $this->userID; }
	public function getFirstName() {  return $this->firstName; }
	public function getLastName() {  return $this->lastName; }
  public function getName() { return $this->firstName . " " . $this->lastName; }
	public function getProgramID() { return $this->programID; }
  public function getType() { return $this->typeID; }
  public function getTimezone() { return $this->timezone; }
  public function getTimezoneID() { return $this->timezoneID; }
  public function getLastLogin() { return $this->lastLogin; }
	public function getEmail() { return $this->email; }
	public function isActive() { return $this->active; }
 
 	// setters
  public function setUserID( $val ) {  $this->userID = $val; }
  public function setProgramID( $val ) {  $this->programID = $val; }
  public function setType( $val ) {  $this->typeID = $val; }
	public function setFirstName( $val ) {  $this->firstName = $val; }
	public function setLastName( $val ) {  $this->lastName = $val; }
  public function setEmail( $val ) {  $this->email = $val; }
  public function setPassword( $val ) {  $this->password = $val; }
  public function setTimezoneID( $val ) {  $this->timezoneID = $val; }
	public function setActive( $val ) { $this->active = $val; }
 
  // for testing only
  public function display()
  {
    echo "<code>";
    echo "UserID: " . $this->userID . "<br>";
    echo "ProgramID: " . $this->programID . "<br>";
    echo "TypeID: " . $this->typeID . "<br>";
    echo "Firstname: " . $this->firstName . "<br>";
    echo "Lastname: " . $this->lastName . "<br>";
    echo "Email: " . $this->email . "<br>";
    echo "Password: " . $this->password . "<br>";
    echo "Active: " . $this->active . "<br>";
    echo "TimezoneID: " . $this->timezoneID . "<br>";
    echo "Timezone: " . $this->timezone;
    echo "</code>";
  }

}
?>