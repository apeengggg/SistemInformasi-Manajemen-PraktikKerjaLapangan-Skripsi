<?php
session_start();

require "../../koneksi.php";
$nidn = $_SESSION["nidn"];
// ambil data bimbingan mahasiswa
// $getbim = mysqli_query($conn, "SELECT * FROM proposal_bim WHERE pembimbing='$nidn' AND status='Bimbingan Pasca'") or die (mysqli_erorr($conn));
// kirim hasil bimbingan
if (isset($_POST["hasilbim"])) {
$ekstensi = array("doc", "docx", "ppt", "pptx", "pdf", "rar", "zip");
$hasilbim = $_FILES["file_hasilbim"]["name"];
$ambil_ekstensi = explode(".", $hasilbim);
$eks = $ambil_ekstensi[1];
$idbim=$_POST["id"];
$newfile = $nidn.'-'.$hasilbim;
$savepath = '../../assets/bim_prop_dosen/'.$newfile;
$pesan = $_POST["pesan"];
$status = $_POST["status_bim"];
$read = 'Dibalas'; 
$n = 'Belum Dibaca';
if (in_array($eks, $ekstensi)) {
$tmp_hasilbim = $_FILES["file_hasilbim"]["tmp_name"];
if (move_uploaded_file($tmp_hasilbim, $savepath)) {
$send = mysqli_query($conn, "UPDATE proposal_bim SET
file_hasilbim='$newfile',
saran='$pesan',
status_bim='$status',
status_dosbing='$read',
status_mhs='$n'
WHERE id_bim='$idbim'") or die (mysqli_erorr($conn));
if ($send) {
echo "<script>
alert('Hasil Bimbingan Terkirim !')
windows.location.href='bimbinganpascaprop.php'
</script>";
}else {
echo "<script>
alert('Hasil Bimbingan Gagal Terkirim !')
windows.location.href='bimbinganpascaprop.php'
</script>";
}
}else {
echo "<script>
alert('File Hasil Bimbingan Gagal di Unggah !')
windows.location.href='bimbinganpascaprop.php'
</script>";
}
}else {
echo "<script>
alert('File Hasil Bimbingan Gagal di Unggah !, Ekstensi file tidak sesuai')
windows.location.href='bimbinganpascaprop.php'
</script>";
}}

// ambil id BImbingan di get
if (isset($_GET["id"])) {
$decode = base64_decode($_GET["id"]);
}
//ambi data bimbingan
$getdata = mysqli_query($conn,
"SELECT d1.nama_dosen AS pembimbing,
mhs.nim AS nim, mhs.nama AS nama, mhs.foto AS foto,
judul.judul AS judul, proposal.lem_rev,
sid.tgl_sidang AS tanggal_sidang, sid.ruang_sidang AS ruang_sidang,
sid.waktu_sidang AS waktu_sidang,
bim.file_bim AS filebim, bim.file_hasilbim AS hasilbim,
bim.tgl_bim AS tanggal_bim, bim.subjek AS subjek_bim,
bim.deskripsi AS deskripsi_bim, bim.saran AS pesan_bim,
bim.status_bim AS status_bim, bim.status_dosbing AS dosbing,
bim.id_bim AS id
FROM proposal_bim bim LEFT JOIN proposal
ON bim.id_proposal=proposal.id_proposal
LEFT JOIN dosen d1
ON proposal.dosbing=d1.nidn
LEFT JOIN judul
ON proposal.id_judul=judul.id_judul
LEFT JOIN mahasiswa mhs
ON judul.nim=mhs.nim
LEFT JOIN proposal_sidang sid
ON proposal.id_proposal=sid.id_proposal
WHERE bim.pembimbing='$nidn'AND sid.tgl_sidang IS NOT NULL AND bim.status='Bimbingan Pasca' AND bim.nim='$decode' ORDER BY bim.tgl_bim DESC") or die (mysqli_erorr($conn));

//ambi data bimbingan
$getdataa = mysqli_query($conn,
"SELECT d1.nama_dosen AS pembimbing,
-- penguji 1
(SELECT d1.nama_dosen FROM dosen d1 INNER JOIN proposal_penguji pp
ON d1.nidn=pp.penguji WHERE pp.id_sidang=ps.id_sidang AND status_penguji='Penguji 1'
AND pp.status='Aktif' LIMIT 0,1) AS penguji1,
-- penguji 2
(SELECT d1.nama_dosen FROM dosen d1 INNER JOIN proposal_penguji pp
ON d1.nidn=pp.penguji WHERE pp.id_sidang=ps.id_sidang AND status_penguji='Penguji 2'
AND pp.status='Aktif' LIMIT 0,1) AS penguji2,
-- 
mhs.nim AS nim, mhs.nama AS nama, mhs.foto AS foto,
judul.judul AS judul, proposal.lem_rev,
ps.tgl_sidang AS tanggal_sidang, ps.ruang_sidang AS ruang_sidang,
ps.waktu_sidang AS waktu_sidang,
bim.file_bim AS filebim, bim.file_hasilbim AS hasilbim,
bim.tgl_bim AS tanggal_bim, bim.subjek AS subjek_bim,
bim.deskripsi AS deskripsi_bim, bim.saran AS pesan_bim,
bim.status_bim AS status_bim, bim.status_dosbing AS dosbing,
bim.id_bim AS id
FROM proposal_bim bim LEFT JOIN proposal
ON bim.id_proposal=proposal.id_proposal
LEFT JOIN dosen d1
ON proposal.dosbing=d1.nidn
LEFT JOIN judul
ON proposal.id_judul=judul.id_judul
LEFT JOIN mahasiswa mhs
ON judul.nim=mhs.nim
LEFT JOIN proposal_sidang ps
ON proposal.id_proposal=ps.id_proposal
WHERE bim.pembimbing='$nidn'AND ps.tgl_sidang IS NOT NULL AND bim.status='Bimbingan Pasca' AND bim.nim='$decode' ORDER BY bim.tgl_bim DESC") or die (mysqli_erorr($conn));
$data1=mysqli_fetch_array($getdataa);
$data2 = mysqli_num_rows($getdataa);

if (isset($_POST["ubahbim"])) {
  $id = $_POST["id"];
  $pesan = $_POST["pesan"];
  $hasil = $_POST["status_bim2"];
  $n = 'Belum Dibaca';
  $ekstensi2 = array("pdf");
  $filebim= $_FILES["file_hasilbim"]["name"];
  $ukuran= $_FILES["file_hasilbim"]["size"];
  // var_dump($filebim); die;
  if (empty($filebim)) {
    $sql = mysqli_query($conn, "UPDATE proposal_bim SET saran='$pesan', status_bim='$hasil', status_mhs='$n'
    WHERE id_bim='$id'");
    if ($sql) {
      echo "<script>
      alert('Bimbingan Berhasil diubah tanpa perubahan pada file bimbingan')
      windows.location.href='p_bimbinganpascaprop.php'
      </script>";
    }else {
      echo "<script>
      alert('Bimbingan Gagal diubah')
      windows.location.href='p_bimbinganpascaprop.php'
      </script>";
    } 
  }else {
    $ambil_ekstensi1 = explode(".", $filebim);
    $eks = $ambil_ekstensi1[1];
    $newfilebim = $nidn.'-'.$namefile.'-'.$filebim;  
    $pathfilebim = '../../assets/bim_prop_dosen/'.$newfilebim;
    $filelama = mysqli_query($conn, "SELECT file_hasilbim FROM proposal_bim WHERE id_bim='$id'");
    $d = mysqli_fetch_array($filelama);
    if (in_array($eks, $ekstensi2)) {
      if (ukuran > 10000000) {
        echo "<script>
        alert('Maximal File Size 10 MB')
        windows.location.href='p_bimbinganpascaprop.php'
        </script>";
      }else{
        $filebim_tmp = $_FILES["file_hasilbim"]["tmp_name"];
        if (move_uploaded_file($filebim_tmp, $pathfilebim)) {
          unlink('../../assets/bim_prop_dosen/'.$d["file_hasilbim"]);
          $tambahbim = mysqli_query($conn, "UPDATE proposal_bim SET saran='$pesan', status_bim='$hasil',
          file_hasilbim='$newfilebim', status_mhs='$n'
          WHERE id_bim='$id'") or die (mysqli_error($conn));
          if ($tambahbim) {
            echo "<script>
            alert('Berhasil Mengubah Bimbingan!')
            windows.location.href='p_bimbinganpascaprop.php'
            </script>";
          }else {
            echo "<script>
            alert('Gagal Mengubah Bimbingan!')
            windows.location.href='p_bimbinganpascaprop.php'
            </script>";
          }
        }
      }
    }else {
      echo "<script>
      alert('Gagal Melakukan Bimbingan, File yang harus di unggah Harus PDF')
      windows.location.href='p_bimbinganpascaprop.php'
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
  <title>Detail Bimbingan Pasca | SIM-PS</title>
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
  <link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/fixedheader/3.1.7/css/fixedHeader.bootstrap.min.css">
  <link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap.min.css">
</head>
<?php 
  if (isset($_SESSION["login_kaprodi"])) {
    include '../kaprodi/assets/header.php';
  }elseif (isset($_SESSION["login_pa"])) {
    include '../pa/assets/header.php';
  }elseif (isset($_SESSION["login_dosen"])) {
    include 'assets/header.php';
  } ?>
<style>
  thead {
    background-color: grey;
    color: #FFFFFF;
  }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
          </ul>
          <!-- <h1 class="m-0 text-dark">Data Pendaftaran Sidang PKL</h1> -->
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
                <td colspan="4">
                  <hr>
                </td>
              </tr>
              <tr>
                <td>
                  <font size="4">Nama</font>
                </td>
                <td>
                  <font size="4">:</font>
                </td>
                <td>
                  <font size="4"><?= $data1["nama"] ?></font>
                </td>
              </tr>
              <tr>
                <td colspan="4">
                  <hr>
                </td>
              </tr>
              <tr>
                <td>
                  <font size="4">Judul</font>
                </td>
                <td>
                  <font size="4">:</font>
                </td>
                <td>
                  <font size="4"><?= $data1["judul"] ?></font>
                </td>
              </tr>
              <tr>
                <td colspan="4s">
                  <hr>
                </td>
              </tr>
              <tr>
                <td>
                  <font size="4">Dosbing</font>
                </td>
                <td>
                  <font size="4">:</font>
                </td>
                <td>
                  <font size="4"><?= $data1["pembimbing"] ?></font>
                </td>
              </tr>
              <tr>
                <td colspan="4">
                  <hr>
                </td>
              </tr>
              <tr>
                <td>
                  <font size="4">Penguji1</font>
                </td>
                <td>
                  <font size="4">:</font>
                </td>
                <td>
                  <font size="4"><?= $data1["penguji1"] ?></font>
                </td>
              </tr>
              <tr>
                <td colspan="4">
                  <hr>
                </td>
              </tr>
              <tr>
                <td>
                  <font size="4">Penguji2</font>
                </td>
                <td>
                  <font size="4">:</font>
                </td>
                <td>
                  <font size="4"><?= $data1["penguji2"] ?></font>
                </td>
              </tr>
              <tr>
                <td colspan="4">
                  <hr>
                </td>
              </tr>
              <tr>
                <td>
                  <font size="4">Jml Bim</font>
                </td>
                <td>
                  <font size="4">:</font>
                </td>
                <td>
                  <font size="4"><?= $data2  ?></font>
                </td>
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
            <center>
              <h2 class="m-0 text-dark">Data Bimbingan Pasca,
                <?=$data1["nama"] ?></h2>
            </center>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead align="center">
                <tr>
                  <th width="10px">No</th>
                  <th width="75px">Tanggal</th>
                  <th width="100px">Subjek</th>
                  <th width="110px">Bimbingan</th>
                  <th width="110px">Dosbing</th>
                  <th width="130px">Hasil</th>
                  <th width="70px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                        $no=1;
                        if (mysqli_num_rows($getdata) > 0) {
                        while ($data=mysqli_fetch_array($getdata)) {
                        $idbimprop = base64_encode($data["nim"]);
                        ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $data['tanggal_bim'] ?></td>
                  <td><?= $data['subjek_bim'] ?></td>
                  <td align="center"><a href="assets/downloadbimprop.php?filename=<?= $data['filebim'] ?>"
                      class="btn btn-info"><i class="fas fa-download"></i></a></td>
                  <td align="center">
                    <?php
                            if ($data["dosbing"]=="Belum Dibaca") {
                            ?>
                    <span class="badge badge-danger">
                      <?php } else if ($data["dosbing"]=="Dibalas"){
                              ?>
                      <span class="badge badge-success">
                        <?php }else if ($data["dosbing"]=="Dibaca"){
                                ?>
                        <span class="badge badge-primary">
                          <?php } ?>
                          <?= $data['dosbing'] ?>
                  </td>
                  <td align="center">
                    <?php
                                  if ($data["status_bim"]=="Revisi") {
                                  ?>
                    <span class="badge badge-danger">
                      <?php } else if ($data["status_bim"]=="Layak"){
                                    ?>
                      <span class="badge badge-success">
                        <?php }else if ($data["status_bim"]=="Lanjut"){
                                      ?>
                        <span class="badge badge-primary">
                          <?php } ?>
                          <?= $data['status_bim'] ?>
                  </td>
                  <td align="center">
                    <button type="submit" class="btn-xs btn-dark" name="detail" data-toggle="modal"
                      data-target="#modal-lg" id="detaildata" data-id="<?php echo $data["id"]?>"
                      data-dosbing="<?php echo $data["pembimbing"]?>" data-nim="<?php echo $data["nim"]?>"
                      data-nama="<?php echo $data["nama"]?>" data-foto="<?php echo $data["foto"]?>"
                      data-judul="<?php echo $data["judul"]?>" data-tglsid="<?php echo $data["tanggal_sidang"]?>"
                      data-ruangsid="<?php echo $data["ruang_sidang"]?>"
                      data-waktusid="<?php echo $data["waktu_sidang"]?>" data-filebim="<?php echo $data["filebim"]?>"
                      data-hasilbim="<?php echo $data["hasilbim"]?>"
                      data-tanggal_bim="<?php echo $data["tanggal_bim"]?>"
                      data-subjek="<?php echo $data["subjek_bim"]?>" data-desk="<?php echo $data["deskripsi_bim"]?>"
                      data-pesan="<?php echo $data["pesan_bim"]?>" data-status="<?php echo $data["status_bim"]?>"
                      data-status_dosbing="<?php echo $data["dosbing"]?>" data-lemrev="<?php echo $data["lem_rev"]?>">
                      <i class="fas fa-info-circle"></i></button>
                    <button type="submit" class="btn-xs btn-dark" name="detail" data-toggle="modal"
                      data-target="#modal-lg1" id="detaildata1" data-id="<?php echo $data["id"]?>"
                      data-dosbing="<?php echo $data["pembimbing"]?>" data-nim="<?php echo $data["nim"]?>"
                      data-nama="<?php echo $data["nama"]?>" data-foto="<?php echo $data["foto"]?>"
                      data-judul="<?php echo $data["judul"]?>" data-tglsid="<?php echo $data["tanggal_sidang"]?>"
                      data-ruangsid="<?php echo $data["ruang_sidang"]?>"
                      data-waktusid="<?php echo $data["waktu_sidang"]?>" data-filebim="<?php echo $data["filebim"]?>"
                      data-hasilbim="<?php echo $data["hasilbim"]?>"
                      data-tanggal_bim="<?php echo $data["tanggal_bim"]?>"
                      data-subjek="<?php echo $data["subjek_bim"]?>" data-desk="<?php echo $data["deskripsi_bim"]?>"
                      data-pesan="<?php echo $data["pesan_bim"]?>" data-status="<?php echo $data["status_bim"]?>"
                      data-status_dosbing="<?php echo $data["dosbing"]?>" data-lemrev="<?php echo $data["lem_rev"]?>">
                      <i class="fas fa-edit"></i></button>
                  </td>
                </tr>
                <?php }
                                    }
                                    ?>
              </tbody>
            </table>

            <!-- modal detail bimbingan -->
            <!-- Modal -->
            <div class="modal fade" id="modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <style>
                      .modal-header,
                      .modal-footer {
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
                        <div class="form-group col-md-12">
                          <center>
                            <img src="" alt="" width="120" height="150" id="foto">
                          </center>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" id="id" name="id" hidden>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-3">
                          <label for="nim">NIM</label>
                          <input type="text" class="form-control" id="nim" name="nim" readonly>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="nama">Nama</label>
                          <input type="text" class="form-control" id="nama" name="nama" readonly>
                        </div>
                        <div class="form-group col-md-5">
                          <label for="subjek">Subjek Bimbingan</label>
                          <input type="text" class="form-control" id="subjek" name="subjek" readonly>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-3">
                          <label for="desk">Deskripsi Bimbingan</label>
                          <textarea name="desk" id="desk" cols="1" rows="1" class="form-control" readonly></textarea>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="pesan">Saran</label>
                          <textarea name="pesan1" id="pesan1" cols="1" rows="1" class="form-control"
                            readonly></textarea>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="tanggal">Tanggal Bimbingan</label>
                          <input type="text" class="form-control" id="tanggal" name="tanggal" readonly>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="status_bim1">Hasil Bimbingan</label>
                          <input type="text" class="form-control" id="status_bim1" name="status_bim1" readonly>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-7">
                          <label for="judul">Judul Laporan</label>
                          <input type="text" class="form-control" id="judul" name="judul" readonly>
                        </div>
                        <div class="form-group col-md-5">
                          <label for="pem">Pembimbing</label>
                          <input type="text" class="form-control" id="pem" name="pem" readonly>
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
                        <div class="form-group col-md-3">
                          <label for="lemrev">Lembar Revisi</label>
                          <br>
                          <a class="btn-sm btn-primary" href=" " id="lemrev">Unduh</a>
                        </div>
                      </div>
                      <!-- /.card-body -->
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                      </div>
                  </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- /. modal detail bimbingan -->

            <!-- modal ubah bimbingan -->
            <!-- Modal -->
            <div class="modal fade" id="modal-lg1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <style>
                      .modal-header,
                      .modal-footer {
                        background-color: #292929;
                        color: #FFFFFF;
                      }
                    </style>
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Bimbingan Laporan Praktik Kerja Lapangan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <!-- form body modal -->
                    <form action="" method="post" enctype="multipart/form-data">
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <center>
                            <img src="" alt="" width="120" height="150" id="foto">
                          </center>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" id="id" name="id" hidden>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-2">
                          <label for="nim">NIM</label>
                          <input type="text" class="form-control" id="nim" name="nim" readonly>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="nama">Nama</label>
                          <input type="text" class="form-control" id="nama" name="nama" readonly>
                        </div>
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
                        <div class="form-group col-md-2">
                          <label for="lemrev">Lembar Revisi</label>
                          <br>
                          <a class="btn-sm btn-primary" href=" " id="lemrev">Unduh</a>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-3">
                          <label for="subjek">Subjek Bimbingan</label>
                          <input type="text" class="form-control" id="subjek" name="subjek" readonly>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="tanggal">Tanggal Bimbingan</label>
                          <input type="text" class="form-control" id="tanggal" name="tanggal" readonly>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="status_bim1">Hasil Bimbingan</label>
                          <input type="text" class="form-control" id="status_bim1" name="status_bim1" readonly>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="pesan">Saran</label>
                          <textarea name="pesan" id="pesan" cols="1" rows="1" class="form-control" required></textarea>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-3">
                          <label for="status_bim2">Hasil Bimbingan Baru</label>
                          <select id="status_bim2" class="form-control" name="status_bim2" required>
                            <option value="">Pilih...</option>
                            <option value="Revisi">Revisi</option>
                            <option value="Lanjut BAB">Lanjut Bab Selanjutnya</option>
                            <option value="Layak">Layak / Sidang</option>
                          </select>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="file_hasilbim">File Hasil Bimbingan Baru</label>
                          <input type="file" class="form-control-file" id="file_hasilbim" name="file_hasilbim">
                          <br>
                          <small><b>PDF, Max Size 10 MB</b></small>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-7">
                          <label for="judul">Judul Laporan</label>
                          <input type="text" class="form-control" id="judul" name="judul" readonly>
                        </div>
                        <div class="form-group col-md-5">
                          <label for="pem1">Pembimbing</label>
                          <input type="text" class="form-control" id="pem1" name="pem1" readonly>
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
            <!-- /. modal ubah bimbingan -->
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
  $(document).on("click", "#detaildata", function () {
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
    $("#modal-lg #desk").val(desk);
    $("#modal-lg #nim").val(nim);
    $("#modal-lg #nama").val(nama);
    $("#modal-lg #lemrev").attr("href", "assets/downloadlemrevprop.php?filename=" + lemrev);
    $("#modal-lg #filebim").attr("href", "assets/downloadbimprop.php?filename=" + filebim);
    $("#modal-lg #file_hasilbim").attr("href", "assets/downloadhasilbimprop.php?filename=" + hasilbim);
    $("#modal-lg #pesan1").val(pesan);
    $("#modal-lg #subjek").val(subjek);
    $("#modal-lg #tanggal").val(tanggalbim);
    $("#modal-lg #judul").val(judul);
    $("#modal-lg #pem").val(pembimbing);
    $("#modal-lg #tgl_sid").val(tglsid);
    $("#modal-lg #ruang_sid ").val(ruangsid);
    $("#modal-lg #waktu").val(waktusid);
    $("#modal-lg #status_bim1").val(status);
    $("#modal-lg #status_bim2").val(status);
    $("#modal-lg #id").val(id);
    $("#modal-lg #foto").attr("src", "../../assets/foto/" + foto);
  });

  // detail data
  $(document).on("click", "#detaildata1", function () {
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
    $("#modal-lg1 #lemrev").attr("href", "assets/downloadlemrevprop.php?filename=" + lemrev);
    $("#modal-lg1 #filebim").attr("href", "assets/downloadbimprop.php?filename=" + filebim);
    $("#modal-lg1 #file_hasilbim").attr("href", "assets/downloadhasilbimprop.php?filename=" + hasilbim);
    $("#modal-lg1 #pesan").val(pesan);
    $("#modal-lg1 #subjek").val(subjek);
    $("#modal-lg1 #desk").val(desk);
    $("#modal-lg1 #tanggal").val(tanggalbim);
    $("#modal-lg1 #judul").val(judul);
    $("#modal-lg1 #pem").val(pembimbing);
    $("#modal-lg1 #pem1").val(pembimbing);
    $("#modal-lg1 #tgl_sid").val(tglsid);
    $("#modal-lg1 #ruang_sid ").val(ruangsid);
    $("#modal-lg1 #waktu").val(waktusid);
    $("#modal-lg1 #status_bim1").val(status);
    $("#modal-lg1 #status_bim2").val(status);
    $("#modal-lg1 #foto").attr("src", "../../assets/foto/" + foto);
  });
</script>
</body>

</html>