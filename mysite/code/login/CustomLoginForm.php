<?php

class CustomLoginForm extends MemberLoginForm 
{
	protected $template = 'CustomLoginForm';
	
	public function __construct($controller, $name, $fields = null, $actions = null, $checkCurrentUser = true) {

		if($checkCurrentUser && Member::currentUser() && Member::logged_in_session_exists()) {
			$controller->redirect(Controller::curr()->redirect(Director::baseURL()));
		}
		else {
			$label=singleton('Member')->fieldLabel(Member::config()->unique_identifier_field);
			$emailValue = Session::get('SessionForms.MemberLoginForm.Email');
			$emailField = new TextField("Email", $label, $emailValue, null, $this);
			$emailField->addExtraClass('form-control');
			$passwordField = new PasswordField("Password", _t('Member.PASSWORD', 'Password'));
			$passwordField->addExtraClass('form-control');
			
			$fields = new FieldList(array(
				new HiddenField("AuthenticationMethod", null, $this->authenticator_class, $this),
				$emailField,
				$passwordField
			));
			
			$loginAction = new FormAction('dologin', _t('Member.BUTTONLOGIN', "Log in"));
			$loginAction->useButtonTag = true;
			$loginAction->addExtraClass('btn btn-primary btn-lg');
			$actions = new FieldList(
				$loginAction
			);
		}

		parent::__construct($controller, $name, $fields, $actions);
	}
	
    public function dologin($data) {
    	
    	$movescountGroup = DataObject::get_by_id("Group", 3);
    	$member = $this->performLogin($data);
    	
    	if($member && $member->inGroup($movescountGroup->ID)) {
    		$this->LoginByMovesCount($data);
    	}
    	
    	parent::dologin($data);
    }
    
    public function logout() {
    	Session::clear('SessionForms.MemberLoginForm.Email');
    	parent::logout();
    }
    
    public function LoginByMovesCount($data)
    {
    	return true;
    }
}