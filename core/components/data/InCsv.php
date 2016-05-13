<?php

/**
  * Ingo Csv
  *
  * PHP 5
  *
  * @package  data
  * @author   apalette
  * @version  1.0 
  * @since    13/05/2015 
  * 
  */
  
class InCsv {
	protected $_header = array();
	protected $_custom_header = array();
	protected $_data = array();
	protected $_name = 'data';
	protected $_file = null;
	
	public function addLine($data) {
		if (is_array($data)) {
			foreach($data as $k => $v) {
				if (! in_array($k, $this->_header)) {
					$this->_header[] = $k;
				}
			}
			$this->_data[] = $data;
		}
	}
	
	public function setHeader($header) {
		if (is_array($header)) {
			$this->_custom_header = $header;
		}
	}
	
	public function setName($name) {
		$this->_name = $name;
	}
	
	public function export($file) {
		$this->_file = $file;
		$this->display();
	}
	
	public function display() {
		
		/**
		 * Open
		 */
		// send response headers to the browser
		if(! $this->_file) {
			header('Content-Type: text/csv; charset=utf-8');
            header( 'Content-Disposition: attachment;filename='.$this->_name.'.csv');
            $fp = fopen('php://output', 'w');
		}
		// open file
		// @todo test
		else {
			 $fp = fopen($this->_file, 'w');
		}
		
		/**
		 * Write
		 */
		// Display Header
		$header = array();
		foreach ($this->_header as $h) {
			$header[] = isset($this->_custom_header[$h]) ? $this->_custom_header[$h] : $h;
		}
		fputcsv($fp, $header, ';');
		
		// Display Data
		foreach ($this->_data as $data) {
			$line = array();
			foreach($this->_header as $h) {
				$line[$h] = isset($data[$h]) ? $data[$h] : '';
			}
			fputcsv($fp, $line, ';');
		}
		
		/*
		 * Close
		 */
		fclose($fp);
	}
}
?>