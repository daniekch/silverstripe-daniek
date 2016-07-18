<?php

class HealthAnalyserPage extends Page
{
	
	
}

class HealthAnalyserPage_Controller extends Page_Controller {

	public function init() {
		parent::init();

	}
	
	public function GetHearthRateDateTime() {
		$hearthRateList = HeartRate::get();
	
		return "'".implode("','", $hearthRateList->map('ID', 'EffectiveTimeLow')->toArray())."'";
	}
	
	public function GetHearthRateValues() {
		$hearthRateList = HeartRate::get();
		
		return implode(',', $hearthRateList->map('ID', 'Value')->toArray());
	}
	
	public function GetHearthRateAvarageValues() {
		$hearthRateList = HeartRate::get();
	
		return implode(',', $hearthRateList->map('ID', 'Value')->toArray());
	}
	
	public function GetBPDateTime() {
		$bpsystolicList = BPSystolic::get();
	
		return "'".implode("','", $bpsystolicList->map('ID', 'EffectiveTimeLow')->toArray())."'";
	}
	
	public function GetBPSystolicValues() {
		$bpsystolicList = BPSystolic::get();
		
		return implode(',', $bpsystolicList->map('ID', 'Value')->toArray());
	}
	
	public function GetBPSystolicDefault() {
		
		$bpsystolicList = BPSystolic::get();
		$return = array();
		
		foreach ($bpsystolicList as $item) {
			
			$return[] = "135";
		}
		
		return implode(',', $return);
	}
	
	public function GetBPDiastolicValues() {
		$bpdiastolicList = BPDiastolic::get();
	
		return implode(',', $bpdiastolicList->map('ID', 'Value')->toArray());
	}
	
	public function GetBPDiastolicDefault() {
	
		$bpdiastolicList = BPDiastolic::get();
		$return = array();
	
		foreach ($bpdiastolicList as $item) {
				
			$return[] = "85";
		}
	
		return implode(',', $return);
	}

	public function CalResult() {
		$sysList = BPSystolic::get();
		$diaList = BPDiastolic::get();
		$minSys = 99999;
		$maxSys = 0;
		$avgSys = 0;
		$minDia = 99999;
		$maxDia= 0;
		$avgDia = 0;
		
		foreach ($sysList as $item) {
			if($item->Value < $minSys){
				$minSys = $item->Value;
			}
			if($item->Value > $maxSys){
				$maxSys = $item->Value;
			}
			
			$avgSys = $avgSys + $item->Value;
		}
		
		foreach ($diaList as $item) {
			if($item->Value < $minDia){
				$minDia = $item->Value;
			}
			if($item->Value > $maxDia){
				$maxDia = $item->Value;
			}
				
			$avgDia = $avgDia + $item->Value;
		}
		
		 return new ArrayList(array(
		 		new ArrayData(array('type' => "SYS", 'min' => $minSys, "avg" => round($avgSys / $sysList->count()), "max" => $maxSys)),
		 		new ArrayData(array('type' => "DIA", 'min' => $minDia, "avg" => round($avgDia / $diaList->count()), "max" => $maxDia))
		));
	}
}