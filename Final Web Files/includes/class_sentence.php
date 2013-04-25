<?php
class Sentence {
	private $defsentID;
	private $sentenceID;
	private $defendantID;
	public $name;
	public $description;
	public $value;
	public $additional;
	public $additionalValue;
	public $completeDate;
	
	public function __construct( $defendantID )
	{
		$this->defsentID = 0;
		$this->sentenceID = 0;
		$this->defendantID = $defendantID;
		$this->name = NULL;
		$this->description = NULL;
		$this->value = NULL;
		$this->additional = NULL;
		$this->additionalValue = NULL;
		$this->completeDate = NULL;
	}
		
	private function addSentenceFunction( $defendantID, $sentenceID )
	{
		$core = Core::dbOpen();
		$sql = "INSERT INTO defendant_sentence (defendantID,sentenceID) VALUES (:defendantID,:sentenceID)";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':defendantID', $defendantID);
		$stmt->bindParam(':sentenceID', $sentenceID);
		Core::dbClose();
		try {
			if(!$stmt->execute())
				return false;
		} catch (PDOException $e) {
			echo "Sentence add failed!";
		}		
		return true;		
	}
		
	/*************************************************************************************************
    function: addSentence
    purpose: Adds new sentence for defendant.
    input: $sentenceID = sentence to be added.
    output: defendant_sentenceID
  ************************************************************************************************/
	public function addSentence( $sentences )
	{	
		if( is_array( $sentences ) ) {
			foreach( $sentences as $sentenceID ) {
					$this->addSentenceFunction( $this->defendantID, $sentenceID );
			}
		}
		else {
			$this->addSentenceFunction( $this->defendantID, $sentences );		
		}
	}
	
	/*************************************************************************************************
    function: getFromID
    purpose: gets sentence information
    input: $defsentID = sentence/defendant unique id.
    output: boolean true/false
  ************************************************************************************************/
	public function getFromID( $defsentID )
	{	
		$core = Core::dbOpen();
		$sql = "SELECT ds.sentenceID, name, description, ds.additional AS add_defendant, ps.additional AS add_sentence,
						value, UNIX_TIMESTAMP( complete ) as complete
						FROM defendant_sentence ds
						JOIN program_sentences ps ON ps.sentenceID = ds.sentenceID
						WHERE ds.defsentID = :defsentID";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':defsentID', $defsentID);
		Core::dbClose();
			
		try {
			if( $stmt->execute() && $stmt->rowCount() > 0 )
			{				
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				
				$this->defsentID = $defsentID;
				$this->sentenceID = $row["sentenceID"];
				$this->name = $row["name"];
				$this->description = $row["description"];
				$this->value = $row["value"];
				$this->additional = $row["add_sentence"];
				$this->additionalValue = $row["add_defendant"];
				$this->completeDate = $row["complete"];
				
				return true;
			}
		} catch (PDOException $e) {
			echo "Sentence add failed!";
		}			
		return false;
	}
	
	/*************************************************************************************************
    function: removeSentence
    purpose: removes sentence requirement
    input: $defsentID = sentence/defendant unique id.
    output: boolean true/false
  ************************************************************************************************/
	public function removeSentence( $defsentID )
	{
		$core = Core::dbOpen();
		$sql = "DELETE FROM defendant_sentence WHERE defsentID = :defsentID AND defendantID = :defendantID";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':defendantID', $this->defendantID);
		$stmt->bindParam(':defsentID', $defsentID);
		Core::dbClose();
			
		try {
			if($stmt->execute())
				return true;
		} catch (PDOException $e) {
			echo "Sentence remove failed!";
		}
		return false;
	}
	
	/*************************************************************************************************
    function: updateSentence
    purpose: updates sentence requirement
    input: none
    output: boolean true/false
  ************************************************************************************************/
	public function updateSentence( )
	{
	
		$core = Core::dbOpen();
		$serverdate = ( $this->completeDate ) ? $core->convertToServerDate( $this->completeDate, $_SESSION["timezone"] ) : NULL;
	
		$sql = "UPDATE defendant_sentence SET value = :value, additional = :additional, complete = :complete
						WHERE defsentID = :defsentID";
		$stmt = $core->dbh->prepare($sql);
		$stmt->bindParam(':defsentID', $this->defsentID);
		$stmt->bindParam(':value', $this->value);
		$stmt->bindParam(':additional', $this->additionalValue);
		$stmt->bindParam(':complete', $serverdate);
		Core::dbClose();
		
		try {
			if($stmt->execute())
				return true;
				
				print_r( $stmt->errorInfo() );
		} catch (PDOException $e) {
			echo "Sentence update failed!";
		}
		return false;
	}
	
	// setters
	public function setDefendantID( $var ) { $this->defendantID = $var; }
	
	// getters
	public function getDefendantID() { return $this->defendantID; }
	public function getSentenceID() { return $this->sentenceID; }
	
		
}

