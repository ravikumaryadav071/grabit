<?php
class validateorder{

	private $_errors = array(),
			$_passed = false;

	public function validate($name, $phone_no, $pincode, $city, $state){

		if(!isset($name)){

			$this->_errors[] = "You have not entered a name. Please enter a name";

		}

		if(!isset($phone_no)){

			$this->_errors[] = "You have not entered Contact Number. Enter your Contact Number.";

		}

		if(isset($phone_no)){

			$len = strlen($phone_no);
			if($len <= 6 || !(is_numeric($phone_no))){

				$this->_errors[] = "Your Contact Number is not correct.";

			}
		}

		if(!isset($pincode)){

			$this->_errors[] = "Please enter your Pincode.";
			
		}

		if(isset($pincode)){

			$len = strlen($pincode);
			if($len != 6 || !(is_numeric($pincode))){

				$this->_errors[] = "Your Pincode is not correct.";

			}
		}

		if(isset($city)){

			if(!in_array($city, array('Delhi', 'Noida', 'Faridabad', 'Gurgaon'))){

				$this->_errors[] = "You have entered wrong City.";

			}

		}

		if(isset($state)){

			if(!in_array($state, array('New Delhi', 'NCR'))){

				$this->_errors[] = "You have entered wrong State.";

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