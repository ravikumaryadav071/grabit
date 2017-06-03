<?php
require_once 'c:/xampp/htdocs/grabit/user_login/core/init.php';
/*
//echo config::get('mysql/host'); // 127.0.0.1
$userInsert = DB::getInstance()->update('users', 4, array(
	'password' => 'newpassword',
	'name' => 'berry alllen'
	
	));
//get('users', array('username', '=', 'rachit'));
//query("SELECT username FROM users WHERE username = ?", array('alex'));

if(!$user->count()) {
	echo 'No user';
} else {
	//echo 'Okay';
	//$fir = $user->results();
	echo $user->first()->username;
}*/

if (session::exists('home')) {
	echo '<p>' . session::flash('home') . '</p>';	
}

//echo session::get(config::get('session/session_name'));
$user = new user();
if ($user->isLoggedIn()) {
	//echo "Logged In";
?>	
	<p>Hello <a href="profile.php?user=<?php echo escape($user->data()->username); ?>"><?php echo escape($user->data()->username); ?> </a>! </p>

	<ul>
		<li><a href="logout.php">Logout</a></li>
		<li><a href="update.php">Udate</a></li>
		<li><a href="changepwd.php">Change Password</a></li>
	</ul>
<?php
	
	if ($user->hasPermission('admin')) {
		# code...
		echo "Your are an Administrator";
?>

<p>Choose any one of the following action</p>
<ul>
<li><a href="catagory_menu.php">Edit existing catagories</a></li>
<li><a href="">Add new catagory</a></li>
<li><a href="order_details_menu.php">Order details</a></li>
<li><a href="generate_bill.php">Generate Bill</a></li>
</ul>

<?php
	}

} 
else {
	echo '<p>You need to <a href="login.php">log in </a> or <a href="register.php">register</a></p>';

}
?>