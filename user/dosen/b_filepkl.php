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
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Data File Laporan PKL | SIM-PS | Dosen</title>
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
              <h1 class="m-0 text-dark">Data File Laporan PKL Mahasiswa Bimbingan</h1>
            </center>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example3" class="table table-bordered table-striped">
              <thead align="center">
                <tr>
                  <th width="80px">NIM</th>
                  <th width="200px">Nama</th>
                  <th width="200px">Judul Laporan</th>
                  <th width="150px">Instansi</th>
                  <th width="50px"> File</th>
                  <!-- <th>Aksi</th> -->
                </tr>
              </thead>
              <tbody>
                <?php
                        //ambi data pendaftar
                        $datapkl = mysqli_query($conn,
                        "SELECT m.nama, m.nim,
                        dosen.nama_dosen, 
                        p.judul_laporan,
                        p.instansi,
                        pf.filePKL, pf.id_filePKL 
                        FROM 
                        pkl_file pf LEFT JOIN pkl p ON pf.id_pkl=p.id_pkl
                        LEFT JOIN dosen_wali dw ON p.id_dosenwali=dw.id_dosenwali
                        LEFT JOIN dosen ON dw.nidn=dosen.nidn
                        LEFT JOIN mahasiswa m ON p.nim=m.nim
                        WHERE dosen.nidn='$nidn'")
                        or die (mysqli_erorr($conn));

                        if (mysqli_num_rows($datapkl) > 0) {
                        while ($data1=mysqli_fetch_array($datapkl) ) {
                        $n = $data1["id_filePKL"];
                        $ni = base64_encode($n);
                        ?>

                <!-- tampilkan data -->
                <tr>
                  <td><?php echo $data1["nim"] ?></td>
                  <td><?php echo $data1["nama"] ?></td>
                  <td><a href="detailfilepkl.php?id=<?=$ni?>"><?php echo $data1["judul_laporan"] ?></a></td>
                  <td><?php echo $data1["instansi"] ?></td>
                  <td align="center"><a href="assets/downloadfile.php?filename=<?=$data1["filePKL"]?>"
                      class="btn btn-info"><i class="fas fa-download"></i></a></td>
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

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <center>
              <h1 class="m-0 text-dark">Data File Laporan PKL Mahasiswa</h1>
            </center>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead align="center">
                <tr>
                  <th width="80px">NIM</th>
                  <th width="200px">Nama</th>
                  <th width="200px">Pembimbing</th>
                  <th width="200px">Judul Laporan</th>
                  <th width="150px">Instansi</th>
                  <th width="50px"> File</th>
                  <!-- <th>Aksi</th> -->
                </tr>
              </thead>
              <tbody>
                <?php
                        //ambi data pendaftar
                        $datapkl = mysqli_query($conn,
                        "SELECT m.nama, m.nim,
                        dosen.nama_dosen, dosen.nama_dosen,
                        p.judul_laporan,
                        p.instansi,
                        pf.filePKL, pf.id_filePKL 
                        FROM 
                        pkl_file pf LEFT JOIN pkl p ON pf.id_pkl=p.id_pkl
                        LEFT JOIN dosen_wali dw ON p.id_dosenwali=dw.id_dosenwali
                        LEFT JOIN dosen ON dw.nidn=dosen.nidn
                        LEFT JOIN mahasiswa m ON p.nim=m.nim")
                        or die (mysqli_erorr($conn));

                        if (mysqli_num_rows($datapkl) > 0) {
                        while ($data1=mysqli_fetch_array($datapkl) ) {
                        $n = $data1["id_filePKL"];
                        $ni = base64_encode($n);
                        ?>

                <!-- tampilkan data -->
                <tr>
                  <td><?php echo $data1["nim"] ?></td>
                  <td><?php echo $data1["nama"] ?></td>
                  <td><?php echo $data1["nama_dosen"] ?></td>
                  <td><a href="detailfilepkl.php?id=<?=$ni?>"><?php echo $data1["judul_laporan"] ?></a></td>
                  <td><?php echo $data1["instansi"] ?></td>
                  <td align="center"><a href="assets/downloadfile.php?filename=<?=$data1["filePKL"]?>"
                      class="btn btn-info"><i class="fas fa-download"></i></a></td>
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
</script>
</body>

</html>