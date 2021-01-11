<?php
session_start();
if (!isset($_SESSION["login_mhs"])) {
header("location:../../index.php");
exit();
}
require "../../koneksi.php";
$nim = $_SESSION["nim"];
// ambil data bimbingan mahasiswa
// $getbim = mysqli_query($conn, "SELECT * FROM pkl_bim LEFT JOIN pkl ON pkl_bim.id_pkl=pkl.id_pkl LEFT JOIN dosen_wali ON pkl.id_dosenwali=dosen_wali.id_dosenwali LEFT JOIN dosen ON dosen_wali.nidn=dosen.nidn WHERE dosen.nidn='$nidn' AND status='Bimbingan Laporan'") or die (mysqli_erorr($conn));

// ambil id BImbingan di get
if (isset($_GET["id"])) {
$decode = base64_decode($_GET["id"]);
}
// echo $decode;
//ambi data bimbingan
$getdataa = mysqli_query($conn,
"SELECT 
m.nim, m.nama, m.foto, p.judul_laporan, d.nama_dosen,
pf.filePKL
FROM pkl_file pf LEFT JOIN pkl p 
ON pf.id_pkl=p.id_pkl
LEFT JOIN mahasiswa m
ON p.nim=m.nim
LEFT JOIN dosen_wali dw
ON p.id_dosenwali=dw.id_dosenwali
LEFT JOIN dosen d
ON dw.nidn=d.nidn
WHERE pf.id_filePKL='$decode'") or die (mysqli_erorr($conn));
$data1 = mysqli_fetch_array($getdataa);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Detail File Laporan PKL | SIM-PS | Mahsiswa</title>
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
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                <a href="filelaporanpkl.php" class="btn btn-warning">Kembali</a>
              </li>
            </ul>
            <!-- <h1 class="m-0 text-dark">Data Judul Skripsi Mahasiswa</h1> -->
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
                      <td colspan="4"><hr></td>
                      </tr>
                      <tr>
                        <td><font size="4">Nama</font></td>
                        <td><font size="4">:</font></td>
                        <td><font size="4"><?= $data1["nama"] ?></font></td>
                      </tr>
                      <tr>
                      <td colspan="4"><hr></td>
                      </tr>
                      <tr>
                        <td><font size="4">NIM</font></td>
                        <td><font size="4">:</font></td>
                        <td><font size="4"><?= $data1["nim"] ?></font></td>
                      </tr>
                      <tr>
                      <td colspan="4"><hr></td>
                      </tr>
                      <tr>
                        <td><font size="4">Pembimbing</font></td>
                        <td><font size="4">:</font></td>
                        <td><font size="4"><?= $data1["nama_dosen"] ?></font></td>
                      </tr>
                      <tr>
                      <td colspan="4"><hr></td>
                      </tr>
                      <tr>
                        <td><font size="4">Judul</font></td>
                        <td><font size="4">:</font></td>
                        <td><font size="4"><?= $data1["judul_laporan"] ?></font></td>
                      </tr>
                      <tr>
                      <td colspan="4"><hr></td>
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
                <center> <h3 class="m-0 text-dark">Detail File Laporan PKL</h3></center></div>
                  <!-- /.card-header -->
                  <div class="card-body">
                  <!-- <object data="../../assets/laporan_pkl/<?=$data1["filePKL"]?>" type="application/pdf"
                  width="100" height="500"></object> -->
                  <embed src="../../assets/laporan_pkl/<?=$data1["filePKL"]?>" type="application/pdf" width="100%" height="500"></embed>
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
                  <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
                  <!-- AdminLTE App -->
                  <script src="../../dist/js/adminlte.min.js"></script>
                  <!-- AdminLTE for demo purposes -->
                  <script src="../../dist/js/demo.js"></script>
                  <!-- page script -->
                  <script>
                  $(function () {
                  $("#example1").DataTable();
                  $('#example2').DataTable({
                  "paging": true,
                  "lengthChange": false,
                  "searching": true,
                  "ordering": false,
                  "info": true,
                  "autoWidth": false,
                  });
                  });
                  // detail data
                  $(document).on("click", "#detaildata", function(){
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
                  let desk = $(this).data('desk');
                  $("#modal-lg #id").val(id);
                  $("#modal-lg #nim").val(nim);
                  $("#modal-lg #nama").val(nama);
                  $("#modal-lg #filebim").attr("href", "assets/download.php?filename="+filebim);
                  $("#modal-lg #file_hasilbim").attr("href", "assets/downloadhasilbimpkl.php?filename="+hasilbim);
                  $("#modal-lg #pesan1").val(pesan);
                  $("#modal-lg #subjek").val(subjek);
                  $("#modal-lg #desk").val(desk);
                  $("#modal-lg #tanggal").val(tanggalbim);
                  $("#modal-lg #judul").val(judul);
                  $("#modal-lg #pembimbing").val(pembimbing);
                  $("#modal-lg #tgl_sid").val(tglsid);
                  $("#modal-lg #ruang_sid ").val(ruangsid);
                  $("#modal-lg #waktu").val(waktusid);
                  $("#modal-lg #status_bim1").val(status);
                  $("#modal-lg #foto").attr("src", "../../assets/foto/"+foto);
                  });

                  // detail data
                  $(document).on("click", "#detaildata1", function(){
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
                  let desk = $(this).data('desk');
                  $("#modal-lg1 #id").val(id);
                  $("#modal-lg1 #nim").val(nim);
                  $("#modal-lg1 #nama").val(nama);
                  $("#modal-lg1 #filebim").attr("href", "assets/download.php?filename="+filebim);
                  $("#modal-lg1 #file_hasilbim").attr("href", "assets/downloadhasilbimpkl.php?filename="+hasilbim);
                  $("#modal-lg1 #pesan").val(pesan);
                  $("#modal-lg1 #subjek").val(subjek);
                  $("#modal-lg1 #desk").val(desk);
                  $("#modal-lg1 #tanggal").val(tanggalbim);
                  $("#modal-lg1 #judul").val(judul);
                  $("#modal-lg1 #pembimbing").val(pembimbing);
                  $("#modal-lg1 #tgl_sid").val(tglsid);
                  $("#modal-lg1 #ruang_sid ").val(ruangsid);
                  $("#modal-lg1 #waktu").val(waktusid);
                  $("#modal-lg1 #status_bim1").val(status);
                  $("#modal-lg1 #status_bim2").val(status);
                  $("#modal-lg1 #hasilbim2").val(hasilbim);
                  $("#modal-lg1 #foto").attr("src", "../../assets/foto/"+foto);
                  });
                  </script>
                </body>
              </html>