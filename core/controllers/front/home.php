<?php
/*$theme->appendCss(array('href' => 'http://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic'));
$theme->appendCss('assets/css/test.css');
$theme->appendJs('//code.jquery.com/jquery-1.11.3.min.js');
$theme->appendJs('assets/js/test.js');*/
//$theme->appendMeta(array('name' => 'description', 'content' => 'My project description'));
$theme->setVar('name', 'John');
$theme->setVar('dependencies', (defined('PROJECT_PATH') ? 'loaded' : 'not loaded'));
$theme->render();
?>
