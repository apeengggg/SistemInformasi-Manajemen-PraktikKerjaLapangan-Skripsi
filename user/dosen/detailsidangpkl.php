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
"SELECT 
mahasiswa.nama AS nama,
mahasiswa.foto AS fotomhs,
d1.foto_dosen AS fotopem,
d2.foto_dosen AS fotopeng,
pkl.judul_laporan AS judul,
d1.nama_dosen AS pembimbing,
d2.nama_dosen AS penguji,
sid.tgl_sid AS tanggal,
sid.ruang_sid AS ruang,
sid.waktu AS waktu,
sid.status_sid AS hasil
FROM pkl_sidang sid 
LEFT JOIN pkl
ON sid.id_pkl=pkl.id_pkl
LEFT JOIN dosen_wali
ON pkl.id_dosenwali=dosen_wali.id_dosenwali
LEFT JOIN dosen d1
ON dosen_wali.nidn=d1.nidn
LEFT JOIN dosen d2
ON sid.penguji=d2.nidn
LEFT JOIN mahasiswa
ON pkl.nim=mahasiswa.nim
WHERE mahasiswa.nim='$decode' AND sid.tgl_sid IS NOT NULL ORDER BY sid.tgl_sid ASC") or die (mysqli_erorr($conn));
$data1 = mysqli_fetch_array($getdataa);

