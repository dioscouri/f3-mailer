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
     * @throws Exception if save to \Mailer\Models\Email fails
     * 
     * @return boolean
     */
	public static function queue( \Mailer\Email $email )
	{
	    $result = false;
	    
	    $mailer = static::instance()->sender()->bindEmail( $email )->init();
	    
	    // add the email to the emails collection with $this->sender as the preferred sender,
        $model = $mailer->toModel()->save();
        
        // update the result
        $result = 'queued';
        
	    // if async sending is disabled, send the email immediately
	    $async = $mailer->settings()->{'general.async'};
	    
	    // For now, async is disabled.  All emails are sent immediately
	    $async = false;
	    
	    if (empty($async)) 
	    {
	        // Send it immediately using $this->sender() since asynchronous sending is disabled.
	        // pass false as the second argument to prevent the mailer from doing a bind & init (since we already did it)
	        $result = $mailer->sendEmail( $email, false );
	        
	        // update the status of the email in the emails collection with the result of the send
	        $model->sender_response = $mailer->response();
	        $model->queue_status = 'sent';
	        $model->send_result = $result;
	        $model->save();
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
	 * @param mixed $body
	 *            Message body.  If an array, [0] => html, [1] => plain text
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
	public static function send($recipientEmails, $subject, $body, $fromEmail = null, $fromName = null, $mode = true, $cc = null, $bcc = null, $attachment = null, $replyTo = null, $replyToName = null)
	{
	    $settings = \Mailer\Models\Settings::fetch();
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
	
	    if (empty($fromEmail)) {
	        $fromEmail = $settings->{'general.from_email'};
	    }
	    
	    if (empty($fromName)) {
	        $fromName = $settings->{'general.from_name'};
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
	 * Simple Alais for sending mail from event
	 *
	 * @param \Mailer\Abstracts\Sender $sender
	 * @return \Mailer\Factory
	 */
	
	public function sendEvent($email, array $content) {
		static::send($email,  $content['subject'], $content['body'], $content['fromEmail'], $content['fromName'], true, $content['cc'], $content['bcc'], $content['replyToEmail'], $content['replyToName'] );
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
	
	
	/*
	 * 
	 */
	public static function getEmailContents($eventName, $options = array()) 
	{
		try {
			
			//fetch the event from mongo
			$event = (new \Mailer\Models\Events)->setCondition('event_name', $eventName)->getItem();
	
			if (empty($event->id)) {
			    throw new \Exception('Invalid Email Event');
			}
		
			//if we have more than just an event name assign those variables to the view users the passed variable name;
			if (!empty($options)) 
			{
				foreach ($options as $key => $value) 
				{
                    \Base::instance()->set($key, $value);
				}
			} 
			
			$blocks = (new \Mailer\Models\Blocks)->getList();
			
			//adding a base URL, you can be overriden with a block
			\Base::instance()->set('base_url', \Base::instance()->get('SCHEME') . '://' . \Base::instance()->get('HOST') . \Base::instance()->get('BASE'));
			
			foreach ($blocks as $block) 
			{
				$html = \Mailer\Render::instance()->resolve($block->content);
				\Base::instance()->set($block->key, $html);
			}
			
			//get the email contents Subject and Content
			$content = $event->getRenderedContent();
		 
			//pass the additional $func = args;
			
		} catch (\Exception $e) {
			// TODO Log it?
			
		    $content = null;
		}
		
		return $content;
	}
	
	
}