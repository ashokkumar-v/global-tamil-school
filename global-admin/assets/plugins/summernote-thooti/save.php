<?php
include "../../config.php";
include "../../functions.php";
$year = date("Y");
$month = date("m");
$date = date("d");


if ($_FILES['file']) {
	$folder = DIR_IMAGE.'post/postimage/';
	//year directory
	$filename = $folder.$year.'/';
	if (!file_exists($filename)) {
		mkdir($folder.$year, 0777);
	}
	//month directory
	$filename = $folder.$year.'/'.$month.'/';
	if (!file_exists($filename)) {
		mkdir($folder.$year.'/'.$month, 0777);
	}
	//date directory
	$filename = $folder.$year.'/'.$month.'/'.$date.'/';
	if (!file_exists($filename)) {
		mkdir($folder.$year.'/'.$month.'/'.$date, 0777);
	}

	
	$error=0;
	$images_arr = array();
	
	$i=1;
    foreach($_FILES['file']['name'] as $key=>$val){
        $image_name = $_FILES['file']['name'][$key];
        $tmp_name   = $_FILES['file']['tmp_name'][$key];
		
		//get image size
		$sourceProperties = getimagesize($tmp_name);
		$width = $sourceProperties[0];
      	$height = $sourceProperties[1];

        //checking image type
        $allowed =  array('gif','png','jpg','jpeg');
        $filename = $_FILES['file']['name'][$key];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
         
        if(!in_array($ext,$allowed)){
			$error=1;
		}
        //move uploaded file to uploads folder
		else{
			$target_dir = $folder.$year.'/'.$month.'/'.$date.'/';
			$target_file = $target_dir.$i.time().".jpg";

			if($width>730){
				switch ($ext) {
					case "jpg":
						$imageResourceId = imagecreatefromjpeg($tmp_name);
						break;
					case "jpeg":
						$imageResourceId = imagecreatefromjpeg($tmp_name);
						break;
					case "png":
						$imageResourceId = imagecreatefrompng($tmp_name);
						break;
					case "gif":
						$imageResourceId = imagecreatefromgif($tmp_name);
						break;
				}

				$targetLayer = imageResize($imageResourceId,$width,$height);
				imagejpeg($targetLayer,$target_file, 70);
			}
			else{
				compressImage($_FILES['file']['tmp_name'][$key],$target_file,70);
			}
			
			$error=0;
		}
		$i++;
	}
	if($error==0)
		echo json_encode("success");
	else
		echo json_encode("invalid");
}
?>