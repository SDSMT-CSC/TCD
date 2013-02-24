<?php

class Program {

	private $programID;
	private $code;
	private $name;
	private $phys_address;
	private $phys_city;
	private $phys_state;
	private $phys_zip;
	private $mail_address;
	private $mail_city;
	private $mail_state;
	private $mail_zip;
	private $phone;
	private $timezoneID;	

	public function __construct()
	{
			$this->programID = NULL;
			$this->code = NULL;
			$this->name = NULL;
			$this->phys_address = NULL;
			$this->phys_city = NULL;
			$this->phys_state = NULL;
			$this->phys_zip = NULL;
			$this->mail_address = NULL;
			$this->mail_city = NULL;
			$this->mail_state = NULL;
			$this->mail_zip = NULL;
			$this->phone = NULL;
			$this->timezoneID = NULL;	
	}	
	
	/*	function: emailExists
	 *	checks the database to see if an email address exists for a user
	 */
	public function programExists( $code )
	{
		// database connection and sql query
    $core = Core::dbOpen();
    $sql = "SELECT programID FROM program WHERE code = :code";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':code', $code);
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
      echo "Search for program failed!";
    }
	}

	public function getFromCode( $code )
	{
		// database connection and sql query
    $core = Core::dbOpen();
    $sql = "SELECT * FROM program WHERE code = :code";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':code', $code);
    Core::dbClose();
		 try
    {
      if( $stmt->execute()) 
			{
				 $row = $stmt->fetch();
				 
					$this->programID = $row["programID"];
					$this->code = $row["code"];
					$this->name = $row["name"];
					$this->phys_address = $row["PAddress"];
					$this->phys_city = $row["pCity"];
					$this->phys_state = $row["pState"];
					$this->phys_zip = $row["pZip"];
					$this->mail_address = $row["mAddress"];
					$this->mail_city = $row["mCity"];
					$this->mail_state = $row["mState"];
					$this->mail_zip = $row["mZip"];
					$this->timezoneID = $row["timezoneID"];	
			}
		} catch ( PDOException $e ) {
      echo "Get program by code failed!";
    }		
	}

	public function getFromID( $id )
	{
		// database connection and sql query
    $core = Core::dbOpen();
    $sql = "SELECT * FROM program WHERE programID = :id";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':id', $id);
    Core::dbClose();
		
	  try
    {
      if( $stmt->execute()) 
			{
				 $row = $stmt->fetch();
				 
					$this->programID = $row["programID"];
					$this->code = $row["code"];
					$this->name = $row["name"];
					$this->phys_address = $row["PAddress"];
					$this->phys_city = $row["pCity"];
					$this->phys_state = $row["pState"];
					$this->phys_zip = $row["pZip"];
					$this->mail_address = $row["mAddress"];
					$this->mail_city = $row["mCity"];
					$this->mail_state = $row["mState"];
					$this->mail_zip = $row["mZip"];
					$this->phone = $row["phone"];
					$this->timezoneID = $row["timezoneID"];	
			}
		} catch ( PDOException $e ) {
      echo "Get program by code failed!";
    }		
		
	}


	/*
	public function addCourt();

	public function updateCourt();

	public function removeCourt();

	public function printActivityReport();
	*/
	
	public function getProgramID() { return $this->programID; }
	public function getName() { return $this->name; }
	public function getPhone() { return $this->phone; }
	public function getTimezoneID() { return $this->timezoneID; }
	public function getAddress() { 
		$str = $this->phys_address . "<br>";
		if( $this->phys_city ) $str .= $this->phys_city . ", ";
		if( $this->phys_state ) { $str .= $this->phys_state . "  "; }
		if( $this->phys_zip ) { $str .= $this->phys_zip; }
		return $str;
	}
	
	
}

?>