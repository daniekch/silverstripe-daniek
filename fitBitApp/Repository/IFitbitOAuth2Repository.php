<?php

interface IFitBitOAuth2Repository {
	
	/*
	 * Save Accesstoken in a storage
	 */
	public function SaveAccessToken($var);
	
	/*
	 * Get Accesstoken from a storage
	 */
	public function ReadAccessToken();
	
	/*
	 * Clear Accesstoken from storage
	 */
	public function ClearAccessToken();
	
	/*
	 * Save AntiForgeryToken in a storage.
	 */
	public function SaveAntiForgeryToken($var);
	
	/*
	 * Read anti forgery token from storage
	 */
	public function ReadAntiForgeryToken();
	
	/*
	 * Save app URL to storage
	 */
	public function SaveAppURL($var);
	
	/*
	 * Read app URL from storage
	 */
	public function ReadAppURL();
	
	/*
	 * Get Access Token from storage or if expired get a new one with refresh token.
	 */
	public function LoadAccessToken();
	
	/*
	 * Get a new accesstoken from authorization code.
	 */
	public function GetAccessTokenWithAuthCode($var);
}