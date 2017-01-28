<?php

use djchen\OAuth2\Client\Provider\Fitbit;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\BadResponseException;

/**
 * Fitit Service class.
 * 
 * The FitBit Provider provide silverstripe fitbit application with usfull function.
 */
class FitBitProvider extends Fitbit {
    
	const HEADER_SUBSCRIBER_ID = 'X-Fitbit-Subscriber-Id';
	
	const METHOD_DELETE = 'DELETE';
	
	private $config;
    
    function __construct() {
    	
    	parent::__construct();
    	
    	$this->config = Config::inst();
    	
    	$this->clientId = $this->config->get('Client_Data', 'client_id');
    	$this->clientSecret = $this->config->get('Client_Data', 'client_secret');
    	
    	if(Director::isLive()) {
    		$this->redirectUri = $this->config->get('Client_Data', 'redirect_url_live');
    	} else if(Director::isTest()) {
    		$this->redirectUri = $this->config->get('Client_Data', 'redirect_url_test');
    	} else if(Director::isDev()) {
    		$this->redirectUri = $this->config->get('Client_Data', 'redirect_url_dev');
    	}
    }
    
    /*
     * Get scope from modul configuration.
     */
    public function GetScope() {
    	$separator = $this->getScopeSeparator();
    	return implode($separator, $this->config->get('Client_Data', 'scope'));
    }
}