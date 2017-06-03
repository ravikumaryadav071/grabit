<?php
class validateorder{

	private $_errors = array(),
			$_passed = false;

	public function validate($name, $address, $state, $pincode){

		if(!isset($name)){

			$this->_errors[] = "You have not entered a name. Please enter a name";

		}

		if(!isset($state)){

			$this->_errors[] = "You have not entered your address. Enter your address.";

		}

		if(!isset($pincode)){

			$this->_errors[] = "Please enter your Pincode.";
			
		}

		if(isset($pincode)){

			$len = strlen($pincode);
			if($len != 6 || !(is_numeric($pincode)){

				$this->_errors[] = "Your Pincode is not correct.";

			}
		}

		if(empty($this->_errors)){

			$this->_passed = true;

		}else{

			$this->_passed = false;
		}

		return $this;
		
	}

	public function passed(){

		return $this->_passed;

	}

	public function errors(){

		return $this->_errors;
	}

}

?>