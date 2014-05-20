<?php
namespace Mailer\Admin;

class Listener extends \Prefab
{

    public function onSystemRebuildMenu($event)
    {
        if ($model = $event->getArgument('model'))
        {
            $root = $event->getArgument('root');
            $emails = clone $model;
            
            $emails->insert(array(
                'type' => 'admin.nav',
                'priority' => 100,
                'title' => 'Emails',
                'icon' => 'fa fa-envelope',
                'is_root' => false,
                'tree' => $root,
                'base' => '/admin/mailer'
            ));
            
            $children = array(
                array(
                    'title' => 'Dashboard',
                    'route' => './admin/mailer',
                    'icon' => 'fa fa-dashboard'
                ),
                array(
                    'title' => 'List',
                    'route' => './admin/mailer/emails',
                    'icon' => 'fa fa-list'
                ),
                array(
                    'title' => 'Settings',
                    'route' => './admin/mailer/settings',
                    'icon' => 'fa fa-cogs'
                )
            );
            $emails->addChildren($children, $root);
            
            \Dsc\System::instance()->addMessage('Mailer added its admin menu items.');
        }
    }
}