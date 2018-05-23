<?php

class Socket {
   
	private $socket;
	
	/**
	 * Create a client socket
	 * 
	 */
	public function __construct($host, $port, $useSsl = false, $certPath = null, $pkPath = null, $timeout = 30) {
		
		$opts = null;
		$protocol = 'tcp';
		
		// Create SSL context
		if ($useSsl) {
			
			$protocol = 'ssl';
			
			$opts = array(
					'ssl' => array(
							'local_cert' 		=> $certPath,
							'local_pk'			=> $pkPath,
							'allow_self_signed' => true,
							'peer_name'			=> 'CanopusHA'
					)
				);
		}
		
		$adr = $protocol . '://' . $host . ':' . $port;
		$ctx = stream_context_create($opts);
		
		$this->socket = stream_socket_client($adr, $errno, $errstr, $timeout, STREAM_CLIENT_CONNECT, $ctx);
	}

	/**
	 * Send data with hashstring to server
	 */
	public function send_data($content, $salt) {
		
		if ($salt != '') {
			$content = hash('sha256', $salt.$content).'::'.$content;
		}
		
		return fwrite($this->socket, $content, strlen($content));
	}
	
	/**
	 * Read data from server socket.
	 * 
	 */
	public function read_data($lenght) {
		
		return fread($this->socket, $lenght);
	}
	
	/**
	 * Close socket after work.
	 */
	public function close_socket() {
		
		return fclose($this->socket);
	}
}