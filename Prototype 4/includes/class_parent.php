<?php
class Guardian {

	private $defendantID;
	private $parentID;
	public $relation;
	public $firstName;
	public $lastName;
	public $homePhone;
	public $workPhone;
	public $employer;
	public $email;
	public $pID;
	public $physicalAddress;
	public $mID;
	public $mailingAddress;
	public $livesWith;
	
	public function __construct( $defendantID )
	{		
		$this->defendantID = $defendantID;
		$this->parentID = 0;
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
	
//	private function updateParent();
//	private function removeParent();
/*
	// setters
	public function setDefendantID( $str ) { $this->defendantID = $str; }
	public function setParentID( $str ) { $this->parentID = $str; }
	
	// getters
	public function getDefendantID() { return $this->defendantID; }
	public function getParentID() { return $this->parentID; }
*/
}
