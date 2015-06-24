<?php
namespace Mailer\Admin;

class Routes extends \Dsc\Routes\Group
{
    public function initialize()
    {
        $this->setDefaults(array(
            'namespace' => '\Mailer\Admin\Controllers',
            'url_prefix' => '/admin/mailer'
        ));
        
        $this->addSettingsRoutes();
        
        $this->add( '', 'GET', array(
            'controller' => 'Home',
            'action' => 'index'
        ) );

        $this->addCrudGroup( 'Templates', 'Template' );
        $this->addCrudGroup( 'Emails', 'Email' );
        $this->addCrudGroup( 'Events', 'Event' );
        $this->addCrudGroup( 'Blocks', 'Block' );
        
        $this->add( '/template/create/@event_id', 'GET', array(
            'controller' => 'Template',
            'action' => 'createFromEvent'
        ) );
        
        $this->add( '/template/create/@event_id', 'POST', array(
            'controller' => 'Template',
            'action' => 'saveFromEvent'
        ) );
        
        $this->add( '/contentvariants/quickadd/@id', 'GET', array(
        		'controller' => 'ContentVariant',
        		'action' => 'quickAdd'
        ) );
        
        $this->app->route('GET /admin/mailer/registerEmails', function($app){
            $mailer_settings = \Mailer\Models\Settings::fetch();
            $result = \Dsc\System::instance()->trigger('onSystemRegisterEmails');
            
            $mailer_settings->{'emails_registered'} = time();
            $mailer_settings->save();
            
            $app->reroute('/admin/mailer/templates');
        });
    }
}