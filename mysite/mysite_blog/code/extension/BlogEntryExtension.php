<?php

class BlogEntryExtension extends DataExtension {
    
	private static $db = array(
		'Lat' => 'Varchar(20)',
		'Lng' => 'Varchar(20)',
		'Zoom' => 'Int'
	);
	
    private static $has_one = array(
    	'HeadImage' => 'Image',
    	'Kml' => 'File'
    );
    
    public static $many_many = array(
    	"GalleryImages" => "File"
    );
     
    public function updateCMSFields(FieldList $fields) {
        $fields->addFieldToTab('Root.Main', new UploadField('HeadImage','Titelbild'), 'Content');
        $fields->addFieldToTab('Root.Main', new TreeMultiSelectField('GalleryImages', 'Gallery Bilder', 'File'), 'Content');
        $fields->addFieldToTab('Root.Main', new TextField('Lat', 'Default Lat'), 'Content');
        $fields->addFieldToTab('Root.Main', new TextField('Lng', 'Default Lng'), 'Content');
        $fields->addFieldToTab('Root.Main', new NumericField('Zoom', 'Default Zoom'), 'Content');
        $fields->addFieldToTab('Root.Main', new UploadField('Kml', 'KML', 'File'), 'Content');
    }
}