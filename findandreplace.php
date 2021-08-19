<?php
$field['settings'][0]="test";

$settings = $field['settings'];
  $settings += array('handler' => 'base');
echo "<pre>";print_r($settings);echo "</pre>";
$test = null;

$t    = array('test');

//$test += $t prints the fatal here

$test = array('one');

$test += $t;

// will only print '0 => one'
//echo "<pre>";print_r($test);echo "</pre>";


$test = array_merge($test, $t);

// will print both elements
//echo "<pre>";print_r($test);echo "</pre>";

echo $_REQUEST['search']; echo "<br><br>";
function listFolderFiles($dir){
    $ffs = scandir($dir);
    $i = 0;
    $list = array(); 
    foreach ( $ffs as $ff ){
        if ( $ff != '.' && $ff != '..' ){
            if ( strlen($ff)>=5 ) {  $ext=$_REQUEST['extension'];
			
			//if($ext=='phtml') { echo "<br>".substr($ff, -5); }
                if ( (substr($ff, -4) == '.'.$ext)  || (substr($ff, -5) == '.'.$ext) ||  (substr($ff, -3) == '.'.$ext)) {
					
                    $list[] = $ff;
                    //echo dirname($ff) . $ff . "<br/>";
                   $path_to_file2= $dir.'/'.$ff; 
				   
				   if(!strpos($path_to_file2, "vti_cnf")) {
				   				
					$file_contents = file_get_contents($path_to_file2);		
					if (strpos($file_contents,$_REQUEST['search']) == true) {
						if($_REQUEST['search']!="")
						{
							//if($_REQUEST['replace']!="") {
							//$file_contents = str_replace($_REQUEST['search'],$_REQUEST['replace'],$file_contents);
							//file_put_contents($path_to_file2,$file_contents);
							//}
						}
						 static $count = 1; echo  $count.". ".$path_to_file2;echo "<br>"; 
    $count++;
						
					}	
				   }
				    
						
                
				}    
            }       
            if( is_dir($dir.'/'.$ff) ) 
                    listFolderFiles($dir.'/'.$ff);	
        }
    } 
    return $list;
}
$files = array(); // global $cnt; $cnt=1;
if(isset($_REQUEST['submit']))
{
$search =$_REQUEST['search'];
$files = listFolderFiles(dirname(__FILE__));

}

if($_REQUEST['extension']!="") {$ext=$_REQUEST['extension']; } else { $ext='php';  }
?>
<form action="" name="form1" enctype="multipart/form-data" method="post">
Search Text:<input type="text" name="search" id="search" required="required" value="<?=$_REQUEST['search']?>" />
Extension: <input type="text" name="extension" id="extension" required="required" value="<?=$ext?>" />
<!--Replace: <input type="text" name="replace" id="replace"  value="<?=$_REQUEST['replace']?>" />-->
<input type="submit" value="submit" name="submit" id="submit" onclick="return check()'" />
</form>
<script type="text/javascript">
function check()
{
if(document.getElementById('search').value="")
{
	alert("please enter the value");
	document.getElementById('search').focus();
return false;	
}
}
</script>