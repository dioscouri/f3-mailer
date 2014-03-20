<?php 
class MailerBootstrap extends \Dsc\Bootstrap{
	protected $dir = __DIR__;
	protected $namespace = 'Mailer';
	
	/**
	 * Dont do anything for sute for now
	 */
	protected function runSite(){}
}
$app = new MailerBootstrap();