<?php

class FitBitController extends Controller {
	
	private $config;
	
	private $service;
	private $provider;
	private $ressourcenRepository;
	private $oAuth2Repository;

	private static $allowed_actions = array(
			'Authorization',
			'Revoke',
			'Notification'
	);
	
	public function init() {
		
		$this->config = Config::inst();
		$this->service = Injector::inst()->create('IFitBitService');
		$this->provider = Injector::inst()->create('FitBitProvider');
		$this->ressourcenRepository = Injector::inst()->create('IFitBitRessourcenRepository');
		$this->oAuth2Repository = Injector::inst()->create('IFitBitOAuth2Repository');
		
		parent::init();
	}
	
	/*
	 * Callback methode from FirBit Authorization Page
	 * exchange Code to access token and redirect to App
	 */
	public function Authorization(SS_HTTPRequest $request) {
		
		$backURL = $this->oAuth2Repository->ReadAppURL();
		$savedState = $this->oAuth2Repository->ReadAntiForgeryToken();
		$code = $request->getVar('code');
		$state = $request->getVar('state');
		$error = $request->getVar('error_description');
		
		if (empty($error) && !empty($code) && $savedState == $state) {
			
			// Change Authorization Code to an Access Code
			if ($this->service->ExchangeAuthorizationToken($code)) {
				
				return $this->redirect($backURL);
			}
		}
		
		return $this->redirect($backURL."?authorization=error");
	}
	
	/*
	 * Revoke a current fitbit access token.
	 */
	public function Revoke(SS_HTTPRequest $request) {
		
		$accessToken = $this->oAuth2Repository->ReadAccessToken();
		$backURL = $request->getVar('backURL');
		
		if (!empty($accessToken)) {
			
			// Revoke accesstoken
			$this->oAuth2Repository->Revoke($accessToken);
			
			// Delete current accessToken in local store
			$this->oAuth2Repository->ClearAccessToken();
		}
		
		return $this->redirect($backURL);
	}
	
	/*
	 * Subscriber Endpoint to receive notification from fitbit
	 */
	public function Notification(SS_HTTPRequest $request) {
		
		// Receive GET Request from fitbit
		if($request->httpMethod() == 'GET') {
			
			// Verify notification endpoint and compare verificationcode
			if ($this->CheckVerififcationCode($request)) {
				
				// OK
				$this->response->setStatusCode(204);
			}
			else {
				
				// Not OK
				$this->response->setStatusCode(404);
			}
		}
		
		// Receive POST requests
		elseif ($request->httpMethod() == 'POST') {
			
			// Verify FitBit request Signature
			if ($this->VerifySignature($request)) {
				
				$collection = json_decode($request->getBody(), true);
				
				foreach ($collection as $entry) {
					
					// Mark record as dirty
					$id = $this->ressourcenRepository->MarkAsDirty($entry['subscriptionId']);
					
					if (intval($id) > 0) {
						
						SS_Log::log('Write recorde to dirty with subscription ID '.$id, SS_Log::INFO);
					}
				}
				
				$this->response->setStatusCode(204);
			}
			else {
				
				SS_Log::log('Subscription Notification - Signature is not valid from IP '.$request->getIP(), SS_Log::WARN);
				
				// Forbidden. If not correct FitBit Request signature.
				$this->response->setStatusCode(403);
			}
		}
		else {
			
			// Methode not allowed. All other as GET or POST.
			$this->response->addHeader('Allow', 'GET, POST');
			$this->response->setStatusCode(405);
		}
		
		return $this->response;
	}
	
	/*
	 * Verify Signature in fitbit POST-Request header.
	 */
	private function VerifySignature($request) {
		
		$expectedSignature = base64_encode(hash_hmac("sha1", $request->getBody(), $this->config->get('Client_Data', 'client_secret')."&", true));
		$signature = $request->getHeader("X-Fitbit-Signature");
		
		if ($signature == $expectedSignature) {
			
			return true;
		}
		
		return false;
	}
	
	/*
	 * Verify GET request by verify parameter
	 */
	private function CheckVerififcationCode($request) {
		
		$verify = $request->getVar('verify');
			
		if (!empty($verify)) {
				
			$verification = $this->config->get('Subscriber', 'verififcation_code');
				
			if ($verify == $verification) {
				
				return true;
			}
		}
		
		return false;
	}
}