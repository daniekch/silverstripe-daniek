<?php

use function GuzzleHttp\json_decode;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

class FitBitRessourcenRepository implements IFitBitRessourcenRepository {
	
	private $config;
	private $provider;
	
	function __construct() {
		
		$this->config = Config::inst();
		$this->provider = Injector::inst()->create('FitBitProvider');
	}
	
	/*
	 * Load member from repository and if no data returned create a new profil
	 */
	public function LoadMember($accessToken) {
	
		$member = null;
		$id = $accessToken->getResourceOwnerId();
	
		if (!empty($id)) {
			
			$member = $this->GetMember($id);
			
			if ($member == null) {
	
				$member = $this->CreateMember($id);
			}
		}
	
		return $member;
	}
	
	/*
	 * Get FitBit data by user ID from DB.
	 */
	public function GetMember($id) {
	
		if ($id) {
				
			return DataObject::get_one('FitBitMember', "FitBitID = '".$id."'") ? : null;
		}
	
		return null;
	}
	
	/*
	 * Create a new FitBit Member.
	 */
	public function CreateMember($id) {
	
		if (!empty($id)) {
	
			$data = new FitBitMember();
			$data->FitBitID = $id;
			$data->FirstName = 'FitBitMember';
			$data->Surname = $id;
			$data->Email = 'fitbit.'.$id.'@daniek.ch';
			$data->write();
	
			return $data;
		}
	
		return null;
	}
	
	/*
	 * Load profil from repository and if no data returned create a new profil
	 */
	public function LoadProfil($member, $accessToken, $forceRefresh) {
		
		$profil = null;
		
		if (!$forceRefresh) {
			$profil = $this->GetProfil($member);
		}
		
		if ($profil == null) {
				
			$profil = $this->CreateProfil($member, $accessToken);
		}
		
		return $profil;
	}

	/*
	 * Get userprofil information from fitbit api.
	 */
	public function GetProfil($member) {
		
		$profile = $member->UserProfil();
		
		if ($profile->ID != 0 && $profile->Dirty == false) {
			
			return json_decode($profile->JSON, true);
		}
		
		return null;
	}
	
	/*
	 * Save user profil in local DB
	 */
	public function CreateProfil($member, $accessToken) {
		
		$url = FitBitProvider::BASE_FITBIT_API_URL . '/1/user/'.$member->FitBitID.'/profile.json';
		$response = $this->RessourcenRequest($url, $accessToken);
			
		if ($response == null) {
				
			return null;
		}
		
		$data = $this->CreateFitBitData($member, $member->UserProfil(), $response);
		
		if ($data->ID != $member->UserProfilID) {
		
			$member->UserProfilID = $data->ID;
			$member->write();
		}
		
		return json_decode($data->JSON, true);
	}
	
	/*
	 * Load activities from given user.
	 */
	public function LoadActivities($member, $accessToken, $forceRefresh, $date) {
		
		$activities = null;
		
		if (!$forceRefresh) {
			$activities = $this->GetActivities($member);
		}
	
		if ($activities == null) {
			
			$activities = $this->CreateActivities($member, $accessToken, $date);
		}
		
		// Check once the day if the subscription allways valid.
		$this->CleanUpSubscription($member, $activities, $accessToken, 'activities', $this->config->get('Subscriber', 'id'));
		
		// If data unsubscribed then subscribe it by fitbit notification
		if ($activities->Subscribed == false) {
			
			if ($this->AddRemoteSubscription($member, $accessToken, 'activities', $activities->ID, $this->config->get('Subscriber', 'id'))) {
				
				$activities->Subscribed = true;
				$activities->SubscriptionDate = date('Y-m-d H:i:s');
				$activities->write();
			}
		}
		
		return json_decode($activities->JSON, true);
	}
	
	/*
	 * Get activities.
	 */
	public function GetActivities($member) {
	
		$activities = $member->Activities();
		
		if ($activities->ID != 0 && $activities->Dirty == false) {
			
			return $activities;
		}
		
		return null;
	}
	
	/*
	 * Create activities from fitbit and save it.
	 */
	public function CreateActivities($member, $accessToken, $date) {
		
		$url = FitBitProvider::BASE_FITBIT_API_URL . '/1/user/'.$member->FitBitID.'/activities/date/'.$date.'.json';
		$response = $this->RessourcenRequest($url, $accessToken);
			
		if ($response == null) {
			
			return null;
		}
		
		$data = $this->CreateFitBitData($member, $member->Activities(), $response);
		
		if ($data->ID != $member->ActivitiesID) {
			
			$member->ActivitiesID = $data->ID;
			$member->write();
		}
		
		return $data;
	}
	
	/*
	 * Load devices from given user.
	 */
	public function LoadDevices($member, $accessToken, $forceRefresh) {
		
		$devices = null;
		
		if (!$forceRefresh) {
			$devices = $this->GetDevices($member);
		}
		
		if ($devices == null) {
			
			$devices = $this->CreateDevices($member, $accessToken);
		}
		
		return $devices;
	}
	
	/*
	 * Get devices connected to a user account
	 */
	public function GetDevices($member) {
		
		$devices = $member->Devices();
		
		if ($devices->ID != 0 && $devices->Dirty == false) {
			
			return json_decode($devices->JSON, true);
		}
		
		return null;
	}
	
