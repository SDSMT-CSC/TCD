<?php

class Citation {

	private $defendantID;
	private $statueID;
	private $officerID;
	public $citationDate;
	public $address;
	public $locationID;
	public $commonPlaceID;
	public $mirandized;
	public $drugsOrAlcohol;
		
	public function __construct( $defendantID )
	{
		$this->defendantID = $defendantID;
		$this->statueID = NULL;
		$this->officerID = NULL;
		$this->citationDate = NULL;
		$this->address = NULL;
		$this->locationID = NULL;
		$this->commonPlaceID = NULL;
		$this->mirandized = 0;
		$this->drugsOrAlcohol = 0;
	}
	
	public function updateOffense()
	{
		
	}
	
	public function removeOffense()
	{
		
	}
	
	public function addStolenItem()
	{
		
	}
	
	public function removeStolenItem()
	{
		
	}

	public function addVehicle()
	{
		
	}
	
	public function removeVehicle()
	{
		
	}
}

?>