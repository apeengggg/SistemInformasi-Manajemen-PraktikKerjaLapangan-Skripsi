<?php
session_start();
require "../../koneksi.php";
if (!isset($_SESSION["login_mhs"])) {
header("location:../../index.php");
exit();
}
$nim = $_SESSION["nim"];
$cek1 = mysqli_query($conn, "SELECT * FROM proposal p LEFT JOIN judul j ON p.id_judul=j.id_judul LEFT JOIN mahasiswa m ON j.nim=m.nim LEFT JOIN dosen ON p.dosbing=dosen.nidn WHERE m.nim='$nim' AND j.status_judul='Disetujui'");
$d =mysqli_fetch_array($cek1);
if (isset($_POST["ajukan"])) {
  $cek1 = mysqli_query($conn, "SELECT * FROM proposal p LEFT JOIN judul j ON p.id_judul=j.id_judul LEFT JOIN mahasiswa m ON j.nim=m.nim LEFT JOIN dosen ON p.dosbing=dosen.nidn WHERE m.nim='$nim' AND j.status_judul='Disetujui'");
$d =mysqli_fetch_array($cek1);
$id_prop = $d["id_proposal"];
$id = $id_prop;
$sql = mysqli_query($conn, "INSERT INTO skripsi (id_proposal) VALUES ('$id')");
if ($sql) {
echo "<script>
alert('Berhasil melakukan Permohonan')
windows.location.href('datadraft.php')
</script>";
}else {
echo "<script>
alert('Gagal melakukan Permohonan')
windows.location.href('datadraft.php')
</script>";
}
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Data Skripsi | SIM-PS | Mahasiswa</title>
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
          <!-- <h1 class="m-0 text-dark">Data Judul Skripsi Mahasiswa</h1> -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <?php
          $cekjudul = mysqli_query($conn, "SELECT * FROM judul WHERE nim='$nim' AND status_judul='Disetujui'");
          if (mysqli_num_rows($cekjudul)<1) {
          ?>
  <div class="alert alert-danger" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <b>Anda Belum Memiliki Judul Skripsi Atau Judul Yang Anda Ajukan Belum Disetujui, Silahkan Ajukan Judul Terlebih
      Dahulu</b>
  </div>
  <?php }else{
          ?>
  <section class="content">
    <div class="row">
      <?php
            $cekdosbing = mysqli_query($conn, "SELECT * FROM skripsi_dosbing sd INNER JOIN skripsi s 
            ON sd.id_skripsi=s.id_skripsi INNER JOIN proposal p ON s.id_proposal=p.id_proposal
            INNER JOIN judul ON p.id_judul=judul.id_judul INNER JOIN mahasiswa m
            ON judul.nim=m.nim WHERE m.nim='$nim'");
            if (mysqli_num_rows($cekdosbing)<1) {
            ?>
      <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <b>Dosen Pembimbing Anda Belum Divalidasi, Silahkan Hubungi Kaprodi atau Penasihat Akademik</b>
      </div>
      <?php }else{
            ?>
      <!-- kolom penguji sidang -->
      <?php
              $getpenguji = mysqli_query($conn,
              "SELECT d1.foto_dosen, skripsi_dosbing.nidn, d1.nama_dosen AS pem
              FROM skripsi_dosbing
              LEFT JOIN dosen d1
              ON skripsi_dosbing.nidn=d1.nidn
              LEFT JOIN skripsi
              ON skripsi_dosbing.id_skripsi=skripsi.id_skripsi
              LEFT JOIN proposal
              ON skripsi.id_proposal=proposal.id_proposal
              LEFT JOIN judul
              ON proposal.id_judul=judul.id_judul
              LEFT JOIN mahasiswa
              ON judul.nim=mahasiswa.nim
              WHERE mahasiswa.nim='$nim' AND judul.status_judul='Disetujui' AND skripsi_dosbing.status='Aktif'
              ORDER BY status_dosbing ASC");
              $no=1;
              while ($datapenguji = mysqli_fetch_array($getpenguji)) {
              ?>
      <style>
        .card-header {
          background-color: #292929;
          color: #FFFFFF;
        }
      </style>
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <center>
              <h4>Pembimbing <?= $no++ ?></h4>
            </center>
          </div>
          <div class="card-body">
            <table align="center">
              <tr>
                <td colspan="3" align="center">
                  <img src="../../assets/foto/<?= $datapenguji["foto_dosen"]?>" width="140px" height="150px" alt="">
                </td>
              </tr>
              <tr>
              <td colspan="3"><hr></td>
              </tr>
              <tr>
                <td><h5>NIDN</h5></td>
                <td><h5>:</h5></td>
                <td><h5><?= $datapenguji["nidn"] ?></h5></td>
              </tr>
              <tr>
              <td colspan="3"><hr></td>
              </tr>
              <tr>
                <td><h5>Nama</h5></td>
                <td><h5>:</h5></td>
                <td><h5><?= $datapenguji["pem"] ?></h5></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>
    <!-- /.row -->
    <?php } ?>

    <!-- data skripsi mahasiswa -->
    <?php
            $getdata = mysqli_query($conn,
            "SELECT mhs.nama, mhs.nim, mhs.foto, judul.judul, judul.studi_kasus
            FROM mahasiswa mhs
            LEFT JOIN judul
            ON mhs.nim=judul.nim
            WHERE mhs.nim='$nim' AND judul.status_judul='Disetujui'");
            $data= mysqli_fetch_array($getdata);
            ?>
    <center>
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <center>
              <h4>Data Skripsi</h4>
            </center>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="card-body">
              <table align="center">
                <tr>
                  <td colspan="3" align="center">
                    <img src="../../assets/foto/<?= $data["foto"]?>" width="140px" height="150px" alt="">
                  </td>
                </tr>
                <tr>
              <td colspan="3"><hr></td>
              </tr>
                <tr>
                  <td align="left"><h5>NIM</h5></td>
                  <td align="left"><h5>:</h5></td>
                  <td><h5><?= $data["nim"] ?></h5></td>
                </tr>
                <tr>
              <td colspan="3"><hr></td>
              </tr>
                <tr>
                  <td align="left"><h5>Nama</h5></td>
                  <td align="left"><h5>:</h5></td>
                  <td><h5><?= $data["nama"] ?></h5></td>
                </tr>
                <tr>
              <td colspan="3"><hr></td>
              </tr>
                <tr>
                  <td align="left"><h5>Judul Skripsi</h5></td>
                  <td align="left"><h5>:</h5></td>
                  <td><h5><?= $data["judul"] ?></h5></td>
                </tr>
                <tr>
              <td colspan="3"><hr></td>
              </tr>
                <tr>
                  <td align="left"><h5>Studi Kasus</h5></td>
                  <td align="left"><h5>:</h5></td>
                  <td><h5><?= $data["studi_kasus"] ?></h5></td>
                </tr>
              </table>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
</div>
<!-- /.row -->
</center>
</section>
<!-- tutup else -->
<!-- modal ubah -->
<div class="modal fade" id="modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-tittle">Permohonan Pengajuan Dosbing 1 dan 2</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" class="form-horizontal">
          <div class="card-body">
            <div class="form-group row">
              <div class="col-sm-9">
                <input type="text" class="form-control" id="id" name="id" readonly hidden>
              </div>
            </div>
            <div class="form-group row">
              <label for="judul" class="col-sm-3 co-form-label">Judul</label>
              <div class="col-sm-12">
                <textarea class="form-control" rows="3" id="judul" name="judul" readonly></textarea>
              </div>
            </div>
            <div class="form-group row">
              <label for="sk" class="col-sm-3 co-form-label">Studi Kasus</label>
              <div class="col-sm-12">
                <input type="text" class="form-control" id="sk" name="sk" placeholder="Studi Kasus Skripsi"
                  required="required" readonly>
              </div>
            </div>
            <div class="form-group row">
              <label for="pem" class="col-sm-3 co-form-label">Pembimbing Proposal</label>
              <div class="col-sm-12">
                <input type="text" class="form-control" id="pem" name="pem" placeholder="Judul Skripsi" readonly="">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="ajukan" id="ajukan">Ajukan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- /. modal ubah -->
<!-- /.content -->
<?php } ?>
</div>
<!-- /.content-wrappeclude-- Control Sidebar -->
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
<!-- AdminLTE for emo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- page scrip
    t -->
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
  // detail data mhs
  $(document).on("click", "#ajukan", function () {
    let id = $(this).data('id');
    let judul = $(this).data('judul');
    let sk = $(this).data('sk');
    let pem = $(this).data('pem');
    $(".modal-body #id").val(id);
    $(".modal-body #judul").val(judul);
    $(".modal-body #sk").val(sk);
    $(".modal-body #pem").val(pem);
  });
</script>
</body>

</html>