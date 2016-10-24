<?php

class CleanUpTask extends BuildTask  {
	
	protected $title = 'Zusammenfuehren der Health Daten';
	
	protected $description = 'Health Daten wie Schritt, Strecke und Stockwerke werden pro Tag in ein Datensatz zusammengefuehrt.';
	
	public function run($request) {

		increase_time_limit_to(3600);
		increase_memory_limit_to('512M');
		
		$result = HealthImporter::MergeHealthData();
			
		exit('Anzahl gespeicherte Daten: '.$result['Saved'].' Anzahl geloeschte Daten: '.$result['Deleted']);
	}
}