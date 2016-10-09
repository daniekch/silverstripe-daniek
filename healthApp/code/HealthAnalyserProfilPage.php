<?php

class HealthAnalyserProfilPage extends Page {

}

class HealthAnalyserProfilPage_Controller extends Page_Controller {

	public function init() {
		parent::init();
	}
	
	static $allowed_actions = array(
			'RegisterForm',
			'EditForm',
			'LoginForm',
			'ImportForm'
	);
	
	public function RegisterForm() {
		
		$tfFirstname = new TextField('FirstName', 'Vorname');
		$tfFirstname->setAttribute('class', 'form-control');
		$tfName = new TextField('Surname', 'Name');
		$tfName->setAttribute('class', 'form-control');
		$efEmail = new EmailField('Email', 'E-Mail');
		$efEmail->setAttribute('class', 'form-control');
		$cpfPassword = new ConfirmedPasswordField('Password', 'Passwort');
		$cpfPassword->getChildren()->fieldByName('Password[_Password]')->setAttribute('class', 'form-control');
		$cpfPassword->getChildren()->fieldByName('Password[_ConfirmPassword]')->setAttribute('class', 'form-control');
		
		
		$cpfPassword->minLength = 7;
		$cpfPassword->canBeEmpty = false;
		$fields = new FieldList(
				$tfFirstname,
				$tfName,
				$efEmail,
				$cpfPassword
				);
		
		$actionButton = new FormAction('doRegister', 'Registrieren');
		$actionButton->useButtonTag = true;
		$actionButton->addExtraClass('btn btn-primary btn-lg');
		
		$actions = new FieldList(
				$actionButton
				);
		
		$validator = new RequiredFields('FirstName', 'Surname', 'Email', 'Password');
		
		$form = new Form($this, 'RegisterForm', $fields, $actions, $validator);
		
		// Set custom template
		$form->setTemplate('HealthRegistrationForm');
		
		return $form;
	}
	
	public function doRegister($data, $form) {
		
		//Check for existing member email address
		
		if($member = Member::get_one('Member', array('Email' => $data['Email'])))
		{
			//Set error message
			$form->AddErrorMessage('Email', "Die E-Mail Adresse ist bereits vergeben. Bitte geben sie eine andere E-Mail ein.", 'bad');
			//Set form data from submitted values
			Session::set("FormInfo.Form_RegisterForm.data", $data);
			//Return back to form
			return $this->redirectBack();;
		}
		
		//Otherwise create new member and log them in
		$Member = new Member();
		$form->saveInto($Member);
		$Member->write();
		$Member->login();
		 
		//Find or create the 'user' group
		if(!$userGroup = Group::get_one('Group', array('Code' => 'HealthAnalyserAppUsers')))
		{
			$userGroup = new Group();
			$userGroup->Code = "HealthAnalyserAppUsers";
			$userGroup->Title = "Health Analyser App Users";
			$userGroup->Write();
			$userGroup->Members()->add($Member);
		}
		//Add member to user group
		$userGroup->Members()->add($Member);
		 
		return $this->redirectBack();
	}
	
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
		
		$group = DataObject::get_one('Group', array('Code' => 'HealthAnalyserAppUsers'));
		if(Member::currentUser() && Member::currentUser()->inGroup($group->ID)){

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
	}
	
	public function doImport($data, $form) {
		
		$content = HealthImporter::readZIP($data['XMLFile']['tmp_name']);
		
		if($content != null) {
			
			$healthData = new SimpleXMLElement($content);
	
			$healthDataList = new ArrayList();
	
			foreach ($healthData->Record as $record) {
				
				$healthDataList->add(HealthImporter::CreateHealthDataObject($record));
			}
			
			$csvFile = HealthImporter::CreateCSVFile($healthDataList, true);
			HealthImporter::LoadDataInFile($csvFile);
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

	public function WeightCount() {
		return 0;
	}
	
	public function BloodPresureCount() {
		return Health_Data::get()->filter(array('Type' => HealthImporter::XML_BPDIASTOLIC_TYPE, 'MemberID' => Member::currentUserID()))->count();
	}
	
	public function HearthRateCount() {
		return Health_Data::get()->filter(array('Type' => HealthImporter::XML_HEARTRATE_TYPE, 'MemberID' => Member::currentUserID()))->count();
	}
}