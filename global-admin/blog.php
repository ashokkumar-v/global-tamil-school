<?php 
ob_start();
session_start();
include("includes/config.php"); 
$table_name="".DB_PREFIX."_gallery";
$current_page = "gallery.php";
 if(!empty($_FILES["upload_file"]) && $_FILES["upload_file"]["error"]!=4) {
		if ($_FILES['upload_file']['name'] != "") {
			list($width,$height) = getimagesize($_FILES['upload_file']['tmp_name']);
			//if($width<750||$height<290){ 
				$v = $_FILES['upload_file']['name'];
				$source = $_FILES['upload_file']['tmp_name'];
				$v = time().$v;
				$parts=explode(".",$v);
				$v=$parts[0].".png";
				$originalpath = "assets/webupload/original/gallery/".$v;
				$thumbnailpath = "assets/webupload/thumb/gallery/".$v; 
				$largepath = "assets/webupload/large/gallery/".$v; 
				$iconpath = "assets/webupload/icon/gallery/".$v; 
				move_uploaded_file($source,$originalpath);
				include_once('includes/imgresize.php');
				resize($originalpath, $thumbnailpath, 555, 215); 
				resize($originalpath, $largepath, 750, 290); 
				resize($originalpath, $iconpath, 100, 100); 
			// }
			// else
			// { 
				// include('includes/resize.php');
				// $v = $_FILES['upload_file']['name'];
				// $source = $_FILES['upload_file']['tmp_name'];
				// $v = time().$v;
				// $originalpath = "assets/webupload/original/gallery/".$v;
				// $thumbnailpath = "assets/webupload/thumb/gallery/".$v; 
				// $largepath = "assets/webupload/large/gallery/".$v; 
				// $iconpath = "assets/webupload/icon/gallery/".$v; 
				// move_uploaded_file($source,$originalpath);
				// $objimg = new SimpleImage();
				// $objimg -> load($originalpath);
				// $objimg -> resize(555,215);
				// $objimg -> save($thumbnailpath);
				// $objimg -> resize(750,290);
				// $objimg -> save($largepath);
				// $objimg -> resize(100,100);
				// $objimg -> save($iconpath);
			// }
		}
 }
else { 
	$v = get_entity($_REQUEST['theValue']); 
}
if(isset($_REQUEST['submit_action'])) {
	 if(!empty($_POST["edit_action"])){ 
		$sql="UPDATE $table_name SET `gallery_image`='".$v."',`updated_by`='".$_SESSION['webadmin_id']."',`updated_date`='".$date."' WHERE `web_id`='".$_REQUEST["id"]."'"; 
	}
     else{
		$sql="INSERT INTO $table_name(`gallery`, `added_by`, `added_date`, `status`) VALUES ('".$v."','".$_SESSION['webadmin_id']."','".$date."','1')";
	}
	$res=$db_cms->update_query($sql);
	if($res!=FALSE){
		$_SESSION["cms_status"]="success";
		$_SESSION["cms_msg"]="Updated successfully!";
		header('Location:'.$current_page.'');
		exit();	
	}
	else{
		$_SESSION["cms_status"]="danger";
		$_SESSION["cms_msg"]="Unable to update!";
	}
}
if($_REQUEST["action"] == "Disable" ){
            $sql="UPDATE $table_name SET status ='0' WHERE `web_id`='".$db_cms->removeQuote($_REQUEST["web_id"])."'";
            $res=$db_cms->delete_query($sql);
            if($res!=FALSE){
                $_SESSION["cms_status"]="success";
                $_SESSION["cms_msg"]="Disabled successfully!";
                header('Location:'.$current_page.'');
                exit();
            }
            else{
                $_SESSION["cms_status"]="error";
                $_SESSION["cms_msg"]="Unable to Disapprove!";
                header('Location:'.$current_page.'');
                exit();
            }
        } 
		if($_REQUEST["action"] == "Enable" ){
            $sql="UPDATE $table_name SET status ='1' WHERE `web_id`='".$db_cms->removeQuote($_REQUEST["web_id"])."'";
            $res=$db_cms->delete_query($sql);
            if($res!=FALSE){
                $_SESSION["cms_status"]="success";
                $_SESSION["cms_msg"]="Enabled successfully!";
                header('Location:'.$current_page.'');
                exit();
            }
            else{
                $_SESSION["cms_status"]="error";
                $_SESSION["cms_msg"]="Unable to Approve!";
                header('Location:'.$current_page.'');
                exit();
            }
        }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Gallery | <?=$site_title;?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include_once("includes/css_js.php");?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">



