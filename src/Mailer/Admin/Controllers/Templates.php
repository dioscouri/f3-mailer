<?php 
namespace Mailer\Admin\Controllers;

class Templates extends \Admin\Controllers\BaseAuth 
{
	use \Dsc\Traits\Controllers\AdminList;
	protected $list_route = '/admin/mailer/templates';
	
	protected function getModel()
	{
		$model = new \Mailer\Models\Templates;
		return $model;
	}
		
	public function index()
    {
        $model = $this->getModel();
        \Base::instance()->set('state', $model->populateState()->getState() );
        \Base::instance()->set('paginated', $model->paginate() );
                
        $this->app->set('meta.title', 'Templates | Mailer');
        
        $view = \Dsc\System::instance()->get('theme');
        echo $view->render('Mailer\Admin\Views::templates/index.php');
    }
}