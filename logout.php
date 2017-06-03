<?php 
require_once 'user_login/core/init.php';

$user = new user();
$user->logout();

redirect::to('index.php');

?>