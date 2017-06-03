<?php 
require_once 'user_login/core/init.php';
?>
<?php
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
				echo "<br><br><br><br> <p>Sorry, Logging in failed.</p>";
			}

		} else {
			foreach ($validation->errors() as $error) {
				echo '<br><br><br><br> <p>', $error, '</p>', '<br>';
			}
		}
	}
}
	$db = DBstore::getstoreInstance();
	$user = new user();
	$catagory_list = $db->query("SELECT * FROM catagory_list", array(), 'SELECT *')->assocresults();
	$count = $db->count();
  $cart = new cart();
  static $guest = 'LoggedOut';
	//echo "Logged In";
  if(isset($_SESSION['user'])){

    if($_SESSION['user'] == 100){

      $guest == 'LoggedIn';

    }
  }
  if($guest == 'LoggedIn'){
    if(isset($_SESSION['user'])){

      if($_SESSION['user'] == 100){

        unset($_SESSION['user']);
        $guest == 'LoggedOut';
      }

    }
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../bootstrap-3.2.0/docs/favicon.ico">

    <title>Grabit</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="carousel.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="../grabit/bootstrap/css/bootstrap-theme.css" />
	<link rel="stylesheet" type="text/css" href="../grabit/bootstrap/jquery/smoothness/jquery-ui-1.10.1.custom.min.css" />
	<link rel="stylesheet" type="text/css" href="../grabit/bootstrap/css/custom.css" />
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!-- <script src="C:/Users/RAVI/Desktop/HTML,JS,ANDCSSBOOKS/bootstrap-3.2.0/docs/assets/js/ie-emulation-modes-warning.js"></script> -->

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../bootstrap-3.2.0/docs/assets/js/ie-emulation-modes-warning.js"></script>
    <script type="text/javascript" src="../bootstrap-3.2.0/docs/assets/js/ie10-viewport-bug-workaround.js"></script>
    <script type="text/javascript" src="bootstrap/jquery/jquery-1.9.1.js"></script>
    <script src="../bootstrap-3.2.0/docs/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../grabit/bootstrap/jquery/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="../grabit/bootstrap/jquery/jquery-ui-1.10.1.custom.min.js"></script>
	<script type="text/javascript" src="../grabit/javascripts/search.js"></script>
    <script src="../bootstrap-3.2.0/docs/assets/js/docs.min.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Custom styles for this template -->
    <link href="carousel.css" rel="stylesheet">
  </head>
<!-- NAVBAR
================================================== -->
  <body>
    <div class="navbar-wrapper">
      <div class="container">

        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#">Grabit.co.in</a>
            </div>
            <div class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <li class="active"><a href="index.php">Home</a></li>
                <?php
					for($i=0; $i<$count; $i++){
						$catagory = $catagory_list[$i];
						?>
						<li>
							<a href="display_catagory_items.php?catagory_id=<?php echo $catagory['catagory_id'];?>"><?php echo $catagory['catagory_name']; ?></a>
						</li>
						<?php
					}
				?>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li class="dropdown-header">Nav header</li>
                    <li><a href="#">Separated link</a></li>
                    <li><a href="#">One more separated link</a></li>
                  </ul>
                </li>
              </ul>
	          	<form class="navbar-form navbar-right" role="search"> 
  					<div class="form-group"> 
  						<input class="form-control" placeholder="Search" id="autosearch"/>  
  						<button type="submit" class="btn btn-default">Serach</button> 
  					</div>
  				</form>
  			    <div class="btn dropdown navbar-right">
	            	<button type="button" class="btn btn-default btn-lg dropdown-toggle" data-toggle="dropdown">
	            		<span class="glyphicon glyphicon-user"></span>user
	            		<span class="caret"></span>
	            	</button>
                  <ul class="dropdown-menu" role="menu">
                    <li role="presentation">
                      <a href="login.php">Login</a>
                    </li>
                    <li role="presentation">
                      <a href="register.php">Register</a>
                    </li>
                  </ul>
          </div>
              <div class="btn navbar-right">
                  <button type="submit" class="btn btn-default btn-lg" name="cart" id="cart">
                  <span class="glyphicon glyphicon-shopping-cart"></span>
                  <span class="badge" value="0"><?php if(isset($_SESSION)){ if($user->isLoggedIn() && !empty($_SESSION['cart'])){echo $cart->total_qty(); } }else{echo'0';}?></span>
                  <input type="hidden" name="cart_qty" id="cart_qty" value="0">
                </button>
              </div>
	            </div>
            </div>
          </div>
        </div>

      </div>
    </div>
<div style="margin-top: 70px">
	<div class="container">
		<form action="" method="post" class="form-signin" role="form">
			<h2 class="form-signin-heading">Please Login</h2>
			<div class="field">
				<lable for="username">Username</lable>
				<input type="text" name="username" id="username" autocomplete="on" class="form-control" placeholder="Username" autofocus required>
			</div>

			<div class="field">
				<lable for="password">Password</lable>
				<input type="password" name="password" id="password" autocomplete="off" class="form-control" placeholder="password" required>
			</div>

			<div class="field">
				<label class="checkbox" for="remember">
					<input type="checkbox" name="remember" id="remember"> Remember me </input>
				</label>
			</div>

			<input type="hidden" name="token" value="<?php echo token::generate(); ?>">
			<button type="submit" value="Log in" class="btn btn-primary btn-lg btn-block">Login</button>
		</form>
	</div>
</div>
<div class="container">
  <form method="post" action="">
    <input type="hidden" name="username" id="username" value="guest">
    <input type="hidden" name="password" id="password" value="password">
    <input type="hidden" name="token" value="<?php echo token::generate(); ?>">
    <input type="submit" value="Continue as a Guest" class="btn btn-success btn-lg btn-block">
  </form>
</div>
</body>
</html>