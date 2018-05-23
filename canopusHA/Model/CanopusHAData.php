<?php

class CanopusHAData extends DataObject {
	
	private static $db = array(
		'IP'	=> 	'Varchar',
		'SSLPort' => 'Int',
		'SocketPort' => 'Int'
	);
	
}