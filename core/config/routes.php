<?php
define ('IN_CONTEXT_DEFAULT', 'front');
define ('IN_API_DEFAULT', 'api');

define ('IN_ROUTES', serialize(array(
	'default' => 'home',
	'manager' => array('login', 'admin'),
	'api' => array(
		'user' => 'user'
	)
)));
?>