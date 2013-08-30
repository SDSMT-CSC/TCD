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
  
  /*************************************************************************************************
   function: buildHeader
   purpose: build header for all reports
   input: $programID = programID to build header for
          $type = report type
          $start = report start date
          $end = report end date
   output: None
  *************************************************************************************************/
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
  
  /*************************************************************************************************
   function: print header
   purpose: print the header
   input: none
   output: html output
  *************************************************************************************************/
  public function printHeader()
  {
    //echo '<div style="text-align:center">'.
    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/includes/css/print.css\" media=\"print\" />";
    echo '<h1>'.$this->programName.'</h1>';
    echo '<h2>'.$this->reportType.'</h2>';
    echo "<h3>for the period of</h3>";
    echo '<h4>'.$this->reportStartDate.' to '.$this->reportEndDate.'</h4>';
    //echo </div>;
  }
  
  /*************************************************************************************************
   function: getVolunteers
   purpose: get volunteers to print information on
   input: $start = start date
          $end = end date
          $programID = program to fetch volunteers for
   output: volunteer array
  *************************************************************************************************/
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
      echo $court_caseID;
      $stmt->bindParam(':court_caseID', $court_caseID);
      try {
        if( $stmt->execute() ) {
          while( $aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
    
    return $volunteers;
  }
  
  /*************************************************************************************************
   function: printVolunteers
   purpose: print information on volunteers 
   input: $volunteers = array of volunteers
   output: html output
  *************************************************************************************************/
  public function printVolunteers( $start, $end, $programID )
  {
    $volunteers = $this->getVolunteers( $start, $end, $programID );
    //set up table
    echo "<table class=\"top\">";
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

  /*************************************************************************************************
   function: getDemographics
   purpose: print demographics for the given program
   input: $start = report start date
          $end = report end date
          $programID = program to do information for
   output: array of defendant information
  *************************************************************************************************/
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
          $row["defendantID"] = $aRow["defendantID"];
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

  /*************************************************************************************************
   function: printDemographics
   purpose: print demographics information to html page
   input: $defendants = defendant information array
   output: html output
  *************************************************************************************************/
  public function printDemographics( $start, $end, $programID )
  {
    $defendants = array();
    foreach($programID as $id)
      $defendants = array_merge($defendants, $this->getDemographics( $start, $end, $id ));
    
    //print number of defendants entered within program in time frame
    echo "All data is where the Defendent Added date falls within the date range<br>";
    $count = count($defendants);
    echo "Number of Defendants Entered: ".$count."<br>";
    
    $demoBySex = array();
    $location = array();
    $race = array();
    $sex = array();
    $age = array();
    $offense = array();
    foreach( $defendants as $defendant ) {
      
      //block to get demographic based on sex
      if( $defendant["sex"] == "" )
        $defendant["sex"] = "Not Entered";
      $demoBySex[$defendant["sex"]]["count"] += 1;
      //taken from stack exchange, converts string date to year.
      $diff = strtotime(date(Y)) - (strtotime($defendant["dob"]));
      $years = floor($diff / (365 * 60 * 60 * 24));
      $demoBySex[$defendant["sex"]]["$years"]["count"] += 1;
      if( $defendant["ethnicity"] == "" )
        $defendant["ethnicity"] = "Not Entered";
      $demoBySex[$defendant["sex"]]["$years"][$defendant["ethnicity"]] += 1;
      
      //gets statistics per section
      foreach( $defendant as $key => $value) {
        switch( $key ) {
          case "locationID":
            if ( $value == "" )
              $value = "Not Entered";
            $location[$value] += 1;;
            break;
          case "dob":
            //taken from stack exchange, converts string date to year.
            $diff = strtotime(date(Y)) - (strtotime($value));
            $years = floor($diff / (365 * 60 * 60 * 24));
            $age[$years] += 1;
            break;
          case "sex":
            if ( $value == "" )
              $value = "Not Entered";
            $sex[$value] += 1;
            break;
          case "ethnicity":
            if ( $value == "" )
              $value = "Not Entered";
            $race[$value] += 1;
            break;
          case "defendantID":
            $offense[] = $value;
        }
      }
    }
    
    //fetch extra information for each table
    $offense = $this->getOffenses( $offense );
    $location = $this->getLocation( $location );
    
    //sort arrays to simplify
    ksort($location);
    ksort($age);
    ksort($sex);
    ksort($race);
    
    //move 'Not Entered' to end
    $location = $this->moveToEnd($location);
    $sex = $this->moveToEnd($sex);
    $race = $this->moveToEnd($race);
    
    //print demo by sex
    echo "<p>Demographics By Sex</p>";
    echo "<table class=\"top\">";
    echo "  <thead>";
    echo "    <tr>";
    echo "      <th></th><th>Sex</th><th></th>";
    echo "      <th></th><th>Age</th><th></th>";
    echo "      <th></th><th>Race</th><th></th>";
    echo "    </tr>";
    echo "  </thead>";
    echo "  <tbody>";
    foreach( $demoBySex as $dsex => $gender ) {
      echo "<tr><td>".$dsex."</td><td>".$gender["count"]."</td><td>".sprintf("%0.2f",$gender["count"]/$count*100)."</td>";
      echo "<td></td><td></td><td></td><td></td><td></td><td></td></tr>";
      foreach( $gender as $dage => $year ) {
        if( $dage == "count") 
          continue;
        echo "<tr><td></td><td></td><td></td>";
        echo "<td>".$dage."</td><td>".$year["count"]."</td><td>".sprintf("%0.2f",$year["count"]/$gender["count"]*100)."</td>";
        echo "<td></td><td></td><td></td></tr>";
        foreach( $year as $drace => $ethnic ) {
          if( $drace == "count")
            continue;
          echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td>";
          echo "<td>".$drace."</td><td>".$ethnic."</td><td>".sprintf("%0.2f",$ethnic/$year["count"]*100)."</td></tr>";
        }
      }
    }
    echo "  </tbody>";
    echo "</table><br>";
    
    //print demographics by offense
    echo "<p>Demographics by Offense</p>";
    $this->printOffenses( $offense );
    echo "<div class=\"top\"></div>";
    
    echo "<p>Court Statistics</p>";
    
    $this->basicTablePrint( $location, "Location", $count);
    $this->basicTablePrint( $sex, "Gender", $count);
    $this->basicTablePrint( $age, "Age", $count);
    $this->basicTablePrint( $race, "Race", $count);
  }

  /*************************************************************************************************
   function: basicTablePrint
   purpose: print simple tables
   input: $printArray = array to have information listed
          $colName = name for first column
          $count = count of defendants
   output: html output
  *************************************************************************************************/
  public function basicTablePrint( $printArray, $colName, $count ) {
    echo "<table>";
    echo "  <thead>";
    echo "    <tr>";
    echo "      <th>".$colName."</th>";
    echo "      <th>Count</th>";
    echo "      <th>Percent</th>";
    echo "    </tr>";
    echo "  </thead>";
    echo "  <tbody>";
    foreach( $printArray as $key => $number ) {
      echo '<tr><td>'.$key.'</td><td>'.$number.'</td><td>'.sprintf("%0.2f",$number/$count*100).'%</td></tr>';
    }
    echo "  </tbody>";
    echo "</table><br>";
  }
  
  /*************************************************************************************************
   function: printOffenses
   purpose: print offense information
   input: $offenses = array of offenses
   output: html output
  *************************************************************************************************/
  public function printOffenses( $offenses ) {
    $totalCount = $offenses["totalCount"];
    unset( $offenses["totalCount"]);
    
    echo "Offenses in this time period: ".$totalCount;
    foreach( $offenses as $key => $offense ) {
      echo "<table>";
      echo "  <thead>";
      echo "    <tr>";
      echo "      <th>Statute</th>";
      echo "      <th>Title</th>";
      echo "      <th>Total</th>";
      echo "    </tr>";
      echo "  </thead>";
      echo "  <tbody>";
      echo "  <tr><td>".$key."</td><td>".$offense["title"]."</td><td>".$offense["count"]."</td></tr>";
      echo "  </tbody>";
      echo "</table>";
      echo "<table>";
      echo "  <thead>";
      echo "    <tr>";
      echo "      <th></th><th>Gender</th><th></th>";
      echo "      <th></th><th>Race</th><th></th>";
      echo "    </tr>";
      echo "  </thead>";
      echo "  <tbody>";
      foreach( $offense["sex"] as $gender => $value ) {
        echo "<tr><td>".$gender."</td><td>".$value["count"]."</td><td>".sprintf("%0.2f",$value["count"]/$totalCount*100)."%</td><td></td><td></td><td></td></tr>";
        foreach ( $value["race"] as $race => $count) {
          echo "<tr><td></td><td></td><td></td><td>".$race."</td><td>".$count."</td><td>".sprintf("%0.2f",$count/$value["count"]*100)."%</tr>";
        }
      }
      echo "  </tbody>";
      echo "</table><br>";
    }
  }
  
  /*************************************************************************************************
   function: moveToEnd
   purpose: have not entered information be moved to end
   input: $arr = array to be rearranged
   output: arr = returned variable
  *************************************************************************************************/
  public function moveToEnd( $arr )
  {
    $val = $arr["Not Entered"];
    unset($arr["Not Entered"]);
    $arr["Not Entered"] = $val;
    return $arr;
  }
  
  /*************************************************************************************************
   function: getOffenses
   purpose: get offenses defendants committed
   input: $defendants = defendant array
   output: array of offenses
  *************************************************************************************************/
  public function getOffenses( $defendants )
  {
    $offenses = array();
    $offense = array();
    $existingOff = array();
    
    //fetch information
    $core = Core::dbOpen();
    $sql = "SELECT c.citationID, c.drugsOrAlcohol, ps.statute, ps.title,
            cv.vehicleID, d.sex, d.ethnicity
            FROM citation c
            LEFT JOIN citation_offense co ON c.defendantID = co.defendantID
            LEFT JOIN program_statutes ps ON co.statuteID = ps.statuteID
            LEFT JOIN citation_vehicle cv ON c.citationID = cv.citationID
            LEFT JOIN defendant d ON d.defendantID = c.defendantID
            WHERE c.defendantID = :id";
    $stmt = $core->dbh->prepare($sql);
    foreach( $defendants as $key => $value) {
      $stmt->bindParam(':id', $value);
      try {
        if( $stmt->execute() ) {
          while( $aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $offenses[$value]["statute"][] = $aRow["statute"];
            $offenses[$value]["title"][] = $aRow["title"];
            $offenses[$value]["drugsOrAlcohol"] = $aRow["drugsOrAlcohol"];
            $offenses[$value]["vehicle"] = $aRow["vehicleID"];
            $offenses[$value]["sex"] = $aRow["sex"];
            $offenses[$value]["ethnicity"] = $aRow["ethnicity"];
          }
        }
      } catch (PDOException $e) {
        echo "Location Fetch Failed!";
      }
    }
    Core::dbClose();
    
    $currStatutes = array();
    //convert to table form
    foreach( $offenses as $blah => $statute ) {
      foreach( $statute as $key => $info ) {
        if( $key == "statute" ) {
          foreach( $info as $value ) {
            $currStatutes[] = $value;
            $offense["totalCount"] += 1;
            $offense[$value]["count"] += 1;
          }
        } elseif( $key == "title" ) {
          foreach( $info as $codeKey => $value ) {
            $offense[$currStatutes[$codeKey]]["title"] = $value;
          }
        } elseif( $key == "sex") {
          foreach( $currStatutes as $value ) {
            if( $info == "" )
              $info = "Not Entered";
            $offense[$value]["sex"][$info]["count"] += 1;
            $gender = $info;
          }
        } elseif( $key == "ethnicity") {
          foreach( $currStatutes as $value ) {
            if( $info == "" )
              $info = "Not Entered";
          $offense[$value]["sex"][$gender]["race"][$info] += 1;
          }
          //reset information for next pass through
          $currStatutes = array();
          $gender = NULL;
        }
      }
    }
    
    return $offense;
  }
  
  /*************************************************************************************************
   function: getLocation
   purpose: get location from id
   input: $location = locationID to retrieve
   output: location2 = locaion city and state
  *************************************************************************************************/
  public function getLocation( $location )
  {
    $location2 = array();
    //convert location from id to town
    $core = Core::dbOpen();
    $sql = "SELECT city, state, zip FROM program_locations WHERE locationID = :id";
    $stmt = $core->dbh->prepare($sql);
    foreach( $location as $key => $value) {
      if( $key == "Not Entered" ) {
        $key2 = "Not Entered";
        $location2[$key2] = $value;
        continue;
      }
      $stmt->bindParam(':id', $key);
      try {
        if( $stmt->execute() ) {
          while( $aRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $key2 = $aRow["city"].', '.$aRow["state"];
            $location2[$key2] = $value;
          }
        }
      } catch (PDOException $e) {
        echo "Location Fetch Failed!";
      }
    }
    Core::dbClose();
    
    return $location2;
  }
  
} //end class
?>