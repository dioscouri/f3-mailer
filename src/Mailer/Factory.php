<?php
namespace Mailer;

class Factory extends \Dsc\Singleton 
{
    protected $__sender;        // an instance of some class that extends \Mailer\Abstracts\Sender
    
    public function __construct($config=array())
    {
    	// TODO Set the $sender based on settings in the config
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
	    
	    // TODO add the email to the emails collection with $this->sender as the preferred sender,
	    // then send it immediately using $this->sender if asynchronous sending is disabled.
	    
	    // update the status of the email in the emails collection with the result of the send
	    
	    return $result;
	}
	
	/**
	 * An alias for the queue function, since most times you'll use this in the context of emailing... e.g.
	 * \Mailer\Factory::send( $email );
	 *
	 * @return boolean
	 */
	public static function send( \Mailer\Email $email )
	{
	    return static::queue( $email );
	}

	/**
	 * Utility function to quickly send an email
	 *
	 * @param   string   $fromEmail    From email address
	 * @param   string   $fromName     From name
	 * @param   mixed    $recipientEmails    Recipient email address(es)
	 * @param   string   $subject      email subject
	 * @param   string   $body         Message body
	 * @param   boolean  $mode         false = plain text, true = HTML
	 * @param   mixed    $cc           CC email address(es)
	 * @param   mixed    $bcc          BCC email address(es)
	 * @param   mixed    $attachment   Attachment file name(s)
	 * @param   mixed    $replyTo      Reply to email address(es)
	 * @param   mixed    $replyToName  Reply to name(s)
	 *
	 * @return  boolean  True on success
	 */
	public static function sendMail($fromEmail, $fromName, $recipientEmails, $subject, $body, $mode = false, $cc = null, $bcc = null, $attachment = null, $replyTo = null, $replyToName = null)
	{
	    // TODO Create a \Mailer\Email object and then static::queue() it
	    // return the result 
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
}