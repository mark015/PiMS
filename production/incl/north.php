<?php
 include('incl/config.php');
 include('incl/auth.php');
  if (!empty($_GET['link'])) {
    $link = $_GET['link'];
  } else {
      $link = ''; // Default value if link is not provided
  }
?>

<!DOCTYPE html>
<html lang="en">
  <?php include 'incl/head.php';?>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index" class="site_title"><i class="fa fa-qrcode"></i> <span>PiMS</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
          <?php include 'incl/menu_profile.php';?>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <?php include 'incl/sidebar.php';?>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->

            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <?php include 'incl/navbar.php';?>
        <!-- /top navigation -->
