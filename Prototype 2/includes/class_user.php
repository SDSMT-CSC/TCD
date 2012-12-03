<?php
class User {
	private $userID;
	private $firstName;
	private $lastName;
	
	public function __construct();
	
	private function getFromEmail();
	private function getFromID();
	private function addUser();
	private function updateUser();
	private function removeUser();
	public function userLoggedIn() {return $this->userID;}
	private function getLastLogin();
}
?>