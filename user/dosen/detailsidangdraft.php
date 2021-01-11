<?php
session_start();

require "../../koneksi.php";
$nidn = $_SESSION["nidn"];

// ambil id BImbingan di get
if (isset($_GET["id"])) {
$decode = base64_decode($_GET["id"]);
}
//ambi data bimbingan
$id_sid = mysqli_query($conn, "SELECT dn.id_sidang FROM draft_nilai dn INNER JOIN draft_sidang ds
ON dn.id_sidang=ds.id_sidang INNER JOIN skripsi s
ON ds.id_skripsi=s.id_skripsi INNER JOIN proposal p ON s.id_proposal=p.id_proposal
INNER JOIN judul j ON p.id_judul=j.id_judul INNER JOIN mahasiswa m ON j.nim=m.nim
WHERE m.nim='$decode' ");
$id_ = mysqli_fetch_array($id_sid);
$ida = $id_["id_sidang"];
$getdataa = mysqli_query($conn,
                        "SELECT DISTINCT mhs.nama, mhs.nim,
                        j.judul, s.id_skripsi,
                        ds.status_sidang AS status,
                        ds.tgl_sidang AS tgl,
                        ds.waktu_sidang AS waktu,
                        ds.ruang_sidang AS ruang, ds.id_sidang, ds.status_sidang,
                        -- ambil data penguji1
                        (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN draft_penguji dp
                        ON d1.nidn=dp.penguji 
                        WHERE dp.id_sidang=ds.id_sidang AND status_penguji='Penguji 1'
                        AND dp.status='Aktif' LIMIT 0,1) AS penguji1, 
                        -- ambil data penguji2
                        (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN draft_penguji dp
                        ON d2.nidn=dp.penguji 
                        WHERE dp.id_sidang=ds.id_sidang AND status_penguji='Penguji 2'
                        AND dp.status='Aktif' LIMIT 0,1) as penguji2,
                        dn.dos1_pen AS dos1p1, dn.dos1_peng AS dos1p11, dn.dos1_sis AS dos1sis, dn.dos1_ap AS dos1ap,
                        dn.dos2_pen AS dos2p1, dn.dos2_peng AS dos2p11, dn.dos2_sis AS dos2sis, dn.dos2_ap AS dos2ap,
                        dn.peng1_pen AS peng1p1, dn.peng1_peng AS peng1p11, dn.peng1_sis AS peng1sis, dn.peng1_ap AS peng1ap,
                        dn.peng2_pen AS peng2p1, dn.peng2_peng AS peng2p11, dn.peng2_sis AS peng2sis, dn.peng2_ap As peng2ap,
                        (SELECT ((dos1_pen+dos1_peng+dos1_sis+dos1_ap+dos2_pen+dos2_peng+dos2_sis+dos2_ap+
                        peng1_pen+peng1_peng+peng1_sis+peng1_ap+peng2_pen+peng2_peng+peng2_sis+peng2_ap)/16)
                        FROM draft_nilai WHERE id_sidang='$ida') AS total
                        FROM draft_sidang ds 
                        LEFT JOIN skripsi s
                        ON ds.id_skripsi=s.id_skripsi
                        LEFT JOIN proposal p
                        ON s.id_proposal=p.id_proposal
                        LEFT JOIN judul j
                        ON p.id_judul=j.id_judul
                        LEFT JOIN mahasiswa mhs
                        ON j.nim=mhs.nim
                        LEFT JOIN draft_penguji dp
                        ON ds.id_sidang=dp.id_sidang
                        LEFT JOIN draft_nilai dn
                        ON ds.id_sidang=dn.id_sidang
                          WHERE mhs.nim='$decode' AND ds.tgl_sidang IS NOT NULL ORDER BY ds.tgl_sidang ASC") 
                        or die (mysqli_error($conn));

$getdata = mysqli_query($conn,
                        "SELECT mhs.nama, mhs.nim, mhs.foto,
                          judul.judul,
                          ds.tgl_sidang AS tgl,
                          ds.waktu_sidang AS waktu,
                          ds.ruang_sidang AS ruang, ds.id_sidang,
                          ds.ruang_sidang AS ruang, 
                          ds.status_sidang AS status,
                          (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd 
                          ON d1.nidn=sd.nidn 
                          WHERE sd.id_skripsi=s.id_skripsi LIMIT 0,1) AS pem1, 
                          (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN skripsi_dosbing sd
                          ON d2.nidn=sd.nidn 
                          WHERE sd.id_skripsi=s.id_skripsi LIMIT 1,1) as pem2,
                           -- ambil data penguji1
                          (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN draft_penguji dp
                          ON d1.nidn=dp.penguji 
                          WHERE dp.id_sidang=ds.id_sidang LIMIT 0,1) AS penguji1, 
                          -- ambil data penguji2
                          (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN draft_penguji dp
                          ON d2.nidn=dp.penguji 
                          WHERE dp.id_sidang=ds.id_sidang LIMIT 1,1) as penguji2
                          FROM draft_sidang ds 
                          LEFT JOIN skripsi s
                          ON ds.id_skripsi=s.id_skripsi
                          LEFT JOIN proposal
                          ON s.id_proposal=proposal.id_proposal
                          LEFT JOIN judul 
                          ON proposal.id_judul=judul.id_judul
                          LEFT JOIN mahasiswa mhs
                          ON judul.nim=mhs.nim
                          WHERE mhs.nim='$decode' AND ds.tgl_sidang IS NOT NULL ORDER BY ds.tgl_sidang DESC") 
                        or die (mysqli_error($conn));
$data1 = mysqli_fetch_array($getdata);
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Detail Sidang Draft | SIM-PS</title>
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
                  <font size="4">Pem 1</font>
                </td>
                <td>
                  <font size="4">:</font>
                </td>
                <td>
                  <font size="4"><?= $data1["pem1"] ?></font>
                </td>
              </tr>
              <tr>
                <td colspan="4">
                  <hr>
                </td>
              </tr>
              <tr>
                <td>
                  <font size="4">Pem 2</font>
                </td>
                <td>
                  <font size="4">:</font>
                </td>
                <td>
                  <font size="4"><?= $data1["pem2"] ?></font>
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
              <tr>
                <td colspan="4">
                  <hr>
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
              <h3 class="m-0 text-dark">Data Sidang Draft,
                <?=$data1["nama"] ?></h3>
            </center>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead align="center">
                <tr>
                  <th width="10px">No</th>
                  <th width="250px">Penguji 1</th>
                  <th width="250px">Penguji 2</th>
                  <th width="110px">Waktu</th>
                  <th width="50px">Ruang</th>
                  <th width="50px">Nilai</th>
                </tr>
              </thead>
              <tbody>
                <?php
                        $no=1;
                        if (mysqli_num_rows($getdataa) > 0) {
                        while ($data=mysqli_fetch_array($getdataa)) {
                          $tanggal = $data["tgl"];
                          $tgl = date('d-M-Y', strtotime($tanggal));
                          $dataq = $data["total"];
                        if ($dataq > 85) {
                          $grade = 'A';
                        }elseif ($dataq > 70 AND $dataq < 85) {
                          $grade = 'B';
                        }elseif ($dataq > 55 AND $dataq < 70) {
                          $grade = 'C';
                        }elseif ($dataq > 40 AND $dataq < 55) {
                          $grade = 'D';
                        }elseif ($dataq > 0 AND $dataq < 40) {
                          $grade = 'E';
                        }elseif ($dataq == "") {
                          $grade = '';
                        }
                        ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $data['penguji1'] ?></td>
                  <td><?= $data['penguji2'] ?></td>
                  <td align="center"><?= $tgl ?><br><?= $data['waktu'] ?></td>
                  <td align="center"><?= $data['ruang'] ?></td>
                  <td align="center">
                    <button class="btn-xs btn-danger" data-toggle="modal" data-target="#modalnilai1" id="nilai1"
                      data-id="<?php echo $data["id_sidang"] ?>" data-ids="<?php echo $data["id_skripsi"] ?>"
                      data-dos1p1="<?php echo $data["dos1p1"] ?>" data-dos1p11="<?php echo $data["dos1p11"] ?>"
                      data-dos1sis="<?php echo $data["dos1sis"] ?>" data-dos1ap="<?php echo $data["dos1ap"] ?>"
                      data-dos2p1="<?php echo $data["dos2p1"] ?>" data-dos2p11="<?php echo $data["dos2p11"] ?>"
                      data-dos2sis="<?php echo $data["dos2sis"] ?>" data-dos2ap="<?php echo $data["dos2ap"] ?>"
                      data-peng1p1="<?php echo $data["peng1p1"] ?>" data-peng1p11="<?php echo $data["peng1p11"] ?>"
                      data-peng1sis="<?php echo $data["peng1sis"] ?>" data-peng1ap="<?php echo $data["peng1ap"] ?>"
                      data-peng2p1="<?php echo $data["peng2p1"] ?>" data-peng2p11="<?php echo $data["peng2p11"] ?>"
                      data-peng2sis="<?php echo $data["peng2sis"] ?>" data-peng2ap="<?php echo $data["peng2ap"] ?>"
                      data-status="<?php echo $data["status_sidang"] ?>" data-total="<?php echo $data["total"] ?>"
                      data-grade="<?php echo $grade ?>">
                      <i class="fas fa-info-circle"></i></button>
                  </td>
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
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Nilai Sidang Draft</h4>
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
                <div class="form-group col-md-3">
                  <label for="npm1">Penyampaian Materi Penguji1</label>
                  <input type="number" class="form-control" id="pen_penguji1" name="pen_penguji1" max="100" min="0"
                    readonly>
                </div>
                <div class="form-group col-md-3">
                  <label for="npm11">Penyampaian Materi Penguji2</label>
                  <input type="number" class="form-control" id="pen_penguji2" name="pen_penguji2" max="100" min="0"
                    readonly>
                </div>
                <div class="form-group col-md-3">
                  <label for="npm11">Penyampaian Materi Pemb1</label>
                  <input type="number" class="form-control" id="pen_dos1" name="pen_dos1" max="100" min="0" readonly>
                </div>
                <div class="form-group col-md-3">
                  <label for="npm11">Penyampaian Materi Pemb2</label>
                  <input type="number" class="form-control" id="pen_dos2" name="pen_dos2" max="100" min="0" readonly>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-3">
                  <label for="npm2">Penguasaan Penguji1</label>
                  <input type="number" class="form-control" id="peng_penguji1" name="peng_penguji1" max="100" min="0"
                    readonly>
                </div>
                <div class="form-group col-md-3">
                  <label for="npm22">Penguasaan Materi Penguji2</label>
                  <input type="number" class="form-control" id="peng_penguji2" name="peng_penguji2" max="100" min="0"
                    readonly>
                </div>
                <div class="form-group col-md-3">
                  <label for="npm11">Penguasaan Materi Pemb1</label>
                  <input type="number" class="form-control" id="peng_dos1" name="peng_dos1" max="100" min="0" readonly>
                </div>
                <div class="form-group col-md-3">
                  <label for="npm11">Penguasaan Materi Pemb2</label>
                  <input type="number" class="form-control" id="peng_dos2" name="peng_dos2" max="100" min="0" readonly>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-3">
                  <label for="sistematika">Sistematika Penulisan Penguji1</label>
                  <input type="number" class="form-control" id="sis_penguji1" name="sis_penguji1" max="100" min="0"
                    readonly>
                </div>
                <div class="form-group col-md-3">
                  <label for="sistematika1">Sitematika Penulisan Penguji2</label>
                  <input type="number" class="form-control" id="sis_penguji2" name="sis_penguji2" max="100" min="0"
                    readonly>
                </div>
                <div class="form-group col-md-3">
                  <label for="npm11">Sistematika Penulisan Pemb1</label>
                  <input type="number" class="form-control" id="sis_dos1" name="sis_dos1" max="100" min="0" readonly>
                </div>
                <div class="form-group col-md-3">
                  <label for="npm11">Sistematika Penulisan Pemb2</label>
                  <input type="number" class="form-control" id="sis_dos2" name="sis_dos2" max="100" min="0" readonly>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-3">
                  <label for="sistematika">TanggungJawab Aplikasi Penguji1</label>
                  <input type="number" class="form-control" id="ap_penguji1" name="ap_penguji1" max="100" min="0"
                    readonly>
                </div>
                <div class="form-group col-md-3">
                  <label for="sistematika1">TanggungJawab Aplikasi Penguji2</label>
                  <input type="number" class="form-control" id="ap_penguji2" name="ap_penguji2" max="100" min="0"
                    readonly>
                </div>
                <div class="form-group col-md-3">
                  <label for="npm11">TanggungJawab Aplikasi Pemb1</label>
                  <input type="number" class="form-control" id="ap_dos1" name="ap_dos1" max="100" min="0" readonly>
                </div>
                <div class="form-group col-md-3">
                  <label for="npm11">TanggungJawab Aplikasi Pemb2</label>
                  <input type="number" class="form-control" id="ap_dos2" name="ap_dos2" max="100" min="0" readonly>
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

  /// detail data
  $(document).on("click", "#nilai1", function () {
    let d = $(this).data('id');
    let dos1p1 = $(this).data('dos1p1');
    let dos1p11 = $(this).data('dos1p11');
    let dos1sis = $(this).data('dos1sis');
    let dos1ap = $(this).data('dos1ap');
    let dos2p1 = $(this).data('dos2p1');
    let dos2p11 = $(this).data('dos2p11');
    let dos2sis = $(this).data('dos2sis');
    let dos2ap = $(this).data('dos2ap');
    let peng1p1 = $(this).data('peng1p1');
    let peng1p11 = $(this).data('peng1p11');
    let peng1sis = $(this).data('peng1sis');
    let peng1ap = $(this).data('peng1ap');
    let peng2p1 = $(this).data('peng2p1');
    let peng2p11 = $(this).data('peng2p11');
    let peng2sis = $(this).data('peng2sis');
    let peng2ap = $(this).data('peng2ap');
    let total = $(this).data('total');
    let hasil = $(this).data('status');
    let grade = $(this).data('grade');
    $("#modalnilai1 #id").val(d);
    $("#modalnilai1 #pen_penguji1").val(peng1p1);
    $("#modalnilai1 #pen_penguji2").val(peng2p1);
    $("#modalnilai1 #pen_dos1").val(dos1p1);
    $("#modalnilai1 #pen_dos2").val(dos2p1);
    $("#modalnilai1 #peng_penguji1").val(peng1p11);
    $("#modalnilai1 #peng_penguji2").val(peng2p11);
    $("#modalnilai1 #peng_dos1").val(dos1p11);
    $("#modalnilai1 #peng_dos2").val(dos2p11);
    $("#modalnilai1 #sis_penguji1").val(peng1sis);
    $("#modalnilai1 #sis_penguji2").val(peng2sis);
    $("#modalnilai1 #sis_dos1").val(dos1sis);
    $("#modalnilai1 #sis_dos2").val(dos2sis);
    $("#modalnilai1 #ap_penguji1").val(peng1ap);
    $("#modalnilai1 #ap_penguji2").val(peng2ap);
    $("#modalnilai1 #ap_dos1").val(dos1ap);
    $("#modalnilai1 #ap_dos2").val(dos2ap);
    $("#modalnilai1 #hasilsidang").val(hasil);
    $("#modalnilai1 #total").val(total);
    $("#modalnilai1 #grade").val(grade);
  });
</script>
</body>

</html>