<?php

class SocketRepository {
	
	function __construct() {
		
	}
	
	public function GetIP() {
		
		$data = CanopusHAData::get();
		
		if($data->exists()) {
				
			return $data->first()->IP;
		}
		
		return null;
	}
	
	public function GetPort() {
		
		$data = CanopusHAData::get();
		
		if($data->exists()) {
		
			return $data->first()->SocketPort;
		}
		
		return null;
	}
}