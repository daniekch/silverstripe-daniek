<?php

use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

/**
 * FitBit page
 */
class FitBitPage extends Page {
	
	private static $db = array(
		'Column_1_title' => 'Varchar(255)',
		'Column_1_desc'	 => 'Text',
		'Column_3_title' => 'Varchar(255)',
		'Column_3_desc'	 => 'Text',
		'Error_global' => 'Text',
		'Warning_forbbiden' => 'Text',
		'Warning_unauthorized' => 'Text',
		'Warning_retryafter' => 'Text'
	);
	
	private static $has_one = array(
		'Column_2_img' => 'Image'
	);
	
	public function getCMSFields() {
		
		$fields = parent::getCMSFields();
	
		$fields->addFieldToTab('Root.Main', new TextField('Column_1_title', 'Spalte 1 Titel'));
		$fields->addFieldToTab('Root.Main', new TextField('Column_1_desc', 'Spalte 1 Text'));
		$fields->addFieldToTab('Root.Main', new UploadField('Column_2_img', 'Spalte 2 Bild'));
		$fields->addFieldToTab('Root.Main', new TextField('Column_3_title', 'Spalte 3 Titel'));
		$fields->addFieldToTab('Root.Main', new TextField('Column_3_desc', 'Spalte 3 Text'));
		$fields->addFieldToTab('Root.Message', new TextField('Error_global', 'Global Error Message'));
		$fields->addFieldToTab('Root.Message', new TextField('Warning_forbbiden', 'Warning Forbbiden Message'));
		$fields->addFieldToTab('Root.Message', new TextField('Warning_unauthorized', 'Warning Unauthorized Message'));
		$fields->addFieldToTab('Root.Message', new TextField('Warning_retryafter', 'Warning RetryAfter Message'));
	
		return $fields;
	}
}

/**
 * FitBit page controller
 */
class FitBitPage_Controller extends Page_Controller {
	
	private $service;
	private $ressourcenRepository;
	private $oAuth2Repository;
	
	public $Authorized = false;
	
	private $accessToken;
	private $profil;
	private $activities;
	private $devices;
	
	public $IsGlobalError;
	public $IsRetryAfter;
	public $RetryAfterTime;
	public $IsUnauthorized;
	public $IsForbidden;
	
	private static $allowed_actions = array(
		'Authorization'
	);
	
	public function init() {
		
		$this->service = Injector::inst()->create('IFitBitService');
		$this->ressourcenRepository = Injector::inst()->create('IFitBitRessourcenRepository');
		$this->oAuth2Repository = Injector::inst()->create('IFitBitOAuth2Repository');
		
		// Try to load a accesstoken
		$accessTokenResponse = $this->oAuth2Repository->LoadAccessToken();
		
		if ($accessTokenResponse != null) {
			
			$this->accessToken = $accessTokenResponse;
			$member = $this->ressourcenRepository->LoadMember($this->accessToken);
			
			if ($member != null) {
				
				try {
					$forceRefresh = $this->request->getVar('forcerefresh') == "1";
					
					$this->profil = $this->ressourcenRepository->LoadProfil($member, $this->accessToken, $forceRefresh);
					$this->activities = $this->ressourcenRepository->LoadActivities($member, $this->accessToken, $forceRefresh, date('Y-m-d'));
					$this->devices = $this->ressourcenRepository->LoadDevices($member, $this->accessToken, $forceRefresh);
					
					$this->Authorized = true;
				}
				catch (IdentityProviderException $exception) {
					
					if ($exception->getCode() == 400 || $exception->getCode() == 404) {
						
						$this->IsGlobalError = true;
					}
					elseif ($exception->getCode() == 401) {
						
						$this->IsUnauthorized = true;
					}
					elseif ($exception->getCode() == 403) {
						
						$this->IsForbidden = true;
					}
					elseif ($exception->getCode() == 429) {
						
						$response = $exception->getResponseBody();
						
						$this->IsRetryAfter = true;
						$this->RetryAfterTime = ($response->getHeader('Retry-After') != null) ? gmdate("i:s", $response->getHeader('Retry-After')[0]) : null;
					}
					
					SS_Log::log($exception, SS_Log::WARN);
				}
			}
		}
		
		parent::init();
	}
	
	/*
	 * Get URL for avatar image
	 */
	public function AvatarURL() {
		
		if (!empty($this->profil)) {
			
			return $this->profil['user']['avatar150'];
		}
		
		return null;
	}
	
	/*
	 * Get display name
	 */
	public function DisplayName() {
		
		if (!empty($this->profil)) {
			
			return $this->profil['user']['displayName'];
		}
		
		return null;
	}
	
	/*
	 * Get birthday
	 */
	public function Birthday() {
		
		if (!empty($this->profil)) {
	
			return date_create($this->profil['user']['dateOfBirth'])->Format('d.m.Y');
		}
	
		return null;
	}
	
	/*
	 * Get steps
	 */
	public function Steps() {
		
		if (!empty($this->activities)) {
			
			return $this->activities['summary']['steps'];
		}
		
		return null;
	}
	
	/*
	 * Get remain to defined goal
	 */
	public function RemainToGoal() {
		
		if (!empty($this->activities)) {
			
			$goal = intval($this->activities['goals']['steps']);
			$steps = intval($this->Steps());
			
			if ($goal > $steps) {
				
				return $goal - $steps;
			}
		}
		
		return 0;
	}
	
	/*
	 * Get avarage daily steps
	 */
	public function AverageDailySteps() {
		
		if (!empty($this->profil)) {
		
			return $this->profil['user']['averageDailySteps'];
		}
	}
	
	/*
	 * Get reached badges
	 */
	public function Badges() {
		
		if (!empty($this->profil)) {
			
			$arrayBadges = array();
		
			foreach ($this->profil['user']['topBadges'] as $topbadge) {
				
				$data = new ArrayData(array(
								'imageURL75px' => $topbadge['image75px'],
								'marketingDescription' => $topbadge['marketingDescription']
							));
				
				array_push($arrayBadges, $data);
			}
			
			return new ArrayList($arrayBadges);
		}
	}
	
	public function GetDevices() {
		
		if (!empty($this->devices)) {
			
			$arrayDevices = array();
		
			foreach ($this->devices as $device) {
				
				$data = new ArrayData(array(
								'deviceVersion' => $device['deviceVersion'],
								'battery' => $device['battery'],
								'lastSyncTime' => date_create($device['lastSyncTime'])->Format('d.m.Y H:i:s')
							));
				
				array_push($arrayDevices, $data);
			}
			
			return new ArrayList($arrayDevices);
		}
	}
	
	public function ErrorMessage() {
		
		if ($this->IsGlobalError) {
			
			return new ArrayData(array(
					'cssClass'	=>	'error',
					'message'	=>	$this->Error_global
			));
		}
		elseif ($this->IsForbidden) {
			
			return new ArrayData(array(
				'cssClass'	=>	'warning',
				'message'	=>	$this->Warning_forbbiden
			));
		}
		elseif ($this->IsUnauthorized) {
				
			return new ArrayData(array(
					'cssClass'	=>	'warning',
					'message'	=>	$this->Warning_unauthorized
			));
		}
		elseif ($this->IsRetryAfter) {
				
			return new ArrayData(array(
					'cssClass'	=>	'warning',
					'message'	=>	str_replace('{RetryAfterTime}', $RetryAfterTime, $this->Warning_retryafter)
			));
		}
		
		return null;
	}
	
	/*
	 * Link to authorization
	 */
	public function Authorization() {
		
		return $this->service->RedirectToAuthorization();
	}
}