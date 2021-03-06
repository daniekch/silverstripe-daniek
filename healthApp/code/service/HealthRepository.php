<?php

/**
 * Health repository class.
 * 
 * The repositoy provide the health application with data.
 */
class HealthRepository {
	
	public $config;
	
	function __construct() {
		$this->config = Config::inst();
	}
	
	/**
	 * Get Steps from health data.
	 * 
	 * @param boolean $limited
	 * @return ArrayList
	 */
	public function GetSteps($limited = false) {
		return self::GetHealthData($this->config->get('Health_Data', 'xml_stepcount_type'), $limited, true);
	}
	
	/**
	 * Get Distance from health data.
	 *
	 * @param boolean $limited
	 * @return ArrayList
	 */
	public function GetDistance($limited = false) {
		return self::GetHealthData($this->config->get('Health_Data', 'xml_distance_type'), $limited, true);
	}
	
	/**
	 * Get Climbing from health data.
	 *
	 * @param boolean $limited
	 * @return ArrayList
	 */
	public function GetClimbing($limited = false) {
		return self::GetHealthData($this->config->get('Health_Data', 'xml_climbed_type'), $limited, true);
	}
	
	/**
	 * Get BodyMass from health data.
	 *
	 * @param boolean $limited
	 * @return ArrayList
	 */
	public function GetBodyMass($limited = false) {
		return self::GetHealthData($this->config->get('Health_Data', 'xml_bodymass_type'), $limited);
	}
	
	/**
	 * Get Hearthrate from health data.
	 *
	 * @param boolean $limited
	 * @return ArrayList
	 */
	public function GetHearthRate($limited = false) {
		return self::GetHealthData($this->config->get('Health_Data', 'xml_hearthrate_type'), $limited);
	}
	
	/**
	 * Get Blood pressure systolic from health data.
	 *
	 * @param boolean $limited
	 * @return ArrayList
	 */
	public function GetBPSystolic($limited = false) {
		return self::GetHealthData($this->config->get('Health_Data', 'xml_bpsystolic_type'), $limited);
	}
	
	/**
	 * Get Blood pressure diastolic from health data.
	 *
	 * @param boolean $limited
	 * @return ArrayList
	 */
	public function GetBPDiastolic($limited = false) {
		return self::GetHealthData($this->config->get('Health_Data', 'xml_bpdiastolic_type'), $limited);
	}
	
	/**
	 * Insert Health data from a csv file.
	 *
	 * @param File $csvFile
	 * @return boolean
	 */
	public function InsertDataFromFile($path) {
		 
		try {
			DB::query("DELETE FROM Health_Data WHERE MemberID = ".Member::currentUserID());
			DB::query("LOAD DATA LOCAL INFILE '".addslashes($path)."' REPLACE INTO TABLE Health_Data FIELDS TERMINATED BY ';' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' IGNORE 1 LINES (Type, Value, StartDate, EndDate, MemberID) SET LastEdited = NOW(), Created = NOW()");
			 
			return true;
			
		} catch (Exception $e) {
			
			return false;
		}
	}
	
	/**
	 * Get Health data from database.
	 *
	 * @param string $type
	 * @param boolean $limited
	 * @param boolean $groupByData
	 * @return ArrayList
	 */
	private function GetHealthData($type, $limited = false, $groupByData = false) {
		
		$query = "  SELECT `ID` as ID,";
		$query .= " DATE(`StartDate`) as StartDate,";
		$query .= " DATE(`EndDate`) as EndDate,";
		if ($groupByData) {
			
			$query .= "SUM(`Value`) as Value";
		}
		else {
			$query .= "`Value` as Value";
		}
		$query .= " FROM `Health_Data`";
		$query .= " WHERE `Type` = '".$type."'";
		$query .= " AND `MemberID` = ".Member::currentUserID();
		
		if ($limited) {
			
			$query .= " AND DATE(`StartDate`) >= (";
			$query .= " SELECT MAX(`StartDate`) as StartDate ";
			$query .= " FROM `Health_Data`";
			$query .= " WHERE `Type` = '".$type."'";
			$query .= " AND `MemberID` = ".Member::currentUserID().") - INTERVAL ".intval($this->config->get('HealthRepository', 'data_day_interval'))." DAY";
		}
		
		if ($groupByData) {
			
			$query .= " GROUP BY DATE(`StartDate`)";
		}
	
		$result = DB::query($query);
		
		return $this->GetArrayList($result);
	}
	
	/**
	 * Generate a ArrayList of MySQLQuery
	 * 
	 * @param MySQLQuery $result
	 * @return ArrayList|NULL
	 */
	private function GetArrayList($result) {
		
		if($result->valid()) {
			
			$return = new ArrayList();
			
			foreach($result as $row) {
				$return->push(new ArrayData(array(
						'ID' => $row['ID'],
						'StartDate' => $row['StartDate']." 00:00:00",
						'EndDate' => $row['EndDate']." 23:59:59",
						'Value' => intVal($row['Value'])
				)));
			}
			
			return $return;
		}
		
		return null;
	}
}