<?php

class CanopusHAPage extends Page {
	
	private static $has_one = array(
		'WebcamImage' => 'Image'
	);
	
	function getCMSFields() {
	
		$fields = parent::getCMSFields();
		
		$fields->addFieldToTab(
			'Root.Webcam',
			$image = new UploadField(
						$name = 'WebcamImage',
						$title = 'Webcam Image'
					)
			);
		
		return $fields;
	}
}

class CanopusHAPage_Controller extends Page_Controller {
	
	private $config;
	private $socketService;
	private $socketRepo;
	
	private static $allowed_actions = [
		'LightSwitch',
	];
	
	public function init() {
		
		$this->config = Config::inst();
		$this->socketService = new SocketService();
		$this->socketRepo = new SocketRepository();
		
		parent::init();
	}
	
	public function GetIP() {
		
		return $this->socketRepo->GetIP();
	}
	
	public function GetSSLPort() {
	
		$data = CanopusHAData::get();
	
		if($data->exists()) {
	
			return $data->first()->SSLPort;
		}
	
		return 'none';
	}
	
	public function LastModified() {
		
		$data = CanopusHAData::get();
		
		if($data->exists()) {
		
			return $data->first()->LastEdited;
		}
		
		return '';
	}
	
	public function GetWebcamImage() {
		
		$image = $this->data()->WebcamImage();
		//$scaledImage = $image->ScaleWidth(600);
		$image->flushCache(true);
		return $image->ScaleWidth(600);
	}
	
	public function LightSwitch() {
		
		$command = 'LightSwitch-'.$this->config->get('Raspberry_Pi', 'Relais_1');
		
		return $this->socketService->sendData($command);
	}
	
	public function LightStatus() {
		
		$command = 'LightStatus-'.$this->config->get('Raspberry_Pi', 'Relais_1');
		
		$response = $this->socketService->sendData($command);
		
		if ($response == 'ON') {
			
			return "checked";
		}
		
		return "";
	}
}