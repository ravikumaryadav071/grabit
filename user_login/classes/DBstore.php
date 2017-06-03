<?php
class DBstore{

	private static $_instance = null;
	private $_error = false,
			$_pdo,
			$_query,
			$_results,
			$_assocresults,
			$_count = 0;
	private function __construct(){

		try{
			$this->_pdo = new PDO('mysql:host=' . storeconfig::get('mysql/host') . '; dbname='. storeconfig::get('mysql/db'), storeconfig::get('mysql/username'), storeconfig::get('mysql/password'));
			$this->_pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public static function getstoreInstance(){
		if(!isset(self::$_instance)){
			self::$_instance = new DBstore();
		}
		return self::$_instance;
	}
	public function query($sql, $params = array(), $operation){

		$this->_error = false;
		if($this->_query = $this->_pdo->prepare($sql)){
			$x = 1;
			if(count($params)){
				foreach($params as $param){
					$this->_query->bindValue($x, $param);
					$x++;
				}
			}
			if($this->_query->execute()){
				if($operation == 'SELECT' || $operation == 'SELECT *'){
					$this->_results = $this->_query->fetchALL(PDO::FETCH_OBJ);
					$this->_query->execute();
					$this->_assocresults = $this->_query->fetchALL(PDO::FETCH_ASSOC);
					$this->_count = $this->_query->rowCount();
				}
			}else{
				$this->_error = true;
			}
		}
		
		return $this;
	}

	private function action($action, $table, $where = array()){
		if(count($where) == 3){
			$operators = array('=', '>', '<', '<=', '>=');
			$field = $where[0];
			$operator = $where[1];
			$value = $where[2];
			if(in_array($operator, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
				if(!$this->query($sql,array($value), $action)->error()){
					return $this;
				}
			}
		}
		return false;
	}

	public function get($table, $where= array()){
		return $this->action('SELECT *', $table, $where);
	}

	public function delete($table, $where = array()){
		return $this->action('DELETE', $table, $where);
	}

	public function insert($table, $fields = array()){
		$keys = array_keys($fields);
		$value = '';
		$x = 1;
		foreach($fields as $field){
			$value .= '?';
			if($x<count($fields)){
				$value.=',';
			}
			$x++;
		}

		$sql = "INSERT INTO {$table}(`". implode('`,`', $keys) ."`) VALUES ({$value})";
		if(!$this->query($sql, $fields, 'INSERT')->error())
		{
			return true;
		}
		return false;
	}

	public function update($table, $fields = array(),$where = array()){

		$set = '';
		$x = 1;
		foreach($fields as $name => $value){
			$set .= "{$name} = ?";
			if($x<count($fields)){
				$set.=',';
			}
			$x++;
		}

		$sql = "UPDATE {$table} SET {$set} WHERE {$where[0]} {$where[1]} {$where[2]}";
		if(!$this->query($sql, $fields, 'UPDATE')->error()){
			return true;
		}
		return false;
	}

	public function results(){

		return $this->_results;
	}

	public function first(){
		$data = $this->results();
		return $data[0];
	}

	public function count(){
		return $this->_count;
	}

	public function error(){
		return $this->_error;
	}

	public function assocresults(){
		return $this->_assocresults;
	}
}
?>