<?php

class Court {

	private $programID;
	private $courtID;
	public $date;
	public $type;
	public $locationID;
	public $contractSigned;
	
	public function __construct( $programID )
	{
		$this->programID = $programID;
		$this->courtID = 0;
		$this->date = NULL;
		$this->type = NULL;
		$this->locationID = NULL;
		$this->contractSigned = NULL;
	}
	
	public function updateCourt()
	{
			
			
			
			
			
	}



}

?>