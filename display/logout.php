<?php 
require_once 'c:/xampp/htdocs/grabit/user_login/core/init.php';

$user = new user();
$user->logout();

redirect::to('index.php');

?>