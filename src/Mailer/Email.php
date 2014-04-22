<?php
namespace Mailer;

/**
 * This class extends PHPMailer, so it has all of the functions you'd need to create an email.
 *
 * Sending it adds it to the Mailer queue (or sends it immediately if queueing is disabled)
 */
class Email extends \Mailer\Abstracts\Sender
{
    /**
     * Overrides PHPMailer::send() in order to add to the Mailer queue
     *
     * @return boolean
     */
    public function send()
    {
        // TODO Use \Dsc\System->mailer?
        return \Mailer\Factory::queue($this);
    }
}