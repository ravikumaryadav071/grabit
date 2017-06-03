<?php

require_once 'user_login/core/init.php';
$user = new user();

if (!$user->isLoggedIn()&& ($_SESSION['user']!=100)) {
	redirect::to('index.php');
}

if (input::exists()) {
	if (token::check(input::get('token'))) {
		# echo "Okay";
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
				'name' => array(
						'required' => true,
						'min' => 2,
						'max' => 50
				),
				'email' => array(
					'required' => true,
					'min' => 4
				),
		));

		if ($validation->passed()) {
			# update
				try {
					
					$user->update(array(
						'name' => input::get('name'),
						'email' => input::get('email')
					));

					session::flash('home', 'Your details have been updated');
					redirect::to('index.php');

				} catch(Exception $e) {
					die($e->getMessage());
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
		<lable for="name">Name</lable>
		<input type="text" name="name" value="<?php echo escape($user->data()->name); ?>">
		<lable for="name">Email Id</lable>
		<input type="text" name="email" value="<?php echo escape($user->data()->email); ?>">
		<input type="submit" value="Update">
		<input type="hidden" name="token" value="<?php  echo token::generate(); ?>">
	</div>
</form>
<p><a href="profile.php?user=<?php echo escape($user->data()->username); ?>">Check your profile.</a></p>
