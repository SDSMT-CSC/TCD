<?php
class Reports {
  public $programName;
  public $reportType;
  public $reportStartDate;
  public $reportEndDate;
  
  public function __construct()
  {
    $this->programName = NULL;
    $this->reportType = NULL;
    $this->reportStartDate = NULL;
    $this->reportEndDate = NULL;
  }
  
  public function buildHeader( $programID, $type, $start, $end )
  {    
    $core = Core::dbOpen();
    $sql = "SELECT name FROM program WHERE programID = :programID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':programID', $programID);
    
    try {
      if( $stmt->execute() ) {
        $row = $stmt->fetch();
        $this->programName = $row["name"];
      }
    } catch (PDOException $e) {
      echo "Fetch Program Name Failed!";
    }
    
    $this->reportType = $type;
    $this->reportStartDate = $start;
    $this->reportEndDate = $end;
  }
  
  public function printHeader()
  {
    //echo '<div style="text-align:center">'.
    echo $this->programName.'<br>';
    echo $this->reportType.'<br>';
    echo "for the period of<br>";
    echo $this->reportStartDate.' to '.$this->reportEndDate.'<br><br>';
    //echo </div>;
  }
  
  public function getVolunteers( $start, $end, $programID )
  {
    $court = array();
    $volunteers = array();
    
    //keep core open till end, close if an exception occurs
    $core = Core::dbOpen();
    
    //get courts between start and end
    $sql = "SELECT courtID FROM court WHERE date BETWEEN :start AND :end AND programID = :programID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':start', $core->convertToServerDate( $start, $_SESSION["timezone"] ));
    $stmt->bindParam(':end', $core->convertToServerDate( $end, $_SESSION["timezone"]));
    $stmt->bindParam(':programID', $programID);
    
    try {
      if ( $stmt->execute() ) {
        while( $aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $court[] = $aRow["courtID"];
        }
      }
    } catch (PDOException $e) {
      Core::dbClose();
      echo "Court Fetch Failed!";
      return false;
    }
    
    //get court cases for each court
    $courtCase = array();
    $sql = "SELECT court_caseID FROM court_case WHERE courtID = :courtID";
    $stmt = $core->dbh->prepare($sql);
    foreach( $court as $key => $courtID ) {
      $stmt->bindParam(':courtID', $courtID);
      try {
        if( $stmt->execute() ) {
          while( $aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $courtCase[] = $aRow["court_caseID"];
          }
        }
      } catch (PDOException $e) {
        Core::dbClose();
        echo "Court Case Fetch Failed!";
        return false;
      }
    }
    
    //get volunteers for each court case
    $sql = "(SELECT v.firstName, v.lastName, cp.position, cm.hours FROM court_member cm
            JOIN volunteer v ON v.volunteerID = cm.volunteerID
            JOIN court_position cp ON cp.positionID = cm.positionID
            WHERE court_caseID = :court_caseID)
            UNION
            (SELECT v.firstName, v.lastName, 'Jury' as position, cv.hours FROM court_jury_volunteer cv
            JOIN volunteer v ON v.volunteerID = cv.volunteerID
            WHERE court_caseID = :court_caseID)
            ORDER BY lastName";
    $stmt = $core->dbh->prepare($sql);
    foreach( $courtCase as $key => $court_caseID) {
      $stmt->bindParam(':court_caseID', $court_caseID);
      try {
        if( $stmt->execute() ) {
          while( $aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
            //$volunteers[] = $aRow;
            $row = array();
            $row["name"] = $aRow["lastName"].", ".$aRow["firstName"];
            $row["position"] = $aRow["position"];
            $row["hours"] = $aRow["hours"];
            
            $volunteers[] = $row;
          }
        }
      } catch (PDOException $e) {
        Core::dbClose();
        echo "Court Member Fetch Failed!";
        return false;
      }
    }
    Core::dbClose();
    
    //var_dump($volunteers);
    return $volunteers;
  }
  
  public function printVolunteers( $volunteers )
  {
    //set up table
    echo "<table>";
    echo "  <thead>";
    echo "    <tr>";
    echo "      <th>Name</th>";
    echo "      <th>Position</th>";
    echo "      <th>Hours</th>";
    echo "    </tr>";
    echo "  </thead>";
    echo "  <tbody>";
    
    //go through volunteers, restructure to have it line up w/ original doc
    $existingVols = array();
    foreach( $volunteers as $key => $volunteer) {
      //name has already been checked, skip
      if( in_array($volunteer["name"], $existingVols) )
        continue;
      //load position name and hours into array and sum total hours
      $totalHours = 0;
      $position = array();
      $hoursWorked = array();
      //inner loop to get other positions for same person
      foreach ($volunteers as $innerkey => $vol) {
        if( $vol["name"] == $volunteer["name"]) {
          $existingVols[] = $vol["name"];             //add name to checked name array
          $totalHours += $vol["hours"];               //add hours to total hours
          if( in_array($vol["position"], $position)) {
            //position already exists in position array, just add hours
            $existPos = array_keys($position, $vol["position"]);
            $hoursWorked[$existPos[0]] += $vol["hours"];
          } else {
            //new position/hour combo, add both
            $position[] = $vol["position"];
            $hoursWorked[] = $vol["hours"];
          }
        }
      }
      //print information
      echo '<tr><td>'.$volunteer["name"].'</td><td></td><td>'.sprintf("%0.2f",$totalHours).'</td></tr>';
      foreach( $position as $posKey => $posValue) {
        echo '<tr><td></td><td>'.$posValue.'</td><td>'.sprintf("%0.2f",$hoursWorked[$posKey]).'</td></tr>';
      }
    }
  }

  public function getDemographics( $start, $end, $programID )
  {
    $defendant = array();
    
    $core = Core::dbOpen();
    
    $sql = "SELECT defendantID, dob, pLocationID, sex, ethnicity
            FROM defendant
            WHERE added BETWEEN :start AND :end AND programID = :programID";
    $stmt = $core->dbh->prepare($sql);
    $stmt->bindParam(':start', $core->convertToServerDate( $start, $_SESSION["timezone"] ));
    $stmt->bindParam(':end', $core->convertToServerDate( $end, $_SESSION["timezone"]));
    $stmt->bindParam(':programID', $programID);
    Core::dbClose();
    
    try {
      if( $stmt->execute() && $stmt->rowCount() > 0) {
        while( $aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $row = array();
          $row["dob"] = $aRow["dob"];
          $row["locationID"] = $aRow["pLocationID"];
          $row["sex"] = $aRow["sex"];
          $row["ethnicity"] = $aRow["ethnicity"];
          
          $defendant[] = $row;
        }
      }
    } catch (PDOException $e) {
      echo "Defendant Demographics Failed!";
    }
    return $defendant;
  }

  public function printDemographics( $defendants )
  {
    //print number of defendants entered within program in time frame
    echo "Number of Defendants Entered: ".count($defendants)."<br>";
    
    //get age, location, sex, and ethnicity for all defendatns in this time period
    $locationName = array();
    $locationCount = array();
    foreach( $defendants as $defendant ) {
      foreach( $defendant as $key => $value) {
        echo $key.': '.$value.'<br>';
        switch( $key ) {
          case "locationID":
            if( in_array($value, $locationName)) {  //check if location has already been entered
              
            } else {
              $locationName[] = $value;
              $locationCount[] += 1;
            }
            break;
          case "dob":
            break;
          case "sex":
            break;
          case "ethnicity":
            break;
        }
      }
    }
  }
  
} //end class























?>