<?php
/**
  * Ingo Request
  *
  * PHP 5
  *
  * @package  main
  * @author   apalette
  * @version  1.0 
  * @since    18/09/2015 
  */
  
class InRequest{
	protected static $_webroot;
	protected static $_abs_webroot;
	protected static $_url_parts;
	
	protected static function _analyze() {
		if (! self::$_abs_webroot) {
			self::_analyzeUrl();
		}
	}
	
	protected static function _analyzeUrl() {
		
		// Webroot
    	$base = str_replace('//','',dirname($_SERVER['PHP_SELF']));
		if ($base === DIRECTORY_SEPARATOR || $base === '.') {
        	$base = '';
        }
		self::$_webroot = $base.'/';
		
		// Url
		self::$_url_parts = array();
		$s = substr(self::$_webroot, 0, strlen(self::$_webroot));
		$pos = strpos($_SERVER['REQUEST_URI'], $s);
		$navurl = ($pos !== 0) ? '' : substr($_SERVER['REQUEST_URI'], strlen($s));
		
		if ($navurl != '') {
			$uriwithoutanchor = explode("#", $navurl);
			$uriwithoutparameters = explode("?", $uriwithoutanchor[0]);
			$uri = explode("/", $uriwithoutparameters[0]);
			if (is_array($uri)) {
				foreach ($uri as $path) {
					if ($path != '') {
						array_push(self::$_url_parts, $path);
					}
				}
			}
		}
	}
	
	public static function getWebroot($abs = false) {
		self::_analyze();
		return $abs ? self::$_abs_webroot : self::$_webroot;
	}
	
	public static function getUrlPart($i = 1) {
		self::_analyze();
		$i--;
		return isset(self::$_url_parts[$i]) ? self::$_url_parts[$i] : null;
	}
}
?>