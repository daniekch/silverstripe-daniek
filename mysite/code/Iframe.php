<?php

class Iframe extends Page {
	
	private static $db = array(
		"Url" => "Varchar(255)",
		"Width" => "Varchar",
		"Height" => "Varchar",
		"Border" => "Enum('0, 1', '0')",
		"Scrolling" => "Enum('no, yes', 'no')"
	);
	
	public function getCMSFields() {
		
		$fields = parent::getCMSFields();
		$fields->addFieldToTab("Root.Main", new TextField("Url", "Url"));
		$fields->addFieldToTab("Root.Main", new TextField("Width", "Width"));
		$fields->addFieldToTab("Root.Main", new TextField("Height", "Height"));
		$fields->addFieldToTab("Root.Main", new DropdownField("Border", "Border", $this->dbObject("Border")->enumValues()));
		$fields->addFieldToTab("Root.Main", new DropdownField("Scrolling", "Scrolling", $this->dbObject("Scrolling")->enumValues()));
		$fields->removeFieldFromTab("Root.Main","Content");
		return $fields;
	}
}

class Iframe_Controller extends Page_Controller {

	function init() {
		parent::init();
	}
}