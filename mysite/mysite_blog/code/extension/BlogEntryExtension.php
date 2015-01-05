<?php

class BlogEntryExtension extends DataExtension {
    
    private static $has_one = array(
    	'HeadImage' => 'Image'
    );
     
    public function updateCMSFields(FieldList $fields) {
        $fields->addFieldToTab('Root.Main', new UploadField('HeadImage','Titelbild', 'Content'));
    }
}