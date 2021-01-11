<?php
session_start();
require "../../koneksi.php";
if (!isset($_SESSION["login_mhs"])) {
header("location:../../index.php");
exit();
}
$nimm = $_SESSION["nim"];
$nim = $_SESSION["nim"];
$tanggal = date('Y-m-d');
//ambil data mahasiswa
$id = mysqli_query($conn, " SELECT mhs.nama AS nama,
mhs.nim AS nim, mhs.ttl AS ttl,
mhs.alamat_rumah AS alamat, mhs.no_hp AS hp,
judul.judul,
proposal.id_proposal
FROM mahasiswa mhs
LEFT JOIN judul
ON mhs.nim=judul.nim
LEFT JOIN proposal
ON judul.id_judul=proposal.id_judul
WHERE mhs.nim='$nim' AND status_judul='Disetujui'")
or die (mysqli_error($conn));
$getid = mysqli_fetch_array($id);
// //ambil data judul
// $judul = mysqli_query($conn, "SELECT judul FROM judul WHERE nim='$nim' AND status_judul=''" ) or die (mysqli_erorr($conn));
// $data1 = mysqli_fetch_array($judul);
if (isset($_POST["sidang"])) {
$idprop = $_POST["id_proposal"];
// cek apakah sidang belum terlaksana atau sudah lulus?
$check = mysqli_query($conn, "
SELECT * FROM proposal_sidang sidang
LEFT JOIN proposal
ON sidang.id_proposal=proposal.id_proposal
LEFT JOIN judul
ON proposal.id_judul=judul.id_judul
LEFT JOIN mahasiswa
ON judul.nim=mahasiswa.nim
WHERE mahasiswa.nim='$nim' AND sidang.status_sidang='Lulus' OR sidang.status_sidang IS NULL");
if (mysqli_num_rows($check) > 0) {
echo "<script>
alert('Anda Belum Melaksanakan Sidang atau Anda Sudah Mengikuti Sidang dan Lulus !')
windows.location.href('sidangpkl.php')
</script>";
}else{
$daftar = mysqli_query($conn, "INSERT INTO proposal_sidang (id_sidang, id_proposal) VALUES ('','$idprop')") or die (mysqli_erorr($conn));
if ($daftar) {
echo "<script>
alert('Berhasil Melakukan Daftar Sidang')
windows.location.href('sidangproposal.php')
</script>";
}else {
echo "<script>
alert('Gagal Melakukan Daftar Sidang')
windows.location.href('sidangproposal.php')
</script>";
}
}
}
$getpenguji = mysqli_query($conn,
"SELECT d1.foto_dosen, proposal.dosbing, d1.nama_dosen AS pem
FROM proposal
LEFT JOIN judul
ON proposal.id_judul=judul.id_judul
LEFT JOIN mahasiswa
ON judul.nim=mahasiswa.nim
LEFT JOIN dosen d1
ON proposal.dosbing=d1.nidn
WHERE mahasiswa.nim='$nim' AND judul.status_judul='Disetujui'");
$datapenguji = mysqli_fetch_array($getpenguji)
?>

<!-- data skripsi mahasiswa -->
<?php
$getdata = mysqli_query($conn,
"SELECT mhs.nama, mhs.nim, mhs.foto, judul.judul, judul.studi_kasus
FROM mahasiswa mhs
LEFT JOIN judul
ON mhs.nim=judul.nim
WHERE mhs.nim='$nim' AND judul.status_judul='Disetujui'");
$data= mysqli_fetch_array($getdata);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Data Skripsi | SIM-PS | Mahasiswa</title>
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
  <style>
  .card-header {
  background-color: #292929;
  color: #FFFFFF;
  }
  </style>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
          </ul>
          <!-- <h1 class="m-0 text-dark">Data File Laporan Praktik Kerja Lapangan</h1> -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
          <!-- Main content -->
          <?php
          $cekjudul = mysqli_query($conn, "SELECT * FROM judul WHERE nim='$nim' AND status_judul='Disetujui'");
          if (mysqli_num_rows($cekjudul)<1) {
          
          }
          ?>
          <section class="content"> 
            <?php
            $a = mysqli_query($conn, "SELECT * FROM judul WHERE nim='$nim' AND status_judul='Disetujui'");
            if (mysqli_num_rows($a)>0) {
            ?>
            <div class="row">
              <!-- kolom penguji sidang -->
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <center>
                    <h5>Data Proposal</h5>
                    </center>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div class="card-body">
                      <table align="center" id="example1" class="table table-bordered table-striped">
                        <center>
                        <tr>
                          <td colspan="3" align="center">
                            <img src="../../assets/foto/<?= $data["foto"]?>"
                            width="140px" height="150px" alt="">
                          </td>
                        </tr>
                        <tr>
                          <td>NIM</td>
                          <td>:</td>
                          <td width="800px"><?= $data["nim"] ?></td>
                        </tr>
                        <tr>
                          <td>Nama</td>
                          <td>:</td>
                          <td><?= $data["nama"] ?></td>
                        </tr>
                        <tr>
                          <td>Judul Skripsi</td>
                          <td>:</td>
                          <td><?= $data["judul"] ?></td>
                        </tr>
                        <tr>
                          <td>Studi Kasus</td>
                          <td>:</td>
                          <td><?= $data["studi_kasus"] ?></td>
                        </tr>
                        </center>
                      </table>
                    </div>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
              <?php
              $s = mysqli_query($conn, "SELECT d.nama_dosen FROM proposal LEFT JOIN dosen d 
                                ON proposal.dosbing=d.nidn LEFT JOIN judul 
                                ON proposal.id_judul=judul.id_judul
                                LEFT JOIN mahasiswa ON judul.nim=mahasiswa.nim 
                                WHERE mahasiswa.nim='$nim'");
              if (mysqli_num_rows($s)>0) {
              ?>
              </div>
              <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <center>
                    <h5>Pembimbing</h5>
                    </center>
                  </div>
                  <div class="card-body">
                    <table align="center">
                      <tr>
                        <td colspan="3" align="center">
                          <img src="../../assets/foto/<?= $datapenguji["foto_dosen"]?>"
                          width="140px" height="150px" alt="">
                        </td>
                      </tr>
                      <tr>
                        <td>NIDN</td>
                        <td>:</td>
                        <td><?= $datapenguji["dosbing"] ?></td>
                      </tr>
                      <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td><?= $datapenguji["pem"] ?></td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
              <?php } ?>
            </div>
            <!-- /.row -->
          </section>
          <!-- /.content -->
          <?php }else{?>
            <div class="alert alert-danger" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                      </button>
                      <b>Anda Belum Memiliki Judul Yang Disetujui Atau Anda Belum Mempunyai Judul, Silahkan Ajukan Judul Terlebih Dahulu</b>
                    </div>
            <?php }?>
        </div>
        <!-- /.content-wrappeclude-- Control Sidebar -->
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
      <!-- AdminLTE for emo purposes -->
      <script src="../../dist/js/demo.js"></script>
      <!-- page scrip
      t -->
      <script>
      $(function () {
      $("#example1").DataTable();
      $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      });
      });
      // detail data mhs
      $(document).on("click", "#daftarsidang", function(){
      let id = $(this).data('id');
      let nama = $(this).data('nama');
      let nim = $(this).data('nim');
      let alamat = $(this).data('alamat');
      let ttl = $(this).data('ttl');
      let hp = $(this).data('hp');
      let judul = $(this).data('judul');
      $(".modal-body #id_proposal").val(id);
      $(".modal-body #nama").val(nama);
      $(".modal-body #nim").val(nim);
      $(".modal-body #alamat_rumah").val(alamat);
      $(".modal-body #ttl").val(ttl);
      $(".modal-body #no_hp").val(hp);
      $(".modal-body #judul_laporan").val(judul);
      });
      </script>
    </body>
  </html>