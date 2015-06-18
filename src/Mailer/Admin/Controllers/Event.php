<?php 
namespace Mailer\Admin\Controllers;

class Event extends \Admin\Controllers\BaseAuth 
{
    use \Dsc\Traits\Controllers\CrudItemCollection;
    
    protected $list_route = '/admin/mailer/events';
    protected $create_item_route = '/admin/mailer/event/create';
    protected $get_item_route = '/admin/mailer/event/read/{id}';
    protected $edit_item_route = '/admin/mailer/event/edit/{id}';
    
    protected function getModel()
    {
        $model = new \Mailer\Models\Events;
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
        $this->app->set('meta.title', 'Create Event | Mailer');
        
        $view = \Dsc\System::instance()->get('theme');
        echo $view->render('Mailer\Admin\Views::events/create.php');
    }
    
    protected function displayEdit()
    {
        $this->app->set('meta.title', 'Edit Event | Mailer');
        
        $view = \Dsc\System::instance()->get('theme');
        echo $view->render('Mailer\Admin\Views::events/edit.php');
    }
    
    protected function displayRead()
    {
        $this->app->set('meta.title', 'Read Event | Mailer');
        
        $view = \Dsc\System::instance()->get('theme');
        echo $view->render('Mailer\Admin\Views::events/read.php');
    }
}