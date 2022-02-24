<?php
session_start();
require("../lib/mainconfig.php");
$check_settings = mysqli_query($db, "SELECT * FROM settings WHERE id = '1'");
$data_settings = mysqli_fetch_assoc($check_settings);
$msg_type = "nothing";

if (isset($_POST['login'])) {
  $post_username = htmlspecialchars(trim($_POST['username']));
  $post_password = htmlspecialchars(trim($_POST['password']));
  $ip = $_SERVER['REMOTE_ADDR'];
  if (empty($post_username) || empty($post_password)) {
    $msg_type = "error";
    $msg_content = "Please Fill In All Inputs.";
  } else {
    $check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$post_username'");
    if (mysqli_num_rows($check_user) == 0) {
      $msg_type = "error";
      $msg_content = "The username you entered is not registered.";
    } else {
      $data_user = mysqli_fetch_assoc($check_user);
      if (password_verify($post_password, $data_user['password'])) {
        $verified = true;
      } else {
        $verified = false;
      }

      if ($data_user['level'] == "Developers" && !$verified) {
        $ip = $_SERVER['REMOTE_ADDR'];
        $msg_type = "error";
        $msg_content = "The Password You Enter Is Wrong.";
      } else if (!$verified) {
        $msg_type = "error";
        $msg_content = "The Password You Enter Is Wrong!.";
      } else if ($data_user['status'] == "Suspended") {
        $msg_type = "error";
        $msg_content = "Account Suspended.";
      } else if ($data_user['status'] == "Not Active") {
        header("Location: " . $cfg_baseurl . "/login/verification.php");
      } else {
        $_SESSION['user'] = $data_user;
        header("Location: " . $cfg_baseurl);
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en-US" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title><?php echo $data_settings['web_title']; ?></title>
    <meta name="description" content="<?php echo $data_settings['web_description']; ?>">
    <meta name="keywords" content="<?php echo $data_settings['seo_keywords']; ?>">

    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $data_settings['link_fav']; ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $data_settings['link_fav']; ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $data_settings['link_fav']; ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $data_settings['link_fav']; ?>">
    <link rel="manifest" href="assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="<?php echo $data_settings['link_fav']; ?>">
    <meta name="theme-color" content="#ffffff">
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

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Bhaijaan+2:wght@400;500;600;700&amp;family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,300&amp;display=swap" rel="stylesheet">
    <link href="assets/css/theme.min.css" rel="stylesheet" />
    <link href="assets/css/user.min.css" rel="stylesheet" />
    
    <!--HEADER TAG-->
    <?php echo $data_settings['seo_meta']; ?>
    <!--HEADER TAG END-->

    <!--GTAG TAG-->
    <?php echo $data_settings['seo_analytics']; ?>
    <!--GTAG TAG END-->
    <!--EMBED CHAT TAG-->
    <?php echo $data_settings['seo_chat']; ?>
    <!--EMBED CHAT TAG END-->
  </head>

  <body>
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
      <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" data-navbar-on-scroll="light">
        <div class="container"><a class="navbar-brand" href="index.html"><img src="<?php echo $data_settings['link_logo']; ?>" height="45" alt="logo" /></a><button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
          <div class="collapse navbar-collapse border-top border-lg-0 mt-4 mt-lg-0" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto pt-2 pt-lg-0 font-base align-items-center">
              <li class="nav-item"><a class="nav-link px-3" href="#product">Product</a></li>
              <li class="nav-item"><a class="nav-link px-3" href="#customers">Customers</a></li>
              <li class="nav-item"><a class="nav-link px-3" href="#pricing">Pricing</a></li>
              <li class="nav-item"><a class="nav-link pl-3 me-3" href="#docs">Docs </a></li>
            </ul><a href="../register" class="btn btn-primary">Daftar</a>
          </div>
        </div>
      </nav>
      <section class="py-7 py-lg-10" id="home">
        <div class="bg-holder bg-size" style="background-image:url(assets/img/illustration/2.png);background-position:left top;background-size:contain;"></div>
        <!--/.bg-holder-->
        <div class="bg-holder d-none d-xxl-block hero-bg" style="background-image:url(assets/img/illustration/1.png);background-position:right top;background-size:contain;"></div>
        <!--/.bg-holder-->
        <div class="container">
          <div class="row align-items-center h-100 justify-content-center justify-content-lg-start">
            <div class="col-md-9 col-xxl-5 text-md-start text-center py-6 pt-8">
              <h1 class="fs-4 fs-md-5 fs-xxl-4" data-zanim-xs='{"delay":0.3}' data-zanim-trigger="scroll">SMM No.1# di Indonesia</h1>
              <p class="fs-1" data-zanim-xs='{"delay":0.5}' data-zanim-trigger="scroll">Menyediakan layanan jasa tambah follower, like, views, subscribe, share, komentar pada berbagai macam jenis platform sosial media.</p>
              <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-md-start mt-5" data-zanim-xs='{"delay":0.5}' data-zanim-trigger="scroll"><a class="btn btn-sm btn-primary me-1" href="../login" role="button">Masuk</a><a class="btn btn-sm btn-default" href="#" role="button">Untuk Memulai Belanja<i class="fas fa-arrow-right ms-2"></i></a></div>
            </div>
          </div>
        </div>
      </section>

      <!-- ============================================-->
      <!-- <section> begin ============================-->
      <section id="product">
        <div class="container">
          <div class="row mb-4">
            <div class="col-md-6 h-100 text-center text-md-start p-0 p-md-5 pb-3">
              <h2 class="mt-3">Apa Itu SMM Panel?</h2>
              <p class="mb-0">SMM Panel adalah Penyedia Layanan Panel Sosial Media Marketing untuk kebutuhan mengembangkan Sosial Media bisnis. Berbeda dengan situs followers gratis yang akan menambah following Anda, kami menawarkan penambahan followers indonesia tanpa menambah following dengan beragam pilihan layanan mulai dari yang termurah, tercepat, terbaik. Anda bebas memilih layanan mana yang ingin digunakan sesuai keinginan customer Anda.</p>
            </div>
            <div class="col-md-6">
              <div class="w-100 h-100 p-5 services-card-shadow rounded-4"><img src="assets/img/icons/1.png" alt="Dashboard" style="width:95px;" />
                <h3 class="mt-3 lh-base">Quality #1 For Business</h3>
                <p class="mb-0">Layanan dari <?php echo $data_settings['web_name']; ?> dijamin berkualitas Enterprise, karena layanan telah melewati riset dan pengembangan yang matang.</p>
              </div>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-md-6">
              <div class="w-100 h-100 p-5 services-card-shadow rounded-4"><img src="assets/img/icons/2.png" alt="Comment" style="width:95px;" />
                <h3 class="mt-3 lh-base">Platform Otomatis</h3>
                <p class="mb-0">Didukung sistem order dan tracking project otomatis yang online 24 jam, memungkinkan order kapanpun & dimanapun.</p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="w-100 h-100 p-5 services-card-shadow rounded-4"><img src="assets/img/icons/3.png" alt="Tailored" style="width:95px;" />
                <h3 class="mt-3 lh-base">Pembayaran</h3>
                <p class="mb-0">Didukung berbagai pilihan metode pembayaran otomatis yang memudahkan dan mempercepat transaksi.</p>
              </div>
            </div>
          </div>
        </div><!-- end of .container-->
      </section><!-- <section> close ============================-->
      <!-- ============================================-->



      <!-- ============================================-->
      <!-- <section> begin ============================-->
      <section id="customers">
        <div class="container">
          <h1 class="text-center display-5 fw-semi-bold" data-zanim-xs='{"delay":0.3}' data-zanim-trigger="scroll"> Apa Yang Kami Tawarkan?</h1>
          <p class="text-center fs-0 fs-md-1" data-zanim-xs='{"delay":0.5}' data-zanim-trigger="scroll"> Banyak sekali penyedia layanan yang sama, namun kami berikan yang terbaik</p>
          <div class="row mb-4 mt-6">
            <div class="col-md-6 col-lg-4 text-center"><img src="assets/img/icons/4.png" alt="Dashboard" style="width:95px;" />
              <h4 class="mt-3 lh-base">Optimasi Instan</h4>
              <p class="fs-0">Proses pengerjaan dimulai dalam 24 jam setelah pemesanan. Rata-rata 2-3 hari selesai. Mudah, cepat dan aman.</p>
            </div>
            <div class="col-md-6 col-lg-4 text-center"><img src="assets/img/icons/5.png" alt="Comment" style="width:95px;" />
              <h4 class="mt-3 lh-base">Harga Terjangkau</h4>
              <p class="fs-0">harga bervariasi dan terjangkau. Semakin banyak pembelian semakin banyak diskon-nya.</p>
            </div>
            
            <div class="col-md-6 col-lg-4 text-center"><img src="assets/img/icons/7.png" alt="Dashboard" style="width:95px;" />
              <h4 class="mt-3 lh-base">Support 24/7</h4>
              <p class="fs-0">Hubungi kami kapan saja dan dimana saja anda berada. Melalui email, live chat, internet call atau internet messaging.</p>
            </div>
          </div>
          
        </div><!-- end of .container-->
      </section><!-- <section> close ============================-->
      <!-- ============================================-->



      <!-- ============================================-->
      <!-- <section> begin ============================-->
      <section id="pricing">
        <div class="container">
          <div class="row flex-center">
            <div class="col-md-6 text-center text-md-start">
              <h4 class="fw-normal fs-3" data-zanim-xs='{"delay":0.3}' data-zanim-trigger="scroll">Beli Followers
Instagram
Terbaik</h4>
              <p class="fs-0 pe-xl-8" data-zanim-xs='{"delay":0.5}' data-zanim-trigger="scroll">Dijamin 100% aman karena tanpa password,
tidak menambah following dan simple
dengan sistem fast checkout!</p>
              <div class="d-flex justify-content-space-between align-item-center my-3 mt-2">
                <div>
                  <h4 class="fw-normal fs-1">Nyaman</h4>
                  <p class="my-1 fs-0 pe-xl-8">Nikmati nyaman dan simple nya menambah interaksi semua social media kamu dengan memakai semua benefit yang ada!</p>
                </div>
                <div>
                  <h4 class="fw-normal fs-1">Pilihan</h4>
                  <p class="my-1 fs-0 pe-xl-8">Semua yang kamu butuhkan ada disini dengan kualitas terbaik, proses cepat & harga terjangkau</p>
                </div>
              </div><a class="btn btn-sm btn-primary my-4 me-1" href="../login" role="button">Login</a><a class="btn btn-sm my-2 btn-default" href="#" role="button">Questions? Talk to our team<i class="fas fa-arrow-right ms-2"></i></a>
            </div>
            <div class="col-md-6 mb-4"><img class="w-100" src="assets/img/illustration/4.png" alt="..." /></div>
          </div>
        </div><!-- end of .container-->
      </section><!-- <section> close ============================-->
      <!-- ============================================-->



      <!-- ============================================-->
      <!-- <section> begin ============================-->
      <section>
        <div class="container">
          <div class="row align-items-center">
            <div class="col-md-6 mb-4"><img class="w-100" src="assets/img/illustration/5.png" alt="..." /></div>
            <div class="col-md-6 text-center text-md-start">
              <h4 class="fs-3 fw-normal" data-zanim-xs='{"delay":0.3}' data-zanim-trigger="scroll">Saatnya Kamu Beralih ke <?php echo $data_settings['web_name']; ?></h4>
              <p class="fs-0 pe-xl-7" data-zanim-xs='{"delay":0.5}' data-zanim-trigger="scroll">Kami senantiasa melayani anda dengan setulus hati.</p>
              <div class="d-flex justify-content-center align-item-center my-3 mt-2">
                
              </div><a class="btn btn-sm btn-primary btn-bg-purple my-4 me-1" href="../register" role="button">Get Daftar</a><a class="btn btn-sm my-2 btn-default" href="#" role="button">Questions? Talk to our team<i class="fas fa-arrow-right ms-2"></i></a>
            </div>
          </div>
        </div><!-- end of .container-->
      </section><!-- <section> close ============================-->
      <!-- ============================================-->

      
      
      
      <section class="py-0 bg-1000">
        

        <!-- ============================================-->
        <!-- <section> begin ============================-->
        <section class="py-0 bg-1000">
          <div class="container">
            <div class="row justify-content-md-between justify-content-evenly py-3">
              <div class="col-12 col-sm-8 col-md-6 col-lg-auto text-center text-md-start">
                <p class="fs--1 my-2 fw-bold text-200">&copy;
                  <script type='text/javascript'>
                  var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

                  var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];

                  var date = new Date();

                  var day = date.getDate();

                  var month = date.getMonth();

                  var thisDay = date.getDay(),

                      thisDay = myDays[thisDay];

                  var yy = date.getYear();

                  var year = (yy < 1000) ? yy + 1900 : yy;

                  document.write(year + ' ');

                  </script>
                  <?php echo $data_settings['web_name']; ?></p>
              </div>
              <div class="col-12 col-sm-8 col-md-6">
                <p class="fs--1 my-2 text-center text-md-end text-200"> Made with&nbsp;<svg class="bi bi-suit-heart-fill" xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="#F95C19" viewBox="0 0 16 16">
                    <path d="M4 1c2.21 0 4 1.755 4 3.92C8 2.755 9.79 1 12 1s4 1.755 4 3.92c0 3.263-3.234 4.414-7.608 9.608a.513.513 0 0 1-.784 0C3.234 9.334 0 8.183 0 4.92 0 2.755 1.79 1 4 1z"></path>
                  </svg>&nbsp;by&nbsp;<a class="fw-bold text-info text-200" href="https://jasaholic.com/" target="_blank">Jasaholic </a></p>
              </div>
            </div>
          </div><!-- end of .container-->
        </section><!-- <section> close ============================-->
        <!-- ============================================-->

      </section>
    </main><!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->



    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="vendors/popper/popper.min.js"></script>
    <script src="vendors/bootstrap/bootstrap.min.js"></script>
    <script src="vendors/anchorjs/anchor.min.js"></script>
    <script src="vendors/is/is.min.js"></script>
    <script src="vendors/fontawesome/all.min.js"></script>
    <script src="vendors/lodash/lodash.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.7.0/gsap.min.js"></script>
    <script src="vendors/imagesloaded/imagesloaded.pkgd.js"></script>
    <script src="vendors/gsap/customEase.js"></script>
    <script src="vendors/gsap/scrollToPlugin.js"></script>
    <!--script(src=`${CWD}vendors/gsap/drawSVGPlugin.js`)-->
    <script src="assets/js/theme.js"></script>
  </body>

</html>
