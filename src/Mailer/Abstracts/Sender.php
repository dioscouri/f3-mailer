<?php 
namespace Mailers\Abstracts;

abstract class Sender extends PHPMailer
{
    use \Mailer\Traits\Cleaner;
    
    public function __construct($exceptions = false)
    {
        parent::__construct();
        
        $settings = \Mailer\Models\Settings::fetch();

        if ($from_name = $settings->{'general.from_name'}) 
        {
            $this->FromName = $from_name; 
        }
        
        if ($from_email = $settings->{'general.from_email'})
        {
            $this->From = $from_email;
        }
        
        // TODO Add this as a config setting
        $this->IsHTML(true);
    }
    
    /**
     * 
     * @return Ambigous <boolean, \Mailers\Abstracts\Sender>
     */
    public static function instance()
    {
        try {
        	$sender = new static;
        } 
        catch (\Exception $e) {
            $sender = false;
        }
        
        return $sender;
    }
}