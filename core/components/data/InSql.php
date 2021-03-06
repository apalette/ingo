<?php
/**
  * Ingo Sql
  *
  * PHP 5
  *
  * @package  data
  * @author   apalette
  * @version  1.0 
  * @since    24/09/2015 
  * 
  */
  
class InSql {
	protected static $_config;
	
	protected $_connexion;
	protected $_exception;
	protected $_query;
	protected $_data;
	protected $_type;
	protected $_params;
		
	public function __construct(){
		if (! self::$_config) {
			if (! defined('IN_DATABASE')) {
				$this->_exception = new Exception('Database Config not found');
			}
			else {
				self::$_config  = unserialize(IN_DATABASE);
			}
		}
    }
	
	public function select($columns = '*'){
		$this->_data = array();
		$this->_params = array();
		$this->_type = 1;
		$this->_query = 'SELECT '.(is_array($columns) ? implode(',', $columns) : $columns);
		return $this;
    }
	
	public function selectOne($columns = '*'){
		$this->_data = array();
		$this->_params = array('one' => true);
		$this->_type = 1;
		$this->_query = 'SELECT '.(is_array($columns) ? implode(',', $columns) : $columns);
		return $this;
    }
	
	public function from($table){
		$this->_query .= ' FROM '.$table; 
		return $this;
    }
	
	public function join($table, $on, $dir = 'LEFT') {
		$this->_query .= ' '.$dir.' JOIN '.$table.' ';
		if (is_array($on)) {
			$v = reset($on);
			$k = key($on);
			$this->_query .= 'ON '.($k.'='.$v).' ';
		}
		return $this;
	}
	
	public function where($conditions) {
		if (is_array($conditions)) {
			$this->_query .= ' WHERE';
			$i = 0;
			
			foreach ($conditions as $k => $v) {
				$op = '=';
				if (is_array($v)) {
					$op = $v[0];
					$v = $v[1];
				}
				
				$this->_query .= (($i > 0) ? ' AND ' : ' ');
				if ($v === null && ($op === '=' || $op === '!')) {
					$this->_query .= $k.(($op === '=') ? ' IS NULL' : ' IS NOT NULL');
				}
				else {
					$d_key = ':w_'.$k;
					$this->_data[$d_key] = $v;
					$this->_query .= ($k.' '.$op.' '.$d_key);
				}
				$i++;
			}
		}
		return $this;
	}
	
	public function order($orders) {
		if (is_array($orders)) {
			$this->_query .= ' ORDER BY';
			$i=0;
			$last = count($orders) - 1;
			
			foreach ($orders as $k => $v) {
				$dir = 'ASC';
				if (is_array($v)) {
					$dir = $v[1];
					$v = $v[0];
				}
				$this->_query .= (' '.$v.' '.$dir);
				if ($i != $last) {
					$this->_query .=',';
					$i++;
				}
			}
		}
		return $this;
	}
	
	public function update($table, $data) {
		$this->_data = array();
		$this->_params = array();
		$this->_type = 3;
		
		$this->_query = 'UPDATE '.$table.' SET';
		foreach ($data as $key => $value) {
			if ($value === null) {
				$this->_query.= ' '.$key.' = NULL, ';
			}
			else {
				$this->_data[':u_'.$key] = $value;
				$this->_query.= ' '.$key.' = :u_'.$key.', ';
			}
		}
		$this->_query = substr($this->_query, 0, strlen($this->_query) -2);
		
		return $this;
	}
	
	public function insert($table, $data) {
		$this->_data = array();
		$this->_params = array();
		$this->_type = 2;
		
		$keys = array();
		$values = array();
		
		foreach ($data as $key => $value) {
			$keys[] = $key;
			
			if ($value === null) {
				$values[] = 'NULL';
			}
			else {
				$values[] = ':i_'.$key;
				$this->_data[':i_'.$key] = $value;
			}
		}
		
		$this->_query = 'INSERT INTO '.$table.'('.implode(',', $keys).') VALUES ('.implode(',', $values).')';
		return $this;
	}

	public function execute(){
		$c = $this->_connect();
		
		if ($c) {
			$sql = $c->prepare($this->_query);
			try {
				if ($sql->execute($this->_data)) {
					$r = $this->_result($c,$sql);
					$c = $sql = null;
					
					return $r;
				}
			}	
			catch(PDOException $e) {
				$this->_exception = $e;
			}
		}
		return false;
	}
	
	public function getQuery() {
		return $this->_query;
	}
	
	public function getException() {
		return $this->_exception;
	}
	
	protected function _connect() {
		if (self::$_config) {
			try {
				$connexion = new PDO('mysql:host='.self::$_config['host'].';port='.self::$_config['port'].';dbname='.self::$_config['database'].';charset='.self::$_config['charset'], self::$_config['user'], self::$_config['password']);
				$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return $connexion;
			}
			catch(PDOException $e) {
				$this->_exception = $e;
			}
		}
		return false;
	}
	
	protected function _result($c, $sql) {
		switch($this->_type) {
			
			// select
			case 1 :
				$rows = $sql->fetchAll(PDO::FETCH_ASSOC);
				if (! isset($this->_params['one'])) {
					return ($rows && is_array($rows)) ? $rows : array();
				}
				else {
					return ($rows && is_array($rows)) ? $rows[0] : null;
				}
			
			// insert	
			case 2 :
				return $c->lastInsertId();
				
			// update
			case 3 :
				return true;
				
			default :
				return null;
		}
	}
}
?>