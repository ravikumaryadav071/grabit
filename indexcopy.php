<!Doctype html>
<html xmlns="http://www.w3s.org/1999/xhtml" lang="en">
<head> 
<title>Bootstrap 101 Template</title> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-responsive.css" />
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="../grabit/bootstrap/css/bootstrap-theme.css" />
<link rel="stylesheet" type="text/css" href="../grabit/bootstrap/jquery/smoothness/jquery-ui-1.10.1.custom.min.css" />
<link rel="stylesheet" type="text/css" href="../grabit/bootstrap/css/custom.css" />
    <script type="text/javascript" src="bootstrap/jquery/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="bootstrap/jquery/jquery-ui-1.10.1.custom.min.js"></script>
    <script src="..\bootstrap-3.2.0\docs/dist/js/bootstrap.min.js"></script>
    <script src="..\bootstrap-3.2.0\docs/assets/js/docs.min.js"></script>
<script type="text/javascript" src="../grabit/bootstrap/js/bootstrap.js"></script>
<script src="C:\Users\RAVI\Desktop\HTML,JS,ANDCSSBOOKS\bootstrap-3.2.0\docs/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="C:\Users\RAVI\Desktop\HTML,JS,ANDCSSBOOKS\bootstrap-3.2.0\docs/assets/js/ie10-viewport-bug-workaround.js"></script>
<script type="text/javascript" src="../grabit/bootstrap/js/collapse.js"></script>
<script type="text/javascript" src="../grabit/bootstrap/js/dropdown.js"></script>
<script type="text/javascript" src="../grabit/bootstrap/js/transition.js"></script>
<script type="text/javascript" src="../grabit/bootstrap/js/scrollspy.js"></script>
<script type="text/javascript" src="../grabit/bootstrap/jquery/jquery-1.9.1.js"></script>
<script type="text/javascript" src="../grabit/bootstrap/jquery/jquery-ui-1.10.1.custom.min.js"></script>
<script type="text/javascript" src="../grabit/javascripts/search.js"></script>
<!--<script type="text/javascript">
	$(document).ready(function(){

		$('.navbar-toggle').mouseOver(function(){

			$('#example-navbar-collapse').show(1500);

		});

		$('.navbar-toggle').mouseOut(function(){

			$('#example-navbar-collapse').hide(1000);

		});


	});
-->
</script>
</head> 
<body style="">
	<div class="">

  <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
      <div class="navbar-header">
        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-scrollspy">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Project Name</a>
      </div>
      <div class="collapse navbar-collapse js-navbar-scrollspy">
        <ul class="nav navbar-nav">
<div class="navbar-wrapper">
<nav class="navbar navbar-default navbar-fixed-top" role="navigation"> 
	<div class="navbar-header"> 
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#example-navbar-collapse"> 
			<span class="sr-only">Toggle navigation</span> 
			<span class="icon-bar"></span> 
			<span class="icon-bar"></span> 
			<span class="icon-bar"></span> 
		</button> <a class="navbar-brand" href="index.php">Grabit.co.in</a> </div> 
		<div class="collapse navbar-collapse" id="example-navbar-collapse"> 
			<ul class="nav navbar-nav">--> 
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

	$db = DBstore::getstoreInstance();
	$catagory_list = $db->query("SELECT * FROM catagory_list", array(), 'SELECT *')->assocresults();
	$count = $db->count();
	//echo "Logged In";
	?>
	<ul>
	<?php
		for($i=0; $i<$count; $i++){
			$catagory = $catagory_list[$i];
		?>
		<li class=""><a href="display_catagory_items.php?catagory_id=<?php echo $catagory['catagory_id'];?>"><?php echo $catagory['catagory_name']; ?></a></li>
		<?php
		}
		?>
  		</ul>
  		<div>
 
  			<form class="navbar-form navbar-right" role="search"> 
  				<div class="form-group"> 
  					<input class="form-control" placeholder="Search" id="autosearch"/>  
  				<button type="submit" class="btn btn-default">Serach</button> 
  			</div>
  			</form>
  			  	<div class="navbar-dropdown navbar-right">
	  				<button type="button" class="btn dropdown-toggle btn-lg" id="dropdown-menu1" data-toggle="dropdown">
	  					<?php
						$user = new user();
						if ($user->isLoggedIn()) {
							?>
							<a href="profile.php?user=<?php echo escape($user->data()->username); ?>"><?php echo escape($user->data()->name); ?> </a>
							<?php
						}else{
							?>
							<a href="login.php">User</a>
							<?php
						}
						?>
						<span class="caret"></span>
						<ul class="dropdown-menu" role="menu" area-labelby="dropdownmenu1">
							<li role="presentation">
								<a role="menuitem" tabindex="-1" href="logout.php">Logout</a>
							</li>
							<li role="presentation">
								<a role="menuitem" tabindex="-1" href="update.php">Udate</a>
							</li>
							<li role="presentation">
								<a role="menuitem" tabindex="-1" href="changepwd.php">Change Password</a>
							</li>
						</ul>
	  				</button>
	  			</div>
  			</div> 
  		</div>
      </div>
  </nav>
</div>
  <?php
	if ($user->isLoggedIn()) {
		?>
  	<div class="row">
  		<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-md-offset-2">
	<p>
	</br>
	</br>
	</br>
	</br>
	</br>
	Hello <a href="profile.php?user=<?php echo escape($user->data()->username); ?>"><?php echo escape($user->data()->username); ?> </a>! </p>

	<ul>
		<li><a href="logout.php">Logout</a></li>
		<li><a href="update.php">Udate</a></li>
		<li><a href="changepwd.php">Change Password</a></li>
	</ul>
	<?php

	$catagory_list = $db->query("SELECT * FROM catagory_list", array(), 'SELECT *')->assocresults();
	$count = $db->count();

	?>
	<ul>
		<?php
		for($i=0; $i<$count; $i++){
			$catagory = $catagory_list[$i];
		?>
		<li><a href="display_catagory_items.php?catagory_id=<?php echo $catagory['catagory_id'];?>"><?php echo $catagory['catagory_name']; ?></a></li>
		<?php
		}
		?>
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
</div>
</div>
</div>
</body>
</html>