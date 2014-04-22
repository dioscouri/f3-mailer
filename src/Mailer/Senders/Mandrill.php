<?php
namespace Mailer\Senders;

class Mandrill extends \Mailers\Abstracts\Sender
{
    public $api = false;        // if api key exists, is a \Mandrill object
    
    public function __construct($exceptions = false)
    {
        parent::__construct();
    
        $settings = \Mailer\Models\Settings::fetch();
    
        $smtp_host = $settings->{'mandrill.smtp_host'};
        $smtp_port = $settings->{'mandrill.smtp_port'};
        $smtp_username = $settings->{'mandrill.smtp_username'};
        $smtp_password = $settings->{'mandrill.smtp_password'};
        
        if ($api_key = $settings->{'mandrill.api_key'})
        {
            $this->api = new \Mandrill( $api_key );
        }
        elseif ($smtp_host && $smtp_port && $smtp_username && $smtp_password) 
        {
        	// since we extend PHPMailer, just send via SMTP
        	$this->IsSMTP();
        	$this->Host = $smtp_host;
        	$this->Port = $smtp_port;
        	$this->SMTPAuth = true;                               // Enable SMTP authentication
        	$this->Username = $smtp_username;                // SMTP username
        	$this->Password = $smtp_password;                  // SMTP password
        	$this->SMTPSecure = 'tls';        	        	
        }
        else 
        {
        	throw new \Exception('Missing settings');
        }
    }    
}