<?php
error_reporting(0);
session_start();
require 'koneksi.php';

// cek apakah masih ada session login untuk setiap user
if (isset($_SESSION["login"])) {
  header("location:user/mahasiswa/index.php");
} else if (isset($_SESSION["login_tu"])) {
  header("location:user/tu/index.php");
} else if (isset($_SESSION["login_kaprodi"])) {
  header("location:user/kaprodi/index.php");
} else if (isset($_SESSION["login_pa"])) {
  header("location:user/pa/index.php");
} else if (isset($_SESSION["login_dosen"])) {
  header("location:user/dosen/index.php");
}

// cek apakah tombol login sudah dipencet
if (isset($_POST["login"])) {
  $nim = $_POST["nim"];
  $password = $_POST["password"];
  $tu = "TataUsaha";
  $kaprodi = "Kaprodi";
  $pa = "PenasihatAkademik";
  $dosen = "Dosen";
  $decode = base64_encode($password);
  // login mahasiswa
  $sql_mhs = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE nim='$nim' AND password='$decode'") or die(mysqli_error($sql_mhs));
  // login tata usaha
  $sql_tu = mysqli_query($conn, "SELECT * FROM tata_usaha WHERE nidn='$nim' AND password='$decode'");
  // login kaprodi
  $sql_kaprodi = mysqli_query($conn, "SELECT * FROM dosen WHERE nidn='$nim' AND password='$decode' AND tipe_akun='$kaprodi'");
  // login penasihat akademik
  $sql_pa = mysqli_query($conn, "SELECT * FROM dosen WHERE nidn='$nim' AND password='$decode' AND tipe_akun='$pa'");
  // login dosbing atau penguji
  $sql_dosen = mysqli_query($conn, "SELECT * FROM dosen WHERE nidn='$nim' AND password='$decode' AND tipe_akun='$dosen'");

  // ambil data session user mahasiswa
  if (mysqli_num_rows($sql_mhs) > 0) {
    $row_mahasiswa = mysqli_fetch_array($sql_mhs);
    $_SESSION["login_mhs"] = true;
    $_SESSION["id_akun"] = $row_mahasiswa["id_akun"];
    $_SESSION["nim"] = $row_mahasiswa["nim"];
    $_SESSION["nama"] = $row_mahasiswa["nama"];
    $_SESSION["foto"] = $row_mahasiswa["foto"];
    $_SESSION["status_pkl"] = $row_mahasiswa["status_pkl"];
    $_SESSION["status_proposal"] = $row_mahasiswa["status_proposal"];
    $_SESSION["status_draft"] = $row_mahasiswa["status_draft"];
    $_SESSION["status_pendadaran"] = $row_mahasiswa["status_pendadaran"];
    $_SESSION["status"] = $row_mahasiswa["status_mhs"];
    $namax = $_SESSION["nama"];
	  $userr = mysqli_query($conn, "SET @user = '$namax'");
    header("location:user/mahasiswa/index.php");
    // ambil data session user tata usaha
  } else if (mysqli_num_rows($sql_tu) > 0) {
    $row_tu = mysqli_fetch_array($sql_tu);
    $_SESSION["login_tu"] = true;
    $_SESSION["id_akun"] = $row_tu["id_akun"];
    $_SESSION["nidn"] = $row_tu["nidn"];
    $_SESSION["nama"] = $row_tu["nama"];
    $namax = $_SESSION["nama"];
	  $userr = mysqli_query($conn, "SET @user = '$namax'");
    header("location:user/tu/index.php");
    // ambil data session user kaprodi
  } else if (mysqli_num_rows($sql_kaprodi) > 0) {
    $row_kaprodi = mysqli_fetch_array($sql_kaprodi);
    $_SESSION["login_kaprodi"] = true;
    // $_SESSION["login_dosen"] = true;
    $_SESSION["id_akun"] = $row_tu["id_akun"];
    $_SESSION["nidn"] = $row_kaprodi["nidn"];
    $_SESSION["nama_dosen"] = $row_kaprodi["nama_dosen"];
    $_SESSION["nama"] = $row_kaprodi["nama"];
    $namax = $_SESSION["nama"];
	  $userr = mysqli_query($conn, "SET @user = '$namax'");
    header("location:user/kaprodi/index.php");
    // ambil data session user penasihat akademik
  } else if (mysqli_num_rows($sql_pa) > 0) {
    $row_pa = mysqli_fetch_array($sql_pa);
    $_SESSION["login_pa"] = true;
    // $_SESSION["login_dosen"] = true;
    $_SESSION["id_akun"] = $row_tu["id_akun"];
    $_SESSION["nidn"] = $row_pa["nidn"];
    $_SESSION["nama_dosen"] = $row_pa["nama_dosen"];
    $_SESSION["nama"] = $row_pa["nama"];
    $namax = $_SESSION["nama"];
	$userr = mysqli_query($conn, "SET @user = '$namax'");
    header("location:user/pa/index.php");
    // ambil data session user dosbing atau penguji
  } else if (mysqli_num_rows($sql_dosen) > 0) {
    $row_dosen = mysqli_fetch_array($sql_dosen);
    $_SESSION["login_dosen"] = true;
    $_SESSION["id_akun"] = $row_tu["id_akun"];
    $_SESSION["nidn"] = $row_dosen["nidn"];
    $_SESSION["nama_dosen"] = $row_dosen["nama_dosen"];
    $_SESSION["nama"] = $row_dosen["nama"];
    $namax = $_SESSION["nama"];
	  $userr = mysqli_query($conn, "SET @user = '$namax'");
    header("location:user/dosen/index.php");
  } else {
    echo "<script>
    alert('USERNAME ATAU PASSWORD SALAHq')
    windows.location.href='index.php'
    </script>";
  }
}
?>



<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SIM-PS | Log In</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SIM-PS | Login</title>
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
<div class="jumbotron">
  <center>
    <img src="logo.png" alt="" width="100px" height="100px">
    <h3 class="display-5">Sistem Informasi Manajemen Praktik Kerja Lapangan dan Skripsi</h3>
    <p class="lead">Sistem Informasi Manajemen Praktik Kerja Lapangan dan Skripsi <b>(SIM-PS)</b> merupakan sistem
      informasi pengelolaan praktik kerja lapangan dan skripsi.
      Dimana pada sistem ini mahasiswa dapat melakukan bimbingan laporan atau skripsi dengan dosen pembimbing,
      pengajuan judul skripsi ke penasihat akademik atau dosen, pendaftaran sidang, dan pengumpulan atau pencarian
      laporan praktik kerja lapangan
      dan skripsi.</p>
    <hr class="my-4">
    <p>Untuk mengakses sistem ini silahkan login terlebih dahulu</p>
    <p class="lead">
      <button class="btn btn-primary" data-toggle="modal" data-target="#modal">Masuk</button>
  </center>
  <!-- <a class="btn btn-primary btn-lg" href="#" role="button">Masuk</a> -->
  </p>
</div>

<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Silahkan Masuk Terlebih Dahulu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="username" name="nim" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="password" id="password1" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <input type="checkbox" class="form-check-label"> Show Password

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary" name="login">Masuk</button>
      </div>
    </div>
  </div>
</div>
</form>
<!-- /.row (main row) -->
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
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script>
  // cek show password
  $(document).ready(function () {
    $('.form-check-label').click(function () {
      if ($(this).is(':checked')) {
        $('#password1').attr('type', 'text');
      } else {
        $('#password1').attr('type', 'password');
      }
    });
  });

</script>
</body>

</html>
