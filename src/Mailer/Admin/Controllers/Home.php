<?php 
namespace Mailer\Admin\Controllers;

class Home extends \Admin\Controllers\BaseAuth 
{    
    public function index()
    {
        $this->app->set('meta.title', 'Dashboard | Mailer');
        
    	$view = \Dsc\System::instance()->get('theme');
    	echo $view->render('Mailer/Admin/Views::home/index.php');
    }
}