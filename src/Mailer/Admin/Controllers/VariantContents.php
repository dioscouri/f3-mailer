<?php 
namespace Mailer\Admin\Controllers;

class Events extends \Admin\Controllers\BaseAuth 
{
	use \Dsc\Traits\Controllers\AdminList;
	protected $list_route = '/admin/mailer/events';
	
	protected function getModel()
	{
		$model = new \Mailer\Models\Events;
		return $model;
	}
		
	public function index()
    {
        $model = $this->getModel();
        \Base::instance()->set('state', $model->populateState()->getState() );
        \Base::instance()->set('paginated', $model->paginate() );
                
        $this->app->set('meta.title', 'Events | Mailer');
        
        $view = \Dsc\System::instance()->get('theme');
        echo $view->render('Mailer\Admin\Views::events/list.php');
    }
}