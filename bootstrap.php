<?php 
$f3 = \Base::instance();
$global_app_name = $f3->get('APP_NAME');

switch ($global_app_name) 
{
    case "admin":
        // register event listener
        \Dsc\System::instance()->getDispatcher()->addListener(\Mailer\Listener::instance());
      
    	// register all the routes
    	\Dsc\System::instance()->get('router')->mount( new \Mailer\Admin\Routes, 'mailer' );
        // append this app's UI folder to the path
        // new way
        \Dsc\System::instance()->get('theme')->registerViewPath( __dir__ . '/src/Mailer/Admin/Views/', 'Mailer/Admin/Views' );
        // old way
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