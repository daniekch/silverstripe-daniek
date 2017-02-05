<?php

use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;

class FitBitOAuth2Repository implements IFitBitOAuth2Repository {
	
	const ACCESS_TOKEN = "FitBitOAuth_Access_Token";
	const ANTIFORGERY_TOKEN = "FitBitOAuth_AnitForgery_Token";
	const APP_URL = "FitBitOAuth_App_Url";
	
	private $config;
	private $provider;
	
	function __construct() {
			
		$this->config = Config::inst();
		$this->provider = Injector::inst()->create('FitBitProvider');
	}
	
	/*
	 * Save Accesstoken in a storage
	 */
	public function SaveAccessToken($var) {
		
		Session::set(self::ACCESS_TOKEN, serialize($var));
	}
	
	/*
	 * Get Accesstoken from a storage
	 */
	public function ReadAccessToken() {
		
		return unserialize(Session::get(self::ACCESS_TOKEN));
	}
	
	/*
	 * Clear Accesstoken from storage
	 */
	public function ClearAccessToken() {
		
		Session::clear(self::ACCESS_TOKEN);
	}
	
	/*
	 * Save AntiForgeryToken in a storage.
	 */
	public function SaveAntiForgeryToken($var) {
		
		Session::set(self::ANTIFORGERY_TOKEN, $var);
	}
	
	/*
	 * Read anti forgery token from storage
	 */
	public function ReadAntiForgeryToken() {
	
		return Session::get(self::ANTIFORGERY_TOKEN);
	}
	
	/*
	 * Save app URL to storage
	 */
	public function SaveAppURL($var) {
		
		Session::set(self::APP_URL, $var);
	}
	
	/*
	 * Read app URL from storage
	 */
	public function ReadAppURL() {
		
		return Session::get(self::APP_URL);
	}
	
	/*
	 * Get Access Token from storage or if expired get a new one with refresh token.
	 */
	public function LoadAccessToken() {
	
		$existingAccessToken = $this->ReadAccessToken();
		
		if (!empty($existingAccessToken)) {
				
			if ($existingAccessToken->hasExpired()) {
				
				try {
					
					// Renew accessToken and save in local session
					$accessToken = $this->provider->getAccessToken('refresh_token', [
							'refresh_token' => $existingAccessToken->getRefreshToken()
					]);
					
					$this->SaveAccessToken($accessToken);
					
					return $accessToken;
				}
				catch (IdentityProviderException $exception) {
					
					SS_Log::log($exception, SS_Log::WARN);
				}
			}
			else {
	
				return $existingAccessToken;
			}
		}
		
		return null;
	}
	
	/*
	 * Get a new accesstoken from authorization code
	 */
	public function GetAccessTokenWithAuthCode($var) {
		
		return $this->provider->getAccessToken(
					'authorization_code', ['code' => $var]
				);
	}
	
	public function Revoke($accessToken) {
		
		try {
				
			$this->provider->revoke($accessToken);
		}
		catch (IdentityProviderException $exception) {
				
			SS_Log::log($exception, SS_Log::WARN);
			
			return false;
		}
		
		return true;
	}
}