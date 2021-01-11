<?php
session_start();
if (!isset($_SESSION["login_pa"])) {
header("location:../../index.php");
exit();
}
require "../../koneksi.php";
$nidn = $_SESSION["nidn"];
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <title>Data Skripsi | SIM-PS | Penasihat Akademik</title>
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
  <?php include 'assets/header.php'; ?>
  <style>
  thead{
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
                  <div class="card-header">
                  <center>  <h1 class="m-0 text-dark" id="semua">Data Skripsi</h1><br></center>
                  <!-- <button type="submit" class="btn btn-warning" data-toggle="modal" data-target="#modal-md"><i class="fas fa-print"></i> Cetak Laporan</button> -->
                    <!-- <a href="#bim" class="btn btn-primary">Mahasiswa Bimbingan</a> -->
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead align="center">
                        <tr>
                          <!-- <th width="70px">Foto</th> -->
                          <th width="55px">NIM</th>
                          <th width="200px">Nama</th>
                          <th width="200px">Judul</th>
                          <th width="200px">Pembimbing1</th>
                          <th width="200px">Pembimbing2</th>
                          <th width="10px">Status</th>
                          <!-- <th>Aksi</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $getdata = mysqli_query($conn,
                        "SELECT 
                        (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd 
                        ON d1.nidn=sd.nidn 
                        WHERE sd.id_skripsi=s.id_skripsi LIMIT 0,1) AS pem1, 
                        (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN skripsi_dosbing sd
                        ON d2.nidn=sd.nidn 
                        WHERE sd.id_skripsi=s.id_skripsi LIMIT 1,1) as pem2, 
                        mhs.nama, mhs.nim, mhs.status_skripsi, judul.judul 
                        FROM skripsi s INNER JOIN proposal 
                        ON s.id_proposal=proposal.id_proposal 
                        INNER JOIN judul 
                        ON proposal.id_judul=judul.id_judul 
                        INNER JOIN mahasiswa mhs
                        ON judul.nim=mhs.nim 
                        WHERE judul.status_judul='Disetujui'")
                        or die (mysqli_erorr($conn));
                        if (mysqli_num_rows($getdata) > 0) {
                        while ($data=mysqli_fetch_array($getdata)) {
                        ?>
                        <tr>
                          <!-- <td>
                            <center>
                            <img src="../../assets/foto/<?= $data['foto'] ?> "alt="" width="50px" height="50px">
                            </center>
                          </td> -->
                          <td><?= $data['nim'] ?></td>
                          <td><?= $data['nama'] ?></td>
                          <td><?= $data['judul']?></td>
                          <td><?= $data['pem1']?></td>
                          <td><?= $data['pem2']?></td>
                          <td><?= $data['status_skripsi']?></td>
                          <!-- <td><button class="btn-xs btn-dark" id="edit"
                              data-toggle="modal" data-target="#modal1"
                              data-id="<?= $data['id_skripsi']?>"
                              data-id="<?= $data['pem1']?>"
                              data-id="<?= $data['pem2']?>"><i class="fas fa-edit"></i></button>
                              <button class="btn-xs btn-warning"><i class="fas fa-info-circle"></i></button>
                          </td> -->
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
            </script>
          </body>
        </html>