<?php
session_start();
require "../../koneksi.php";
if (!isset($_SESSION["login_pa"])) {
header("location:../../index.php");
exit();
}
$nidn = $_SESSION["nidn"];
$u_create = $_SESSION["nama"];
$action = "update";
$set = mysqli_query($conn, "SET @action ='$action', @user = '$u_create'");
//ambil data user
$get = mysqli_query($conn, "SELECT * FROM dosen WHERE nidn='$nidn'") or die (mysqli_error($conn));
if ( mysqli_num_rows($get) == 0) {
echo "
<script>
alert('Tidak Ditemukan Data Dalam Database!')
</script>";
exit();
}else{
$data = mysqli_fetch_array($get);
}

//ubah data
if (isset($_POST["ubahdata"])) {
$fotolama = $data["foto_dosen"];
$nidn = $_POST["nidn"];
$nama = $_POST["nama"];
$foto = $_FILES["foto"]["name"];
// var_dump($_FILES); die;
if (empty($foto)) {
$edit = mysqli_query($conn, "UPDATE dosen SET
nidn='$nidn',
nama_dosen='$nama'
WHERE nidn='$nidn'") or die (mysqli_error($edit));
if ($edit) {
echo "<script>
alert('Data Berhasil Di Ubahhhhhhhhhhhh!')
window.location.href('profile.php')
</script>";
}else{
echo "<script>
alert('Data Gagal Di Ubah!')
window.location.href('profile.php')
</script>";
}  
}else {
  $ekstensi = array("jpg", "jpeg", "JPG", "png");
$ambil_ekstensi = explode(".", $foto);
$eks = $ambil_ekstensi[1];
if (in_array($eks, $ekstensi)) {
$dot = "-";
$fotobaru = date('dmYHis').$dot.$foto;
$pathfoto = "../../assets/foto/".$fotobaru;
$tmp_foto = $_FILES["foto"]["tmp_name"];
if (move_uploaded_file($tmp_foto, $pathfoto)) {
    if ($fotolama != 'profil.png') {
unlink('../../assets/foto/'.$fotolama);
}
$edit1 = mysqli_query($conn, "UPDATE dosen SET
nidn='$nidn',
nama_dosen='$nama',
foto_dosen='$fotobaru'
WHERE nidn='$nidn'") or die (mysqli_error($edit1));
if ($edit1) {
echo "<script>
alert('Data Berhasil Di Ubah!')
window.location.href('profile.php')
</script>";
}else{
echo "<script>
alert('Data Gagal Di Ubah!')
window.location.href('profile.php')
</script>";      
    }
  }
}
}
}

if (isset($_POST["ubahpassword"])) {
$password_lama = $data["password"];
// var_dump($_POST); 
// var_dump($password_lama);
$password = $_POST["password"];
$p2 = base64_encode($password);
// var_dump($p2); die;
$password_baru = $_POST["password_baru"];
$ulangi = $_POST["password1"];
$p3 = base64_encode($ulangi);
if ($password_lama != $p2) {
 echo "<script>
alert('Password Lama Tidak Sama!')
window.location.href('profile.php')
</script>"; 
}else {
  if ($password_baru != $ulangi) {
   echo "<script>
alert('Password Baru Tidak Sama!')
window.location.href('profile.php')
</script>"; 
  }else {
    $ubahpassword=mysqli_query($conn, "UPDATE dosen SET password='$p3' WHERE nidn='$nidn'") or die (mysqli_erorr($conn));
    if ($ubahpassword) {
      echo "<script>
alert('Password Telah Diubah!')
window.location.href('profile.php')
</script>"; 
    }else {
      echo "<script>
alert('Password Gagal diubah!')
window.location.href('profile.php')
</script>"; 
    }
  }
}
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIM-PS | Data Profil | Penasihat Akademik</title>
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
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
              </li>
            </ul>
            <!-- <h1 class="m-0 text-dark">Data Pendaftaran Sidang PKL</h1> -->
            </div><!-- /.col -->
            </div><!-- /.row -->
            </div><!-- /.container-fluid -->
          </section>
            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content">
            <div class="card-header"></div>
              <!-- /.row -->
              <!-- Main row -->
              <div class="row">
                <!-- Left col -->
                <section class="col-lg-12">
                  <div class="card card-info">
                    <div class="card-header">
                    <center><h2>Data Profil</h2></center>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal" method="post" enctype="multipart/form-data">
                      <div class="card-body">
                        <div class="form-group row">
                          <div class="col-sm-10">
                          <center>
                          <img src="../../assets/foto/<?= $data["foto_dosen"] ?>" alt=""
                          width="140px" height="150px">
                        </center>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="nidn" class="col-sm-2 col-form-label">NIDN</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="nidn" id="nidn" placeholder="nim" value="<?php echo $data["nidn"] ?>" readonly>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $data["nama_dosen"]?>" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="foto" class="col-sm-2 col-form-label">Foto</label>
                          <div class="col-sm-10">
                            <input type="file" id="foto" name="foto">
                          </div>
                        </div>
                      </div>
                      <!-- /.card-body -->
                      <div class="card-footer">
                        <button type="submit" class="btn btn-info" name="ubahdata" id="ubahdata">Ubah Data</button>
                      </div>
                      <!-- /.card-footer -->
                    </form>
                  </div>
                </section>
                <section class="col-lg-12">
                <form class="form-horizontal" method="post">
                    <div class="card card-info">
                    <div class="card-header">
                      <center><h2>Akun</h2></center>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal" method="post">
                      <div class="card-body">
                        <div class="form-group row">
                          <label for="password" class="col-sm-4 col-form-label">Password</label>
                          <div class="col-sm-5">
                            <?php $p = base64_decode($data["password"]);?>
                            <input type="password" class="form-control" name="password" id="password" placeholder="password" value="<?=$p?>">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="password" class="col-sm-4 col-form-label">Password Baru</label>
                          <div class="col-sm-5">
                            <input type="password" class="form-control" id="password_baru" placeholder="password_baru" name="password_baru">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="password" class="col-sm-4 col-form-label">Ulangi Password Baru</label>
                          <div class="col-sm-5">
                            <input type="password" class="form-control" id="password1" placeholder="password1" name="password1">
                            <input type="checkbox" class="form-check-label"> Show Password
                          </div>
                        </div>
                      </div>
                      <div class="card-footer">
                        <button type="submit" class="btn btn-info" name="ubahpassword" id="ubahpassword">Ubah Password</button>
                      </div>
                    <!-- /.card-body -->
                  </form>
                </div>
              </section>
              <!-- right col -->
            </div>
            <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
          </section>
          <!-- /.content -->
        </div>
        </div>
        <!-- /.content-wrapper -->
       
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
          <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
      </div>
      <!-- <?php include 'assets/footer.php'; ?> -->
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

      <script>
        // cek show password
        $(document).ready(function(){
        $('.form-check-label').click(function(){
        if($(this).is(':checked')){
        $('#password').attr('type','text');
        $('#password_baru').attr('type','text');
        $('#password1').attr('type','text');
        }else{
        $('#password').attr('type','password');
        $('#password_baru').attr('type','password');
        $('#password1').attr('type','password');
        }
        });
        });
      </script>
    </body>
  </html>