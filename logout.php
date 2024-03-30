<?php
session_start();
$_SESSION = NULL;
session_destroy();
setcookie('username', $username,time()-3600,"/");
setcookie('password', $password,time()-3600,"/");
header('location: login.php');
?>