<?php

class SocketService {
	
	private $config;
	
	private $host;
	private $port;
	private $useSsl;
	private $certPath;
	private $pkPath;
	private $salt;
	
	function __construct() {
		
		$this->config = Config::inst();
		$this->socketRepo = new SocketRepository();
		
		$this->host = $this->socketRepo->GetIP();
		$this->port = $this->config->get('CanopusHA_CIS', 'Port');
		$this->useSsl = $this->config->get('CanopusHA_CIS', 'useSSL');
		$this->certPath = $this->config->get('CanopusHA_CIS', 'client_cert_path');
		$this->pkPath = $this->config->get('CanopusHA_CIS', 'client_pk_path');
		$this->salt = $this->config->get('CanopusHA_CIS', 'data_salt');
	}
	
	public function sendData($data) {
		
		$socket = new Socket($this->host, $this->port, $this->useSsl, $this->certPath, $this->pkPath);
		
		$socket->send_data($data, $this->salt);
		$response = $socket->read_data(1024);
		
		$socket->close_socket();
		
		return $response;
	}
}