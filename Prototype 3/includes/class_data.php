<?php
class Data{
	public function fetchProgramData() {
		//database connection and SQL query
		$core = Core::dbOpen();
		$sql = "SELECT programID, type, firstName, lastName, email FROM user";
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