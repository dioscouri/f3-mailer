<?php

namespace Mailer\Admin;

/**
 * Group class is used to keep track of a group of routes with similar aspects (the same controller, the same f3-app and etc)
 */
class Routes extends \Dsc\Routes\Group{
	
	
	function __construct(){
		parent::__construct();
	}
	
	/**
	 * Initializes all routes for this group
	 * NOTE: This method should be overriden by every group
	 */
	public function initialize(){
		$this->setDefaults(
				array(
					'namespace' => '\Mailer\Admin\Controllers',
					'url_prefix' => '/admin'
				)
		);
		
		// uncomment this, if you add settings
		// $this->addSettingsRoutes( '/emails' );
		$this->addCrudList( 'Emails' );
		$this->addCrudItem( 'Email' );
	}
}