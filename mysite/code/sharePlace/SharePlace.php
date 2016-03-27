<?php

class SharePlace extends DataObject
{
	private static $db = array(
		"Title"		=> "Varchar(200)",
		"Comments"	=> "Text",
		"ShareType"	=> "Enum('Picture,Location,Text', 'Picture')",
		'Lat' 		=> 'Varchar(20)',
		'Lng' 		=> 'Varchar(20)',
		'NearBy'	=> 'Varchar(200)',
		'NearBy_Icon' => 'Varchar(200)'
	);
	
	private static $has_one = array(
		'Picture' => 'Image',
		'SharePlacePage' => 'SharePlacePage'
	);
	
	/*public function getCMSFields() {
		$fields = parent::getCMSFields();
	
		if($this->ID) {
	
		}
	
		return $fields;
	}*/
}