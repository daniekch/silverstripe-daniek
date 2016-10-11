<?php
class HealthImporter {
    
	const XML_BODYMASS_TYPE = "HKQuantityTypeIdentifierBodyMass";
    const XML_HEARTRATE_TYPE = "HKQuantityTypeIdentifierHeartRate";
    const XML_BPSYSTOLIC_TYPE = "HKQuantityTypeIdentifierBloodPressureSystolic";
    const XML_BPDIASTOLIC_TYPE = "HKQuantityTypeIdentifierBloodPressureDiastolic";
    const XML_STEPCOUNT_TYPE = "HKQuantityTypeIdentifierStepCount";
    const XML_DISTANCEWALKINGRUNNING_TYPE = "HKQuantityTypeIdentifierDistanceWalkingRunning";
    const XML_FLIGHTSCLIMBED_TYPE = "HKQuantityTypeIdentifierFlightsClimbed";
    
    /**
     * Merge some types of data in only one record.
     * @return number[]
     */
    public static function MergeHealthData() {
    	
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
    
    /**
     * Create a CSV file for converter app
     * 
     * @param SimpleXMLData $xmlData
     * @return CSV File
     */
    public static function CreateCSVFile($xmlData) {
    	
        $file = tmpfile();
    	 
    	$titleRow = array('type', 'sourceName', 'sourceVersion', 'unit', 'creationDate', 'startDate', 'endDate', 'value');
    	 
    	fputcsv($file, $titleRow, ';');
    	 
    	foreach ($xmlData->Record as $record)
    	{
    		$row = array(
    				$record['type'],
    				$record['sourceName'],
    				$record['sourceVersion'],
    				$record['unit'],
    				$record['creationDate'],
    				$record['startDate'],
    				$record['endDate'],
    				$record['value']
    			);
    
    		fputcsv($file, $row, ';');
    	}
    	 
    	fseek($file, 0);
    	 
    	return $file;
    }
    
    /**
     * Create a CSV for fast import in sql.
     * 
     * @param SimpleXMLData $xmlData
     * @return CSV file
     */
    public static function CreateCSVFileForImport($xmlData) {
    	 
    	$file = tmpfile();
    	 
    	$titleRow = array('Type', 'Value', 'StartDate', 'EndDate', 'MemberID');
    	 
    	fputcsv($file, $titleRow, ';');
    	 
    	foreach ($xmlData->Record as $record)
    	{
    		$row = array($record['type'], $healthData->Value, $healthData->StartDate, $healthData->EndDate, $healthData->MemberID);
    
    		fputcsv($file, $row, ';');
    	}
    	 
    	fseek($file, 0);
    	 
    	return $file;
    }
    
    /**
     * Execute the load data query on sql db.
     * 
     * @param File $csvFile
     * @return boolean
     */
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
    
    /**
     * Unzip the apple export file
     * 
     * @param string $zipName
     * @return File or NULL
     */
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