	/*
	 * Create devices from fitbit and save it.
	 */
	public function CreateDevices($member, $accessToken) {
		
		$url = FitBitProvider::BASE_FITBIT_API_URL . '/1/user/'.$member->FitBitID.'/devices.json';
		$response = $this->RessourcenRequest($url, $accessToken);
			
		if ($response == null) {
		
			return null;
		}
		
		$data = $this->CreateFitBitData($member, $member->Devices(), $response);
		
		if ($data->ID !== $member->DevicesID) {
		
			$member->DevicesID = $data->ID;
			$member->write();
		}
		
		return json_decode($data->JSON, true);
	}
	
	/*
	 * Mark FitBit data record as dirty
	 */
	public function MarkAsDirty($id) {
		
		$data = DataObject::get_by_id('FitBitData', intval($id));
		
		if (!empty($data)) {
				
			$data->Dirty = true;
			
			return $data->write();
		}
		
		return 0;
	}
	
	/*
	 * Create fitbit data record.
	 */
	private function CreateFitBitData($member, $data, $response) {
		
		if ($data->ID == 0) {
			
			$data = new FitBitData();
		}
		
		$data->JSON = json_encode($response);
		$data->Hash = md5(json_encode($response));
		$data->Dirty = false;
		$data->MemberID = $member->ID;
		$data->write();
		
		return $data;
	}
	
	/*
	 * Check if Subscription valid
	 */
	private function CleanUpSubscription($member, $data, $accessToken, $type, $subscriberId) {
		
		$subscribedDate = new DateTime($data->SubscriptionDate);
		$today = new DateTime();
		
		// Check only once the day the subscription
		if ($subscribedDate->modify('+1 day') < $today) {
			
			$remoteSubscriptions = $this->GetRemoteSubscription($member, $accessToken, $type);
			
			// If empty subscription on remote system, then delete local subscription
			if (empty($remoteSubscriptions['apiSubscriptions'])) {
				
				$data->Subscribed = false;
				$data->SubscriptionDate = null;
				$data->write();
				
				return;
			}
			
			foreach ($remoteSubscriptions['apiSubscriptions'] as $remSub) {
				
				if ($remSub != null && $remSub['collectionType'] == $type) {
						
					// Update data timestamp if subscribed, otherwise delete subscription on remote system and local.
					if ($remSub['subscriptionId'] == $data->ID) {
						
						$data->SubscriptionDate = date('Y-m-d H:i:s');
						$data->write();
					}
					else {
						
						$this->DeleteRemoteSubscription($member, $accessToken, 'activities', $remSub['subscriptionId'], $subscriberId);
						
						$data->Subscribed = false;
						$data->SubscriptionDate = null;
						$data->write();
					}
				}
			}
		}
		
		return;
	}
	
	/*
	 * Create a ressourcen request to firbit api.
	 */
	private function RessourcenRequest($url, $accessToken) {
		
		if (!empty($url) && !empty($accessToken)) {
			
			$request = $this->provider->getAuthenticatedRequest(
					FitBitProvider::METHOD_GET,
					$url,
					$accessToken,
					['headers' => 	[FitBitProvider::HEADER_ACCEPT_LANG => 'de_DE'],
									[FitBitProvider::HEADER_ACCEPT_LOCALE => 'de_DE']]
					);
				
			return $this->provider->getResponse($request);
		}
		
		return null;
	}
	
	/*
	 * Add subscription
	 */
	private function AddRemoteSubscription($member, $accessToken, $collectionpath, $subscriptionId, $subscriberId) {
		
		$url = FitBitProvider::BASE_FITBIT_API_URL.'/1/user/'.$member->FitBitID.'/'.$collectionpath.'/apiSubscriptions/'.$subscriptionId.'.json';
		
		$request = $this->provider->getAuthenticatedRequest(
						FitBitProvider::METHOD_POST,
						$url,
						$accessToken,
						['headers' => [FitBitProvider::HEADER_SUBSCRIBER_ID => $subscriberId]]
					);
		try {
			
			$response = $this->provider->getResponse($request);
		}
		catch (IdentityProviderException $exception) {
			
			SS_Log::log($exception, SS_Log::WARN);
			
			return false;
		}
		
		return true;
	}
	
	/*
	 * Get subscription from user.
	 */
	private function GetRemoteSubscription($member, $accessToken, $collectionpath) {
	
		$url = FitBitProvider::BASE_FITBIT_API_URL.'/1/user/'.$member->FitBitID.'/'.$collectionpath.'/apiSubscriptions.json';
	
		$request = $this->provider->getAuthenticatedRequest(
				FitBitProvider::METHOD_GET,
				$url,
				$accessToken
				);
		try {
			
			$subscription = $this->provider->getResponse($request);
			
			return $subscription;
		}
		catch (IdentityProviderException $exception) {
				
			SS_Log::log($exception, SS_Log::WARN);
		}
		
		return null;
	}
	
	/*
	 * Delete subscription from user
	 */
	private function DeleteRemoteSubscription($member, $accessToken, $collectionpath, $subscriptionId, $subscriberId) {
		
		$url = FitBitProvider::BASE_FITBIT_API_URL.'/1/user/'.$member->FitBitID.'/'.$collectionpath.'/apiSubscriptions/'.$subscriptionId.'.json';
		
		$request = $this->provider->getAuthenticatedRequest(
						FitBitProvider::METHOD_DELETE,
						$url,
						$accessToken,
						['headers' => [FitBitProvider::HEADER_SUBSCRIBER_ID => $subscriberId]]
					);
		try {
			
			$response = $this->provider->getResponse($request);
		}
		catch (IdentityProviderException $exception) {
			
			SS_Log::log($exception, SS_Log::WARN);
			
			return false;
		}
		
		return true;
	}
}