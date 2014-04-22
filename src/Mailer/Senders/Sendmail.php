<?php
namespace Mailer\Senders;

class Sendmail extends \Mailer\Abstracts\Sender
{
    protected $type = 'sendmail';
    
    public function init()
    {
        $this->isSendmail();
        
        return parent::init();
    }
}