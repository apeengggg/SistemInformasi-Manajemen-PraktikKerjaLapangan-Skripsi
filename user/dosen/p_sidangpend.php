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
$datee = date('d-M-Y', strtotime($date));
$jadwalsidang = mysqli_query($conn,
"SELECT mhs.nama, mhs.nim,
judul.judul,
-- pembimbing 1
(SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd 
ON d1.nidn=sd.nidn 
WHERE sd.id_skripsi=s.id_skripsi AND status_dosbing='Pembimbing 1'
AND sd.status='Aktif' LIMIT 0,1) AS pem1, 
-- pembimbing2
(SELECT d2.nama_dosen FROM dosen d2 INNER JOIN skripsi_dosbing sd
ON d2.nidn=sd.nidn 
WHERE sd.id_skripsi=s.id_skripsi  AND status_dosbing='Pembimbing 2'
AND sd.status='Aktif' LIMIT 0,1) as pem2,
-- data sdaing
ps.tgl_sidang AS tgl,
ps.waktu_sidang AS waktu,
ps.ruang_sidang AS ruang, ps.id_sidang,
ps.status_sidang AS status_sidang, s.id_skripsi,
-- penguji 1
(SELECT d1.nama_dosen FROM dosen d1 INNER JOIN pend_penguji ppe
ON d1.nidn=ppe.penguji 
WHERE ppe.id_sidang=ps.id_sidang AND status_penguji='Penguji 1'
AND ppe.status='Aktif 'LIMIT 0,1) AS penguji1, 
-- ambil data penguji2
(SELECT d2.nama_dosen FROM dosen d2 INNER JOIN pend_penguji ppe
ON d2.nidn=ppe.penguji 
WHERE ppe.id_sidang=ps.id_sidang AND status_penguji='Penguji 2'
AND ppe.status='Aktif 'LIMIT 0,1) as penguji2,
pn.dos1_pen AS dos1p1, pn.dos1_peng AS dos1p11, pn.dos1_sis AS dos1sis, pn.dos1_ap AS dos1ap,
pn.dos2_pen AS dos2p1, pn.dos2_peng AS dos2p11, pn.dos2_sis AS dos2sis, pn.dos2_ap AS dos2ap,
pn.peng1_pen AS peng1p1, pn.peng1_peng AS peng1p11, pn.peng1_sis AS peng1sis, pn.peng1_ap AS peng1ap,
pn.peng2_pen AS peng2p1, pn.peng2_peng AS peng2p11, pn.peng2_sis AS peng2sis, pn.peng2_ap As peng2ap
FROM pend_sidang ps 
LEFT JOIN skripsi s
ON ps.id_skripsi=s.id_skripsi
LEFT JOIN proposal
ON s.id_proposal=proposal.id_proposal
LEFT JOIN judul 
ON proposal.id_judul=judul.id_judul
LEFT JOIN mahasiswa mhs
ON judul.nim=mhs.nim
LEFT JOIN pend_penguji ppe
ON ps.id_sidang=ppe.id_sidang
LEFT JOIN pend_nilai pn
ON ps.id_sidang=pn.id_sidang
WHERE ppe.penguji='$nidn' AND ps.tgl_sidang='$date' ORDER BY ps.tgl_sidang DESC") 
or die (mysqli_error($conn)); 

$jadwalsidang1 = mysqli_query($conn,
"SELECT DISTINCT mhs.nama, mhs.nim,
j.judul,
ps.status_sidang AS status,
ps.tgl_sidang AS tgl,
ps.waktu_sidang AS waktu,
ps.ruang_sidang AS ruang, ps.id_sidang,
-- ambil data penguji1
(SELECT d1.nama_dosen FROM dosen d1 INNER JOIN pend_penguji ppe
ON d1.nidn=ppe.penguji 
WHERE ppe.id_sidang=ps.id_sidang AND status_penguji='Penguji 1'
AND ppe.status='Aktif' LIMIT 0,1) AS penguji1, 
-- ambil data penguji2
(SELECT d2.nama_dosen FROM dosen d2 INNER JOIN pend_penguji ppe
ON d2.nidn=ppe.penguji 
WHERE ppe.id_sidang=ps.id_sidang AND status_penguji='Penguji 2'
AND ppe.status='Aktif' LIMIT 0,1) as penguji2
FROM pend_sidang ps 
LEFT JOIN skripsi s
ON ps.id_skripsi=s.id_skripsi
LEFT JOIN proposal p
ON s.id_proposal=p.id_proposal
LEFT JOIN judul j
ON p.id_judul=j.id_judul
LEFT JOIN mahasiswa mhs
ON j.nim=mhs.nim
LEFT JOIN pend_penguji ppe
ON ps.id_sidang=ppe.id_sidang
WHERE ppe.penguji='$nidn' GROUP BY mhs.nim") 
or die (mysqli_error($conn));

// if (isset($_POST["nilai1"])) {
//   $id = $_POST["id"];
//   $ids = $_POST["ids"];
//   $cekpem = mysqli_query($conn, "SELECT DISTINCT status_penguji FROM draft_penguji dp LEFT JOIN dosen d
//   ON dp.penguji=d.nidn LEFT JOIN draft_sidang ds ON dp.id_sidang=ds.id_sidang 
//   WHERE dp.penguji='$nidn' AND ds.id_sidang='$id'");
//   $q = mysqli_fetch_array($cekpem);
//   $w = $q["status_penguji"];
//   if ($w == 'Penguji 1') {
//     $id = $_POST["id"];
//     $npm1 = $_POST["npm1"];
//     $npm2 = $_POST["npm2"];
//     $sis = $_POST["sistematika"];
//     $hasil = $_POST["hasilsidang"];
//     $ap = $_POST["aplikasi"];
//     // var_dump($_POST); die;
//     $send = mysqli_query($conn, "UPDATE pend_nilai SET peng1_pen='$npm1', peng1_peng='$npm2', 
//     peng1_sis='$sis', peng1_ap='$ap' WHERE id_sidang='$id'");
//     $sql = mysqli_query($conn, "UPDATE draft_sidang SET status_sidang='$hasil' WHERE id_sidang='$id'");
//     if ($send && $sql) {
//       echo "<script>
//       alert('Nilai Berhasil Diinput !')
//       windows.location.href='p_sidangpend.php'
//       </script>";
//     }else {
//       echo "<script>
//       alert('Nilai gagal diinput !')
//       windows.location.href='p_sidangpend.php'
//       </script>";
//     }
//   }else{
//     $id = @$_POST["id"];
//     $npm1 = @$_POST["npm1"];
//     $npm2 = @$_POST["npm2"];
//     $sis = @$_POST["sistematika"];
//     $hasil = @$_POST["hasilsidang"];
//     $ap = @$_POST["aplikasi"];
//     // var_dump($_POST); die;
//     $send = mysqli_query($conn, "UPDATE pend_nilai SET peng2_pen='$npm1', peng2_peng='$npm2', 
//     peng2_sis='$sis', peng2_ap='$ap' WHERE id_sidang='$id'");
//     $sql = mysqli_query($conn, "UPDATE pend_sidang SET status_sidang='$hasil' WHERE id_sidang='$id'");
//     if ($send && $sql) {
//       echo "<script>
//       alert('Nilai Berhasil Diinput !')
//       windows.location.href='p_sidangpend.php'
//       </script>";
//     }else {
//       echo "<script>
//       alert('Nilai gagal diinput !')
//       windows.location.href='p_sidangpend.php'
//       </script>";
//     }
//   }
// }
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Data Sidang Pendadaran | SIM-PS | Dosen</title>
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
          <!-- <h2 class="m-0 text-dark">Data Pendaftaran Sidang PKL</h2> -->
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
              <h2 class="m-0 text-dark" id="penguji">Jadwal Pengujian Sidang Pendadaran, <?=$datee?></h2><br>
            </center>
            <!-- <a href="#bim" class="btn btn-primary">Data Sidang Mahasiswa Bimbingan</a> -->
            <!-- <a href="#all" class="btn btn-primary">Semua Data Sidang Mahasiswa</a> -->
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
                  <th width="250px">Nama</th>
                  <th width="200px">Judul</th>
                  <th width="110px">Waktu</th>
                  <th>Ruangan</th>
                  <th width="180px">Penguji 1</th>
                  <th width="180px">Penguji 2</th>
                  <!-- <th width="50px">Nilai</th> -->
                </tr>
              </thead>
              <tbody>
                <?php
if (mysqli_num_rows($jadwalsidang) > 0) {
  while ($data1=mysqli_fetch_array($jadwalsidang) ) {
    $nim = $data1["nim"]; 
    $id = base64_encode($nim);
    $d = $data1["tgl"];
    $tgl = date('d-M-Y', strtotime($d));
    ?>

                <!-- tampilkan data -->
                <tr>
                  <td><a href="detailsidangpend.php?id=<?= $id ?>"><?php echo $data1["nama"] ?></a></td>
                  <td><?php echo $data1["judul"] ?></td>
                  <td align="center"><?php echo $tgl ?><br><?php echo $data1["waktu"] ?></td>

                  <td align="center"><?php echo $data1["ruang"] ?></td>
                  <td><?php echo $data1["penguji1"] ?></td>
                  <td><?php echo $data1["penguji2"] ?></td>
                  <!-- <td align="center">
                    <?php
    $id = $data1["id_sidang"];
    $sql = mysqli_query($conn, "SELECT * FROM pend_nilai WHERE id_sidang='$id' AND 
    (peng1_pen IS NULL AND peng1_peng IS NULL AND peng1_sis IS NULL OR
    peng2_pen IS NULL AND peng2_peng IS NULL AND peng2_sis IS NULL)");
    $q = mysqli_num_rows($sql);
    if ($q>0) {
      ?>
                    <button class="btn-xs btn-dark" data-toggle="modal" data-target="#modalnilai" id="nilai"
                      data-id="<?php echo $data1["id_sidang"] ?>" data-ids="<?php echo $data1["id_skripsi"] ?>">
                      <i class="fas fa-file"></i></button>
                    <?php }else{?> -->
                    <!-- <button class="btn-xs btn-danger" data-toggle="modal" data-target="#modalnilai1"
        id="nilai1"
        data-id="<?php echo $data1["id_sidang"] ?>"
        data-ids="<?php echo $data1["id_skripsi"] ?>"
        data-peng1p1="<?php echo $data1["peng1p1"] ?>"
        data-peng1p11="<?php echo $data1["peng1p11"] ?>"
        data-peng1sis="<?php echo $data1["peng1sis"] ?>"
        data-peng1ap="<?php echo $data1["peng1ap"] ?>"
        data-peng2p1="<?php echo $data1["peng2p1"] ?>"
        data-peng2p11="<?php echo $data1["peng2p11"] ?>"
        data-peng2sis="<?php echo $data1["peng2sis"] ?>"
        data-peng2ap="<?php echo $data1["peng2ap"] ?>"
        data-status="<?php echo $data1["status_sid"] ?>">
        <i class="fas fa-info-circle"></i></button> -->
                    <!-- <?php } ?>
                    <button class="btn-xs btn-danger" data-toggle="modal" data-target="#modalnilai1" id="nilai1"
                      data-id="<?php echo $data1["id_sidang"] ?>" data-ids="<?php echo $data1["id_skripsi"] ?>"
                      data-peng1pen="<?php echo $data1["peng1p1"] ?>" data-peng1peng="<?php echo $data1["peng1p11"] ?>"
                      data-peng1sis="<?php echo $data1["peng1sis"] ?>" data-peng1ap="<?php echo $data1["peng1ap"] ?>"
                      data-peng2pen="<?php echo $data1["peng2p1"] ?>" data-peng2peng="<?php echo $data1["peng2p11"] ?>"
                      data-peng2sis="<?php echo $data1["peng2sis"] ?>" data-peng2ap="<?php echo $data1["peng2ap"] ?>"
                      data-status="<?php echo $data1["status_sidang"] ?>">
                      <i class="fas fa-info-circle"></i></button>
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

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <!-- <h2 class="m-0 text-dark" id="penguji">Jadwal Pengujian Sidang Draft</h2> -->
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
              <h2 class="m-0 text-dark" id="penguji">Riwayat Pengujian Sidang Pendadaran</h2><br>
            </center>
            <button type="submit" class="btn btn-warning" data-toggle="modal" data-target="#modal-md"><i
                class="fas fa-print"> Cetak</i></button>
            <!-- <a href="#bim" class="btn btn-primary">Data Sidang Mahasiswa Bimbingan</a> -->
            <!-- <a href="#all" class="btn btn-primary">Semua Data Sidang</a> -->
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
                  <th width="180px">Penguji 1</th>
                  <th width="180px">Penguji 2</th>
                </tr>
              </thead>
              <tbody>
                <?php
      if (mysqli_num_rows($jadwalsidang1) > 0) {
        while ($data2=mysqli_fetch_array($jadwalsidang1) ) {
          $nim = $data2["nim"]; 
          $idd = $data2["id_sidang"]; 
          $id = base64_encode($nim);
          ?>

                <!-- tampilkan data -->
                <tr>
                  <td><a href="detailsidangdraft.php?id=<?= $id ?>"><?php echo $data2["nama"] ?></a></td>
                  <td><?php echo $data2["judul"] ?></td>
                  <td><?php echo $data2["penguji1"] ?></td>
                  <td><?php echo $data2["penguji2"] ?></td>
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
          <h4 class="modal-title">Form Nilai Sidang Draft</h4>
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
                <input type="text" class="form-control" id="ids" name="ids">
              </div>
              <div class="form-row">
                <label for="npm1">Nilai Penyampaian Materi</label>
                <input type="number" class="form-control" id="npm1" name="npm1" max="100" min="0">
              </div>
              <div class="form-row">
                <label for="npm2">Nilai Penguasaan Materi</label>
                <input type="number" class="form-control" id="npm2" name="npm2" max="100" min="0">
              </div>
              <div class="form-row">
                <label for="sistematika">Nilai Sistematika Penulisan</label>
                <input type="number" class="form-control" id="sistematika" name="sistematika" max="100" min="0">
              </div>
              <div class="form-row">
                <label for="sistematika">Nilai Penanggungjawaban Aplikasi</label>
                <input type="number" class="form-control" id="aplikasi" name="aplikasi" max="100" min="0">
              </div>
              <div class="form-row">
                <label for="hasilsidang">Hasil Sidang</label>
                <select name="hasilsidang" id="hasilsidang" class="form-control" required>
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
                <input type="text" class="form-control" id="id" name="id">
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="npm1">Nilai Penyampaian Materi Penguji 1</label>
                  <input type="number" class="form-control" id="pen_penguji1" name="pen_penguji1" max="100" min="0"
                    readonly>
                </div>
                <div class="form-group col-md-6">
                  <label for="npm11">Nilai Penyampaian Materi Penguji 2</label>
                  <input type="number" class="form-control" id="pen_penguji2" name="pen_penguji2" max="100" min="0"
                    readonly>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="npm2">Nilai Penguasaan Penguji 1</label>
                  <input type="number" class="form-control" id="peng_penguji1" name="peng_penguji1" max="100" min="0"
                    readonly>
                </div>
                <div class="form-group col-md-6">
                  <label for="npm22">Nilai Penguasaan Materi Penguji 2</label>
                  <input type="number" class="form-control" id="peng_penguji2" name="peng_penguji2" max="100" min="0"
                    readonly>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="sistematika">Nilai Sistematika Penulisan Penguji 1</label>
                  <input type="number" class="form-control" id="sis_penguji1" name="sis_penguji1" max="100" min="0"
                    readonly>
                </div>
                <div class="form-group col-md-6">
                  <label for="sistematika1">Nilai Sitematika Penulisan Penguji 2</label>
                  <input type="number" class="form-control" id="sis_penguji2" name="sis_penguji2" max="100" min="0"
                    readonly>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="sistematika">Nilai Penanggungjawaban Aplikasi Penguji 1</label>
                  <input type="number" class="form-control" id="ap_penguji1" name="ap_penguji1" max="100" min="0"
                    readonly>
                </div>
                <div class="form-group col-md-6">
                  <label for="sistematika1">Nilai Penanggungjawaban Aplikasi Penguji 2</label>
                  <input type="number" class="form-control" id="ap_penguji2" name="ap_penguji2" max="100" min="0"
                    readonly>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="hasilsidang">Hasil Sidang</label>
                  <input type="text" class="form-control" id="hasilsidang" name="hasilsidang" readonly>
                </div>
              </div>
            </div>
          </form> -->
          <!-- /.modal-content -->
        <!-- </div> -->
        <!-- /.modal-dialog -->
      <!-- </div>
    </div>
  </div> -->
  <!-- /.modal -->
<!-- </div> -->
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
        <form class="form-horizontal" method="post" action="assets/reportpend.php">
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
    let ds = $(this).data('ids');
    $("#modalnilai #id").val(d);
    $("#modalnilai #ids").val(ds);
  });

  /// detail data
  $(document).on("click", "#nilai1", function () {
    let d = $(this).data('id');
    let peng1pen = $(this).data('peng1pen');
    let peng1peng = $(this).data('peng1peng');
    let peng1sis = $(this).data('peng1sis');
    let peng1ap = $(this).data('peng1ap');
    let peng2pen = $(this).data('peng2pen');
    let peng2peng = $(this).data('peng2peng');
    let peng2sis = $(this).data('peng2sis');
    let peng2ap = $(this).data('peng2ap');
    let hasil = $(this).data('status');
    $("#modalnilai1 #id").val(d);
    $("#modalnilai1 #pen_penguji1").val(peng1pen);
    $("#modalnilai1 #peng_penguji1").val(peng1peng);
    $("#modalnilai1 #sis_penguji1").val(peng1sis);
    $("#modalnilai1 #ap_penguji1").val(peng1ap);
    $("#modalnilai1 #hasilsidang").val(hasil);
    $("#modalnilai1 #pen_penguji2").val(peng2pen);
    $("#modalnilai1 #peng_penguji2").val(peng2peng);
    $("#modalnilai1 #sis_penguji2").val(peng2sis);
    $("#modalnilai1 #ap_penguji2").val(peng2ap);
  });
</script>
</body>

</html>