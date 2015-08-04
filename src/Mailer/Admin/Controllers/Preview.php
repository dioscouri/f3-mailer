<?php 
namespace Mailer\Admin\Controllers;

class Preview extends \Admin\Controllers\BaseAuth 
{

    public function index()
    {
        $f3 = \Base::instance();
        
        $id = $this->inputfilter->clean( $f3->get('PARAMS.id'), 'alnum' );
        
        $templateModel = (new \Mailer\Models\Templates)->setState('filter.id', $id);
        $this->app->set('id', $id);
       
        try {
            $template = $templateModel->getItem();
            
            if(empty($template->id)) {
            	throw new \Exception();
            }
            //get the event
            $event = (new \Mailer\Models\Events)->setState('filter.id', $template->event_id)->getItem();
            
            $listenerEvent = 'mailerPreview';
            $parts = explode('.',$event->event_name);
            foreach($parts as $part) {
            	$listenerEvent .= ucfirst($part);
            }
            
            //the preview event should return the variables
            $results = \Dsc\System::instance()->trigger($listenerEvent);
          
            $variables = $results->getArgument('variables');
            $view = \Dsc\System::instance()->get('theme');

            if(!empty($variables)) {
            	
            	$contents = \Mailer\Factory::getEmailContents( $event->event_name,$variables);
          
            	$this->app->set('contents', $contents); 
            	
            	echo $view->renderView('Mailer/Admin/Views::preview/index.php');
            	
            } else {
            	
            	$view = \Dsc\System::instance()->get('theme');
            	$this->app->set('event', $listenerEvent);
            	echo $view->renderView('Mailer/Admin/Views::preview/notsupported.php');
            }
            
            
            
        } catch ( \Exception $e ) {
            \Dsc\System::instance()->addMessage( "Invalid Item: " . $e->getMessage(), 'error');       
            return;
        }
    
    }

    public function email()
    {
    	$f3 = \Base::instance();
    
    	$id = $this->inputfilter->clean( $f3->get('PARAMS.id'), 'alnum' );
    	$email = $this->inputfilter->clean( $f3->get('GET.email'), 'string' );
    	$templateModel = (new \Mailer\Models\Templates)->setState('filter.id', $id);
    	$this->app->set('id', $id);
    	$mailer = \Dsc\System::instance()->get('mailer');
    	
    	try {
    		$template = $templateModel->getItem();
    
    		if(empty($template->id)) {
    			throw new \Exception();
    		}
    		//get the event
    		$event = (new \Mailer\Models\Events)->setState('filter.id', $template->event_id)->getItem();
    
    		$listenerEvent = 'mailerPreview';
    		$parts = explode('.',$event->event_name);
    		foreach($parts as $part) {
    			$listenerEvent .= ucfirst($part);
    		}
    
    		//the preview event should return the variables
    		$results = \Dsc\System::instance()->trigger($listenerEvent);
    
    		$variables = $results->getArgument('variables');
    		$view = \Dsc\System::instance()->get('theme');
    
    		if(!empty($variables)) {
    			 
    			$contents = \Mailer\Factory::getEmailContents( $event->event_name,$variables);
    
    			$mailer->sendEvent( $email, $contents);
    			 
    			\Dsc\System::addMessage('Sent Email to : '. $email. '', 'success' );
    			$this->app->set('contents', $contents);
    			echo $view->renderView('Mailer/Admin/Views::preview/index.php');
    			 
    		} else {
    			\Dsc\System::addMessage('No email sent', 'error' );
    			
    			$view = \Dsc\System::instance()->get('theme');
    			$this->app->set('event', $listenerEvent);
    			echo $view->renderView('Mailer/Admin/Views::preview/notsupported.php');
    		}
    		
    
    	} catch ( \Exception $e ) {
    		\Dsc\System::instance()->addMessage( "Invalid Item: " . $e->getMessage(), 'error');
    		return;
    	}
    
    }
    
    
}