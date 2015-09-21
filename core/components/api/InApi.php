<?php
/**
  * Ingo API
  *
  * PHP 5
  *
  * @package  api
  * @author   apalette
  * @version  1.0 
  * @since    21/09/2015 
  */
  
class InApi{
	
	protected static $_error_codes = array(
		404 => 'The URI requested is invalid',
		422 => 'Missing parameters'
	);
	protected $_controller;
	public $path;
	public $data;
	
	public function __construct($path = null) {
		$this->path = $path ? $path : (defined('IN_API_DEFAULT') ? IN_API_DEFAULT : null);
		$this->_controller = InRouter::getController();
		if ($this->path && $this->_controller) {
			$c = IN_CONTROLLERS_PATH.'/'.$this->path.'/'.InRouter::getController().'.php';
			if (file_exists($c)) {
				$api = $this;
				require_once $c;
			}
		}
	}
	
	public function displayData() {
		InApi::_displayHeader();
		if (! $this->data || ! is_array($this->data)) {
			$this->setError(404);
		}
		echo json_encode($this->data);
	}
	
	public function setError($code) {
		if (isset(self::$_error_codes[$code])) {
			$this->data = array('error' => array($code => self::$_error_codes[$code]));
		}
	}
	
	protected static function _displayHeader() {
		$origin = isset($_SERVER['HTTP_ORIGIN'])? $_SERVER['HTTP_ORIGIN']: $_SERVER['HTTP_HOST'];
		header('Access-Control-Allow-Origin: '.$origin);
		header('Access-Control-Allow-Methods: GET, POST');
		header('Access-Control-Allow-Credentials: true');
	}
}
?>