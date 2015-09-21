<?php
/**
  * Ingo Theme
  *
  * PHP 5
  *
  * @package  display
  * @author   apalette
  * @version  1.0 
  * @since    18/09/2015 
  */
  
class InTheme{
	
	public $title;
	public $page;
	public $layout;
	public $view;
	public $path;
	
	public function __construct() {
		if (defined('IN_TEMPLATE_DEFAULTS')) {
			$config = unserialize(IN_TEMPLATE_DEFAULTS);
			foreach ($config as $i => $v) {
				$this->$i = $v;
			}
		}
	}
	
	public function render() {
		require_once IN_TEMPLATE_PATH.'/'.$this->path.'/'.$this->layout.'.php';
	}
	
	public function renderPage() {
		echo $this->page;
	}
	
	public function renderTitle() {
		echo $this->title;
	}
	
	public function renderMetas() {
		
	}
	
	public function renderCss() {
		
	}
	
	public function renderJs() {
		
	}
	
	public function renderView() {
		require_once IN_TEMPLATE_PATH.'/'.$this->path.IN_TEMPLATE_VIEWS_PATH.'/'.$this->view.'.php';
	}
}
?>