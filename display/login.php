<?php 
require_once 'c:/xampp/htdocs/grabit/user_login/core/init.php';

if (input::exists()) {
	if (token::check(input::get('token'))) {
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
				'username' => array('required' => true),
				'password' => array('required' => true)
			));

		if ($validation->passed()) {
			//Log user in
			$user = new user();
			$remember = (input::get('remember') === 'on') ? true : false;
			$login = $user->login(input::get('username'), input::get('password'), $remember);
			
			if ($login) {
				//echo "Success";
				redirect::to('index.php');
			} else {
				echo "Sorry, Logging in failed.";
			}

		} else {
			foreach ($validation->errors() as $error) {
				echo $error, '<br>';
			}
		}
	}
}

?>


<form action="" method="post">
	<div class="field">
		<lable for="username">Username</lable>
		<input type="text" name="username" id="username" autocomplete="on">
	</div>

	<div class="field">
		<lable for="password">Password</lable>
		<input type="password" name="password" id="password" autocomplete="off">
	</div>

	<div class="field">
		<label for="remember">
			<input type="checkbox" name="remember" id="remember"> Remember me </input>
		</label>
	</div>

	<input type="hidden" name="token" value="<?php echo token::generate(); ?>">
	<input type="submit" value="Log in">
</form>