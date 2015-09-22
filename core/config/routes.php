<?php
define ('IN_CONTEXT_DEFAULT', 'front');
define ('IN_API_DEFAULT', 'api');
define ('IN_MINIFIER', 'min.php');

define ('IN_ROUTES', serialize(array(
	'default' => 'home',
	'manager' => array('login', 'admin'),
	'api' => array(
		'user' => array('user', array('id', 'token'), 'GET')
	)
)));
?>