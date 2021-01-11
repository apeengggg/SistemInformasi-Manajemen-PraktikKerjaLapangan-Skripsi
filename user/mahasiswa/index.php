<?php
session_start();
if (!isset($_SESSION["login_mhs"])) {
header("location:../../index.php");
exit();
}
require "../../koneksi.php";
$nim = $_SESSION["nim"];
$nama = $_SESSION["nama"];

include 'assets/notif.php';

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIM-PS | Dashboard | Mahasiswa</title>
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
  </head>
		<?php include 'assets/header.php'; ?>
        <!-- Content Wrapper. Contains page content -->
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
                     <li class="nav-item">
                      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                    </li>
                      <li class="breadcrumb-item"><a href="#">Home</a></li>
                      <li class="breadcrumb-item active">Mahasiswa</li>
                      <li class="breadcrumb-item active"><?=$u_create?></li>
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
                      <center>
                              <h1 class="m-0 text-dark">Dashboard</h1>
                              <div class="alert alert-success alert-dismissible fade show" role="alert">
                              <marquee behavior="" direction="left">
                              Selamat Datang Kembali, <strong><?=$nama?></strong>
                              </marquee>
                            </div>
                      </center>
                      <?php 
                      $cekprofil = mysqli_query($conn, "SELECT ttl, alamat_rumah, no_hp
                      FROM mahasiswa WHERE nim='$nim' AND (ttl IS NULL OR alamat_rumah IS NULL OR no_hp IS NULL)");
                      if (mysqli_num_rows($cekprofil)>0) {
                        ?>
                        <center>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h5>Anda Belum Melengkapi Data Profil</h5>
                      </div>
                </center>
                <?php }
                      ?>
                      
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
                        <div class="col-lg-3 col-6">
                          <!-- small box -->
                          <!-- bimbingan pkl -->
                          <div class="small-box bg-info pkl">
                            <div class="inner">
                            <?php $pkl1_ = mysqli_num_rows($pkl1);?>  
                            <h3><?= $pkl1_ ?></h3>
                              <p>Bimbingan Laporan PKL Baru</p>
                            </div>
                            <div class="icon">
                              <i class="fas fa-pencil-ruler"></i>
                            </div>
                            <a href="bimbinganpkl.php" class="small-box-footer">Klik disini untuk melihat <i class="fas fa-arrow-circle-right"></i></a>
                          </div>
                          <!-- bimbigan pasca sidang pkl -->
                          <div class="small-box bg-info pkl1">
                            <div class="inner">
                            <?php $pkl2_ = mysqli_num_rows($pkl2);?>  
                            <h3><?= $pkl2_ ?></h3>
                              <p>Bimbingan Pasca Sidang PKL Baru</p>
                            </div>
                            <div class="icon">
                              <i class="fas fa-pencil-ruler"></i>
                            </div>
                            <a href="pascasidang.php" class="small-box-footer">Klik disini untuk melihat <i class="fas fa-arrow-circle-right"></i></a>
                          </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                          <!-- small box -->
                          <!-- bimbingan proposal -->
                          <div class="small-box bg-success prop">
                            <div class="inner">
                            <?php $prop1_ = mysqli_num_rows($prop1);?>  
                            <h3><?= $prop1_ ?></h3>
                              <p>Bimbingan Proposal Baru</p>
                            </div>
                            <div class="icon">
                              <i class="fas fa-copy"></i>
                            </div>
                            <a href="bimbinganproposal.php" class="small-box-footer">Klik disini untuk melihat <i class="fas fa-arrow-circle-right"></i></a>
                          </div>
                          <div class="small-box bg-success prop1">
                            <div class="inner">
                            <?php $prop2_ = mysqli_num_rows($prop2);?>  
                            <h3><?= $prop2_ ?></h3>
                              <p>Bimbingan Pasca Sidang Proposal Baru</p>
                            </div>
                            <div class="icon">
                              <i class="fas fa-copy"></i>
                            </div>
                            <a href="pascaproposal.php" class="small-box-footer">Klik disini untuk melihat <i class="fas fa-arrow-circle-right"></i></a>
                          </div>
                          <!-- bimbingan pasca sidang proposal -->
                        </div>
                        <!-- ./col -->
                        <!-- bimbingan draft baru -->
                        <div class="col-lg-3 col-6">
                          <!-- small box -->
                          <div class="small-box bg-warning draft">
                            <div class="inner">
                            <?php $draft_ = mysqli_num_rows($draft);?>  
                            <h3><?= $draft_ ?></h3>
                              <p>Bimbingan Draft Baru</p>
                            </div>
                            <div class="icon">
                              <i class="ion ion-person-add"></i>
                            </div>
                            <a href="bimbingandraft.php" class="small-box-footer">Klik disini untuk melihat <i class="fas fa-arrow-circle-right"></i></a>
                          </div>
                        <!-- bimbingan pendadaran baru -->
                        <div class="small-box bg-warning pend">
                            <div class="inner">
                            <?php $pend1 = mysqli_num_rows($pend);?>  
                            <h3><?= $pend1 ?></h3>
                              <p>Bimbingan Pendadaran Baru</p>
                            </div>
                            <div class="icon">
                              <i class="ion ion-person-add"></i>
                            </div>
                            <a href="bimbinganpendadaran.php" class="small-box-footer">Klik disini untuk melihat <i class="fas fa-arrow-circle-right"></i></a>
                          </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                          <!-- small box -->
                          <div class="small-box bg-danger pend1">
                            <div class="inner">
                            <?php $pend2_ = mysqli_num_rows($pend2);?>  
                            <h3><?= $pend2_ ?></h3>
                              <p>Bimbingan Pasca Sidang Pendadaran Baru</p>
                            </div>
                            <div class="icon">
                              <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="bimbinganpendadaran.php" class="small-box-footer">Klik disini untuk melihat <i class="fas fa-arrow-circle-right"></i></a>
                          </div>
                        </div>
                        <!-- ./col -->
                      </div>
                      <!-- /.row -->
                     </div>
                    <!-- /.row -->
                    </div>
                    <!-- notif pembimbing proposal -->
                    <!-- <div class="alert alert-success alert-dismissible fade show" role="alert">
                      <strong>Dosen Pembimbing Proposal</strong> Anda Sudah Dipilih <a href="dataproposal.php">Klik Disini</a>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div> -->
                  <!-- notif pembimbing proposal -->
                  </div>
               </div>
                <!-- /.card -->
               </section>
          <!-- right col -->
            </div>
           <!-- /.row (main row) -->
         </div><!-- /.container-fluid -->
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