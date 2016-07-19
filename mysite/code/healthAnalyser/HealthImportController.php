<?php
class HealthImport_Controller extends Controller {

    private static $allowed_actions = array('Form');

    protected $template = "BlankPage";
    
    const XMLHEARTRATETYPE = "HKQuantityTypeIdentifierHeartRate";
    const XMLBPSYSTOLICTYPE = "HKQuantityTypeIdentifierBloodPressureSystolic";
    const XMLBPDIASTOLICTYPE = "HKQuantityTypeIdentifierBloodPressureDiastolic";
    
    const HEARTRATE_CLASSNAME = "HeartRate";
    const BPSYSTOLIC_CLASSNAME = "BPSystolic";
    const BPDIASTOLIC_CLASSNAME = "BPDiastolic";
    
    public function Link($action = null) {
        return Controller::join_links('healthImport', $action);
    }

    public function Form() {
    	
    	if(!Permission::check("ADMIN")) {
    		$this->redirect(Director::baseURL() . 'Security/login?BackURL=' . urlencode(Director::baseURL() . 'healthImport'));
    	}
    	
    	return new Form(
    			$this,
    			'Form',
    			new FieldList(
    					new FileField('XMLFile', "File")
    					),
    			new FieldList(
    					new FormAction('doSubmitForm', 'Upload')
    					),
    			new RequiredFields('XMLFile')
    			);
    }

    public function doSubmitForm($data, $form) {
    	
    	$content = file_get_contents($data['XMLFile']['tmp_name']);
    	
    	if(!empty($content)) {
    		
    		$clinicalDocument = new SimpleXMLElement($content);
    		
    		$healthDataCreate = 0;
    		$healthDataUpdate = 0;
    		$healthDataDeleted = 0;
    		$healthDataWrited = array();
    		
    		foreach ($clinicalDocument->component[1]->section->entry as $entry) {
    			
    			foreach ($entry->organizer->component as $component) {
    				
    				$low = new DateTime($component->observation->effectiveTime->low->attributes()[0]);
    				$high = new DateTime($component->observation->effectiveTime->high->attributes()[0]);
    				
    				$healthDataClass;
    				
    				if($component->observation->text->type == self::XMLHEARTRATETYPE)
    				{
    					$healthDataClass = self::HEARTRATE_CLASSNAME;
    				}
    				elseif($component->observation->text->type == self::XMLBPSYSTOLICTYPE)
    				{
    					$healthDataClass = self::BPSYSTOLIC_CLASSNAME;
    				}
    				elseif ($component->observation->text->type == self::XMLBPDIASTOLICTYPE)
    				{
    					$healthDataClass = self::BPDIASTOLIC_CLASSNAME;
    				}
    				
    				$healthData = $this->GetHealtDataObject($healthDataClass, $component, $low, $high);
    					
    				if($healthData != null) {
    					$healthDataUpdate++;
    				}
    				else {
    					$healthData = $this->CreateHealthDataObject($healthDataClass);
    					$healthDataCreate++;
    				}
    					
    				$healthData->Value = intval($component->observation->text->value);
    				$healthData->EffectiveTimeLow = $low->format('Y-m-d H:i:s');
    				$healthData->EffectiveTimeHigh = $high->format('Y-m-d H:i:s');
    					
    				if ($id = $this->SaveHealthData($healthData)) {
    					$healthDataWrited["HeartRate"][] = $id;
    				}
    			} 
    		}
    		
    		$healthDataDeleted = $this->DeleteHealthData($healthDataWrited);
    	}
 		
        $messages = array();
        $messages[] = sprintf('Imported %d items', $healthDataCreate);
        $messages[] = sprintf('Updated %d items', $healthDataUpdate);
        $messages[] = sprintf('Deleted %d items', $healthDataDeleted);
        if(!$messages) $messages[] = 'No changes';
        $form->sessionMessage(implode(', ', $messages), 'good');

        return $this->redirectBack();
    }
    
