<?php
session_start();
require "../../koneksi.php";
if (!isset($_SESSION["login_dosen"])) {
  if (!isset($_SESSION["login_kaprodi"])){
    if (!isset($_SESSION["login_pa"])) {
      header("location:../../index.php");
      exit();
    }
  }
}
$nidn=$_SESSION["nidn"];
$date = date('Y-m-d');

if (isset($_POST["nilai1"])) {
  $id = $_POST["id"];
  // var_dump($id); die;
  $npm1 = $_POST["npm1"];
  $npm2 = $_POST["npm2"];
  $sis = $_POST["sistematika"];
  $hasil = $_POST["hasilsidang"];
  $send = mysqli_query($conn, "UPDATE pkl_nilai SET peng_pen_mat='$npm2', peng_peng_mat='$npm2', 
  peng_sis='$sis' WHERE id_sidang='$id'");
  $sql = mysqli_query($conn, "UPDATE pkl_sidang SET status_sid='$hasil' WHERE id_sidpkl='$id'");
  if ($send && $sql) {
    echo "<script>
    alert('Nilai Berhasil Diinput !')
    windows.location.href='p_sidangpkl.php'
    </script>";
  }else {
    echo "<script>
    alert('Nilai gagal diinput !')
    windows.location.href='p_sidangpkl.php'
    </script>";
  }
}

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Data Sidang PKL | SIM-PS | Dosen</title>
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
<?php 
if (isset($_SESSION["login_kaprodi"])) {
  include '../kaprodi/assets/header.php';
}elseif (isset($_SESSION["login_pa"])) {
  include '../pa/assets/header.php';
}elseif (isset($_SESSION["login_dosen"])) {
  include 'assets/header.php';
} ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
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
  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <center>
              <h1 class="m-0 text-dark" id="jad">Jadwal Pengujian Sidang</h1><br>
            </center>
            <!-- <a href="#bim" class="btn btn-primary">Data Sidang Mahasiswa Bimbingan</a>
<a href="#all" class="btn btn-primary">Data Sidang Seluruh Mahasiswa</a> -->
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
                  <th>Nilai</th>
                </tr>
              </thead>
              <tbody>
                <?php
//ambi data pendaftar
$datasidang2 = mysqli_query($conn,
"SELECT 
mahasiswa.nama,
pkl.judul_laporan,
pkl.id_dosenwali,
d1.nama_dosen AS pembimbing,
d2.nama_dosen AS penguji,
pkl_sidang.tgl_sid,
pkl_sidang.ruang_sid,
pkl_sidang.status_sid,
pkl_sidang.waktu, pkl_sidang.id_sidpkl AS id,
pkl_nilai.peng_pen_mat AS p1, pkl_nilai.peng_peng_mat AS p2,
pkl_nilai.peng_sis AS sis
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
LEFT JOIN pkl_nilai
ON pkl_sidang.id_sidpkl=pkl_nilai.id_sidang
WHERE pkl_sidang.penguji='$nidn' AND pkl_sidang.status_sid IS NULL
ORDER BY pkl_sidang.tgl_sid DESC")
or die (mysqli_erorr($conn));
if (mysqli_num_rows($datasidang2) > 0) {
  while ($data2=mysqli_fetch_array($datasidang2) ) {
    $tanggal = $data2["tgl_sid"];
    $tgl = date('d-M-Y', strtotime($tanggal));
    ?>
                <!-- tampilkan data -->
                <tr>
                  <td><?= $data2["nama"] ?></td>
                  <td><?= $data2["judul_laporan"] ?></td>
                  <td><?= $data2["pembimbing"] ?></td>
                  <td align="center"><?= $tgl ?><br><?= $data2["waktu"] ?></td>
                  <td><?= $data2["penguji"] ?></td>
                  <td align="center"><?= $data2["ruang_sid"] ?></td>
                  <td>
                    <?php
    $id = $data2["id"];
    $sql = mysqli_query($conn, "SELECT * FROM pkl_nilai WHERE id_sidang='$id' AND 
    peng_pen_mat IS NULL AND peng_peng_mat IS NULL AND peng_sis IS NULL");
    $q = mysqli_num_rows($sql);
    if ($q>0) {
      ?>
                    <button class="btn-xs btn-dark" data-toggle="modal" data-target="#modalnilai" id="nilai"
                      data-id="<?php echo $data2["id"] ?>">
                      <i class="fas fa-file"></i></button>
                    <?php }else{?>
                    <button class="btn-xs btn-danger" data-toggle="modal" data-target="#modalnilai1" id="nilai1"
                      data-id="<?php echo $data2["id"] ?>" data-p1="<?php echo $data2["p1"] ?>"
                      data-p2="<?php echo $data2["p2"] ?>" data-sis="<?php echo $data2["sis"] ?>"
                      data-status="<?php echo $data2["status_sid"] ?>">
                      <i class="fas fa-info-circle"></i></button>
                    <?php } ?>
                  </td>
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
  </section>
  <!-- /.content -->

  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <center>
              <h1 class="m-0 text-dark" id="jad">Riwayat Pengujian Sidang</h1><br>
            </center>
            <button type="submit" class="btn btn-warning" data-toggle="modal" data-target="#modal-md"><i
                class="fas fa-print"> Cetak</i></button>
            <!-- <a href="#bim" class="btn btn-primary">Data Sidang Mahasiswa Bimbingan</a>
      <a href="#all" class="btn btn-primary">Data Sidang Seluruh Mahasiswa</a> -->
          </div>
          <div class="card-body">
            <table id="example3" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="150px">Nama</th>
                  <th width="250px">Judul</th>
                  <th width="150px">Pembimbing</th>
                  <th width="75px">Tanggal</th>
                  <th width="50px">Waktu</th>
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
      pkl_sidang.id_sidpkl AS id,
      mahasiswa.nama, mahasiswa.nim,
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
      WHERE pkl_sidang.penguji='$nidn'")
      or die (mysqli_erorr($conn));
      if (mysqli_num_rows($datasidang1) > 0) {
        while ($data1=mysqli_fetch_array($datasidang1) ) {
          $nim = $data1["nim"];
          $id = base64_encode($nim);
          ?>
                <!-- tampilkan data -->
                <tr>
                  <td><a href="detailsidangpkl.php?id=<?=$id?>"><?php echo $data1["nama"] ?></a></td>
                  <td><?php echo $data1["judul_laporan"] ?></td>
                  <td><?php echo $data1["pembimbing"] ?></td>
                  <td><?php echo $data1["tgl_sid"] ?></td>
                  <td><?php echo $data1["waktu"] ?></td>
                  <td><?php echo $data1["penguji"] ?></td>
                  <td><?php echo $data1["ruang_sid"] ?></td>
                  <!-- <td><button class="btn-xs btn-dark" data-toggle="modal" data-target="#modalnilai"
          id="nilai"
          data-id="<?php echo $data1["id"] ?>">
          <i class="fas fa-file"></i></button></td> -->
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
</div>
</section>
<!-- /.content -->
<!-- /. data riwayat sidang -->
</div>

<!-- modal tambah bimbingan -->
<div class="modal fade" id="modalnilai">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Form Nilai Sidang PKL</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="post">
          <div class="card-body">
            <div class="form-row">
              <input type="text" class="form-control" id="id" name="id">
            </div>
            <div class="form-row">
              <label for="npm1">Nilai Penyampaian Materi</label>
              <input type="number" class="form-control" id="npm1" name="npm1" max="100" min="0" required>
            </div>
            <div class="form-row">
              <label for="npm2">Nilai Penguasaan Materi</label>
              <input type="number" class="form-control" id="npm2" name="npm2" max="100" min="0" required>
            </div>
            <div class="form-row">
              <label for="sistematika">Nilai Sistematika Penulisan</label>
              <input type="number" class="form-control" id="sistematika" name="sistematika" max="100" min="0" required>
            </div>
            <div class="form-row">
              <label for="hasilsidang">Hasil Sidang</label>
              <select name="hasilsidang" id="hasilsidang" class="form-control">
                <option value="">Pilih Hasil Sidang..</option>
                <option value="Lulus">Lulus</option>
                <option value="Tidak Lulus">Tidak Lulus</option>
              </select>
            </div>
            <!-- /.card-body -->
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="nilai1" id="nilai1">Kirim</button>
          </div>
        </form>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
  </div>
</div>
<!-- /.modal -->
<!-- modal tambah bimbingan -->

<!-- modal tambah bimbingan -->
<div class="modal fade" id="modalnilai1">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Nilai Sidang PKL</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="post">
          <div class="card-body">
            <div class="form-row">
              <input type="text" class="form-control" id="id" name="id">
            </div>
            <div class="form-row">
              <label for="npm1">Nilai Penyampaian Materi</label>
              <input type="number" class="form-control" id="npm1" name="npm1" max="100" min="0" readonly>
            </div>
            <div class="form-row">
              <label for="npm2">Nilai Penguasaan Materi</label>
              <input type="number" class="form-control" id="npm2" name="npm2" max="100" min="0" readonly>
            </div>
            <div class="form-row">
              <label for="sistematika">Nilai Sistematika Penulisan</label>
              <input type="number" class="form-control" id="sistematika" name="sistematika" max="100" min="0" readonly>
            </div>
            <div class="form-row">
              <label for="hasilsidang">Hasil Sidang</label>
              <input type="text" class="form-control" id="hasilsidang" name="hasilsidang" readonly>
              <!-- /.card-body -->
            </div>
        </form>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
  </div>
</div>
</div>
<!-- /.modal -->
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

<!-- /.content-wrapper -->
<!-- <?php include 'assets/footer.php'; ?> -->
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

  /// detail data
  $(document).on("click", "#nilai", function () {
    let d = $(this).data('id');
    $("#modalnilai #id").val(d);
  });

  /// detail data
  $(document).on("click", "#nilai1", function () {
    let d = $(this).data('id');
    let p1 = $(this).data('p1');
    let p2 = $(this).data('p2');
    let sis = $(this).data('sis');
    let hasil = $(this).data('status');
    $("#modalnilai1 #id").val(d);
    $("#modalnilai1 #npm1").val(p1);
    $("#modalnilai1 #npm2").val(p2);
    $("#modalnilai1 #sistematika").val(sis);
    $("#modalnilai1 #hasilsidang").val(hasil);
  });
</script>
</body>

</html>