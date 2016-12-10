<?php

/**
 * Registrations page
 */
class RegistrationsPage extends Page {
	
}

/**
 * Registrations page controller
 */
class RegistrationsPage_Controller extends Page_Controller {
	
	static $allowed_actions = array(
		'RegisterForm'
	);
	
	/**
	 * Init controller
	 */
	public function init() {
		
		parent::init();
	}
	
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
		$form->setTemplate('RegistrationsForm');
	
		return $form;
	}
	
	public function doRegister($data, $form) {
	
		// Check for existing member email address
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
		$member = new Member();
		$form->saveInto($member);
		$member->login();
		
		//Find or create the 'user' group
		if(!$userGroup = Group::get_one('Group', array('Code' => 'health-app')))
		{
			$userGroup = new Group();
			$userGroup->Code = "health-app";
			$userGroup->Title = "Health App";
			$userGroup->Write();
			$userGroup->Members()->add($member);
		}
		
		//Add member to user group
		$userGroup->Members()->add($member);
		
		return $this->redirect(Director::absoluteBaseURL().'Security/login?registered=1');
	}
}