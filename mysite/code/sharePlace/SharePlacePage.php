<?php

class SharePlacePage extends Page
{
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

class SharePage_Controller extends Page_Controller {
	
	public function init() {
		parent::init();
	
	}
}