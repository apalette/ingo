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
  * 
  * required display.InCss
  * required display.InJs
  * required main.InRequest
  */
  
class InTheme{
	
	public $title;
	public $description;
	public $page;
	public $layout;
	public $view;
	public $path;
	public $minify = true;
	
	protected $_css = array(
		'favicon1' => array('href' => 'favicon.ico', 'rel' => 'icon', 'type' => 'image/x-icon'),
		'favicon2' => array('href' => 'favicon.ico', 'rel' => 'shortcut icon', 'type' => 'image/x-icon'),
		'apple-touch-icon' => array('href' => 'apple-touch-icon.png', 'rel' => 'apple-touch-icon', 'type' => 'image/x-icon'),
	);
	
	protected $_js= array(
	);
	
	protected $_metas = array(
		'charset' => array('charset' => 'utf8'),
		'http-equiv' => array('http-equiv' => 'X-UA-Compatible', 'content' => 'IE=edge'),
		'viewport' => array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1'),
		'description' => array('name' => 'description', 'content' => '')
	);
	
	public function __construct() {
		if (defined('IN_TEMPLATE_DEFAULTS')) {
			$config = unserialize(IN_TEMPLATE_DEFAULTS);
			foreach ($config as $i => $v) {
				$this->$i = $v;
			}
		}
	}
	
	public function appendCss($css) {
		if (is_string($css)) {
			$this->_css[] = array('href' => $css, 'rel' => 'stylesheet', 'type' => 'text/css');
		}
		elseif (is_array($css) && isset($css['href'])) {
			$css['rel'] = isset($css['rel']) ? $css['rel'] : 'stylesheet';
			$css['type'] = isset($css['type']) ? $css['type'] : 'text/css';
			$this->_css[] = $css;
		}
	}

	public function appendJs($js) {
		if (is_string($js)) {
			$this->_js[] = $js;
		}
	}
	
	public function appendMeta($meta) {
		if (is_array($meta)) {
			$this->_metas[] = $meta;
		}
	}
	
	public function render() {
		$this->_metas['description']['content'] = $this->description;
		require_once IN_TEMPLATES_PATH.'/'.$this->path.'/'.$this->layout.'.php';
	}
	
	public function renderPage() {
		echo $this->page;
	}
	
	public function renderTitle() {
		echo $this->title;
	}
	
	public function renderMetas() {
		foreach ($this->_metas as $meta) {
			echo '<meta';
			foreach($meta as $k => $v) {
				echo ' '.$k.'="'.$v.'"';
			}
			echo ' />';
		}
	}
	
	public function renderCss() {
		InCss::display($this->_css, $this->minify);
	}
	
	public function renderJs() {
		InJs::display($this->_js, $this->minify);
	}
	
	public function renderView() {
		require_once IN_TEMPLATES_PATH.'/'.$this->path.IN_TEMPLATE_VIEWS_PATH.'/'.$this->view.'.php';
	}
}
?>