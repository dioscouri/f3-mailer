<?php 
namespace Mailer\Admin\Controllers;

class Blocks extends \Admin\Controllers\BaseAuth 
{
	use \Dsc\Traits\Controllers\AdminList;
	protected $list_route = '/admin/mailer/blocks';
	
	protected function getModel()
	{
		$model = new \Mailer\Models\Blocks;
		return $model;
	}
		
	public function index()
    {
        $model = $this->getModel();
        \Base::instance()->set('state', $model->populateState()->getState() );
        \Base::instance()->set('paginated', $model->paginate() );
                
        $this->app->set('meta.title', 'Blocks | Mailer');
        
        $view = \Dsc\System::instance()->get('theme');
        echo $view->render('Mailer\Admin\Views::blocks/list.php');
    }
}