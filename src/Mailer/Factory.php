<?php
namespace Mailer;

class Factory extends \Dsc\Singleton 
{
    protected $__sender;        // an instance of some class that extends \Mailer\Abstracts\Sender
    protected $__settings;
    
    public function __construct($config=array())
    {
    	// Set the $sender based on settings in the config
        $this->__settings = \Mailer\Models\Settings::fetch();
        
        if ($class = $this->__settings->{'general.sender'}) 
        {
        	if (class_exists($class) && $sender = $class::instance()) 
        	{
        		$this->setSender( $sender );
        	}
        }
        
        if (empty($this->__sender)) 
        {
            $sender = \Mailer\Senders\Mail::instance();
            $this->setSender( $sender );
        } 
    }
    
    /**
     * Add an email to the queue, which means either: 
     * 1) queue the email (if asynchronous emails are enabled) or 
     * 2) send the email immediately
     * 
     * Either way, the preferred sender is used (whatever is chosen in the config and set as $this->sender).
     * 
     * @return boolean
     */
	public static function queue( \Mailer\Email $email )
	{
	    $result = true;
	    
	    $mailer = static::instance();
	    
	    // TODO add the email to the emails collection with $this->sender as the preferred sender,

	    // if async sending is disabled, send the email immediately
	    if (empty($mailer->settings()->{'general.async'})) 
	    {
	        // then send it immediately using $this->__sender if asynchronous sending is disabled.
	        $result = $mailer->sender()->sendEmail( $email );
	        
	        // TODO update the status of the email in the emails collection with the result of the send	        
	    }
	    
	    return $result;
	}
	
	/**
	 * Utility function to quickly send an email
	 *
	 * @param string $fromEmail
	 *            From email address
	 * @param string $fromName
	 *            From name
	 * @param mixed $recipientEmails
	 *            Recipient email address(es)
	 * @param string $subject
	 *            email subject
	 * @param string $body
	 *            Message body
	 * @param boolean $mode
	 *            false = plain text, true = HTML
	 * @param mixed $cc
	 *            CC email address(es)
	 * @param mixed $bcc
	 *            BCC email address(es)
	 * @param mixed $attachment
	 *            Attachment file name(s)
	 * @param mixed $replyTo
	 *            Reply to email address(es)
	 * @param mixed $replyToName
	 *            Reply to name(s)
	 *
	 * @return boolean True on success
	 */
	public static function send($fromEmail, $fromName, $recipientEmails, $subject, $body, $mode = true, $cc = null, $bcc = null, $attachment = null, $replyTo = null, $replyToName = null)
	{
	    $email = new \Mailer\Email;
	
	    $email->setSubject($subject);
	    $email->setBody($body);
	
	    // Are we sending the email as HTML?
	    if (!$mode)
	    {
	        $email->IsHTML(false);
	    }
	
	    $email->addRecipient($recipientEmails);
	    $email->addCC($cc);
	    $email->addBCC($bcc);
	    $email->addAttachment($attachment);
	
	    if (is_array($replyTo))
	    {
	        foreach ($replyTo as $key=>$replyToEmail)
	        {
	            $replyName = $replyToEmail;
	            if (!empty($replyToName[$key])) {
	                $replyName = $replyToName[$key];
	            }
	
	            $email->addReplyTo(array(
	                $replyToEmail,
	                $replyName
	            ));
	        }
	    }
	    elseif (isset($replyTo))
	    {
	        $replyName = !empty($replyToName) ? $replyToName : $replyTo;
	
	        $email->addReplyTo(array(
	            $replyTo,
	            $replyName
	        ));
	    }
	
	    // Add sender to replyTo only if no replyTo received
	    $autoReplyTo = (empty($email->ReplyTo)) ? true : false;
	    $email->setSender(array(
	        $fromEmail,
	        $fromName,
	        $autoReplyTo
	    ));
	
	    return static::queue( $email );
	}
	
	/**
	 * Sets the global sender object if it's valid 
	 * 
	 * @param \Mailer\Abstracts\Sender $sender
	 * @return \Mailer\Factory
	 */
	public function setSender( \Mailer\Abstracts\Sender $sender ) 
	{
		$this->__sender = $sender;
		
		return $this;
	}
	
	/**
	 * Gets the sender object
	 */
	public function sender()
	{
	    return $this->__sender;
	}
	
	/**
	 * Get the settings object
	 */
	public function settings()
	{
	    return $this->__settings;
	}
}