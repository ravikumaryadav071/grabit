<?php

require_once 'c:/xampp/htdocs/grabit/user_login/core/init.php';
$user = new user();

if (!$user->isLoggedIn()) {
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
				)
		));

		if ($validation->passed()) {
			# update
				try {
					$user->update(array(
						'name' => input::get('name')
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
		<input type="text" name="name" value="<?php escape($user->data()->name); ?>">
		<input type="submit" value="Update">
		<input type="hidden" name="token" value="<?php  echo token::generate(); ?>">
	</div>
</form>
