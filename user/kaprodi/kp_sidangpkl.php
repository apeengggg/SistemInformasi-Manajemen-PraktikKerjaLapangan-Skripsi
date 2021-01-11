<?php
session_start();
require "../../koneksi.php";
if (!isset($_SESSION["login_kaprodi"])) {
header("location:../../index.php");
exit();
}
$date = date('Y-m-d');
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Data Sidang PKL | SIM-PS | Kaprodi</title>
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
<?php include 'assets/header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <!-- data jadwal pengujian sidang -->
    <div class="row">
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
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <center>
              <h1 class="m-0 text-dark" id="jad">Jadwal Pengujian Sidang</h1><br>
            </center>
            <!-- <a href="#bim" class="btn btn-primary">Data Sidang Mahasiswa Bimbingan</a> -->
            <a href="#all" class="btn btn-primary">Data Sidang Seluruh Mahasiswa</a>
          </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead align="center">
                <tr>
                  <th width="150px">Nama</th>
                  <th width="250px">Judul</th>
                  <th width="150px">Pembimbing</th>
                  <th width="100px">Tanggal</th>
                  <th width="150px">Penguji</th>
                  <th width="100px">Ruangan</th>
                  <!-- <th>Aksi</th> -->
                </tr>
              </thead>
              <tbody>
                <?php
                        //ambi data pendaftar
                        $datasidang1 = mysqli_query($conn,
                        "SELECT 
                        pkl_sidang.id_sidpkl,
                        mahasiswa.nama,
                        pkl.judul_laporan,
                        pkl.id_dosenwali,
                        d1.nama_dosen AS pembimbing,
                        d2.nama_dosen AS penguji,
                        pkl_sidang.tgl_sid,
                        pkl_sidang.ruang_sid,
                        pkl_sidang.status_sid,
                        pkl_sidang.waktu
                        FROM pkl_sidang LEFT JOIN pkl
                        ON pkl_sidang.id_pkl=pkl.id_pkl
                        LEFT JOIN dosen_wali
                        ON pkl.id_dosenwali=dosen_wali.id_dosenwali
                        LEFT JOIN dosen d1 
                        ON dosen_wali.nidn=d1.nidn
                        LEFT JOIN dosen d2
                        ON pkl_sidang.penguji=d2.nidn
                        LEFT JOIN mahasiswa
                        ON pkl.nim=mahasiswa.nim
                        WHERE pkl_sidang.status_sid IS NULL ORDER BY tgl_sid DESC")
                        or die (mysqli_erorr($conn));
                        if (mysqli_num_rows($datasidang1) > 0) {
                        while ($data1=mysqli_fetch_array($datasidang1) ) {
                          $tanggal = $data1["tgl_sid"];
                          $tgl = date('d-M-Y', strtotime($tanggal));
                        ?>
                <!-- tampilkan data -->
                <tr>
                  <td><?php echo $data1["nama"] ?></td>
                  <td><?php echo $data1["judul_laporan"] ?></td>
                  <td><?php echo $data1["pembimbing"] ?></td>
                  <td align="center"><?php echo$tgl ?><br><?php echo $data1["waktu"] ?></td>
                  <td><?php echo $data1["penguji"] ?></td>
                  <td align="center"><?php echo $data1["ruang_sid"] ?></td>
                </tr>
                <?php  
                        }}
                        ?>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->

        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <!-- /. data jadwal pengujian sidang -->

    <!-- data semua sidang -->
    <div class="row">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-12">
              <!-- <h1 class="m-0 text-dark" id="all">Data Sidang PKL</h1> -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <center>
              <h1 class="m-0 text-dark" id="all">Data Sidang PKL</h1><br>
            </center>
            <button type="submit" class="btn btn-warning" data-toggle="modal" data-target="#modal-md"><i
                class="fas fa-print">Cetak</i></button>
            <a href="#jad" class="btn btn-primary">Data Jadwal Sidang</a>
            <!-- <a href="#bim" class="btn btn-primary">Data Sidang Mahasiswa Bimbingan</a> -->
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example5" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="80px">NIM</th>
                  <th width="200px">Nama</th>
                  <th width="200px">Judul</th>
                  <th width="200px">Pembimbing</th>
                  <!-- <th>Aksi</th> -->
                </tr>
              </thead>
              <tbody>
                <?php
                        //ambi data pendaftar
                        $datasidang3 = mysqli_query($conn,
                        "SELECT 
                        pkl_sidang.id_sidpkl,
                        mahasiswa.nama, mahasiswa.nim,
                        pkl.judul_laporan,
                        pkl.id_dosenwali,
                        d1.nama_dosen AS pembimbing,
                        d2.nama_dosen AS penguji,
                        pkl_sidang.tgl_sid,
                        pkl_sidang.ruang_sid,
                        pkl_sidang.status_sid
                        FROM pkl_sidang LEFT JOIN pkl
                        ON pkl_sidang.id_pkl=pkl.id_pkl
                        LEFT JOIN dosen_wali
                        ON pkl.id_dosenwali=dosen_wali.id_dosenwali
                        LEFT JOIN dosen d1 
                        ON dosen_wali.nidn=d1.nidn
                        LEFT JOIN dosen d2
                        ON pkl_sidang.penguji=d2.nidn
                        LEFT JOIN mahasiswa
                        ON pkl.nim=mahasiswa.nim GROUP BY mahasiswa.nama ")
                        or die (mysqli_erorr($conn));
                        if (mysqli_num_rows($datasidang3) > 0) {
                        while ($data3=mysqli_fetch_array($datasidang3) ) {
                        $nama1 = $data3["nim"];
                        $id1 = base64_encode($nama1);
                        ?>
                <!-- tampilkan data -->
                <tr>
                  <td><?php echo $data3["nim"] ?></td>
                  <td><a href="detailsidangpkl.php?id=<?= $id1 ?>"><?php echo $data3["nama"] ?></a></td>
                  <td><?php echo $data3["judul_laporan"] ?></td>
                  <td><?php echo $data3["pembimbing"] ?></td>
                </tr>
                <?php  
                        }}
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
                <h4 class="modal-title">Cetak Laporan Data Sidang Praktik Kerja Lapangan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="form-horizontal" method="post" action="assets/reportsidpkl.php">
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
                    <div class="form-group row">
                      <label for="angkatan" class="col-sm-3 col-form-label">Tanggal Sidang/Bulan</label>
                      <div class="col-sm-9">
                        <input type="date" name="tgl_awal" id="tgl_awal" class="form-control-sm">
                        -
                        <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control-sm">
                        <br>
                        <small><b>*Jika Ingin Mencetak Semua Data Sidang, Kosongkan Kolom Tanggal Sidang Pertama dan Kedua<br>
                        *Jika Ingin Mencetak Selama Satu Bulan, Isi Kolom Pertama Tanggal Sidang Pertama Pada
                        Tanggal 1 dan Isi Kolom Kedua Tanggal Sidang Kedua Pada Tanggal Terakhir (28/29/30/31) </b></small>
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
</script>
</body>

</html>