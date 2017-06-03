<?php
require_once 'c:/xampp/htdocs/grabit/user_login/core/init.php';

$user = new user();

if(!$user->isLoggedIn()) {
	redirect::to('index.php');
}
if (input::exists()) {
	if (token::check(input::get('token'))) {
		//echo 'ok';
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'password_current' => array(
				'required' => true,
				'min' => 6
			),
			'password_new' => array(
				'required' => true,
				'min' =>6
			),
			'password_new_again' => array(
				'required' => true,
				'min' =>6,
				'matches' => 'password_new'
			)
		));
		if ($validation->passed()) {
			// change of password
			if (hash::make(input::get('password_current'), $user->data()->salt) !== $user->data()->password) {
				# code...
				echo "Wrong password";
			} else {
				//echo "okay";
				$salt = hash::salt(32);
				$user->update(array(
						'password' => hash::make(input::get('password_new'), $salt),
						'salt' => $salt
				));

				session::flash('home', 'Your password has been changed');
				redirect::to('index.php');
			}

		} else {
			//loop thorugh errors
			foreach ($validation->errors() as $error) {
				echo $error,'<br>';
			}
		}
	}
}

?>

<form action="" method="post">
	<div class="field">
			<label for="password_current">Current Password</label>
			<input type="password" name="password_current" id="password_current">
	</div>

	<div class="field">
			<label for="password_new">New Password</label>
			<input type="password" name="password_new" id="password_new">
	</div>

	<div class="field">
			<label for="password_new_again">Confirm Password</label>
			<input type="password" name="password_new_again" id="password_new_again">
	</div>

	<input type="submit" value="Change">
	<input type="hidden" name="token" value="<?php echo token::generate();  ?>">
</form>
