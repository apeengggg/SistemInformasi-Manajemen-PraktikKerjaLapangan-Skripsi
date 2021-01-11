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
//ambil id_propsoal
$id = mysqli_query($conn, "SELECT proposal.id_proposal
FROM judul LEFT JOIN proposal
ON judul.id_judul=proposal.id_judul
WHERE judul.nim='$nim' AND judul.status_judul='Disetujui'")
or die (mysqli_error($conn));
$getid = mysqli_fetch_array($id);
// tambah bimbingan
if (isset($_POST["bimbingan"])) {
  $ekstensi = array("pdf");
  $filebim= $_FILES["filebim"]["name"];
  $ukuran = $_FILES["filebim"]["size"];
  $ambil_ekstensi = explode(".", $filebim);
  $eks = $ambil_ekstensi[1];
  $nidn = $_POST["nidn"];
  $tgl = $tanggal;
  $subjek = $_POST["subjek"];
  $desk = $_POST["deskripsi"];
  $idproposal = $getid["id_proposal"];
  $status='Bimbingan Proposal';
  $newfilebim = $nim.'-'.$namefile.'-'.$filebim;
  $pathfilebim = '../../assets/bim_prop/'.$newfilebim;
  if (in_array($eks, $ekstensi)) {
    if ($ukuran > 10000000) {
      echo "<script>
      alert('Maximal File Size 10 MB')
      windows.location.href='bimbinganproposal.php'
      </script>";
    }else{
    $filebim_tmp = $_FILES["filebim"]["tmp_name"];
    if (move_uploaded_file($filebim_tmp, $pathfilebim)) {
      $tambahbim = mysqli_query($conn, "INSERT INTO proposal_bim (id_proposal, nim, pembimbing, tgl_bim, subjek, deskripsi, file_bim, status)
      VALUES ('$idproposal' ,'$nim', '$nidn', '$tgl', '$subjek', '$desk', '$newfilebim','$status')") or die (mysqli_error($conn));
      if ($tambahbim) {
        echo "<script>
        alert('Berhasil Melakukan Bimbingan!')
        windows.location.href='bimbinganproposal.php'
        </script>";
      }else {
        echo "<script>
        alert('Gagal Melakukan Bimbingan!')
        windows.location.href='bimbinganproposal.php'
        </script>";
      }
    }
  }
}else{
    echo "<script>
    alert('File yang diupload bukan PDF')
    windows.location.href='bimbinganproposal.php'
    </script>";
  }
}
// baca mahasiswa
if(isset($_POST["hasil"])) {
  // var_dump($_POST); die;
  $id=$_POST["id"];
  $status_mhs = "Dibaca";
  // cek apakah sudah terisi filehasil bimbingannya
  $cekfile = mysqli_query($conn, "SELECT file_hasilbim FROM proposal_bim WHERE id_bim='$id' AND file_hasilbim IS NULL");
  if(mysqli_num_rows($cekfile)===1) {
    echo "<script>
    windows.location.href='pascasidang.php'
    </script>";
  }else{
    $update = mysqli_query($conn, "UPDATE proposal_bim SET status_mhs='$status_mhs' WHERE id_bim='$id'");
  }
}

if (isset($_POST["ubahbim"])) {
  $id = $_POST["id"];
  $cek = mysqli_query($conn, "SELECT status_bim FROM proposal_bim WHERE id_bim='$id' AND status_bim IS NOT NULL");
  if (mysqli_num_rows($cek)>0) {
    echo "<script>
    alert('Bimbingan Gagal Diubah, Dosen Pembimbing Sudah Mengirim Hasil Bimbingan')
    windows.location.href='bimbinganproposalosal.php'
    </script>";
  }else{
    $subjek = $_POST["subjek"];
    $desk = $_POST["desk"];
    $ekstensi2 = array("doc", "docx", "ppt", "pptx", "rar", "zip", "pdf");
    $filebim= $_FILES["filebim"]["name"];
    $ukuran= $_FILES["filebim"]["size"];
    // var_dump($filebim); die;
    
    if (empty($filebim)) {
      $sql = mysqli_query($conn, "UPDATE proposal_bim SET subjek='$subjek', deskripsi='$desk'
      WHERE id_bim='$id'");
      if ($sql) {
        echo "<script>
        alert('Bimbingan Berhasil diubah tanpa perubahan pada file bimbingan')
        windows.location.href='bimbinganproposalosal.php'
        </script>";
      }else {
        echo "<script>
        alert('Bimbingan Gagal diubah')
        windows.location.href='bimbinganproposalosal.php'
        </script>";
      }
    }else {
      $ambil_ekstensi1 = explode(".", $filebim);
      $eks = $ambil_ekstensi1[1];
      $newfilebim = $nim.'-'.$namefile.'-'.$filebim;
      $status='Bimbingan Proposal';
      $pathfilebim = '../../assets/bim_prop/'.$newfilebim;
      $filelama = mysqli_query($conn, "SELECT file_bim FROM proposal_bim WHERE id_bim='$id'");
      $d = mysqli_fetch_array($filelama);
      if (in_array($eks, $ekstensi2)) {
        if ($ukuran > 10000000) {
          echo "<script>
        alert('Maximal File Size 10 MB')
        windows.location.href='bimbinganproposalosal.php'
        </script>";
        }else{
        $filebim_tmp = $_FILES["filebim"]["tmp_name"];
        if (move_uploaded_file($filebim_tmp, $pathfilebim)) {
          unlink('../../assets/bim_prop/'.$d["file_bim"]);
          $tambahbim = mysqli_query($conn, "UPDATE proposal_bim SET subjek='$subjek', deskripsi='$desk',
          file_bim='$newfilebim' WHERE id_bim='$id'") or die (mysqli_error($conn));
          if ($tambahbim) {
            echo "<script>
            alert('Berhasil Mengubah Bimbingan!')
            windows.location.href='bimbinganproposalosal.php'
            </script>";
          }else {
            echo "<script>
            alert('Gagal Mengubah Bimbingan!')
            windows.location.href='bimbinganproposalosal.php'
            </script>";
          }
        }
      }
    }else {
        echo "<script>
        alert('Gagal Melakukan Bimbingan, File yang harus di unggah hanya PDF')
        windows.location.href='bimbinganproposalosal.php'
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
  <title>Bimbingan Proposal | SIM-PS | Mahasiswa</title>
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
  <!-- Main content -->
  <section class="content">
    <?php
$a = mysqli_query($conn, "SELECT * FROM judul WHERE nim='$nim' AND status_judul='Disetujui'");
$b = mysqli_query($conn, "SELECT proposal.dosbing FROM proposal LEFT JOIN judul ON proposal.id_judul=judul.id_judul 
LEFT JOIN mahasiswa ON judul.nim=mahasiswa.nim WHERE mahasiswa.nim='$nim' AND dosbing IS NOT NULL ");
if (mysqli_num_rows($a)>0) {
  if (mysqli_num_rows($b)>0) {
    
    ?>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <center>
              <h5>Dosen Pembimbing Proposal</h5>
            </center>
          </div>
          <?php
    //ambil data pembimbing
    $pemb = mysqli_query($conn, "SELECT dosen.nidn, dosen.nama_dosen, dosen.foto_dosen FROM proposal LEFT JOIN dosen ON proposal.dosbing=dosen.nidn LEFT JOIN judul ON proposal.id_judul=judul.id_judul WHERE judul.nim='$nim' AND judul.status_judul='Disetujui'") or die (mysqli_error($conn));
    $dataa=mysqli_fetch_array($pemb);
    ?>

          <!-- /.card-header -->
          <div class="card-body">
            <table align="center">
              <tr>
                <td colspan="3" align="center">
                  <img src="../../assets/foto/<?= $dataa["foto_dosen"]?>" width="140px" height="150px" alt="">
                </td>
              </tr>
              <tr align="center">
                <td>NIDN</td>
                <td>:</td>
                <td><?= $dataa["nidn"] ?></td>
              </tr>
              <tr align="center">
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
              <h2 class="m-0 text-dark">Data Bimbingan Proposal</h2><br>
            </center>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-lg">
              <i class="fas fa-plus"></i> Bimbingan
            </button>
          </div>
          <?php
    //ambil data pembimbing
    $pemb = mysqli_query($conn,
    "SELECT dosen.nama_dosen, dosen.nidn
    FROM dosen LEFT JOIN proposal
    ON dosen.nidn=proposal.dosbing
    LEFT JOIN judul
    ON proposal.id_judul=judul.id_judul
    WHERE judul.nim='$nim' AND judul.status_judul='Disetujui'") or die (mysqli_error($conn));
    ?>
          <!-- modal tambah bimbingan -->
          <div class="modal fade" id="modal-lg">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Form Bimbingan Proposal</h4>
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
                            <option readonly selected>Pilih</option>
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
                          <small><b>PDF, Max Size 10 MB</b></small>
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
                  <th width="90px">Tanggal</th>
                  <th width="150px">Subjek</th>
                  <th width="100px">Dosen</th>
                  <th width="100px">Mahasiswa</th>
                  <th>Status</th>
                  <th width="70px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
      // ambil data bimbimngan
      $getdata=mysqli_query($conn,
      "SELECT dosen.nama_dosen AS pembimbing,
      bim.tgl_bim AS tgl, bim.subjek AS subjek,
      bim.saran AS pesan, bim.status_bim AS hasil,
      bim.id_bim, bim.file_hasilbim AS file_hasil,
      bim.file_bim AS file_bim, bim.deskripsi,
      bim.status_dosbing AS dosbing_status, bim.status_mhs AS mahasiswa,
      bim.status_bim AS status_bim, bim.status,
      judul.judul AS judul
      FROM proposal_bim bim LEFT JOIN proposal
      ON bim.id_proposal=proposal.id_proposal
      LEFT JOIN dosen
      ON proposal.dosbing=dosen.nidn
      LEFT JOIN judul ON proposal.id_judul=judul.id_judul
      WHERE bim.nim='$nim' AND bim.status='Bimbingan Proposal'
      ORDER BY bim.tgl_bim DESC")
      or die (mysqli_erorr($conn));
      while ($data=mysqli_fetch_array($getdata)) {
        ?>
                <tr>
                  <td><?= $data["tgl"]  ?></td>
                  <td><?= $data["subjek"]  ?></td>
                  <td align="center">
                    <?php
        if ($data["dosbing_status"]=="Belum Dibaca") {
          ?>
                    <span class="badge badge-primary">
                      <?php } else if ($data["dosbing_status"]=="Dibalas"){
            ?>
                      <span class="badge badge-success">
                        <?php }else if ($data["dosbing_status"]=="Dibaca"){
              ?>
                        <span class="badge badge-danger">
                          <?php } ?>
                          <?= $data["dosbing_status"]  ?></td>

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
                  if ($data["status_bim"]=="Lanjut") {
                    ?>
                    <span class="badge badge-primary">
                      <?php } else if ($data["status_bim"]=="Layak"){
                      ?>
                      <span class="badge badge-success">
                        <?php }else if ($data["status_bim"]=="Revisi"){
                        ?>
                        <span class="badge badge-danger">
                          <?php } ?>
                          <?= $data["status_bim"]  ?></td>
                  <td align="center">
                    <button type="submit" class="btn-xs btn-dark" name="detail" data-toggle="modal"
                      data-target="#modal-lg1" id="detailbim" data-id="<?= $data["id_bim"]?>"
                      data-dosbing="<?= $data["pembimbing"]?>" data-judul="<?= $data["judul"]?>"
                      data-filebim="<?= $data["file_bim"]?>" data-hasilbim="<?= $data["file_hasil"]?>"
                      data-tgl="<?= $data["tgl"]?>" data-subjek="<?= $data["subjek"]?>"
                      data-desk="<?= $data["deskripsi"]?>" data-pesan="<?= $data["pesan"]?>"
                      data-status="<?= $data["hasil"]?>" data-status_dosbing="<?= $data["dosbing_status"]?>"><i
                        class="fas fa-info-circle"></i></button>
                    <button type="submit" class="btn-xs btn-dark" name="detail" data-toggle="modal"
                      data-target="#modal-lg11" id="detailbim1" data-id="<?= $data["id_bim"]?>"
                      data-dosbing="<?= $data["pembimbing"]?>" data-judul="<?= $data["judul"]?>"
                      data-filebim="<?= $data["file_bim"]?>" data-hasilbim="<?= $data["file_hasil"]?>"
                      data-tgl="<?= $data["tgl"]?>" data-subjek="<?= $data["subjek"]?>"
                      data-desk="<?= $data["deskripsi"]?>" data-pesan="<?= $data["pesan"]?>"
                      data-status="<?= $data["hasil"]?>" data-status_dosbing="<?= $data["dosbing_status"]?>"><i
                        class="fas fa-edit"></i></button>
                  </td>
                </tr>
                <?php
                        
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
              <h5 class="modal-title" id="exampleModalLabel">Detail Bimbingan Proposal</h5>
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
                    <label for="judul">Judul Skripsi</label>
                    <input type="text" class="form-control" id="judul" name="judul" readonly>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="pembimbing">Dosen Pembimbing</label>
                    <input type="text" class="form-control" id="pembimbing" name="pembimbing" readonly>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="pesan">Pesan</label>
                    <textarea name="pesan1" id="pesan1" cols="1" rows="1" class="form-control" readonly></textarea>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="subjek">Subjek Bimbingan</label>
                    <textarea name="subjek" id="subjek" cols="1" rows="1" class="form-control" readonly></textarea>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="tanggal">Tanggal Bimbingan</label>
                    <input type="text" class="form-control" id="tanggal" name="tanggal" readonly>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="hasilbim">Hasil Bimbingan</label>
                    <input type="text" class="form-control" id="hasilbim" name="hasilbim" readonly>
                  </div>
                  <!-- <div class="form-group col-md-3">
                      <label for="desk">Deskripsi Bimbingan</label>
                      <textarea name="desk" id="desk" cols="1" rows="1" class="form-control" readonly></textarea>
                      </div> -->
                  <div class="form-group col-md-2">
                    <label for="filebim">File Bimbingan</label>
                    <br>
                    <a class="btn-sm btn-primary" href="" id="filebim" name="filebim">Unduh</a>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="file_hasilbim">File Hasil Bimbingan</label>
                    <br>
                    <a class="btn-sm btn-primary" href=" " id="file_hasilbim">Unduh</a>
                  </div>

                </div>

                <!-- /.card-body -->
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="hasil"
                    id="hasil">Dibaca</button>
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
            <h5 class="modal-title" id="exampleModalLabel">Ubahs Bimbingan Proposal</h5>
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
                  <label for="judul">Judul Skripsi</label>
                  <input type="text" class="form-control" id="judul" name="judul" readonly>
                </div>
                <div class="form-group col-md-3">
                  <label for="pembimbing">Dosen Pembimbing</label>
                  <input type="text" class="form-control" id="pembimbing" name="pembimbing" readonly>
                </div>
              </div>
              <div class="form-row">
                <!-- <div class="form-group col-md-3">
                      <label for="pesan">Pesan</label>
                      <textarea name="pesan1" id="pesan1" cols="1" rows="1" class="form-control" readonly></textarea>
                      </div> -->
                <div class="form-group col-md-3">
                  <label for="subjek">Subjek Bimbingan</label>
                  <textarea name="subjek" id="subjek" cols="1" rows="1" class="form-control"></textarea>
                </div>
                <div class="form-group col-md-3">
                  <label for="desk">Deskripsi Bimbingan</label>
                  <textarea name="desk" id="desk" cols="1" rows="1" class="form-control"></textarea>
                </div>
                <div class="form-group col-md-2">
                  <label for="filebim">File Bimbingan</label>
                  <br>
                  <a class="btn-sm btn-primary" href="" id="filebim" name="filebim">Unduh</a>
                </div>
                <div class="form-group col-md-4">
                  <label for="filebim">File Bimbingan Baru</label>
                  <input type="file" name="filebim" id="filebim" class="form-control-file">
                  <br>
                  <small><b>PDF, Max Size 10 MB</b></small>
                </div>
                <!-- <div class="form-group col-md-3">
                      <label for="tanggal">Tanggal Bimbingan</label>
                      <input type="text" class="form-control" id="tanggal" name="tanggal" readonly>
                      </div>
                      <div class="form-group col-md-3">
                      <label for="hasilbim">Hasil Bimbingan</label>
                      <input type="text" class="form-control" id="hasilbim" name="hasilbim" readonly>
                      </div> -->
                <!-- <div class="form-group col-md-3">
                      <label for="desk">Deskripsi Bimbingan</label>
                      <textarea name="desk" id="desk" cols="1" rows="1" class="form-control" readonly></textarea>
                      </div> -->

                <!-- <div class="form-group col-md-2">
                      <label for="file_hasilbim">File Hasil Bimbingan</label>
                      <br>
                      <a class="btn-sm btn-primary" href=" " id="file_hasilbim">Unduh</a>
                      </div> -->

              </div>

              <!-- /.card-body -->
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="ubahbim"
                  id="ubahbim">Dibaca</button>
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
<!-- /.content -->
<?php }else{?>
<div class="alert alert-danger" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <b>Anda Belum Memiliki Dosen Pembimbing Proposal!</b>
</div>
<?php }}else{?>
<div class="alert alert-danger" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <b>Anda Belum Memiliki Judul Yang Disetujui Atau Anda Belum Mempunyai Judul, Silahkan Ajukan Judul Terlebih Dahulu</b>
</div>
<?php }?>
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
    let id = $(this).data('id');
    let dosbing = $(this).data('dosbing');
    let judul = $(this).data('judul');
    let filebim = $(this).data('filebim');
    let hasilbim = $(this).data('hasilbim');
    let tgl = $(this).data('tgl');
    let subjek = $(this).data('subjek');
    let desk = $(this).data('desk');
    let pesan = $(this).data('pesan');
    let status = $(this).data('status');
    let status_dos = $(this).data('status_dosbing');
    $("#modal-lg1 #hasilbim").val(status);
    $("#modal-lg1 #id").val(id);
    $("#modal-lg1 #filebim").attr("href", "assets/downloadbimprop.php?filename=" + filebim);
    $("#modal-lg1 #file_hasilbim").attr("href", "assets/downloadhasilbimprop.php?filename=" + hasilbim);
    $("#modal-lg1 #pesan1").val(pesan);
    $("#modal-lg1 #subjek").val(subjek);
    $("#modal-lg1 #desk").val(desk);
    $("#modal-lg1 #tanggal").val(tgl);
    $("#modal-lg1 #judul").val(judul);
    $("#modal-lg1 #pembimbing").val(dosbing);
    $("#modal-lg1 #tgl_sid").val(tglsid);
  });

  // detail data
  $(document).on("click", "#detailbim1", function () {
    let id = $(this).data('id');
    let dosbing = $(this).data('dosbing');
    let judul = $(this).data('judul');
    let filebim = $(this).data('filebim');
    let hasilbim = $(this).data('hasilbim');
    let tgl = $(this).data('tgl');
    let subjek = $(this).data('subjek');
    let desk = $(this).data('desk');
    let pesan = $(this).data('pesan');
    let status = $(this).data('status');
    let status_dos = $(this).data('status_dosbing');
    $("#modal-lg11 #id").val(id);
    $("#modal-lg11 #filebim").attr("href", "assets/downloadbimprop.php?filename=" + filebim);
    $("#modal-lg11 #file_hasilbim").attr("href", "assets/downloadhasilbimprop.php?filename=" + hasilbim);
    $("#modal-lg11 #pesan1").val(pesan);
    $("#modal-lg11 #subjek").val(subjek);
    $("#modal-lg11 #desk").val(desk);
    $("#modal-lg11 #tanggal").val(tgl);
    $("#modal-lg11 #judul").val(judul);
    $("#modal-lg11 #pembimbing").val(dosbing);
    $("#modal-lg11 #tgl_sid").val(tglsid);
    $("#modal-lg11 #status_bim1").val(status);
  });
</script>
</body>

</html>