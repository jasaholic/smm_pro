<?php
session_start();
require("../../lib/mainconfig.php");


if (!isset($_SESSION)) {
  session_start();
}
/* CLEARING POST DATA IF EXISTS*/
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $_SESSION['postdata'] = $_POST;
  unset($_POST);
  header("Location: " . $_SERVER[REQUEST_URI]);
  exit;
}

if (@$_SESSION['postdata']) {
  $_POST = $_SESSION['postdata'];
  unset($_SESSION['postdata']);
}
//clear

/* CHECK USER SESSION */
if (isset($_SESSION['user'])) {
  $sess_username = $_SESSION['user']['username'];
  $sess_id = $_SESSION['user']['id'];
  $check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
  $data_user = mysqli_fetch_assoc($check_user);
  if (mysqli_num_rows($check_user) == 0) {
    header("Location: " . $cfg_baseurl . "/logout/");
  } else if ($data_user['status'] == "Suspended") {
    header("Location: " . $cfg_baseurl . "/logout/");
  }
  $email = $data_user['email'];
  if ($email == "") {
    header("Location: " . $cfg_baseurl . "settings");
  }
  $title = "Deposit History";
  include("../../lib/header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Riwayat Deposit</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Riwayat Deposit</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Riwayat Deposit</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No.</th>
                    <th>No.Invoice</th>
                    <th>Tanggal</th>
                    <th>Metode</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    // start paging config
                    $query_order = mysqli_query($db, "SELECT * FROM deposits WHERE user = '$sess_id' ORDER BY id DESC");
                    // end paging config

                    while ($data_order = mysqli_fetch_assoc($query_order)) {
                      if ($data_order['status'] == "Error") {
                        $label = "danger";
                        $label2 = "Error";
                      } else if ($data_order['status'] == "Pending") {
                        $label = "warning";
                        $label2 = "Pending";
                      } else if ($data_order['status'] == "Success") {
                        $label = "success";
                        $label2 = "Success";
                      } else if ($data_order['status'] == "Expired") {
                        $label = "secondary";
                        $label2 = "Expired";
                      }
                    ?>
                      <?php $no = $no + 1; ?>

                  <tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $data_order['invoice_number']; ?>
                    </td>
                    <td><?php echo $data_order['created_at']; ?></td>
                    <td><?php echo $data_order['code']; ?></td>
                    <td><?php echo rupiah($data_order['balance']); ?></td>
                    <td><span class="badge badge-<?php echo $label; ?>"><?php echo $label2; ?></span></td>
                    <td>
                      <?php
                          if ($data_order['status'] == "Expired" or $data_order['status'] == "Error" or $data_order['status'] == "Success")  { ?>
                      <button type="button" disabled="true" class="btn btn-outline-secondary btn-xs" onclick="showInstruction(<?php echo $data_order['id']; ?>)"><i class="nav-icon fa fa-credit-card"></i>
                      </button>
                      <?php
                          } else { ?>
                      <button type="button" class="btn btn-outline-secondary btn-xs" onclick="showInstruction(<?php echo $data_order['id']; ?>)"><i class="nav-icon fa fa-credit-card"></i>
                      </button>
                      <?php
                          }
                          ?>
                    </td>
                  </tr>
                  <?php
                    }
                    ?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>No.</th>
                    <th>No.Invoice</th>
                    <th>Tanggal</th>
                    <th>Metode</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- Modal -->
          <div class="modal fade" id="instructionsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h2 class="modal-title" id="exampleModalLabel">Cara Pembayaran</h2>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div id="data" style="margin: 10px;"></div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                </div>
              </div>
            </div>
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
  

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../plugins/jszip/jszip.min.js"></script>
<script src="../../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script>
    function showInstruction(id) {
      if (id == "") {
        document.getElementById("data").innerHTML = "";
        return;
      } else {
        $('#instructionsModal').modal()
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("data").innerHTML = this.responseText;
          }
        };
        xmlhttp.open("GET", "instruction.php?id=" + id, true);
        xmlhttp.send();
      }
    }
  </script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
<?php
        include("../../lib/footer.php");
      } else {
        header("Location: " . $cfg_baseurl);
      } ?>