<?php
class Page extends SiteTree {

	private static $db = array(
		
	);

	private static $has_one = array(
	);
	
	function getCMSFields() {
		$fields = parent::getCMSFields();
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
		
		Requirements::block('framework/thirdparty/jquery/jquery.js');
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
