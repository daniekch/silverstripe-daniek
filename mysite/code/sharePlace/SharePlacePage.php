<?php

class SharePlacePage extends Page
{
	private static $db = array(
		"Limit"		=> "Int"
	);
	
	private static $has_many = array(
		"SharePlace" => "SharePlace"
	);
	
	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
	
		// contact message data relation management
		$config = GridFieldConfig_RelationEditor::create();
		$config->getComponentByType('GridFieldDataColumns')->setDisplayFields(array(
				"Title"		=> "Title",
				"Comments"	=> "Comments"
		));
	
		$placeField = new GridField(
				'SharePlace',
				'geteilte Orte',
				$this->SharePlace(),
				$config
				);
	
		$fields->addFieldToTab('Root.Orte', $placeField);
	
		return $fields;
	}
}

class SharePlacePage_Controller extends Page_Controller {
	
	private static $allowed_actions = array(
		'getSharedPlaces'
	);
	
	public function init() {
		parent::init();
	
	}
	
	public function getSharedPlaces($limit = 10, $offset = 0)	{
		
		$places = $this->SharePlace()->sort('Created', 'DESC')->limit($limit, $offset);
		
		$arrayData = new ArrayData(array(
			'SharePlaces' => $places
		));
		
		return $this->renderWith("SharePlace", $arrayData);
	}
}