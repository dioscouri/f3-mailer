<?php
namespace Mailer\Senders;

class Mail extends \Mailer\Abstracts\Sender
{
    public function init()
    {
        $this->isMail();
        
        return parent::init();
    }
}