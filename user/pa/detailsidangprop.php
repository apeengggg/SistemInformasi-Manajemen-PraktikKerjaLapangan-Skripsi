<?php
session_start();

require "../../koneksi.php";
$nidn = $_SESSION["nidn"];

// ambil id BImbingan di get
if (isset($_GET["id"])) {
  $decode = base64_decode($_GET["id"]);
}
//ambi data bimbingan
$getdataa = mysqli_query($conn,
"SELECT DISTINCT mhs.nama, mhs.nim, mhs.foto,
judul.judul,
d1.nama_dosen AS pembimbing,
ps.tgl_sidang AS tgl,
ps.waktu_sidang AS waktu,
ps.ruang_sidang AS ruang, ps.id_sidang,
-- ambil data penguji1
(SELECT d1.nama_dosen FROM dosen d1 INNER JOIN proposal_penguji pp
ON d1.nidn=pp.penguji 
WHERE pp.id_sidang=ps.id_sidang LIMIT 0,1) AS penguji1, 
-- ambil data penguji2
(SELECT d2.nama_dosen FROM dosen d2 INNER JOIN proposal_penguji pp
ON d2.nidn=pp.penguji 
WHERE pp.id_sidang=ps.id_sidang LIMIT 1,1) as penguji2,
ps.status_sidang AS status
FROM proposaL_sidang ps 
LEFT JOIN proposal
ON ps.id_proposal=proposal.id_proposal
LEFT JOIN dosen d1
ON d1.nidn=proposal.dosbing
LEFT JOIN judul 
ON proposal.id_judul=judul.id_judul
LEFT JOIN mahasiswa mhs
ON judul.nim=mhs.nim
LEFT JOIN proposal_penguji pp
ON ps.id_sidang=pp.id_sidang
WHERE mhs.nim='$decode' AND ps.tgl_sidang IS NOT NULL ORDER BY ps.tgl_sidang DESC") 
or die (mysqli_error($conn));

$getdata = mysqli_query($conn,
"SELECT DISTINCT mhs.nama, mhs.nim, mhs.foto,
judul.judul,
d1.nama_dosen AS pembimbing,
ps.tgl_sidang AS tgl,
ps.waktu_sidang AS waktu,
ps.ruang_sidang AS ruang, ps.id_sidang,
(SELECT d1.nama_dosen FROM dosen d1 INNER JOIN proposal_penguji pp
ON d1.nidn=pp.penguji 
WHERE pp.id_sidang=ps.id_sidang LIMIT 0,1) AS penguji1, 
(SELECT d2.nama_dosen FROM dosen d2 INNER JOIN proposal_penguji pp
ON d2.nidn=pp.penguji 
WHERE pp.id_sidang=ps.id_sidang LIMIT 1,1) as penguji2,
ps.status_sidang AS status
FROM proposaL_sidang ps 
LEFT JOIN proposal
ON ps.id_proposal=proposal.id_proposal
LEFT JOIN dosen d1
ON d1.nidn=proposal.dosbing
LEFT JOIN judul 
ON proposal.id_judul=judul.id_judul
LEFT JOIN mahasiswa mhs
ON judul.nim=mhs.nim
LEFT JOIN proposal_penguji pp
ON ps.id_sidang=pp.id_sidang
WHERE mhs.nim='$decode' AND ps.tgl_sidang IS NOT NULL ORDER BY ps.tgl_sidang desc") 
or die (mysqli_error($conn));
$data1 = mysqli_fetch_array($getdata);
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Detail Sidang Proposal | SIM-PS</title>
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
<?php 
  if (isset($_SESSION["login_kaprodi"])) {
    include '../kaprodi/assets/header.php';
  }elseif (isset($_SESSION["login_pa"])) {
    include '../pa/assets/header.php';
  }elseif (isset($_SESSION["login_dosen"])) {
    include 'assets/header.php';
  } ?>
<style>
  thead {
    background-color: grey;
    color: #FFFFFF;
  }
</style>
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
          <!-- /.card-header -->
          <div class="card-body">
          <table align="center">
              <tr>
                <td colspan="4" align="center">
                  <img src="../../assets/foto/<?= $data1["foto"]?>" alt="" width="150px" height="150px">
                </td>
              </tr>
              <tr>
                <td colspan="4">
                  <hr>
                </td>
              </tr>
              <tr>
                <td>
                  <font size="4">Nama</font>
                </td>
                <td>
                  <font size="4">:</font>
                </td>
                <td>
                  <font size="4"><?= $data1["nama"] ?></font>
                </td>
              </tr>
              <tr>
                <td colspan="4">
                  <hr>
                </td>
              </tr>
              <tr>
                <td>
                  <font size="4">Judul</font>
                </td>
                <td>
                  <font size="4">:</font>
                </td>
                <td>
                  <font size="4"><?= $data1["judul"] ?></font>
                </td>
              </tr>
              <tr>
                <td colspan="4">
                  <hr>
                </td>
              </tr>
              <tr>
                <td>
                  <font size="4">Pembimbing</font>
                </td>
                <td>
                  <font size="4">:</font>
                </td>
                <td>
                  <font size="4"><?= $data1["pembimbing"] ?></font>
                </td>
              </tr>
              <tr>
                <td colspan="4">
                  <hr>
                </td>
              </tr>
              <tr>
                <td>
                  <font size="4">Jumlah </font>
                </td>
                <td>
                  <font size="4">:</font>
                </td>
                <?php $jml = mysqli_num_rows($getdata) ?>
                <td>
                  <font size="4"><?= $jml.' Kali Sidang' ?></font>
                </td>
              </tr>

            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <center>
              <h2 class="m-0 text-dark">Data Sidang Proposal,
                <?=$data1["nama"] ?></h2>
            </center>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead align="center">
                <tr>
                  <th width="10px">No</th>
                  <th width="200px">Penguji 1</th>
                  <th width="200px">Penguji 2</th>
                  <th width="100px">Waktu</th>
                  <th width="50px">Ruang</th>
                  <th width="50px">Hasil</th>
                </tr>
              </thead>
              <tbody>
                <?php
$no=1;
if (mysqli_num_rows($getdataa) > 0) {
  while ($data=mysqli_fetch_array($getdataa)) {
    $tanggal = $data["tgl"];
    $tgl = date('d-M-Y', strtotime($tanggal));
    ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $data['penguji1'] ?></td>
                  <td><?= $data['penguji2'] ?></td>
                  <td align="center"><?= $tgl ?><br><?= $data['waktu'] ?></td>
                  <td align="center"><?= $data['ruang'] ?></td>
                  <td><?= $data['status'] ?></td>
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
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->

  <!-- modal tambah bimbingan -->
  <div class="modal fade" id="modalnilai1">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Hasil Sidang Proposal</h4>
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
                <label for="hasilsidang">Hasil Sidang</label>
                <input type="text" class="form-control" id="hasilsidang" name="hasilsidang" readonly>
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
    let foto = $(this).data('foto');
    let nim = $(this).data('nim');
    let nama = $(this).data('nama');
    let lemrev = $(this).data('lemrev');
    let filebim = $(this).data('filebim');
    let hasilbim = $(this).data('hasilbim');
    let pesan = $(this).data('pesan');
    let subjek = $(this).data('subjek');
    let tanggalbim = $(this).data('tanggal_bim');
    let judul = $(this).data('judul');
    let pembimbing = $(this).data('dosbing');
    let tglsid = $(this).data('tglsid');
    let ruangsid = $(this).data('ruangsid');
    let waktusid = $(this).data('waktusid');
    let status = $(this).data('status');
    let id = $(this).data('id');
    $("#modal-lg #nim").val(nim);
    $("#modal-lg #nama").val(nama);
    $("#modal-lg #filebim").attr("href", "assets/download.php?filename=" + filebim);
    $("#modal-lg #file_hasilbim").attr("href", "assets/downloadhasilbimpkl.php?filename=" + hasilbim);
    $("#modal-lg #pesan1").val(pesan);
    $("#modal-lg #subjek").val(subjek);
    $("#modal-lg #tanggal").val(tanggalbim);
    $("#modal-lg #judul").val(judul);
    $("#modal-lg #pembimbing").val(pembimbing);
    $("#modal-lg #tgl_sid").val(tglsid);
    $("#modal-lg #ruang_sid ").val(ruangsid);
    $("#modal-lg #waktu").val(waktusid);
    $("#modal-lg #status_bim1").val(status);
    $("#modal-lg #id").val(id);
    $("#modal-lg #foto").attr("src", "../../assets/foto/" + foto);
  });

  /// detail data
  $(document).on("click", "#nilai1", function () {
    let d = $(this).data('id');
    let hasil = $(this).data('status');
    $("#modalnilai1 #id").val(d);
    $("#modalnilai1 #hasilsidang").val(hasil);
  });
</script>
</body>

</html>