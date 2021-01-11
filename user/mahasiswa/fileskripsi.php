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
$id = mysqli_query($conn, 
"SELECT skripsi.id_skripsi FROM skripsi LEFT JOIN proposal 
ON skripsi.id_proposal=proposal.id_proposal
LEFT JOIN judul 
ON proposal.id_judul=judul.id_judul 
LEFT JOIN mahasiswa 
ON judul.nim=mahasiswa.nim 
WHERE mahasiswa.nim='$nim' AND status_judul='Disetujui'") or die (mysqli_error($conn));
$getid = mysqli_fetch_array($id);

// insert
if (isset($_POST["unggah"])) {
  $ekstensi1 = array("pdf");
  $ekstensi2 = array("rar", "zip");
  $ekstensi3 = array("jpg", "jpeg");
  $ekstensi4 = array("doc", "docx");
  $draftpdf = $_FILES["draftpdf"]["name"];
  $ukurandraftpdf = $_FILES["draftpdf"]["size"];
  $draftdoc = $_FILES["draftdoc"]["name"];
  $ukurandraftdoc = $_FILES["draftdoc"]["size"];
  $jurnalpdf = $_FILES["jurnalpdf"]["name"];
  $ukuranjurnalpdf = $_FILES["jurnalpdf"]["size"];
  $jurnaldoc = $_FILES["jurnaldoc"]["name"];
  $ukuranjurnaldoc = $_FILES["jurnaldoc"]["size"];
  $aplikasi = $_FILES["aplikasi"]["name"];
  $ukuranaplikasi = $_FILES["aplikasi"]["size"];
  $karbim = $_FILES["karbim"]["name"];
  $ukurankarbim = $_FILES["karbim"]["size"];
  $lempeng = $_FILES["lempeng"]["name"];
  $ukuranlempeng = $_FILES["lempeng"]["size"];
  $cover = $_FILES["cover"]["name"];
  $ukurancover = $_FILES["cover"]["size"];
  $poster = $_FILES["poster"]["name"];
  $ukuranposter = $_FILES["poster"]["size"];
  $ambil_ekstensi1 = explode(".", $draftpdf);
  $ambil_ekstensi2 = explode(".", $draftdoc);
  $ambil_ekstensi3 = explode(".", $jurnalpdf);
  $ambil_ekstensi4 = explode(".", $jurnaldoc);
  $ambil_ekstensi5 = explode(".", $aplikasi);
  $ambil_ekstensi6 = explode(".", $karbim);
  $ambil_ekstensi7 = explode(".", $lempeng);
  $ambil_ekstensi8 = explode(".", $cover);
  $ambil_ekstensi9 = explode(".", $poster);
  $eks1 = $ambil_ekstensi1[1];
  $eks2 = $ambil_ekstensi2[1];
  $eks3 = $ambil_ekstensi3[1];
  $eks4 = $ambil_ekstensi4[1];
  $eks5 = $ambil_ekstensi5[1];
  $eks6 = $ambil_ekstensi6[1];
  $eks7 = $ambil_ekstensi7[1];
  $eks8 = $ambil_ekstensi8[1];
  $eks9 = $ambil_ekstensi9[1];
  $newfile1 = $nim.'-'.$namefile.'-'.$draftpdf;
  $newfile2 = $nim.'-'.$namefile.'-'.$draftdoc;
  $newfile3 = $nim.'-'.$namefile.'-'.$jurnalpdf;
  $newfile4 = $nim.'-'.$namefile.'-'.$jurnaldoc;
  $newfile5 = $nim.'-'.$namefile.'-'.$aplikasi;
  $newfile6 = $nim.'-'.$namefile.'-'.$karbim;
  $newfile7 = $nim.'-'.$namefile.'-'.$lempeng;
  $newfile8 = $nim.'-'.$namefile.'-'.$cover;
  $newfile9 = $nim.'-'.$namefile.'-'.$poster;
  // var_dump($newfile1);
  $id=$getid["id_skripsi"];
  $pathlemrev1= '../../assets/skripsi_draft_pdf/'.$newfile1;
  $pathlemrev2= '../../assets/skripsi_draft_doc/'.$newfile2;
  $pathlemrev3= '../../assets/skripsi_jurnal_pdf/'.$newfile3;
  $pathlemrev4= '../../assets/skripsi_jurnal_doc/'.$newfile4;
  $pathlemrev5= '../../assets/skripsi_app/'.$newfile5;
  $pathlemrev6= '../../assets/skripsi_karbim/'.$newfile6;
  $pathlemrev7= '../../assets/skripsi_lempeng/'.$newfile7;
  $pathlemrev8= '../../assets/skripsi_cover/'.$newfile8;
  $pathlemrev9= '../../assets/skripsi_poster/'.$newfile9;
  if (in_array($eks1, $ekstensi1) && 
      in_array($eks2, $ekstensi4) && 
      in_array($eks3, $ekstensi1) && 
      in_array($eks4, $ekstensi4) && 
      in_array($eks5, $ekstensi2) && 
      in_array($eks6, $ekstensi1) && 
      in_array($eks7, $ekstensi1) && 
      in_array($eks8, $ekstensi1) && 
      in_array($eks9, $ekstensi3)) {
    if ($ukurandraftpdf > 20000000 && 
    $ukuranjurnalpdf > 200000 && 
    $ukurankarbim > 100000 && 
    $ukuranlempeng > 100000 && 
    $ukurancover > 100000 && 
    $ukuranposter > 100000 ) {
      echo "<script>
      alert('Cek Kembali Ukuran File Yang Anda Unggah, Terjadi Kesalahan')
      windows.location.href='fileskripsi.php'
      </script>";
    }else{
      $file_tmp1 = $_FILES["draftpdf"]["tmp_name"];
      $file_tmp2 = $_FILES["draftdoc"]["tmp_name"];
      $file_tmp3 = $_FILES["jurnalpdf"]["tmp_name"];
      $file_tmp4 = $_FILES["jurnaldoc"]["tmp_name"];
      $file_tmp5 = $_FILES["aplikasi"]["tmp_name"];
      $file_tmp6 = $_FILES["karbim"]["tmp_name"];
      $file_tmp7 = $_FILES["lempeng"]["tmp_name"];
      $file_tmp8 = $_FILES["cover"]["tmp_name"];
      $file_tmp9 = $_FILES["poster"]["tmp_name"];
      if (move_uploaded_file($file_tmp1, $pathlemrev1) &&
          move_uploaded_file($file_tmp2, $pathlemrev2) &&
          move_uploaded_file($file_tmp3, $pathlemrev3) &&
          move_uploaded_file($file_tmp4, $pathlemrev4) &&
          move_uploaded_file($file_tmp5, $pathlemrev5) &&
          move_uploaded_file($file_tmp6, $pathlemrev6) &&
          move_uploaded_file($file_tmp7, $pathlemrev7) &&
          move_uploaded_file($file_tmp8, $pathlemrev8) &&
          move_uploaded_file($file_tmp9, $pathlemrev9)) {
        $insertdraftpdf = mysqli_query($conn, "INSERT INTO skripsi_file 
        (id_skripsi, draft_doc, draft_pdf, jurnal_pdf, jurnal_doc,
        aplikasi, kartu_bim, lem_pengesahan, cover, poster) 
        VALUES ('$id', '$newfile2', '$newfile1', '$newfile3',
        '$newfile4','$newfile5','$newfile6','$newfile7',
        '$newfile8','$newfile9')") or die (mysqli_erorr($conn));
        if ($insertdraftpdf) {
          echo "<script>
          alert('Berhasil Mengunggah File skripsi!')
          windows.location.href='fileskripsi.php'
          </script>";     
        }else {
          echo "<script>
          alert('Gagal Mengunggah File skripsi!')
          windows.location.href='fileskripsi.php'
          </script>";
        }    
      }else {
        echo "<script>
        alert('Gagal Mengunggah File skripsi!')
        windows.location.href='fileskripsi.php'
        </script>";
      }
    }
  }else{
    echo "<script>
    alert('Cek Kembali Ekstensi Beberapa File Yang Anda Unggah, Terjadi Kesalahan')
    windows.location.href='fileskripsi.php'
    </script>";
  }
}

// ubah file
if (isset($_POST["ubah"])) {
  // $file_lama = $_POST["nama"];
  $ekstensi1 = array("pdf");
  $ekstensi2 = array("rar", "zip");
  $ekstensi3 = array("jpg", "jpeg");
  $ekstensi4 = array("doc", "docx");
  $draftpdf = $_FILES["draftpdf"]["name"];
  $ukurandraftpdf = $_FILES["draftpdf"]["size"];
  $draftdoc = $_FILES["draftdoc"]["name"];
  $ukurandraftdoc = $_FILES["draftdoc"]["size"];
  $jurnalpdf = $_FILES["jurnalpdf"]["name"];
  $ukuranjurnalpdf = $_FILES["jurnalpdf"]["size"];
  $jurnaldoc = $_FILES["jurnaldoc"]["name"];
  $ukuranjurnaldoc = $_FILES["jurnaldoc"]["size"];
  $aplikasi = $_FILES["aplikasi"]["name"];
  $ukuranaplikasi = $_FILES["aplikasi"]["size"];
  $karbim = $_FILES["karbim"]["name"];
  $ukurankarbim = $_FILES["karbim"]["size"];
  $lempeng = $_FILES["lempeng"]["name"];
  $ukuranlempeng = $_FILES["lempeng"]["size"];
  $cover = $_FILES["cover"]["name"];
  $ukurancover = $_FILES["cover"]["size"];
  $poster = $_FILES["poster"]["name"];
  $ukuranposter = $_FILES["poster"]["size"];

  $id=$_POST["id"];
  $ambil_file_lama = mysqli_query($conn, "SELECT * FROM skripsi_file WHERE id_file='$id'");
  $file_lama = mysqli_fetch_array($ambil_file_lama);
  $file_lama1 = $file_lama["draft_pdf"];
  $file_lama2 = $file_lama["draft_doc"];
  $file_lama3 = $file_lama["jurnal_pdf"];
  $file_lama4 = $file_lama["jurnal_doc"];
  $file_lama5 = $file_lama["aplikasi"];
  $file_lama6 = $file_lama["kartu_bim"];
  $file_lama7 = $file_lama["lem_pengesahan"];
  $file_lama8 = $file_lama["cover"];
  $file_lama9 = $file_lama["poster"];
  if ($draftpdf === "") {
  }else{
    $ambil_ekstensi1 = explode(".", $draftpdf);
    $eks1 = $ambil_ekstensi1[1];
    $newfile1 = $nim.'-'.$namefile.'-'.$draftpdf;
    $pathlemrev1= '../../assets/skripsi_draft_pdf/'.$newfile1;
    if (in_array($eks1, $ekstensi1)) {
      if ($ukurandraftpdf > 20000000) {
        echo "<script>
        alert('Maximal File Size 20 MB')
        windows.location.href='fileskripsi.php'
        </script>";
      }else{
        $file_tmp1 = $_FILES["draftpdf"]["tmp_name"];
        unlink('../../assets/skripsi_draft_pdf/'.$file_lama1);
        if (move_uploaded_file($file_tmp1, $pathlemrev1)) {
        $insertdraftpdf = mysqli_query($conn, "UPDATE skripsi_file 
          SET draft_pdf='$newfile1' 
          WHERE id_file='$id'") or die (mysqli_erorr($conn));
        if ($insertdraftpdf) {
          echo "<script>
          alert('Berhasil Mengubah File Draft PDF')
          </script>";
        }else{
          echo "<script>
          alert('Gagal Mengubah File Draft PDF')
          </script>";
        }
        }else {
          echo "<script>
          alert('Gagal Mengunggah File Draft PDF! Silahkan Unggah Ulang File Anda')
          windows.location.href='fileskripsi.php'
          </script>";
        }
      }
    }else{
      echo "<script>
        alert('File Draft PDF Anda Bukan Berekstensi PDF ! Silahkan Unggah Ulang File Anda')
        windows.location.href='fileskripsi.php'
        </script>";
    }
  }

  if ($draftdoc === "") {
  }else{
  $ambil_ekstensi2 = explode(".", $draftdoc);
  $eks2 = $ambil_ekstensi2[1];
  $newfile2 = $nim.'-'.$namefile.'-'.$draftdoc;
  $pathlemrev2= '../../assets/skripsi_draft_doc/'.$newfile2;
    if (in_array($eks2, $ekstensi4)) {
        $file_tmp2 = $_FILES["draftdoc"]["tmp_name"];
        unlink('../../assets/skripsi_draft_doc/'.$file_lama2);
        if (move_uploaded_file($file_tmp2, $pathlemrev2)) {
        $insertdraftdoc = mysqli_query($conn, "UPDATE skripsi_file 
          SET draft_doc='$newfile2' 
          WHERE id_file='$id'") or die (mysqli_erorr($conn));
          if ($insertdraftdoc) {
            echo "<script>
            alert('Berhasil Mengubah File Draft DOC')
            </script>";
          }else{
            echo "<script>
            alert('Gagal Mengubah File Draft DOC')
            </script>";
          }
        }else {
          echo "<script>
          alert('Gagal Mengunggah File Draft DOC! Silahkan Unggah Ulang File Anda')
          windows.location.href='fileskripsi.php'
          </script>";
        }
    }else{
      echo "<script>
        alert('File Draft DOC Anda Bukan Berekstensi Doc/Docx ! Silahkan Unggah Ulang File Anda')
        windows.location.href='fileskripsi.php'
        </script>";
    }
  }

  if ($jurnalpdf === "") {
  }else{
    $ambil_ekstensi3 = explode(".", $jurnalpdf);
  $eks3 = $ambil_ekstensi3[1];
  $newfile3 = $nim.'-'.$namefile.'-'.$jurnalpdf;
  $pathlemrev3= '../../assets/skripsi_jurnal_pdf/'.$newfile3;
    if (in_array($eks3, $ekstensi1)) {
      if ($ukuranjurnalpdf > 2000000) {
        echo "<script>
        alert('Maximal File Size 2 MB')
        windows.location.href='fileskripsi.php'
        </script>";
      }else{
        $file_tmp2 = $_FILES["jurnalpdf"]["tmp_name"];
        unlink('../../assets/skripsi_jurnal_pdf/'.$file_lama3);
        if (move_uploaded_file($file_tmp3, $pathlemrev3)) {
        $insertjurnalpdf = mysqli_query($conn, "UPDATE skripsi_file 
          SET jurnal_pdf='$newfile3' 
          WHERE id_file='$id'") or die (mysqli_erorr($conn)); 
        }else {
          echo "<script>
          alert('Gagal Mengunggah File Jurnal PDF! Silahkan Unggah Ulang File Anda')
          windows.location.href='fileskripsi.php'
          </script>";
        }
      }
    }else{
      echo "<script>
        alert('File Jurnal PDF Anda Bukan Berekstensi PDF ! Silahkan Unggah Ulang File Anda')
        windows.location.href='fileskripsi.php'
        </script>";
    }
  }

  if ($jurnaldoc === "") {
  }else{
    $ambil_ekstensi4 = explode(".", $jurnaldoc);
  $eks4 = $ambil_ekstensi4[1];
  $newfile4 = $nim.'-'.$namefile.'-'.$jurnaldoc;
  $pathlemrev4= '../../assets/skripsi_jurnal_doc/'.$newfile4;
    if (in_array($eks4, $ekstensi4)) {
        $file_tmp2 = $_FILES["jurnaldoc"]["tmp_name"];
        unlink('../../assets/skripsi_jurnal_doc/'.$file_lama4);
        if (move_uploaded_file($file_tmp4, $pathlemrev4)) {
        $insertjurnaldoc = mysqli_query($conn, "UPDATE skripsi_file 
          SET jurnal_doc='$newfile4' 
          WHERE id_file='$id'") or die (mysqli_erorr($conn));
        }else {
          echo "<script>
          alert('Gagal Mengunggah File Jurnal DOC! Silahkan Unggah Ulang File Anda')
          windows.location.href='fileskripsi.php'
          </script>";
        }
    }else{
      echo "<script>
        alert('File Jurnal DOC Anda Bukan Berekstensi Doc/Docx ! Silahkan Unggah Ulang File Anda')
        windows.location.href='fileskripsi.php'
        </script>";
    }
  }

  if ($aplikasi === "") {
  }else{
  $ambil_ekstensi5 = explode(".", $aplikasi);
  $eks5 = $ambil_ekstensi5[1];
  $newfile5 = $nim.'-'.$namefile.'-'.$aplikasi;
  $pathlemrev5= '../../assets/skripsi_app/'.$newfile5;
    if (in_array($eks5, $ekstensi2)) {
        $file_tmp2 = $_FILES["aplikasi"]["tmp_name"];
        unlink('../../assets/skripsi_app/'.$file_lama5);
        if (move_uploaded_file($file_tmp5, $pathlemrev5)) {
        $insertaplikasi = mysqli_query($conn, "UPDATE skripsi_file 
          SET aplikasi='$newfile5' 
          WHERE id_file='$id'") or die (mysqli_erorr($conn)); 
        }else {
          echo "<script>
          alert('Gagal Mengunggah File Aplikasi Silahkan Unggah Ulang File Anda')
          windows.location.href='fileskripsi.php'
          </script>";
        }
    }else{
      echo "<script>
        alert('File Aplikasi Anda Bukan Berekstensi Rar/Zip ! Silahkan Unggah Ulang File Anda')
        windows.location.href='fileskripsi.php'
        </script>";
    }
  }

  if ($karbim === "") {
  }else{
  $ambil_ekstensi6 = explode(".", $karbim);
  $eks6 = $ambil_ekstensi6[1];
  $newfile6 = $nim.'-'.$namefile.'-'.$karbim;
  $pathlemrev6= '../../assets/skripsi_karbim/'.$newfile6;
    if (in_array($eks6, $ekstensi1)) {
      if ($ukurankarbim > 100000) {
        echo "<script>
        alert('Maximal File Size 100 KB')
        windows.location.href='fileskripsi.php'
        </script>";
      }else{
        $file_tmp2 = $_FILES["karbim"]["tmp_name"];
        unlink('../../assets/skripsi_karbim/'.$file_lama6);
        if (move_uploaded_file($file_tmp6, $pathlemrev6)) {
        $insertkarbim = mysqli_query($conn, "UPDATE skripsi_file 
          SET kartu_bim='$newfile6' 
          WHERE id_file='$id'") or die (mysqli_erorr($conn)); 
        }else {
          echo "<script>
          alert('Gagal Mengunggah File Kartu Bimbingan Silahkan Unggah Ulang File Anda')
          windows.location.href='fileskripsi.php'
          </script>";
        }
      }
    }else{
      echo "<script>
        alert('File Kartu Bimbingan Anda Bukan Berekstensi PDF ! Silahkan Unggah Ulang File Anda')
        windows.location.href='fileskripsi.php'
        </script>";
    }
  }

  if ($lempeng === "") {
  }else{
    $ambil_ekstensi7 = explode(".", $lempeng);
  $eks7 = $ambil_ekstensi7[1];
  $newfile7 = $nim.'-'.$namefile.'-'.$lempeng;
  $pathlemrev7= '../../assets/skripsi_lempeng/'.$newfile7;
    if (in_array($eks7, $ekstensi1)) {
      if ($ukuranlempeng > 100000) {
        echo "<script>
        alert('Maximal File Size 100 KB')
        windows.location.href='fileskripsi.php'
        </script>";
      }else{
        $file_tmp2 = $_FILES["lempeng"]["tmp_name"];
        unlink('../../assets/skripsi_lempeng/'.$file_lama7);
        if (move_uploaded_file($file_tmp7, $pathlemrev7)) {
        $insertlempeng = mysqli_query($conn, "UPDATE skripsi_file 
          SET lem_pengesahan='$newfile7' 
          WHERE id_file='$id'") or die (mysqli_erorr($conn)); 
        }else {
          echo "<script>
          alert('Gagal Mengunggah File Lembar Pengesahan Silahkan Unggah Ulang File Anda')
          windows.location.href='fileskripsi.php'
          </script>";
        }
      }
    }else{
      echo "<script>
        alert('File Lembar Pengesahan Anda Bukan Berekstensi PDF ! Silahkan Unggah Ulang File Anda')
        windows.location.href='fileskripsi.php'
        </script>";
    }
  }

  if ($cover === "") {
  }else{
  $ambil_ekstensi8 = explode(".", $cover);
  $eks8 = $ambil_ekstensi8[1];
  $newfile8 = $nim.'-'.$namefile.'-'.$cover;
  $pathlemrev8= '../../assets/skripsi_cover/'.$newfile8;
    if (in_array($eks8, $ekstensi1)) {
      if ($ukuranlempeng > 100000) {
        echo "<script>
        alert('Maximal File Size 100 KB')
        windows.location.href='fileskripsi.php'
        </script>";
      }else{
        $file_tmp2 = $_FILES["cover"]["tmp_name"];
        unlink('../../assets/skripsi_cover/'.$file_lama8);
        if (move_uploaded_file($file_tmp8, $pathlemrev8)) {
        $insertcover = mysqli_query($conn, "UPDATE skripsi_file 
          SET cover='$newfile8' 
          WHERE id_file='$id'") or die (mysqli_erorr($conn)); 
        }else {
          echo "<script>
          alert('Gagal Mengunggah File Cover Silahkan Unggah Ulang File Anda')
          windows.location.href='fileskripsi.php'
          </script>";
        }
      }
    }else{
      echo "<script>
        alert('File Cover Anda Bukan Berekstensi PDF ! Silahkan Unggah Ulang File Anda')
        windows.location.href='fileskripsi.php'
        </script>";
    }
  }

  if ($poster === "") {
  }else{
  $ambil_ekstensi9 = explode(".", $poster);
  $eks9 = $ambil_ekstensi9[1];
  $newfile9 = $nim.'-'.$namefile.'-'.$poster;
  $pathlemrev9= '../../assets/skripsi_poster/'.$newfile9;
    if (in_array($eks9, $ekstensi3)) {
      if ($ukuranlempeng > 100000) {
        echo "<script>
        alert('Maximal File Size 100 KB')
        windows.location.href='fileskripsi.php'
        </script>";
      }else{
        $file_tmp2 = $_FILES["poster"]["tmp_name"];
        unlink('../../assets/skripsi_poster/'.$file_lama9);
        if (move_uploaded_file($file_tmp9, $pathlemrev9)) {
        $insertposter = mysqli_query($conn, "UPDATE skripsi_file 
          SET poster='$newfile9' 
          WHERE id_file='$id'") or die (mysqli_erorr($conn)); 
        }else {
          echo "<script>
          alert('Gagal Mengunggah File Poster Silahkan Unggah Ulang File Anda')
          windows.location.href='fileskripsi.php'
          </script>";
        }
      }
    }else{
      echo "<script>
        alert('File Poster Anda Bukan Berekstensi PDF ! Silahkan Unggah Ulang File Anda')
        windows.location.href='fileskripsi.php'
        </script>";
    }
  }
  // header('location: fileskripsi.php');
}  


?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Data File Skripsi | SIM-PS | Mahasiswa</title>
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
          <!-- <h1 class="m-0 text-dark">Data File Skripsi</h1> -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <?php
$cekjudul = mysqli_query($conn, "SELECT * FROM judul WHERE nim='$nim' AND status_judul='Disetujui'");
if (mysqli_num_rows($cekjudul)<1) {
  ?>
  <div class="alert alert-danger" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <b>Anda Belum Memiliki Judul Skripsi Atau Judul Yang Anda Ajukan Belum Disetujui, Silahkan Ajukan Judul Terlebih
      Dahulu</b>
  </div>
  <?php }else{
    ?>
  <section class="content">
    <div class="row">
      <div class="col-12">
        <?php
    $cekdosbing = mysqli_query($conn, "SELECT * FROM skripsi_bim sb INNER JOIN skripsi s 
    ON sb.id_skripsi=s.id_skripsi INNER JOIN proposal p ON s.id_proposal=p.id_proposal
    INNER JOIN judul ON p.id_judul=judul.id_judul INNER JOIN mahasiswa m
    ON judul.nim=m.nim WHERE m.nim='$nim' AND sb.status='Bimbingan Pasca' AND sb.status_bim='Layak'");
    if (mysqli_num_rows($cekdosbing)<1) {
      ?>
        <div class="alert alert-danger" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <b>Bimbingan Pasca Sidang Pendadaran Anda Belum Disetujui Dosen Pembimbing 1/2, silahkan hubungi Dosen
            Pembimbing 1/2 Anda Untuk Mengunggah File Draft Skripsi Anda</b>
        </div>
        <?php }else{
        ?>
        <div class="card">
          <div class="card-header">
            <center>
              <h1 class="m-0 text-dark">Manajemen File Skripsi</h1>
            </center>
          </div>
          <!-- cek sudah diunggah belum laporan? -->
          <?php
        $cekfile=mysqli_query($conn, 
        "SELECT 
        (SELECT d1.nama_dosen FROM  dosen d1 INNER JOIN skripsi_dosbing sd
        ON d1.nidn=sd.nidn WHERE sd.id_skripsi=s.id_skripsi AND status_dosbing='Pembimbing 1'
        AND sd.status='Aktif' LIMIT 0,1) AS pem1, 
        (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd
        ON d1.nidn=sd.nidn WHERE sd.id_skripsi=s.id_skripsi AND status_dosbing='Pembimbing 2'
        AND sd.status='Aktif' LIMIT 0,1) AS pem2, 
        judul.judul, 
        skripsi_file.draft_pdf, skripsi_file.draft_doc, skripsi_file.jurnal_pdf,
        skripsi_file.jurnal_doc, skripsi_file.aplikasi, skripsi_file.kartu_bim,
        skripsi_file.lem_pengesahan, skripsi_file.cover, skripsi_file.poster 
        FROM skripsi s INNER JOIN skripsi_file
        ON s.id_skripsi=skripsi_file.id_skripsi
        INNER JOIN proposal
        ON s.id_proposal=proposal.id_proposal
        INNER JOIN judul
        ON proposal.id_judul=judul.id_judul
        INNER JOIN mahasiswa
        ON judul.nim=mahasiswa.nim
        WHERE mahasiswa.nim='$nim' AND judul.status_judul='Disetujui' 
        AND (skripsi_file.draft_pdf IS NOT NULL AND skripsi_file.draft_doc IS NOT NULL AND skripsi_file.jurnal_pdf IS NOT NULL AND
        skripsi_file.jurnal_doc IS NOT NULL AND skripsi_file.aplikasi IS NOT NULL AND skripsi_file.kartu_bim IS NOT NULL AND
        skripsi_file.lem_pengesahan IS NOT NULL AND skripsi_file.cover IS NOT NULL AND skripsi_file.poster)") or die (mysqli_erorr($conn));
        if (mysqli_num_rows($cekfile)===0) {
          ?>
          <div class="card-header">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-lg">
              Unggah
            </button>
          </div>
          <?php } ?>
          <!-- /.card-header -->
          <div class="card-body">
            <!-- cek file ta sudah diunggah belum -->
            <?php 
          $cekfile1=mysqli_query($conn, 
          "SELECT (SELECT d1.nama_dosen FROM  dosen d1 INNER JOIN skripsi_dosbing sd
          ON d1.nidn=sd.nidn WHERE sd.id_skripsi=s.id_skripsi AND status_dosbing='Pembimbing 1'
          AND sd.status='Aktif' LIMIT 0,1) AS pem1, 
          (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd
          ON d1.nidn=sd.nidn WHERE sd.id_skripsi=s.id_skripsi AND status_dosbing='Pembimbing 2'
          AND sd.status='Aktif' LIMIT 0,1) AS pem2, 
          judul.judul, 
          skripsi_file.draft_pdf, skripsi_file.draft_doc, skripsi_file.jurnal_pdf,
          skripsi_file.jurnal_doc, skripsi_file.aplikasi, skripsi_file.kartu_bim,
          skripsi_file.lem_pengesahan, skripsi_file.cover, skripsi_file.poster
          FROM skripsi s LEFT JOIN skripsi_file
          ON s.id_skripsi=skripsi_file.id_skripsi
          LEFT JOIN proposal
          ON s.id_proposal=proposal.id_proposal
          LEFT JOIN judul
          ON proposal.id_judul=judul.id_judul
          LEFT JOIN mahasiswa
          ON judul.nim=mahasiswa.nim
          WHERE mahasiswa.nim='$nim' AND judul.status_judul='Disetujui' 
          AND (skripsi_file.draft_pdf IS NOT NULL AND skripsi_file.draft_doc IS NOT NULL AND skripsi_file.jurnal_pdf IS NOT NULL AND
          skripsi_file.jurnal_doc IS NOT NULL AND skripsi_file.aplikasi IS NOT NULL AND skripsi_file.kartu_bim IS NOT NULL AND
          skripsi_file.lem_pengesahan IS NOT NULL AND skripsi_file.cover IS NOT NULL AND skripsi_file.poster)");
          if (mysqli_num_rows($cekfile1)===1) {
            ?>
            <table id="example1" class="table table-bordered table-striped">
              <thead align="center">
                <tr>
                  <th width="50px">Draft PDF</th>
                  <th width="50px">Draft DOC</th>
                  <th width="50px">Jurnal PDF</th>
                  <th width="50px">Jurnal DOC</th>
                  <th width="50px">App</th>
                  <th width="50px">Kartu Bimbingan</th>
                  <th width="50px">Lembar Pengesahan</th>
                  <th width="50px">Cover</th>
                  <th width="50px">Poster</th>
                  <th width="50px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
            //ambi data bimbingan
            $getdata = mysqli_query($conn,
            "SELECT (SELECT d1.nama_dosen FROM  dosen d1 INNER JOIN skripsi_dosbing sd
            ON d1.nidn=sd.nidn WHERE sd.id_skripsi=s.id_skripsi AND status_dosbing='Pembimbing 1'
            AND sd.status='Aktif' LIMIT 0,1) AS pem1, 
            (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd
            ON d1.nidn=sd.nidn WHERE sd.id_skripsi=s.id_skripsi AND status_dosbing='Pembimbing 2'
            AND sd.status='Aktif' LIMIT 0,1) AS pem2, 
            judul.judul, 
            skripsi_file.draft_pdf, skripsi_file.draft_doc, skripsi_file.jurnal_pdf,
            skripsi_file.jurnal_doc, skripsi_file.aplikasi, skripsi_file.kartu_bim,
            skripsi_file.lem_pengesahan, skripsi_file.cover, skripsi_file.poster,
            skripsi_file.id_file 
            FROM skripsi s INNER JOIN skripsi_file
            ON s.id_skripsi=skripsi_file.id_skripsi
            INNER JOIN proposal
            ON s.id_proposal=proposal.id_proposal
            INNER JOIN judul
            ON proposal.id_judul=judul.id_judul
            INNER JOIN mahasiswa
            ON judul.nim=mahasiswa.nim
            WHERE mahasiswa.nim='$nim' AND judul.status_judul='Disetujui'")
            or die (mysqli_erorr($conn));
            if (mysqli_num_rows($getdata) > 0) {
              while ($data=mysqli_fetch_array($getdata)) {
                ?>
                <tr>
                  <td align="center">
                    <a href="assets/downloaddraftpdf.php?filename=<?= $data["draft_pdf"] ?>" class="btn-sm btn-info"
                      target="_blank"><i class="fas fa-download"></i></a>
                  </td>
                  <td align="center">
                    <a href="assets/downloaddraftdoc.php?filename=<?= $data["draft_doc"] ?>" class="btn-sm btn-info"
                      target="_blank"><i class="fas fa-download"></i></a>
                  </td>
                  <td align="center">
                    <a href="assets/downloadjurnalpdf.php?filename=<?= $data["jurnal_pdf"] ?>" class="btn-sm btn-info"
                      target="_blank"><i class="fas fa-download"></i></a>
                  </td>
                  <td align="center">
                    <a href="assets/downloadjurnaldoc.php?filename=<?= $data["jurnal_doc"] ?>" class="btn-sm btn-info"
                      target="_blank"><i class="fas fa-download"></i></a>
                  </td>
                  <td align="center">
                    <a href="assets/downloadaplikasi.php?filename=<?= $data["aplikasi"] ?>" class="btn-sm btn-info"
                      target="_blank"><i class="fas fa-download"></i></a>
                  </td>
                  <td align="center">
                    <a href="assets/downloadkartubimbingan.php?filename=<?= $data["kartu_bim"] ?>"
                      class="btn-sm btn-info" target="_blank"><i class="fas fa-download"></i></a>
                  </td>
                  <td align="center">
                    <a href="assets/downloadlempeng.php?filename=<?= $data["lem_pengesahan"] ?>" class="btn-sm btn-info"
                      target="_blank"><i class="fas fa-download"></i></a>
                  </td>
                  <td align="center">
                    <a href="assets/downloadcover.php?filename=<?= $data["cover"] ?>" class="btn-sm btn-info"
                      target="_blank"><i class="fas fa-download"></i></a>
                  </td>
                  <td align="center">
                    <a href="assets/downloadposter.php?filename=<?= $data["poster"] ?>" class="btn-sm btn-info"
                      target="_blank"><i class="fas fa-download"></i></a>
                  </td>
                  <td align="center">
                    <button type="submit" class="btn-sm btn-dark" name="detail" data-toggle="modal"
                      data-target="#modal-lg1" id="detailbim" data-id="<?php echo $data["id_file"]?>"
                      data-namafile="<?php echo $data["file"]?>">
                      <i class="fas fa-edit"></i>
                    </button>
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
  <?php } }?>
  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-heade">
            <center>
              <h1 class="m-0 text-dark">Data Jurnal Mahasiswa</h1>
            </center>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <!-- cek file ta sudah diunggah belum -->
            <table id="example3" class="table table-bordered table-striped">
              <thead align="center">
                <tr>
                  <th width="250px">Nama Mahasiswa</th>
                  <th width="350px">Judul Skripsi</th>
                  <th width="100px">File Jurnal</th>
                  <!-- <th width="50px">Aksi</th> -->
                </tr>
              </thead>
              <tbody>
                <?php
            //ambil data bimbingan
            $getdata = mysqli_query($conn,
            "SELECT (SELECT d1.nama_dosen FROM  dosen d1 INNER JOIN skripsi_dosbing sd
            ON d1.nidn=sd.nidn WHERE sd.id_skripsi=s.id_skripsi AND status_dosbing='Pembimbing 1'
            AND sd.status='Aktif' LIMIT 0,1) AS pem1, 
            (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd
            ON d1.nidn=sd.nidn WHERE sd.id_skripsi=s.id_skripsi AND status_dosbing='Pembimbing 2'
            AND sd.status='Aktif' LIMIT 0,1) AS pem2, 
            judul.judul, 
            skripsi_file.draft_pdf, skripsi_file.draft_doc, skripsi_file.jurnal_pdf,
            skripsi_file.jurnal_doc, skripsi_file.aplikasi, skripsi_file.kartu_bim,
            skripsi_file.lem_pengesahan, skripsi_file.cover, skripsi_file.poster,
            skripsi_file.id_file,
            m.nim, m.nama
            FROM skripsi s INNER JOIN skripsi_file
            ON s.id_skripsi=skripsi_file.id_skripsi
            INNER JOIN proposal
            ON s.id_proposal=proposal.id_proposal
            INNER JOIN judul
            ON proposal.id_judul=judul.id_judul
            INNER JOIN mahasiswa m
            ON judul.nim=m.nim
            WHERE m.nim='$nim' AND judul.status_judul='Disetujui'")
            or die (mysqli_erorr($conn));
            if (mysqli_num_rows($getdata) > 0) {
              while ($data=mysqli_fetch_array($getdata)) {
                $n = $data["id_file"];
                $ni = base64_encode($n);
                ?>
                <tr>
                  <td><?= $data["nama"]  ?></td>
                  <td><a href="detailfileskripsi.php?id=<?=$ni?>"><?= $data["judul"] ?></a></td>
                  <td align="center">
                    <a href="../../assets/skripsi_jurnal_pdf/<?= $data["jurnal_pdf"] ?>" class="btn btn-info"
                      target="_blank"><i class="fas fa-download"></i></a></td>
                  <!-- <td align="center">
                <button type="submit" class="btn-sm btn-dark" name="detail" data-toggle="modal" data-target="#modal-lg1" id="detailbim"
                data-id="<?php echo $data["id_file"]?>"
                data-namafile="<?php echo $data["file"]?>">
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

  <!-- modal tambah bimbingan -->
  <div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Form Unggah File Skripsi</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="card-body">
              <div class="form-group row">
                <label for="file" class="col-sm-3 col-form-label">File Draft Skripsi</label>
                <div class="col-sm-4">
                  <input type="file" id="draftpdf" name="draftpdf" required="required">
                  <br>
                  <small><b>PDF, Max File Size 20 MB</b></small>
                </div>
                <div class="col-sm-4">
                  <input type="file" id="draftdoc" name="draftdoc" required="required">
                  <br>
                  <small><b>Doc / Docx</b></small>
                </div>
              </div>
              <div class="form-group row">
                <label for="file" class="col-sm-3 col-form-label">File Jurnal</label>
                <div class="col-sm-4">
                  <input type="file" id="jurnalpdf" name="jurnalpdf" required="required">
                  <br>
                  <small><b>PDF, Max FIle Size 2 MB</b></small>
                </div>
                <div class="col-sm-4">
                  <input type="file" id="jurnaldoc" name="jurnaldoc" required="required">
                  <br>
                  <small><b>Docx / Doc</b></small>
                </div>
              </div>
              <div class="form-group row">
                <label for="file" class="col-sm-3 col-form-label">File Program/Aplikasi</label>
                <div class="col-sm-9">
                  <input type="file" id="aplikasi" name="aplikasi" required="required">
                  <br>
                  <small><b>RAR / Zip</b></small>
                </div>
              </div>
              <div class="form-group row">
                <label for="file" class="col-sm-3 col-form-label">Scan Kartu Bimbingan</label>
                <div class="col-sm-9">
                  <input type="file" id="karbim" name="karbim" required="required">
                  <br>
                  <small><b>PDF, Max File Size 100 KB</b></small>
                </div>
              </div>
              <div class="form-group row">
                <label for="file" class="col-sm-3 col-form-label">Scan Lembar Pengesahan</label>
                <div class="col-sm-9">
                  <input type="file" id="lempeng" name="lempeng" required="required">
                  <br>
                  <small><b>PDF, Max File Size 100 KB</b></small>
                </div>
              </div>
              <div class="form-group row">
                <label for="file" class="col-sm-3 col-form-label">Scan Cover Naskah</label>
                <div class="col-sm-9">
                  <input type="file" id="cover" name="cover" required="required">
                  <br>
                  <small><b>PDF, Max File Size 100 KB</b></small>
                </div>
              </div>
              <div class="form-group row">
                <label for="file" class="col-sm-3 col-form-label">Desain Poster</label>
                <div class="col-sm-9">
                  <input type="file" id="poster" name="poster" required="required">
                  <br>
                  <small><b>jpg / jpeg, Max File Size 250 KB</b></small>
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
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <style>
            .modal-header {
              background-color: #292929;
              color: #FFFFFF;
            }
          </style>
          <h5 class="modal-title" id="exampleModalLabel">Form Ubah File Skripsi</h5>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- form body modal -->
          <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="file" class="col-sm-3 col-form-label">File Draft Skripsi</label>
              <div class="col-sm-4">
                <input type="text" id="id" name="id" readonly hidden>
                <input type="file" id="draftpdf" name="draftpdf">
                <br>
                <small><b>PDF, Max File Size 20 MB</b></small>
              </div>
              <div class="col-sm-4">
                <input type="file" id="draftdoc" name="draftdoc">
                <br>
                <small><b>Doc / Docx</b></small>
              </div>
            </div>
            <div class="form-group row">
              <label for="file" class="col-sm-3 col-form-label">File Jurnal</label>
              <div class="col-sm-4">
                <input type="file" id="jurnalpdf" name="jurnalpdf">
                <br>
                <small><b>PDF, Max FIle Size 2 MB</b></small>
              </div>
              <div class="col-sm-4">
                <input type="file" id="jurnaldoc" name="jurnaldoc">
                <br>
                <small><b>Docx / Doc</b></small>
              </div>
            </div>
            <div class="form-group row">
              <label for="file" class="col-sm-3 col-form-label">File Program/Aplikasi</label>
              <div class="col-sm-9">
                <input type="file" id="aplikasi" name="aplikasi">
                <br>
                <small><b>RAR / Zip</b></small>
              </div>
            </div>
            <div class="form-group row">
              <label for="file" class="col-sm-3 col-form-label">Scan Kartu Bimbingan</label>
              <div class="col-sm-9">
                <input type="file" id="karbim" name="karbim">
                <br>
                <small><b>PDF, Max File Size 100 KB</b></small>
              </div>
            </div>
            <div class="form-group row">
              <label for="file" class="col-sm-3 col-form-label">Scan Lembar Pengesahan</label>
              <div class="col-sm-9">
                <input type="file" id="lempeng" name="lempeng">
                <br>
                <small><b>PDF, Max File Size 100 KB</b></small>
              </div>
            </div>
            <div class="form-group row">
              <label for="file" class="col-sm-3 col-form-label">Scan Cover Naskah</label>
              <div class="col-sm-9">
                <input type="file" id="cover" name="cover">
                <br>
                <small><b>PDF, Max File Size 100 KB</b></small>
              </div>
            </div>
            <div class="form-group row">
              <label for="file" class="col-sm-3 col-form-label">Desain Poster</label>
              <div class="col-sm-9">
                <input type="file" id="poster" name="poster">
                <br>
                <small><b>jpg / jpeg, Max File Size 250 KB</b></small>
              </div>
            </div>
            <small><b>*Isi Form Hanya Yang Ingin Diubah, kosongkan Form Jika Tidak Ingin Mengubah File</b></small>
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
</div>
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
    $("#modal-lg1 #file").attr("href", "../../assets/skripsi/" + nama);
    $("#modal-lg1 #nama").val(nama);
    $("#modal-lg1 #id").val(id);
  });
</script>
</body>

</html>