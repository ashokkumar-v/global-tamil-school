<?php
error_reporting(1); 
session_start();
ob_start();

$ip=$_SERVER["SERVER_ADDR"];

define("DB_PREFIX", "sa");

    date_default_timezone_set('Asia/Kolkata');
	define("DB_HOST", "localhost");
	define("DB_NAME", "bcayjamy_global_tamil_school");
	define("DB_USER", "bcayjamy_mainusr");
	define("DB_PASS", "Karthick@3030");

	$sitepath='https://globaltamilschool.co.uk/';
    $siteadminpath='https://globaltamilschool.co.uk/global-admin/';

include('mysqli_class.php');

$db_cms=new DBManager(); 
if($db_cms->connect(DB_HOST,DB_USER,DB_PASS,DB_NAME)==FALSE){
    echo "Could not connect";
    exit;
}
$date = date('Y/m/d');
$site_title="Global Tamil School Admin Panel";

?>
