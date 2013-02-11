<?php
class Data{
	public function buildDataTable($data) {
		$lastElement = end($data);
		foreach($data as $userElement) {
			echo "[\n";
			foreach($userElement as $key => $value) {
				if($key == "email")
					echo "\"$value\"\n";
				else
					echo "\"$value\",\n";
			}
			if($userElement == $lastElement)
				echo "]\n";
			else
				echo "],\n";
		}
	}
	
	public function fetchUserData() {
		//database connection and SQL query
		$core = Core::dbOpen();
		$sql = "SELECT p.code, u.type, u.firstName, u.lastName, u.email FROM user u 
				JOIN program p ON u.programID = p.programID";
				
		$stmt = $core->dbh->prepare($sql);
		Core::dbClose();
		
		try {
			if($stmt->execute()) {
				$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
				//$json = json_encode($rows);
				return $rows;
			}
		}
		catch (PDOException $e) {
      		echo "Program Data Read Failed!";
    	}
	}
}
?>