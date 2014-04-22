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
                
        $this->addCrudGroup( 'Emails', 'Email' );
    }
}