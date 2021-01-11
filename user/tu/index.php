<?php
session_start();
if (!isset($_SESSION["login_tu"])) {
header("location:../../index.php");
exit();
}
require "../../koneksi.php";
require "assets/notif.php";

$nidn = $_SESSION["nidn"];
$nama = $_SESSION["nama"];
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIM-PS | Dashboard | Tata Usaha</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="../../plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="../../plugins/summernote/summernote-bs4.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/fixedheader/3.1.7/css/fixedHeader.bootstrap.min.css">
  <link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap.min.css">
  </head>
<?php include 'assets/header.php'; ?>        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <div class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <!-- <h1 class="m-0 text-dark">Dashboard</h1> -->
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                      <li class="breadcrumb-item"><a href="#">Home</a></li>
                      <li class="breadcrumb-item active">Tata Usaha</li>
                      <li class="breadcrumb-item active"><?= $u_create ?></li>
                    </ol>
                    </div><!-- /.col -->
                    </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                  </div>
                  <!-- /.content-header -->
                  <!-- Main content -->
                  <section class="content">
                    <div class="container-fluid">
                      <!-- Small boxes (Stat box) -->
                      <!-- Main row -->
                      <div class="row">
                        <!-- Left col -->
                         <section class="col-lg-12">
                              <!-- Map card -->
                              <div id="notif">
                              <center>
                              <h1 class="m-0 text-dark">Dashboard</h1>
                              <div class="alert alert-success alert-dismissible fade show" role="alert">
                              <marquee behavior="" direction="left">
                              Selamat Datang Kembali, <strong><?=$nama?></strong>
                              </marquee>
                            </div>
                              </center>
                              <div class="card bg-gradient-white">
                                <div class="card-header">
                                  <h3 class="card-title">
                                  <i class="fas fa-bell"></i>
                                  Panel Notifikasi
                                  <?php 
                                  if ($count > 0) {
                                    echo '<span class="badge badge-danger right"><h5 class="jumlah">'.$count.'</h5></span>';
                                  }
                                  ?>
                                  </h3>
                                  <!-- card tools -->
                                  <div class="card-tools">
                                  <button data-toggle="collapse" data-target="#body" class="btn-sm btn-info">
                                  <i class="fas fa-window-minimize"></i></button>
                                  </div>
                                  <!-- /.card-tools -->
                                </div>
                                </div>
                                <div class="collapse" id="body">
                                <div class="row">
                              <div class="col-lg-3 col-3">
                                <!-- small box -->
                                <!-- bimbingan pkl -->
                                <div class="small-box bg-info pdpkl">
                                  <div class="inner">
                                  <?php $pdpkl_ = mysqli_num_rows($pdpkl);?>  
                                  <h3><?= $pdpkl_ ?></h3>
                                    <p>Pendaftar Sidang PKL</p>
                                  </div>
                                  <div class="icon">
                                    <i class="fas fa-pencil-ruler"></i>
                                  </div>
                                </div>
                              </div>
                              <div class="col-lg-3 col-3">
                                <!-- small box -->
                                <!-- bimbingan pkl -->
                                <div class="small-box bg-danger pkl">
                                  <div class="inner">
                                  <?php $pdprop_ = mysqli_num_rows($pdprop);?>  
                                  <h3><?= $pdprop_ ?></h3>
                                    <p>Pendaftar Sidang Proposal</p>
                                  </div>
                                  <div class="icon">
                                    <i class="fas fa-pencil-ruler"></i>
                                  </div>
                                </div>
                              </div>
                              <div class="col-lg-3 col-3">
                                <!-- small box -->
                                <!-- bimbingan pkl -->
                                <div class="small-box bg-dark pkl">
                                  <div class="inner">
                                  <?php $pddraft_ = mysqli_num_rows($pddraft);?>  
                                  <h3><?= $pddraft_ ?></h3>
                                    <p>Pendaftar Sidang Draft</p>
                                  </div>
                                  <div class="icon">
                                    <i class="fas fa-pencil-ruler"></i>
                                  </div>
                                </div>
                              </div>
                              <div class="col-lg-3 col-3">
                                <!-- small box -->
                                <!-- bimbingan pkl -->
                                <div class="small-box bg-warning pkl">
                                  <div class="inner">
                                  <?php $pdpend_ = mysqli_num_rows($pdpend);?>  
                                  <h3><?= $pdpend_ ?></h3>
                                    <p>Pendaftar Sidang Pendadaran</p>
                                  </div>
                                  <div class="icon">
                                    <i class="fas fa-pencil-ruler"></i>
                                  </div>
                                </div>
                              </div>
                              <div class="col-lg-3 col-3">
                                <!-- small box -->
                                <!-- bimbingan pkl -->
                                <div class="small-box bg-danger v1">
                                  <div class="inner">
                                  <?php $pdv1_ = mysqli_num_rows($v1);?>  
                                  <h3><?= $pdv1_ ?></h3>
                                    <p>Validasi Persyaratan PKL</p>
                                  </div>
                                  <div class="icon">
                                    <i class="fas fa-pencil-ruler"></i>
                                  </div>
                                </div>
                              </div>
                              <div class="col-lg-3 col-3">
                                <!-- small box -->
                                <!-- bimbingan pkl -->
                                <div class="small-box bg-success v1">
                                  <div class="inner">
                                    <p>Sidang PKL Hari Ini :<?= $spkl ?></p>
                                    <p>Sidang Proposal Hari Ini :<?= $sprop ?></p>
                                  </div>
                                  <div class="icon">
                                    <i class="fas fa-pencil-ruler"></i>
                                  </div>
                                </div>
                              </div>
                              <div class="col-lg-3 col-3">
                                <!-- small box -->
                                <!-- bimbingan pkl -->
                                <div class="small-box bg-success v1">
                                  <div class="inner">
                                  <p>Sidang Draft Hari Ini :<?= $sdraft ?></p>
                                  <p>Sidang Pendadaran Hari Ini :<?= $spend ?></p>
                                  </div>
                                  <div class="icon">
                                    <i class="fas fa-pencil-ruler"></i>
                                  </div>
                                </div>
                              </div>
                              <div class="col-lg-3 col-3">
                                <!-- small box -->
                                <!-- bimbingan pkl -->
                                <div class="small-box bg-danger v1">
                                  <div class="inner">
                                  <?php $pdv2 = mysqli_num_rows($v2);?>  
                                  <h3><?= $pdv2 ?></h3>
                                    <p>Validasi Persyaratan Skripsi</p>
                                  </div>
                                  <div class="icon">
                                    <i class="fas fa-pencil-ruler"></i>
                                  </div>
                                </div>
                              </div>
                                </div>
                                <!-- /.card-body-->
                              </div>
                              <!-- /.card -->
                            </section>
                            <!-- right col -->
                          </div>
                          <!-- /.row (main row) -->
                          </div><!-- /.container-fluid -->
                          </div> 
                          <!-- div notif /. -->
                        </section>
                        <!-- /.content -->
                      </div>
                      <!-- /.content-wrapper -->
                      <?php include 'assets/footer.php'; ?>
                      <!-- Control Sidebar -->
                      <aside class="control-sidebar control-sidebar-dark">
                        <!-- Control sidebar content goes here -->
                      </aside>
                      <!-- /.control-sidebar -->
                    </div>
                    <!-- ./wrapper -->
                    <!-- jQuery -->
                    <script src="../../plugins/jquery/jquery.min.js"></script>
                    <!-- jQuery UI 1.11.4 -->
                    <script src="../../plugins/jquery-ui/jquery-ui.min.js"></script>
                    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
                    <script>
                    $.widget.bridge('uibutton', $.ui.button)
                    </script>
                    <!-- Bootstrap 4 -->
                    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
                    <!-- ChartJS -->
                    <script src="../../plugins/chart.js/Chart.min.js"></script>
                    <!-- Sparkline -->
                    <script src="../../plugins/sparklines/sparkline.js"></script>
                    <!-- JQVMap -->
                    <script src="../../plugins/jqvmap/jquery.vmap.min.js"></script>
                    <script src="../../plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
                    <!-- jQuery Knob Chart -->
                    <script src="../../plugins/jquery-knob/jquery.knob.min.js"></script>
                    <!-- daterangepicker -->
                    <script src="../../plugins/moment/moment.min.js"></script>
                    <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
                    <!-- Tempusdominus Bootstrap 4 -->
                    <script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
                    <!-- Summernote -->
                    <script src="../../plugins/summernote/summernote-bs4.min.js"></script>
                    <!-- overlayScrollbars -->
                    <script src="../../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
                    <!-- AdminLTE App -->
                    <script src="../../dist/js/adminlte.js"></script>
                    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
                    <script src="../../dist/js/pages/dashboard.js"></script>
                    <!-- AdminLTE for demo purposes -->
                    <script src="../../dist/js/demo.js"></script>
                  </body>
                </html>