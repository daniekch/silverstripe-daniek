<?php

class SharePlaceUploadForm extends Form {

	public function __construct($controller, $name) {

		$typeField = new DropdownField('ShareType', 'Posttyp', singleton('SharePlace')->dbObject('ShareType')->enumValues());
		$typeField->addExtraClass('form-control');
		
		$titleField = new TextField('Title', 'Titel');
		$titleField->addExtraClass('form-control');
		
		$pictureField = new FileField('Picture', 'Bild');
		$pictureField->setAllowedExtensions(array('jpg', 'jpeg', 'png', 'gif'));
		$pictureField->setFolderName('Images/sharePlace');
		$pictureField->addExtraClass('form-control');
		
		
		$commentsField = new TextareaField('Comments', 'Kommentar');
		$commentsField->addExtraClass('form-control');
		$commentsField->setRows('8');
		
		$latField = new HiddenField('Lat');
		$lngField = new HiddenField('Lng');
		$nearBy = new HiddenField('NearBy');
		$nearByIcon = new HiddenField('NearByIcon');

		$fields = new FieldList(
							$typeField,
							$titleField,
							$pictureField,
							$commentsField,
							$latField,
							$lngField,
							$nearBy,
							$nearByIcon
						);

		$actionButton = new FormAction('SendSharePlaceUploadForm', 'Posten', $this);
		$actionButton->useButtonTag = true;
		$actionButton->addExtraClass('btn btn-primary btn-lg');

		$actions = new FieldList(
							$actionButton
						);

		//$validator = new RequiredFields('Name', 'Email', 'Subject', 'Comments');

		parent::__construct($controller, $name, $fields, $actions/*, $validator*/);
	}

	public function SendSharePlaceUploadForm(array $data, Form $form) {

		$sharePlace = new SharePlace();
		
		$form->saveInto($sharePlace);
		$sharePlace->SharePlacePageID = Controller::curr()->ID;
		$id = $sharePlace->write();
		
		if($id)
		{
			$From = 'info@daniek.ch';
			$To = Controller::curr()->Mailto;
			$Subject = "Neuer Lebensmoment auf daniek.ch";
			$email = new Email($From, $To, $Subject);
			
			$email->setTemplate('SharePlaceUploadEmail');
			$email->populateTemplate(array(
					'Title' => $data['Title'],
					'Comments' => $data['Comments']
			));
			
			$email->send();
		}

		Controller::curr()->redirect(Controller::curr()->Link() . "?success=1");
	}

	public function forTemplate() {
		return $this->renderWith(array($this->class, 'SharePlaceUploadForm'));
	}
}