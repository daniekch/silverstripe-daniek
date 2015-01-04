<?php

class StartPage extends Page {

	private static $db = array(
		"Slider_Title_1" => "Text",
		"Slider_Lead_1" => "Text",
		"Slider_Link_1" => "Text"
	);

	private static $has_one = array(
		"Slider_Backround_Image_1" => "Image",
		"Slider_Overlay_Image_1" => "Image"
	);
	
	function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->addFieldToTab("Root.Slider 1", new TextField("Slider_Title_1", "Title"));
		$fields->addFieldToTab("Root.Slider 1", new TextField("Slider_Lead_1", "Lead"));
		$fields->addFieldToTab("Root.Slider 1", new TextField("Slider_Link_1", "Link"));
		$fields->addFieldToTab("Root.Slider 1", new UploadField('Slider_Backround_Image_1', 'Background Image'));
		$fields->addFieldToTab("Root.Slider 1", new UploadField('Slider_Overlay_Image_1', 'Overlay Image'));
		
		return $fields;
	}

}
class StartPage_Controller extends Page_Controller {

	private static $allowed_actions = array (
	);

	public function init() {
		parent::init();
	}
	
	public function Slider() {
		$currentPage = $this->data();
		
		return new ArrayList(array(
        	new ArrayData(array(
        		'Count' => '0',
            	'Title' => $currentPage->Slider_Title_1,
                'Lead' => $currentPage->Slider_Lead_1,
        		'Link' => $currentPage->Slider_Link_1,
        		'BackgroundImage' => File::get()->byID($currentPage->Slider_Backround_Image_1ID),
        		'OverlayImageUrl' => File::get()->byID($currentPage->Slider_Overlay_Image_1ID)
            ))
    	));
	}

}