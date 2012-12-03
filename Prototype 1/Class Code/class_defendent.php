<?php
class Defendent {
	private $firstName;	private $lastName;	private $middleInitial;	private $citationNumber;	private $citationDate;	private $citationTime;	private $phoneNumber;	private $dateOfBirth;	private $courtCaseNumber;	private $agencyNumber;	private $streetAddress;	private $mailingAddress;	private $city;	private $state;	private $zipCode;	private $intakeDate;	private $intakeTime;	private $intakeInterviewer;	private $intakeRefertoJuvenile;	private $intakeDismissed;
	public function __construct();		private function assignCourt();	private function expungeFull();	private function expungePartial();	private function expungeSeal();	private function printDocket();
}
?>