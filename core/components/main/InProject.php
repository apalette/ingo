<?php
/**
  * Ingo Project
  *
  * PHP 5
  *
  * @package  main
  * @author   apalette
  * @version  1.0 
  * @since    18/09/2015 
  */
  
class InProject{
	protected $_theme;
	protected $_page;
	protected $_context;
	
	public function __construct() {
		$this->_page = InRouter::getController();
		$this->_theme = new InTheme();
		$this->_theme->page = $this->_page;
		$this->_theme->path = InRouter::getContext();
		$this->_theme->view = $this->_page;
		
		if ($this->_page) {
			$theme = $this->_theme;
			$project = $this;
			require_once IN_CONTROLLERS_PATH.'/'.InRouter::getContext().'/'.InRouter::getController().'.php';
		}
	}
}
?>