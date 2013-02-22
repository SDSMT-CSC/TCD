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
  }
  
  /*
   *  function: getFromLogin
   *   purpose: Checks the email and password the user entered at login
   *     with record in the database. If the email address exists, the
   *     password is checked with the current hash. If the hash is the
   *     same, proceed with user access and login.
   *  input: $email = email address user entered at login
   *         $password = password user entered at login
   *  output: boolean true/false
   */
  public function getFromLogin( $email, $password )
  {
    // values entered from the login form
    $this->email = $email;
    $this->password = $password;
    
    // database connection and sql query
    $core = Core::dbOpen();
    $sql = "SELECT userID, hash FROM user WHERE email = :email";
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
        $this->hash = $row["hash"];
        $this->lastLogin = $row["loginDate"];
        
        return true;
      }
    } catch ( PDOException $e ) {
      echo "Set User Information Failed!";
    }

    return false;
  }
  
  /* 
   *  function: checkHash
   *  purpose: checks a current hash against the algorithm to verify integrity
   *  input: $hash = 128 character hashed string
   *  output: boolean true/false
   */
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

  /* 
   *  function: newHash
   *  purpose: generate a new hash based on email and password
   *  input: none
   *  output: 128 character hash string
   */
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
  
  /*	function: updateUser
	 *	adds user data to the database
	 */
  public function updateUser()
  {
			// database connection and sql query
			$core = Core::dbOpen();
			
			if( $this->userID == 0 ) // add new user
			{
				$this->active = 0;
				$this->typeID = 5;
				$sql = "INSERT INTO user (programID,typeID,firstName,lastName,email,timezoneID,hash,active)
								VALUES (:programID, :typeID, :firstname, :lastname, :email, :timezoneID, :hash, :active)";
			}
			else
			{
				
			}
			
			
			$stmt = $core->dbh->prepare($sql);
			if( $this->userID > 0 ) { $stmt->bindParam(':userID', $id); }
			$stmt->bindParam(':programID',$this->programID);
			$stmt->bindParam(':typeID',$this->typeID);
			$stmt->bindParam(':firstname',$this->firstName);
			$stmt->bindParam(':lastname',$this->lastName);
			$stmt->bindParam(':email',$this->email);
			$stmt->bindParam(':timezoneID',$this->timezoneID);
			$stmt->bindParam(':hash',$this->newHash());
			$stmt->bindParam(':active',$this->active);
			Core::dbClose();
			
		try
    {
      
			if( $stmt->execute()) {
			  return true;
      }
			
			print_r($stmt->errorInfo());
			
    } catch ( PDOException $e ) {
      echo "Set User Information Failed!";
    }			
  }
	
	
  public function removeUser()
  {
    
  }
  
	/*	function: emailExists
	 *	checks the database to see if an email address exists for a user
	 */
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
        if( $stmt->rowCount() > 0 ) {				
        	return true;
				}

				return false;
      }
    } catch ( PDOException $e ) {
      echo "Search for email failed!";
    }
	}
	
	// getters
  public function getUserID() { return $this->userID; }
	public function getProgramID() { return $this->programID; }
  public function getType() { return $this->typeID; }
  public function getTimezone() { return $this->timezone; }
  public function getLastLogin() { return $this->lastLogin; }
	public function getEmail() { return $this->email; }
 
 	// setters
	public function setFirstName( $val ) {  $this->firstName = $val; }
	public function setLastName( $val ) {  $this->lastName = $val; }
  public function setEmail( $val ) {  $this->email = $val; }
  public function setPassword( $val ) {  $this->password = $val; }
  public function setProgramID( $val ) {  $this->programID = $val; }
  public function setTimezoneID( $val ) {  $this->timezoneID = $val; }
 
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
    echo "TimezoneID: " . $this->timezoneID . "<br>";
    echo "Timezone: " . $this->timezone;
    echo "</code>";
  }

}
?>