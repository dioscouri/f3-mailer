<?php 
namespace Mailer\Models;

class Blocks extends \Dsc\Mongo\Collections\Nodes 
{   

	public $key = null;
	public $content = null;
	
    protected $__collection_name = 'mailer.blocks';
    protected $__type = 'core';
    
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
                      
            $this->setCondition('$or', $where);
        }
    	return $this;
    }
    
    protected function beforeValidate()
    {
    	if (empty($this->key))
    	{
    		throw new \Exception('Key Can Not Be Empty');
    	}
    	
    	if (empty($this->content))
    	{
    		throw new \Exception('Content can not be empty');
    	}
    	
    
    	return parent::beforeValidate();
    }
}