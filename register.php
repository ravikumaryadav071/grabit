</br>
</br>
</br>
</br>
<?php

include'navbar.php';
?>
<?php
//var_dump(token::check(input::get('token')));

if(input::exists()) {
	//echo "submitted";
	//echo Input::get('username');
	if(token::check(input::get('token'))) {
		//echo "I have been run";
			$validate = new Validate();
			$validation = $validate->check($_POST, array(
				'username' => array(
						'required' => true,
						'min' => 2,
						'max' => 30,
						'unique' => 'users'
					),
				'email' => array(
						'required' => true,
						'min' => 3
					),
				'password' => array(
					'required' => true,
					'min' => 6

					),
				'password_again' => array(
					'required' => true,
					'matches' => 'password'
					),
				'name' => array(
					'required' => true,
					'min' => 2,
					'max' => 50
					)		
				));

			if($validation->passed()) {
				//register user
				/*echo "Passed";
				session::flash('success', 'you have registered successfully');
				header('Location: index.php');
				*/
				$user = new user();

				$salt = hash::salt(32);
				
				try {

					$user->create(array(
							'username' => input::get('username'),
							'email' => input::get('email'),
							'password' => hash::make(input::get('password'), $salt),
							'salt' => $salt,
							'name' => input::get('name'),
							'joined' => date('Y-m-d H:i:s'),
							'group' => 1
						));
					session::flash('home', 'you have registered successfully');
					//header('Location: index.php');
					redirect::to('index.php');

				} catch(Exception $e) {
					die($e->getMessage());
				}
			} else {
				//output errors
				//print_r($validation->errors
					foreach ($validation->errors() as $error) {
							echo $error, '<br>';
						}
				}
	}
}


?>


<form action="" method="post">
	<div class="field">
		<label for="username"> Username</label>
		<input type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete ="off">
		<span id="username_response" class=""></span>
	</div>

	<div class="field">
		<label for="email"> Email Id</label>
		<input type="text" name="email" id="email" value="<?php echo escape(Input::get('email')); ?>" autocomplete = "off">
		<span id="email_response"></span>
	</div>

	<div class="field">
		<label for="password"> Choose a Password</label>
		<input type="password" name="password" id="password">
		<span id="password_response"></span>
	</div>

	<div class="field">
		<label for="password_again"> Enter your password again</label>
		<input type="password" name="password_again" id="password_again">
		<span id="password_again_response"></span>
	</div>

	<div class="field">
		<label for="name"> Your name</label>
		<input type="text" name="name" value="<?php echo escape(Input::get('name')); ?>" id="name">
		<span id="name_response"></span>
	</div>

	<input type="hidden" name="token"  value="<?php echo token::generate(); ?>">
	<input type="submit" value="Register">
</form>
<script type="text/javascript" src="javascripts/register.js"></script>
</body>
</html>