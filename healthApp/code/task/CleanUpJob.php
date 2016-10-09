<?php

class CleanUpTask extends BuildTask  {
	
	protected $title = 'Bereinigung Health Daten';
	
	protected $description = 'Bereinigen und Zusammenfuehren von Health Daten';
	
	public function run($request) {

		increase_time_limit_to(3600);
		increase_memory_limit_to('512M');
		
		$result = HealthImporter::CleanUpHealthData();
			
		exit('Anzahl gespeicherte Daten: '.$result['Saved'].' Anzahl geloeschte Daten: '.$result['Deleted']);
	}
}