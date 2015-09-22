<?php
/**
  * Ingo Js
  *
  * PHP 5
  *
  * @package  display
  * @author   apalette
  * @version  1.0 
  * @since    22/09/2015 
  * 
  * required main.InRequest
  */
  
class InJs {
	
	public static function display($js, $minify) {
		$js = self::_prepareJs($js);
		($minify && defined('IN_MINIFIER')) ? self::_displayMixed($js) : self::_displayUnMinify($js);
	}
	
	protected static function _prepareJs($js) {
		foreach ($js as $k => $v) {
			$js[$k] = (substr($v, 0, 4) != 'http' && substr($v, 0, 2) != '//') ? InRequest::getWebroot().$v : $v;
		}
		return $js;
	}
	
	protected static function _displayUnMinify($js) {
		foreach ($js as $k => $v) {
			echo '<script type="text/javascript" src="'.$v.'"></script>';
		}
	}
	
	protected static function _displayMinify($js) {
		if (count ($js) > 0) {
			echo '<script type="text/javascript" src="'.InRequest::getWebroot().IN_MINIFIER.'?f='.implode(',',$js).'"></script>';
		}
	}
	
	protected static function _displayMixed($js) {
		$temp = array();
		$min = null;
		
		foreach ($js as $k => $v) {
			$cmin = (substr($v, 0, 4) != 'http' && substr($v, 0, 2) != '//');
			if ($min !== null && $cmin != $min) {
				$min ? self::_displayMinify($temp) : self::_displayUnMinify($temp);
				$temp = array();
				
			}
			$min = $cmin;
			$temp[] = $v;
		}
		
		if ($min !== null) {
			$min ? self::_displayMinify($temp) : self::_displayUnMinify($temp);
		}
	}
}
?>