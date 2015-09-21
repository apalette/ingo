<?php
define ('IN_CORE_PATH', __DIR__);
define ('IN_CONFIG_PATH', IN_CORE_PATH.'/config');
define ('IN_COMPONENTS_PATH', IN_CORE_PATH.'/components');
define ('IN_CONTROLLERS_PATH', IN_CORE_PATH.'/controllers');

require_once IN_CONFIG_PATH.'/routes.php';
require_once IN_COMPONENTS_PATH.'/main/InRequest.php';
require_once IN_COMPONENTS_PATH.'/main/InRouter.php';
require_once IN_COMPONENTS_PATH.'/api/InApi.php';

if (defined('IN_ENV') && IN_ENV === 'dev') {
	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
}
$api = new InApi();
$api->displayData();
?>