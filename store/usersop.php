<?php

class usersop{
	private $_db,
			$_message = '',
			$_error = false,
			$_received = 0;

	public function __construct(){
		try{

			$this->_db = DBstore::getstoreInstance();

		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public function add_to_wishlist($userid = NULL, $itemid = NULL, $catagory = NULL){

		if(isset($itemid) && isset($userid) && isset($catagory)){

			if($this->_db->query("SELECT * FROM wishlist WHERE userid = ? AND itemid = ?", array($userid, $itemid), 'SELECT *')->count == 0){

				$arr = array(	'userid' => $userid,
								'itemid' => $itemid,
								'catagory' => $catagory);
				$tablename = 'wishlist';
				$this->_db->insert($tablename, $arr);
				if(!$this->_db->error()){

					$this->_message = 'Your item has added to your wishlist';
					$this->_error = false;
				
				}else{

				$this->_message = 'This item is already is in your wishlist.';
				$this->_error = true;
				return $this;

				}

			}else{

				$this->_message = 'There is a problem in adding the item to the wishlist. Try again!';
				$this->_error = true;
				return $this;
			}

			return false;
		
		}
	}

	public function delete_from_wishlist($userid = NULL, $itemid = NULL){

		if(isset($userid) && isset($itemid)){

			$set = '';
			$x = 1;
			$sql = "DELETE FROM wishlist WHERE userid = ? AND itemid = ?";
			$this->_db->query($sql, array($userid, $itemid), 'DELETE');
			$this->_message = 'Item has removed from your wishlist';
			$this->_error = false;
			return $this;

		}else{

			$this->_message = 'You cannot remove this item right now. Try again!';
			$this->_error = true;
			return $this;

		}

		return false;

	}

	public function place_order_discrip($orderid = NULL, $itemid = NULL, $userid = NULL, $catagory = NULL, $qty = 1){

		if(isset($orderid) && isset($itemid) && isset($userid) && isset($catagory)){

			$arr = array(	'orderid' => $orderid,
							'userid' => $userid,
							'itemid' => $itemid,
							'catagory' => $catagory,
							'quantity' => $qty);
			$tablename = 'orders_discrip';
			$this->_db->insert($tablename, $arr);
			if(!$this->_db->error()){

				//to increment the flag count
				$result1 = $this->_db->get('catagory_list',array('catagory_id','=',$catagory))->first();
				$catagoryname = $result1->catagory_table;
				$result2 = $this->_db->get($catagoryname,array('itemid','=',$itemid))->first();
				$flag = $result2->flag + 1;
				$stock = $result2->stock - $qty;
				$this->_db->update($catagoryname, array('flag' => $flag), array('itemid', '=', $itemid));
				$this->_error = false;

			}else{
				$this->_error = true;
			}
			return $this;
		}

		return false;

	}

	public function place_order($userid = NULL, $name = NULL, $address = NULL, $state = NULL, $pin = NULL, $amount = NULL, $recevied = NULL){

		if(isset($userid) && isset($name) && isset($address) && isset($state) && isset($pin) && isset($amount)){
			$arr = array(	'userid' => $userid,
							'name' => $name,
							'address' => $address,
							'state' => $state,
							'pincode' => $pin,
							'amount' => $amount,
							'recevied' => $recevied
							);
			$tablename = 'orders';
			$this->_db->insert($tablename, $arr);
			if(!$this->_db->error()){

				$this->_message = 'Your order has placed. Thank You!';
				$this->_error = false;
			
			}else{

				$this->_message = 'There is a problem in placing the order. Please try again';
				$this->_error = true;
			}

			return $this;

		}

		return false;

	}

	public function cancel_order($orderid = NULL){

		if(isset($orderid)){

			$order = $this->_db->get('orders', array('orderid', '=', $orderid))->assocresults();
			$this->_db->insert('cancel_orders', $order);
			$orders_detail = $this->_db->get('orders_discrip', array('orderid', '=', $orderid));
			$orders_detail_assoc = $orders_detail->assocresults();
			for($i = 0; $i<$this->_db->count(); $i++){
			
				$this->_db->insert('cancel_orders_details', $orders_detail_assoc[$i]);
				$orders_detail_obj = $orders_detail->fetch_object();
				$stock = $this->_db->get($orders_detail_obj->catagory, array('itemid', '=', $orders_detail_obj->itemid)) + $orders_detail_obj->quantity;
				$this->_db->update($orders_detail_obj->catagory, array('stock'=>$stock),array('itemid', '=', $orders_detail_obj->itemid));
			
			}

			$this->_db->delete('orders', array('orderid', '=', $orderid));
			$this->_db->delete('orders_discrip', array('orderid', '=', $orderid));
			$this->_message = 'Your order has cancelled.';
			$this->_error = false;
			return $this;

		}else{

			$this->_message = 'Oops! There is a problem. Your order cannot be cancelled right now. Try Again.';
			$this->_error = true;
			return $this;
		}

		return false;

	}

	public function check_stock($itemid, $catagory, $qty = 1){

		$limit = $this->_db->get($catagory,array('itemid', '=', $itemid))->first();
		if($limit->stock < $qty){

			$this->_message = "There are total {$limit->stock} items left. Your order quantity exceeding the stock limit";
			$this->_error = true;
			return $this;

		}else{
			$this->_error = false;
		}

		return $this;

	}

	public function payment_reqiured($orderid = NULL){

		if(isset($orderid)){

			$amt = $this->_db->query("SELECT * FROM orders WHERE orderid = ?", array($orderid), 'SELECT')->first();
			$this->_recevied = $amt->amount * 0.10;
			$this->_message = "You have to pay {$this->_recevied} amount in order to confirm your order.(10% of your total amount)";
			$this->_error = false;
			return $this;

		}else{

			$this->_error = true;
			return $this;
		}

		return false;

	}

	public function payment_received($orderid = NULL, $amount = NULL, $received = NULL){

		if(isset($orderid) && isset($received) && $received == 'yes' && isset($amount)){

			$this->_db->update('orders', array('received' => $amount), array('orderid', '=', $orderid));
			if(!$this->_db->error()){
				$this->_message = 'Your payment has received. Thank You!';
				$this->_error = false;
				return $this;

			}else{

				$this->_error = true;
				return $this;
			}

			return $this;
		}

		return false;

	}

	public function recently_viewed($userid = NULL, $itemid = NULL, $catagory = NULL){

		if(isset($itemid) && isset($userid) && isset($catagory)){
				if($this->_db->query("SELECT * FROM wishlist WHERE userid = ? AND itemid = ?", array($userid, $itemid), 'SELECT *')->count() != 0){

					return $this;

				}
				$tablename = 'recently_viewed';
				$query = "SELECT * FROM recently_viewed ORDER BY viewedid";

				if($this->_db->query($query, array(), 'SELECT *')->count() >= 10){

					$res = $this->_db->first();
					$where = array('viewedid','=', $res->viewedid);
					$this->_db->delete('recently_viewed', $where);

				}

				if($this->_db->query($query, array(), 'SELECT *')->count() < 10){

				$arr = array(	'userid' => $userid,
								'itemid' => $itemid,
								'catagoryid' => $catagory);

				$this->_db->insert($tablename, $arr);
				if(!$this->_db->error()){

					$this->_error = false;

				}else{

					$this->_error = true;

				}

				return $this;

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

	public function received(){

		return $this->_received;
	}

}
?>