<?php 
namespace Mailer\Admin\Controllers;

class Home extends \Admin\Controllers\BaseAuth 
{    
    public function index()
    {
    	$view = \Dsc\System::instance()->get('theme');
    	echo $view->render('Mailer/Admin/Views::home/index.php');
    }
}