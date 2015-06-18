<?php 
namespace Mailer\Admin\Controllers;

class ContentVariant extends \Admin\Controllers\BaseAuth 
{
    use \Dsc\Traits\Controllers\CrudItemCollection;
    
    protected $list_route = '/admin/mailer/contentvariants';
    protected $create_item_route = '/admin/mailer/contentvariant/create';
    protected $get_item_route = '/admin/mailer/contentvariant/read/{id}';
    protected $edit_item_route = '/admin/mailer/contentvariant/edit/{id}';
    
    protected function getModel()
    {
        $model = new \Mailer\Models\ContentVariants;
        return $model;
    }
    
    protected function getItem()
    {
        $f3 = \Base::instance();
        $id = $this->inputfilter->clean( $f3->get('PARAMS.id'), 'alnum' );
        $model = $this->getModel()
        ->setState('filter.id', $id);
    
        try {
            $item = $model->getItem();
        } catch ( \Exception $e ) {
            \Dsc\System::instance()->addMessage( "Invalid Item: " . $e->getMessage(), 'error');
            $f3->reroute( $this->list_route );
            return;
        }
    
        return $item;
    }

    protected function displayCreate()
    {
        $this->app->set('meta.title', 'Create Variants | Mailer');
        
        $view = \Dsc\System::instance()->get('theme');
        echo $view->render('Mailer\Admin\Views::contentvariants/create.php');
    }
    
    protected function displayEdit()
    {
        $this->app->set('meta.title', 'Edit Variants | Mailer');
        
        $view = \Dsc\System::instance()->get('theme');
        echo $view->render('Mailer\Admin\Views::contentvariants/edit.php');
    }
    
    protected function displayRead()
    {
        $this->app->set('meta.title', 'Read Variants | Mailer');
        
        $view = \Dsc\System::instance()->get('theme');
        echo $view->render('Mailer\Admin\Views::contentvariants/read.php');
    }
    
    public function quickAdd()
    {
    	try {
    		
    		$date = new \DateTime;
    		$model = $this->getModel();
    		$model->set('title', 'New Variant ' . $date->format('Y/m/d H:i:s'));
    		$model->set('copy', 'New Variant ' . $date->format('Y/m/d H:i:s'));
    		$model->set('event_id', new \MongoId((string) $this->app->get('PARAMS.id')));
    		$model->save();
    		
    		$this->app->reroute('/admin/mailer/contentvariant/edit/'.$model->id);
    		
    	} catch (\Exception $e) {
    		echo $e->getMessage(); die();
    	}
    	
    	
    	
    	
    }
}