<?php
namespace Mailer\Senders;

class Sendmail extends \Mailers\Abstracts\Sender
{
    public function __construct($exceptions = false)
    {
        parent::__construct($exceptions);
        
        $this->isSendmail();
    }
}