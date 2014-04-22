<?php
namespace Mailer\Senders;

class Sendmail extends \Mailer\Abstracts\Sender
{
    public function init()
    {
        $this->isSendmail();
        
        return parent::init();
    }
}