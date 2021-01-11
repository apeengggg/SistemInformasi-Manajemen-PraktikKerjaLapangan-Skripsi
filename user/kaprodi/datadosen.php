<?php
error_reporting(0);
session_start();
if (!isset($_SESSION["login_kaprodi"])) {
header("location:../../index.php");
exit();
}
require "../../koneksi.php";
$nidn = $_SESSION["nidn"];

// input data dosen 
if (isset($_POST["inputdosen"])) {
$nidnn = $_POST["nidn1"];
$nama = $_POST["nama_dosen1"];
$tipdos = $_POST["tipe_dosen1"];
$jab = $_POST["jabatan1"];
$pwd = base64_encode($nidnn);
$ceknidn = mysqli_query($conn, "SELECT * FROM dosen WHERE nidn='$nidnn'") or die (mysqli_erorr($conn));
if (mysqli_num_rows($ceknidn)===1) {
echo "<script>
alert('Cek Kembali NIDN Dosen, NIDN Sudah Terdaftar')
windows.location.href('datadosen.php')
</script>"; 
}else{
$insertsql = mysqli_query($conn, "INSERT INTO dosen
(nidn, password, nama_dosen, tipe_akun, jabatan)
VALUES
('$nidnn', '$pwd', '$nama','$tipdos', '$jab')")
or die (mysqli_erorr($conn));
if ($insertsql) {
echo "<script>
alert('Data Dosen Berhasil Ditambahkan')
windows.location.href('datadosen.php')
</script>";
}else {
echo "<script>
alert('Data Dosen Gagal Ditambahkan')
windows.location.href('datadosen.php')
</script>";
}
}
}
?>

<!-- import data -->
<?php
if (isset($_POST['importdosen'])) {
require('../../plugins/excel_reader/php-excel-reader/excel_reader2.php');
require('../../plugins/excel_reader/SpreadsheetReader.php');
$namafile = $_FILES['filedosen']['name'];
//upload data excel kedalam folder uploads
$target_dir = "../../assets/uploads/".basename($_FILES['filedosen']['name']);

move_uploaded_file($_FILES['filedosen']['tmp_name'],$target_dir);
$Reader = new SpreadsheetReader($target_dir);
foreach ($Reader as $Key => $Row)
{
// import data excel mulai baris ke-2 (karena ada header pada baris 1)
if ($Key <= 1) continue;
$cek = mysqli_query($conn, "SELECT * FROM dosen WHERE nidn='".$Row[0]."'");
$nidnx = mysqli_fetch_array($cek);
$nidnxx = $nidnx["nidn"];
if (mysqli_num_rows($cek)===1) {
echo "<script>
alert('Cek Kembali Nim, Nim <?= $nidnxx ?> Sudah Terdaftar')
windows.location.href('datadosen.php')
</script>";
}else{
$pass = base64_encode($Row[0]);
$query=mysqli_query($conn, "INSERT INTO dosen (nidn,password,nama_dosen,tipe_akun,jabatan)
VALUES ('".$Row[0]."', '$pass','".$Row[1]."','".$Row[2]."','".$Row[3]."')") or die (mysqli_erorr($conn));
}}
if ($query) {
unlink('../../assets/uploads/'.$namafile);
echo "<script>
  alert('Data Dosen Berhasil Di Import')
  windows.location.href('datadosen.php')
</script>";
}else{
echo "<script>
  alert('Data Dosen Gagal Di Import')
  windows.location.href('datadosen.php')
</script>";
}
}
?>

<!-- ubah data -->
<?php
if (isset($_POST["ubahdata"])) {
$unidn = $_POST["nidn"];
$unama = $_POST["nama_dosen"];
$upass = $_POST["password"];
$utipe = $_POST["tipe_dosen"];
$ujab = $_POST["jabatan"];
$p = base64_encode($upass);
$ubahdata = mysqli_query($conn, "UPDATE dosen SET
nidn = '$unidn',
nama_dosen = '$unama',
password = '$p',
tipe_akun = '$utipe',
jabatan = '$ujab'
WHERE nidn='$unidn'") or die (mysqli_erorr($conn));
if ($ubahdata) {
echo "<script>
alert('Data Dosen Berhasil Di Ubah')
windows.location.href('datadosen.php')
</script>";
}else {
echo "<script>
alert('Data Dosen Gagal Di Import')
windows.location.href('datadosen.php')
</script>";
}
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SIM-PS | Data Dosen | Kaprodi </title>
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
  <link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/fixedheader/3.1.7/css/fixedHeader.bootstrap.min.css">
  <link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap.min.css">
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
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <center>
              <h1 class="m-0 text-dark">Data Dosen</h1>
            </center>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example3" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>NIDN</th>
                  <th>Nama Dosen</th>
                  <th>Pangkats</th>
                  <th>Status Dosen</th>
                  <!-- <th>Aksi</th> -->
                </tr>
              </thead>
              <tbody>
                <?php
                        //ambi data bimbingan
                        $getdata = mysqli_query($conn,
                        "SELECT * FROM dosen") or die (mysqli_erorr($conn));
                        if (mysqli_num_rows($getdata) > 0) {
                        while ($data=mysqli_fetch_array($getdata)) {
                        $px = base64_decode($data["password"]);
                        ?>
                <tr>
                  <td><?= $data['nidn']?></td>
                  <td><?= $data['nama_dosen']?></td>
                  <td><?= $data['jabatan']?></td>
                  <td><?= $data['tipe_akun']?></td>
                  <!-- <td width="30px">
                            <button type="submit" id="detaildata" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-lg"
                            data-nidn="<?= $data['nidn'] ?>"
                            data-nama="<?= $data['nama_dosen'] ?>"
                            data-tipe="<?= $data['tipe_dosen'] ?>"
                            data-jabatan="<?= $data['jabatan'] ?>"
                            data-password="<?= $px ?>"
                            >Detail</button>
                          </td> -->
                </tr>
                <?php  }
                        }
                        ?>
              </tbody>
            </table>

            <!-- MODAL TAMBAH DATA MAHASISWA -->
            <div class="modal fade" id="modal-md">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Tambah Data Dosen</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form class="form-horizontal" method="post">
                      <div class="card-body">
                        <div class="form-group row">
                          <label for="subjek" class="col-sm-3 col-form-label">NIDN</label>
                          <div class="col-sm-9">
                            <input type="number" class="form-control" id="nidn1" name="nidn1" placeholder="NIDN"
                              required="required">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="subjek" class="col-sm-3 col-form-label">Nama</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_dosen1" name="nama_dosen1"
                              placeholder="Nama Lengkap, Beserta Gelar" required="required">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="subjek" class="col-sm-3 col-form-label">Pangkat</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="jabatan1" name="jabatan1"
                              placeholder="Lekor, Asisten Ahli, ..." required="required">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="subjek" class="col-sm-3 col-form-label">Tipe Dosen</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="tipe_dosen1" id="tipe_dosen1" required="required">
                              <option disabled selected>Pilih Tipe Dosen</option>
                              <option value="Dosen">Dosen</option>
                              <option value="PenasihatAkademik">Penasihat Akademik</option>
                              <option value="Kaprodi">Kaprodi</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <!-- /.card-body -->
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="inputdosen"
                      id="inputdosen">Kirim</button>
                  </div>
                </div>
                </form>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
            <!-- /.MODAL TAMBAH DATA MAHASISWA -->

            <!-- MODAL IMPORT DATA MAHASISWA -->
            <div class="modal fade" id="modal-md1">
              <div class="modal-dialog modal-md1">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Import Data Dosen</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form class="form-horizontal" method="post" enctype="multipart/form-data">
                      <div class="card-body">
                        <div class="form-group row">
                          <label for="subjek" class="col-sm-3 col-form-label">File</label>
                          <div class="col-sm-9">
                            <input type="file" id="filedosen" name="filedosen" required="required">
                            <small id="emailHelp" class="form-text text-muted">Pastikan format file anda .xls / .xlsx /
                              .csv </small>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="subjek" class="col-sm-5 col-form-label">Format Excel</label>
                          <div class="col-sm-2">
                            <a href="assets/downloadtemplatedosen.php">Unduh</a>
                          </div>
                        </div>
                      </div>
                      <!-- /.card-body -->
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="importdosen"
                      id="importdosen">Kirim</button>
                  </div>
                </div>
                </form>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
            <!-- /.MODAL IMPORT DATA MAHASISWA -->

            <!-- MODAL TAMBAH DATA MAHASISWA -->
            <div class="modal fade" id="modal-lg">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Ubah/Detail Data Dosen</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form class="form-horizontal" method="post">
                      <div class="card-body">
                        <div class="form-group row">
                          <label for="nidn" class="col-sm-3 col-form-label">NIDN</label>
                          <div class="col-sm-9">
                            <input type="number" class="form-control" id="nidn" name="nidn" placeholder="NIDN"
                              required="required">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="nama_dosen" class="col-sm-3 col-form-label">Nama</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_dosen" name="nama_dosen"
                              required="required">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="subjek" class="col-sm-3 col-form-label">Pangkat</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="jabatan" name="jabatan"
                              placeholder="Lekor, Asisten Ahli, ..." required="required">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="password" class="col-sm-3 col-form-label">Password</label>
                          <div class="col-sm-9">
                            <input type="password" class="form-control" id="password1" name="password"
                              required="required">
                            <input type="checkbox" class="form-check-label"> Show Password
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="subjek" class="col-sm-3 col-form-label">Tipe Dosen</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="tipe_dosen" id="tipe_dosen" required="required">
                              <option disabled selected>Pilih Tipe Dosen</option>
                              <option value="dosen">Dosen</option>
                              <option value="pa">Penasihat Akademik</option>
                              <option value="kaprodi">Kaprodi</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <!-- /.card-body -->
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="ubahdata"
                      id="ubahdata">Ubah Data</button>
                  </div>
                </div>
                </form>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
            <!-- /.MODAL TAMBAH DATA MAHASISWA -->
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
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="../../plugins/datatables/jquery.dataTables.js"></script>
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
  $(document).on("click", "#detaildata", function () {
    let nidn = $(this).data('nidn');
    let nama = $(this).data('nama');
    let password = $(this).data('password');
    let tipe = $(this).data('tipe');
    let jab = $(this).data('jabatan');

    $(".modal-body #nidn").val(nidn);
    $(".modal-body #nama_dosen").val(nama);
    $(".modal-body #password1").val(password);
    $(".modal-body #tipe_dosen").val(tipe);
    $(".modal-body #jabatan").val(jab);
  });

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