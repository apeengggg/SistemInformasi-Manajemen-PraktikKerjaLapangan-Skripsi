<?php
session_start();
require "../../koneksi.php";
if (!isset($_SESSION["login_tu"])) {
header("location:../../index.php");
exit();
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Data File Skripsi | SIM-PS | Tata Usaha</title>
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
  <!-- Main content -->
  <section class="content">
    <!-- data file mahasiswa bimbingan -->
    <div class="row">
      <div class="col-12">
        <div class="card">

          <div class="card-header">
            <center>
              <h1 class="m-0 text-dark" id="all">Data File Jurnal Skripsi</h1><br>
            </center>
            <!-- <a href="#bim" class="btn btn-primary">Data File Skripsi Mahasiswa Bimbingan</a> -->
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead align="center">
                <tr>
                  <th width="80px">NIM</th>
                  <th width="170px">Nama</th>
                  <th width="150px">Judul Skripsi</th>
                  <th width="170px">Pembimbing 1</th>
                  <th width="170px">Pembimbing 2</th>
                  <th width="50px">Jurnal</th>
                </tr>
              </thead>
              <tbody>
                <?php
                        //ambi data pendaftar
                        $datapkl = mysqli_query($conn,
                        "SELECT DISTINCT 		
						            mahasiswa.nama, mahasiswa.nim,
                        judul.judul,
                        judul.studi_kasus,
                        sf.draft_pdf, sf.draft_doc, sf.jurnal_pdf, sf.jurnal_doc,
                        sf.aplikasi, sf.kartu_bim, sf.lem_pengesahan, sf.cover, sf.poster,
                        sf.id_file,
                        (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd 
                        ON d1.nidn=sd.nidn 
                        WHERE sd.id_skripsi=s.id_skripsi LIMIT 0,1) AS pem1, 
                        (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN skripsi_dosbing sd
                        ON d2.nidn=sd.nidn 
                        WHERE sd.id_skripsi=s.id_skripsi LIMIT 1,1) as pem2 
                        FROM skripsi_file sf LEFT JOIN skripsi s
                        ON sf.id_skripsi=s.id_skripsi
                        LEFT JOIN skripsi_dosbing sd
                        ON s.id_skripsi=sd.id_skripsi
                        LEFT JOIN proposal
                        ON s.id_proposal=proposal.id_proposal
                        LEFT JOIN judul
                        ON proposal.id_judul=judul.id_judul
                        LEFT JOIN mahasiswa
                        ON judul.nim=mahasiswa.nim")
                        or die (mysqli_erorr($conn));
                        if (mysqli_num_rows($datapkl) > 0) {
                        while ($data1=mysqli_fetch_array($datapkl) ) {
                        $n = $data1["id_file"];
                        $ni = base64_encode($n);
                        ?>
                <!-- tampilkan data -->
                <tr>
                  <td><?php echo $data1["nim"] ?></td>
                  <td><?php echo $data1["nama"] ?></td>
                  <td><a href="detailfileskripsi.php?id=<?=$ni?>"><?php echo $data1["judul"] ?></a></td>
                  <td><?php echo $data1["pem1"] ?></td>
                  <td><?php echo $data1["pem2"] ?></td>
                  <td align="center"><a href="assets/downloadjurnalpdf.php?filename=<?=$data1["jurnal_pdf"]?>"
                      class="btn-sm btn-info"><i class="fas fa-download"></i></a></td>
                </tr>
                <?php  }
                        }
                        ?>
              </tbody>
            </table>
          </div>
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <!-- /. data file maahsiswa bimbingan -->
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
</script>
</body>

</html>