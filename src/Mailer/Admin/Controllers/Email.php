<?php 
namespace Mailer\Admin\Controllers;

class Email extends \Admin\Controllers\BaseAuth 
{
    public function read()
    {
        $model = new \Mailer\Models\Emails;
                
        $view = \Dsc\System::instance()->get('theme');
        echo $view->render('Mailer\Admin\Views::emails/read.php');
    }
}