$id_sid = mysqli_query($conn, "SELECT id_sidang FROM pkl_nilai pn INNER JOIN pkl_sidang ps
ON pn.id_sidang=ps.id_sidpkl INNER JOIN pkl p ON ps.id_pkl=p.id_pkl INNER JOIN mahasiswa m
ON p.nim=m.nim WHERE m.nim='$decode'");
$id_ = mysqli_fetch_array($id_sid);
$ida = $id_["id_sidang"];
$getdata = mysqli_query($conn,
"SELECT 
mahasiswa.nama AS nama,
mahasiswa.foto AS fotomhs,
d1.foto_dosen AS fotopem,
d2.foto_dosen AS fotopeng,
pkl.judul_laporan AS judul,
d1.nama_dosen AS pembimbing,
d2.nama_dosen AS penguji,
sid.tgl_sid AS tanggal,
sid.ruang_sid AS ruang,
sid.waktu AS waktu,
sid.status_sid AS hasil, sid.id_sidpkl AS id,
pn.peng_pen_mat AS p1, pn.peng_peng_mat AS p2, pn.peng_sis AS sis,
pn.pem_peng_mat AS p11, pn.pem_peng_mat AS p22, pn.pem_sis AS sis1,
(SELECT ((pem_pen_mat+pem_peng_mat+pem_sis+peng_peng_mat+peng_pen_mat+peng_sis)/6) 
FROM pkl_nilai WHERE id_sidang='$ida') AS total
FROM pkl_sidang sid 
LEFT JOIN pkl
ON sid.id_pkl=pkl.id_pkl
LEFT JOIN dosen_wali
ON pkl.id_dosenwali=dosen_wali.id_dosenwali
LEFT JOIN dosen d1
ON dosen_wali.nidn=d1.nidn
LEFT JOIN dosen d2
ON sid.penguji=d2.nidn
LEFT JOIN mahasiswa
ON pkl.nim=mahasiswa.nim
LEFT JOIN pkl_nilai pn 
ON sid.id_sidpkl=pn.id_sidang
WHERE mahasiswa.nim='$decode' AND sid.tgl_sid IS NOT NULL ORDER BY sid.tgl_sid ASC") or die (mysqli_erorr($conn));
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Detail Sidang PKL | SIM-PS</title>
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
                  <img src="../../assets/foto/<?= $data1["fotomhs"]?>" alt="" width="150px" height="150px">
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
                <?php $jml = mysqli_num_rows($getdataa) ?>
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
              <h2 class="m-0 text-dark">Data Sidang PKL,
                <?=$data1["nama"] ?></h2>
            </center>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead align="center">
                <tr>
                  <th width="10px">No</th>
                  <th width="200px">Penguji</th>
                  <th width="75px">Waktu</th>
                  <th width="50px">Ruang</th>
                  <th width="50px">Nilai</th>
                </tr>
              </thead>
              <tbody>
                <?php
                        $no=1;
                        if (mysqli_num_rows($getdata) > 0) {
                        while ($data=mysqli_fetch_array($getdata)) {
                        $tanggal = $data["tanggal"];
                        $tgl = date('d-M-Y', strtotime($tanggal));
                        if ($tanggal == "" OR $tanggal == NULL) {
                          $tgll = "";
                        }else {
                          $tgll = $tgl;
                        }
                        $dataq = $data["total"];
                        if ($dataq > 85) {
                          $grade = 'A';
                        }elseif ($dataq > 70 OR $dataq < 85) {
                          $grade = 'B';
                        }elseif ($dataq > 55 OR $dataq < 70) {
                          $grade = 'C';
                        }elseif ($dataq > 40 OR $dataq < 55) {
                          $grade = 'D';
                        }elseif ($dataq > 0 OR $dataq < 40) {
                          $grade = 'E';
                        }elseif ($dataq == "") {
                          $grade = '';
                        }
                        ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $data['penguji'] ?></td>
                  <td align="center"><?= $tgll ?><br><?= $data['waktu'] ?></td>
                  <td align="center"><?= $data['ruang'] ?></td>
                  <td align="center"> <button class="btn-xs btn-danger" data-toggle="modal" data-target="#modalnilai1"
                      id="nilai1" data-id="<?php echo $data["id"] ?>" data-p1="<?php echo $data["p1"] ?>"
                      data-p2="<?php echo $data["p2"] ?>" data-sis="<?php echo $data["sis"] ?>"
                      data-p11="<?php echo $data["p11"] ?>" data-p22="<?php echo $data["p22"] ?>"
                      data-sis1="<?php echo $data["sis1"] ?>" data-status="<?php echo $data["hasil"] ?>"
                      data-total="<?php echo $data["total"] ?>" data-grade="<?php echo $grade ?>">
                      <i class="fas fa-info-circle"></i></button></td>
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
                <input type="text" class="form-control" id="id" name="id" readonly hidden>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="npm1">Nilai Penyampaian Materi Penguji</label>
                  <input type="number" class="form-control" id="npm1" name="npm1" max="100" min="0" readonly>
                </div>
                <div class="form-group col-md-6">
                  <label for="npm11">Nilai Penyampaian Materi Pembimbing</label>
                  <input type="number" class="form-control" id="npm11" name="npm11" max="100" min="0" readonly>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="npm2">Nilai Penguasaan Penguji</label>
                  <input type="number" class="form-control" id="npm2" name="npm2" max="100" min="0" readonly>
                </div>
                <div class="form-group col-md-6">
                  <label for="npm22">Nilai Penguasaan Materi Pembimbing</label>
                  <input type="number" class="form-control" id="npm22" name="npm22" max="100" min="0" readonly>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="sistematika">Nilai Sistematika Penulisan Penguji</label>
                  <input type="number" class="form-control" id="sistematika" name="sistematika" max="100" min="0"
                    readonly>
                </div>
                <div class="form-group col-md-6">
                  <label for="sistematika1">Nilai Sitematika Penulisan Pembimbing</label>
                  <input type="number" class="form-control" id="sistematika1" name="sistematika1" max="100" min="0"
                    readonly>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="hasilsidang">Hasil Sidang</label>
                  <input type="text" class="form-control" id="hasilsidang" name="hasilsidang" readonly>
                </div>
                <div class="form-group col-md-3">
                  <label for="sistematika1">Rata-rata Nilai</label>
                  <input type="number" class="form-control" id="total" name="total" max="100" min="0" readonly>
                </div>
                <div class="form-group col-md-3">
                  <label for="sistematika1">Mutu Nilai</label>
                  <input type="text" class="form-control" id="grade" name="grade" readonly>
                </div>
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
    let p1 = $(this).data('p1');
    let p2 = $(this).data('p2');
    let p11 = $(this).data('p11');
    let p22 = $(this).data('p22');
    let sis = $(this).data('sis');
    let sis1 = $(this).data('sis1');
    let hasil = $(this).data('status');
    let total = $(this).data('total');
    let grade = $(this).data('grade');
    $("#modalnilai1 #id").val(d);
    $("#modalnilai1 #npm1").val(p1);
    $("#modalnilai1 #npm2").val(p2);
    $("#modalnilai1 #npm11").val(p11);
    $("#modalnilai1 #npm22").val(p22);
    $("#modalnilai1 #sistematika").val(sis);
    $("#modalnilai1 #sistematika1").val(sis1);
    $("#modalnilai1 #hasilsidang").val(hasil);
    $("#modalnilai1 #total").val(total);
    $("#modalnilai1 #grade").val(grade);
  });
</script>
</body>

</html>