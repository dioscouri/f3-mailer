<?php 
namespace Mailer\Admin;

class Listener extends \Prefab 
{
    public function onSystemRebuildMenu( $event )
    {
        if ($mapper = $event->getArgument('mapper')) 
        {
        	$mapper->reset();
        	$mapper->priority = 50;
        	$mapper->title = 'Emails';
        	$mapper->base = '/admin/mailer';
        	$mapper->route = '';
        	$mapper->icon = 'fa fa-envelope';
        	$mapper->children = array(
        	        json_decode(json_encode(array( 'title'=>'Dashboard', 'route'=>'/admin/mailer', 'icon'=>'fa fa-dashboard' )))
        			,json_decode(json_encode(array( 'title'=>'List', 'route'=>'/admin/mailer/emails', 'icon'=>'fa fa-list' )))
        	        ,json_decode(json_encode(array( 'title'=>'Settings', 'route'=>'/admin/mailer/settings', 'icon'=>'fa fa-cogs' )))
        	);
        	$mapper->save();
        	
        	\Dsc\System::instance()->addMessage('Mailer added its admin menu items.');
        }
        
    }
}