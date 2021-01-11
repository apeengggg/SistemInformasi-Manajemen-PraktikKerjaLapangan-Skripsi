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
                        WHERE proposal.dosbing='$nidn' GROUP BY mhs.nim") 
                        or die (mysqli_error($conn));
                        
$jadwal = mysqli_query($conn,
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
                        WHERE proposal.dosbing='$nidn' AND ps.tgl_sidang='$date'") 
                        or die (mysqli_error($conn));
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
  <!-- Main content -->
  <section class="content">
    <!-- data jadwal pengujian sidang -->
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
              <!-- <h2 class="m-0 text-dark">Data Pendaftaran Sidang PKL</h2> -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <center>
              <h2 class="m-0 text-dark" id="jad">Data Jadwal Sidang Proposal Mahasiswa Bimbingan</h2><br>
            </center>
            <!-- <a href="#bim" class="btn btn-primary">Data Sidang Mahasiswa Bimbingan</a> -->
            <!-- <a href="#all" class="btn btn-primary">Data Sidang Seluruh Mahasiswa</a> -->
          </div>
          <div class="card-body">
            <table id="example5" class="table table-bordered table-striped">
              <thead align="center">
                <tr>
                  <th width="100px">NIM</th>
                  <th width="200px">Nama</th>
                  <th width="200px">Judul</th>
                  <th width="100px">Waktu</th>
                  <th width="200px">Penguji 1</th>
                  <th width="200px">Penguji 2</th>
                  <th width="150px">Ruang</th>
                  <!-- <th>Nilai</th> -->
                </tr>
              </thead>
              <tbody>
                <?php
                    if (mysqli_num_rows($jadwal) > 0) {
                      while ($data2=mysqli_fetch_array($jadwal) ) {
                        $nama = $data2["nim"];
                        $id = base64_encode($nama); 
                        $tanggal = $data2["tgl_sidang"];
                        $tgl = date("d-M-Y", strtotime($tanggal));
                  ?>
                <!-- tampilkan data -->
                <tr>
                  <td><?php echo $data2["nim"] ?></td>
                  <td><?php echo $data2["nama"] ?></td>
                  <td><?php echo $data2["judul"] ?><br>
                  <td align="center"><?= $tgl ?><br>
                    <?php echo $data2["waktu"] ?></td>
                  <td><?php echo $data2["penguji1"] ?></td>
                  <td><?php echo $data2["penguji2"] ?></td>
                  <td><?php echo $data2["ruang"] ?></td>
                  <!-- <td align="center">
                    <?php
                          $id = $data2["id"];
                          $sql = mysqli_query($conn, "SELECT * FROM pkl_nilai WHERE id_sidang='$id' AND 
                          pem_pen_mat IS NULL AND pem_peng_mat IS NULL AND pem_sis IS NULL");
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
                  </td> -->
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
              <h2 class="m-0 text-dark" id="jad">Data Riwayat Sidang Mahasiswa Bimbingan</h2><br>
            </center>
            <!-- <a href="#bim" class="btn btn-primary"></a>
                  <a href="#all" class="btn btn-primary">Data Sidang Semua Mahasiswa</a> -->
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
                  <td><a href="detailsidangprop.php?id=<?= $id1 ?>"><?php echo $data1["nama"] ?></a></td>
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
</script>
</body>

</html>