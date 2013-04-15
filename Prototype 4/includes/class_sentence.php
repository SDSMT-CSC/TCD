<?php
class Sentence {
	private $sentenceID;
	private $defendantID;
	public $name;
	public $description;
	public $type;
	public $additional;
	public $completeDate;
	
	public function __construct( $defendantID )
	{
		$this->sentenceID = 0;
		$this->defendantID = $defendantID;
		$this->name = NULL;
		$this->description = NULL;
		$this->type = NULL;
		$this->additional = NULL;
		$this->completeDate = NULL;
	}
		
	/*************************************************************************************************
    function: addSentence
    purpose: Adds new sentence for defendant.
    input: $sentenceID = sentence to be added.
    output: defendant_sentenceID
  ************************************************************************************************/
	public function addSentence( $sentenceID )
	{	
		$core = Core::dbOpen();
		$sql = "INSERT INTO defendant_sentence (defendantID,sentenceID) VALUES (:defendantID,:sentenceID)";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':defendantID', $this->defendantID);
		$stmt->bindParam(':sentenceID', $sentenceID);
		Core::dbClose();
		
		try {
			if($stmt->execute())
				return true;
		} catch (PDOException $e) {
			echo "Sentence add failed!";
		}
		return false;
	}
	
	// setters
	public function setDefendantID( $var ) { $this->defendantID = $var; }
	
	// getters
	public function getDefendantID() { return $this->defendantID; }
	public function getSentenceID() { return $this->sentenceID; }
	
		
}

