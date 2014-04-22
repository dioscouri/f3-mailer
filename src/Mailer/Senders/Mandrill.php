<?php
namespace Mailer\Senders;

class Mandrill extends \Mailer\Abstracts\Sender
{
    protected $__api = false; // if api key exists, is a \Mandrill object
    protected $__response = null; // if api call is made, this holds the response
    
    /**
     * Initialize the Sender
     * 
     * @throws \Exception
     */
    public function init()
    {
        $settings = \Mailer\Models\Settings::fetch();
        
        $api_key = $settings->{'mandrill.api_key'};
        $smtp_host = $settings->{'mandrill.smtp_host'};
        $smtp_port = $settings->{'mandrill.smtp_port'};
        $smtp_username = $settings->{'mandrill.smtp_username'};
        $smtp_password = $settings->{'mandrill.smtp_password'};
        
        // for the moment, only send via SMTP
        if ($api_key)
        {
            $this->__api = new \Mandrill($api_key);
        }
        elseif ($smtp_host && $smtp_port && $smtp_username && $smtp_password)
        {
            // since we extend PHPMailer, just send via SMTP
            $this->IsSMTP();
            $this->Host = $smtp_host;
            $this->Port = $smtp_port;
            $this->SMTPAuth = true;
            $this->Username = $smtp_username;
            $this->Password = $smtp_password;
            $this->SMTPSecure = 'tls';
        }
        else
        {
            throw new \Exception('Missing settings');
        }
        
        return parent::init();
    }

    /**
     * Get the API class
     *
     * @return \Mandrill Boolean
     */
    public function api()
    {
        return $this->__api;
    }

    /**
     * Get last API call's response
     *
     * @return
     *
     */
    public function response()
    {
        return $this->__response;
    }

    /**
     * Send the email, either via the API or via SMTP
     *
     * @return boolean
     */
    public function send()
    {
        if ($this->api())
        {
            return $this->sendAPI();
        }
        
        return parent::send();
    }

    /**
     * Send the email via the API
     *
     * @return boolean
     */
    public function sendAPI()
    {
        /**
         * https://mandrillapp.com/api/docs/messages.html#method=send
         */
        $params = array(
            "html" => $this->Body,
            "text" => $this->AltBody,
            "from_email" => $this->From,
            "from_name" => $this->FromName,
            "subject" => $this->Subject,
            "to" => $this->convertTo(),
            "track_opens" => true,
            "track_clicks" => true,
            "auto_text" => true
        );
        
        // TODO Enable attachments
        if (! empty($attachments))
        {
            $params['attachments'] = array(
                $attachments
            );
        }
        
        $this->__response = $this->api()->messages->send($params, true);
        
        if (isset($this->__response->code))
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * Converts the PHP Mailer $to array
     * into an array that can be used by the Mandrill API
     *
     * @return multitype:multitype:string unknown
     */
    protected function convertTo()
    {
        $to = array();
        foreach ($this->to as $recipient)
        {
            $new_recipient = array(
                'type' => 'to',
                'email' => $recipient[0]
            );
            
            if (! empty($recipient[1]))
            {
                $new_recipient['name'] = $recipient[1];
            }
            
            $to[] = $new_recipient;
        }
        
        return $to;
    }
}