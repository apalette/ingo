<?php
/**
  * Ingo Css
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
  
class InCSS {
	
	public static function display($css, $minify) {
		$css = self::_prepareCss($css);
		($minify && defined('IN_MINIFIER')) ? self::_displayMixed($css) : self::_displayUnMinify($css);
	}
	
	protected static function _prepareCss($css) {
		foreach ($css as $k => $v) {
			$v['href'] = (substr($v['href'], 0, 4) != 'http' && substr($v['href'], 0, 2) != '//') ? InRequest::getWebroot().$v['href'] : $v['href'];
			$css[$k] = $v;
		}
		return $css;
	}
	
	protected static function _displayUnMinify($css) {
		foreach ($css as $k => $v) {
			echo '<link type="'.$v['type'].'" rel="'.$v['rel'].'" href="'.$v['href'].'" />';
		}
	}
	
	protected static function _displayMinify($css) {
		if (count ($css) > 0) {
			$files = array();
			foreach($css as $k => $v) {
				$files[] = $v['href'];
			}
			echo '<link type="text/css" rel="stylesheet" href="'.InRequest::getWebroot().IN_MINIFIER.'?f='.implode(',',$files).'" />';
		}
	}
	
	protected static function _displayMixed($css) {
		$temp = array();
		$min = null;
		
		foreach ($css as $k => $v) {
			$cmin = (($v['rel'] == 'stylesheet') && (substr($v['href'], 0, 4) != 'http') && (substr($v['href'], 0, 2) != '//'));
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