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
$id = mysqli_query($conn, "SELECT * FROM pkl JOIN mahasiswa ON mahasiswa.nim=pkl.nim WHERE mahasiswa.nim='$nim'") or die (mysqli_error($conn));
$getid = mysqli_fetch_array($id);

//ambil data judul
$judul = mysqli_query($conn, "SELECT judul_laporan FROM pkl WHERE nim='$nim'" ) or die (mysqli_erorr($conn));
$data1 = mysqli_fetch_array($judul);


if (isset($_POST["sidang"])) {
  $idpkl = $_POST["id_pkl"];
  $syarat = $_FILES["syarat1"]["name"];
  $ukuran = $_FILES["syarat1"]["size"];
  // var_dump($_FILES);
  // echo '<br>';
  // var_dump($_POST); die;
$cekbim = mysqli_query($conn, "SELECT * FROM pkl_bim WHERE nim='$nim' AND status='Bimbingan Laporan'
                      AND status_bim='Layak'");
if (mysqli_num_rows($cekbim)===0) {  
    echo "<script>
    alert('Bimbingan anda belum disetujui oleh dosen pembimbing, hubungi dosen pembimbing anda .. !')
    windows.location.href('sidangpkl.php')
    </script>";                    
        }else {
// cek apakah sidang belum terlaksana atau sudah lulus?
$check = mysqli_query($conn, "SELECT * FROM pkl_sidang LEFT JOIN pkl ON pkl_sidang.id_pkl=pkl.id_pkl 
                              LEFT JOIN pkl_syarat_sidang ON pkl_sidang.id_sidpkl=pkl_syarat_sidang.id_sidang
                              WHERE pkl.nim='$nim' AND 
                              (pkl_sidang.status_sid='Lulus' OR pkl_sidang.status_sid IS NULL) 
                              AND (pkl_sidang.val_dosbing='2' OR pkl_sidang.val_dosbing='0')
                              AND (pkl_syarat_sidang.status='2' OR pkl_syarat_sidang.status='0')
                              ");
if (mysqli_num_rows($check) > 0) {
  echo "<script>
    alert('Anda Belum Melaksanakan Sidang atau Anda Sudah Mengikuti Sidang dan Lulus!')
    windows.location.href('sidangpkl.php')
    </script>";
}else{
  $ekstensi2 = array("pdf");
  $ambil_ekstensi1 = explode(".", $syarat);
  $eks = $ambil_ekstensi1[1];
  $newsyarat = $nim.'-'.$namefile.'-'.$syarat;
  $pathsyarat = '../../assets/syarat_sidang_pkl/'.$newsyarat;
  if (in_array($eks, $ekstensi2)) {
    if ($ukuran > 200000) {
      echo "<script>
        alert('Gagal Mengunggah Syarat Sidang, File Maximal 200 KB')
        windows.location.href='sidangpkl.php'
        </script>"; 
    }else{
    $syarat_tmp = $_FILES["syarat1"]["tmp_name"];
    if (move_uploaded_file($syarat_tmp, $pathsyarat)) {
      $daftar = mysqli_query($conn, "INSERT INTO pkl_sidang (id_sidpkl, id_pkl) VALUES ('','$idpkl')") or die (mysqli_erorr($conn));
      $id_sidang = mysqli_insert_id($conn);
      $syarat_sidang = mysqli_query($conn, "INSERT INTO pkl_syarat_sidang (file, status, id_sidang) VALUES ('$newsyarat', '0', '$id_sidang')") or die (mysqli_erorr($conn));
      if ($daftar && $syarat_sidang) {
        echo "<script>
        alert('Berhasil Melakukan Daftar Sidang')
        windows.location.href('sidangpkl.php')
        </script>";
        }else {
        echo "<script>
        alert('Gagal Melakukan Daftar Sidang')
        windows.location.href('sidangpkl.php')
        </script>";
    }
  }
      }
    }else{
      echo "<script>
      alert('Gagal Mengunggah File Persyaratan, File Harus PDF !')
      windows.location.href('sidangpkl.php')
      </script>";
    }
  }
}
}

// ambil data sidang
$datasidang1 = mysqli_query($conn,
"SELECT * FROM dosen LEFT JOIN pkl_sidang 
ON dosen.nidn=pkl_sidang.penguji 
LEFT JOIN pkl 
ON pkl_sidang.id_pkl=pkl.id_pkl 
WHERE pkl.nim ='$nim'") 
or die (mysqli_erorr($conn));
$dataa=mysqli_fetch_array($datasidang1);
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Data Sidang PKL| SIM-PS | Mahasiswa</title>
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
          $cekdatapkl = mysqli_query($conn, "SELECT * FROM pkl_bim WHERE pkl_bim.nim='$nim' AND status_bim='Layak'");
          if (mysqli_num_rows($cekdatapkl)<1) {
          ?>
  <center>
    <div class="alert alert-danger" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <b>Bimbingan Anda Belum DiSetujui Oleh Dosen Pembimbing, Silahkan Hubungi Dosen Pembimbing Anda</b>
    </div>
  </center>
  <?php }else{
          ?>
  <!-- Main content -->

  <section class="content">
    <!-- <div class="row"> -->
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <center>
            <h2>Data Sidang Praktik Kerja Lapangan</h2><br>
          </center>
          <button type="button" id="daftarsidang" class="btn btn-primary" data-toggle="modal" data-target="#modal-lg"
            data-id="<?php echo $getid["id_pkl"] ?>" data-nama="<?php echo $getid["nama"] ?>"
            data-nim="<?php echo $getid["nim"] ?>" data-ttl="<?php echo $getid["ttl"] ?>"
            data-alamat="<?php echo $getid["alamat_rumah"] ?>" data-hp="<?php echo $getid["no_hp"] ?>"
            data-judul="<?php echo $data1["judul_laporan"] ?>">
            <i class="fas fa-plus"></i> Daftar Sidang PKL
          </button>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead align="center">
              <tr>
                <th width="200px">Penguji</th>
                <th width="30px">Waktu</th>
                <th width="100px">Ruangan</th>
                <th width="30px">Hasil</th>
                <th width="80px">Validasi Dosbing</th>
                <th width="80px">Validasi Syarat</th>
              </tr>
            </thead>
            <tbody>
              <?php                        
                        $datasidang = mysqli_query($conn,
                          "SELECT * FROM pkl_sidang LEFT JOIN dosen 
                          ON pkl_sidang.penguji=dosen.nidn 
                          LEFT JOIN pkl
                          ON pkl_sidang.id_pkl=pkl.id_pkl
                          LEFT JOIN pkl_syarat_sidang 
                          ON pkl_sidang.id_sidPKL=pkl_syarat_sidang.id_sidang 
                          WHERE pkl.nim ='$nim'") 
                          or die (mysqli_erorr($conn));
                        if (mysqli_num_rows($datasidang) > 0) {
                        while ($data=mysqli_fetch_array($datasidang)) {
                        $d = $data["tgl_sid"];
                        $tgl = date('d-M-Y', strtotime($d));
                        if ($d == "") {
                          $tgl = "";
                        }
                        if ($data["val_dosbing"]==0) {
                          $val ='Menunggu';
                        }elseif ($data["val_dosbing"]==1) {
                          $val ='Ditolak';
                        }elseif ($data["val_dosbing"]==2) {
                          $val ='Disetujui';
                        }
                        if ($data["status"]==0) {
                          $status ='Menunggu';
                        }elseif ($data["status"]==1) {
                          $status ='Ditolak';
                        }elseif ($data["status"]==2) {
                          $status ='Disetujui';
                        }
                        // echo $val;
                        ?>
              <tr>
                <td><?php echo $data["nama_dosen"] ?></td>
                <td align="center"><?php echo $tgl ?><br><?php echo $data["waktu"] ?></td>
                <td><?php echo $data["ruang_sid"] ?></td>
                <td align="center"><?php echo $data["status_sid"] ?></td>
                <td align="center">
                  <?php
                            if ($val=="Menunggu") {
                            ?>
                  <span class="badge badge-primary">
                    <?php } else if ($val=="Disetujui"){
                              ?>
                    <span class="badge badge-success">
                      <?php }else if ($val=="Ditolak"){
                                ?>
                      <span class="badge badge-danger">
                        <?php } ?>
                        <?= $val  ?>
                </td>
                <td align="center">
                  <?php
                            if ($status=="Menunggu") {
                            ?>
                  <span class="badge badge-primary">
                    <?php } else if ($status=="Disetujui"){
                              ?>
                    <span class="badge badge-success">
                      <?php }else if ($status=="Ditolak"){
                                ?>
                      <span class="badge badge-danger">
                        <?php } ?>
                        <?= $status  ?>
                </td>
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

<!-- MODAL TAMBAH DATA MAHASISWA -->
<div class="modal fade" id="modal-lg">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Formulir Pendaftaran Sidang</h4>
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
              <label for="nama" class="col-sm-3 col-form-label">Nama</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="nama" name="nama" required="required" readonly>
              </div>
            </div>
            <div class="form-group row">
              <label for="nim" class="col-sm-3 col-form-label">NIM</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="nim" name="nim" required="required" readonly>
              </div>
            </div>
            <div class="form-group row">
              <label for="ttl" class="col-sm-3 col-form-label">Tempat, Tanggal Lahir</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="ttl" name="ttl" required="required" readonly>
              </div>
            </div>
            <div class="form-group row">
              <label for="alamat_rumah" class="col-sm-3 col-form-label">Alamat Rumah</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="alamat_rumah" name="alamat_rumah" required="required"
                  readonly>
              </div>
            </div>
            <div class="form-group row">
              <label for="no_hp" class="col-sm-3 col-form-label">No HP</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="no_hp" name="no_hp" required="required" readonly>
              </div>
            </div>
            <div class="form-group row">
              <label for="judul_laporan" class="col-sm-3 col-form-label">Judul Laporan PKL</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="judul_laporan" name="judul_laporan" required="required"
                  readonly>
              </div>
            </div>
            <div class="form-group row">
              <label for="syarat" class="col-sm-3 col-form-label">Formulir Sidang</label>
              <div class="col-sm-9">
                <input type="file" id="syarat1" name="syarat1" required="required">
                <br>
                <small><b>PDF, Max Size 200kb</b></small>
              </div>
            </div>
          </div>
          <!-- /.card-body -->
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="sidang" id="sidang">Daftar
          Sidang</button>
      </div>
    </div>
    </form>
    <!-- /.modal-content -->
  </div>

  <?php } ?>
  <!-- /.modal-dialog -->
</div>
<!-- /.MODAL TAMBAH DATA MAHASISWA -->
<?php include 'assets/footer.php'; ?>
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
  $(document).on("click", "#daftarsidang", function () {
    let id = $(this).data('id');
    let nama = $(this).data('nama');
    let nim = $(this).data('nim');
    let alamat = $(this).data('alamat');
    let ttl = $(this).data('ttl');
    let hp = $(this).data('hp');
    let judul = $(this).data('judul');
    $(".modal-body #id_pkl").val(id);
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