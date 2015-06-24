<?php 
namespace Mailer\Models;

class Templates extends \Dsc\Mongo\Collections\Content
{
    protected $__collection_name = 'mailer.templates';
    protected $__type = 'core';
    
    public $slug = null;           // required, unique.
    
    public $title = null;           // human-readable
    
    public $event_id = null;           // ObjectId of Event it is attached    
    public $event_subject = null;   // subject of the email
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
    
        $filter_event_id = $this->getState('filter.event');
        if (strlen($filter_event_id))
        {
            $this->setCondition('event_id', new \MongoId( (string) $filter_event_id ) );
        }
         
        return $this;
    }
    
    
    protected function beforeValidate()
    {
        if (empty($this->event_id))
        {
            throw new \Exception('Event Id is required');
        }
        
        $this->event_id = new \MongoId( (string) $this->event_id );
    
        // TODO Put this in beforeSave, to ensure that the slug is clean
        //$this->slug = \Web::instance()->slug( $this->slug );
    
        return parent::beforeValidate();
    }
    
    public function event()
    {
        if (empty($this->event_id))
        {
            return null;
        }
    
        $item = (new \Mailer\Models\Events)->setState('filter.id', $this->event_id)->getItem();
        if (empty($item->id))
        {
            return null;
        }
    
        return $item;
    }
    
    public function markUsed()
    {
        $this->last_used = time();
    
        return $this->save();
    }
}