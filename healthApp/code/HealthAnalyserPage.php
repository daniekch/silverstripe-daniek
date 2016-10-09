<?php

class HealthAnalyserPage extends Page {
	
	private $hearthRateList;
	private $bpsystolicList;
	private $bpdiastolicList;
}

class HealthAnalyserPage_Controller extends Page_Controller {

	private static $allowed_actions = array('SearchForm');
	
	public function init() {
		parent::init();
		
		if(!$this->CanHealthPageView()) {
			$this->redirect($this->Link().'profil-informationen');
		}
		
		$this->hearthRateList = Health_Data::get()->filter(array('Type' => HealthImporter::XML_HEARTRATE_TYPE, 'MemberID' => Member::currentUserID()));
		$this->bpsystolicList = Health_Data::get()->filter(array('Type' => HealthImporter::XML_BPSYSTOLIC_TYPE, 'MemberID' => Member::currentUserID()));
		$this->bpdiastolicList = Health_Data::get()->filter(array('Type' => HealthImporter::XML_BPDIASTOLIC_TYPE, 'MemberID' => Member::currentUserID()));
	}
	
	public function SearchForm() {
		
		$datefieldFrom = new DateField('From', 'Von');
		$datefieldFrom->addExtraClass('form-control');
		
		$datefieldTo = new DateField('To', 'Bis');
		$datefieldTo->addExtraClass('form-control');
		
		$fields = new FieldList(
			$datefieldFrom->setConfig('showcalendar', true)->setConfig('dateformat', 'dd.MM.yyyy'),
			$datefieldTo->setConfig('showcalendar', true)->setConfig('dateformat', 'dd.MM.yyyy')
    	);
		
		$actionButton = new FormAction('doSearchForm', 'Anzeigen');
		$actionButton->useButtonTag = true;
		$actionButton->addExtraClass('btn btn-primary btn-lg');
		
        $actions = new FieldList(
    		$actionButton
    	);
        
        $form = new Form($this, 'SearchForm', $fields, $actions);
        
        // Load the form with previously sent data
        $form->loadDataFrom($this->request->postVars());
        
        // Set custom template
        $form->setTemplate('HealthSearchForm');
        
        return $form;
	}
	
	public function doSearchForm($data, $form) {
		
		$datefrom;
		$dateTo;
		
		if(empty($data['From'])) {
			$datefrom = new DateTime("0000-00-00T00:00:00+00:00");
		}
		else {
			$datefrom = new DateTime($data['From'].'T00:00:00+00:00');
		}
		
		if(empty($data['To'])) {
			$dateTo = new DateTime();
		}
		else {
			$dateTo = new DateTime($data['To'].'T23:59:59+00:00');
		}
			
		$filter = array();
		if (!empty($datefrom)) {
			$filter['StartDate:GreaterThanOrEqual'] = $datefrom->format('Y-m-d H:i:s');
			$filter['EndDate:GreaterThanOrEqual'] = $datefrom->format('Y-m-d H:i:s');
		}
		if (!empty($dateTo)) {
			$filter['StartDate:LessThanOrEqual'] = $dateTo->format('Y-m-d H:i:s');
			$filter['EndDate:LessThanOrEqual'] = $dateTo->format('Y-m-d H:i:s');
		}
		
		$this->hearthRateList = Health_HeartRate::get()->filter($filter)->sort('StartDate ASC');
		$this->bpsystolicList = Health_BPSystolic::get()->filter($filter)->sort('StartDate ASC');
		$this->bpdiastolicList = Health_BPDiastolic::get()->filter($filter)->sort('StartDate ASC');
		
		return $this->render();
	}

	public function GetHearthRateDateTime() {
		return "'".implode("','", $this->hearthRateList->map('ID', 'StartDate')->toArray())."'";
	}
	
	public function GetHearthRateValues() {
		return implode(',', $this->hearthRateList->map('ID', 'Value')->toArray());
	}
	
	public function GetHearthRateAvarageValues() {
		return implode(',', $this->hearthRateList->map('ID', 'Value')->toArray());
	}
	
	public function GetBPDateTime() {
		return "'".implode("','", $this->bpsystolicList->map('ID', 'StartDate')->toArray())."'";
	}
	
	public function GetBPSystolicValues() {
		return implode(',', $this->bpsystolicList->map('ID', 'Value')->toArray());
	}
	
	public function GetBPSystolicDefault() {
		
		$return = array();
		
		foreach ($this->bpsystolicList as $item) {
			
			$return[] = "135";
		}
		
		return implode(',', $return);
	}
	
	public function GetBPDiastolicValues() {
		return implode(',', $this->bpdiastolicList->map('ID', 'Value')->toArray());
	}
	
	public function GetBPDiastolicDefault() {
	
		$return = array();
	
		foreach ($this->bpdiastolicList as $item) {
				
			$return[] = "85";
		}
	
		return implode(',', $return);
	}

	public function CalResult() {
		
		$minSys = 99999;
		$maxSys = 0;
		$avgSys = 0;
		$overDefaultSys = 0;
		
		$minDia = 99999;
		$maxDia= 0;
		$avgDia = 0;
		$overDefaultDia = 0;
		
		foreach ($this->bpsystolicList as $item) {
			if($item->Value < $minSys){
				$minSys = $item->Value;
			}
			if($item->Value > $maxSys){
				$maxSys = $item->Value;
			}
			
			$avgSys = $avgSys + $item->Value;
			
			if ($item->Value > 135) {
				$overDefaultSys++;
			}
		}
		
		foreach ($this->bpdiastolicList as $item) {
			if($item->Value < $minDia){
				$minDia = $item->Value;
			}
			if($item->Value > $maxDia){
				$maxDia = $item->Value;
			}
				
			$avgDia = $avgDia + $item->Value;
			
			if ($item->Value > 85) {
				$overDefaultDia++;
			}
		}
		
		 return new ArrayList(array(
		 		new ArrayData(array(
		 			'type' => "SYS",
		 			'min' => $minSys != 99999 ? $minSys : 0,
		 			'avg' => $avgSys != 0 ? round($avgSys / $this->bpsystolicList->count()) : 0,
		 			'max' => $maxSys,
		 			'percentOver' => $overDefaultSys != 0 ? round(($overDefaultSys / $this->bpsystolicList->count()) * 100) : 0
		 		)),
		 		new ArrayData(array(
		 			'type' => "DIA",
		 			'min' => $minDia != 99999 ? $minDia : 0,
		 			'avg' => $avgDia != 0 ? round($avgDia / $this->bpdiastolicList->count()) : 0,
		 			'max' => $maxDia,
		 			'percentOver' => $overDefaultSys != 0 ? round(($overDefaultDia / $this->bpdiastolicList->count()) * 100) : 0
		 		))
		));
	}
	
	public function getEncodedHealthAppURL() {
		return urlencode($this->Link());
	}
	
	public function GetTotalCountHealthData() {
		return $this->hearthRateList->count() + $this->bpsystolicList->count() + $this->bpdiastolicList->count();
	}

	public function CanHealthPageView() {
		
		$group = DataObject::get_one('Group', array('Code' => 'HealthAnalyserAppUsers'));
		if(Member::currentUser() && Member::currentUser()->inGroup($group->ID)){
			
			return true;
		}
		
		return false;
	}
}