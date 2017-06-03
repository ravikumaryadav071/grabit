<?php 
class user {
	private $_db,
			$_data,
			$_sessionName,
			$_isLoggedIn,
			$_cookieName;

	public function __construct($user = null) {
		$this->_db = DB::getInstance();

		$this->_sessionName = config::get('session/session_name');
		$this->_cookieName = config::get('remember/cookie_name');

		if (!$user) {
			if (session::exists($this->_sessionName)) {
				$user = session::get($this->_sessionName);
				//echo $user;
				if ($this->find($user)) {
					$this->_isLoggedIn = true;
				} else {
					//process Logout
				}
			}
		} else {
			$this->find($user);
		}
	}


	public function update($fields = array(), $id = null) {

		if (!$id && $this->isLoggedIn()) {
			$id = $this->data()->id;
		}

		if (!$this->_db->update('users', $id, $fields)) {
			throw new Exception('There was a problem updating.');
			
		}
	}

	public function create($fields = array()) {
		if(!$this->_db->insert('users', $fields)) {
			throw new Exception("There was a problem creating in account");
		}
	}

	public function find($user= null) {
		if($user) {
			$field = (is_numeric($user)) ? 'id' : 'username';
			$data = $this->_db->get('users', array($field, '=' ,$user));

			if ($data->count()) {
				$this->_data = $data->first();
				return true;
			}
		}
	}

	public function login($username = null, $password = null, $remember = false) {
		
		
		//print_r($this->_data);

		if (!$username && !$password && $this->exists()) {
			# Log user in
			session::put($this->_sessionName,$this->data()->id);

		} else {
				$user = $this->find($username);
				if ($user) {
					if ($this->data()->password === hash::make($password, $this->data()->salt)) {
						//echo "Okay";
						session::put($this->_sessionName, $this->data()->id);
						if ($remember) {
							$hash = hash::unique();
							$hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));

							if (!$hashCheck->count()) {
								$this->_db->insert('users_session',array(
									'user_id' => $this->data()->id,
									'hash' => $hash
								));
							} else {
								$hash = $hashCheck->first()->hash;
							}

							cookie::put($this->_cookieName, $hash, config::get('remember/cookie_expiry'));

						}
						return true;
					}
					
				}
			}

			return false;
	}

	public function hasPermission($key) {
		$group = $this->_db->get('groups', array('id', '=', $this->data()->group));
		//print_r($group->first());
		if ($group->count()) {
			$permissions = json_decode($group->first()->permissions, true);
			//print_r($permissions);
			if ($permissions[$key] == true) {
				return true;
			}
		}
		return false;
	}

	public function exists() {
		return (!empty($this->_data)) ? true : false;
	}

	public function logout() {
		$this->_db->delete('users_session', array('user_id', '=', $this->data()->id));
		session::delete($this->_sessionName);
		session::delete('cart');
		cookie::delete($this->_cookieName);
	}

	public function data() {
			return $this->_data;
	}

	public function isLoggedIn() {
		return $this->_isLoggedIn;
	}
}
?>
