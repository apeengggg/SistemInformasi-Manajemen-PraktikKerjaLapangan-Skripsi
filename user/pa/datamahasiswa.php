<?php
session_start();
if (!isset($_SESSION["login_pa"])) {
header("location:../../index.php");
exit();
}
require "../../koneksi.php";
$nidn = $_SESSION["nidn"];
//  input mahasiswa manual
if (isset($_POST["inputmhs"])) {
$nim = $_POST["nim1"];
$nama = $_POST["nama1"];
$prodi = $_POST["prodi1"];
$angkatan = $_POST["angkatan1"];
$pass = base64_encode($nim);
$tipe = "Mahasiswa";
$ceknim = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE nim='$nim'") or die (mysqli_erorr($conn));
if (mysqli_num_rows($ceknim)===1) {
echo "<script>
alert('Cek Kembali Nim, Nim Sudah Terdaftar')
windows.location.href('datamahasiswa.php')
</script>";
}else{
$insertakun = mysqli_query($conn, "INSERT INTO mahasiswa (nim, nama, password, prodi, angkatan) VALUES ('$nim', '$nama', '$pass', '$prodi', '$angkatan') ");
if ($insertakun) {
echo "<script>
alert('Data Mahasiswa Berhasil Ditambahkan')
windows.location.href('datamahasiswa.php')
</script>"; 
}
}
}

?>
<!-- import data excel -->
<?php
if (isset($_POST['importmhs'])) {
require('../../plugins/excel_reader/php-excel-reader/excel_reader2.php');
require('../../plugins/excel_reader/SpreadsheetReader.php');
$namafile = $_FILES['filemhs']['name'];
//upload data excel kedalam folder uploads
$target_dir = "../../assets/uploads/".basename($_FILES['filemhs']['name']);
move_uploaded_file($_FILES['filemhs']['tmp_name'],$target_dir);
$Reader = new SpreadsheetReader($target_dir);
foreach ($Reader as $Key => $Row)
{
// import data excel mulai baris ke-2 (karena ada header pada baris 1)
if ($Key <= 1) continue;
$cek = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE nim='".$Row[0]."'");
if (mysqli_num_rows($cek)===1) {
echo "<script>
alert('Cek Kembali Nim, Nim Sudah Terdaftar')
windows.location.href('datamahasiswa.php')
</script>";
}else{
$pwd = base64_encode($Row[0]);
$query = mysqli_query($conn, "INSERT INTO mahasiswa (nim,password,nama,prodi,angkatan) VALUES ('".$Row[0]."', '$pwd','".$Row[1]."','".$Row[2]."','".$Row[3]."')") or die (mysqli_erorr($conn));
}}
if ($query) {
unlink('../../assets/uploads/'.$namafile);
echo "<script>
alert('Data Mahasiswa Berhasil Di Import')
windows.location.href('datamahasiswa.php')
</script>";
}else{
echo "<script>
alert('Data Mahasiswa Gagal Di Import')
windows.location.href('datamahasiswa.php')
</script>";
}
}
?>

