<?php
session_start();
require "../../koneksi.php";
if (!isset($_SESSION["login_tu"])) {
header("location:../../index.php");
exit();
}
$date = date('Y-m-d');

if (isset($_POST["ubah"])) {
  $id = $_POST["id"];
  $hasil = $_POST["hasilsidang"];
  $p1 = $_POST["npm1"]; 
  $p11 = $_POST["npm11"];
  $sis1 = $_POST["sistematika"];
  $p2 = $_POST["npm2"];
  $p22 = $_POST["npm22"];
  $sis2 = $_POST["sistematika1"];
  if ($hasil == 'Lulus') {
    $ustatus = mysqli_query($conn, "UPDATE mahasiswa
                LEFT JOIN pkl ON mahasiswa.nim=pkl.nim
                LEFT JOIN pkl_sidang ps ON pkl.id_pkl=ps.id_pkl
                SET mahasiswa.status_pkl='Lulus'
                WHERE ps.id_sidpkl='$id'");
  $sql = mysqli_query($conn, "UPDATE pkl_nilai SET pem_pen_mat='$p11', pem_peng_mat='$p22',
                      pem_sis='$sis2', peng_pen_mat='$p1', peng_peng_mat='$p2', peng_sis='$sis1'
                      WHERE id_sidang='$id'");
  $sql2 = mysqli_query($conn, "UPDATE pkl_sidang SET status_sid='$hasil' WHERE id_sidpkl='$id'");
  if ($sql && $sql2 && $ustatus) {
echo "<script>
alert('Nilai Berhasil Di input')
windows.location.href('sidangpkl.php')
</script>";
  }else {
    echo "<script>
alert('Nilai Gagal Di input')
windows.location.href('sidangpkl.php')
</script>";
  }
}else{
  $sql4 = mysqli_query($conn, "UPDATE pkl_sidang SET status_sid='$hasil' WHERE id_sidpkl='$id'");
  if ($sql4) {
echo "<script>
alert('Hasil Sidang Berhasil Diubah')
windows.location.href('sidangpkl.php')
</script>";
  }else {
    echo "<script>
alert('Hasil Sidang Gagal Diubah')
windows.location.href('sidangpkl.php')
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
  <title>Data Sidang PKL | SIM-PS | Tata Usaha</title>
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
    <!-- data sidang mahasiswa bimbingan -->
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
              <h1 class="m-0 text-dark">Data Jadwal Sidang PKL</h1><br>
            </center>
            <a href="assets/jadwalsidang.php" target="_blank" class="btn btn-success">
              <i class="fas fa-file-export"></i> Export Jadwal
            </a>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead align="center">
                <tr>
                  <th width="70px">NIM</th>
                  <th width="180px">Nama</th>
                  <th width="150px">Judul</th>
                  <th width="120px">Waktu</th>
                  <th width="80px">Ruangan</th>
                  <th width="200px">Penguji</th>
                  <th width="50px">Nilai</th>
                </tr>
              </thead>
              <tbody>
                <?php
                        //ambi data pendaftar
                        $datasidang3 = mysqli_query($conn,
                        "SELECT DISTINCT
                        pkl_sidang.id_sidpkl,
                        mahasiswa.nim,
                        mahasiswa.nama,
                        pkl.judul_laporan,
                        pkl.id_dosenwali,
                        d1.nama_dosen AS pembimbing,
                        d2.nama_dosen AS penguji,
                        pkl_sidang.tgl_sid,
                        pkl_sidang.ruang_sid,
                        pkl_sidang.waktu,
                        pkl_sidang.status_sid,
                        pkl_sidang.id_sidpkl AS id,
                        pn.pem_pen_mat AS p1, pn.pem_peng_mat AS p11, pn.pem_sis AS sis1,
                        pn.peng_pen_mat AS p2, pn.peng_peng_mat AS p22, pn.peng_sis AS sis2
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
                        LEFT JOIN pkl_nilai pn
                        ON pkl_sidang.id_sidpkl=pn.id_sidang
                        WHERE pkl_sidang.status_sid IS NULL AND pkl_sidang.tgl_sid IS NOT NULL
                        AND val_dosbing='2'")
                        or die (mysqli_erorr($conn));
                        if (mysqli_num_rows($datasidang3) > 0) {
                        while ($data3=mysqli_fetch_array($datasidang3) ) {
                        $nama = $data3["nama"];
                        $id = base64_encode($nama);
                        $tanggal = $data3["tgl_sid"];
                        $tgl = date('d-M-Y', strtotime($tanggal));
                        ?>
                <!-- tampilkan data -->
                <tr>
                  <td><?= $data3["nim"] ?></td>
                  <td><?= $data3["nama"] ?></td>
                  <td><?= $data3["judul_laporan"] ?></td>
                  <td align="center"><?= $tgl ?><br><?= $data3["waktu"] ?></td>
                  <td align="center"><?= $data3["ruang_sid"] ?></td>
                  <td><?= $data3["penguji"] ?></td>
                  <td align="center"><button class="btn-xs btn-dark" id="nilai1" data-toggle="modal"
                      data-target="#modalnilai1" data-id="<?= $data3["id"] ?>" data-p1="<?= $data3["p1"] ?>"
                      data-p11="<?= $data3["p11"] ?>" data-sis1="<?= $data3["sis1"] ?>" data-p2="<?= $data3["p2"] ?>"
                      data-p22="<?= $data3["p22"] ?>" data-sis2="<?= $data3["sis2"] ?>"
                      data-hasil="<?= $data3["status_sid"] ?>">
                      <i class="fas fa-edit"></i></button></td>
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

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <!-- <h1 class="m-0 text-dark">Data Sidang PKL</h1> -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <center>
            <h1 class="m-0 text-dark">Data Sidang PKL</h1><br>
          </center>
          <button type="submit" class="btn btn-warning" data-toggle="modal" data-target="#modal-md"><i
              class="fas fa-print"></i> Cetak</button>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example5" class="table table-bordered table-striped">
            <thead align="center">
              <tr>
                <th width="80px">NIM</th>
                <th width="200px">Nama</th>
                <th width="200px">Judul</th>
                <!-- <th width="200px">Penguji</th> -->
                <!-- <th width="50px">Aksi</th> -->
              </tr>
            </thead>
            <tbody>
              <?php
                        //ambi data pendaftar
                        $datasidang2 = mysqli_query($conn,
                        "SELECT 
                        pkl_sidang.id_sidpkl,
                        mahasiswa.nama, mahasiswa.nim,
                        pkl.judul_laporan,
                        pkl.id_dosenwali,
                        d1.nama_dosen AS pembimbing,
                        d2.nama_dosen AS penguji,
                        pkl_sidang.tgl_sid,
                        pkl_sidang.ruang_sid,
                        pkl_sidang.status_sid,
                        pkl_sidang.id_sidpkl AS id
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
                        GROUP BY mahasiswa.nama")
                        or die (mysqli_erorr($conn));
                        if (mysqli_num_rows($datasidang2) > 0) {
                        while ($data2=mysqli_fetch_array($datasidang2) ) {
                        $nama = $data2["nim"];
                        $id = base64_encode($nama);
                        ?>
              <!-- tampilkan data -->
              <tr>
                <td><?= $data2["nim"] ?></td>
                <td><a href="detailsidangpkl.php?id=<?= $id ?>"><?= $data2["nama"] ?></a></td>
                <td><?= $data2["judul_laporan"] ?></td>
                <!-- <td><?= $data2["penguji"] ?></td> -->
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
<!-- /. data sidang mahasiswa bimbingan -->
</section>
<!-- /.content -->

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

<!-- modal tambah bimbingan -->
<div class="modal fade" id="modalnilai1">
  <div class="modal-dialog modal-lg">
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
              <input type="text" class="form-control" id="id" name="id" hidden>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="npm1">Nilai Penyampaian Materi Penguji</label>
                <input type="number" class="form-control" id="npm1" name="npm1" max="100" min="0">
              </div>
              <div class="form-group col-md-6">
                <label for="npm11">Nilai Penyampaian Materi Pembimbing</label>
                <input type="number" class="form-control" id="npm11" name="npm11" max="100" min="0">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="npm2">Nilai Penguasaan Penguji</label>
                <input type="number" class="form-control" id="npm2" name="npm2" max="100" min="0">
              </div>
              <div class="form-group col-md-6">
                <label for="npm22">Nilai Penguasaan Materi Pembimbing</label>
                <input type="number" class="form-control" id="npm22" name="npm22" max="100" min="0">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="sistematika">Nilai Sistematika Penulisan Penguji</label>
                <input type="number" class="form-control" id="sistematika" name="sistematika" max="100" min="0">
              </div>
              <div class="form-group col-md-6">
                <label for="sistematika1">Nilai Sitematika Penulisan Pembimbing</label>
                <input type="number" class="form-control" id="sistematika1" name="sistematika1" max="100" min="0">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="hasilsidang">Hasil Sidang</label>
                <select name="hasilsidang" id="hasilsidang" class="form-control" required>
                  <option value="">Pilih Hasil Sidang...</option>
                  <option value="Lulus">Lulus</option>
                  <option value="Tidak Lulus">Tidak Lulus</option>
                </select>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="ubah" id="ubah">Ubah</button>
            </div>
            <!-- /.card-body -->
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

  // detail data
  $(document).on("click", "#detaildata", function () {
    let id = $(this).data('id');
    $(".modal-body #id").val(id);
  });

  /// detail data
  $(document).on("click", "#nilai1", function () {
    let d = $(this).data('id');
    let p1 = $(this).data('p1');
    let p2 = $(this).data('p2');
    let p11 = $(this).data('p11');
    let p22 = $(this).data('p22');
    let sis2 = $(this).data('sis2');
    let sis1 = $(this).data('sis1');
    let hasil = $(this).data('status');
    let total = $(this).data('total');
    let grade = $(this).data('grade');
    $("#modalnilai1 #id").val(d);
    $("#modalnilai1 #npm1").val(p2);
    $("#modalnilai1 #npm2").val(p22);
    $("#modalnilai1 #npm11").val(p1);
    $("#modalnilai1 #npm22").val(p11);
    $("#modalnilai1 #sistematika").val(sis2);
    $("#modalnilai1 #sistematika1").val(sis1);
    $("#modalnilai1 #hasilsidang").val(hasil);
    $("#modalnilai1 #total").val(total);
    $("#modalnilai1 #grade").val(grade);
  });
</script>
</body>

</html>