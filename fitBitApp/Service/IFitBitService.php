<?php

/**
 * Fitit Service interface
 *
 * The FitBit Service layer provide silverstripe fitbit application with usfull function.
 */
interface IFitBitService {
	
	/*
	 * Exchangeg authorization code to a access token.
	 */
	public function ExchangeAuthorizationToken($code);
	
	/*
	 * Redirect client to authorization page from fitbit
	 */
	public function RedirectToAuthorization();
}