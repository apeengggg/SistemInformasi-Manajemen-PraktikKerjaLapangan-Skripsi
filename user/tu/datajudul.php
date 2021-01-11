<?php
session_start();
if (!isset($_SESSION["login_tu"])) {
header("location:../../index.php");
exit();
}
require "../../koneksi.php";
$nidn = $_SESSION["nidn"];

// // ambil data bimbingan mahasiswa
// $getbim = mysqli_query($conn, "SELECT * FROM bimpkl WHERE nidn='$nidn'") or die (mysqli_erorr($conn));
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Data Judul | SIM-PS | Tata Usaha</title>
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
          <!-- <h1 class="m-0 text-dark">Daftar Judul Mahasiswa</h1> -->
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
              <h1 class="m-0 text-dark">Daftar Judul Mahasiswa</h1><br>
            </center>
            <button type="submit" class="btn btn-warning" data-toggle="modal" data-target="#modal-md"><i
                class="fas fa-print"></i> Cetak Laporan</button>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead align="center">
                <tr>
                  <th width="50px">NIM</th>
                  <th width="200px">Nama</th>
                  <th width="50px">Tanggal</th>
                  <th width="250px">Judul Skripsi</th>
                  <th width="200px">Pengajuan</th>
                  <th width="50px">Tujuan</th>
                  <th width="75px">Status</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                            //ambi data bimbingan
                            $getdata = mysqli_query($conn, 
                              "SELECT mahasiswa.nim,
                                      mahasiswa.nama,
                                      judul.judul,
                                      judul.status_judul, 
                                      judul.tanggal_pengajuan,
                                      dosen.tipe_akun, dosen.nama_dosen FROM
                                      judul LEFT JOIN mahasiswa
                                      ON judul.nim=mahasiswa.nim
                                      LEFT JOIN dosen
                                      ON judul.tujuan=dosen.nidn WHERE judul.status_judul='Disetujui' OR judul.status_judul='Ditolak'") 
                            or die (mysqli_erorr($conn));
                            if (mysqli_num_rows($getdata) > 0) {
                            while ($data=mysqli_fetch_array($getdata)) {
                            ?>
                <tr>
                  <td><?= $data["nim"]?></td>
                  <td><?= $data["nama"]?></td>
                  <td><?= $data["tanggal_pengajuan"]?></td>
                  <td><?= $data["judul"]?></td>
                  <td><?= $data["nama_dosen"]?></td>
                  <td>
                    <center><?= $data["tipe_akun"]?></center>
                  </td>
                  <td align="center">
                    <!-- ubah tulisan -->
                    <?php 
                                if ($data["status_judul"]=="Menunggu") {
                                ?>
                    <span class="badge badge-primary">
                      <?php } else if ($data["status_judul"]=="Ditolak"){
                                ?>
                      <span class="badge badge-danger">
                        <?php }else if($data["status_judul"]=="Disetujui") {
                                ?>
                        <span class="badge badge-success">
                          <?php } ?>
                          <?= $data["status_judul"] ?></span></td>
                </tr>
                <?php }
                            }
                            ?>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- modal cetak laporan -->
        <div class="modal fade" id="modal-md">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Cetak Laporan Judul Skripsi Mahasiswa</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="form-horizontal" method="post" action="assets/reportjudul.php">
                  <div class="card-body">
                    <div class="form-group row">
                      <label for="angkatan" class="col-sm-3 col-form-label">Tahun Angkatan</label>
                      <div class="col-sm-9">
                        <select class="form-control" name="angkatan" id="angkatan" required="required">
                          <option value="">Pilih Angkatan...</option>
                          <?php
                                    //ambil data dosen
                                    $sql = mysqli_query($conn, "SELECT angkatan FROM mahasiswa GROUP BY angkatan") or die (mysqli_erorr($conn));
                                    while ($dosen1 = mysqli_fetch_array($sql)) {
                                    ?>
                          <option value="<?=$dosen1["angkatan"]?>"><?=$dosen1["angkatan"]?>
                          </option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="jadwalkan"
                  id="jadwalkan">Cetak</button>
              </div>
            </div>
            </form>
          </div>
        </div>
        <!-- modal cetak laporan -->
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
</script>
</body>

</html>