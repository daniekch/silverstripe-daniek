<?php

class CommentControllerExtension extends Extension {
    
	public function alterCommentForm($form) {
		$form->setTemplate('Corlate_CommentForm');
		
		$fields = $form->VisibleFields();
		
		$fields->removeByName('URL');
		
        foreach($form->VisibleFields() as $field) {
        	$field->setFieldHolderTemplate('Corlate_CommentCompositeField');  
            foreach($field->FieldList() as $inputField) {
            	$inputField->setAttribute('class', 'form-control');
            	//Debug::show($inputField->getName());
            	if($inputField->getName() == 'Name') {
            		$inputField->setTitle("Name");
            	}
            	else if($inputField->getName() == 'Email') {
            		$inputField->setTitle("E-Mail (wird nicht publiziert)");
            	}
            	else if ($inputField->getName() == 'Comment') {
            		$inputField->setTitle("Kommentar");
            	}
            }
        }
        
        foreach($form->Actions() as $action) {
        	$action->setAttribute('class', 'btn btn-primary btn-lg');
        	$action->setAttribute('required', 'required');
        	$action->setTitle('Senden');
        }
        
    }
}