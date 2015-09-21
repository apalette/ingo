<?php
define ('IN_CONTEXT_DEFAULT', 'front');

define ('IN_ROUTES', serialize(array(
	'default' => 'home',
	'manager' => array('login', 'admin')
)));
?>