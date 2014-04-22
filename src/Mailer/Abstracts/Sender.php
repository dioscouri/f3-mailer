<?php 
namespace Mailers\Abstracts;

abstract class Sender extends PHPMailer
{
    use \Mailer\Traits\Cleaner;
    
    public function __construct($exceptions = false)
    {
        parent::__construct();
        
        // TODO Set things based on settings in the Config, including
        // $this->From
        // $this->FromName
    }
}