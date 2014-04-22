<?php
namespace Mailer\Senders;

class Smtp extends \Mailers\Abstracts\Sender
{
    public function __construct($exceptions = false)
    {
        parent::__construct($exceptions);
        
        $smtp_host = $settings->{'smtp.smtp_host'};
        $smtp_port = $settings->{'smtp.smtp_port'};
        $smtp_username = $settings->{'smtp.smtp_username'};
        $smtp_password = $settings->{'smtp.smtp_password'};
        
        if ($smtp_host && $smtp_port && $smtp_username && $smtp_password)
        {
            // since we extend PHPMailer, just send via SMTP
            $this->IsSMTP();
            $this->Host = $smtp_host;
            $this->Port = $smtp_port;
            $this->Username = $smtp_username;
            $this->Password = $smtp_password;
            // TODO Add config options for these
            $this->SMTPAuth = true;
            $this->SMTPSecure = 'tls';
        }
        else
        {
            throw new \Exception('Missing settings');
        }        
    }
}