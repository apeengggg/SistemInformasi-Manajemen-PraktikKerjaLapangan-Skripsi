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
$namefile = date('Y-m-d-h-i-s');

//ambil id_pkl
$id = mysqli_query($conn, "SELECT pkl.id_pkl FROM pkl JOIN mahasiswa ON mahasiswa.nim=pkl.nim WHERE mahasiswa.nim='$nim'") or die (mysqli_error($conn));
$getid = mysqli_fetch_array($id);
// ambil data penguji
$getpeng = mysqli_query($conn, "SELECT pkl_sidang.penguji FROM pkl_sidang JOIN pkl on pkl_sidang.id_pkl=pkl.id_pkl WHERE nim='$nim'");
$data1 = mysqli_fetch_array($getpeng);
//ambil data lampiran revisi
$getlamp = mysqli_query($conn, "SELECT lem_rev, nim FROM pkl WHERE nim='$nim' AND lem_rev IS NULL");

// tambah bimbingan
if (isset($_POST["bimbingan"])) {
$ekstensi2 = array("pdf");
$filebim= $_FILES["filebim"]["name"];
$ukuran = $_FILES["filebim"]["size"];
// var_dump($ukuran); die;
$ambil_ekstensi1 = explode(".", $filebim);
$eks = $ambil_ekstensi1[1];
$nidn = $_POST["nidn"];
$tgl = $tanggal;
$subjek = $_POST["subjek"];
$desk = $_POST["deskripsi"];
$idpkl = $getid["id_pkl"];
$newfilebim = $nim.'-'.$namefile.'-'.$filebim;
$status='Bimbingan Laporan';
$pathfilebim = '../../assets/mhs_bimPKL/'.$newfilebim;
if (in_array($eks, $ekstensi2)) {
  if ($ukuran > 10000000) {
    echo "<script>
    alert('Ukuran File Anda Melebihi 10MB ! Gagal Menunggah File Bimbingan')
    windows.location.href='bimbinganpkl.php'
    </script>";
  }else{
$filebim_tmp = $_FILES["filebim"]["tmp_name"];
if (move_uploaded_file($filebim_tmp, $pathfilebim)) {
$tambahbim = mysqli_query($conn, "INSERT INTO pkl_bim (id_pkl, nim, nidn, tanggal, subjek, deskripsi, file_bim, status)
VALUES ('$idpkl' ,'$nim', '$nidn', '$tgl', '$subjek', '$desk', '$newfilebim','$status')") or die (mysqli_error($conn));
if ($tambahbim) {
echo "<script>
alert('Berhasil Melakukan Bimbingan!')
windows.location.href='bimbinganpkl.php'
</script>";
}else {
echo "<script>
alert('Gagal Melakukan Bimbingan!')
windows.location.href='bimbinganpkl.php'
</script>";
}
}
}
}else {
  echo "<script>
  alert('Gagal Melakukan Bimbingan, File yang harus di unggah hanya bisa doc, docx, ppt, pptx, rar, pdf, atau zip!')
  windows.location.href='index.php'
  </script>";    
  }
}
// baca mahasiswa
if(isset($_POST["hasilbim"])) {
$id=$_POST["id"]; 
$status_mhs = "Dibaca";
// cek apakah sudah terisi filehasil bimbingannya
$cekfile = mysqli_query($conn, "SELECT * FROM pkl_bim WHERE id_bimPKL='$id' AND file_hasilbim IS NULL") or die (mysqli_error($conn));
if(mysqli_num_rows($cekfile)===1) {
echo "<script>
windows.location.href='index.php'
</script>";
}else{
$update = mysqli_query($conn, "UPDATE pkl_bim SET status_mhs='$status_mhs' WHERE id_bimPKL='$id'");
}
}

if (isset($_POST["ubahbim"])) {
  $id = $_POST["id"];
  $cek = mysqli_query($conn, "SELECT status_bim FROM pkl_bim WHERE id_bimPKL='$id' AND status_bim IS NOT NULL");
  if (mysqli_num_rows($cek)>0) {
    echo "<script>
    alert('Bimbingan Gagal Diubah, Dosen Pembimbing Sudah Mengirim Hasil Bimbingan')
    windows.location.href='bimbinganpkl.php'
    </script>";
  }else{
  $subjek = $_POST["subjek"];
  $desk = $_POST["desk"];
  $filebim= $_FILES["filebim"]["name"];
  $ukuran = $_FILES["filebim"]["size"];
  // var_dump($filebim); die;
  $status='Bimbingan Laporan';
  if (empty($filebim)) {
    $sql = mysqli_query($conn, "UPDATE pkl_bim SET subjek='$subjek', deskripsi='$desk'
                        WHERE id_bimPKL='$id'");
    if ($sql) {
      echo "<script>
    alert('Bimbingan Berhasil diubah tanpa perubahan pada file bimbingan')
    windows.location.href='bimbinganpkl.php'
    </script>";
    }else {
      echo "<script>
      alert('Bimbingan Gagal diubah')
      windows.location.href='bimbinganpkl.php'
      </script>";
    }
  }else {
    $ekstensi2 = array("pdf");
    $ambil_ekstensi1 = explode(".", $filebim);
    $eks = $ambil_ekstensi1[1];
    $newfilebim = $nim.'-'.$namefile.'-'.$filebim;
    $pathfilebim = '../../assets/mhs_bimPKL/'.$newfilebim;
    $filelama = mysqli_query($conn, "SELECT file_bim FROM pkl_bim WHERE id_bimPKL='$id'");
    $d = mysqli_fetch_array($filelama);
    if (in_array($eks, $ekstensi2)) {
    if ($ukuran > 10000000) {
        echo "<script>
        alert('Gagal Mengubah File Bimbingan, File Max Size 10 MB!')
        windows.location.href='bimbinganpkl.php'
        </script>"; 
      }else{
    $filebim_tmp = $_FILES["filebim"]["tmp_name"];
    if (move_uploaded_file($filebim_tmp, $pathfilebim)) {
    unlink('../../assets/mhs_bimPKL/'.$d["file_bim"]);
    $tambahbim = mysqli_query($conn, "UPDATE pkl_bim SET subjek='$subjek', deskripsi='$desk',
                            file_bim='$newfilebim' WHERE id_bimPKL='$id'") or die (mysqli_error($conn));
    if ($tambahbim) {
    echo "<script>
    alert('Berhasil Mengubah Bimbingan!')
    windows.location.href='bimbinganpkl.php'
    </script>";
    }else {
    echo "<script>
    alert('Gagal Mengubah Bimbingan!')
    windows.location.href='bimbinganpkl.php'
    </script>";
    }
    }
    }
    }else {
      echo "<script>
      alert('Gagal Mengubah File Bimbingan, File yang harus di unggah hanya PDF!')
      windows.location.href='bimbinganpkl.php'
      </script>"; 
    }
  }
  }
}

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Data Bimbingan PKL | SIM-PS | Mahasiswa</title>
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
          $cekdatapkl = mysqli_query($conn, "SELECT * FROM pkl WHERE nim='$nim'");
          if (mysqli_num_rows($cekdatapkl)<1) {
          ?>
  <center>
    <div class="alert alert-danger" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <b>Anda Belum Memiliki Data PKL, silahkan tambahkan terlebih dahulu pada halaman data pkl</b>
    </div>
  </center>
  <?php }else{
          ?>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <?php
              //ambil data pembimbing
              $pemb = mysqli_query($conn, "SELECT dosen.nidn, dosen.nama_dosen, dosen.foto_dosen FROM pkl LEFT JOIN dosen_wali ON pkl.id_dosenwali=dosen_wali.id_dosenwali LEFT JOIN dosen ON dosen_wali.nidn=dosen.nidn WHERE pkl.nim='$nim'") or die (mysqli_error($conn));
              $dataa=mysqli_fetch_array($pemb);
              ?>
          <div class="card-header">
            <center>
              <h3>Pembimbing</h3>
            </center>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table align="center">
              <tr>
                <td colspan="3">
                  <img src="../../assets/foto/<?= $dataa["foto_dosen"]?>" width="140px" height="150px" alt="">
                </td>
              </tr>
              <tr>
                <td>NIDN</td>
                <td>:</td>
                <td><?= $dataa["nidn"] ?></td>
              </tr>
              <tr>
                <td>Nama</td>
                <td>:</td>
                <td><?= $dataa["nama_dosen"] ?></td>
              </tr>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <center>
              <h2>Data Bimbingan Praktik Kerja Lapangan</h2><b></b>
            </center>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-lg">
              <i class="fas fa-plus"></i> Bimbingan
            </button>
            <a href="assets/cetakbimpkl.php" class="btn btn-warning"><i class="fas fa-print"></i> Cetak Kartu
              Bimbingan</a>
            <a href="assets/exportkabimpkl.php" target="_blank" class="btn btn-success"><i class="fas fa-download"></i>
              Export Kartu Bimbingan</a>
          </div>
          <?php
                  //ambil data pembimbing
                  $pemb = mysqli_query($conn, "SELECT dosen.nidn, dosen.nama_dosen FROM pkl LEFT JOIN dosen_wali ON pkl.id_dosenwali=dosen_wali.id_dosenwali LEFT JOIN dosen ON dosen_wali.nidn=dosen.nidn WHERE pkl.nim='$nim'") or die (mysqli_error($conn));
                  ?>
          <!-- modal tambah bimbingan -->
          <div class="modal fade" id="modal-lg">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Form Bimbingan Laporan PKL</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form class="form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                      <div class="form-group row">
                        <label for="nidn" class="col-sm-3 co-form-label">Dosen Pembimbing</label>
                        <div class="col-sm-9">
                          <select class="form-control" name="nidn" id="nidn" required="required">
                            <option value="">Pilih</option>
                            <?php
                                    while ($datapemb = mysqli_fetch_array($pemb)) {
                                    ?>
                            <option value="<?=$datapemb["nidn"]?>"><?=$datapemb["nama_dosen"]?>
                            </option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="subjek" class="col-sm-3 col-form-label">Subjek</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="subjek" name="subjek" placeholder="BAB 1"
                            required="required">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi</label>
                        <div class="col-sm-9">
                          <textarea class="form-control" rows="3" placeholder="Pesan" name="deskripsi" id="deskripsi"
                            required="required"></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="filebim" class="col-sm-3 col-form-label">File Bimbingan</label>
                        <div class="col-sm-9">
                          <input type="file" id="filebim" name="filebim" required="required">
                          <br>
                          <small><b>PDF, Max Size 10MB</b></small>
                        </div>
                      </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="bimbingan"
                    id="bimbingan">Kirim</button>
                </div>
              </div>
              </form>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- /.modal -->
          <!-- modal tambah bimbingan -->


          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead align="center">
                <tr>
                  <th width="100px">Tanggal</th>
                  <th width="100px">Subjek</th>
                  <th width="75px">Dosen</th>
                  <th width="75px">Mahasiswa</th>
                  <th width="75px">Status</th>
                  <th width="75px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                        //ambi data bimbingan
                        $getdata = mysqli_query($conn,
                        "SELECT d1.nama_dosen AS pembimbing, 
                         mhs.nim AS nim,
                         mhs.nama AS nama, 
                         mhs.foto AS foto,
                         pkl.judul_laporan AS judul,
                         pkl.lem_rev,
                        bim.file_bim AS filebim, 
                        bim.file_hasilbim AS hasilbim, 
                        bim.tanggal AS tanggal_bim, 
                        bim.subjek AS subjek_bim, 
                        bim.deskripsi AS deskripsi_bim, 
                        bim.pesan AS pesan_bim, 
                        bim.status_bim AS status_bim, 
                        bim.status_dosbing AS dosbing, 
                        bim.id_bimPKL AS id, 
                        bim.status_mhs AS mahasiswa
                        FROM pkl_bim bim LEFT JOIN pkl
                        ON bim.id_pkl=pkl.id_pkl 
                        LEFT JOIN dosen_wali
                        ON pkl.id_dosenwali=dosen_wali.id_dosenwali
                        LEFT JOIN dosen d1
                        ON dosen_wali.nidn=d1.nidn
                        LEFT JOIN mahasiswa mhs
                        ON pkl.nim=mhs.nim
                        WHERE bim.nim='$nim' AND bim.status='Bimbingan Laporan'
                        ORDER BY bim.status_mhs ASC")
                        or die (mysqli_erorr($conn));
                        if (mysqli_num_rows($getdata) > 0) {
                        while ($data=mysqli_fetch_array($getdata)) {
                        $d = $data["tanggal_bim"];
                        $tgl = date('d-M-Y', strtotime($d));
                        ?>
                <tr>
                  <td align="center"><?= $tgl  ?></td>
                  <td><?= $data["subjek_bim"]  ?></td>
                  <td align="center">
                    <?php
                            if ($data["dosbing"]=="Belum Dibaca") {
                            ?>
                    <span class="badge badge-primary">
                      <?php } else if ($data["dosbing"]=="Dibalas"){
                              ?>
                      <span class="badge badge-success">
                        <?php }else if ($data["dosbing"]=="Dibaca"){
                                ?>
                        <span class="badge badge-danger">
                          <?php } ?>
                          <?= $data["dosbing"]  ?></td>

                  <td align="center">
                    <?php
                                  if ($data["mahasiswa"]=="Belum Dibaca") {
                                  ?>
                    <span class="badge badge-danger">
                      <?php } else if ($data["mahasiswa"]=="Dibaca"){
                                    ?>
                      <span class="badge badge-success">
                        <?php }?>

                        <?= $data["mahasiswa"]  ?></td>

                  <td align="center">
                    <?php
                                      if ($data["status_bim"]=="Lanjut BAB") {
                                      ?>
                    <span class="badge badge-primary">
                      <?php } else if ($data["status_bim"]=="Layak"){
                                        ?>
                      <span class="badge badge-success">
                        <?php }else if ($data["status_bim"]=="Revisi"){
                                          ?>
                        <span class="badge badge-warning">
                          <?php } ?>
                          <?= $data["status_bim"]  ?></td>
                  <td align="center">
                    <button type="submit" class="btn-sm btn-dark" name="detail" data-toggle="modal"
                      data-target="#modal-lg1" id="detailbim" data-id="<?php echo $data["id"]?>"
                      data-dosbing="<?php echo $data["pembimbing"]?>" data-penguji="<?php echo $data["penguji"]?>"
                      data-judul="<?php echo $data["judul"]?>" data-tglsid="<?php echo $data["tanggal_sidang"]?>"
                      data-ruangsid="<?php echo $data["ruang_sidang"]?>"
                      data-waktusid="<?php echo $data["waktu_sidang"]?>" data-filebim="<?php echo $data["filebim"]?>"
                      data-hasilbim="<?php echo $data["hasilbim"]?>"
                      data-tanggal_bim="<?php echo $data["tanggal_bim"]?>"
                      data-subjek="<?php echo $data["subjek_bim"]?>" data-desk="<?php echo $data["deskripsi_bim"]?>"
                      data-pesan="<?php echo $data["pesan_bim"]?>" data-status="<?php echo $data["status_bim"]?>"
                      data-status_dosbing="<?php echo $data["dosbing"]?>" data-lemrev="<?php echo $data["lem_rev"]?>"><i
                        class="fas fa-info-circle"></i></button>
                    <button type="submit" class="btn-sm btn-dark" name="detail1" data-toggle="modal"
                      data-target="#modal-lg11" id="detailbim1" data-id="<?php echo $data["id"]?>"
                      data-dosbing="<?php echo $data["pembimbing"]?>" data-penguji="<?php echo $data["penguji"]?>"
                      data-judul="<?php echo $data["judul"]?>" data-tglsid="<?php echo $data["tanggal_sidang"]?>"
                      data-ruangsid="<?php echo $data["ruang_sidang"]?>"
                      data-waktusid="<?php echo $data["waktu_sidang"]?>" data-filebim="<?php echo $data["filebim"]?>"
                      data-hasilbim="<?php echo $data["hasilbim"]?>"
                      data-tanggal_bim="<?php echo $data["tanggal_bim"]?>"
                      data-subjek="<?php echo $data["subjek_bim"]?>" data-desk="<?php echo $data["deskripsi_bim"]?>"
                      data-pesan="<?php echo $data["pesan_bim"]?>" data-status="<?php echo $data["status_bim"]?>"
                      data-status_dosbing="<?php echo $data["dosbing"]?>" data-lemrev="<?php echo $data["lem_rev"]?>"><i
                        class="fas fa-edit"></i></button>
                  </td>
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

      <!-- modal detail bimbingan -->
      <div class="modal fade" id="modal-lg1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <style>
                .modal-header {
                  background-color: #292929;
                  color: #FFFFFF;
                }
              </style>
              <h5 class="modal-title" id="exampleModalLabel">Detail Bimbingan Laporan Praktik Kerja Lapangan</h5>

              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <!-- form body modal -->
              <form action="" method="post" enctype="multipart/form-data">
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <input type="text" class="form-control" id="id" name="id" hidden>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-9">
                    <label for="judul">Judul Laporan</label>
                    <input type="text" class="form-control" id="judul" name="judul" disabled>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="pembimbing">Dosen Pembimbing</label>
                    <input type="text" class="form-control" id="pembimbing" name="pembimbing" disabled>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="pesan">Pesan</label>
                    <textarea name="pesan1" id="pesan1" cols="1" rows="1" class="form-control" disabled></textarea>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="subjek">Subjek Bimbingan</label>
                    <input type="text" class="form-control" id="subjek" name="subjek" disabled>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="tanggal">Tanggal Bimbingan</label>
                    <input type="text" class="form-control" id="tanggal" name="tanggal" disabled>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="status_bim1">Hasil Bimbingan</label>
                    <input type="text" class="form-control" id="status_bim1" name="status_bim1" disabled>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-2">
                    <label for="filebim">File Bimbingan</label>
                    <br>
                    <a class="btn-sm btn-primary" href="" id="filebim" name="filebim">Unduh</a>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="file_hasilbim">File Hasil Bimbingan</label>
                    <br>
                    <a class="btn-sm btn-primary" href=" " id="file_hasilbim">Unduh</a>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="hasilbim"
                    id="hasilbim">Dibaca</button>
                </div>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- /. modal detail bimbingan -->

    <!-- modal ubah bimbingan -->
    <div class="modal fade" id="modal-lg11" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <style>
              .modal-header {
                background-color: #292929;
                color: #FFFFFF;
              }
            </style>
            <h5 class="modal-title" id="exampleModalLabel">Ubah Bimbingan Praktik Kerja Lapangan</h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- form body modal -->
            <form action="" method="post" enctype="multipart/form-data">
              <div class="form-row">
                <div class="form-group col-md-4">
                  <input type="text" class="form-control" id="id" name="id" hidden>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-9">
                  <label for="judul">Judul Laporan</label>
                  <input type="text" class="form-control" id="judul" name="judul" readonly>
                </div>
                <div class="form-group col-md-3">
                  <label for="pembimbing">Dosen Pembimbing</label>
                  <input type="text" class="form-control" id="pembimbing" name="pembimbing" readonly>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-3">
                  <label for="subjek">Subjek Bimbingan</label>
                  <input type="text" class="form-control" id="subjek" name="subjek">
                </div>
                <div class="form-group col-md-3">
                  <label for="desk">Deskripsi Bimbingan</label>
                  <!-- <input type="text" class="form-control" id="desk" name="desk" disabled> -->
                  <textarea name="desk" id="desk" cols="20" rows="3" class="form-control"></textarea>
                </div>
                <div class="form-group col-md-2">
                  <label for="filebim">File Bimbingan Lama</label>
                  <br>
                  <a class="btn-sm btn-primary" href="" id="filebim" name="filebim">Unduh</a>
                </div>
                <div class="form-group col-md-3">
                  <label for="filebim">File Bimbingan Baru</label>
                  <div class="col-sm-9">
                    <input type="file" id="filebim" name="filebim">
                    <br>
                    <small><b>PDF, Max Size 10MB</b></small>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="ubahbim"
                  id="ubahbim">Ubah</button>
              </div>
          </div>
          </form>
        </div>
      </div>
    </div>
</div>

<!-- /.modal ubah bimbingan -->
<!-- /.col -->
</div>
<!-- /.row -->
</section>
<?php } ?>
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
  // detail data
  $(document).on("click", "#detailbim", function () {
    let foto = $(this).data('foto');
    let nim = $(this).data('nim');
    let nama = $(this).data('nama');
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
    let penguji = $(this).data('penguji');
    let lemrev = $(this).data('lemrev');
    $("#modal-lg1 #lem_rev").attr("href", "assets/downloadlemrev.php?filename=" + lemrev);
    $("#modal-lg1 #penguji").val(penguji);
    $("#modal-lg1 #filebim").attr("href", "assets/downloadfilebim.php?filename=" + filebim);
    $("#modal-lg1 #file_hasilbim").attr("href", "assets/downloadhasilbim.php?filename=" + hasilbim);
    $("#modal-lg1 #pesan1").val(pesan);
    $("#modal-lg1 #subjek").val(subjek);
    $("#modal-lg1 #tanggal").val(tanggalbim);
    $("#modal-lg1 #judul").val(judul);
    $("#modal-lg1 #pembimbing").val(pembimbing);
    $("#modal-lg1 #tgl_sid").val(tglsid);
    $("#modal-lg1 #ruang_sid ").val(ruangsid);
    $("#modal-lg1 #waktu").val(waktusid);
    $("#modal-lg1 #status_bim1").val(status);
    $("#modal-lg1 #id").val(id);
  });

  // detail data
  $(document).on("click", "#detailbim1", function () {
    let foto = $(this).data('foto');
    let nim = $(this).data('nim');
    let nama = $(this).data('nama');
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
    let penguji = $(this).data('penguji');
    let lemrev = $(this).data('lemrev');
    let desk = $(this).data('desk');
    $("#modal-lg11 #lem_rev").attr("href", "assets/downloadlemrev.php?filename=" + lemrev);
    $("#modal-lg11 #penguji").val(penguji);
    $("#modal-lg11 #filebim").attr("href", "assets/downloadfilebim.php?filename=" + filebim);
    $("#modal-lg11 #file_hasilbim").attr("href", "assets/downloadhasilbim.php?filename=" + hasilbim);
    $("#modal-lg11 #pesan1").val(pesan);
    $("#modal-lg11 #subjek").val(subjek);
    $("#modal-lg11 #tanggal").val(tanggalbim);
    $("#modal-lg11 #judul").val(judul);
    $("#modal-lg11 #pembimbing").val(pembimbing);
    $("#modal-lg11 #tgl_sid").val(tglsid);
    $("#modal-lg11 #ruang_sid ").val(ruangsid);
    $("#modal-lg11 #waktu").val(waktusid);
    $("#modal-lg11 #status_bim1").val(status);
    $("#modal-lg11 #id").val(id);
    $("#modal-lg11 #desk").val(desk);
  });
</script>
</body>

</html>