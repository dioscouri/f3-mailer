<?php
namespace Mailer\Senders;

class Mandrill extends \Mailers\Abstracts\Sender
{
    public function __construct($exceptions = false)
    {
        parent::__construct();
    
        $settings = \Mailer\Models\Settings::fetch();
    
        $smtp_host = $settings->{'mandrill.smtp_host'};
        $smtp_port = $settings->{'mandrill.smtp_port'};
        $smtp_username = $settings->{'mandrill.smtp_username'};
        
        if ($api_key = $settings->{'mandrill.api_key'})
        {
        
        }
        elseif ($smtp_host && $smtp_port && $smtp_username) {
        	
        }
        else 
        {
        	throw new \Exception('Missing settings');
        }
    }    
}