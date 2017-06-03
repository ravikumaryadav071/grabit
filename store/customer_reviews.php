<?php
class customer_reviwes{
	private $_db,
			$_message,
			$_error;

	public function __construct(){
		try{

			$_db = DBstore::getInstance();

		}catch(Exception $e){

			die($e->getMessage());

		}
	}

	public function rating($orderid = NULL, $userid = NULL, $itemid =NULL, $catagory = NULL, $rating = NULL, $review = NULL){

		if(isset($orderid) && isset($userid) && isset($itemid) && isset($catagory) && isset($rating)){

			if($this->_db->query("SELECT * FROM orders_discrip WHERE orderid = ? AND userid = ? AND itemid = ?", array($orderid, $userid, $itemid), 'SELECT *')->count()){

				if($this->_db->query("SELECT * FROM customer_rewiews WHERE orderid = {$orderid} AND userid = {$userid} AND itemid = {$itemid}")->rowCount()){

					$this->_message = 'You have already given a review';
					$this->_error = false;
					return $this;

				}
			}else{

				$query = "INSERT INTO customer_rewiews (orderid, userid, itemid, catagory, rating, review) VALUES($orderid, $userid, $itemid, $catagory, $rating, $review)";
				if(!$this->_db->query($query)->error()){

					$this->_message = 'Your review has added. Thank you!';
					$this->_error = false;
					return $this;
				}else{

					$this->_message = 'Your review cannot be submitted right now';
					$this->_eror = true;
					return false;

				}

			}

		}

		return false;		

	}

	public function message(){

		return $this->_message;

	}

	public function error(){

		return $this->_error;

	}
}

?>