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
//ambil id_pkl
$id = mysqli_query($conn, "SELECT pkl.id_pkl FROM pkl JOIN mahasiswa ON mahasiswa.nim=pkl.nim WHERE mahasiswa.nim='$nim'") or die (mysqli_error($conn));
$getid = mysqli_fetch_array($id);

if (isset($_POST["unggah"])) {
  $ekstensi = array("pdf");
  $file = $_FILES["filePKL"]["name"];
  $ukuran = $_FILES["filePKL"]["size"];
  $ambil_ekstensi = explode(".", $file);
  $eks = $ambil_ekstensi[1];
  $newfile = $nim.'-'.$namefile.'-'.$file;
  $id=$getid["id_pkl"];
  $pathlemrev= '../../assets/laporan_pkl/'.$newfile;
  if (in_array($eks, $ekstensi)) {
    if ($ukuran > 10000000) {
      echo "<script>
      alert('Maximal File Size 10 MB')
      windows.location.href='filelaporanpkl.php'
      </script>"; 
    }else{
      $file_tmp = $_FILES["filePKL"]["tmp_name"];
      if (move_uploaded_file($file_tmp, $pathlemrev)) {
        $insertlem = mysqli_query($conn, "INSERT INTO pkl_file 
        (id_pkl, filePKL) 
        VALUES ('$id', '$newfile')") or die (mysqli_erorr($conn)); 
        if ($insertlem) {
          echo "<script>
          alert('Berhasil Mengunggah file!')
          windows.location.href='filelaporanpkl.php'
          </script>";     
        }else {
          echo "<script>
          alert('Gagal Mengunggah file!')
          windows.location.href='filelaporanpkl.php'
          </script>";
        }    
      }else {
        echo "<script>
        alert('Gagal Mengunggah file!')
        windows.location.href='filelaporanpkl.php'
        </script>";
      }
    }
  }else{
    echo "<script>
    alert('File yang diupload bukan PDF !!')
    windows.location.href='filelaporanpkl.php'
    </script>";
  }  
}

// ubah file
if (isset($_POST["ubah"])) {
  $file_lama = $_POST["nama"];
  $ekstensi = array("pdf");
  $file = $_FILES["filePKL"]["name"];
  $ukuran = $_FILES["filePKL"]["size"];
  $ambil_ekstensi = explode(".", $file);
  $eks = $ambil_ekstensi[1];
  $newfile = $nim.'-'.$namefile.'-'.$file;
  $id=$_POST["id"];
  $pathlemrev= '../../assets/laporan_pkl/'.$newfile;
  if (in_array($eks, $ekstensi)) {
    if ($ukuran > 10000000) {
      echo "<script>
      alert('Maximal File Size 10 MB')
      windows.location.href='filelaporanpkl.php'
      </script>"; 
    }else{
      $file_tmp = $_FILES["filePKL"]["tmp_name"];
      unlink('../../assets/laporan_pkl/'.$file_lama);
      if (move_uploaded_file($file_tmp, $pathlemrev)) {
        $insertlem = mysqli_query($conn, "UPDATE pkl_file 
        SET filePKL='$newfile' 
        WHERE id_filePKL='$id'") or die (mysqli_erorr($conn)); 
        if ($insertlem) {
          echo "<script>
          alert('Berhasil Mengubah File!')
          windows.location.href='filelaporanpkl.php'
          </script>";     
        }else {
          echo "<script>
          alert('Gagal Mengubah File!')
          windows.location.href='filelaporanpkl.php'
          </script>";
        }    
      }else {
        echo "<script>
        alert('Gagal Mengunggah File!')
        windows.location.href='filelaporanpkl.php'
        </script>";
      }
    }
  }else{
    echo "<script>
    alert('File yang diupload bukan PDF !!')
    windows.location.href='filelaporanpkl.php'
    </script>";
  }  
}  


?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Data File Laporan PKL | SIM-PS | Mahasiswa</title>
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
<style>
  thead {
    background-color: #292929;
    color: #FFFFFF;
  }
</style>
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
  <?php
$cekdatapkl = mysqli_query($conn, "SELECT * FROM pkl_bim WHERE nim='$nim' AND status='Bimbingan Pasca'
AND status_bim='Layak'");
if (mysqli_num_rows($cekdatapkl)<1) {
  ?>
  <center>
    <div class="alert alert-danger" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <b>Bimbingan Pasca Sidang Anda Belum Layak, Silahkan Hubungi Dosen Penguji Anda Untuk Mengunggah File Laporan
        PKL</b>
    </div>
  </center>
  <?php }else{
    ?>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <center>
              <h3 class="m-0 text-dark">Data File Laporan Praktik Kerja Lapangan Mahasiswa</h3>
          </div>
          </center>
          <!-- cek sudah diunggah belum laporan? -->
          <?php
    $cekfile=mysqli_query($conn, 
    "SELECT dosen.nama_dosen, 
    pkl.judul_laporan, 
    pkl_file.filePKL 
    FROM pkl_file INNER JOIN pkl
    ON pkl_file.id_pkl=pkl.id_pkl
    INNER JOIN dosen_wali
    ON pkl.id_dosenwali=dosen_wali.id_dosenwali
    INNER JOIN dosen 
    ON dosen_wali.nidn=dosen.nidn
    WHERE pkl.nim='$nim' AND pkl_file.filePKL IS NOT NULL");
    if (mysqli_num_rows($cekfile)===0) {
      ?>
          <div class="card-header">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-lg">
              <i class="fas fa-upload"></i> Unggah
            </button>
          </div>
          <?php } ?>

          <!-- /.card-header -->
          <div class="card-body">
            <!-- cek file ta sudah diunggah belum -->
            <?php 
      $cekfile=mysqli_query($conn, 
      "SELECT dosen.nama_dosen, 
      pkl.judul_laporan, 
      pkl_file.filePKL 
      FROM pkl_file INNER JOIN pkl
      ON pkl_file.id_pkl=pkl.id_pkl
      INNER JOIN dosen_wali
      ON pkl.id_dosenwali=dosen_wali.id_dosenwali
      INNER JOIN dosen 
      ON dosen_wali.nidn=dosen.nidn
      WHERE pkl.nim='$nim' AND pkl_file.filePKL IS NULL");
      if (mysqli_num_rows($cekfile)===0) {
        ?>
            <table id="example1" class="table table-bordered table-striped">
              <thead align="center">
                <tr>
                  <th width="250px">Pembimbing</th>
                  <th width="350px">Judul Laporan</th>
                  <th width="50px">File</th>
                  <th width="50px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
        //ambi data bimbingan
        $getdata = mysqli_query($conn,
        "SELECT dosen.nama_dosen, 
        pkl.judul_laporan, 
        pkl_file.filePKL, .pkl_file.id_filePKL 
        FROM pkl_file INNER JOIN pkl
        ON pkl_file.id_pkl=pkl.id_pkl
        INNER JOIN dosen_wali
        ON pkl.id_dosenwali=dosen_wali.id_dosenwali
        INNER JOIN dosen 
        ON dosen_wali.nidn=dosen.nidn 
        WHERE pkl.nim='$nim'")
        or die (mysqli_erorr($conn));
        if (mysqli_num_rows($getdata) > 0) {
          while ($data=mysqli_fetch_array($getdata)) {
            ?>
                <tr>
                  <td><?= $data["nama_dosen"]  ?></td>
                  <td><?= $data["judul_laporan"]  ?></td>
                  <td align="center">
                    <a href="assets/downloadfile.php?filename=<?= $data["filePKL"] ?>" class="btn-sm btn-primary"><i
                        class="fas fa-download"></i></a></td>
                  <td align="center">
                    <button type="submit" class="btn-sm btn-dark" name="detail" data-toggle="modal"
                      data-target="#modal-lg1" id="detailbim" data-id="<?php echo $data["id_filePKL"]?>"
                      data-namafile="<?php echo $data["filePKL"]?>">
                      <i class="fas fa-edit"></i></button>
                  </td>
                </tr>
                <?php
          }
        }
        ?>
              </tbody>
            </table>
            <?php } ?>
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
  <?php } ?>
  <!-- section semua file -->
  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <center>
              <h3 class="m-0 text-dark">File Laporan Praktik Kerja Lapangan</h3>
          </div>
          </center>
          <!-- /.card-header -->
          <div class="card-body">
            <!-- cek file ta sudah diunggah belum -->
            <table id="example3" class="table table-bordered table-striped">
              <thead align="center">
                <tr>
                  <th width="80px">NIM</th>
                  <th width="250px">Nama</th>
                  <th width="250px">Pembimbing</th>
                  <th width="350px">Judul Laporan</th>
                  <th width="50px">File</th>
                  <!-- <th width="50px">Aksi</th> -->
                </tr>
              </thead>
              <tbody>
                <?php
        //ambi data bimbingan
        $getdata = mysqli_query($conn,
        "SELECT m.nim, m.nama, d.nama_dosen, 
        p.judul_laporan, 
        pf.filePKL, .pf.id_filePKL 
        FROM pkl_file pf INNER JOIN pkl p 
        ON pf.id_pkl=p.id_pkl
        INNER JOIN dosen_wali dw
        ON p.id_dosenwali=dw.id_dosenwali
        INNER JOIN dosen d
        ON dw.nidn=d.nidn
        INNER JOIN mahasiswa m
        ON p.nim=m.nim")
        or die (mysqli_erorr($conn));
        if (mysqli_num_rows($getdata) > 0) {
          while ($data=mysqli_fetch_array($getdata)) {
            $n=$data["id_filePKL"];
            $ni = base64_encode($n);
            ?>
                <tr>
                  <td><?= $data["nim"]  ?></td>
                  <td><?= $data["nama"]  ?></td>
                  <td><?= $data["nama_dosen"]  ?></td>
                  <td><a href="detailfilepkl.php?id=<?=$ni?>"><?= $data["judul_laporan"]  ?></a></td>
                  <td align="center">
                    <a href="assets/downloadfile.php?filename=<?= $data["filePKL"] ?>" class="btn-sm btn-primary"><i
                        class="fas fa-download"></i></a></td>
                  <!-- <td align="center">
            <button type="submit" class="btn-sm btn-dark" name="detail" data-toggle="modal" data-target="#modal-lg1" id="detailbim"
            data-id="<?php echo $data["id_filePKL"]?>"
            data-namafile="<?php echo $data["filePKL"]?>">
            <i class="fas fa-edit"></i></button>
            </td> -->
                </tr>
                <?php
          }
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
  <!-- section smeua file -->

</div>

<!-- modal tambah bimbingan -->
<div class="modal fade" id="modal-lg">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Form Unggah File Laporan Praktik Kerja Lapangan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="card-body">
            <div class="form-group row">
              <label for="filePKL" class="col-sm-3 col-form-label">File Bimbingan</label>
              <div class="col-sm-9">
                <input type="file" id="filePKL" name="filePKL" required="required">
                <br>
                <small>
                  <b>PDF, Maximal Size 10 MB</b>
                </small>
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
<!-- /.modal -->
<!-- modal tambah bimbingan -->
<!-- modal detail bimbingan -->
<div class="modal fade" id="modal-lg1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <style>
          .modal-header {
            background-color: #292929;
            color: #FFFFFF;
          }
        </style>
        <h5 class="modal-title" id="exampleModalLabel">Form Ubah File Laporan PKL</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- form body modal -->
        <form action="" method="post" enctype="multipart/form-data">
          <div class="form-row">
            <div class="form-group col-md-12">
              <input type="text" class="form-control" id="id" name="id" hidden>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="file">File Laporan PKL</label>
              <a href="" target="_blank" id="file" name="file" class="btn-sm btn-primary">Lihat</a>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="filePKL">File Laporan Baru</label>
              <input type="file" name="filePKL" id="filePKL">
              <br>
              <small><b>PDF, Maximal Size 10 MB</b></small>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <input type="text" class="form-control" id="nama" name="nama">
            </div>
          </div>
          <!-- /.card-body -->
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="ubah" id="ubah">Ubah</button>
          </div>
      </div>
      </form>
    </div>
  </div>
</div>
</div>
<!-- /. modal detail bimbingan -->
<!-- /.modal detail bimbingan -->
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
  // detail data
  $(document).on("click", "#detailbim", function () {
    let id = $(this).data('id');
    let nama = $(this).data('namafile');
    $("#modal-lg1 #file").attr("href", "../../assets/laporan_pkl/" + nama);
    $("#modal-lg1 #nama").val(nama);
    $("#modal-lg1 #id").val(id);
  });
</script>
</body>

</html>