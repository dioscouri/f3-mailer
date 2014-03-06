<?php 
class MailerBootstrap extends \Dsc\BaseBootstrap{
	protected $dir = __DIR__;
	protected $namespace = 'Mailer';
	
	/**
	 * Dont do anything for sute for now
	 */
	protected function runSite(){}
}
$app = new MailerBootstrap();