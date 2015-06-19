<?php 
namespace Mailer\Models;

class ContentVariants extends \Dsc\Mongo\Collections\Describable
{
       
    protected $__collection_name = 'mailer.events.content';
    protected $__type = 'core';
    
	public $slug = null;           // required, unique.
	
    public $title = null;           // human-readable      
    public $type = null;           // e.g. 'products', 'orders', 'customers', 'misc'
    public $icon = null;           // a font-awesome class name

    public $event_id = null;           // ObjectId of Event it is attached
    public $event_html = null;           // HTML markup for the body of the email
    public $event_text = null;           // HTML markup for the body of the email
    public $last_used = null;  			//putting last time the template was sent to enable round robin A+B testing
    
    protected $__config = array(
        'default_sort' => array(
        	'last_used' => -1
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


    protected function beforeValidate()
    {
    	if (empty($this->event_id))
    	{
    		throw new \Exception('Event Id is required');
    	}
    
    	if (empty($this->last_used))
    	{
    		$this->last_used = time();
    	}
    	// TODO Put this in beforeSave, to ensure that the slug is clean
    	//$this->slug = \Web::instance()->slug( $this->slug );
    
    	return parent::beforeValidate();
    }
         
}