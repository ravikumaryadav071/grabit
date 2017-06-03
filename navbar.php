<?php
  ob_start();
  require_once 'user_login/core/init.php';
  //session_start();
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
  $user = new user();
  $cart = new cart();
  $userop = new usersop();
  $catagory_list = $db->query("SELECT * FROM catagory_list", array(), 'SELECT *')->assocresults();
  $count = $db->count();
  //echo "Logged In";

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
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css" />
    <link href="carousel.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../grabit/bootstrap/css/bootstrap-theme.css" />
    <link rel="stylesheet" type="text/css" href="bootstrap/jquery/smoothness/jquery-ui-1.10.1.custom.css" />
    <link rel="stylesheet" type="text/css" href="../grabit/bootstrap/jquery/smoothness/jquery-ui-1.10.1.custom.min.css" />
    <link rel="stylesheet" type="text/css" href="../grabit/bootstrap/css/custom.css" />
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!-- <script src="C:/Users/RAVI/Desktop/HTML,JS,ANDCSSBOOKS/bootstrap-3.2.0/docs/assets/js/ie-emulation-modes-warning.js"></script> -->

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../bootstrap-3.2.0/docs/assets/js/ie-emulation-modes-warning.js"></script>
    <script type="text/javascript" src="../bootstrap-3.2.0/docs/assets/js/ie10-viewport-bug-workaround.js"></script>
    <script type="text/javascript" src="bootstrap/jquery/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="../grabit/bootstrap/jquery/jquery-ui-1.10.1.custom.min.js"></script>
    <script src="../bootstrap-3.2.0/docs/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../grabit/javascripts/search.js"></script>
    <script src="../bootstrap-3.2.0/docs/assets/js/docs.min.js"></script>
    <script type="text/javascript" src="javascripts/add_to_cart.js"></script>
    <script type="text/javascript" src="javascripts/add_to_wishlist.js"></script>

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
              <a class="navbar-brand" href="index.php">Grabit.in</a>
            </div>
            <div class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <li><a href="index.php">Home</a></li>
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

              <form class="navbar-form navbar-right" role="search" action="search_results.php" method="post"> 
                <div class="form-group"> 
                  <input class="form-control" placeholder="Search" id="autosearch" name="search_text" autocomplete="off"/>  
                  <button type="submit" class="btn btn-default">Serach</button> 
                </div>
              </form>

              <div class="btn dropdown navbar-right">
                <button type="button" class="btn btn-default btn-lg dropdown-toggle" data-toggle="dropdown">
                  <span class="glyphicon glyphicon-user"></span>user
                  <span class="caret"></span>
                </button>
                <?php
                  if($user->isLoggedIn() && ($_SESSION['user']!=100)){
                ?>
                <ul class="dropdown-menu" role="menu">
              <li role="presentation">
                <a href="profile.php?user=<?php echo escape($user->data()->username); ?>"><?php echo escape($user->data()->username); ?></a>
              </li>
              <li role="presentation">
                <a href="wishlist.php">Wishlist</a>
              </li>
              <li role="presentation">
                <a href="orders.php">Orders</a>
              </li>
              <li role="presentation">
                <a href="update.php">Udate</a>
              </li>
              <li role="presentation">
                <a href="changepwd.php">Change Password</a>
              </li>
              <li role="presentation">
                <a href="logout.php">Logout</a>
              </li>
            </ul>
            <?php
                }else{
                  ?>
                  <ul class="dropdown-menu" role="menu">
                    <li role="presentation">
                      <a href="login.php">Login</a>
                    </li>
                    <li role="presentation">
                      <a href="register.php">Register</a>
                    </li>
                  </ul>
                    <?php
                }
            ?>
          </div>
              <div class="btn navbar-right">
                <?php
                if($user->isLoggedIn()){
                  ?>
                  <a href="show_cart.php">
                  <?php
                }else{
                  ?>
                  <a href="login.php">
                  <?php
                }
                ?>
                <button type="submit" class="btn btn-default btn-lg" name="cart" id="cart">
                  <span class="glyphicon glyphicon-shopping-cart"></span>
                  <span class="badge" value="0"><?php if($user->isLoggedIn() && !empty($_SESSION['cart'])){echo $cart->total_qty(); }else{echo'0';}?></span>
                  <input type="hidden" name="cart_qty" id="cart_qty" value="0">
                </button>
              </a>
              </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
    <?php
    ?>