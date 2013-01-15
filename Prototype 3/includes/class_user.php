<?php
class User {
	private $userID;
	private $programID;
	private $firstName;
	private $lastName;
	private $email;
	private $password;
	private $hash;
	
	public function __construct()
	{
		
	}
	
	public function getFromLogin( $email, $password )
	{
		$this->email = $email;
		$this->password = $password;
		
		// lookup user in database
		

	}

	private function newHash()
	{
		$salt = hash('sha256', uniqid(mt_rand(), true) . 't33nh4sh' . strtolower($username));

		// Prefix the password with the salt
		$hash = $salt . $password;
		
		// Hash the salted password a bunch of times
		for ( $i = 0; $i < 100000; $i ++ ) {
		  $hash = hash('sha256', $hash);
		}
		
		// Prefix the hash with the salt so we can find it back later
		$hash = $salt . $hash;
	}
	
	public function getFromID($id)
	{
		
	}
	
	public function addUser()
	{
		
	}
	
	public function updateUser()
	{
		
	}
	
	public function removeUser()
	{
		
	}
	
	public function userLoggedIn() { return $this->userID; }
	public function getLastLogin() { return $this->lastlogin; }
	
	public function display()
	{
		echo "<code>";
		echo "UserID: " . $this->userID . "<br>";
		echo "ProgramID: " . $this->programID . "<br>";
		echo "Firstname: " . $this->firstName . "<br>";
		echo "Lastname: " . $this->lastName . "<br>";
		echo "Email: " . $this->email . "<br>";
		echo "Hash: " . $this->hash . "<br>";	
		echo "</code>";
	}
	
}
?>