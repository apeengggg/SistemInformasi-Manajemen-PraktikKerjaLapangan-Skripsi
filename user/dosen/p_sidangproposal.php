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
WHERE pp.id_sidang=ps.id_sidang AND status_penguji='Penguji 1'
AND pp.status='Aktif' LIMIT 0,1) AS penguji1, 
-- ambil data penguji2
(SELECT d2.nama_dosen FROM dosen d2 INNER JOIN proposal_penguji pp
ON d2.nidn=pp.penguji 
WHERE pp.id_sidang=ps.id_sidang AND status_penguji='Penguji 2'
AND pp.status='Aktif' LIMIT 0,1) as penguji2,
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
WHERE pp.penguji='$nidn' AND ps.tgl_sidang='$date' ORDER BY tgl_sidang DESC")  
or die (mysqli_error($conn));

$jadwalsidang1 = mysqli_query($conn,
"SELECT DISTINCT mhs.nama, mhs.nim,
judul.judul,
d1.nama_dosen AS pembimbing,
ps.tgl_sidang AS tgl,
ps.waktu_sidang AS waktu,
ps.ruang_sidang AS ruang, ps.id_sidang,
-- ambil data penguji1
(SELECT d1.nama_dosen FROM dosen d1 INNER JOIN proposal_penguji pp
ON d1.nidn=pp.penguji 
WHERE pp.id_sidang=ps.id_sidang AND status_penguji='Penguji 1'
AND pp.status='Aktif' LIMIT 0,1) AS penguji1, 
-- ambil data penguji2
(SELECT d2.nama_dosen FROM dosen d2 INNER JOIN proposal_penguji pp
ON d2.nidn=pp.penguji 
WHERE pp.id_sidang=ps.id_sidang AND status_penguji='Penguji 2'
AND pp.status='Aktif' LIMIT 0,1) as penguji2,
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
WHERE pp.penguji='$nidn' GROUP BY mhs.nim")  
or die (mysqli_error($conn));


// if (isset($_POST["nilai1"])) {
//   $id = $_POST["id"];
//   // var_dump($id); die;
//   $hasil = $_POST["hasilsidang"];
//   $sql = mysqli_query($conn, "UPDATE proposal_sidang SET status_sidang='$hasil' WHERE id_sidang='$id'");
//   if ($sql) {
//     echo "<script>
//     alert('Status Berhasil Diinput !')
//     windows.location.href='p_sidangproposal.php'
//     </script>";
//   }else {
//     echo "<script>
//     alert('Status gagal diinput !')
//     windows.location.href='p_sidangproposal.php'
//     </script>";
//   }
// }
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Data Sidang Proposal | SIM-PS | Dosen</title>
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
              <h1 class="m-0 text-dark" id="jad">Jadwal Pengujian Sidang Proposal</h1><br>
            </center>
            <!-- <a href="#bim" class="btn btn-primary">Data Sidang Mahasiswa Bimbingan</a> -->
            <!-- <a href="#all" class="btn btn-primary">Data Sidang Semua Mahasiswa</a> -->
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example3" class="table table-bordered table-striped">
              <style>
                .thead {
                  width: absoulute;
                }
              </style>
              <thead class="thead">
                <tr>
                  <th width="180px">Nama</th>
                  <th width="200px">Judul</th>
                  <th width="100px">Waktu</th>
                  <th width="180px">Ruangan</th>
                  <th width="180px">Penguji 1</th>
                  <th width="180px">Penguji 2</th>
                  <!-- <th>Status</th> -->
                </tr>
              </thead>
              <tbody>
                <?php
if (mysqli_num_rows($jadwalsidang) > 0) {
  while ($data1=mysqli_fetch_array($jadwalsidang) ) {
    $nim = $data1["nim"]; 
    $id = base64_encode($nim);
    $tanggal = $data1["tgl"];
    $tgl = date('d-M-Y', strtotime($tanggal));
    ?>

                <!-- tampilkan data -->
                <tr>
                  <td><a href="detailsidangprop.php?id=<?= $id ?>"><?php echo $data1["nama"] ?></a></td>
                  <td><?php echo $data1["judul"] ?></td>
                  <td align="center"><?php echo $tgl ?><br><?php echo $data1["waktu"] ?></td>
                  <td align="center"><?php echo $data1["ruang"] ?></td>
                  <td><?php echo $data1["penguji1"] ?></td>
                  <td><?php echo $data1["penguji2"] ?></td>
                  <!-- <td>
                    <?php
    $id = $data1["id_sidang"];
    $sql = mysqli_query($conn, "SELECT * FROM proposal_sidang WHERE id_sidang='$id' AND 
    status_sidang IS NULL");
    $q = mysqli_num_rows($sql);
    if ($q>0) {
      ?>
                    <button class="btn-xs btn-dark" data-toggle="modal" data-target="#modalnilai" id="nilai"
                      data-id="<?php echo $data1["id_sidang"] ?>">
                      <i class="fas fa-file"></i></button>
                    <?php }else{?>
                    <button class="btn-xs btn-danger" data-toggle="modal" data-target="#modalnilai1" id="nilai1"
                      data-id="<?php echo $data1["id_sidang"] ?>" data-status="<?php echo $data1["status"] ?>">
                      <i class="fas fa-info-circle"></i></button>
                    <?php } ?>
                  </td> -->
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
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.section 2 -->
  <!-- modal tambah bimbingan -->
  <!-- <div class="modal fade" id="modalnilai">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Form Hasil Sidang Proposal</h4>
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
                <select name="hasilsidang" id="hasilsidang" class="form-control">
                  <option value="">Pilih Hasil Sidang..</option>
                  <option value="Lulus">Lulus</option>
                  <option value="Tidak Lulus">Tidak Lulus</option>
                </select>
              </div> -->
              <!-- /.card-body -->
            <!-- </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="nilai1"
                id="nilai1">Kirim</button>
            </div>
          </form> -->
          <!-- /.modal-content -->
        <!-- </div> -->
        <!-- /.modal-dialog -->
      <!-- </div>
    </div>
  </div> -->
  <!-- /.modal -->
  <!-- modal tambah bimbingan -->

  <!-- modal tambah bimbingan -->
  <!-- <div class="modal fade" id="modalnilai1">
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
                <input type="text" class="form-control" id="hasilsidang" name="hasilsidang" readonly> -->
                <!-- /.card-body -->
              <!-- </div>
          </form> -->
          <!-- /.modal-content -->
        <!-- </div> -->
        <!-- /.modal-dialog -->
      <!-- </div>
    </div>
  </div>
</div> -->
<!-- /.modal -->
<!-- modal tambah bimbingan -->
<!-- /.content -->

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <!-- <h1 class="m-0 text-dark" id="jad">Jadwal Pengujian Sidang Proposal, <?=$date?></h1> -->
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
            <h1 class="m-0 text-dark" id="jad">Jadwal Pengujian Sidang Proposal</h1><br>
          </center>
          <button type="submit" class="btn btn-warning" data-toggle="modal" data-target="#modal-md"><i
                class="fas fa-print"> Cetak</i></button>
          <!-- <a href="#bim" class="btn btn-primary">Data Sidang Mahasiswa Bimbingan</a> -->
          <!-- <a href="#all" class="btn btn-primary">Data Sidang Semua Mahasiswa</a> -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <style>
              .thead {
                width: absoulute;
              }
            </style>
            <thead class="thead">
              <tr>
                <th width="180px">Nama</th>
                <th width="200px">Judul</th>
                <th width="180px">Penguji 1</th>
                <th width="180px">Penguji 2</th>
                <!-- <th width="50px">Status</th> -->
              </tr>
            </thead>
            <tbody>
              <?php
      if (mysqli_num_rows($jadwalsidang1) > 0) {
        while ($data2=mysqli_fetch_array($jadwalsidang1)) {
          $nim = $data2["nim"]; 
          $id = base64_encode($nim);
          $tanggal = $data2["tgl"];
          $tgl = date('d-M-Y', strtotime($tanggal));
          ?>

              <!-- tampilkan data -->
              <tr>
                <td><a href="detailsidangprop.php?id=<?= $id ?>"><?php echo $data2["nama"] ?></a></td>
                <td><?php echo $data2["judul"] ?></td>
                <td><?php echo $data2["penguji1"] ?></td>
                <td><?php echo $data2["penguji2"] ?></td>
                <!-- <td align="center">
          <?php
          $id = $data2["id_sidang"];
          $sql = mysqli_query($conn, "SELECT * FROM proposal_sidang WHERE id_sidang='$id' AND 
          status_sidang IS NULL");
          $q = mysqli_num_rows($sql);
          if ($q>0) {
            ?>
            <button class="btn-xs btn-dark" data-toggle="modal" data-target="#modalnilai"
            id="nilai"
            data-id="<?php echo $data2["id_sidang"] ?>">
            <i class="fas fa-file"></i></button>
            <?php }else{?>
              <button class="btn-xs btn-danger" data-toggle="modal" data-target="#modalnilai1"
              id="nilai1"
              data-id="<?php echo $data2["id_sidang"] ?>"
              data-status="<?php echo $data2["status"] ?>">
              <i class="fas fa-info-circle"></i></button>
              <?php } ?> -->
                </td>
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
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>
<!-- /.section 2 -->
</div>
<!-- /.content-wrapper -->
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
  // detail data mhs
  $(document).on("click", "#detaildata", function () {
    let id = $(this).data('id');
    let nama = $(this).data('nama');
    let judul = $(this).data('judul');
    let dosbing = $(this).data('dosbing');
    let tgl = $(this).data('tgl');
    let ruang = $(this).data('ruang');
    let penguji1 = $(this).data('penguji1');
    let penguji2 = $(this).data('penguji2');
    $(".modal-body #id_sidang").val(id);
    $(".modal-body #nama").val(nama);
    $(".modal-body #judul_laporan").val(judul);
    $(".modal-body #id_dosenwali").val(dosbing);
    $(".modal-body #tgl_sid").val(tgl);
    $(".modal-body #ruangsid").val(ruang);
    $(".modal-body #penguji1").val(penguji1);
    $(".modal-body #penguji2").val(penguji2);
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