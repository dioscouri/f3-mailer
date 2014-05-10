<?php 
namespace Mailer\Admin\Controllers;

class Emails extends \Admin\Controllers\BaseAuth 
{
	use \Dsc\Traits\Controllers\AdminList;
	protected $list_route = '/admin/mailer/emails';
	
	protected function getModel()
	{
		$model = new \Mailer\Models\Emails;
		return $model;
	}
		
	public function index()
    {
        $model = $this->getModel();
        \Base::instance()->set('state', $model->populateState()->getState() );
        \Base::instance()->set('paginated', $model->paginate() );
                
        $view = \Dsc\System::instance()->get('theme');
        echo $view->render('Mailer\Admin\Views::emails/list.php');
    }
}