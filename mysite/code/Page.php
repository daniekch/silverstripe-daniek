<?php
class Page extends SiteTree {

	private static $db = array(
		'Subtitle' => 'Varchar(255)'
	);

	private static $has_one = array(
	);
	
	function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->addFieldToTab("Root.Main", new TextField("Subtitle", 'Untertitel'), 'URLSegment');
		return $fields;
	}

}
class Page_Controller extends ContentController {

	/**
	 * An array of actions that can be accessed via a request. Each array element should be an action name, and the
	 * permissions or conditions required to allow the user to access it.
	 *
	 * <code>
	 * array (
	 *     'action', // anyone can access this action
	 *     'action' => true, // same as above
	 *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
	 *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
	 * );
	 * </code>
	 *
	 * @var array
	 */
	private static $allowed_actions = array (
	);

	public function init() {
		parent::init();
		// You can include any CSS or JS required by your project here.
		// See: http://doc.silverstripe.org/framework/en/reference/requirements
	}
	
	public function googleAnalytics() {
	
		$googleAnalytics = Page::config()->get('googleAnalytics');
	
		return new ArrayData(array(
				'enabled' => ($googleAnalytics["enabled"] == "true" && Director::isLive()),
				'accountId' => $googleAnalytics["accountId"]
		));
	}
	
	public function MetaRobots()
	{
		if($this->URLSegment == 'Security')
		{
			return "noindex, nofollow";
		}
		
		return "index, follow";
	}

}
