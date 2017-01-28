<?php

use djchen\OAuth2\Client\Provider\Fitbit;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;

/**
 * Fitit Service class.
 *
 * The FitBit Service layer provide silverstripe fitbit application with usfull function.
 */
class FitBitService implements IFitBitService {
	
	private $provider;
	private $ressourcenRepository;
	private $oAuth2Repository;
	
	function __construct() {
		 
		$this->provider = Injector::inst()->create('FitBitProvider');
		$this->ressourcenRepository = Injector::inst()->create('IFitBitRessourcenRepository');
		$this->oAuth2Repository = Injector::inst()->create('IFitBitOAuth2Repository');
	}
	
	/*
	 * Exchangeg authorization code to a access token.
	 */
	public function ExchangeAuthorizationToken($code) {
		
		try {
			
			$accessToken = 	$this->oAuth2Repository->GetAccessTokenWithAuthCode($code);
			$this->oAuth2Repository->SaveAccessToken($accessToken);
		}
		catch (IdentityProviderException $exception) {
			
			SS_Log::log($exception, SS_Log::WARN);
			
			return false;
		}
		
		return true;
	}
	
	/*
	 * Redirect client to authorization page from fitbit
	 */
	public function RedirectToAuthorization() {
		
		// Delete current accessToken
		$this->oAuth2Repository->ClearAccessToken();
		
		// Generate authorization url with fitbit scope
		$options['scope'] = $this->provider->GetScope();
		$url = $this->provider->getAuthorizationUrl($options);
		
		// Save Anti Forgery Token
		$state = $this->provider->getState();
		$this->oAuth2Repository->SaveAntiForgeryToken($state);
		
		// Save URL on which we come back after authorization
		$appURL = Controller::curr()->Link();
		$this->oAuth2Repository->SaveAppURL($appURL);
		
		// Redirect to Authorization page
		return Controller::curr()->redirect($url);
	}
}