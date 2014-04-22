<?php
namespace Mailer\Senders;

class Smtp extends \Mailer\Abstracts\Sender
{
    protected $type = 'smtp';
    
    public function init()
    {
        $smtp_host = $this->settings()->{'smtp.smtp_host'};
        $smtp_port = $this->settings()->{'smtp.smtp_port'};
        $smtp_username = $this->settings()->{'smtp.smtp_username'};
        $smtp_password = $this->settings()->{'smtp.smtp_password'};
        
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

        return parent::init();
    }
}