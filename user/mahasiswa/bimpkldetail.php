<?php
session_start();
if (!isset($_SESSION["login_mhs"])) {
header("location:../../index.php");
exit();
}
require "../../koneksi.php";
$nim = $_SESSION["nim"];
// ambil data bimbingan mahasiswa
$getbim = mysqli_query($conn, "SELECT * FROM bimpkl WHERE nim='$nim'") or die (mysqli_erorr($conn));
if (isset($_GET["id_bimPKL"])) {
$idbim = $_GET["id_bimPKL"];
$getdata = mysqli_query($conn, "SELECT mahasiswa.nim, mahasiswa.nama, mahasiswa.foto, pkl.judul_laporan, pkl.instansi, dosen.nidn ,dosen.nama_dosen, bimpkl.subjek, bimpkl.deskripsi, bimpkl.tanggal, bimpkl.file_bim, bimpkl.file_hasilbim, bimpkl.pesan, bimpkl.status_bim FROM mahasiswa JOIN pkl ON mahasiswa.nim=pkl.nim JOIN bimpkl ON pkl.id_pkl=bimpkl.id_pkl JOIN dosen ON bimpkl.nidn=dosen.nidn JOIN dosen_wali ON dosen_wali.nidn = dosen.nidn WHERE bimpkl.id_bimPKL='$idbim'")
or die (mysqli_erorr($conn));
if (mysqli_num_rows($getdata) == 0) {
echo "
<script>
alert('data tidak ada dalam database !')
</script>";
exit();
}else {
$databim = mysqli_fetch_array($getdata);
}
}
// cek bales belum ?
$replybel = mysqli_query($conn, "SELECT * FROM bimpkl WHERE id_bimPKL='$idbim' AND file_hasilbim IS NOT NULL") or die (mysqli_erorr($replybel));
if ( mysqli_num_rows($replybel) > 0) {
if (isset($_POST["detail"])) {
//ubah status dibaca
$read = 'Dibaca';
$ubah = mysqli_query($conn, "UPDATE bimpkl SET status_mhs='$read' WHERE id_bimPKL='$idbim'") or die (mysqli_erorr($conn));
}
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIM-PS | Detail Bimbingan | Kaprodi</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="../../plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="../../plugins/summernote/summernote-bs4.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  </head>
  <?php include 'assets/header.php'; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Detail Bimbingan PKL</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Detail Bimbingan PKL</a></li>
                <li class="breadcrumb-item active">Mahasiswa</li>
              </ol>
              </div><!-- /.col -->
              </div><!-- /.row -->
              </div><!-- /.container-fluid -->
              </div>                  <!-- /.content-header -->
              <!-- Main content -->
              <section class="content">
                <div class="row">
                  <div class="col-7">
                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">Detail PKL Mahasiswa</h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                        <table align="center">
                          <tr>
                            <td rowspan="4" align="center">
                              <img src="../../assets/foto/<?php echo $databim["foto"] ?>" alt="" height="200" width="160">
                            </td>
                          </tr>
                        </table>
                        <hr>
                        <table>
                          <tr>
                            <td>NIM</td>
                            <td>:</td>
                            <td>
                              <input type="text" value="<?php echo $databim["nim"] ?>" disabled>
                            </td>
                          </tr>
                          <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td>
                              <input type="text" value="<?php echo $databim["nama"] ?>" disabled>
                            </td>
                          </tr>
                          <tr>
                            <td>Pembimbing</td>
                            <td>:</td>
                            <td>
                              <input type="text" value="<?php echo $databim["nama_dosen"] ?>" disabled>
                            </td>
                          </tr>
                          <tr>
                            <td>Instansi</td>
                            <td>:</td>
                            <td>
                              <input type="text" value="<?php echo $databim["instansi"] ?>" style="width:500px;" disabled>
                            </td>
                          </tr>
                          <tr>
                            <td>Judul</td>
                            <td>:</td>
                            <td>
                              <input type="text" value="<?php echo $databim["judul_laporan"] ?>" style="width:500px;" disabled>
                            </td>
                          </tr>
                        </table>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->
                </div>
                <!--balas-->
                <div class="col-5">
                  <div class="card">
                    <div class="card-header">
                      <h2 class="card-title">Detail Bimbingan Laporan PKL</h2>
                      <div class="card-tools">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-lg">
                        Ubah
                        </button>
                      </div>
                    </div>
                    <div class="modal fade" id="modal-lg">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Bimbingan PKL</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form class="form-horizontal" method="post" enctype="multipart/form-data">
                              <div class="card-body">
                                <div class="form-group row">
                                  <label for="subjek" class="col-sm-3 col-form-label">Subjek</label>
                                  <div class="col-sm-9">
                                    <input type="text" class="form-control" id="subjek" name="subjek" placeholder="BAB 1" required="required">
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi</label>
                                  <div class="col-sm-9">
                                    <textarea class="form-control" rows="3" placeholder="Pesan" name="deskripsi" id="deskripsi" required="required"></textarea>
                                  </div>
                                </div>
                              </div>
                              <!-- /.card-body -->
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                              <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="bimbingan" id="bimbingan">Kirim</button>
                            </div>
                          </div>
                        </form>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                       <table>
                          <tr>
                            <td>Subjek</td>
                            <td>:</td>
                            <td>
                              <input type="text" value="<?php echo $databim["subjek"] ?>" readonly>
                            </td>
                          </tr>
                          <tr>
                            <td>Deskripsi</td>
                            <td>:</td>
                            <td>
                              <input type="text" value="<?php echo $databim["deskripsi"] ?>" readonly>
                            </td>
                          </tr>
                          <tr>
                            <td>Tanggal</td>
                            <td>:</td>
                            <td>
                              <input type="text" value="<?php echo $databim["tanggal"] ?>" readonly>
                            </td>
                          </tr>
                          <tr>
                            <td>File Bimbingan</td>
                            <td>:</td>
                            <td>
                              <a href="download.php?filename=<?=$databim["file_bim"]?>">Unduh</a>
                            </td>
                          </tr>
                          <?php
                          //cek sudah ada balasan ?
                          $cekreply = mysqli_query($conn, "SELECT * FROM bimpkl WHERE nim='$nim' AND file_hasilbim IS NOT NULL") or die (mysqli_erorr($conn));
                          if (mysqli_num_rows($cekreply) < 1) {
                          ?>
                          <?php   } ?>
                        </table>
                        <hr>
                        <?php
                        // kalo belum dibales
                        $cekreply2 = mysqli_query($conn, "SELECT * FROM bimpkl WHERE nim='$nim' AND file_hasilbim IS NULL OR file_hasilbim=''") or die (mysqli_erorr($conn));
                        if (mysqli_num_rows($cekreply2) == 1){
                        ?>
                        <table>
                          <tr>
                            <td>Status Laporan</td>
                            <td>:</td>
                            <td>
                              <input type="text" value="<?php echo $databim["status_bim"] ?>" disabled>
                            </td>
                          </tr>
                          <tr>
                            <td>Pesan</td>
                            <td>:</td>
                            <td>
                              <input type="text" value="<?php echo $databim["pesan"] ?>" disabled>
                            </td>
                          </tr>
                          <tr>
                            <td>Hasil Bimbingan</td>
                            <td>:</td>
                            <td>
                              <a href="download.php?filename=<?=$databim["file_hasilbim"]?>">Unduh</a>
                            </td>
                          </tr>
                        </table>
                      </form>
                      <?php   } ?>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->
                </div>
              </div>
            </section>
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
        <!-- jQuery UI 1.11.4 -->
        <script src="../../plugins/jquery-ui/jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
        $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- ChartJS -->
        <script src="../../plugins/chart.js/Chart.min.js"></script>
        <!-- Sparkline -->
        <script src="../../plugins/sparklines/sparkline.js"></script>
        <!-- JQVMap -->
        <script src="../../plugins/jqvmap/jquery.vmap.min.js"></script>
        <script src="../../plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
        <!-- jQuery Knob Chart -->
        <script src="../../plugins/jquery-knob/jquery.knob.min.js"></script>
        <!-- daterangepicker -->
        <script src="../../plugins/moment/moment.min.js"></script>
        <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
        <!-- Summernote -->
        <script src="../../plugins/summernote/summernote-bs4.min.js"></script>
        <!-- overlayScrollbars -->
        <script src="../../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
        <!-- AdminLTE App -->
        <script src="../../dist/js/adminlte.js"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="../../dist/js/pages/dashboard.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="../../dist/js/demo.js"></script>
        
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
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        });
        });
        </script>
      </body>
    </html>