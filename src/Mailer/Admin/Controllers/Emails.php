<?php 
namespace Mailer\Admin\Controllers;

class Emails extends \Admin\Controllers\BaseAuth 
{
    public function index()
    {
        $model = new \Mailer\Models\Emails;
        \Base::instance()->set('state', $model->populateState()->getState() );
        \Base::instance()->set('paginated', $model->paginate() );
                
        $view = \Dsc\System::instance()->get('theme');
        echo $view->render('Mailer\Admin\Views::emails/list.php');
    }
}