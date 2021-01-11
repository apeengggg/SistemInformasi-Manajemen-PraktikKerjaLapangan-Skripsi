<?php
session_start();
require "../../koneksi.php";
if (!isset($_SESSION["login_tu"])) {
header("location:../../index.php");
exit();
}
$nidn=$_SESSION["nidn"];

if (isset($_POST["ubah"])) {
  $id = $_POST["id"];
  $hasil = $_POST["status"];
  if ($hasil = "Lulus") {
  $ustatus = mysqli_query($conn, "UPDATE mahasiswa
            LEFT JOIN judul ON mahasiswa.nim=judul.niim
            LEFT JOIN proposal p ON judul.id_judul=p.id_judul
            LEFT JOIN proposal_sidang ps ON p.id_proposal=ps.id_proposal
            SET mahasiswa.status_proposal='Lulus'
            WHERE ps.id_sidang='$id'");
  $sql = mysqli_query($conn, "UPDATE proposal_sidang SET status_sidang='$hasil' WHERE id_sidang='$id'");
  if ($sql) {
echo "<script>
alert('Status Sidang Berhasil DiUbah')
windows.location.href('sidangproposal.php')
</script>";
  }else {
    echo "<script>
alert('Status Sidang Gagal Diubah')
windows.location.href('sidangproposal.php')
</script>";
   }
  }else{
    $sql1 = mysqli_query($conn, "UPDATE proposal_sidang SET status_sidang='$hasil' WHERE id_sidang='$id'");
  if ($sql1) {
echo "<script>
alert('Status Sidang Berhasil DiUbah')
windows.location.href('sidangproposal.php')
</script>";
  }else {
    echo "<script>
alert('Status Sidang Gagal Diubah')
windows.location.href('sidangproposal.php')
</script>";
   }
  }
}
?>

<!-- jadwalkan sidang -->
<?php
// jadwal sidang
$date = date('Y-m-d');
$jadwalsidang = mysqli_query($conn,
                        "SELECT DISTINCT mhs.nama, mhs.nim,
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
                        WHERE ps.status_sidang IS NULL
                        AND val_dosbing='2'") 
                        or die (mysqli_error($conn));

// seluruh data sidang
$datasidang = mysqli_query($conn,
                        "SELECT DISTINCT mhs.nama, mhs.nim,
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
                        GROUP BY mhs.nama
                        ") 
                        or die (mysqli_error($conn));
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Data Sidang Proposal | SIM-PS | Tata Usaha</title>
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
              <h1 class="m-0 text-dark" id="jad">Jadwal Pengujian Sidang Proposal</h1><br>
            </center>
            <a href="assets/jadwalsidangprop.php" target="_blank" class="btn btn-success">
              <i class="fas fa-file-export"></i> Export Jadwal
            </a>
            <a href="#all" class="btn btn-primary">Data Sidang Semua Mahasiswa</a>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <style>
                .thead {
                  width: absoulute;
                }
              </style>
              <thead class="thead" align="center">
                <tr>
                  <th width="80px">NIM</th>
                  <th width="200px">Nama</th>
                  <th width="110px">Waktu</th>
                  <th width="100px">Ruangan</th>
                  <th width="200px">Penguji 1</th>
                  <th width="200px">Penguji 2</th>
                  <th width="100px">Status</th>
                  <th width="50px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                        if (mysqli_num_rows($jadwalsidang) > 0) {
                        while ($data1=mysqli_fetch_array($jadwalsidang) ) {
                        $nim = $data1["nim"]; 
                        $id = base64_encode($nim);
                        $d = $data1["tgl"];
                        $tgll = date('d-M-Y', strtotime($d));
                        ?>

                <!-- tampilkan data -->
                <tr>
                  <td><?php echo $data1["nim"] ?></td>
                  <td><a href="detailsidangprop.php?id=<?= $id ?>"><?php echo $data1["nama"] ?></a></td>
                  <td align="center"><?php echo $tgll ?><br><?php echo $data1["waktu"] ?></td>
                  <td align="center"><?php echo $data1["ruang"] ?></td>
                  <td><?php echo $data1["penguji1"] ?></td>
                  <td><?php echo $data1["penguji2"] ?></td>
                  <td><?php echo $data1["status"] ?></td>
                  <td align="center"><button class="btn-xs btn-dark" id="detaildata" data-toggle="modal"
                      data-target="#modal" data-id="<?= $data1["id_sidang"] ?>">
                      <i class="fas fa-edit"></i></button></td>
                </tr>
                <?php  }
                        }
                        ?>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- modal edit status sidang -->
        <div class="modal fade" id="modal">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Ubah Hasil Sidang</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="form-horizontal" method="post">
                  <div class="card-body">
                    <div class="form-group row">
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="id" name="id" required="required" hidden>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="subjek" class="col-sm-3 col-form-label">Hasil Sidang</label>
                      <div class="col-sm-9">
                        <select name="status" id="status" class="form-control" required>
                          <option value="">Pilih Hasil Sidang...</option>
                          <option value="Lulus">Lulus</option>
                          <option value="Tidak Lulus">Tidak Lulus</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="ubah" id="ubah">Kirim</button>
              </div>
            </div>
            </form>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /. mdoal edit satus sidang -->



      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.section 2 -->

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <!-- <h1 class="m-0 text-dark" id="all">Data Sidang Proposal Mahasiswa</h1> -->
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
              <h1 class="m-0 text-dark" id="all">Data Sidang Proposal Mahasiswa</h1>
              <br>
            </center>
            <button type="submit" class="btn btn-warning" data-toggle="modal" data-target="#modal-md"><i
                class="fas fa-print"></i>Cetak Laporan</button>
            <a href="#jad" class="btn btn-primary">Data Jadwal Sidang</a>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example5" class="table table-bordered table-striped">
              <style>
                .thead {
                  width: absoulute;
                }
              </style>
              <thead class="thead">
                <tr>
                  <th width="70px">NIM</th>
                  <th width="180px">Nama</th>
                  <th width="200px">Pembimbing</th>
                  <th width="200px">Judul</th>
                </tr>
              </thead>
              <tbody>
                <?php
                        if (mysqli_num_rows($datasidang) > 0) {
                        while ($data1=mysqli_fetch_array($datasidang) ) {
                        $nim2 = $data1["nim"];
                        $id2 = base64_encode($nim2)
                        ?>

                <!-- tampilkan data -->
                <tr>
                  <td><?php echo $data1["nim"] ?></td>
                  <td><a href="detailsidangprop.php?id=<?= $id2 ?>"><?php echo $data1["nama"] ?></a></td>
                  <td><?php echo $data1["pembimbing"] ?></td>
                  <td><?php echo $data1["judul"] ?></td>
                </tr>
                <?php  }
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
                <h4 class="modal-title">Cetak Laporan Data Sidang Proposal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="form-horizontal" method="post" action="assets/reportsidprop.php">
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
                  id="jadwalkan">Jadwalkan</button>
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

  <!-- /.section 2 -->
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
  // detail data
  $(document).on("click", "#detaildata", function () {
    let id = $(this).data('id');
    $(".modal-body #id").val(id);
  });
</script>
</body>

</html>