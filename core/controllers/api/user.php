<?php
if ($api->getParam('token') != 1) {
	$api->setError(401);
}
else {
	$api->data= array('id' => $api->getParam('id'));
}
?>