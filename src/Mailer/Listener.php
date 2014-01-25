<?php 
namespace Mailer;

class Listener extends \Prefab 
{
    public function onSystemRebuildMenu( $event )
    {
        if ($mapper = $event->getArgument('mapper')) 
        {
        	$mapper->reset();
        	$mapper->priority = 50;
            $mapper->id = 'fa-mailer';
        	$mapper->title = 'Emails';
        	$mapper->route = '';
        	$mapper->icon = 'fa fa-envelope';
        	$mapper->children = array(
        			json_decode(json_encode(array( 'title'=>'List', 'route'=>'/admin/emails', 'icon'=>'fa fa-list' )))
        			,json_decode(json_encode(array( 'title'=>'Add New User', 'route'=>'/admin/email/create', 'icon'=>'fa fa-plus' )))
        			,json_decode(json_encode(array( 'title'=>'Detail', 'route'=>'/admin/email/view', 'hidden'=>true )))
        	);
        	$mapper->save();
        	
        	\Dsc\System::instance()->addMessage('Mailer added its admin menu items.');
        }
        
    }
}