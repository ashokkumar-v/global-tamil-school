<?php
session_start();
include_once("includes/config.php");
    if(!empty($_POST["username"]) && !empty($_POST["password"])){
        $db_res=$db_cms->WebAdminLogin($_POST["username"],$_POST["password"]);
        if(!$db_res){
            $_SESSION["cms_status"]="danger";
            $_SESSION["cms_msg"]="Invalid Username/Password!";
            header("location:index.php");
            exit;
        }
        else{
            header("location:dashboard.php");
            exit;
        }
    }
    else{
        $_SESSION["cms_status"]="danger";
        $_SESSION["cms_msg"]="Please enter the values!";
        header("location:index.php");
        exit;
    }
?>