<?php

class FitBitData extends DataObject {
	
	private static $db = array(
		'JSON' 				=> 	'Text',
		'Hash' 				=> 	'Varchar',
		'Dirty'				=> 	'Boolean',
		'Subscribed'		=>	'Boolean',
		'SubscriptionDate'	=>	'SS_Datetime'
	);
	
	private static $has_one = array(
		'Member'		=>	'FitBitMember'
	);
}