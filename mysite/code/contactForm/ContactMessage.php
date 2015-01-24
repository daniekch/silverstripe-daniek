<?php

class ContactMessage extends DataObject {
	
	private static $db = array(
		"Name"			=> "Varchar(200)",
		"Email"			=> "Varchar(200)",
		"Phone"			=> "Varchar(200)",
		"Company"		=> "Varchar(200)",
		"Subject"		=> "Varchar(200)",
		"Comments"		=> "Text"
	);
	
	private static $has_one = array(
		'ContactPage' => 'ContactPage'
	);
}
