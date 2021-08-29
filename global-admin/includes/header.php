<?php if(empty($_SESSION['webadmin_id']) && empty($_SESSION['webadmin_username'])){
    $_SESSION["cms_status"]="error";
    $_SESSION["cms_msg"]="Please login now!";
    header('Location:index.php');
    exit();
}
?>
 <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
	<ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a href="#">
              <img src="assets/img/profile.png" class="user-image" alt="User Image">
              <span><?php echo $_SESSION['webadmin_username'];?> </span>
            </a>
      </li>
      <li class="nav-item">
		<a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->