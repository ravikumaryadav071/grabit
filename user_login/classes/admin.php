<?php

class admin{

	private $_db,
			$_results,
			$_assocresults,
			$_count,
			$_message = '',
			$_error = false;

	public function __construct(){

		try{

			$this->_db = DBstore::getstoreInstance();

		}catch(PDOException $e){

			die($e->getMessage());

		}

	}

	public function get_order_details($tablename = NULL, $details = array()){
		
		if(isset($details) && isset($tablename)){	
			
			$count = 1;
			$str = "";
			foreach($details as $key=>$value){

				if($count == 1){

					$str = "{$key} = ?";

				}else{

					$str .= " AND {$key} = ?";
				}

				$count++;

			}

			$query = "SELECT * FROM {$tablename} WHERE " .$str;
			$this->_results = $this->_db->query($query, $details, 'SELECT *')->results();
			$this->_assocresults = $this->_db->assocresults();
			$this->_count = $this->_db->count();
			$this->_error = false;
			return $this;

		}else{

			$this->_error = true;
			$this->_message = 'You got some problem. Try again!';
			return $this;

		}

		return false;

	}

	public function results(){

		return $this->_results;

	}

	public function assocresults(){

		return $this->_assocresults;

	}

	public function count(){

		return $this->_count;

	}

	public function error(){

		return $this->_error;

	}

	public function message(){

		return $this->_message;

	}

}

?>