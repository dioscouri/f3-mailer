<?php 
namespace Mailer\Models;

class Events extends \Dsc\Mongo\Collections\Describable
{
       
    protected $__collection_name = 'mailer.events';
    protected $__type = 'core';
    
	public $slug = null;           // required, unique.
	
    public $title = null;           // human-readable      
    public $type = null;           // e.g. 'products', 'orders', 'customers', 'misc'
    public $icon = null;           // a font-awesome class name

    
    protected $__config = array(
        'default_sort' => array(
        	'type' => 1,
            'title' => 1,
        ) 
    );
    
    protected function fetchConditions()
    {
        parent::fetchConditions();
        
        $filter_namespace = $this->getState('filter.namespace');
        if (strlen($filter_namespace))
        {
            $this->setCondition('namespace', $filter_namespace);
        }
    	
        return $this;
    }

    public static function register( $eventName, array $options=[], array $content= [])
    {
        // Add the email to the collection if it isn't already
        $event = (new static)->setCondition('event_name', $eventName)->getItem();
        if (empty($event->id)) 
        {
            try {
                $event = new static;
                
                $event->bind(array(
                    'event_name' => $eventName,
                ))->bind($options)->save();
				
                $content = $content + ['title' => 'default', 'copy' => 'Default From Application'];
                //create the default content
                $model = (new \Mailer\Models\ContentVariants);
                $model->set('event_id',$event->id);
                $model->bind($content);
                $model->save();
                return $event;
            }
            catch (\Exception $e) {
                echo $e->getMessage(); die();
            	return false;
            }

        }
        
        return true;
    }
    /*
     * Gets the content Variant based off settings
     * */
	public function getContentVariant() {
		try {
			$variants = (new \Mailer\Models\ContentVariants);
			
			$variants->setCondition('event_id', $this->id);
			
			
			
			$content = $variants->getItem();
			
			
			
			if(empty($content->event_html) ) {
				throw new \Exception('Content is empty, or No Content Variant for this event');
			} else {
				$content->set('last_used', time())->save();
				return $content;
			}
		} catch (Exception $e) {
			//throw the error up the stack
			throw new \Exception($e->getMessage());
		}

	}   
	
	public function getRenderedContent() {
		
		$content = $this->getContentVariant();
		
	
		$subject = \Mailer\Render::instance()->resolve($content->event_title);
		$html = \Mailer\Render::instance()->resolve($content->event_html);
		$text = \Mailer\Render::instance()->resolve($content->event_text);
		
		return ['subject' =>$subject, 'content' => [$html,$text]]; 
		
	}
    
    protected function beforeValidate()
    {
        if (empty($this->slug)) 
        {
            $this->slug = \Web::instance()->slug( $this->namespace );
        }
        
        // TODO Put this in beforeSave, to ensure that the slug is clean
        //$this->slug = \Web::instance()->slug( $this->slug );
        
        return parent::beforeValidate();
    }

    /**
     * 
     * @return Ambigous <multitype:multitype: , unknown>
     */
    public function grouped()
    {
        $grouped = array();
        
        if ($items = $this->getItems())
        {
            foreach ($items as $item)
            {
                if (empty($grouped[$item->type]))
                {
                    $grouped[$item->type] = array();
                }
        
                $grouped[$item->type][] = $item;
            }
        }
        
        return $grouped;
    }

     
}