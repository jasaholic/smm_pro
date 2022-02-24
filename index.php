<?php
session_start();
require("lib/mainconfig.php");
$msg_type = "nothing";

/* CHECK FOR MAINTENANCE */
if ($cfg_mt == 1) {
    die("Web is under maintenance.");
} else {

    /* CHECK USER SESSION */
    if (isset($_SESSION['user'])) {
        $sess_username = $_SESSION['user']['username'];
        $check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
        $data_user = mysqli_fetch_assoc($check_user);
        if (mysqli_num_rows($check_user) == 0) {
            header("Location: " . $cfg_baseurl . "/logout/");
        } else if ($data_user['status'] == "Suspended") {
            header("Location: " . $cfg_baseurl . "/logout/");
        }

        /* DATA FOR DASHBOARD */
        $check_order = mysqli_query($db, "SELECT SUM(price) AS total FROM orders WHERE user = '$sess_username' AND status = 'Success' OR user = '$sess_username' AND status = 'Pending' OR user = '$sess_username' AND status = 'Processing' OR user = '$sess_username' AND status = 'In Progress'");
        $data_order = mysqli_fetch_assoc($check_order);

        $number_order = mysqli_num_rows(mysqli_query($db, "SELECT * FROM orders WHERE user = '$sess_username'"));

        $number_order_completed = mysqli_num_rows(mysqli_query($db, "SELECT * FROM orders WHERE user = '$sess_username' AND status = 'Success'"));

        $number_order_pending = mysqli_num_rows(mysqli_query($db, "SELECT * FROM orders WHERE user = '$sess_username' AND status = 'Pending'"));

        $number_order_proses = mysqli_num_rows(mysqli_query($db, "SELECT * FROM orders WHERE user = '$sess_username' AND  status = 'In Progress'"));

        $number_order_error = mysqli_num_rows(mysqli_query($db, "SELECT * FROM orders WHERE user = '$sess_username' AND  status = 'Error'"));


        $count_users = mysqli_num_rows(mysqli_query($db, "SELECT * FROM users"));

        /* DATA FOR ORDERS STATISTICS CHART */
        $date_1 = date('Y-m-d', (strtotime('-5 day', strtotime($date))));
        $date_2 = date('Y-m-d', (strtotime('-4 day', strtotime($date))));
        $date_3 = date('Y-m-d', (strtotime('-3 day', strtotime($date))));
        $date_4 = date('Y-m-d', (strtotime('-2 day', strtotime($date))));
        $date_5 = date('Y-m-d', (strtotime('-1 day', strtotime($date))));
        $date_6 = $date;

        $count_c_date_1 = mysqli_num_rows(mysqli_query($db, "SELECT * FROM orders WHERE user = '$sess_username' AND (status = 'Success' OR status = 'Completed') AND date = '$date_1'"));
        $count_c_date_2 = mysqli_num_rows(mysqli_query($db, "SELECT * FROM orders WHERE user = '$sess_username' AND (status = 'Success' OR status = 'Completed') AND date = '$date_2'"));
        $count_c_date_3 = mysqli_num_rows(mysqli_query($db, "SELECT * FROM orders WHERE user = '$sess_username' AND (status = 'Success' OR status = 'Completed') AND date = '$date_3'"));
        $count_c_date_4 = mysqli_num_rows(mysqli_query($db, "SELECT * FROM orders WHERE user = '$sess_username' AND (status = 'Success' OR status = 'Completed') AND date = '$date_4'"));
        $count_c_date_5 = mysqli_num_rows(mysqli_query($db, "SELECT * FROM orders WHERE user = '$sess_username' AND (status = 'Success' OR status = 'Completed') AND date = '$date_5'"));
        $count_c_date_6 = mysqli_num_rows(mysqli_query($db, "SELECT * FROM orders WHERE user = '$sess_username' AND (status = 'Success' OR status = 'Completed') AND date = '$date_6'"));

        $count_p_date_1 = mysqli_num_rows(mysqli_query($db, "SELECT * FROM orders WHERE user = '$sess_username' AND (status = !'Success' OR status = !'Completed') AND date = '$date_1'"));
        $count_p_date_2 = mysqli_num_rows(mysqli_query($db, "SELECT * FROM orders WHERE user = '$sess_username' AND (status = !'Success' OR status = !'Completed') AND date = '$date_2'"));
        $count_p_date_3 = mysqli_num_rows(mysqli_query($db, "SELECT * FROM orders WHERE user = '$sess_username' AND (status = !'Success' OR status = !'Completed') AND date = '$date_3'"));
        $count_p_date_4 = mysqli_num_rows(mysqli_query($db, "SELECT * FROM orders WHERE user = '$sess_username' AND (status = !'Success' OR status = !'Completed') AND date = '$date_4'"));
        $count_p_date_5 = mysqli_num_rows(mysqli_query($db, "SELECT * FROM orders WHERE user = '$sess_username' AND (status = !'Success' OR status = !'Completed') AND date = '$date_5'"));
        $count_p_date_6 = mysqli_num_rows(mysqli_query($db, "SELECT * FROM orders WHERE user = '$sess_username' AND (status = !'Success' OR status = !'Completed') AND date = '$date_6'"));

        $check_order_today = mysqli_query($db, "SELECT SUM(price) AS total FROM orders WHERE user = '$sess_username' AND status = 'Success' AND date = '$date' OR user = '$sess_username' AND status = 'Pending' AND date = '$date' OR user = '$sess_username' AND status = 'Processing' AND date = '$date' OR user = '$sess_username' AND status = 'In Progress' AND date = '$date'");
        $data_order_today = mysqli_fetch_assoc($check_order_today);

        /* GENERAL WEB SETTINGS */
        $check_settings = mysqli_query($db, "SELECT * FROM settings WHERE id = '1'");
        $data_settings = mysqli_fetch_assoc($check_settings);

        $email = $data_user['email'];
        $hp = $data_user['nohp'];
        /* if ($email == "") {
  header("Location: ".$cfg_baseurl2."settings.php");
  } */
    } else {
        header("Location: home");
    }
    $title = "Dashboard";
    include("lib/header.php");
    if (isset($_SESSION['user'])) {
?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $number_order; ?></h3>

                <p>Total Order</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="history/order/" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <?php
                                        if ($data_user['balance'] == "0" or $data_user['balance'] < 0) {
                                        ?>
                <h3><?php echo rupiah($data_user['balance']); ?></h3>
                <?php
                                        } ?>
                                        <?php
                                        if ($data_user['balance'] > 0) {
                                        ?>
                <h3><?php echo rupiah($data_user['balance']); ?></h3>
                 <?php
                                        } ?>
                <p>Sisa Saldo</p>
              </div>
              <div class="icon">
                <i class="ion ion-card"></i>
              </div>
              <a href="tripay/" class="small-box-footer">Deposit Lagi <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo rupiah($data_order['total']); ?></h3>

                <p>Total Pengeluaran</p>
              </div>
              <div class="icon">
                <i class="ion ion-card"></i>
              </div>
              <a href="history/balance/" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo rupiah($data_order['total'] - $data_order_today['total']); ?></h3>

                <p>Pengeluaran Harian</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.css">
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Grafik Pemesanan</h5>

              
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    
                    <div class="chart">
                      <!-- Sales Chart Canvas -->
                      <canvas id="myChart" height="180" style="height: 280px;"></canvas>
                    </div>
                    <!-- /.chart-responsive -->
                  </div>
                  <!-- /.col -->
                  
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
              
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <div class="col-md-8">
            <!-- MAP & BOX PANE -->
            

            <!-- TABLE: LATEST ORDERS -->
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Pesanan Terakhir</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th>Layanan</th>
                      <th>Status</th>
                      <th>Jumlah</th>
                      <th>Harga</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php
                    // start paging config
                    $query_order = mysqli_query($db, "SELECT * FROM orders WHERE user = '$sess_username' ORDER BY id DESC LIMIT 5" );
                    // end paging config
                    while ($data_order = mysqli_fetch_assoc($query_order)) {
                      if ($data_order['status'] == "Pending") {
                        $label = "warning";
                      } else if ($data_order['status'] == "Processing") {
                        $label = "info";
                      } else if ($data_order['status'] == "In Progress") {
                        $label = "info";
                      } else if ($data_order['status'] == "Error") {
                        $label = "danger";
                      } else if ($data_order['status'] == "Canceled") {
                        $label = "danger";
                      } else if ($data_order['status'] == "Partial") {
                        $label = "danger";
                      } else if ($data_order['status'] == "Success") {
                        $label = "success";
                      } else if ($data_order['status'] == "Completed") {
                        $label = "success";
                      }
                    ?>
                    <tr>
                      <td>#<?php echo $data_order['poid']; ?></td>
                      <td><?php echo $data_order['service']; ?></td>
                      <td><span class="badge badge-<?php echo $label; ?>"><?php echo $data_order['status']; ?></span></td>
                      <td>
                        <div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo number_format($data_order['quantity'], 0, ',', '.'); ?></div>
                      </td>
                      <td><?php echo rupiah($data_order['price']); ?></td>
                    </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <a href="order/" class="btn btn-sm btn-info float-left">Order</a>
                <a href="history/order" class="btn btn-sm btn-secondary float-right">Lihat Semua</a>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->

          <div class="col-md-4">
            <!-- Info Boxes Style 2 -->
            <div class="info-box mb-3 bg-primary">
              <span class="info-box-icon"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Pesanan Selesai</span>
                <span class="info-box-number"><?php echo $number_order_completed; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-success">
              <span class="info-box-icon"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Pesanan Diproses</span>
                <span class="info-box-number"><?php echo $number_order_proses; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-warning">
              <span class="info-box-icon"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Pesanan Pending</span>
                <span class="info-box-number"><?php echo $number_order_pending; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-danger">
              <span class="info-box-icon"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Pesanan Error</span>
                <span class="info-box-number"><?php echo $number_order_error; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->

            
            <!-- /.card -->

            
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="plugins/raphael/raphael.min.js"></script>
<script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>

<script>
                                                var ctx = document.getElementById('myChart');
                                                var myChart = new Chart(ctx, {
                                                    type: 'line',
                                                    data: {
                                                        labels: ['<?php echo $date_1; ?>', '<?php echo $date_2; ?>', '<?php echo $date_3; ?>', '<?php echo $date_4; ?>', '<?php echo $date_5; ?>', '<?php echo $date_6; ?>'],
                                                        datasets: [{
                                                                label: 'Completed',
                                                                fill: true,
                                                                data: [<?php echo $count_c_date_1; ?>, <?php echo $count_c_date_2; ?>, <?php echo $count_c_date_3; ?>, <?php echo $count_c_date_4; ?>, <?php echo $count_c_date_5; ?>, <?php echo $count_c_date_6; ?>],
                                                                backgroundColor: 'rgba(50,141,255,.2)',
                                                                borderColor: '#328dff',
                                                                pointBorderColor: '#328dff',
                                                                pointBackgroundColor: '#fff',
                                                                pointBorderWidth: 2,
                                                                borderWidth: 1,
                                                                borderJoinStyle: 'miter',
                                                                pointHoverBackgroundColor: '#328dff',
                                                                pointHoverBorderColor: '#328dff',
                                                                pointHoverBorderWidth: 1,
                                                                pointRadius: 3,

                                                            },
                                                            {
                                                                label: 'Not Completed',
                                                                fill: false,
                                                                data: [<?php echo $count_p_date_1; ?>, <?php echo $count_p_date_2; ?>, <?php echo $count_p_date_3; ?>, <?php echo $count_p_date_4; ?>, <?php echo $count_p_date_5; ?>, <?php echo $count_p_date_6; ?>],
                                                                borderDash: [5, 5],
                                                                backgroundColor: 'rgba(87,115,238,.3)',
                                                                borderColor: '#2979ff',
                                                                pointBorderColor: '#2979ff',
                                                                pointBackgroundColor: '#2979ff',
                                                                pointBorderWidth: 2,

                                                                borderWidth: 1,
                                                                borderJoinStyle: 'miter',
                                                                pointHoverBackgroundColor: '#2979ff',
                                                                pointHoverBorderColor: '#fff',
                                                                pointHoverBorderWidth: 1,
                                                                pointRadius: 3,

                                                            }
                                                        ]
                                                    },
                                                    options: {
                                                        maintainAspectRatio: false,
                                                        legend: {
                                                            display: true
                                                        },

                                                        scales: {
                                                            xAxes: [{
                                                                display: true,
                                                                gridLines: {
                                                                    zeroLineColor: '#eee',
                                                                    color: '#eee',

                                                                    borderDash: [5, 5],
                                                                }
                                                            }],
                                                            yAxes: [{
                                                                display: true,
                                                                gridLines: {
                                                                    zeroLineColor: '#eee',
                                                                    color: '#eee',
                                                                    borderDash: [5, 5],
                                                                }
                                                            }]

                                                        },
                                                        elements: {
                                                            line: {

                                                                tension: 0.4,
                                                                borderWidth: 1
                                                            },
                                                            point: {
                                                                radius: 2,
                                                                hitRadius: 10,
                                                                hoverRadius: 6,
                                                                borderWidth: 4
                                                            }
                                                        }
                                                    }
                                                });
                                            </script>
</body>
</html>
 <?php
    }
    include("lib/footer.php");
}
    ?>