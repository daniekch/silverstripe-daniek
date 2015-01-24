<?php

class BlogEntryExtension extends DataExtension {
    
    private static $has_one = array(
    	'HeadImage' => 'Image'
    );
    
    public static $many_many = array(
    		"GalleryImages" => "File"
    );
     
    public function updateCMSFields(FieldList $fields) {
        $fields->addFieldToTab('Root.Main', new UploadField('HeadImage','Titelbild', 'Content'));
        $fields->addFieldToTab('Root.Main', new TreeMultiSelectField('GalleryImages', 'Gallery Bilder', 'File'), '');
    }
}