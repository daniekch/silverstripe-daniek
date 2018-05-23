<?php

class TelegramHelper {
	
	public static function Salutation() {

		$hour      = date('H');
		
		if ($hour >= 20) {
			$greetings = "Gute Nacht";
		} elseif ($hour >= 17) {
			$greetings = "Guten Abend";
		} elseif ($hour >= 13) {
			$greetings = "Guten Nachmittag";
		} elseif ($hour >= 11) {
			$greetings = "Guten Mittag";
		} elseif ($hour < 11) {
			$greetings = "Guten Morgen";
		}
		
		return $greetings;
	}

}