<?php

/**
 * Health analyser page
 */
class HealthAnalyserPage extends Page {
	
}

/**
 * Health analyser page controller
 */
class HealthAnalyserPage_Controller extends Page_Controller {
	
	private static $allowed_actions = array('SearchForm');
	
	private $repository;
	
	private $stepsList;
	private $distanceList;
	private $climbList;
	private $bodyMassList;
	private $hearthRateList;
	private $bpsystolicList;
	private $bpdiastolicList;
	
	/**
	 * Init controller
	 */
	public function init() {
		
		if(!$this->CanHealthPageView()) {
			$this->redirect($this->LinkToHealthProfilPage());
		}
		
		$this->repository = Injector::inst()->create('Repository');
		
		$this->stepsList = $this->repository->GetSteps(true);
		$this->distanceList = $this->repository->GetDistance(true);
		$this->climbList = $this->repository->GetClimbing(true);
		$this->bodyMassList = $this->repository->GetBodyMass(true);
		$this->hearthRateList =  $this->repository->GetHearthRate(true);
		$this->bpsystolicList = $this->repository->GetBPSystolic(true);
		$this->bpdiastolicList = $this->repository->GetBPDiastolic(true);
		
		
		parent::init();
	}
	
	/**
	 * Generate search form
	 * @return form
	 */
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
	
	/**
	 * Action of Search form
	 * @return rendering
	 */
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
		
		$this->hearthRateList = $this->repository->GetHearthRate()->filter($filter)->sort('StartDate ASC');
		$this->bpsystolicList = $this->repository->GetBPSystolic()->filter($filter)->sort('StartDate ASC');
		$this->bpdiastolicList = $this->repository->GetBPDiastolic()->filter($filter)->sort('StartDate ASC');
		$this->stepsList = $this->repository->GetSteps(true);
		
		return $this->render();
	}
		
	/**
	 * Generate string of dates for steps
	 * @return string
	 */
	public function GetStepsDateTime() {
		
		return $this->FormatHealthDate($this->stepsList);
	}
	
	/**
	 * Generate string of values for steps
	 * @return string
	 */
	public function GetStepsValues() {
		
		return $this->GetHealthValueString($this->stepsList);
	}
	
	/**
	 * Generate string of dates for distance
	 * @return string
	 */
	public function GetDistanceDateTime() {
		
		return $this->FormatHealthDate($this->distanceList);
	}
	
	/**
	 * Generate string of values for distance
	 * @return string
	 */
	public function GetDistanceValues() {
		
		return $this->GetHealthValueString($this->distanceList);
	}
	
	/**
	 * Generate string of dates for climbing
	 * @return string
	 */
	public function GetClimbeDateTime() {
		
		return $this->FormatHealthDate($this->climbList);
	}
	
	/**
	 * Generate string of values for climbing
	 * @return string
	 */
	public function GetClimbeValues() {
		
		return $this->GetHealthValueString($this->climbList);
	}
	
	/**
	 * Generate string of dates for BodyMass
	 * @return string
	 */
	public function GetBodyMassDateTime() {
		
		return $this->FormatHealthDate($this->bodyMassList);
	}
	
	/**
	 * Generate string of values for BodyMass
	 * @return string
	 */
	public function GetBodyMassValues() {
		
		return $this->GetHealthValueString($this->bodyMassList);
	}
	
	/**
	 * Generate string of dates for heartrate
	 * @return string
	 */
	public function GetHearthRateDateTime() {
		
		return $this->FormatHealthDate($this->hearthRateList, false);
	}
	
	/**
	 * Generate string of values for heartrate
	 * @return string
	 */
	public function GetHearthRateValues() {
		
		return $this->GetHealthValueString($this->hearthRateList);
	}
	
	/**
	 * Generate string of dates for bloodpresure
	 * @return string
	 */
	public function GetBPDateTime() {
		
		return $this->FormatHealthDate($this->bpdiastolicList, false);
	}
	
	/**
	 * Generate string of values for bloodpresure diastolic
	 * @return string
	 */
	public function GetBPDiastolicValues() {
		
		return $this->GetHealthValueString($this->bpdiastolicList);
	}
	
	/**
	 * Generate string of values for bloodpresure systolic
	 * @return string
	 */
	public function GetBPSystolicValues() {
		
		return $this->GetHealthValueString($this->bpsystolicList);
	}
	
	/**
	 * Get Systolic default value
	 * @return string
	 */
	public function GetBPSystolicDefault() {
	
		$return = array();
	
		foreach ($this->bpsystolicList as $item) {
				
			$return[] = "135";
		}
	
		return implode(',', $return);
	}
	
	/**
	 * Get Diastolic default value
	 * @return string
	 */
	public function GetBPDiastolicDefault() {
	
		$return = array();
	
		foreach ($this->bpdiastolicList as $item) {
				
			$return[] = "85";
		}
	
		return implode(',', $return);
	}
	
	/**
	 * Calculate result of blood presure
	 * @return ArrayList
	 */
	public function CalcBPResult() {
		
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

	/**
	 * Validate User rights for analyser page
	 * @return boolean
	 */
	public function CanHealthPageView() {
		
		$group = DataObject::get_one('Group', array('Code' => 'HealthAnalyserAppUsers'));
		if(Member::currentUser() && Member::currentUser()->inGroup($group->ID)){
			
			return true;
		}
		
		return false;
	}
	
	/**
	 * Generate Link to profile page
	 * @return ArrayList
	 */
	public function LinkToHealthProfilPage() {
	
		if($children = $this->Children()) {
				
			$page = $children->filterByCallback(function ($item, $list) { return $item->getClassName() == 'HealthAnalyserProfilPage';});
				
			if ($page->exists()) {
				return $page->first()->Link();
			}
		}
	
		return null;
	}
	
	/**
	 * Formate health value
	 * @return string|null
	 */
	private function GetHealthValueString($sourceList) {
		
		$list = $sourceList->map('ID', 'Value');
		
		return (!empty($list)) ? implode(',', $list) : null;
	}
	
	/**
	 * Formate date for chart
	 * @return string|null
	 */
	private function FormatHealthDate($sourceList, $withoutTime = true) {
		
		$return = array();
		
		foreach ($sourceList->map('ID', 'StartDate') as $startDate) {
			$date = new DateTime($startDate);
			array_push($return, ($withoutTime) ? $date->format("d.m.Y") : $date->format("d.m.Y H:i"));
		}
		
		return (!empty($return)) ? "'".implode("','", $return)."'" : null;
	}
}