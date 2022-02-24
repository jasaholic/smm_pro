<?php
if (isset($_SESSION['user'])) {
    $email = $data_user['email'];
    $hp = $data_user['nohp'];
    $nama = $data_user['name'];

    $check_settings = mysqli_query($db, "SELECT * FROM settings WHERE id = '1'");
    $data_settings = mysqli_fetch_assoc($check_settings);
    if ($email == "") {
        header("Location: " . $cfg_baseurl . "/settings/");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $data_settings['web_title']; ?></title>
  <meta name="description" content="<?php echo $data_settings['web_description']; ?>">
    <meta name="keywords" content="<?php echo $data_settings['seo_keywords']; ?>">
  <!--HEADER TAG-->
    <?php echo $data_settings['seo_meta']; ?>
    <!--HEADER TAG END-->

    <!--GTAG TAG-->
    <?php echo $data_settings['seo_analytics']; ?>
    <!--GTAG TAG END-->
    <!--EMBED CHAT TAG-->
    <?php echo $data_settings['seo_chat']; ?>
    <!--EMBED CHAT TAG END-->

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo $cfg_baseurl; ?>/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $cfg_baseurl; ?>/dist/css/adminlte.min.css">
  <link rel="icon" href="<?php echo $data_settings['link_fav']; ?>">
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="<?php echo $cfg_baseurl; ?>/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>  -->

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <?php
                                        if ($data_user['balance'] == "0" or $data_user['balance'] < 0) {
                                        ?>
        <a type="button" class="nav-link"><i class="fas fa-credit-card"></i> <?php echo rupiah($data_user['balance']); ?></a><?php
                                        } ?>
                                        <?php
                                        if ($data_user['balance'] > 0) {
                                        ?>
        <a type="button" class="nav-link"><i class="fas fa-credit-card"></i> <?php echo rupiah($data_user['balance']); ?></a><?php
                                        } ?>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo $cfg_baseurl; ?>" class="brand-link">
      <img src="<?php echo $cfg_baseurl; ?>/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Dashboard</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          <li class="nav-item">
            <a href="<?php echo $cfg_baseurl; ?>" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Beranda
                
              </p>
            </a>
          </li>
          
          <li class="nav-header">Layanan</li>
          <li class="nav-item">
            <a href="<?php echo $cfg_baseurl; ?>/tripay" class="nav-link">
              <i class="nav-icon fas fa-credit-card"></i>
              <p>
                Deposit Instant
                
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo $cfg_baseurl; ?>/order" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Order
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo $cfg_baseurl; ?>/services" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Layanan
              </p>
            </a>
          </li>
          
          
          <li class="nav-header">Riwayat</li>
          <li class="nav-item">
            <a href="<?php echo $cfg_baseurl; ?>/history/deposit" class="nav-link">
              <i class="nav-icon fas fa-credit-card"></i>
              <p>Deposit</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo $cfg_baseurl; ?>/history/balance" class="nav-link">
              <i class="nav-icon fas fa-credit-card"></i>
              <p>Saldo</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo $cfg_baseurl; ?>/history/order" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>Pemesanan</p>
            </a>
          </li>
          <li class="nav-header">Halaman</li>
          <li class="nav-item">
            <a href="<?php echo $cfg_baseurl; ?>/settings" class="nav-link">
              <i class="fas fa-cog nav-icon"></i>
              <p>Pengaturan</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo $cfg_baseurl; ?>/api" class="nav-link">
              <i class="nav-icon fas fa-code"></i>
              <p>
                Dok API
                
              </p>
            </a>
            
          </li>
          
          <li class="nav-header">Session</li>
          <?php
                    if ($data_user['level'] == "Developers") {
                    ?>
          <li class="nav-item">
            <a href="<?php echo $cfg_baseurl; ?>/admin" class="nav-link">
              <i class="nav-icon fas fa-cog text-danger"></i>
              <p class="text">Administrator</p>
            </a>
          </li>
           <?php
                    }
                    ?>
          <li class="nav-item">
            <a href="<?php echo $cfg_baseurl; ?>/keluar" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>Keluar</p>
            </a>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>