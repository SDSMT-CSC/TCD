<?php
class Core {
	// database connection info
	private $db_host = 'localhost';
	private $db_name = 'teencour_data';
	private $db_user = 'teencour_web';
	private $db_password = 't33nc0urtw3b12';

	// database handler
  public $dbh;
  private static $instance;

  /*************************************************************************************************
    function: __construct
    purpose: build PDO object for database access
    input: none
    output: construct core object
  ************************************************************************************************/
  private function __construct() {
    	// building data source name
    	$dsn = 'mysql:host=' . $this->db_host . ';dbname=' . $this->db_name;
		// open the database
		try {
			$this->dbh = new PDO($dsn, $this->db_user, $this->db_password);
		} catch (PDOException $e) {
			print "Error: " . $e->getMessage() . "<br>";
			die();
		}
	}
  
  /*************************************************************************************************
    function: dbOpen
    purpose: create an instance to open db communication
    input: none
    output: instance object
    ************************************************************************************************/
  public static function dbOpen() {
        if (!isset(self::$instance)) {
          $object = __CLASS__;
        	self::$instance = new $object;
        }
    	return self::$instance;
    }

  /*************************************************************************************************
    function: dbClose
    purpose: close the db communication
    input: none
    output: none
    ************************************************************************************************/
  public static function dbClose() {
		if (!isset(self::$instance)) {
			$this->dbh = null;
		}
	}
	
  /*************************************************************************************************
    function: convertToServerDate
    purpose: convert from the users timezone to central time (where server is located)
    input: $originalTS = timestamp to convert
           $userTimeZone = user's timezone
    output: timestamp converted to server timezone
    ************************************************************************************************/
	public function convertToServerDate( $originalTS, $userTimeZone )
	{
		$sqlDate = new DateTime( $originalTS, new DateTimeZone($userTimeZone) );
		$sqlDate->setTimezone(new DateTimeZone('America/Chicago'));
		return $sqlDate->format('Y-m-d H:i:s');
	}	
}

?>