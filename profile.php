<?php
require_once 'user_login/core/init.php';

if (!$username = input::get('user')) {
	redirect::to('index.php');
} else {
	//echo $username;
	$user = new user($username);
	if (!$user->exists()) {
		redirect::to(404);
	} else {
		//echo "Exists";
		$data = $user->data();
	}
	?>
	<h3><?php echo escape($data->username); ?></h3>
	<p>FULL Name : <?php echo escape($data->name); ?></p>
	<p>Email Id: <?php echo escape($data->email); ?></p>
	<p><a href="update.php">Update Information</a></p>

<?php
}