<?php include_once("includes/header.php");
include_once("includes/sidebar.php");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Gallery Management</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Gallery Management</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
   <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
		  <?php  if(!empty($_SESSION["cms_status"]) && !empty($_SESSION["cms_msg"])){ ?>
			
			<div id="toastsContainerTopRight" class="toasts-top-right fixed">
			   <div class="toast bg-<?php echo $_SESSION["cms_status"]; ?> fade show" role="alert" aria-live="assertive" aria-atomic="true">
				  <div class="toast-header"><strong class="mr-auto">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $_SESSION["cms_msg"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong><small></small><button data-dismiss="toast" type="button" class="ml-2 mb-1 close" aria-label="Close"><span aria-hidden="true">×</span></button></div>
			   </div>
			</div>
			<?php } ?>
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Gallery Management</h3>
				<?php  if($_REQUEST['action'] == ""){ ?>
				<div class="card-tools">
				  <a href="<?=$current_page;?>?action=add" class="btn btn-default btn-md p-1 text-muted" title="Click to add"><i class="fas fa-plus" aria-hidden="true"></i> </a>
				</div>
				<?php } else{ ?>
				<div class="card-tools">
				  <a href="<?=$current_page;?>" class="btn btn-default btn-md p-1 text-muted" title="Click to back"><i class="fas fa-reply" aria-hidden="true"></i> </a>
				</div>
				<?php } ?>
              </div>
              <!-- /.card-header -->
             
				<?php
				if($_REQUEST['action'] == ""){  
				?>
				 <div class="card-body">
                <table id="example2" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>S.No.</th>
                    <th>Image</th>
					<th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php
                                $sql="SELECT * FROM $table_name ORDER BY web_id DESC";
                                $res=$db_cms->select_query_with_rows($sql);
								//print_r($res);
                                if($res!=FALSE){
                                    $i=1;
                                    foreach ($res as $row){
                                        ?>
                  <tr>
                    <td> <?=$i;?></td>
                    <td>  <?php echo get_symbol($row["title"]); ?></td>
					<td style="vertical-align: middle">
												<?php
													if ($row["status"] == 0){
														$btn_status = "btn-danger";
														$status = "Disabled";
														$change_status = "Enable";
													}
													if ($row["status"] == 1){
														$btn_status = "btn-success";
														$status = "Enabled";
														$change_status = "Disable";
													}?>
                                                <a class="btn <?php echo $btn_status;?>" href="<?php echo "?action=".$change_status."&web_id=".$row["web_id"];?>"><?php echo $status;?></a>
                                            </td>
                    <td>   
					<a class="btn btn-primary" href="<?=$current_page?>?action=edit&id=<?=$row['web_id']?>"><i class="fas fa-edit"></i></a></td>
					
                  </tr>
				   <?php
                                        $i++;
                                    }
                                }
                                ?>
                  </tfoot>
                </table>
				</div>
				<?php 
				} else if(($_REQUEST['action'] == "edit") || ($_REQUEST['action'] == "add")){ 
				$sql="SELECT * FROM $table_name WHERE web_id='".$_REQUEST['id']."'";
				$res=$db_cms->select_query_with_row($sql);
				$image=$res["gallery_image"];
								?>
              <form role="form" id="quickForm" method="post" enctype="multipart/form-data">
                <div class="card-body">
					<div class="row">
						<div class="col-md-12">
                    <div class="form-group">
                        <label>Gallery Image</label>
						<input type="file" class="form-control" id="upload_file" name="upload_file"  data-msg="Please upload image" onchange="return test();" value="<?php echo get_symbol($image);?>" >
								<input type="hidden" id="theValue" name="theValue" value="<?php echo get_symbol($image);?>" />
								<span id="err_image" class="error">  </span>
								<?php if($_REQUEST["action"]!="add"){  ?>
								<div class="mt-2">
									<img src="<?php echo $siteadminpath;?>/assets/webupload/icon/blog/<?php echo get_symbol($image);?>" alt="Image" />
								</div>
								<br/>
							<?php  }  ?>
                    </div>
                </div>

					</div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
					<?php
					$action=($_REQUEST["action"]=="edit")?"edit_action":(($_REQUEST["action"]=="add")?"add_action":"none_action");
					$val=(!empty($res))?$res["web_id"]:"1";
					?>
				  <input type="hidden" name="<?php echo $action;?>" value="<?php echo $val;?>"/>
                  <button type="submit"  name="submit_action"  id="submit_action" class="btn btn-primary" onclick="return validation();">Submit</button>
                </div>
              </form>
			  
            	<?php 
				} /*else if($_REQUEST['action'] == "view"){  
				$sql="SELECT * FROM $table_name WHERE web_id='".$_REQUEST['id']."'";
				$res=$db_cms->select_query_with_row($sql);
				$title=get_symbol($res["title"]);
				$blog_slug=get_symbol($res["blog_slug"]);
				$content=get_symbol($res["content"]); 
				$meta_title=get_symbol($res["meta_title"]); 
				$meta_tag_desc=get_symbol($res["meta_tag_desc"]); 
				$meta_tag_keywords=get_symbol($res["meta_tag_keywords"]); 
				$tags=get_symbol($res["tags"]); 
				$image=$res["blog_image"];?>
				 <div class="card-body">
				<dl class="row">
                  <dt class="col-sm-4">Title</dt>
                  <dd class="col-sm-8"><?=$title;?></dd>
                  <dt class="col-sm-4">Blog Slug</dt>
                  <dd class="col-sm-8"><?=$blog_slug;?></dd>
                  <dt class="col-sm-4">Content</dt>
                  <dd class="col-sm-8"><?=$content;?></dd>
                  <dt class="col-sm-4">Meta Title</dt>
                  <dd class="col-sm-8"><?=$meta_title;?></dd>
                  <dt class="col-sm-4">Meta Tag Description</dt>
                  <dd class="col-sm-8"><?=$meta_tag_desc;?></dd>
                  <dt class="col-sm-4">Meta Keywords</dt>
                  <dd class="col-sm-8"><?=$meta_tag_keywords;?></dd>
                  <dt class="col-sm-4">Tags</dt>
                  <dd class="col-sm-8"><?=$tags;?></dd>
                  <dt class="col-sm-4">Image</dt>
                  <dt class="col-sm-8"><img src="<?php echo $siteadminpath;?>/assets/webupload/thumb/blog/<?php echo get_symbol($image);?>" alt="Image" /></dt>
                </dl>
				<?php }*/ ?>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php $_SESSION["cms_status"]="";
		$_SESSION["cms_msg"]="";
include_once("includes/footer.php");?>
</div>
<!-- ./wrapper -->

<script type="text/javascript">
  $(function () {
    $("#example2").DataTable({
      "responsive": true,
      "autoWidth": false,
	  "minHeight": 300,
    });
  });
   $('.close').click(function() {
  $("#toastsContainerTopRight").hide();
});
$(function () {
    // Summernote
	$('.textarea').summernote({
	  height: 420,   // set editor height
	  callbacks: {
    onKeyup: function(e) {
      document.getElementById("err_content").innerHTML = "";
    }
  }
	});
  })
 function test()
	{	
		document.getElementById('theValue').value=$('input[id=upload_file]').val().replace(/C:\\fakepath\\/i, ''); 
		return true;
	}
        function validation(){  
		var error = 0;
            title=document.getElementById("title").value;
            if(title===""){
				error++;
               document.getElementById("err_title").innerHTML = "Please enter title";
                document.getElementById('title').focus();
				$("#title").addClass("err_border");
            } 
			else{
				document.getElementById("err_title").innerHTML = "";
			}
            blog_slug=document.getElementById("blog_slug").value;
            if(blog_slug===""){
				error++;
               document.getElementById("err_blog_slug").innerHTML = "Please enter blog slug";
                document.getElementById('blog_slug').focus();
				$("#blog_slug").addClass("err_border");
            } 
			else{
				document.getElementById("err_blog_slug").innerHTML = "";
			}
            meta_title=document.getElementById("meta_title").value;
            if(meta_title===""){
				error++;
               document.getElementById("err_meta_title").innerHTML = "Please enter meta title";
                document.getElementById('meta_title').focus();
				$("#meta_title").addClass("err_border");
            } 
			else{
				document.getElementById("err_blog_slug").innerHTML = "";
			}
			content = $('#content').summernote('code').replace(/<(.|\n)*?>/g, '');
            if(content==="")
            {
				error++;
                document.getElementById("err_content").innerHTML = "Please enter description";
                document.getElementById('content').focus();
            }
			else{
				document.getElementById("err_content").innerHTML = "";
			}
			var file = document.getElementById('theValue').value;  
			var FileExt = file.substr(file.lastIndexOf('.')+1); 
			if(file == "")
			{
				error++;
				document.getElementById("err_image").innerHTML = "Please upload the image";
				document.getElementById('theValue').focus();
				$("#upload_file").addClass("err_border");
			}
			else if(FileExt == "gif" || FileExt == "GIF" || FileExt == "JPEG" || FileExt == "jpeg" || FileExt == "jpg" || FileExt == "JPG" || FileExt == "png")
			{
			} 
			else
			{
				document.getElementById("err_image").innerHTML = "Upload Gif or Jpg or png images only"; 
				document.getElementById('theValue').focus();
			}
if(error>0) {
		 return false;
	 }
	 return true;			
        } 
		function test()
		{	
			document.getElementById('theValue').value=$('input[id=upload_file]').val().replace(/C:\\fakepath\\/i, ''); 
			return true;
		}
		function confirmDelete(){	
			answer = confirm("Do you want to delete this item?");
			if (answer ==0) 
			{ 
				return false;
			} 	
		}
		$( "#title" ).keyup(function() {
         	$("#title").removeClass("err_border");	
			document.getElementById("err_title").innerHTML = "";
         });
         $( "#blog_slug" ).keyup(function() {
         	$("#blog_slug").removeClass("err_border");	
			document.getElementById("err_blog_slug").innerHTML = "";
         });
         $( "#meta_title" ).keyup(function() {
         	$("#meta_title").removeClass("err_border");	
			document.getElementById("err_meta_title").innerHTML = "";
         });
		 $( "#content" ).keyup(function() {
			document.getElementById("err_content").innerHTML = "";
         });
		 $( "#upload_file" ).change(function() {
         	$("#upload_file").removeClass("err_border");	
			document.getElementById("err_image").innerHTML = "";
         });

</script>
</body>
</html>