    /**
     * Save healtdata Object and return id
     * @param unknown $healthDate
     */
    private function SaveHealthData($healthDate) {
    	
    	$id = $healthDate->write();
    	
    	if (is_numeric($id)) {
    		
    		SS_Log::log("HeartRate saved with ID: ".$id, SS_Log::INFO);
    		
    		return $id;
    	}
    		
    	return false;
    }
    
    /**
     * Get healthData from exist db record or create a new
     * @param string $class_name
     * @param array $XMLcomponent
     * @param DateTime $low
     * @param DateTime $high
     */
    private function GetHealtDataObject($class_name, $XMLcomponent, $low, $high) {
    	
    	$healthData;
    	
    	if($class_name == self::HEARTRATE_CLASSNAME) {
    		
    		$healthData = HeartRate::get()->filter(array(
    			'EffectiveTimeLow' 	=> $low->format('Y-m-d H:i:s'),
    			'EffectiveTimeHigh' => $high->format('Y-m-d H:i:s')
    		));
    	}
    	elseif ($class_name == self::BPDIASTOLIC_CLASSNAME) {
    		
    		$healthData = BPDiastolic::get()->filter(array(
    				'EffectiveTimeLow' 	=> $low->format('Y-m-d H:i:s'),
    				'EffectiveTimeHigh' => $high->format('Y-m-d H:i:s')
    		));
    	}
    	else if ($class_name == self::BPSYSTOLIC_CLASSNAME) {
    		
    		$healthData = BPSystolic::get()->filter(array(
    				'EffectiveTimeLow' 	=> $low->format('Y-m-d H:i:s'),
    				'EffectiveTimeHigh' => $high->format('Y-m-d H:i:s')
    		));
    	}
    		
    	if($healthData->exists()) {
    		
    		$healthData = $healthData->first();
    		SS_Log::log("Load healtData from DB with ID: ".$healthData->ID, SS_Log::INFO);
    		
    		return $healthData;
    	}
    	
    	return null;
    }
    
    /**
     * Create a new HealthData Object.
     * @param string $class_name Classname for healthData Type
     * @return HeartRate
     */
    private function CreateHealthDataObject($class_name) {
    	
    	$healthData;
    	$healthDataDeleted = 0;
    	
    	if($class_name == self::HEARTRATE_CLASSNAME) {
    		 
    		$healthData = new HeartRate();
    	}
    	elseif ($class_name == self::BPDIASTOLIC_CLASSNAME) {
    	
    		$healthData =  new BPDiastolic();
    	}
    	else if ($class_name == self::BPSYSTOLIC_CLASSNAME) {
    	
    		$healthData = new BPSystolic();
    	}
    	
    	SS_Log::log("Create new HeartRate Object", SS_Log::INFO);
    	 
    	return $healthData;
    }
    
    /**
     * Delete all heartRates it was not in import
     * @param array $healthDataWrited
     * @return boolean
     */
    private function DeleteHealthData($healthDataWrited) {
    	
    	$healthData;
    	$healthDataDeleted = 0;
    	
    	foreach($healthDataWrited as $class => $id) {
    		
    		if($class == self::HEARTRATE_CLASSNAME) {
	    		$healthData = HeartRate::get();
	    	}
	    	elseif ($class_name == self::BPDIASTOLIC_CLASSNAME) {
	    		 
	    		$healthData =  BPDiastolic::get();
	    	}
	    	else if ($class_name == self::BPSYSTOLIC_CLASSNAME) {
	    		 
	    		$healthData = BPSystolic::get();
	    	}
	    	
	    	foreach($healthData as $item) {
				
    			if(!in_array($item->ID, $id)) {
    				SS_Log::log("Delete HealthData Object with ID: ".$item->ID." and class ". $class, SS_Log::INFO);
    				$item->delete();
    				
    				$healthDataDeleted++;
    			}
	    	}
    	}
    	
    	return $healthDataDeleted;
    }
}