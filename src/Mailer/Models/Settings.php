<?php 
namespace Mailer\Models;

class Settings extends \Dsc\Mongo\Collections\Settings
{
    protected $__type = 'mailer.settings';
    
    public $general = array(
    	'from_name', 
        'from_email', 
        'async' => 0
    );
    
    public $smtp = array(
        'smtp_host', 'smtp_port', 'smtp_username', 'smtp_password'
    );
        
    public $mandrill = array(
    	'smtp_host', 'smtp_port', 'smtp_username', 'smtp_password', 'api_key'
    );
}