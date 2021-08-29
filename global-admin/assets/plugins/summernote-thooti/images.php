<?php include "../../config.php";
$year = date("Y");
$month = date("m");
$date = date("d");
?>
<div class="modal-dialog modal-lg" style="overflow:initial">
	<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Image manager
			<button type="button" data-toggle="tooltip" title="Upload" id="button-upload" 
			class="btn btn-primary btn-sm"><i class="fas fa-upload"></i></button>
			<button type="button" data-toggle="tooltip" title="Delete" id="delete-image" 
			class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
			</h4>
		</div>
		<div class="modal-body">
			<div class="row">
				<?php
				$folder = DIR_IMAGE.'post/postimage/';
				$directory = $folder.$year.'/'.$month.'/'.$date.'/'; //edit path
				//pagination
				if($_POST['page']=='')
					$_POST['page']=1;
				if($_POST['page'])
				{
				$page = $_POST['page'];
				$cur_page = $page;
				$page -= 1;
				$per_page = 8;
				$previous_btn = true;
				$next_btn = true;
				$first_btn = true;
				$last_btn = true;
				$start = $page * $per_page;
				//pagination
				
				
				$images = glob($directory.'*.{jpg,jpeg,png,gif}', GLOB_BRACE);

				//print_r($images);
				
				foreach ($images as $image){
				  $tmp[basename($image)] = filemtime($image);
				}
				arsort($tmp);
				$files = array_keys($tmp);
								
				$msg = "";				
				
				for( $i = $start; $i <=$start+($per_page-1); $i++){
					$image = SITEURL.$images[$i];	
					if($image!=SITEURL)
						$msg .='
						<div class="col-sm-3 col-xs-6 text-center" style="margin-bottom:20px;">
							<a id="image_'.$i.'" class="thumbnail mb-14" href="'.SITEURL.'img/post/postimage/'.$year.'/'.$month.'/'.$date.'/'.$files[$i].'" style="height:110px;width:100%;margin-bottom: 14px;">
								<img style="width:100%;height:100%;object-fit:contain;" class="img-responsive summernote-images" src="'.SITEURL.'img/post/postimage/'.$year.'/'.$month.'/'.$date.'/'.$files[$i].'">
							</a>
							<label class="summernote-imgname"><input type="checkbox" name="imagecheck[]" value="'.$files[$i].'"> '.$files[$i].'</label>
						</div>
						';
				}				
				
				$msg = "<div class='data'>" . $msg . "</div></div></div>";
				
				
				$count = count($images);
				$no_of_paginations = ceil($count / $per_page);

/* ---------------Calculating the starting and endign values for the loop----------------------------------- */
if ($cur_page >= 7) {
    $start_loop = $cur_page - 3;
    if ($no_of_paginations > $cur_page + 3)
        $end_loop = $cur_page + 3;
    else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
        $start_loop = $no_of_paginations - 6;
        $end_loop = $no_of_paginations;
    } else {
        $end_loop = $no_of_paginations;
    }
} else {
    $start_loop = 1;
    if ($no_of_paginations > 7)
        $end_loop = 7;
    else
        $end_loop = $no_of_paginations;
}
/* ----------------------------------------------------------------------------------------------------------- */
$msg .= "<div class='modal-footer'><ul class='pagination' id='pagination' style='margin:0'>";

// FOR ENABLING THE FIRST BUTTON
if ($first_btn && $cur_page > 1) {
$msg .= "<li p='1' onclick='loadData(1)'><a href='javascript:void(0)'>|<</a></li>";
} else if ($first_btn) {
    $msg .= "<li p='1' onclick='loadData(1)'><a href='javascript:void(0)' class='pointerevents-none'>|<</a></li>";
}

// FOR ENABLING THE PREVIOUS BUTTON
if ($previous_btn && $cur_page > 1) {
    $pre = $cur_page - 1;
    $msg .= "<li p='$pre' onclick='loadData($pre)'><a href='javascript:void(0)'><</a></li>";
} else if ($previous_btn) {
    $msg .= "<li><a href='javascript:void(0)' class='pointerevents-none'><</a></li>";
}
for ($i = $start_loop; $i <= $end_loop; $i++) {

    if ($cur_page == $i)
        $msg .= "<li p='$i' class='active'><a href='javascript:void(0)'>{$i}</a></li>";
    else
        $msg .= "<li p='$i' onclick='loadData($i)'><a href='javascript:void(0)'>{$i}</a></li>";
}

