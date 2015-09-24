<?php
require_once IN_CONFIG_PATH.'/database.php';
require_once IN_COMPONENTS_PATH.'/data/InSql.php';

$sql = new InSql();
//$r = $sql->select()->from('user')->where(array('email' => 'test', 'id' => array('>', 2), 'password' => array('!', null)))->execute();
$r = $sql->select()->from('user')->where(array('id' => array('=', 1)))->order(array('id', array('email', 'DESC')))->execute();
echo $sql->getQuery().' <br>';
if ($r) {
	print_r($r);
}
else {
	print_r($sql->getException());
}

$theme->render();
?>