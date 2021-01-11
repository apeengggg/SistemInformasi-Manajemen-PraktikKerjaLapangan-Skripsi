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
$id = mysqli_query($conn, "SELECT skripsi.id_skripsi FROM skripsi LEFT JOIN proposal ON skripsi.id_proposal=proposal.id_proposal LEFT JOIN judul ON proposal.id_judul=judul.id_judul LEFT JOIN mahasiswa ON mahasiswa.nim=judul.nim WHERE judul.nim='$nim' AND status_judul='Disetujui'") or die (mysqli_error($conn));
$getid = mysqli_fetch_array($id);
$id_proposal= $getid["id_skripsi"];

//ambil data lampiran revisi
$getlamp = mysqli_query($conn, "SELECT skripsi.lem_rev_pend, mahasiswa.nim FROM skripsi LEFT JOIN proposal ON skripsi.id_proposal=proposal.id_proposal LEFT JOIN judul ON proposal.id_judul=judul.id_judul LEFT JOIn mahasiswa ON judul.nim=mahasiswa.nim WHERE judul.nim='$nim' AND status_judul='Disetujui' AND skripsi.lem_rev_pend IS NULL");

// unggah lembar revisi
if (isset($_POST["unggah"])) {
  $ekstensi = array("pdf");
  $lemrev = $_FILES["lem_rev"]["name"];
  $ukuran = $_FILES["lem_rev"]["size"];
  $ambil_ekstensi = explode(".", $lemrev);
  $eks = $ambil_ekstensi[1];
  $newlemrev = $nim.'-'.$namefile.'-'.$lemrev;
  $pathlemrev= '../../assets/lembar_revisi_pend/'.$newlemrev;
  if (in_array($eks, $ekstensi)) {
    if ($ukuran > 250000) {
      echo "<script>
      alert('Maximal File Size 250 KB')
      windows.location.href='pascapend.php'
      </script>";
    }else{
      $lemrev_tmp = $_FILES["lem_rev"]["tmp_name"];
      if (move_uploaded_file($lemrev_tmp, $pathlemrev)) {
        $insertlem = mysqli_query($conn, "UPDATE skripsi SET lem_rev_pend='$newlemrev' WHERE id_skripsi='$id_proposal'") or die (mysqli_erorr($conn));
        if ($insertlem) {
          echo "<script>
          alert('Berhasil Mengunggah Lembar Revisi!')
          windows.location.href='pascapend.php'
          </script>";
        }else {
          echo "<script>
          alert('Gagal Mengunggah Lembar Revisi!')
          windows.location.href='pascapend.php'
          </script>";
        }
      }
    }
  }else {
    echo "<script>
    alert('Gagal Mengunggah Lembar Revisi, Ekstensi Harus PDF!')
    windows.location.href='pascapend.php'
    </script>";   
  }
}
// tambah bimbingan
if (isset($_POST["bimbingan"])) {
  $ekstensi2 = array("pdf");
  $nidn = $_POST["nidn"];
  $tgl = $tanggal;
  $subjek = $_POST["subjek"];
  $desk = $_POST["deskripsi"];
  $idpkl = $getid["id_skripsi"];
  $status='Bimbingan Pasca';
  $filebim= $_FILES["filebim"]["name"];
  $ukuran= $_FILES["filebim"]["size"];
  $ambil_ekstensi2 = explode(".", $filebim);
  $eks2 = $ambil_ekstensi2[1];
  $newfilebim = $nim.'-'.$namefile.'-'.$filebim;
  $pathfilebim = '../../assets/bim_draft/'.$newfilebim;
  if (mysqli_num_rows($getlamp)>0) {
    echo "<script>
    alert('Anda belum mengunggah lembar revisi!')
    windows.location.href='pascapend.php'
    </script>";  
  }else {
    if (in_array($eks2, $ekstensi2)) {
      if ($ukuran > 20000000) {
        echo "<script>
        alert('Maximal File Size 20 MB')
        windows.location.href='pascapend.php'
        </script>";
      }else{
        $filebim_tmp = $_FILES["filebim"]["tmp_name"];  
        if (move_uploaded_file($filebim_tmp, $pathfilebim)) {
          $tambahbim = mysqli_query($conn, "INSERT INTO skripsi_bim (id_skripsi, nim, pembimbing, tgl_bim, subjek, deskripsi, file_bim, status)
          VALUES ('$idpkl' ,'$nim', '$nidn', '$tgl', '$subjek', '$desk', '$newfilebim', '$status')") or die (mysqli_error($conn));
          if ($tambahbim) {
            echo "<script>
            alert('Berhasil Melakukan Bimbingan!')
            windows.location.href='pascapend.php'
            </script>";
          }else {
            echo "<script>
            alert('Gagal Melakukan Bimbingan!')
            windows.location.href='pascapend.php'
            </script>";
          }
        }
      }
    }else {
      echo "<script>
      alert('Gagal Melakukan Bimbingan, File yang diunggah Harus PDF')
      windows.location.href='pascapend.php'
      </script>";   
    }}}
    
    // baca mahasiswa
    // baca mahasiswa
    if(isset($_POST["hasilbim"])) {
      $id=$_POST["id"];
      $status_mhs = "Dibaca";
      // cek apakah sudah terisi filehasil bimbingannya
      $cekfile = mysqli_query($conn, "SELECT file_hasilbim FROM skripsi_bim WHERE id_bim='$id' AND file_hasilbim IS NULL");
      if(mysqli_num_rows($cekfile)===1) {
        echo "<script>
        windows.location.href='pascapend.php'
        </script>";
      }else{
        $update = mysqli_query($conn, "UPDATE skripsi_bim SET status_mhs='$status_mhs' WHERE id_bim='$id'");
      }
    }
    
    if (isset($_POST["ubahbim"])) {
      $id = $_POST["id"];
      $cek = mysqli_query($conn, "SELECT status_bim FROM skripsi_bim WHERE id_bim='$id' AND status_bim IS NOT NULL");
      if (mysqli_num_rows($cek)>0) {
        echo "<script>
        alert('Bimbingan Gagal Diubah, Dosen Pembimbing Sudah Mengirim Hasil Bimbingan')
        windows.location.href='pascapend.php'
        </script>";
      }else{
        $subjek = $_POST["subjek"];
        $desk = $_POST["desk"];
        $ekstensi2 = array("pdf");
        $filebim= $_FILES["filebim"]["name"];
        $ukuran= $_FILES["filebim"]["size"];
        if (empty($filebim)) {
          $sql = mysqli_query($conn, "UPDATE skripsi_bim SET subjek='$subjek', deskripsi='$desk'
          WHERE id_bim='$id'");
          if ($sql) {
            echo "<script>
            alert('Bimbingan Berhasil diubah tanpa perubahan pada file bimbingan')
            windows.location.href='pascapend.php'
            </script>";
          }else {
            echo "<script>
            alert('Bimbingan Gagal diubah')
            windows.location.href='pascapend.php'
            </script>";
          }
        }else {
          $ambil_ekstensi1 = explode(".", $filebim);
          $eks = $ambil_ekstensi1[1];
          $newfilebim = $nim.'-'.$namefile.'-'.$filebim;
          $status='Bimbingan Pasca';
          $pathfilebim = '../../assets/bim_draft/'.$newfilebim;
          $filelama = mysqli_query($conn, "SELECT file_bim FROM skripsi_bim WHERE id_bim='$id'");
          $d = mysqli_fetch_array($filelama);
          if (in_array($eks, $ekstensi2)) {
            if ($ukuran > 20000000) {
              echo "<script>
              alert('Maximal File Size 20 MB')
              windows.location.href='pascapend.php'
              </script>";
            }else{
              $filebim_tmp = $_FILES["filebim"]["tmp_name"];
              if (move_uploaded_file($filebim_tmp, $pathfilebim)) {
                unlink('../../assets/bim_draft/'.$d["file_bim"]);
                $tambahbim = mysqli_query($conn, "UPDATE skripsi_bim SET subjek='$subjek', deskripsi='$desk',
                file_bim='$newfilebim' WHERE id_bim='$id'") or die (mysqli_error($conn));
                if ($tambahbim) {
                  echo "<script>
                  alert('Berhasil Mengubah Bimbingan!')
                  windows.location.href='pascapend.php'
                  </script>";
                }else {
                  echo "<script>
                  alert('Gagal Mengubah Bimbingan!')
                  windows.location.href='pascapend.php'
                  </script>";
                }
              }
            }
          }else {
            echo "<script>
            alert('Gagal Melakukan Bimbingan, File yang harus di unggah Harus PDF')
            windows.location.href='pascapend.php'
            </script>";    
          }
        }
      }
    }
    
    if (isset($_POST["ubahlem"])) {
      $d = $getid["id_skripsi"];
      $q = mysqli_query($conn, "SELECT lem_rev_pend FROM skripsi WHERE id_skripsi='$d'");
      $a = mysqli_fetch_array($q);
      $ekstensi = array("pdf");
      $lemrev = $_FILES["lemrev"]["name"];
      $ukuran = $_FILES["lemrev"]["size"];
      // var_dump($lemrev); 
      // var_dump($d); die;
      $ambil_ekstensi = explode(".", $lemrev);
      $eks = $ambil_ekstensi[1];
      $newlemrev = $nim.'-'.$namefile.'-'.$lemrev;
      $pathlemrev= '../../assets/lembar_revisi_pend/'.$newlemrev;
      if (in_array($eks, $ekstensi)) {
        if ($ukuran > 250000) {
          echo "<script>
          alert('Maximal File Size 250 KB')
          windows.location.href='pascaspend.php'
          </script>";
        }else{
          $lemrev_tmp = $_FILES["lemrev"]["tmp_name"];
          if (move_uploaded_file($lemrev_tmp, $pathlemrev)) {
            unlink('../../assets/lembar_revisi_pend/'.$a["lem_rev_pend"]);
            $insertlem = mysqli_query($conn, "UPDATE skripsi SET lem_rev_pend='$newlemrev' WHERE id_skripsi='$d'") or die (mysqli_erorr($conn));
            if ($insertlem) {
              echo "<script>
              alert('Berhasil Mengubah Lembar Revisi!')
              windows.location.href='pascaspend.php'
              </script>";
            }else {
              echo "<script>
              alert('Gagal Mengubah Lembar Revisi!')
              windows.location.href='pascaspend.php'
              </script>";
            }
          }
        }
      }else {
        echo "<script>
        alert('File yang diunggah harus berekstensi PDF')
        windows.location.href='pascaspend.php'
        </script>";   
      }
    }
    ?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Bimbingan Pasca | SIM-PS | Mahasiswa</title>
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
          <!-- <h1 class="m-0 text-dark">Data Bimbingan Pasca</h1> -->
          <!-- cek lembar revisi -->
          <?php
    $cekjudul = mysqli_query($conn, "SELECT * FROM judul WHERE nim='$nim' AND status_judul='Disetujui'");
    if (mysqli_num_rows($cekjudul)<1) {
      ?>
          <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <b>Anda Belum Memiliki Judul Skripsi Atau Judul Yang Anda Ajukan Belum Disetujui, Silahkan Ajukan Judul
              Terlebih Dahulu</b>
          </div>
          <?php }else{
        ?>
          <section class="content">
            <div class="row">
              <?php
        $cekdosbing = mysqli_query($conn, "SELECT * FROM pend_sidang ps INNER JOIN skripsi s 
        ON ps.id_skripsi=s.id_skripsi INNER JOIN proposal p ON s.id_proposal=p.id_proposal
        INNER JOIN judul ON p.id_judul=judul.id_judul INNER JOIN mahasiswa m
        ON judul.nim=m.nim WHERE m.nim='$nim' AND ps.status_sidang='Lulus'");
        if (mysqli_num_rows($cekdosbing)<1) {
          ?>
              <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <b>Anda Belum Melakukan Sidang Pendadaran/Sidang Pendadaran Anda Belum Lulus, Silahkan hubungi Tata
                  Usaha</b>
              </div>
              <?php }else{
            $ceklem = mysqli_query($conn, "SELECT skripsi.lem_rev_pend, mahasiswa.nama FROM skripsi LEFT JOIN proposal ON skripsi.id_proposal=proposal.id_proposal LEFT JOIN judul ON proposal.id_judul=judul.id_judul LEFT JOIN mahasiswa ON judul.nim=mahasiswa.nim WHERE judul.nim='$nim' AND judul.status_judul='Disetujui' AND skripsi.lem_rev_pend IS NULL");
            if (mysqli_num_rows($ceklem)===1) {
              ?>
              <div class="alert alert-danger" role="alert">
                <b>Anda belum mengunggah file lembar revisi</b>. unggah terlebih dahulu untuk melakukan bimbingan pasca
                sidang<br>
                Untuk mengunggah <button name="lem_rev" id="lem_rev" data-toggle="modal" data-target="#modal-lg2"
                  class="btn-sm btn-warning"><b>Klik Disini</b></button>
              </div>
              <?php } ?>
            </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <!-- kolom penguji sidang -->
      <?php 
              $getpenguji = mysqli_query($conn, 
              "SELECT DISTINCT
              -- nidn 1
              (SELECT d1.nidn FROM dosen d1 INNER JOIN pend_penguji pp
              ON d1.nidn=pp.penguji WHERE pp.id_sidang=ps.id_sidang AND status_penguji='Penguji 1'
              AND pp.status='Aktif' LIMIT 0,1) AS nidn1,
              -- penguji 1
              (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN pend_penguji pp
              ON d1.nidn=pp.penguji WHERE pp.id_sidang=ps.id_sidang AND status_penguji='Penguji 1'
              AND pp.status='Aktif' LIMIT 0,1) AS penguji1,
              -- foto 1
              (SELECT d1.foto_dosen FROM dosen d1 INNER JOIN pend_penguji pp
              ON d1.nidn=pp.penguji WHERE pp.id_sidang=ps.id_sidang AND status_penguji='Penguji 1'
              AND pp.status='Aktif' LIMIT 0,1) AS foto1,
              -- nidn 2
              (SELECT d1.nidn FROM dosen d1 INNER JOIN pend_penguji pp
              ON d1.nidn=pp.penguji WHERE pp.id_sidang=ps.id_sidang AND status_penguji='Penguji 2'
              AND pp.status='Aktif' LIMIT 0,1) AS nidn2,
              -- penguji 2
              (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN pend_penguji pp
              ON d1.nidn=pp.penguji WHERE pp.id_sidang=ps.id_sidang AND status_penguji='Penguji 2'
              AND pp.status='Aktif' LIMIT 0,1) AS penguji2,
              -- foto 2
              (SELECT d1.foto_dosen FROM dosen d1 INNER JOIN pend_penguji pp
              ON d1.nidn=pp.penguji WHERE pp.id_sidang=ps.id_sidang AND status_penguji='Penguji 2'
              AND pp.status='Aktif' LIMIT 0,1) AS foto2
              FROM pend_sidang ps 
              LEFT JOIN skripsi s ON ps.id_skripsi=s.id_skripsi
              LEFT JOIN proposal p ON s.id_proposal=p.id_proposal
              LEFT JOIN judul j ON p.id_judul=j.id_judul
              LEFT JOIN mahasiswa m ON j.nim=m.nim 
              WHERE m.nim='$nim' AND j.status_judul='Disetujui'");
              $datapenguji = mysqli_fetch_array($getpenguji); ?>
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <center>
              <h4>Penguji 1</h4>
            </center>
          </div>
          <div class="card-body">
            <?php 
              $id1 = base64_encode($datapenguji["nidn1"]);
              $id2 = base64_encode($datapenguji["nidn2"]); ?>
            <table align="center">
              <tr>
                <td colspan="3" align="center">
                  <img src="../../assets/foto/<?= $datapenguji["foto1"]?>" width="140px" height="150px" alt="">
                </td>
              </tr>
              <tr>
              <td colspan="3"><hr></td>
              </tr>
              <tr>
                <td><h5>NIDN</h5></td>
                <td><h5>:</h5></td>
                <td><h5><?= $datapenguji["nidn1"] ?></h5></td>
              </tr>
              <tr>
              <td colspan="3"><hr></td>
              </tr>
              <tr>
                <td><h5>Nama</h5></td>
                <td><h5>:</h5></td>
                <td><h5><?= $datapenguji["penguji1"] ?></h5></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <center>
              <h4>Penguji 2</h4>
            </center>
          </div>
          <div class="card-body">
          <table align="center">
              <tr>
                <td colspan="3" align="center">
                  <img src="../../assets/foto/<?= $datapenguji["foto2"]?>" width="140px" height="150px" alt="">
                </td>
              </tr>
              <tr>
              <td colspan="3"><hr></td>
              </tr>
              <tr>
                <td><h5>NIDN</h5></td>
                <td><h5>:</h5></td>
                <td><h5><?= $datapenguji["nidn2"] ?></h5></td>
              </tr>
              <tr>
              <td colspan="3"><hr></td>
              </tr>
              <tr>
                <td><h5>Nama</h5></td>
                <td><h5>:</h5></td>
                <td><h5><?= $datapenguji["penguji2"] ?></h5></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- /.row -->

    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <center>
            <h2>Data Bimbingan Pasca Sidang Pendadaran</h2><br>
          </center>
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-lg">
            <i class="fas fa-plus"></i> Bimbingan
          </button>
          <button class="btn btn-info" name="ubahlem" id="ubahlem" data-toggle="modal" data-target="#modal-lg3"
            data-id="<?=$id_proposal?>"><i class="fas fa-edit"></i> Ubah Lembar Revisi</button>
        </div>
        <?php
              //ambil data pembimbing
              $pemb = mysqli_query($conn, 
              "SELECT DISTINCT
              -- nidn 1
              (SELECT d1.nidn FROM dosen d1 INNER JOIN pend_penguji pp
              ON d1.nidn=pp.penguji WHERE pp.id_sidang=ps.id_sidang AND status_penguji='Penguji 1'
              AND pp.status='Aktif' LIMIT 0,1) AS nidn1,
              -- penguji 1
              (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN pend_penguji pp
              ON d1.nidn=pp.penguji WHERE pp.id_sidang=ps.id_sidang AND status_penguji='Penguji 1'
              AND pp.status='Aktif' LIMIT 0,1) AS penguji1,
              -- foto 1
              (SELECT d1.foto_dosen FROM dosen d1 INNER JOIN pend_penguji pp
              ON d1.nidn=pp.penguji WHERE pp.id_sidang=ps.id_sidang AND status_penguji='Penguji 1'
              AND pp.status='Aktif' LIMIT 0,1) AS foto1,
              -- nidn 2
              (SELECT d1.nidn FROM dosen d1 INNER JOIN pend_penguji pp
              ON d1.nidn=pp.penguji WHERE pp.id_sidang=ps.id_sidang AND status_penguji='Penguji 2'
              AND pp.status='Aktif' LIMIT 0,1) AS nidn2,
              -- penguji 2
              (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN pend_penguji pp
              ON d1.nidn=pp.penguji WHERE pp.id_sidang=ps.id_sidang AND status_penguji='Penguji 2'
              AND pp.status='Aktif' LIMIT 0,1) AS penguji2,
              -- foto 2
              (SELECT d1.foto_dosen FROM dosen d1 INNER JOIN pend_penguji pp
              ON d1.nidn=pp.penguji WHERE pp.id_sidang=ps.id_sidang AND status_penguji='Penguji 2'
              AND pp.status='Aktif' LIMIT 0,1) AS foto2,
              -- pembimbing 1
              (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd
              ON d1.nidn=sd.nidn WHERE sd.id_skripsi=s.id_skripsi AND status_dosbing='Pembimbing 1'
              AND sd.status='Aktif' LIMIT 0,1) AS pem1,
              -- nidn 1
              (SELECT d1.nidn FROM dosen d1 INNER JOIN skripsi_dosbing sd
              ON d1.nidn=sd.nidn WHERE sd.id_skripsi=s.id_skripsi AND status_dosbing='Pembimbing 1'
              AND sd.status='Aktif' LIMIT 0,1) AS nidn11,
              -- pembimbing 2
              (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd
              ON d1.nidn=sd.nidn WHERE sd.id_skripsi=s.id_skripsi AND status_dosbing='Pembimbing 2'
              AND sd.status='Aktif' LIMIT 0,1) AS pem2,
              -- nidn 2
              (SELECT d1.nidn FROM dosen d1 INNER JOIN skripsi_dosbing sd
              ON d1.nidn=sd.nidn WHERE sd.id_skripsi=s.id_skripsi AND status_dosbing='Pembimbing 2'
              AND sd.status='Aktif' LIMIT 0,1) AS nidn22
              FROM pend_sidang ps 
              LEFT JOIN skripsi s ON ps.id_skripsi=s.id_skripsi
              LEFT JOIN proposal p ON s.id_proposal=p.id_proposal
              LEFT JOIN judul j ON p.id_judul=j.id_judul
              LEFT JOIN mahasiswa m ON j.nim=m.nim 
              WHERE ps.status_sidang='Lulus' AND m.nim='$nim'") or die (mysqli_error($conn));
              ?>

        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead align="center">
              <tr>
                <th>Nama Penguji</th>
                <th>Tanggal</th>
                <th>Subjek</th>
                <th>Status Dosen</th>
                <th>Status Mahasiswa</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              //ambi data bimbingan
              $getdata = mysqli_query($conn,
              "SELECT d3.nama_dosen AS penguji,
              mhs.nim AS nim, 
              mhs.nama AS nama, 
              mhs.foto AS foto, 
              judul.judul AS judul, 
              s.lem_rev_pend,
              -- pem1
              (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd
              ON d1.nidn=sd.nidn WHERE sd.id_skripsi=s.id_skripsi AND
              sd.status='Aktif' AND status_dosbing='Pembimbing 1' LIMIT 0,1) AS pem1,
              -- pem2
              (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd
              ON d1.nidn=sd.nidn WHERE sd.id_skripsi=s.id_skripsi AND
              sd.status='Aktif' AND status_dosbing='Pembimbing 2' LIMIT 0,1) AS pem2,
              ps.tgl_sidang AS tanggal_sidang, 
              ps.ruang_sidang AS ruang_sidang, 
              ps.waktu_sidang AS waktu_sidang,
              bim.file_bim AS filebim,
              bim.file_hasilbim AS hasilbim,
              bim.tgl_bim AS tanggal_bim, 
              bim.subjek AS subjek_bim, 
              bim.deskripsi AS deskripsi_bim, 
              bim.saran AS pesan_bim, 
              bim.status_bim AS status_bim, 
              bim.status_dosbing AS dosbing, 
              bim.id_bim AS id, 
              bim.status_mhs AS mahasiswa
              FROM skripsi_bim bim LEFT JOIN skripsi s
              ON bim.id_skripsi=s.id_skripsi
              LEFT JOIN proposal
              ON s.id_proposal=proposal.id_proposal
              LEFT JOIN pend_sidang ps
              ON s.id_skripsi=ps.id_skripsi
              LEFT JOIN judul
              ON proposal.id_judul=judul.id_judul
              LEFT JOIN mahasiswa mhs
              ON judul.nim=mhs.nim
              LEFT JOIN dosen d3 
              ON bim.pembimbing=d3.nidn
              WHERE bim.nim='$nim'AND bim.status='Bimbingan Pasca' 
              ORDER BY bim.status_dosbing ASC")
              or die (mysqli_erorr($conn));
              if (mysqli_num_rows($getdata) > 0) {
                while ($data=mysqli_fetch_array($getdata)) {
                  ?>
              <tr>
                <td><?= $data["penguji"]  ?></td>
                <td><?= $data["tanggal_bim"]  ?></td>
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
                  <button type="submit" class="btn-sm btn-dark" name="detail" data-toggle="modal"
                    data-target="#modal-lg1" id="detailbim" data-id="<?php echo $data["id"]?>"
                    data-dosbing1="<?php echo $data["pem1"]?>" data-dosbing2="<?php echo $data["pem2"]?>"
                    data-penguji="<?php echo $data["penguji"]?>" data-judul="<?php echo $data["judul"]?>"
                    data-tglsid="<?php echo $data["tanggal_sidang"]?>"
                    data-ruangsid="<?php echo $data["ruang_sidang"]?>"
                    data-waktusid="<?php echo $data["waktu_sidang"]?>" data-filebim="<?php echo $data["filebim"]?>"
                    data-hasilbim="<?php echo $data["hasilbim"]?>" data-tanggal_bim="<?php echo $data["tanggal_bim"]?>"
                    data-subjek="<?php echo $data["subjek_bim"]?>" data-desk="<?php echo $data["deskripsi_bim"]?>"
                    data-pesan="<?php echo $data["pesan_bim"]?>" data-status="<?php echo $data["status_bim"]?>"
                    data-status_dosbing="<?php echo $data["dosbing"]?>"
                    data-lemrev="<?php echo $data["lem_rev_pend"]?>"><i class="fas fa-info-circle"></i></button>
                  <button type="submit" class="btn-sm btn-dark" name="detail" data-toggle="modal"
                    data-target="#modal-lg11" id="detailbim1" data-id="<?php echo $data["id"]?>"
                    data-dosbing1="<?php echo $data["pem1"]?>" data-dosbing2="<?php echo $data["pem2"]?>"
                    data-penguji="<?php echo $data["penguji"]?>" data-judul="<?php echo $data["judul"]?>"
                    data-tglsid="<?php echo $data["tanggal_sidang"]?>"
                    data-ruangsid="<?php echo $data["ruang_sidang"]?>"
                    data-waktusid="<?php echo $data["waktu_sidang"]?>" data-filebim="<?php echo $data["filebim"]?>"
                    data-hasilbim="<?php echo $data["hasilbim"]?>" data-tanggal_bim="<?php echo $data["tanggal_bim"]?>"
                    data-subjek="<?php echo $data["subjek_bim"]?>" data-desk="<?php echo $data["deskripsi_bim"]?>"
                    data-pesan="<?php echo $data["pesan_bim"]?>" data-status="<?php echo $data["status_bim"]?>"
                    data-status_dosbing="<?php echo $data["dosbing"]?>"
                    data-lemrev="<?php echo $data["lem_rev_pend"]?>"><i class="fas fa-edit"></i></button>
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
    <!-- /.col -->
</div>
<!-- /.row -->
<?php }}?>
</section>
<!-- /.content -->
<!-- modal unggah lem rev -->
<div class="modal fade" id="modal-lg2">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Unggah File Lembar Revisi</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="card-body">
            <div class="form-group row">
              <label for="lem_rev" class="col-sm-5 col-form-label">Lembar Revisi</label>
              <div class="col-sm-7">
                <input type="file" id="lem_rev" name="lem_rev" required="required">
                <br>
                <small><b>PDF, Maximal File 250 KB</b></small>
              </div>
            </div>
          </div>
          <!-- /.card-body -->
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="unggah" id="unggah">Kirim</button>
      </div>
    </div>
    </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /. modal unggah lem rev -->

<!-- modal tambah bimbingan -->
<div class="modal fade" id="modal-lg">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Form Bimbingan Pasca</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="card-body">
            <div class="form-group row">
              <label for="nidn" class="col-sm-3 co-form-label">Dosen Penguji</label>
              <div class="col-sm-9">
                <select class="form-control" name="nidn" id="nidn" required="required">
                  <option value="">Pilih</option>
                  <?php
                    $datapemb = mysqli_fetch_array($pemb) 
                      ?>
                  <option value="<?=$datapemb["nidn1"]?>"><?=$datapemb["penguji1"]?>
                  </option>
                  <option value="<?=$datapemb["nidn2"]?>"><?=$datapemb["penguji2"]?>
                  </option>
                  <option value="<?=$datapemb["nidn22"]?>"><?=$datapemb["pem2"]?>
                  </option>
                  <option value="<?=$datapemb["nidn11"]?>"><?=$datapemb["pem1"]?>
                  </option>
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
                <small><b>PDF, Maximal File 20 MB </b></small>
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

<!-- modal ubah lembar revisi -->
<div class="modal fade" id="modal-lg3">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Ubah Lembar Revisi</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="card-body">
            <div class="form-group row">
              <div class="col-sm-9">
                <input type="text" id="id" name="id" readonly hidden>
                <!-- <textarea class="form-control" rows="3" placeholder="Pesan" name="id" id="id" required="required"></textarea> -->
              </div>
            </div>
            <div class="form-group row">
              <label for="filebim" class="col-sm-3 col-form-label">Lembar Revisi Baru</label>
              <div class="col-sm-9">
                <input type="file" id="lemrev" name="lemrev" required="required">
                <br>
                <small><b>PDF, Maximal File 250 KB</b></small>
              </div>
            </div>
          </div>
          <!-- /.card-body -->
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="ubahlem" id="ubahlem">Ubah</button>
      </div>
    </div>
    </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- modal ubah lembar revisi -->


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
        <h5 class="modal-title" id="exampleModalLabel">Detail Bimbingan Pasca</h5>
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
            <div class="form-group col-md-4">
              <label for="penguji">Nama Penguji</label>
              <input type="text" class="form-control" id="penguji" name="penguji" readonly>
            </div>
            <div class="form-group col-md-3">
              <label for="subjek">Subjek Bimbingan</label>
              <input type="text" class="form-control" id="subjek" name="subjek" readonly>
            </div>
            <div class="form-group col-md-3">
              <label for="tanggal">Tanggal Bimbingan</label>
              <input type="text" class="form-control" id="tanggal" name="tanggal" readonly>
            </div>
            <div class="form-group col-md-2">
              <label for="filebim">File Bimbingan</label>
              <br>
              <a class="btn-sm btn-primary" href="" id="filebim" name="filebim">Unduh</a>
            </div>
          </div>
          <div class="form-row">
          </div>
          <div class="form-row">
            <div class="form-group col-md-3">
              <label for="pesan">Pesan</label>
              <textarea name="pesan1" id="pesan1" cols="1" rows="1" class="form-control" readonly></textarea>
            </div>
            <div class="form-group col-md-3">
              <label for="status_bim1">Hasil Bimbingan</label>
              <input type="text" class="form-control" id="status_bim1" name="status_bim1" readonly>
            </div>
            <div class="form-group col-md-3">
              <label for="file_hasilbim">File Hasil Bimbingan</label>
              <br>
              <a class="btn-sm btn-primary" href=" " id="file_hasilbim">Unduh</a>
            </div>
            <div class="form-group col-md-2">
              <label for="lem_rev">Lembar Revisi</label>
              <br>
              <a class="btn-sm btn-primary" href="" id="lem_rev">Unduh</a>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="judul">Judul Skripsi</label>
              <textarea name="judul" id="judul" cols="1" rows="1" class="form-control" readonly></textarea>
            </div>
            <div class="form-group col-md-3">
              <label for="pembimbing">Dosen Pembimbing1</label>
              <input type="text" class="form-control" id="dosbing1" name="dosbing1" readonly>
            </div>
            <div class="form-group col-md-3">
              <label for="pembimbing">Dosen Pembimbing2</label>
              <input type="text" class="form-control" id="dosbing2" name="dosbing2" readonly>
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

<!-- ubah bimbingan -->
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
        <h5 class="modal-title" id="exampleModalLabel">Ubah Bimbingan Pasca</h5>
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
            <div class="form-group col-md-6">
              <label for="penguji">Nama Dosen</label>
              <input type="text" class="form-control" id="penguji" name="penguji" readonly>
            </div>
            <div class="form-group col-md-2">
              <label for="filebim">File Bimbingan</label>
              <br>
              <a class="btn-sm btn-primary" href="" id="filebim" name="filebim">Unduh</a>
            </div>
            <div class="form-group col-md-4">
              <label for="filebim">File Bimbingan Baru</label>
              <input type="file" name="filebim" id="filebim" class="form-control-file">
              <small><b>PDF, Maximal File 20 MB</b></small>
            </div>
          </div>
          <div class="form-row">
          </div>
          <div class="form-row">
            <div class="form-group col-md-5">
              <label for="subjek">Subjek Bimbingan</label>
              <input type="text" class="form-control" id="subjek" name="subjek">
            </div>
            <div class="form-group col-md-7">
              <label for="desk">Deskripsi</label>
              <!-- <input type="text" class="form-control" id="desk" name="desk" readonly> -->
              <textarea name="desk" id="desk" cols="30" rows="1" class="form-control"></textarea>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="judul">Judul Skripsi</label>
              <textarea name="judul" id="judul" cols="1" rows="1" class="form-control" readonly></textarea>
            </div>
            <div class="form-group col-md-3">
              <label for="pembimbing">Dosen Pembimbing1</label>
              <input type="text" class="form-control" id="dosbing1" name="dosbing1" readonly>
            </div>
            <div class="form-group col-md-3">
              <label for="pembimbing">Dosen Pembimbing2</label>
              <input type="text" class="form-control" id="dosbing2" name="dosbing2" readonly>
            </div>
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
<!-- /.ubah bimbingan -->
</div>
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
    let dosbing1 = $(this).data('dosbing1');
    let dosbing2 = $(this).data('dosbing2');
    let desk = $(this).data('desk');
    $("#modal-lg1 #id").val(id);
    $("#modal-lg1 #lem_rev").attr("href", "assets/downloadlemrevpend.php?filename=" + lemrev);
    $("#modal-lg1 #penguji").val(penguji);
    $("#modal-lg1 #filebim").attr("href", "assets/downloadbimdraft.php?filename=" + filebim);
    $("#modal-lg1 #file_hasilbim").attr("href", "assets/downloadhasilbimdraft.php?filename=" + hasilbim);
    $("#modal-lg1 #pesan1").val(pesan);
    $("#modal-lg1 #subjek").val(subjek);
    $("#modal-lg1 #desk").val(desk);
    $("#modal-lg1 #tanggal").val(tanggalbim);
    $("#modal-lg1 #judul").val(judul);
    $("#modal-lg1 #pembimbing").val(pembimbing);
    $("#modal-lg1 #tgl_sid").val(tglsid);
    $("#modal-lg1 #ruang_sid ").val(ruangsid);
    $("#modal-lg1 #waktu").val(waktusid);
    $("#modal-lg1 #status_bim1").val(status);
    $("#modal-lg1 #dosbing1").val(dosbing1);
    $("#modal-lg1 #dosbing2").val(dosbing2);
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
    let dosbing1 = $(this).data('dosbing1');
    let dosbing2 = $(this).data('dosbing2');
    let desk = $(this).data('desk');
    $("#modal-lg11 #id").val(id);
    $("#modal-lg11 #lem_rev").attr("href", "assets/downloadlemrevpend.php?filename=" + lemrev);
    $("#modal-lg11 #penguji").val(penguji);
    $("#modal-lg11 #filebim").attr("href", "assets/downloadbimdraft.php?filename=" + filebim);
    $("#modal-lg11 #file_hasilbim").attr("href", "assets/downloadhasilbimdraft.php?filename=" + hasilbim);
    $("#modal-lg11 #pesan1").val(pesan);
    $("#modal-lg11 #subjek").val(subjek);
    $("#modal-lg11 #desk").val(desk);
    $("#modal-lg11 #tanggal").val(tanggalbim);
    $("#modal-lg11 #judul").val(judul);
    $("#modal-lg11 #pembimbing").val(pembimbing);
    $("#modal-lg11 #tgl_sid").val(tglsid);
    $("#modal-lg11 #ruang_sid ").val(ruangsid);
    $("#modal-lg11 #waktu").val(waktusid);
    $("#modal-lg11 #status_bim1").val(status);
    $("#modal-lg11 #dosbing1").val(dosbing1);
    $("#modal-lg11 #dosbing2").val(dosbing2);
  });

  // detail data
  $(document).on("click", "#ubahlem", function () {
    let id = $(this).data('id');
    $("#modal-lg3 #id").val(id);
  });
</script>
</body>

</html>