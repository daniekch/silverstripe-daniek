<?php

class ContactForm extends Form {
	
	public function __construct($controller, $name) {
		
		$nameField = new TextField('Name', 'Name *');
		$nameField->addExtraClass('form-control');
		$emailField = new EmailField('Email', 'Email *');
		$emailField->addExtraClass('form-control');
		$phoneField = new TextField('Phone', 'Telefon');
		$phoneField->addExtraClass('form-control');
		$companyField = new TextField('Company', 'Firma');
		$companyField->addExtraClass('form-control');
		$subjectField = new TextField('Subject', 'Betreff *');
		$subjectField->addExtraClass('form-control');
		$commentsField = new TextareaField('Comments','Mitteilung *');
		$commentsField->addExtraClass('form-control');
		$commentsField->setRows('8');
		
		$fields = new FieldList(
		    $nameField,
			$emailField,
			$phoneField,
			$companyField,
	    	$subjectField,
			$commentsField
		);
		
		$actionButton = new FormAction('SendContactForm', 'Senden', $this);
		$actionButton->useButtonTag = true;
		$actionButton->addExtraClass('btn btn-primary btn-lg');
		
		$actions = new FieldList(
			$actionButton
		);
		
		$validator = new RequiredFields('Name', 'Email', 'Subject', 'Comments');
		
		parent::__construct($controller, $name, $fields, $actions, $validator);
	}
	
	public function SendContactForm(array $data, Form $form) {
	
		$From = $data['Email'];
		$To = Controller::curr()->Mailto;
		$Subject = "Kontaktanfrage Daniek.ch: ".$data['Subject'];
		$email = new Email($From, $To, $Subject);
	
		$email->setTemplate('ContactEmail');
		$email->populateTemplate(array(
			'Name' => $data['Name'],
			'Email' => $data['Email'],
			'Phone' => $data['Phone'],
			'Company' => $data['Company'],
			'Subject' => $data['Subject'],
			'Comments' => $data['Comments']
		));
		$email->send();
		
		$contactMessage = new ContactMessage();
		$form->saveInto($contactMessage);
		$contactMessage->ContactPageID = Controller::curr()->ID;
		$contactMessage->write();
		
		Controller::curr()->redirect(Controller::curr()->Link() . "?success=1");
	}
	
	public function forTemplate() {
		return $this->renderWith(array($this->class, 'ContactForm'));
	}
}