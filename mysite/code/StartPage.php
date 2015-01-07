<?php

class StartPage extends Page {

	private static $db = array(
		"Slider_Title_1" => "Text",
		"Slider_Lead_1" => "Text",
		"Slider_Link_1" => "Text",
		"Slider_Title_2" => "Text",
		"Slider_Lead_2" => "Text",
		"Slider_Link_2" => "Text",
		"Slider_Title_3" => "Text",
		"Slider_Lead_3" => "Text",
		"Slider_Link_3" => "Text"
	);

	private static $has_one = array(
		"Slider_Backround_Image_1" => "Image",
		"Slider_Overlay_Image_1" => "Image",
		"Slider_Backround_Image_2" => "Image",
		"Slider_Overlay_Image_2" => "Image",
		"Slider_Backround_Image_3" => "Image",
		"Slider_Overlay_Image_3" => "Image"
	);
	
	function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$fields->addFieldToTab("Root.Slider Item 1", new TextField("Slider_Title_1", "Title"));
		$fields->addFieldToTab("Root.Slider Item 1", new TextField("Slider_Lead_1", "Lead"));
		$fields->addFieldToTab("Root.Slider Item 1", new TextField("Slider_Link_1", "Link"));
		$fields->addFieldToTab("Root.Slider Item 1", new UploadField('Slider_Backround_Image_1', 'Background Image'));
		$fields->addFieldToTab("Root.Slider Item 1", new UploadField('Slider_Overlay_Image_1', 'Overlay Image'));
		
		$fields->addFieldToTab("Root.Slider Item 2", new TextField("Slider_Title_2", "Title"));
		$fields->addFieldToTab("Root.Slider Item 2", new TextField("Slider_Lead_2", "Lead"));
		$fields->addFieldToTab("Root.Slider Item 2", new TextField("Slider_Link_2", "Link"));
		$fields->addFieldToTab("Root.Slider Item 2", new UploadField('Slider_Backround_Image_2', 'Background Image'));
		$fields->addFieldToTab("Root.Slider Item 2", new UploadField('Slider_Overlay_Image_2', 'Overlay Image'));
		
		$fields->addFieldToTab("Root.Slider Item 3", new TextField("Slider_Title_3", "Title"));
		$fields->addFieldToTab("Root.Slider Item 3", new TextField("Slider_Lead_3", "Lead"));
		$fields->addFieldToTab("Root.Slider Item 3", new TextField("Slider_Link_3", "Link"));
		$fields->addFieldToTab("Root.Slider Item 3", new UploadField('Slider_Backround_Image_3', 'Background Image'));
		$fields->addFieldToTab("Root.Slider Item 3", new UploadField('Slider_Overlay_Image_3', 'Overlay Image'));
		
		
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
        		'OverlayImage' => File::get()->byID($currentPage->Slider_Overlay_Image_1ID)
            )),
			new ArrayData(array(
					'Count' => '1',
					'Title' => $currentPage->Slider_Title_2,
					'Lead' => $currentPage->Slider_Lead_2,
					'Link' => $currentPage->Slider_Link_2,
					'BackgroundImage' => File::get()->byID($currentPage->Slider_Backround_Image_2ID),
					'OverlayImage' => File::get()->byID($currentPage->Slider_Overlay_Image_2ID)
			)),
			new ArrayData(array(
					'Count' => '2',
					'Title' => $currentPage->Slider_Title_3,
					'Lead' => $currentPage->Slider_Lead_3,
					'Link' => $currentPage->Slider_Link_3,
					'BackgroundImage' => File::get()->byID($currentPage->Slider_Backround_Image_3ID),
					'OverlayImage' => File::get()->byID($currentPage->Slider_Overlay_Image_3ID)
			))
    	));
	}

}