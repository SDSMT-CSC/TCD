<?php
class Sentence {
	private $id;
	private $noPunishment;
	private $restitution;
	private $restitutionAmount;
	private $resitiutionDate;
	private $communityService;
	private $communityServiceHours;
	private $communityServiceDate;
	private $essay;
	private $essayLength;
	private $essayTitle;
	private $essayDate;
	private $apology;
	private $apologyLength;
	private $apologyTo;
	private $apologyDate;
	private $juryDuty;
	private $juryDutyAmount;
	private $juryDutyDate;
	private $sentenceCompletionDate;
	
	public function __construct();
	
	private function addSentence();
	private function editSentence();
	private function deleteSentence();
	private function printSentence();
}
