<?php
include "../../config.php";
$year = date("Y");
$month = date("m");
$date = date("d");
$folder = DIR_IMAGE.'post/postimage/';

if(isset($_POST["imagecheck"])){
	$error=0;
	$paths=$_POST["imagecheck"];
	foreach ($paths as $path) {
		if (file_exists( $folder.$year.'/'.$month.'/'.$date.'/'.$path)){
			unlink( $folder.$year.'/'.$month.'/'.$date.'/'.$path);
			$error=0;
		}	
	}
	if($error==0)
		echo json_encode("success");
}
?>