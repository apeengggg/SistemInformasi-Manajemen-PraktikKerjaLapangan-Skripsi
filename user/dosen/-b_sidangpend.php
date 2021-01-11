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
 // mahasiswa bimbingnan
$mhsbim = mysqli_query($conn,
                        "SELECT DISTINCT mhs.nama, mhs.nim,
                        judul.judul,
                        -- pembimbing 1
                        (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd 
                        ON d1.nidn=sd.nidn 
                        WHERE sd.id_skripsi=s.id_skripsi AND status_dosbing='Pembimbing 1'
                        AND sd.status='Aktif' LIMIT 0,1) AS pem1, 
                        -- pembimbing2
                        (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN skripsi_dosbing sd
                        ON d2.nidn=sd.nidn 
                        WHERE sd.id_skripsi=s.id_skripsi AND status_dosbing='Pembimbing 2'
                        AND sd.status='Aktif' LIMIT 0,1) as pem2,
                        -- data sdaing
                        ps.tgl_sidang AS tgl,
                        ps.waktu_sidang AS waktu,
                        ps.ruang_sidang AS ruang, ps.id_sidang,
                        ps.status_sidang AS status,
                        -- penguji 1
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
                        LEFT JOIN skripsi_dosbing sd
                        ON s.id_skripsi=sd.id_skripsi
                        LEFT JOIN proposal
                        ON s.id_proposal=proposal.id_proposal
                        LEFT JOIN judul 
                        ON proposal.id_judul=judul.id_judul
                        LEFT JOIN mahasiswa mhs
                        ON judul.nim=mhs.nim
                        LEFT JOIN pend_penguji ppe
                        ON ps.id_sidang=ppe.id_sidang
                        WHERE sd.nidn='$nidn' AND ppe.status='Aktif' GROUP BY mhs.nim") 
                        or die (mysqli_error($conn));

if (isset($_POST["nilai1"])) {
  $id = $_POST["id"];
  $ids = $_POST["ids"];
  $cekpem = mysqli_query($conn, "SELECT DISTINCT status_dosbing FROM skripsi_dosbing sd LEFT JOIN dosen d
                        ON sd.nidn=d.nidn LEFT JOIN skripsi s ON sd.id_skripsi=s.id_skripsi 
                        WHERE sd.nidn='$nidn' AND s.id_skripsi='$ids'");
  $q = mysqli_fetch_array($cekpem);
  $w = $q["status_dosbing"];
  if ($w == 'Pembimbing 1') {
  $id = $_POST["id"]; 
  $npm1 = $_POST["npm1"];
  $npm2 = $_POST["npm2"];
  $sis = $_POST["sistematika"];
  // $hasil = $_POST["hasilsidang"];
  $ap = $_POST["aplikasi"];
  // var_dump($_POST); die;
  $send = mysqli_query($conn, "UPDATE pend_nilai SET dos1_pen='$npm1', dos1_peng='$npm2', 
                      dos1_sis='$sis', dos1_ap='$ap' WHERE id_sidang='$id'");
  if ($send) {
  echo "<script>
  alert('Nilai Berhasil Diinput !')
  windows.location.href='b_sidangpend.php'
  </script>";
  }else {
  echo "<script>
  alert('Nilai gagal diinput !')
  windows.location.href='b_sidangpend.php'
  </script>";
  }
}else{
  $id = $_POST["id"];
  $npm1 = $_POST["npm1"];
  $npm2 = $_POST["npm2"];
  $sis = $_POST["sistematika"];
  // $hasil = $_POST["hasilsidang"];
  $ap = $_POST["aplikasi"];
  // var_dump($_POST); die;
  $send = mysqli_query($conn, "UPDATE pend_nilai SET dos2_pen='$npm1', dos2_peng='$npm2', 
  dos2_sis='$sis', dos2_ap='$ap' WHERE id_sidang='$id'");
  if ($send) {
  echo "<script>
  alert('Nilai Berhasil Diinput !')
  windows.location.href='b_sidangpend.php'
  </script>";
  }else {
  echo "<script>
  alert('Nilai gagal diinput !')
  windows.location.href='b_sidangpend.php'
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
          <!-- <h1 class="m-0 text-dark">Data Pendaftaran Sidang PKL</h1> -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
    <!-- data jadwal pengujian sidang -->
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <center>
              <h2 class="m-0 text-dark" id="jad">Data Jadwal Sidang Mahasiswa Bimbingan</h2><br>
            </center>
            <!-- <a href="#bim" class="btn btn-primary">Data Sidang Mahasiswa Bimbingan</a> -->
            <!-- <a href="#all" class="btn btn-primary">Data Sidang Seluruh Mahasiswa</a> -->
          </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead align="center">
                <tr>
                  <th width="80px">NIM</th>
                  <th width="200px">Nama</th>
                  <th width="100px">Waktu</th>
                  <th width="200px">Penguji 1</th>
                  <th width="200px">Penguji 2</th>
                  <th width="150px">Ruang</th>
                  <th width="50px">Nilai</th>
                </tr>
              </thead>
              <tbody>
                <?php
                        //ambi data pendaftar
                        $datasidang2 = mysqli_query($conn,
                        "SELECT DISTINCT mhs.nama, mhs.nim,
                        j.judul, s.id_skripsi,
                        ps.status_sidang AS status,
                        ps.tgl_sidang AS tgl,
                        ps.waktu_sidang AS waktu,
                        ps.ruang_sidang AS ruang, ps.id_sidang, ps.status_sidang,
                        -- ambil data penguji1
                        (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN pend_penguji ppe
                        ON d1.nidn=ppe.penguji 
                        WHERE ppe.id_sidang=ps.id_sidang AND status_penguji='Penguji 1'
                        AND ppe.status='Aktif' LIMIT 0,1) AS penguji1, 
                        -- ambil data penguji2
                        (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN pend_penguji ppe
                        ON d2.nidn=ppe.penguji 
                        WHERE ppe.id_sidang=ps.id_sidang AND status_penguji='Penguji 2'
                        AND ppe.status='Aktif' LIMIT 0,1) as penguji2,
                        pn.dos1_pen AS dos1p1, pn.dos1_peng AS dos1p11, pn.dos1_sis AS dos1sis, pn.dos1_ap AS dos1ap,
                        pn.dos2_pen AS dos2p1, pn.dos2_peng AS dos2p11, pn.dos2_sis AS dos2sis, pn.dos2_ap AS dos2ap,
                        pn.peng1_pen AS peng1p1, pn.peng1_peng AS peng1p11, pn.peng1_sis AS peng1sis, pn.peng1_ap AS peng1ap,
                        pn.peng2_pen AS peng2p1, pn.peng2_peng AS peng2p11, pn.peng2_sis AS peng2sis, pn.peng2_ap As peng2ap
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
                        LEFT JOIN pend_nilai pn
                        ON ps.id_sidang=pn.id_sidang
                        LEFT JOIN skripsi_dosbing sd
                        ON s.id_skripsi=sd.id_skripsi
                        LEFT JOIN dosen d
                        ON sd.nidn=d.nidn
                        WHERE sd.nidn='$nidn' AND ps.tgl_sidang='$date' ORDER BY ps.tgl_sidang DESC")
                        or die (mysqli_erorr($conn));
                        if (mysqli_num_rows($datasidang2) > 0) {
                        while ($data2=mysqli_fetch_array($datasidang2) ) {
                        $nama = $data2["nim"];
                        $id = base64_encode($nama); 
                        $tanggal = $data2["tgl"];
                        $tgl = date("d-M-Y", strtotime($tanggal));
                        ?>
                <!-- tampilkan data -->
                <tr>
                  <td><?php echo $data2["nim"] ?></td>
                  <td><a href="detailsidangpend.php?id=<?= $id ?>"><?php echo $data2["nama"] ?></a></td>
                  <td align="center"><?= $tgl ?><br>
                    <?php echo $data2["waktu"] ?></td>
                  <td><?php echo $data2["penguji1"] ?></td>
                  <td><?php echo $data2["penguji2"] ?></td>
                  <td><?php echo $data2["ruang"] ?></td>
                  <td align="center">
                    <?php
                          $id = $data2["id_sidang"];
                          $sql = mysqli_query($conn, "SELECT * FROM pend_nilai WHERE id_sidang='$id' AND 
                          (dos1_pen IS NULL AND dos1_peng IS NULL AND dos1_sis IS NULL OR
                          dos2_pen IS NULL AND dos2_peng IS NULL AND dos2_sis IS NULL)");
                          $q = mysqli_num_rows($sql);
                          if ($q>0) {
                          ?>
                    <button class="btn-xs btn-dark" data-toggle="modal" data-target="#modalnilai" id="nilai"
                      data-id="<?php echo $data2["id_sidang"] ?>" data-ids="<?php echo $data2["id_skripsi"] ?>">
                      <i class="fas fa-file"></i></button>
                    <?php }else{?>
                    <!-- <button class="btn-xs btn-danger" data-toggle="modal" data-target="#modalnilai1"
                          id="nilai1"
                          data-id="<?php echo $data2["id_sidang"] ?>"
                          data-ids="<?php echo $data2["id_skripsi"] ?>"
                          data-peng1p1="<?php echo $data2["peng1p1"] ?>"
                          data-peng1p11="<?php echo $data2["peng1p11"] ?>"
                          data-peng1sis="<?php echo $data2["peng1sis"] ?>"
                          data-peng1ap="<?php echo $data2["peng1ap"] ?>"
                          data-peng2p1="<?php echo $data2["peng2p1"] ?>"
                          data-peng2p11="<?php echo $data2["peng2p11"] ?>"
                          data-peng2sis="<?php echo $data2["peng2sis"] ?>"
                          data-peng2ap="<?php echo $data2["peng2ap"] ?>"
                          data-status="<?php echo $data2["status_sid"] ?>">
                          <i class="fas fa-info-circle"></i></button> -->
                    <?php } ?>
                    <button class="btn-xs btn-danger" data-toggle="modal" data-target="#modalnilai1" id="nilai1"
                      data-id="<?php echo $data2["id_sidang"] ?>" data-ids="<?php echo $data2["id_skripsi"] ?>"
                      data-peng1pen="<?php echo $data2["dos1p1"] ?>" data-peng1peng="<?php echo $data2["dos1p11"] ?>"
                      data-peng1sis="<?php echo $data2["dos1sis"] ?>" data-peng1ap="<?php echo $data2["dos1ap"] ?>"
                      data-peng2pen="<?php echo $data2["dos2p1"] ?>" data-peng2peng="<?php echo $data2["dos2p11"] ?>"
                      data-peng2sis="<?php echo $data2["dos2sis"] ?>" data-peng2ap="<?php echo $data2["dos2ap"] ?>"
                      data-status="<?php echo $data2["status_sidang"] ?>">
                      <i class="fas fa-info-circle"></i></button>
                  </td>
                  <?php } ?>
                  </td>
                </tr>
                <?php  
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
  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <center>
              <h2 class="m-0 text-dark" id="penguji">Jadwal Pengujian Sidang Pendadaran Mahasiswa Bimbingan</h2><br>
            </center>
            <!-- <a href="#bim" class="btn btn-primary">Data Sidang Mahasiswa Bimbingan</a>
                    <a href="#all" class="btn btn-primary">Semua Data Sidang Mahasiswa</a> -->
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
                  <th width="80px">NIM</th>
                  <th width="200px">Nama</th>
                  <th width="200px">Judul</th>
                </tr>
              </thead>
              <tbody>
                <?php
                        if (mysqli_num_rows($mhsbim) > 0) {
                        while ($data1=mysqli_fetch_array($mhsbim) ) {
                        $nim1 = $data1["nim"]; 
                        $id1 = base64_encode($nim1);
                        ?>
                <!-- tampilkan data -->
                <tr>
                  <td><?php echo $data1["nim"] ?></td>
                  <td><a href="detailsidangpend.php?id=<?= $id1 ?>"><?php echo $data1["nama"] ?></a></td>
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
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.section 2 -->

  <!-- modal tambah bimbingan -->
  <div class="modal fade" id="modalnilai">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Form Nilai Sidang Pendadaran</h4>
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
                <input type="text" class="form-control" id="ids" name="ids" hidden>
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
                <input type="number" class="form-control" id="sistematika" name="sistematika" max="100" min="0"
                  required>
              </div>
              <div class="form-row">
                <label for="sistematika">Nilai Penanggungjawaban Aplikasi</label>
                <input type="number" class="form-control" id="aplikasi" name="aplikasi" max="100" min="0" required>
              </div>
              <!-- <div class="form-row"> 
                                    <label for="hasilsidang">Hasil Sidang</label>
                                    <select name="hasilsidang" id="hasilsidang" class="form-control">
                                    <option disabled selected>Pilih Hasil Sidang..</option>
                                    <option value="Lulus">Lulus</option>
                                    <option value="Tidak Lulus">Tidak Lulus</option></select>
                                </div> -->
              <!-- /.card-body -->
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="nilai1"
                id="nilai1">Kirim</button>
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
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Nilai Sidang Pendadaran</h4>
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
                  <label for="npm1">Nilai Penyampaian Materi Pembimbing 1</label>
                  <input type="number" class="form-control" id="pen_penguji1" name="pen_penguji1" max="100" min="0"
                    readonly>
                </div>
                <div class="form-group col-md-6">
                  <label for="npm11">Nilai Penyampaian Materi Pembimbing 2</label>
                  <input type="number" class="form-control" id="pen_penguji2" name="pen_penguji2" max="100" min="0"
                    readonly>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="npm2">Nilai Penguasaan Pembimbing 1</label>
                  <input type="number" class="form-control" id="peng_penguji1" name="peng_penguji1" max="100" min="0"
                    readonly>
                </div>
                <div class="form-group col-md-6">
                  <label for="npm22">Nilai Penguasaan Materi Pembimbing 2</label>
                  <input type="number" class="form-control" id="peng_penguji2" name="peng_penguji2" max="100" min="0"
                    readonly>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="sistematika">Nilai Sistematika Penulisan Pembimbing 1</label>
                  <input type="number" class="form-control" id="sis_penguji1" name="sis_penguji1" max="100" min="0"
                    readonly>
                </div>
                <div class="form-group col-md-6">
                  <label for="sistematika1">Nilai Sitematika Penulisan Pembimbing 2</label>
                  <input type="number" class="form-control" id="sis_penguji2" name="sis_penguji2" max="100" min="0"
                    readonly>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="sistematika">Nilai Penanggungjawaban Aplikasi Pembimbing 1</label>
                  <input type="number" class="form-control" id="ap_penguji1" name="ap_penguji1" max="100" min="0"
                    readonly>
                </div>
                <div class="form-group col-md-6">
                  <label for="sistematika1">Nilai Penanggungjawaban Aplikasi Pembimbing 2</label>
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
          </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
    </div>
  </div>
  <!-- /.modal -->
  <!-- modal tambah bimbingan -->
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