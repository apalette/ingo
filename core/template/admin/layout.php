<!DOCTYPE html>
<html class="<?php $this->renderPage() ?>">
    <head>
    	<title><?php $this->renderTitle() ?></title>
    	<?php $this->renderMetas() ?>
    	<?php $this->renderCSS() ?>
    	<?php $this->renderJS() ?>
    </head>
    <body>
    	<?php $this->renderView() ?>
    </body>
</html>