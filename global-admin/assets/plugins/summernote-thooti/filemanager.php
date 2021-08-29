<?php include "../../config.php";?>
<script>
$(document).ready(function(){
	function loading_show(){
		$('#loading').html("loading").fadeIn('fast');
	}
	function loading_hide(){
		$('#loading').fadeOut('fast');
	}                
	loadData(1);
	function loadData(page){		             
		$.ajax
		({
			type: "POST",
			url: "<?php echo ADMINURL?>plugins/summernote/images.php",
			data: "page="+page,
			success: function(msg)
			{
				$("#imagesdiv").html(msg);
			}
		});
	}	// For first time page load default results
});
</script>

	<div id="imagesdiv"></div>

<script>
$("#imagesdiv").load("<?php echo ADMINURL?>plugins/summernote/images.php");
</script>