<?php 
namespace Mailer\Models;

class Emails extends \Dsc\Mongo\Collections\Nodes 
{
    public $queue_status = 'queued';
    public $send_result = null;
    
    protected $__collection_name = 'mailer.emails';
    protected $__type = 'mailer.emails';
    
    protected $__config = array(
        'default_sort' => array(
            'metadata.created.time' => 1
        ),
    );
}