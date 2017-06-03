<?php
class cart{
	private $_message = '',
			$_totalprice = 0,
			$_totalqty = 0;
	
	public function add_to_cart($itemid, $itemcat, $itemqty = 1){
		if(!isset($_SESSION['cart'])){

			$_SESSION['cart'] = array();
		}
		if(!isset($_SESSION['cart'][$itemid])){
			$_SESSION['cart'][$itemid] = array(
				'itemid' => $itemid,
				'catagoryid' => $itemcat,
				'qty' => $itemqty 
				);

			$this->_message = "This product is added to your cart.";
			
			return $this;
			}
			else{

				$this->_message = "Your item is already added to the cart, you can't add it again.";
				return false;
			}
	}

	public function edit_qty($itemid, $itemqty){

		if(isset($_SESSION['cart'][$itemid])){

			$_SESSION['cart'][$itemid]['qty'] = $itemqty;
			$this->_message = "Your changes have saved successfully";
			return $this;

		}else{

			$this->_message = "Your changes can't be saved right now.";
			return $this;
		}

		return false;

	}

	public function delete_from_cart($itemid){

		if(isset($_SESSION['cart'][$itemid])){

			unset($_SESSION['cart'][$itemid]);
			$this->_message = "Item is successfully removed from the cart";
			return $this;

		}else{

			$this->_message = "This item is can't be deleted. Please try again.";
			return false;
		}
	}

	public function total(){

		if(count(isset($_SESSION['cart']))){

			$cart = $_SESSION['cart'];
			foreach($cart as $itemid){
				$priceofitem = $this->get_price_of_item($itemid['itemid'], $itemid['catagoryid']);
				$this->_totalprice += $priceofitem*$itemid['qty'];
				$this->_totalqty += $itemid['qty'];
			}
		}
		return $this;
	}

	private function get_price_of_item($itemid = NULL, $itemcat = NULL){

		if(isset($itemid) && isset($itemcat)){

			$db = DBstore::getstoreinstance();
			$arr = array('catagory_id', '=',  $itemcat);
			$catagory = $db->get('catagory_list', $arr)->first();
			$catagory_table = $catagory->catagory_table;
			$arr = array('itemid', '=', $itemid);
			$itemdetail = $db->get($catagory_table, $arr)->first();
			$priceofitem = $itemdetail->price;
			return $priceofitem;
		}
	}

	public function message(){

		return $this->_message;
	}

	public function total_price(){

		$this->total();
		return $this->_totalprice;
	}

	public function total_qty(){
		
		$this->total();
		return $this->_totalqty;
	}
}

?>