<!-- ubah data -->
<?php
if (isset($_POST["ubahdata"])) {
$unim = $_POST["nim"];
$unama = $_POST["nama"];
$upass = $_POST["password"];
$ualamat = $_POST["alamat_rumah"];
$uprodi = $_POST["prodi"];
$uhp = $_POST["no_hp"];
$uttl = $_POST["ttl"];
$uakun = $_POST["status_mhs"];
$upkl = $_POST["status_pkl"];
$uprop = $_POST["status_proposal"];
$uskripsi = $_POST["status_skripsi"];
$p = base64_encode($upass);
$ubahdata = mysqli_query($conn, 
"UPDATE mahasiswa SET
nim = '$unim',
nama = '$unama',
password = '$p',
alamat_rumah = '$ualamat',
prodi = '$uprodi',
no_hp = '$uhp',
ttl = '$uttl',
status_mhs = '$uakun',
status_pkl = '$upkl',
status_proposal = '$uprop',
status_skripsi = '$uskripsi'
WHERE nim='$unim'") or die (mysqli_erorr($conn));
if ($ubahdata) {
echo "<script>
alert('Data Mahasiswa Berhasil Di Ubah')
windows.location.href('datamahasiswa.php')
</script>";
}else {
echo "<script>
alert('Data Mahasiswa Gagal Di Import')
windows.location.href('datamahasiswa.php')
</script>";
}
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SIM-PS | Data Mahasiswa | Penasihat Akademik </title>
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
              <h1 class="m-0 text-dark">Data Mahasiswa</h1><br>
            </center>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example3" class="table table-bordered table-striped">
              <thead align="center">
                <tr>
                  <th>NIM</th>
                  <th>Nama</th>
                  <th>Angkatan</th>
                  <th>Status Mahasiswa</th>
                  <th>PKL</th>
                  <th>Proposal</th>
                  <th>Skripsi</th>
                  <!-- <th>Aksi</th> -->
                </tr>
              </thead>
              <tbody>
                <?php
                        $getdata = mysqli_query($conn,
                        "SELECT * FROM mahasiswa ORDER BY nim DESC") or die (mysqli_erorr($conn));
                        if (mysqli_num_rows($getdata) > 0) {
                        while ($data=mysqli_fetch_array($getdata)) {
                        $pas = base64_decode($data["password"]);
                        ?>
                <tr>
                  <td><?php echo $data['nim']?></td>
                  <td><?php echo $data['nama']?></td>
                  <td><?php echo $data['angkatan']?></td>
                  <td><?php echo $data['status_mhs']?></td>
                  <td><?php echo $data['status_pkl']?></td>
                  <td><?php echo $data['status_proposal']?></td>
                  <td><?php echo $data['status_skripsi']?></td>
                  <!-- <td width="30px">
                            <button type="submit" id="detaildata" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-xl"
                            data-nim="<?= $data['nim']; ?>"
                            data-nama="<?= $data['nama']; ?>"
                            data-password="<?= $pas ?>"
                            data-foto="<?= $data['foto']; ?>"
                            data-alamat="<?= $data['alamat_rumah']; ?>"
                            data-hp="<?= $data['no_hp']; ?>"
                            data-prodi="<?= $data['prodi']; ?>"
                            data-ttl="<?= $data['ttl']; ?>"
                            data-akun="<?= $data['status_mhs']; ?>"
                            data-pkl="<?= $data['status_pkl']; ?>"
                            data-proposal="<?= $data['status_proposal']; ?>"
                            data-skripsi="<?= $data['status_skripsi']; ?>"
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
                    <h4 class="modal-title">Tambah Data Mahasiswa</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form class="form-horizontal" method="post">
                      <div class="card-body">
                        <div class="form-group row">
                          <label for="subjek" class="col-sm-3 col-form-label">NIM</label>
                          <div class="col-sm-9">
                            <input type="number" class="form-control" id="nim1" name="nim1" placeholder="NIM"
                              required="required">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="subjek" class="col-sm-3 col-form-label">Nama</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama1" name="nama1" placeholder="Nama Lengkap"
                              required="required">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="subjek" class="col-sm-3 col-form-label">Prodi</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="prodi1" name="prodi1"
                              placeholder="Program Studi" required="required">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="angkatan" class="col-sm-3 col-form-label">Angkatan</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="angkatan1" name="angkatan1"
                              placeholder="Tahun Angkatan" required="required">
                          </div>
                        </div>
                      </div>
                      <!-- /.card-body -->
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="inputmhs"
                      id="inputmhs">Kirim</button>
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
                    <h4 class="modal-title">Import Data Mahasiswa</h4>
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
                            <input type="file" id="filemhs" name="filemhs" required="required">
                            <small id="emailHelp" class="form-text text-muted">Pastikan format file anda .xls / .xlsx /
                              .csv </small>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="subjek" class="col-sm-5 col-form-label">Format Excel</label>
                          <div class="col-sm-2">
                            <a href="assets/downloadtemplatemhs.php">Unduh</a>
                          </div>
                        </div>
                      </div>
                      <!-- /.card-body -->
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="importmhs"
                      id="importmhs">Kirim</button>
                  </div>
                </div>
                </form>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
            <!-- /.MODAL IMPORT DATA MAHASISWA -->

            <!-- MODAL DETAIL MAHASISWA -->
            <div class="modal fade" id="modal-xl" role="dialog">
              <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="modal-xlLabel">Detail Data Mahasiswa</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <!-- form body modal -->
                    <form action="" method="post">
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label for="nim">NIM</label>
                          <input type="nim" class="form-control" id="nim" name="nim">
                        </div>
                        <div class="form-group col-md-4">
                          <label for="nama">Nama</label>
                          <input type="text" class="form-control" id="nama" name="nama">
                        </div>
                        <div class="form-group col-md-4">
                          <label for="password">Password</label>
                          <input type="password" class="form-control" id="password1" name="password" maxlength="16">
                          <input type="checkbox" class="form-check-label"> Show Password
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="alamat_rumah">Alamat Rumah</label>
                        <input type="text" class="form-control" id="alamat_rumah" name="alamat_rumah">
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label for="prodi">Prodi</label>
                          <input type="prodi" class="form-control" id="prodi" name="prodi">
                        </div>
                        <div class="form-group col-md-4">
                          <label for="no_hp">No HP</label>
                          <input type="text" class="form-control" id="no_hp" name="no_hp">
                        </div>
                        <div class="form-group col-md-4">
                          <label for="ttl">Tempat, Tanggal Lahir</label>
                          <input type="text" class="form-control" id="ttl" name="ttl">
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-3">
                          <label for="status_mhs">Status Akun</label>
                          <select id="status_mhs" class="form-control" name="status_mhs">
                            <option value="-">Pilih..</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                          </select>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="status_pkl">Status PKL</label>
                          <select id="status_pkl" class="form-control" name="status_pkl">
                            <option value="-">Pilih...</option>
                            <option value="Lulus">Lulus</option>
                          </select>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="status_proposal">Status Proposal</label>
                          <select id="status_proposal" class="form-control" name="status_proposal">
                            <option value="-">Pilih...</option>
                            <option value="Lulus">Lulus</option>
                          </select>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="status_skripsi">Status Skripsi</label>
                          <select id="status_skripsi" class="form-control" name="status_skripsi">
                            <option value="-">Pilih...</option>
                            <option value="Lulus">Lulus</option>
                          </select>
                        </div>
                      </div>
                      <!-- /.card-body -->
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
              <!-- /.MODAL DETAIL MAHASISWA -->

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
    let nim = $(this).data('nim');
    let nama = $(this).data('nama');
    let password = $(this).data('password');
    let prodi = $(this).data('prodi');
    let alamat = $(this).data('alamat');
    let hp = $(this).data('hp');
    let ttl = $(this).data('ttl');
    let akun = $(this).data('akun');
    let pkl = $(this).data('pkl');
    let proposal = $(this).data('proposal');
    let skripsi = $(this).data('skripsi');
    $(".modal-body #nim").val(nim);
    $(".modal-body #nama").val(nama);
    $(".modal-body #password1").val(password);
    $(".modal-body #prodi").val(prodi);
    $(".modal-body #alamat_rumah").val(alamat);
    $(".modal-body #no_hp").val(hp);
    $(".modal-body #ttl").val(ttl);
    $(".modal-body #status_mhs").val(akun);
    $(".modal-body #status_pkl").val(pkl);
    $(".modal-body #status_proposal").val(proposal);
    $(".modal-body #status_skripsi").val(skripsi);
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