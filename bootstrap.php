<?php 
$f3 = \Base::instance();
$global_app_name = $f3->get('APP_NAME');

switch ($global_app_name) 
{
    case "admin":
        // register event listener
        \Dsc\System::instance()->getDispatcher()->addListener(\Mailer\Listener::instance());
        
        // register all the routes
        $f3->route('GET|POST /admin/emails', '\Mailer\Admin\Controllers\Emails->display');
        $f3->route('GET|POST /admin/emails/@page', '\Mailer\Admin\Controllers\Emails->display');
        $f3->route('GET|POST /admin/emails/delete', '\Mailer\Admin\Controllers\Emails->delete');
        $f3->route('GET /admin/email', '\Mailer\Admin\Controllers\Email->create');
        $f3->route('POST /admin/email', '\Mailer\Admin\Controllers\Email->add');
        $f3->route('GET /admin/email/@id', '\Mailer\Admin\Controllers\Email->read');
        $f3->route('GET /admin/email/edit/@id', '\Mailer\Admin\Controllers\Email->edit');
        $f3->route('POST /admin/email/@id', '\Mailer\Admin\Controllers\Email->update');
        $f3->route('DELETE /admin/email/@id', '\Mailer\Admin\Controllers\Email->delete');
        $f3->route('GET /admin/email/delete/@id', '\Mailer\Admin\Controllers\Email->delete');        
      
        // append this app's UI folder to the path, e.g. UI=../apps/blog/admin/views/
        
        // TODO set some app-specific settings, if desired
        $ui = $f3->get('UI');
        $ui .= ";" . $f3->get('PATH_ROOT') . "vendor/dioscouri/f3-mailer/src/Mailer/Admin/Views/";
        $f3->set('UI', $ui);
                        
        break;
    case "site":    
      
        // TODO register all the routes
        
        // append this app's UI folder to the path, e.g. UI=../apps/blog/site/views/
                
        // TODO set some app-specific settings, if desired
        break;
}
?>