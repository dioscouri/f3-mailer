<?php 
namespace Mailer\Admin\Controllers;

class Template extends \Admin\Controllers\BaseAuth 
{
    use \Dsc\Traits\Controllers\CrudItemCollection;
    
    protected $list_route = '/admin/mailer/templates';
    protected $create_item_route = '/admin/mailer/template/create';
    protected $get_item_route = '/admin/mailer/template/read/{id}';
    protected $edit_item_route = '/admin/mailer/template/edit/{id}';
    
    protected function getModel()
    {
        $model = new \Mailer\Models\Templates;
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
        $mailer_settings = \Mailer\Models\Settings::fetch();
        if (!$mailer_settings->emails_registered || (date('Y-m-d', time()) > date('Y-m-d', $mailer_settings->emails_registered)))
        {
            $result = \Dsc\System::instance()->trigger('onSystemRegisterEmails');
        
            $mailer_settings->{'emails_registered'} = time();
            $mailer_settings->save();
            
            $this->app->reroute('/admin/mailer/template/create');
        }
                
        $this->app->set('meta.title', 'Create Templates | Mailer');
        
        $view = \Dsc\System::instance()->get('theme');
        echo $view->render('Mailer\Admin\Views::templates/create.php');
    }
    
    protected function displayEdit()
    {
        $this->app->set('meta.title', 'Edit Templates | Mailer');
        
        $view = \Dsc\System::instance()->get('theme');
        echo $view->render('Mailer\Admin\Views::templates/edit.php');
    }
    
    protected function displayRead()
    {
        $this->app->set('meta.title', 'Read Templates | Mailer');
        
        $view = \Dsc\System::instance()->get('theme');
        echo $view->render('Mailer\Admin\Views::templates/read.php');
    }
    
    public function createFromEvent()
    {
        // get the event_id
        $event_id = $this->inputfilter->clean( $this->app->get('PARAMS.event_id'), 'alnum' );
        
        try {
            $event = (new \Mailer\Models\Events)->setState('filter.id', $event_id)->getItem();
            if (empty($event->id)) {
                throw new \Exception( 'Invalid Event' );
            }
            
        } catch ( \Exception $e ) {
            
            \Dsc\System::addMessage( $e->getMessage(), 'error');
            $this->app->reroute( $this->list_route );
        }
        
        $item = (new \Mailer\Models\Templates)->set('event_id', $event_id)->bind(array(
            'event_subject' => $event->event_subject,
            'event_html' => $event->event_html,
            'event_text' => $event->event_text,
        ));
        $this->app->set('item', $item);
        
        $flash = \Dsc\Flash::instance();
        $flash->store($item->cast());
        $this->app->set('flash', $flash);
        
        $this->app->set('meta.title', 'Create Template | Mailer');
        
        $view = \Dsc\System::instance()->get('theme');
        echo $view->render('Mailer\Admin\Views::templates/create.form.php');
    }
    
    public function saveFromEvent()
    {
        // get the event_id
        $event_id = $this->inputfilter->clean( $this->app->get('PARAMS.event_id'), 'alnum' );
    
        try {
            $event = (new \Mailer\Models\Events)->setState('filter.id', $event_id)->getItem();
            if (empty($event->id)) {
                throw new \Exception( 'Invalid Event' );
            }
    
        } catch ( \Exception $e ) {
    
            \Dsc\System::addMessage( $e->getMessage(), 'error');
            $this->app->reroute( $this->list_route );
        }
        
        // save the template
        
        // set $this->create_item_route
        $this->create_item_route = $this->create_item_route . '/' . $event_id;
        
        // then push $data to $this->doAdd($data)
        $data = $this->app->get('REQUEST');
        $data['event_id'] = $event_id;
        
        $this->doAdd($data);
        
        if ($route = $this->getRedirect()) {
            $this->app->reroute( $route );
        }
        
        return;
    }
 
}