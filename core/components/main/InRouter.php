<?php
/**
  * Ingo Router
  *
  * PHP 5
  *
  * @package  main
  * @author   apalette
  * @version  1.0 
  * @since    18/09/2015 
  */
  
class InRouter{
	
	protected static $_routes;
	protected static $_controller;
	protected static $_context;
	protected static $_params;
	
	protected static function _load() {
		if (! self::$_routes) {
			if (defined('IN_ROUTES')) {
				self::$_routes = unserialize(IN_ROUTES);
			}
		}
	}
	
	protected static function _process() {
		if (! self::$_controller) {
			self::_load();
			if (self::$_routes) {
				self::_parseRequest(self::$_routes, 1);
			}
		}
	}
	
	protected static function _parseRequest($routes, $level) {
		$p = InRequest::getUrlPart($level);
		if ($p && isset($routes[$p])) {
			if (! is_array($routes[$p])) {
				self::$_controller = $routes[$p];
				self::$_context = IN_CONTEXT_DEFAULT;
			}
			else {
				self::_parseRequest($routes[$p], $level + 1);
			}
		}
		else {
			if (isset($routes['default'])) {
				if (! is_array($routes['default'])) {
					self::$_controller = $routes['default'];
					self::$_context = IN_CONTEXT_DEFAULT;
				}
				else {
					self::$_controller = $routes['default'][0];
					self::$_context = isset($routes['default'][1]) ? $routes['default'][1] : IN_CONTEXT_DEFAULT;
					self::$_params = isset($routes['default'][2]) ? $routes['default'][2] : null;
				}
			}
			else {
				self::$_controller = $routes[0];
				self::$_context = isset($routes[1]) ? $routes[1] : IN_CONTEXT_DEFAULT;
				self::$_params = isset($routes[2]) ? $routes[2] : null;
			}
		}
	}
	
	public static function getController() {
		self::_process();
		return self::$_controller;
	}
	
	public static function getContext() {
		self::_process();
		return self::$_context;
	}
	
	public static function getParams() {
		self::_process();
		return self::$_params ? self::$_params : array();
	}
}
?>