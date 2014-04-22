<?php 
namespace Mailer\Admin\Controllers;

class Settings extends \Admin\Controllers\BaseAuth 
{
	use \Dsc\Traits\Controllers\Settings;
	
	protected $layout_link = 'Mailer/Admin/Views::settings/default.php';
	protected $settings_route = '/admin/mailer/settings';
    
    protected function getModel()
    {
        $model = new \Mailer\Models\Settings;
        return $model;
    }
}