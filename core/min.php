<?php
define ('IN_CORE_PATH', __DIR__);
define ('IN_COMPONENTS_PATH', IN_CORE_PATH.'/components');
define ('IN_VENDORS_PATH', IN_CORE_PATH.'/vendors');

require_once IN_COMPONENTS_PATH.'/main/InRequest.php';

define('IN_MIN_WEB_ROOT', InRequest::getWebRoot());
require_once IN_VENDORS_PATH.'/minify/index.php';
?>