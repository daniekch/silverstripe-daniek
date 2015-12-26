<?php

class SharePlace extends DataObject
{
	private static $db = array(
		"Title"		=> "Varchar(200)",
		"Comments"	=> "Text",
		"ShareType"	=> "Enum('Picture,Location', 'Picture')",
		'Lat' 		=> 'Varchar(20)',
		'Lng' 		=> 'Varchar(20)'
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