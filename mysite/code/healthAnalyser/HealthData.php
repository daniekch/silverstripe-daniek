<?php
class HealthData extends DataObject
{
	private static $db = array(
		"EffectiveTimeLow"	=>	"SS_Datetime",
		"EffectiveTimeHigh"	=>	"SS_Datetime"
	);
	
}