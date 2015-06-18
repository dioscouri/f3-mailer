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

    public static function register( $namespace, array $options=array() )
    {
        // Add the report to the collection if it isn't already
        $report = (new static)->setState('filter.namespace', $namespace)->getItem();
        if (empty($report->id) || !empty($options['__update'])) 
        {
            try {
                if (empty($report->id)) {
                    $report = new static;
                }
                
                $report->bind(array(
                    'namespace' => $namespace,
                ))->bind($options)->save();

                return $report;
            }
            catch (\Exception $e) {
                
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
			
			
			
			if(empty($content->email_body)) {
				throw new \Exception('Content is empty, or No Content Variant for this event');
			} else {
				return $content;
			}
		} catch (Exception $e) {
			//throw the error up the stack
			throw new \Exception($e->getMessage());
		}

	}   
	
	public function getRenderedContent() {
		
		$content = $this->getContentVariant();
		
	
		
		$rendered = \Mailer\Render::instance()->resolve($content->email_body);
		
		
		return $rendered; 
		
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