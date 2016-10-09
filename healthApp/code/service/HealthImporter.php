<?php
class HealthImporter {
    
	const XML_BODYMASS_TYPE = "HKQuantityTypeIdentifierBodyMass";
    const XML_HEARTRATE_TYPE = "HKQuantityTypeIdentifierHeartRate";
    const XML_BPSYSTOLIC_TYPE = "HKQuantityTypeIdentifierBloodPressureSystolic";
    const XML_BPDIASTOLIC_TYPE = "HKQuantityTypeIdentifierBloodPressureDiastolic";
    const XML_STEPCOUNT_TYPE = "HKQuantityTypeIdentifierStepCount";
    const XML_DISTANCEWALKINGRUNNING_TYPE = "HKQuantityTypeIdentifierDistanceWalkingRunning";
    const XML_FLIGHTSCLIMBED_TYPE = "HKQuantityTypeIdentifierFlightsClimbed";
    
    public function Link($action = null) {
        return Controller::join_links('healthImport', $action);
    }
    
    /**
     * Save healtdata Object and return id
     * @param unknown $healthDate
     */
    public static function SaveHealthData($healthDataList) {
    	
    	foreach ($healthDataList as $healthData) {
    		
    		if($healthData->isInDB()) {
    			
    			if($healthData->updateChanges()) {
    				//$healthData->write();
    			}
    		}
    		else {
    			//$healthDate->write();
    		}
    		
    		$healthDate->flushCache();
    		$healthDate->destroy();
    		
    	}
    	
    	return $healthDataList->getIDList();
    }
    
    /**
     * Get healthData from exist db record or create a new
     * @param string $class_name
     * @param array $XMLcomponent
     * @param DateTime $low
     * @param DateTime $high
     */
    public static function GetHealtDataObject($record, $healthDataList) {
    	
    	$type = (string) $record['type'];
    	$startDate = new DateTime($record['startDate']);
    	$endDate = new DateTime($record['endDate']);
    	
    	if(	$type == HealthImporter::XML_DISTANCEWALKINGRUNNING_TYPE ||
    		$type == HealthImporter::XML_HEARTRATE_TYPE ||
    		$type == HealthImporter::XML_STEPCOUNT_TYPE) {
    			
    		$filter = array(
    			'Type'							=> $type,
    			'StartDate:GreaterThanOrEqual' 	=> $startDate->format('Y-m-d').'T00:00:00+00:00',
    			'EndDate:LessThanOrEqual' 		=> $endDate->format('Y-m-d').'T23:59:59+00:00',
    			'MemberID'						=> Member::currentUserID()
   			);
    		
    		$healthData = Health_Data::get()->filter($filter);
    		
    		if($healthData == null || !$healthData->exists()){
    			
    			$healthData = $healthDataList->filter($filter);
    		}
    	}
    	else {
    		$healthData = Health_Data::get()->filter(array(
    				'StartDate' => $startDate->format('Y-m-d H:i:s'),
    				'EndDate' 	=> $endDate->format('Y-m-d H:i:s'),
    				'MemberID'	=> Member::currentUserID()
    		));
    	}
    	
    	if($healthData != null && $healthData->exists()) {
    		
    		return $healthData->first();
    	}
    	
    	return new Health_Data();
    }
    
    /**
     * Create a new HealthData Object.
     * @param string $class_name Classname for healthData Type
     * @return HeartRate
     */
    public static function CreateHealthDataObject($record) {
    	
    	$healthData = new Health_Data();
    	
    	$startDate = new DateTime($record['startDate']);
    	$endDate = new DateTime($record['endDate']);
    	
    	$healthData->Type = (string) $record['type'];
    	$healthData->Value = floatval($record['value']);
    	$healthData->StartDate = $startDate->format('Y-m-d H:i:s');
    	$healthData->EndDate = $endDate->format('Y-m-d H:i:s');
    	$healthData->MemberID = Member::currentUserID();
    	
    	return $healthData;
    }
    
    /**
     * Delete all heartRates it was not in import
     * @param array $healthDataWrited
     * @return boolean
     */
    public static function DeleteHealthData($healthDataWrited) {
    	
    	$healthData = null;
    	
    	foreach($healthDataWrited as $id) {
    		
    		$healthData = Health_Data::get()->filter(array('MemberID' => Member::currentUserID()));
	    	
    		foreach($healthData as $item) {
    		
    			if(!in_array($item->ID, $id)) {
    				$item->delete();
    			}
    		}
    	}
    }
    