// TO ENABLE THE NEXT BUTTON
if ($next_btn && $cur_page < $no_of_paginations) {
    $nex = $cur_page + 1;
    $msg .= "<li p='$nex' onclick='loadData($nex)'><a href='javascript:void(0)'>></a></li>";
} else if ($next_btn) {
    $msg .= "<li class='disabled'><a href='javascript:void(0)' class='pointerevents-none'>></a></li>";
}

// TO ENABLE THE END BUTTON
if ($last_btn && $cur_page < $no_of_paginations) {
    $msg .= "<li p='$no_of_paginations' onclick='loadData($no_of_paginations)'><a href='javascript:void(0)'>>|</a></li>";
} else if ($last_btn) {
    $msg .= "<li p='$no_of_paginations' onclick='loadData($no_of_paginations)'><a href='javascript:void(0)' class='pointerevents-none'>>|</a></li>";
}
$msg = $msg . "</ul></div>";  // Content for pagination
echo $msg;
				
				
				}
				?>
			
		
	</div>
</div>


<script>
/**** tooltip ******/
$(function(){ $('[data-toggle="tooltip"]').tooltip(); });
/**** tooltip ******/

function loadData(page){                 
	$.ajax({
		type: "POST",
		url: "<?php echo ADMINURL?>plugins/summernote/images.php",
		data: "page="+page,
		success: function(msg)
		{
			$("#imagesdiv").html(msg);
		}
	});
}

/******* image delete  *******/
var image_to_delete;
var image_id;

$("#delete-image").on("click",function() {
	var checked=false;
	var chk = document.getElementsByName("imagecheck[]");
	for(var i=0; i < chk.length; i++){
		if(chk[i].checked) {
			checked = true;
		}
	}
	if (!checked) {
		alert('Select image');
		return false;
	}
	else{
		var n=window.confirm("Are you sure?");
		image_to_delete = $(this).data('image');
		
		if(n){
			$.ajax({  
				url: "<?php echo ADMINURL?>plugins/summernote/delete.php",
				type: "POST", 
				dataType: 'json',
				data: $('input[name^=\'imagecheck\']:checked'),
				beforeSend: function() {
					$('#delete-image').html('<i class="fas fa-circle-notch"></i>');
					$('#delete-image').prop('disabled', true);
				},
				complete: function() {
					$('#delete-image').html('<i class="far fa-trash-alt"></i>');
					$('#delete-image').prop('disabled', false);
				},
				success: function(json) {
					if(json=="success"){
						alert("Deleted successfully");
						$("#imagesdiv").load("<?php echo ADMINURL?>plugins/summernote/images.php");
					}
					else{
						alert("Error...");
						$("#imagesdiv").load("<?php echo ADMINURL?>plugins/summernote/images.php");
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					//alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					alert("Error...");
				}
			})
			
		}
	}
});
/******* image delete  *******/

/***** image upload  ******/
$('#button-upload').on('click', function() {
	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file[]" accept="image/*" multiple/></form>');

	$('#form-upload input[name="file[]"]').trigger('click');

	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name="file[]"]').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: '<?php echo ADMINURL?>plugins/summernote/save.php',
				type: 'post',
				data: new FormData($('#form-upload')[0]),
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$('#button-upload').html('<i class="fas fa-circle-notch"></i>');
					$('#button-upload').prop('disabled', true);
				},
				complete: function() {
					$('#button-upload').html('<i class="fas fa-upload"></i>');
					$('#button-upload').prop('disabled', false);
				},
				success: function(json) {
					if(json=="success"){
						alert("Uploaded successfully");
						$("#imagesdiv").load("<?php echo ADMINURL?>plugins/summernote/images.php");
					}
					else if(json=="invalid"){
						alert("Invalid file format");
						$("#imagesdiv").load("<?php echo ADMINURL?>plugins/summernote/images.php");
					}
					else{
						alert("Error...");
						$("#imagesdiv").load("<?php echo ADMINURL?>plugins/summernote/images.php");
					}
				},

				error: function(xhr, ajaxOptions, thrownError) {
					alert("Error...");
					//alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});
/***** image upload  ******/
</script>