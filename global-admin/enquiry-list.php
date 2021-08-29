<?php 
ob_start();
session_start();
include("includes/config.php"); 
$table_enquiry="".DB_PREFIX."_enquiry_list";
$current_page = "enquiry-list.php";
if(isset($_REQUEST['submit_action'])) {
	$date_range =$db_cms->removeQuote(get_symbol($_POST["d_range"]));
	header('Location:'.$current_page.'?drange='.$date_range);
}
$drange = get_symbol($_REQUEST['drange']);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Enquiry Lists | <?=$site_title;?></title>
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
            <h1 class="m-0 text-dark">Enquiry Lists</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Enquiry</li>
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
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Enquiry Lists</h3>
				<?php  if($_REQUEST['action'] == "view"){ ?>
				<div class="card-tools">
				  <a href="<?=$current_page;?>" class="btn btn-default btn-md p-1 text-muted" title="Click to back"><i class="fas fa-reply" aria-hidden="true"></i> </a>
				</div>
				<?php } ?>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
				<?php
				if($_REQUEST['action'] == ""){  
				?>
                <table id="example2" class="table table-bordered table-striped inbox_data">
                  <thead>
                  <tr>
                    <th>SI </th>
                    <th>Date </th>
                    <th>Name</th>
                    <th>Mail ID</th>
					<th>Mob. No</th>
                    <th>Message</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php 
					$sql="SELECT * FROM $table_enquiry";
                                $res=$db_cms->select_query_with_rows($sql);
                                if($res!=FALSE){
                                    $i=1;
                                    foreach ($res as $row){
                                        ?>
                  <tr>
				    <td> <?=$i;?></td>
                    <td> <?php echo $row["submitted_date"]; ?></td>
                    <td>  <?php echo $row["name"]; ?></td>
					<td>  <?php echo $row["email"]; ?></td>
                    <td>  <?php echo $row["phone"]; ?></td>
                    <td>  <?php echo $row["message"]; ?></td>
					
                  </tr>
				   <?php
                                        $i++;
                                    }
                                }
                                ?>
                  </tbody>
                </table>
				<?php 
				} ?>
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
<?php include_once("includes/footer.php");?>
</div>
<!-- ./wrapper -->
<script>

$(document).ready(function () {
	
	function table_ajax(daterangeval) {
		table = $('#example2').DataTable();
		table.destroy();
		table = $('#example2').DataTable({ 
			"responsive": true,
			  "autoWidth": false,
			  "minHeight": 300,
			  "buttons": [  "csv"],
    }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
	}
	$('#cust_detail input').prop('disabled', true);
	var daterangeval = "all";
	table_ajax(daterangeval);
	$(function () {
		$('#reservation').daterangepicker({
			locale: {
				format: 'YYYY/MM/DD'
			}
		});
		$( "#reservation" ).change(function() {
});
	})
$( "row" ).addClass( "col-sm-12 col-md-6" );
});



</script>
</body>
</html>
