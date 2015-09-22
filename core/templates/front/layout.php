<!DOCTYPE html>
<html class="<?php $this->renderPage() ?>">
    <head>
    	<title><?php $this->renderTitle() ?></title>
    	<?php $this->renderMetas() ?>
    	<?php $this->renderCSS() ?>
    </head>
    <body>
    	<?php $this->renderView() ?>
    	<?php $this->renderJS() ?>
    </body>
</html>