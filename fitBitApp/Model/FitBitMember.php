<?php

class FitBitMember extends Member {
	
	private static $db = array(
		'FitBitID' => 'Varchar'
	);
	
	private static $has_one = array(
		'UserProfil'	=> 'FitBitData',
		'Activities'	=> 'FitBitData',
		'Devices'		=> 'FitBitData'
	);
}