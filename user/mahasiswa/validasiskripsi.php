<?php
session_start();
require "../../koneksi.php";
if (!isset($_SESSION["login_mhs"])) {
header("location:../../index.php");
exit();
}
$nimm = $_SESSION["nim"];
$nim = $_SESSION["nim"];
$tanggal = date('Y-m-d');
$waktu = date('H-i-s');

// insert
if (isset($_POST["unggah"])) {
// var_dump($waktu); die;
$ekstensi = array("pdf");
$file = $_FILES["file"]["name"];
$ukuran = $_FILES["file"]["size"];
$ambil_ekstensi = explode(".", $file);
$eks = $ambil_ekstensi[1];
$newfile = $nim.'-'.$namefile.'-'.$file;
$pathlemrev= '../../assets/persyaratan_skripsi/'.$newfile;
$cekstatusx1 = mysqli_query($conn, "SELECT * FROM skripsi_syarat WHERE nim='$nim' AND 
(status='2' OR status='0')");
if (mysqli_num_rows($cekstatusx1)>0) {
  echo "<script>
  alert('ANDA SUDAH MEMPUNYAI DATA VALIDASI YANG DISETUJUI ATAU BELUM DIVALIDASI, TIDAK DAPAT MENGUNGGAH PERSYARATAN VALIDASI LAGI')
  windows.location.href='validasiskripsi.php'
  </script>"; 
}else{
if (in_array($eks, $ekstensi)) {
  if ($ukuran > 250000) {
    echo "<script>
alert('Maximal File Size 250 KB')
windows.location.href='validasiskripsi.php'
</script>"; 
  }else{
$file_tmp = $_FILES["file"]["tmp_name"];
if (move_uploaded_file($file_tmp, $pathlemrev)) {
$insertlem = mysqli_query($conn, "INSERT INTO skripsi_syarat 
                                  (file, nim) 
                                  VALUES ('$newfile', '$nim')") or die (mysqli_erorr($conn)); 
if ($insertlem) {
echo "<script>
alert('Berhasil Mengunggah File Persyaratan, Tunggu Tata Usaha Untuk Memvalidasi!')
windows.location.href='validasiskripsi.php'
</script>";     
   }else {
     echo "<script>
alert('Gagal Mengunggah File Persyaratan, Tunggu Tata Usaha Untuk Memvalidasi!')
windows.location.href='validasiskripsi.php'
</script>";
   }    
}else {
  echo "<script>
alert('Gagal Mengunggah File Persyaratan, Tunggu Tata Usaha Untuk Memvalidasi!')
windows.location.href='validasiskripsi.php'
</script>";
}
  }
  }else{
      echo "<script>
alert('File yang diupload bukan PDF !!')
windows.location.href='validasiskripsi.php'
</script>";
  }  
}
}

// ubah file
if (isset($_POST["ubah"])) {
$id=$_POST["id"];
$file_lama = $_POST["nama"];
$ekstensi = array("pdf");
$file = $_FILES["file"]["name"];
$ukuran = $_FILES["file"]["size"];
// var_dump($_FILES); die;
$ambil_ekstensi = explode(".", $file);
$eks = $ambil_ekstensi[1];
$newfile =  $nim.'-'.$namefile.'-'.$file;
$pathlemrev= '../../assets/persyaratan_skripsi/'.$newfile;
$cekstatusx = mysqli_query($conn, "SELECT status FROM skripsi_syarat WHERE id_syarat='$id'");
$a = mysqli_fetch_array($cekstatusx);
$b = $a["status"];
// var_dump($a); die;
// print_r($a);
if ($b === '1' || $b === '2') {
  echo "<script>
  alert('Persyaratan Anda Sudah Divalidasi Oleh Tata Usaha, Jika Persyaratan Di Tolak Silahkan Unggah Ulang Persyaratan yang baru')
  windows.location.href='validasiskripsi.php'
  </script>"; 
}else{
if (in_array($eks, $ekstensi)) {
  if ($ukuran > 250000) {
    echo "<script>
alert('Maximal FIle size 250 KB')
windows.location.href='validasiskripsi.php'
</script>";     
  }else {
$file_tmp = $_FILES["file"]["tmp_name"];
unlink('../../assets/persyaratan_skripsi/'.$file_lama);
if (move_uploaded_file($file_tmp, $pathlemrev)) {
$insertlem = mysqli_query($conn, "UPDATE skripsi_syarat 
                                  SET file='$newfile' 
                                  WHERE id_syarat='$id'") or die (mysqli_erorr($conn)); 
if ($insertlem) {
echo "<script>
alert('Berhasil Mengubah Persyaratan!')
windows.location.href='validasiskripsi.php'
</script>";     
   }else {
     echo "<script>
alert('Gagal Mengubah File Persyaratan!')
windows.location.href='validasiskripsi.php'
</script>";
   }    
}else {
  echo "<script>
alert('Gagal Mengunggah File Persyaratan!')
windows.location.href='validasiskripsi.php'
</script>";
}
  }
}else{
      echo "<script>
alert('File yang diupload bukan PDF !!')
windows.location.href='validasiskripsi.php'
</script>";
  }  
}
}


?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Validasi Persyaratan Skripsi | SIM-PS | Mahasiswa</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/fixedheader/3.1.7/css/fixedHeader.bootstrap.min.css">
  <link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap.min.css">
</head>
<style>
  thead {
    background-color: #292929;
    color: #FFFFFF;
  }
</style>
<?php include 'assets/header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
          </ul>
          <!-- <h1 class="m-0 text-dark">Data File Skripsi</h1> -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <center>
              <h3 class="m-0 text-dark">Validasi Persyaratan Skripsi</h3>
            </center>
          </div>
          <div class="card-header">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-lg">
              Unggah
            </button>
            <br><br>
            <h5>
              <p>Persyaratan:</p>
              <p>1. KHS*</p>
              <p>2. Sertifikat KKM*</p>
              <b>
                <p>*Satukan Semua Persyaratan Dalam File PDF</p>
              </b>
            </h5>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <!-- cek file ta sudah diunggah belum -->
            <?php 
                    $cekfile1=mysqli_query($conn, 
                    "SELECT * FROM skripsi_syarat INNER JOIN mahasiswa ON skripsi_syarat.nim=mahasiswa.nim
                    WHERE skripsi_syarat.nim='$nim'");
                        if (mysqli_num_rows($cekfile1)>0) {
                          ?>
            <table id="example1" class="table table-bordered table-striped">
              <thead align="center">
                <tr>
                  <th width="110px">Tanggal</th>
                  <th width="80px">File Persyaratan</th>
                  <th width="100px">Hasil Validasi</th>
                  <th width="80px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                        //ambi data bimbingan
                        $getdata = mysqli_query($conn,
                        "SELECT * FROM skripsi_syarat INNER JOIN mahasiswa ON skripsi_syarat.nim=mahasiswa.nim
                        WHERE skripsi_syarat.nim='$nim'")
                        or die (mysqli_erorr($conn));
                        if (mysqli_num_rows($getdata) > 0) {
                        while ($data=mysqli_fetch_array($getdata)) {
                        $tanggal = $data["tanggal"];
                        $tgl = date('d-M-Y', strtotime($tanggal));
                        ?>
                <tr>
                  <td><?= $tgl  ?></td>
                  <td align="center"><a href="assets/downsyaratskripsi.php?filename=<?= $data["file"] ?>"
                      class="btn btn-info" target="_blank"><i class="fas fa-download"></i></a></td>
                  <td align="center">
                    <?php
                            if ($data["status"]=="0") {
                            ?>
                    <span class="badge badge-primary">
                      <?php echo 'Menunggu' ?>
                      <?php } else if ($data["status"]=="2"){
                              ?>
                      <span class="badge badge-success">
                        <?php echo 'Disetujui' ?>
                        <?php }else if ($data["status"]=="1"){
                                ?>
                        <span class="badge badge-danger">
                          <?php echo 'Ditolak' ?>
                          <?php } ?></span></td>
                  <td align="center">
                    <button type="submit" class="btn-sm btn-dark" name="detail" data-toggle="modal"
                      data-target="#modal-lg1" id="detailbim" data-id="<?php echo $data["id_syarat"]?>"
                      data-nama="<?php echo $data["file"]?>">
                      <i class="fas fa-edit"></i></button>
                  </td>
                </tr>
                <?php
                                        }
                                        }
                                        ?>
              </tbody>
            </table>
            <?php } ?>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->

  <!-- modal tambah bimbingan -->
  <div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Form Unggah Persyaratan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="card-body">
              <div class="form-group row">
                <label for="file" class="col-sm-3 col-form-label">File Persyaratan</label>
                <div class="col-sm-9">
                  <input type="file" id="file" name="file" required="required">
                  <small id="emailHelp" class="form-text text-muted">File Persyaratan Harus Ber-Ekstensi PDF, Max Size
                    250 KB</small>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="unggah" id="unggah">Unggah</button>
        </div>
      </div>
      </form>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  <!-- modal tambah bimbingan -->

  <!-- modal detail bimbingan -->
  <div class="modal fade" id="modal-lg1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <style>
            .modal-header {
              background-color: #292929;
              color: #FFFFFF;
            }
          </style>
          <h5 class="modal-title" id="exampleModalLabel">Form Ubah Persyaratan</h5>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- form body modal -->
          <form action="" method="post" enctype="multipart/form-data">
            <div class="form-row">
              <div class="form-group col-md-12">
                <input type="text" class="form-control" id="id" name="id" hidden>
              </div>
              <div class="form-group col-md-12">
                <input type="text" class="form-control" id="nama" name="nama" hidden>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="file">File Persyaratan Baru:</label>
                <input type="file" name="file" id="file" required>
                <small id="emailHelp" class="form-text text-muted">File Persyaratan Harus Ber-Ekstensi PDF, Max Size 250
                  KB</small>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="ubah" id="ubah">Ubah</button>
            </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- /. modal detail bimbingan -->
<!-- /.modal detail bimbingan -->
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
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="../../plugins/datatables/jquery.dataTables.js"></script>
<!-- swwet alert -->
<script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- data tables -->
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- page script -->
<script src="https://cdn.datatables.net/fixedheader/3.1.7/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.6/js/responsive.bootstrap.min.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
    var table = $('#example1').DataTable({
      responsive: true
    });
  });
  $(document).ready(function () {
    var table = $('#example3').DataTable({
      responsive: true
    });
  });
  $(document).ready(function () {
    var table = $('#example5').DataTable({
      responsive: true
    });
  });
  // detail data
  $(document).on("click", "#detailbim", function () {
    let id = $(this).data('id');
    let nama = $(this).data('nama');
    $("#modal-lg1 #file").attr("href", "../../assets/skripsi/" + nama);
    $("#modal-lg1 #nama").val(nama);
    $("#modal-lg1 #id").val(id);
  });
</script>
</body>

</html>