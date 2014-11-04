<?php 
namespace Mailer\Models;

class Emails extends \Dsc\Mongo\Collections\Nodes 
{
    public $queue_status = 'queued';
    public $send_result = null;
    public $sender_response = null;
    
    protected $__collection_name = 'mailer.emails';
    protected $__type = 'mailer.emails';
    
    protected $__config = array(
        'default_sort' => array(
            'metadata.created.time' => -1
        ),
    );
    
    protected function fetchConditions()
    {
    	parent::fetchConditions();
    
    $filter_keyword = $this->getState('filter.keyword');
        if ($filter_keyword&&is_string($filter_keyword))
        {
            $key = new \MongoRegex('/'.$filter_keyword.'/i');
            
            $where = array();
            
            $regex = '/^[0-9a-z]{24}$/';
            if (preg_match($regex, (string) $filter_keyword))
            {
                $where[] = array(
                    '_id' => new \MongoId((string) $filter_keyword)
                );
            }
            $where[] = array(
                'Subject' => $key
            );
            $where[] = array(
                'Body' => $key
            );
            $where[] = array(
                'AltBody' => $key
            );
           
            $where[] = array(
                'metadata.creator.name' => $key
            );
            
            $where[] = array( 
            		'all_recipients' => $key
            		
            );
            
            $this->setCondition('$or', $where);
        }
    	return $this;
    }
    
}