<?php
class Workshop {
	private $id;
	private $date;
	private $time;
	private $title;
	private $information;
	private $instructor;
	private $officer;
	private $attendees;
	
	public function __construct();
	
	private function setWorkshop();
	private function editWorkshop();
	private function deleteWorkshop();
	private function printWorkshopInformation();
}
?>