<?php 
namespace Mailer\Abstracts;

class Sender extends \PHPMailer
{
    use \Mailer\Traits\Cleaner;
    
    protected $__settings;
    protected $__response = null; // if the sender makes a call (mail(), sendmail(), api->send(), whatever), this holds the response
    
    protected $type = 'mail';
    
    public $From = null;
    public $FromName = null;
    
    public function __construct($exceptions = true)
    {
        parent::__construct($exceptions);
    }
    
    /**
     * Get the settings object
     */
    public function settings()
    {
        if (empty($this->__settings)) 
        {
            $this->__settings = \Mailer\Models\Settings::fetch();
        }
        
        return $this->__settings;
    }
    
    /**
     * Initialize the sender for sending
     * 
     * @return \Mailer\Abstracts\Sender
     */
    public function init()
    {
        if (empty($this->FromName)) 
        {
            if ($from_name = $this->settings()->{'general.from_name'})
            {
                $this->FromName = $from_name;
            }            
        }
        
        if (empty($this->From))
        {
            if ($from_email = $this->settings()->{'general.from_email'})
            {
                $this->From = $from_email;
            }        
        }        
        
        // TODO Add this as a config setting
        $this->IsHTML(true);

        return $this;
    }
    
    /**
     * Get last send's response
     *
     * @return
     *
     */
    public function response()
    {
        return $this->__response;
    }
    
    /**
     * 
     * @return Ambigous <boolean, \Mailer\Abstracts\Sender>
     */
    public static function instance()
    {
        try {
        	$sender = new static;
        } 
        catch (\Exception $e) {
            $sender = false;
        }
        
        return $sender;
    }
    
    /**
     * Binds an email object to this sender
     * 
     * @param \Mailer\Email $email
     */
    public function bindEmail( \Mailer\Email $email )
    {
        $vars = get_object_vars($this);
        foreach ($vars as $key=>$value) 
        {
            if (substr( $key, 0, 2 ) != '__')
            {
                $this->$key = $email->get($key);
            }
        }
        
        return $this;
    }
    
    /**
     * Actually sends the email realtime
     * 
     * @param \Mailer\Email $email
     */
    public function sendEmail( \Mailer\Email $email, $bind_and_init=true ) 
    {
        if ($bind_and_init) {
            return $this->bindEmail( $email )->init()->send();
        }
        else {
            return $this->send();
        }        
    }
    
    /**
     * Set the email sender
     *
     * @param   mixed  $from  email address and Name of sender
     *                        <code>array([0] => email Address, [1] => Name)</code>
     *                        or as a string
     *
     */
    public function setSender($from)
    {
        if (is_array($from))
        {
            // If $from is an array we assume it has an address and a name
            if (isset($from[2]))
            {
                // If it is an array with entries, use them
                $this->SetFrom($this->cleanLine($from[0]), $this->cleanLine($from[1]), (bool) $from[2]);
            }
            else
            {
                $this->SetFrom($this->cleanLine($from[0]), $this->cleanLine($from[1]));
            }
        }
        elseif (is_string($from))
        {
            // If it is a string we assume it is just the address
            $this->SetFrom($this->cleanLine($from));
        }
        else
        {
            throw new \Exception( 'Invalid Sender' );
        }
    
        return $this;
    }
    
    /**
     * Set the email subject
     *
     */
    public function setSubject($subject)
    {
        $this->Subject = $this->cleanLine($subject);
    
        return $this;
    }
    
    /**
     * Set the email body
     * 
     */
    public function setBody($content)
    {
        if (is_array($content)) 
        {
            $values = array_values($content);
            $this->Body = $this->cleanText($values[0]);
            
            if (!empty($values[1])) 
            {
                $this->setAltBody($values[1]);
            }
        }
        
        else 
        {
            $this->Body = $this->cleanText($content);
        }
    
        return $this;
    }
    
    /**
     * Set the email plain-text body
     *
     */
    public function setAltBody($content)
    {
        $this->AltBody = $this->cleanText($content);
    
        return $this;
    }
    
