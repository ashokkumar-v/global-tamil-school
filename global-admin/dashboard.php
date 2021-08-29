<?php 
ob_start();
session_start();
include("includes/config.php"); 
$current_page = "dashboard.php";
$enquiry=$db_cms->count_query("SELECT * FROM sa_enquiry_list ");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?=$site_title;?> | Dashboard</title>
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
            <h1 class="m-0 text-dark">Customers Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
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
			<div class="col-lg-3 col-6">
			<div class="small-box bg-gradient-info">
              <div class="inner">
                <h3><?=$enquiry;?></h3>
                <p>Home Enquiry</p>
              </div>
              <div class="icon">
                <i class="ion ion-ios-people-outline"></i>
              </div>
              <a href="enquiry-list.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
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
</body>
</html>