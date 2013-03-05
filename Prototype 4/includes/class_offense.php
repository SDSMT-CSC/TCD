<?php
class Offense {
	private $date;
	private $time;
	private $streetAddress;
	private $city;
	private $state;
	private $statute;
	private $title;
	private $type;
	private $vehicleLicense;
	private $vehicleState;
	private $vehicleMake;
	private $vehicleModel;
	private $officerName;
	private $officerID;
	private $mirandized;
	private $drugsOrAlcohol;
	private $itemsStolen;
	private $itemsVandalized;
	
	public function __construct();
	
	private function addOffense();
	private function updateOffense();
	private function removeOffense();
}
?>