    /**
     * Add recipients to the email.
     *
     * @param   mixed   $recipient  Either a string or array of strings [email address(es)]
     * @param   mixed   $name       Either a string or array of strings [name(s)]
     * @param   string  $method     The parent method's name.
     * 
     */
    protected function add($recipient, $name = '', $method = 'AddAddress')
    {
        if (is_array($recipient))
        {
            if (is_array($name))
            {
                $combined = array_combine($recipient, $name);
    
                if ($combined === false)
                {
                    throw new \Exception("The number of elements for each array isn't equal.");
                }
    
                foreach ($combined as $recipientEmail => $recipientName)
                {
                    $recipientEmail = $this->cleanLine($recipientEmail);
                    $recipientName = $this->cleanLine($recipientName);
                    call_user_func('parent::' . $method, $recipientEmail, $recipientName);
                }
            }
            else
            {
                $name = $this->cleanLine($name);
    
                foreach ($recipient as $to)
                {
                    $to = $this->cleanLine($to);
                    call_user_func('parent::' . $method, $to, $name);
                }
            }
        }
        else
        {
            $recipient = $this->cleanLine($recipient);
            call_user_func('parent::' . $method, $recipient, $name);
        }
    
        return $this;
    }
    
    /**
     * Add recipients to the email
     *
     * @param   mixed  $recipient  Either a string or array of strings [email address(es)]
     * @param   mixed  $name       Either a string or array of strings [name(s)]
     * 
     */
    public function addRecipient($recipient, $name = '')
    {
        $this->add($recipient, $name, 'AddAddress');
    
        return $this;
    }
    
    /**
     * Add carbon copy recipients to the email
     *
     * @param   mixed  $cc    Either a string or array of strings [email address(es)]
     * @param   mixed  $name  Either a string or array of strings [name(s)]
     *
     */
    public function addCC($cc, $name = '')
    {
        // If the carbon copy recipient is an array, add each recipient... otherwise just add the one
        if (isset($cc))
        {
            $this->add($cc, $name, 'AddCC');
        }
    
        return $this;
    }
    
    /**
     * Add blind carbon copy recipients to the email
     *
     * @param   mixed  $bcc   Either a string or array of strings [email address(es)]
     * @param   mixed  $name  Either a string or array of strings [name(s)]
     *
     */
    public function addBCC($bcc, $name = '')
    {
        // If the blind carbon copy recipient is an array, add each recipient... otherwise just add the one
        if (isset($bcc))
        {
            $this->add($bcc, $name, 'AddBCC');
        }
    
        return $this;
    }
    
    /**
     * Add file attachments to the email
     *
     * @param   mixed  $attachment  Either a string or array of strings [filenames]
     * @param   mixed  $name        Either a string or array of strings [names]
     * @param   mixed  $encoding    The encoding of the attachment
     * @param   mixed  $type        The mime type
     * 
     */
    public function addAttachment($attachment, $name = '', $encoding = 'base64', $type = 'application/octet-stream', $disposition = 'attachment')
    {
        // If the file attachments is an array, add each file... otherwise just add the one
        if (isset($attachment))
        {
            if (is_array($attachment))
            {
                if (!empty($name) && count($attachment) != count($name))
                {
                    throw new \Exception("The number of attachments must be equal with the number of name");
                }
    
                foreach ($attachment as $key => $file)
                {
                    if (!empty($name))
                    {
                        parent::AddAttachment($file, $name[$key], $encoding, $type, $disposition);
                    }
                    else
                    {
                        parent::AddAttachment($file, $name, $encoding, $type, $disposition);
                    }
                }
            }
            else
            {
                parent::AddAttachment($attachment, $name, $encoding, $type, $disposition);
            }
        }
    
        return $this;
    }
    
    /**
     * Add Reply to email address(es) to the email
     *
     * @param   mixed  $replyto  Either a string or array of strings [email address(es)]
     * @param   mixed  $name     Either a string or array of strings [name(s)]
     *
     */
    public function addReplyTo($replyto, $name = '')
    {
        $this->add($replyto, $name, 'AddReplyTo');
    
        return $this;
    }
    
    /**
     * Sets message type to HTML
     *
     * @param   boolean  $ishtml  Boolean true or false.
     *
     */
    public function isHtml($ishtml = true)
    {
        parent::IsHTML($ishtml);
    
        return $this;
    }
    
    /**
     * Oh, this is nasty.
     * 
     * @param unknown $key
     */
    public function get( $key )
    {
        return $this->$key;        
    }
    
    /**
     * Set properties of a model based on $this
     *
     * @return \Mailer\Models\Emails
     */
    public function toModel()
    {
        $model = new \Mailer\Models\Emails;
    
        $vars = get_object_vars($this);
    
        foreach ($vars as $key=>$value)
        {
            if (substr( $key, 0, 2 ) == '__')
            {
                unset($vars[$key]);
            }
        }
    
        $model->bind($vars);
        
        // cleanup and prune some fields
        $model->all_recipients = array_keys( $model->all_recipients );
        
        return $model;
    }
}