<?php
session_start();
unset($_SESSION['webadmin_id']);
unset($_SESSION['webadmin_username']);

$_SESSION["cms_status"]="success";
$_SESSION["cms_msg"]="You have successfully logged out!";
header('Location:index.php');
exit();
?>