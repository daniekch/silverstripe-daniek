<?php

/**
 * Health Service class.
 * 
 * The Health Service provide health app with usfull function.
 */
class HealthService {
    
	private $config;
	public $repository;
	
	static $dependencies = array(
		'repository'	=> '%$HealthRepository'
	);
    
    function __construct() {
    	
    	$this->config = Config::inst();
    	//$this->repository = Injector::inst()->create('Repository');
    }
    
    /**
     * Merge some types of data in only one record.
     * @return number[]
     */
    public function MergeHealthData() {
    	
    	$healthDataList = Health_Data::get()->filter(array('Adjusted' => 0));
    	
    	$result = array("Saved" => 0, "Deleted" => 0);
    	
    	$toDelete = new ArrayList();
    	$toAdjusted = new ArrayList();
    	
		$completedDate = null;
		$completedType = null;
			
		foreach ($healthDataList as $healthDataObject) {
				
			$startDate = new DateTime($healthDataObject->StartDate);
			$endDate = new DateTime($healthDataObject->EndDate);
				
		   	if($healthDataObject->Type == $this->config->get('Health_Data', 'xml_stepcount_type')) {
		   		$type = $this->config->get('Health_Data', 'xml_stepcount_type');
		   	}
		   	else if ($healthDataObject->Type == $this->config->get('Health_Data', 'xml_distance_type')) {
		   		$type = $this->config->get('Health_Data', 'xml_distance_type');
		   	}
		   	else if ($healthDataObject->Type == $this->config->get('Health_Data', 'xml_climbed_type')) {
		   		$type = $this->config->get('Health_Data', 'xml_climbed_type');
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
	    		
	   			$count = 0.00;
	    			
	   			foreach ($filteredList as $duplicate) {
	   				$count = $count + floatval($duplicate->Value);
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
    public function CreateCSVFile($xmlData) {
    	
        $file = tmpfile();
    	 
    	$titleRow = array('type', 'sourceName', 'sourceVersion', 'unit', 'creationDate', 'startDate', 'endDate', 'value');
    	 
    	fputcsv($file, $titleRow, ';');
    	 
    	foreach ($xmlData->Record as $record)
    	{
    		$startDate = new DateTime($record['startDate']);
    		$endDate = new DateTime($record['endDate']);
    		$creationDate = new DateTime($record['creationDate']);
    		
    		$row = array(
    				$record['type'],
    				$record['sourceName'],
    				$record['sourceVersion'],
    				$record['unit'],
    				$creationDate->format('Y-m-d H:i:s'),
    				$startDate->format('Y-m-d H:i:s'),
    				$endDate->format('Y-m-d H:i:s'),
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
    public function CreateCSVFileForImport($xmlData) {
    	 
    	$file = tmpfile();
    	 
    	$titleRow = array('Type', 'Value', 'StartDate', 'EndDate', 'MemberID');
    	 
    	fputcsv($file, $titleRow, ';');
    	 
    	foreach ($xmlData->Record as $record)
    	{
    		$startDate = new DateTime($record['startDate']);
    		$endDate = new DateTime($record['endDate']);
    		
    		$row = array($record['type'], $record['value'], $startDate->format('Y-m-d H:i:s'), $endDate->format('Y-m-d H:i:s'), Member::currentUserID());
    
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
    public function LoadDataInFile($csvFile) {
    	
    	$metaDatas = stream_get_meta_data($csvFile);
    	return $this->repository->InsertDataFromFile($metaDatas['uri']);
    }
    
    /**
     * Unzip the apple export file
     * 
     * @param string $zipName
     * @return File or NULL
     */
    public function readZIP($zipName) {
    	
    	$za = new ZipArchive();
    			
    	if ($za->open($zipName) == true) {
    		
    		for ($i = 0; $i < $za->numFiles; $i++){
    				
    			$infoEntry = $za->statIndex($i);
    			
    			if ($infoEntry['name'] == 'apple_health_export/Exportieren.xml' ||
    				$infoEntry['name'] == 'apple_health_export/Export.xml' ||
    				$infoEntry['name'] == 'Exportieren.xml') {
    				
    				return stream_get_contents($za->getStream($infoEntry['name']));
    			}
    		}
    	}
    	
    	return null;
    }
    
    /**
     * Get Steps from health data.
     *
     * @param boolean $limited
     * @return ArrayList
     */
    public function GetSteps($limited = false) {
    	return $this->repository->GetSteps($limited);
    }
    
    /**
     * Get Distance from health data.
     *
     * @param boolean $limited
     * @return ArrayList
     */
    public function GetDistance($limited = false) {
    	return $this->repository->GetDistance($limited);
    }
    
    /**
     * Get Climbing from health data.
     *
     * @param boolean $limited
     * @return ArrayList
     */
    public function GetClimbing($limited = false) {
    	return $this->repository->GetClimbing($limited);
    }
    
    /**
     * Get BodyMass from health data.
     *
     * @param boolean $limited
     * @return ArrayList
     */
    public function GetBodyMass($limited = false) {
    	return $this->repository->GetBodyMass($limited);
    }
    
    /**
     * Get Hearthrate from health data.
     *
     * @param boolean $limited
     * @return ArrayList
     */
    public function GetHearthRate($limited = false) {
    	return $this->repository->GetHearthRate($limited);
    }
    
    /**
     * Get Blood pressure systolic from health data.
     *
     * @param boolean $limited
     * @return ArrayList
     */
    public function GetBPSystolic($limited = false) {
    	return $this->repository->GetBPSystolic($limited);
    }
    
    /**
     * Get Blood pressure diastolic from health data.
     *
     * @param boolean $limited
     * @return ArrayList
     */
    public function GetBPDiastolic($limited = false) {
    	return $this->repository->GetBPDiastolic($limited);
    }
    
    public function StepsCount() {
    	$list = $this->repository->GetSteps();
    	return ($list != null) ? $list->count() : 0;
    }
    
    public function DistanceCount() {
    	$list = $this->repository->GetDistance();
    	return ($list != null) ? $list->count() : 0;
    }
    
    public function ClimbingCount() {
    	$list = $this->repository->GetClimbing();
    	return ($list != null) ? $list->count() : 0;
    }
    
    public function BodyMassCount() {
    	$list = $this->repository->GetBodyMass();
    	return ($list != null) ? $list->count() : 0;
    }
    
    public function HearthRateCount() {
    	$list = $this->repository->GetHearthRate();
    	return ($list != null) ? $list->count() : 0;
    }
    
    public function BPSystolicCount() {
    	$list = $this->repository->GetBPSystolic();
    	return ($list != null) ? $list->count() : 0;
    }
    
    public function BPDiastolicCount() {
    	$list = $this->repository->GetBPDiastolic();
    	return ($list != null) ? $list->count() : 0;
    }
    
    /**
     * Check if user have any data imported
     * @return boolean
     */
    public function UserHasData() {
    	
    	if ($this->repository->GetSteps() != null) {
    		return true;
    	}
    	elseif ($this->repository->GetDistance() != null) {
    		return true;
    	}
    	elseif ($this->repository->GetClimbing() != null) {
    		return true;
    	}
    	elseif ($this->repository->GetBodyMass() != null) {
    		return true;
    	}
    	elseif ($this->repository->GetHearthRate() != null) {
    		return true;
    	}
    	elseif ($this->repository->GetBPDiastolic() != null) {
    		return true;
    	}
    	elseif ($this->repository->GetBPSystolic() != null) {
    		return true;
    	}
    	
    	return false;
    }
}