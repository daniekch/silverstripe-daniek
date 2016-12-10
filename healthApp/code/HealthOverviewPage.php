<?php

class HealthOverviewPage extends Page {

	private static $db = array(
		'FeatureTitle1'	=> 'Varchar(255)',
		'FeatureDesc1'	=> 'Varchar(255)',
		'FeatureIcon1'	=> 'Varchar(255)',
		'FeatureTitle2'	=> 'Varchar(255)',
		'FeatureDesc2'	=> 'Varchar(255)',
		'FeatureIcon2'	=> 'Varchar(255)',
		'FeatureTitle3'	=> 'Varchar(255)',
		'FeatureDesc3'	=> 'Varchar(255)',
		'FeatureIcon3'	=> 'Varchar(255)',
		'FeatureTitle4'	=> 'Varchar(255)',
		'FeatureDesc4'	=> 'Varchar(255)',
		'FeatureIcon4'	=> 'Varchar(255)',
		'FeatureTitle5'	=> 'Varchar(255)',
		'FeatureDesc5'	=> 'Varchar(255)',
		'FeatureIcon5'	=> 'Varchar(255)',
		'FeatureTitle6'	=> 'Varchar(255)',
		'FeatureDesc6'	=> 'Varchar(255)',
		'FeatureIcon6'	=> 'Varchar(255)'
	);
	
	public function getCMSFields()
	{
		$iconSource = array(
				'' 					=> 'Please select...',
				'fa-bullhorn' 		=> 'Horn',
				'fa-comments' 		=> 'Kommentar',
				'fa-cloud-download' => 'Download',
				'fa-leaf' 			=> 'Blatt',
				'fa-cogs' 			=> 'Einstellungen',
				'fa-heart' 			=> 'Herz');
		
		$fields = parent::getCMSFields();
	
		$fields->addFieldToTab("Root.Feature 1", new TextField('FeatureTitle1', 'Titel'));
		$fields->addFieldToTab("Root.Feature 1", new TextField('FeatureDesc1', 'Beschreibung'));
		$fields->addFieldToTab("Root.Feature 1", new DropdownField("FeatureIcon1", "Icon", $iconSource));
		$fields->addFieldToTab("Root.Feature 2", new TextField('FeatureTitle2', 'Titel'));
		$fields->addFieldToTab("Root.Feature 2", new TextField('FeatureDesc2', 'Beschreibung'));
		$fields->addFieldToTab("Root.Feature 2", new DropdownField("FeatureIcon2", "Icon", $iconSource));
		$fields->addFieldToTab("Root.Feature 3", new TextField('FeatureTitle3', 'Titel'));
		$fields->addFieldToTab("Root.Feature 3", new TextField('FeatureDesc3', 'Beschreibung'));
		$fields->addFieldToTab("Root.Feature 3", new DropdownField("FeatureIcon3", "Icon", $iconSource));
		$fields->addFieldToTab("Root.Feature 4", new TextField('FeatureTitle4', 'Titel'));
		$fields->addFieldToTab("Root.Feature 4", new TextField('FeatureDesc4', 'Beschreibung'));
		$fields->addFieldToTab("Root.Feature 4", new DropdownField("FeatureIcon4", "Icon", $iconSource));
		$fields->addFieldToTab("Root.Feature 5", new TextField('FeatureTitle5', 'Titel'));
		$fields->addFieldToTab("Root.Feature 5", new TextField('FeatureDesc5', 'Beschreibung'));
		$fields->addFieldToTab("Root.Feature 5", new DropdownField("FeatureIcon5", "Icon", $iconSource));
		$fields->addFieldToTab("Root.Feature 6", new TextField('FeatureTitle6', 'Titel'));
		$fields->addFieldToTab("Root.Feature 6", new TextField('FeatureDesc6', 'Beschreibung'));
		$fields->addFieldToTab("Root.Feature 6", new DropdownField("FeatureIcon6", "Icon", $iconSource));
		
		return $fields;
	}
}

class HealthOverviewPage_Controller extends Page_Controller {
	
	private $service;

	static $allowed_actions = array(
			'ZIPImportForm'
	);
	
	public function init() {
		
		$this->service = Injector::inst()->get('HealthService');
		
		parent::init();
	}
	
	/**
	 * Generate form for converter
	 * @return Form
	 */
	public function ZIPImportForm() {
	
		$ffXML = new FileField('ZIPFile', '');
		$ffXML->setAllowedExtensions(array('zip'));
			
		$fields = new FieldList($ffXML);
			
		$actionButton = new FormAction('doZIPImport', 'Konvertieren');
		$actionButton->useButtonTag = true;
		$actionButton->addExtraClass('btn btn-primary btn-lg');
			
		$actions = new FieldList($actionButton);
			
		$validator = new RequiredFields('ZIPFile');
			
		$form = new Form($this, 'ZIPImportForm', $fields, $actions, $validator);
			
		// Set custom template
		//$form->setTemplate('HealthSearchForm');
			
		return $form;
	}
	
	/**
	 * Action methode from converter form
	 * 
	 * @param object $data
	 * @param object $form
	 * @throws Exception
	 * @return SS_HTTPResponse|boolean|SS_HTTPResponse
	 */
	public function doZIPImport($data, $form) {
		
		try {
			$content = $this->service->readZIP($data['ZIPFile']['tmp_name']);
			
			if($content != null) {
				
				$xmlData = new SimpleXMLElement($content);
					
				$csvFile = $this->service->CreateCSVFile($xmlData);
				$metaDatas = stream_get_meta_data($csvFile);
				
				$response = new SS_HTTPResponse();
				$response->setBody(file_get_contents($metaDatas['uri']));
				$response->addHeader("Content-disposition","attachment; filename=export.csv");
				
				return $response;
			}
			else {
				throw new Exception("Die Datei konnte nicht gelesen werden.");
			}
		}
		catch(Exception $e) {
			$form->AddErrorMessage('ZIPFile', $e->getMessage(), 'bad');
		}

		return $this->redirectBack();
	}
	
	/**
	 * Generate Link to Subpage where type HelthAnalysPage
	 * @return Link or NULL
	 */
	public function LinkToHealthAnalyser() {
		
		if($children = $this->Children()) {
			
			$page = $children->filterByCallback(function ($item, $list) { return $item->getClassName() == 'HealthAnalyserPage';});
			
			if ($page->exists()) {
				return $page->first()->Link();
			}
		}
		
		return null;
	}
}