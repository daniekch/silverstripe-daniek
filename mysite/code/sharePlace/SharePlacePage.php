<?php

class SharePlacePage extends Page
{
	private static $db = array(
		'Limit'		=> 'Int',
		'Mailto' => 'Varchar(100)'
	);
	
	private static $has_many = array(
		'SharePlace' => 'SharePlace'
	);
	
	private static $defaults = array(
		'Limit' => 10
	);
	
	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		
		$fields->addFieldToTab("Root.Configuration", new TextField('Limit', 'Anzahl Orte'));
		$fields->addFieldToTab("Root.Configuration", new TextField('Mailto', 'E-Mail bei neuen Posts'));
		
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
		'getsharedplaces',
		'SharePlaceUploadForm'
	);
	
	public function init() {
		parent::init();
	
	}
	
	public function ShowUploadForm()
	{
		return $this->request->getVar('form') && $this->request->getVar('form') == 'upload';
	}
	
	public function SharePlaceUploadForm()
	{
		return new SharePlaceUploadForm($this, 'SharePlaceUploadForm');
	}
	
	public function getsharedplaces(SS_HTTPRequest $request)
	{		
		$limit = $this->Limit;
		$offset = 0;
		
		if($request->param('ID'))
		{
			$offset = $request->param('ID');
		}
		
		$places = $this->SharePlace()->sort('Created', 'DESC');
		$nextOffset = $offset + $limit;
		$ShowMoreLink = $places->limit($limit, $nextOffset);
		
		$arrayData = new ArrayData(array(
			'SharePlaces' 	=> $places->limit($limit, $offset),
			'ShowMoreLink' 	=> $ShowMoreLink->Count() > 0,
			'MoreLink'		=> $this->Link('getsharedplaces').'/'.$nextOffset
		));
		
		return $this->renderWith("SharePlace", $arrayData);
	}
}