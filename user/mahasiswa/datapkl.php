<?php
session_start();
require "../../koneksi.php";
if (!isset($_SESSION["login_mhs"])) {
header("location:../../index.php");
exit();
}
$nimm = $_SESSION["nim"];
$nim = $_SESSION["nim"];
//ambil data pkl

$get = mysqli_query($conn, 
  "SELECT pkl.nim, 
  mahasiswa.nama, 
  dosen_wali.id_dosenwali, 
  dosen.foto_dosen,
  dosen.nidn, 
  dosen.nama_dosen, 
  pkl.judul_laporan, 
  pkl.instansi, 
  pkl.surat_balasan,
  pkl.id_pkl 
  FROM pkl LEFT JOIN mahasiswa 
  ON pkl.nim=mahasiswa.nim 
  LEFT JOIN dosen_wali 
  ON pkl.id_dosenwali=dosen_wali.id_dosenwali
  LEFT JOIN dosen 
  ON dosen_wali.nidn=dosen.nidn WHERE pkl.nim='$nim'") or die (mysqli_error($conn));
$datapkl = mysqli_fetch_array($get);
//tambah PKL
if (isset($_POST["tambahpkl"])) {
$judul = $_POST["judulpkl"];
$instansi = $_POST["instansi"];
$surat = $_FILES["suratbalasan"]["name"];
$ukuran = $_FILES["suratbalasan"]["size"];
// var_dump($surat); die;
$ptgnim = substr($nim, -1);
if (empty($surat)) {
$inputpkl = mysqli_query($conn, "INSERT INTO pkl (judul_laporan, instansi, nim, id_dosenwali)
VALUES ('$judul','$instansi', '$nim', '$ptgnim')") or die (mysqli_error($conn));
if ($inputpkl) {
echo "<script>
alert('Data PKL berhasil diinput!')
windows.location.href('datapkl.php')
</script>";
}else {
echo "<script>
alert('Gagal menambahkan Data PKL!')
windows.location.href('datapkl.php')
</script>";
}  
}else { 
$ekstensi = array("pdf");
$get_eks = explode(".", $surat);
$eks1 = $get_eks[1];
$suratbaru = $nim.'-'.$namefile.'-'.$surat;
$pathsurat = "../../assets/surat_balasan/".$suratbaru;
if (in_array($eks1, $ekstensi)) {
  if ($ukuran > 100000) {
    echo "<script>
alert('Maximal File Size 100KB')
windows.location.href('datapkl.php')
</script>";
  }else{
$tmp_surat = $_FILES["suratbalasan"]["tmp_name"];
if (move_uploaded_file($tmp_surat, $pathsurat)) {
  $inputpkl = mysqli_query($conn, "INSERT INTO pkl (judul_laporan, instansi, nim, id_dosenwali, surat_balasan)
VALUES ('$judul','$instansi', '$nim', '$ptgnim', '$suratbaru')") or die (mysqli_error($conn));
if ($inputpkl) {
echo "<script>
alert('Data PKL berhasil diinput!')
windows.location.href('datapkl.php')
</script>";
}else {
echo "<script>
alert('Gagal menambahkan Data PKL!')
windows.location.href('datapkl.php')
</script>";
        }
      }else {
        echo "<script>
alert('Gagal mengunggah surat!')
windows.location.href('datapkl.php')
</script>";
      }
    }
  }else {
    echo "<script>
alert('Surat yang anda unggah harus ber-Ekstensi PDF!')
windows.location.href('datapkl.php')
</script>";
  }
}
  }

if (isset($_POST["unggah"])) {
$ekstensi1 = array("pdf");
$id_pkl = $_POST["id_pkl"];
$suratbaru1 = $_FILES["surat_balasan"]["name"];
$ukuran = $_FILES["surat_balasan"]["size"];
$potong = explode(".", $suratbaru1); 
$ambil = $potong[1];
$dot = "-";
$newsurat = $nim.$dot.$namefile.$dot.$suratbaru1;
$pathsurat1 = "../../assets/surat_balasan/".$newsurat;
if (in_array($ambil, $ekstensi1)) {
  if ($ukuran > 100000) {
    echo "<script>
    alert('Maximal File Size 100KB)
    windows.location.href('datapkl.php')
    </script>";
  }else{
  $surat_baru_tmp = $_FILES["surat_balasan"]["tmp_name"];
  if (move_uploaded_file($surat_baru_tmp, $pathsurat1)) {
    $masuk = mysqli_query($conn, "UPDATE pkl SET surat_balasan='$newsurat'") or die (mysqli_erorr($conn));
    if ($masuk) {
      echo "<script>
alert('Surat berhasil diunggah!')
windows.location.href('datapkl.php')
</script>";
    }else {
      echo "<script>
alert('Surat gagal diunggah!')
windows.location.href('datapkl.php')
</script>";
    }
  }else {
    echo "<script>
alert('Gagal mengunggah surat!')
windows.location.href('datapkl.php')
</script>";
    }
  }
}else {
  echo "<script>
alert('Surat yang anda unggah harus ber-Ekstensi PDF!')
windows.location.href('datapkl.php')
</script>";
}
}

if (isset($_POST["ubahdataa"])) {
  $surat_lama = $datapkl["surat_balasan"];
  $surat_baru = $_FILES["surat_balasan"]["name"];
  $ukuran = $_FILES["surat_balasan"]["size"];
  $id_new = $_POST["id_pkl"];
  $judul_baru = $_POST["judul_laporan"];
  $instansi_baru = $_POST["instansi"];
  if (empty($surat_baru)) {
  $masuk2 = mysqli_query($conn, "UPDATE pkl SET judul_laporan='$judul_baru', instansi='$instansi_baru' WHERE id_pkl='$id_new'") or die (mysqli_erorr($conn));
  if ($masuk2) {
  echo "<script>
alert('Data berhasil diubah!')
windows.location.href('datapkl.php')
</script>";  
  }else {
    echo "<script>
alert('Data gagal diubah')
windows.location.href('datapkl.php')
</script>";
  }
}else {
  $ekstensi5 = array("pdf");
  $ambil_eks5 = explode(".", $surat_baru);
  $eks = $ambil_eks5[1];
  // var_dump($ambil_eks5); 
  // var_dump($eks); die;
  $name = $nim."-".$namefile.'-'.$surat_baru;
  $pathnew = "../../assets/surat_balasan/".$name;
if (in_array($eks, $ekstensi5)) {
  if ($ukuran > 100000) {
    echo "<script>
alert('Maximal File Size 100 KB')
windows.location.href('datapkl.php')
</script>";
  }else{
  $surat_tmp = $_FILES["surat_balasan"]["tmp_name"];
  if (move_uploaded_file($surat_tmp, $pathnew)) {
    unlink('../../assets/surat_balasan/'.$surat_lama);
    $masuk3 = mysqli_query($conn, "UPDATE pkl SET judul_laporan='$judul_baru', instansi='$instansi_baru' , surat_balasan='$name' WHERE id_pkl='$id_new'") or die (mysqli_erorr($conn));
    if ($masuk3) {
      echo "<script>
alert('Data berhasil di ubah!')
windows.location.href('datapkl.php')
</script>";
    }else {
      echo "<script>
alert('Data gaagl di ubah!')
windows.location.href('datapkl.php')
</script>";
    }
  }else {
    echo "<script>
alert('Surat yang anda unggah harus ber-Ekstensi PDF!')
windows.location.href('datapkl.php')
</script>";
    }
  }
}else {
  echo "<script>
alert('Surat yang anda unggah harus ber-Ekstensi PDF!')
windows.location.href('datapkl.php')
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
    <title>SIM-PS | Data PKL | Mahasiswa</title>
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
            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content">
              <!-- /.row -->
              <!-- Main row -->
              <div class="row">
                <!-- Left col -->
                <?php
                $anypkl = mysqli_query($conn, "SELECT * FROM pkl WHERE nim='$nim'") or die (mysqli_error($anypkl));
                if (mysqli_num_rows($anypkl) == 0) {
                ?>
                <section class="col-lg-6">
                  <div class="card card-info">
                    <div class="card-header">
                      <h3 class="card-title">Form Data PKL</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal" method="post" enctype="multipart/form-data">
                      <div class="card-body">
                        <div class="form-group row">
                          <label for="judulpkl" class="col-sm-3 col-form-label">Judul Laporan</label>
                          <div class="col-sm-9">
                            <textarea class="form-control" rows="3" placeholder="Judul Laporan PKL" name="judulpkl" id="judulpkl" required="required"></textarea>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="instansi" class="col-sm-3 col-form-label">Instansi</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="instansi" name="instansi" placeholder="Instansi Dilakukan PKL" required="required">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="suratbalasan" class="col-sm-3 col-form-label">Surat Balasan</label>
                          <div class="col-sm-9">
                            <input type="file" id="suratbalasan" name="suratbalasan" class="form-control-file">
                          </div>
                        </div>
                      </div>
                      <!-- /.card-body -->
                      <div class="card-footer">
                        <button type="submit" class="btn btn-info float-right" name="tambahpkl" id="tambahpkl">Tambah Data</button>
                      </div>
                      <!-- /.card-footer -->
                    </form>
                  </div>
                </section>
                <?php }else{ ?>
                <?php 
                $ceksurat = mysqli_query($conn, "SELECT surat_balasan FROM pkl WHERE nim='$nim' AND surat_balasan IS NULL");
                if (mysqli_num_rows($ceksurat)===1) {
                   ?>
                    <div class="card-header">
                      <div class="alert alert-danger" role="alert">
                      <b>Anda Belum Mengunggah Surat Balasan Instansi</b> Silahkan Unggah Surat Balasan Dari Instansi Tempat Dimana Anda Melakukan Praktik Kerja Lapangan  <button class="btn-sm btn-warning" data-toggle="modal" data-target="#modal1" id="surat" data-id="<?= $datapkl["id_pkl"] ?>"> Disini</button>
                    </div>
                    </div>
                  <?php } ?>
                <section class="col-lg-6">
                  <div class="card card-info">
                  <div class="card-header">
                    <h5>Data Praktik Kerja Lapangan</h5>
                  </div>
                    <!-- form start -->
                    <form class="form-horizontal" method="post" enctype="multipart/form-data">
                      <div class="card-body">
                        <div class="form-group row">
                          <label for="nim" class="col-sm-3 col-form-label">NIM</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $datapkl["nim"] ?>" readonly>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $datapkl["nama"] ?>" readonly>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="judulpkl" class="col-sm-3 col-form-label">Judul Laporan</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="judulpkl" name="judulpkl" value="<?= $datapkl["judul_laporan"]?>"  readonly>
                            <!-- <textarea name="judulpkl" id="judulpkl" cols="10" rows="2" value="<?= $datapkl["judul_laporan"]?>" readonly>
                            </textarea> -->
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="instansi" class="col-sm-3 col-form-label">Instansi</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="instansi" name="instansi" value="<?php echo $datapkl["instansi"] ?>" readonly>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="suratbalasan" class="col-sm-3 col-form-label">Surat Balasan</label>
                          <div class="col-sm-9">
                            <?php 
                            if (mysqli_num_rows($ceksurat)===0) {
                            ?>
                            <a href="assets/download.php?filename=<?=$datapkl["surat_balasan"]?>" class="btn-sm btn-primary">Unduh</a>
                          <?php }else {
                            ?>
                            <label for="suratbalasan" class="col-sm-12 col-form-label">Surat Belum Diunggah</label>
                          <?php } ?>
                          </div>
                        </div>
                      </div>
                      <!-- /.card-body -->
                      <!-- <div class="card-footer"> -->
                      <!-- <button type="submit" class="btn btn-info float-right" name="ubahfoto" id="ubahfoto">Tambah Data</button> -->
                      <!-- </div> -->
                      <!-- /.card-footer -->
                    </form>
                  <div class="card-footer">
                    <button class="btn btn-primary" id="ubahdata" data-toggle="modal" data-target="#modal2"
                    data-id="<?= $datapkl["id_pkl"] ?>"
                    data-judul="<?= $datapkl["judul_laporan"] ?>"
                    data-instansi="<?= $datapkl["instansi"] ?>"
                    data-surat="<?= $datapkl["surat_balasan"] ?>">Ubah</button>
                  </div>
                  </div>
                </section>

                <!-- dosbing -->
                <section class="col-lg-6">
                  <div class="card card-info">
                    <!-- form start -->
                    <form class="form-horizontal" method="post" enctype="multipart/form-data">
                      <div class="card-header">
                        <h5>Dosen Pembimbing</h5>
                      </div>
                      <div class="card-body">
                        <div class="form-group row">
                          <div class="col-sm-12">
                            <center>
                            <img src="../../assets/foto/<?= $datapkl["foto_dosen"] ?>" alt="" width="140px" height="150px">
                          </center>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="nim" class="col-sm-3 col-form-label">NIDN</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $datapkl["nidn"] ?>" readonly>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="nama" class="col-sm-3 col-form-label">Pembimbing</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $datapkl["nama_dosen"] ?>" readonly>
                          </div>
                        </div>
                      </div>
                      <!-- /.card-body -->
                      <!-- <div class="card-footer"> -->
                      <!-- <button type="submit" class="btn btn-info float-right" name="ubahfoto" id="ubahfoto">Tambah Data</button> -->
                      <!-- </div> -->
                      <!-- /.card-footer -->
                    </form>
                  </div>
                </section>
                <!-- /.dosbing -->
                <!-- right col -->
              </div>
              <!-- /.row (main row) -->
              <?php } ?>
              <!-- modal tambah surat baalsann -->
                  <div class="modal fade" id="modal2">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Form Ubah Data PKL</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="card-body">
                              <div class="form-group row">
                                  <div class="col-sm-9">
                                    <input type="text" class="form-control" id="id_pkl" name="id_pkl" required="required" hidden readonly >
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="judul" class="col-sm-3 col-form-label">Judul Laporan</label>
                                  <div class="col-sm-9">
                                    <input type="text" class="form-control" id="judul_laporan" name="judul_laporan" required="required" >
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="instansi" class="col-sm-3 col-form-label">Instansi</label>
                                  <div class="col-sm-9">
                                    <input type="text" class="form-control" id="instansi" name="instansi" required="required" >
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="nama" class="col-sm-3 col-form-label">Surat Balasan</label>
                                  <div class="col-sm-9">
                                    <input type="file" id="surat_balasan" name="surat_balasan">
                                    <br>
                                    <small><b>PDF, Max File Size 100 KB</b></small>
                                    <a href="" class="btn btn-primary" id="surat_balasan">Unduh</a>
                                  </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="ubahdataa" id="ubahdataa">Ubah</button>
                          </div>
                        </div>
                      </form>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>
                  <!-- /.modal tambah surat baalsann -->

                  <!-- modal ubah data pkl -->
                  <div class="modal fade" id="modal1">
                    <div class="modal-dialog modal-md">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Form Unggah Surat Balasan</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="card-body">
                              <div class="form-group row">
                                  <div class="col-sm-9">
                                    <input type="text" class="form-control" id="id_pkl" name="id_pkl" required="required" hidden readonly>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="nama" class="col-sm-3 col-form-label">Surat Balasan</label>
                                  <div class="col-sm-9">
                                    <input type="file" id="surat_balasan" name="surat_balasan" required="required" readonly>
                                    <br>
                                    <small><b>PDF, Maximal File Size 100 KB</b></small>
                                  </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="unggah" id="unggah">Unggah</button>
                          </div>
                        </div>
                      </form>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>
                  <!-- /.modal ubah data pkl -->

              </div><!-- /.container-fluid -->
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
        
        <script type="text/javascript">
          $(document).on("click", "#surat", function(){
          let id = $(this).data('id');
          $("#modal1 #id_pkl").val(id);
          });

          $(document).on("click", "#ubahdata", function(){
          let id = $(this).data('id');
          let judul = $(this).data('judul');
          let instansi = $(this).data('instansi');
          let surat = $(this).data('surat');
          $("#modal2 #id_pkl").val(id);
          $("#modal2 #judul_laporan").val(judul);
          $("#modal2 #instansi").val(instansi);
          $("#modal2 #surat_balasan").attr("href", "assets/download.php?filename="+surat);
          });
        </script>
      </body>
    </html>