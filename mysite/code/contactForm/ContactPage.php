<?php

class ContactPage extends Page
{
	private static $db = array(
		'Mailto' => 'Varchar(100)',
		'SubmitText' => 'HTMLText'
	);
	
	private static $has_many = array(
		"ContactMessage" => "ContactMessage"
	);
	
	public function getCMSFields() 
	{
		$fields = parent::getCMSFields();
	
		$fields->addFieldToTab("Root.E-Mail Optionen", new TextField('Mailto', 'Mail Empfaenger'));	
		$fields->addFieldToTab("Root.E-Mail Optionen", new HTMLEditorField('SubmitText', 'Bestaetigungstext'));
		
		// contact message data relation management
		$config = GridFieldConfig_RelationEditor::create();
		$config->getComponentByType('GridFieldDataColumns')->setDisplayFields(array(
			"Name"	=> "Name",
			"Email"	=> "Email",
			"Phone"	=> "Phone",
			"Company"	=> "Company",
			"Subject"	=> "Subject",
			"Comments"	=> "Comments"
		));
		
		$messageField = new GridField(
				'ContactMessage', // Field name
				'Mitteilungen', // Field title
				$this->ContactMessage(), // List of all related students
				$config
		);
		
        $fields->addFieldToTab('Root.Mitteilungen', $messageField);
	
		return $fields;	
	}

}

class ContactPage_Controller extends Page_Controller
{
	static $allowed_actions = array(
		'ContactForm'
	);
	
	public function ContactForm()
	{			
	    return new ContactForm($this, 'ContactForm');
	}

	public function Success()
	{
		return isset($_REQUEST['success']) && $_REQUEST['success'] == "1";
	}
}