    public static function CleanUpHealthData() {
    	
    	$healthDataList = Health_Data::get()->filter(array('Adjusted' => 0));
    	
    	$result = array("Saved" => 0, "Deleted" => 0);
    	
    	$toDelete = new ArrayList();
    	$toAdjusted = new ArrayList();
    	
		$completedDate = null;
		$completedType = null;
			
		foreach ($healthDataList as $healthDataObject) {
				
			$startDate = new DateTime($healthDataObject->StartDate);
			$endDate = new DateTime($healthDataObject->EndDate);
				
		   	if($healthDataObject->Type == HealthImporter::XML_STEPCOUNT_TYPE) {
		   		$type = HealthImporter::XML_STEPCOUNT_TYPE;
		   	}
		   	else if ($healthDataObject->Type == HealthImporter::XML_DISTANCEWALKINGRUNNING_TYPE) {
		   		$type = HealthImporter::XML_DISTANCEWALKINGRUNNING_TYPE;
		   	}
		   	else if ($healthDataObject->Type == HealthImporter::XML_FLIGHTSCLIMBED_TYPE) {
		   		$type = HealthImporter::XML_FLIGHTSCLIMBED_TYPE;
		   	}
		   	else {
		   		$toAdjusted->push($healthDataObject);
		   		
		   		continue;
		   	}
		   	
		   	if (!($completedDate != null && 
		   		$completedDate->format('Y-m-d') == $startDate->format('Y-m-d') &&
		   		$completedType != null &&
		   		$completedType == $type)) {
		   		
	    		$filteredList = Health_Data::get()->filter(array(
	    				'Type'							=> $type,
	   					'StartDate:GreaterThanOrEqual' 	=> $startDate->format('Y-m-d').'T00:00:00+00:00',
	    				'EndDate:LessThanOrEqual' 		=> $endDate->format('Y-m-d').'T23:59:59+00:00',
	   					'MemberID'						=> Member::currentUserID(),
	    				'Adjusted' 						=> 0
	   			));
	    		
	   			$count = 0;
	    			
	   			foreach ($filteredList as $duplicate) {
	   				$count = $count + intval($duplicate->Value);
	   				$toDelete->push($duplicate);
	   			}
	    		
	   			$healthData = new Health_Data();
	   			$healthData->Type = $type;
	   			$healthData->Value = $count;
	   			$healthData->StartDate = $startDate->format('Y-m-d').'T00:00:00+00:00';
	   			$healthData->EndDate = $endDate->format('Y-m-d').'T23:59:59+00:00';
	   			$healthData->MemberID = Member::currentUserID();
	   			
	   			$toAdjusted->push($healthData);

	   			$completedDate = $startDate;
	   			$completedType = $type;
		   	}
		}
		
		foreach ($toDelete as $item) {
			$item->Delete();
			$result['Deleted']++;
		}
		
		foreach ($toAdjusted as $item) {
			$item->Adjusted = 1;
			$item->Write();
			
			$result['Saved']++;
		}
		
		return $result;
    }
    
    public static function CreateCSVFile($healthDataList, $import = false) {
    	
    	$file = tmpfile();
    	
    	$titleRow = array('Type', 'Value', 'StartDate', 'EndDate');
    	if($import == true) {
    		array_push($titleRow, 'MemberID');
    	}
    	
    	fputcsv($file, $titleRow, ';');
    	
    	foreach ($healthDataList as $healthData)
    	{
    		$row = array($healthData->Type, $healthData->Value, $healthData->StartDate, $healthData->EndDate);
    		if($import == true) {
    			array_push($row, $healthData->MemberID);
    		}
    		
    		fputcsv($file, $row, ';');
    	}
    	
    	fseek($file, 0);
    	
    	return $file;
    }
    
    public static function LoadDataInFile($csvFile) {
    	
    	try {
    		$metaDatas = stream_get_meta_data($csvFile);
    		DB::query("DELETE FROM health_data WHERE MemberID = ".Member::currentUserID());
    		DB::query("LOAD DATA LOCAL INFILE '".addslashes($metaDatas['uri'])."' REPLACE INTO TABLE health_data FIELDS TERMINATED BY ';' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' IGNORE 1 LINES (Type, Value, StartDate, EndDate, MemberID) SET LastEdited = NOW(), Created = NOW()");
    	
    		return true;
    	} catch (Exception $e) {
    		
    		return false;
    	}
    }
    
    public static function readZIP($zipName) {
    	
    	$za = new ZipArchive();
    			
    	if ($za->open($zipName) == true) {
    		
    		for ($i = 0; $i < $za->numFiles; $i++){
    				
    			$infoEntry = $za->statIndex($i);
    				
    			if ($infoEntry['name'] == 'apple_health_export/Exportieren.xml' || $infoEntry['name'] == 'Exportieren.xml') {
    				
    				return stream_get_contents($za->getStream($infoEntry['name']));
    			}
    		}
    	}
    	
    	return null;
    }
}