<?php

class HealthAnalyserProfilPage extends Page {
	
	private static $db = array (
		'HealthData_Title'		=> 'Varchar(255)',
		'HealthData_Desc'		=> 'Varchar(255)',
		'HealthImport_Title'	=> 'Varchar(255)',
		'HealthImport_Desc'		=> 'Varchar(255)'
	);

	public function getCMSFields() {
	
		$fields = parent::getCMSFields();
	
		$fields->addFieldToTab("Root.HealthData", new TextField('HealthData_Title', 'Titel'));
		$fields->addFieldToTab("Root.HealthData", new TextField('HealthData_Desc', 'Beschreibung'));
		$fields->addFieldToTab("Root.HealthImport", new TextField('HealthImport_Title', 'Titel'));
		$fields->addFieldToTab("Root.HealthImport", new TextField('HealthImport_Desc', 'Beschreibung'));
	
		return $fields;
	}
}

class HealthAnalyserProfilPage_Controller extends Page_Controller {

	private $service;
	
	public function init() {
		
		$this->service = Injector::inst()->get('HealthService');
		
		parent::init();
	}
	
	static $allowed_actions = array(
			'EditForm',
			'LoginForm',
			'ImportForm'
	);
	
	public function EditForm() {
	
		$tfFirstname = new TextField('FirstName', 'Vorname');
		$tfFirstname->setAttribute('class', 'form-control');
		$tfName = new TextField('Surname', 'Name');
		$tfName->setAttribute('class', 'form-control');
		
		$fields = new FieldList(
				$tfFirstname,
				$tfName
				);
	
		$actionButton = new FormAction('doEdit', 'Speichern');
		$actionButton->useButtonTag = true;
		$actionButton->addExtraClass('btn btn-primary btn-lg');
	
		$actions = new FieldList(
				$actionButton
				);
	
		$validator = new RequiredFields('FirstName', 'Surname');
	
		$form = new Form($this, 'EditForm', $fields, $actions, $validator);
	
		// Set custom template
		//$form->setTemplate('HealthEditForm');
	
		//Populate the form with the current members data
		$Member = Member::currentUser();
		$form->loadDataFrom($Member->data());
		
		return $form;
	}
	
	public function doEdit($data, $form)
	{
		//Check for a logged in member
		if($currentMember = Member::currentUser())
		{
			$form->saveInto($currentMember);
			$currentMember->write();
		}
		
		return $this->redirect($this->Link());
	}
	
	public function LoginForm() {
		
		$efEmail = new EmailField('Email', 'E-Mail');
		$efEmail->addExtraClass('form-control');
		$pfPassword = new PasswordField('Password', 'Passwort');
		$pfPassword->addExtraClass('form-control');
		
		$fields = new FieldList($efEmail, $pfPassword);
		
		$actionButton = new FormAction('doLogin', 'Login');
		$actionButton->useButtonTag = true;
		$actionButton->addExtraClass('btn btn-primary btn-lg');
		
		$actions = new FieldList($actionButton);
		
		$validator = new RequiredFields('Email', 'Password');
		
		$form = new Form($this, 'LoginForm', $fields, $actions, $validator);
		
		// Set custom template
		$form->setTemplate('HealthLoginForm');
		
		return $form;
	}
	
	public function doLogin($data, $form) {
		
		if($member = Member::get_one('Member', array('Email' => $data['Email']))) {
			
			if($result = $member->checkPassword($data['Password'])) {
				
				if($result->valid() == true) {
					
					$member->logIn();
					return $this->redirectBack();
				}
			}
		}

		$form->AddErrorMessage('Password', "Die E-Mail oder Password ist ungueltig.", 'bad');
		
		return $this->redirectBack();
	}

	public function ImportForm() {

		$ffXML = new FileField('XMLFile', 'Apple Health XML File');
		$ffXML->setAllowedExtensions(array('zip'));
		
		$fields = new FieldList($ffXML);
		
		$actionButton = new FormAction('doImport', 'Importieren');
		$actionButton->useButtonTag = true;
		$actionButton->addExtraClass('btn btn-primary btn-lg');
		
		$actions = new FieldList($actionButton);
		
		$validator = new RequiredFields('XMLFile');
		
		$form = new Form($this, 'ImportForm', $fields, $actions, $validator);
		
		// Set custom template
		//$form->setTemplate('HealthSearchForm');
		
		return $form;
	}
	
	public function doImport($data, $form) {
		
		$content = $this->service->readZIP($data['XMLFile']['tmp_name']);
		
		if($content != null) {
			
			$xmlData = new SimpleXMLElement($content);
			
			$csvFile = $this->service->CreateCSVFileForImport($xmlData);
			
			$this->service->LoadDataInFile($csvFile);
		}
		else {
			$form->AddErrorMessage('XMLFile', "Die Datei konnte nicht gelesen werden.", 'bad');
		}
		
		return $this->redirectBack();
	}
	
	public function IsRegistration() {
		return $this->getRequest()->getVar('registration') == '1';
	}
	
	public function IsEdit() {
		return $this->getRequest()->getVar('edit') == '1';
	}
	
	/**
	 * Check if any data imported
	 * @return boolean
	 */
	public function HasHealthData() {
		return $this->service->UserHasData();
	}
	
	public function StepsCount() {
		return $this->service->StepsCount();
	}
	
	public function DistanceCount() {
		return $this->service->DistanceCount();
	}
	
	public function ClimbingCount() {
		return $this->service->ClimbingCount();
	}
	
	public function BodyMassCount() {
		return $this->service->BodyMassCount();
	}
	
	public function HearthRateCount() {
		return $this->service->HearthRateCount();
	}
	
	public function BPSystolicCount() {
		return $this->service->BPSystolicCount();
	}
	
	public function BPDiastolicCount() {
		return $this->service->BPDiastolicCount();
	}
}