<?php
namespace Mailer\Senders;

class Mail extends \Mailer\Abstracts\Sender
{
    protected $type = 'mail';
    
    public function init()
    {
        $this->isMail();
        
        return parent::init();
    }
}