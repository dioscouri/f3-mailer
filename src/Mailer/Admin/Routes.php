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
		
		$this->add( '/emails', array('GET', 'POST'), array(
								'controller' => 'Emails',
								'action' => 'display'
								));

		$this->add( '/emails/@page', array('GET', 'POST'), array(
				'controller' => 'Emails',
				'action' => 'display'
		));

		$this->add( '/emails/delete', array('GET', 'POST'), array(
				'controller' => 'Emails',
				'action' => 'delete'
		));

		$this->add( '/email', 'GET', array(
				'controller' => 'Email',
				'action' => 'create'
		));

		$this->add( '/email', 'POST', array(
				'controller' => 'Email',
				'action' => 'add'
		));

		$this->add( '/email/@id', 'GET', array(
				'controller' => 'Email',
				'action' => 'read'
		));

		$this->add( '/email/edit/@id', 'GET', array(
				'controller' => 'Email',
				'action' => 'edit'
		));

		$this->add( '/email/@id', 'POST', array(
				'controller' => 'Email',
				'action' => 'update'
		));

		$this->add( '/email/email/@id', 'DELETE', array(
				'controller' => 'Email',
				'action' => 'delete'
		));

		$this->add( '/email/delete/@id', 'GET', array(
				'controller' => 'Email',
				'action' => 'delete'
		));
	}
}