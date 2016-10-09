<?php
class Health_Data extends DataObject
{
	private static $db = array(
		"Type"	=>	"varchar(255)",
		"StartDate"	=>	"SS_Datetime",
		"EndDate"	=>	"SS_Datetime",
		"Value"		=>	"Decimal",
		"Adjusted"	=>	"boolean"
	);
	
	private static $has_one = array(
		"Member" => "Member"
	);
	
}