<?php
session_start();
require "../../koneksi.php";
if (!isset($_SESSION["login_mhs"])) {
header("location:../../index.php");
exit();
}
$nim = $_SESSION["nim"];
// $akun = $_SESSION["id_akun"];
// pengajuan ke pa
// var_dump($_POST["ajukanpa"]);
if (isset($_POST["ajukanpa"])) {
$cekpkl = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE nim='$nim' AND status_pkl='Lulus'");
if (mysqli_num_rows($cekpkl)===0) {
  echo "<script>
  alert('Anda Belum Lulus PKL, atau status pkl anda belum diubah, hubungi tata usaha')
  windows.location.href('datajudul.php')
  </script>";
}else{
$judul = $_POST["judul"];
$deskripsi = $_POST["deskripsi"];
$tujuan = $_POST["tujuan"];
$sk = $_POST["studikasus1"];
// cek sudah ada judul yang disetujui ?
$ceksetuju1 = mysqli_query($conn, "SELECT * FROM judul WHERE nim='$nim' AND (status_judul='Disetujui' OR status_judul='Menunggu')") or die(mysqli_erorr($conn));
if (mysqli_num_rows($ceksetuju1) > 0) {
echo "<script>
alert('Anda Sudah Mempunyai Judul Yang Disetujui Atau Anda Sudah Mengajukan Judul dan Belum Di validasi! Tidak Bisa Mengajukan Judul Lagi !')
windows.location.href('datajudul.php')
</script>";
}else{
$insertpa = mysqli_query($conn, "UPDATE judul SET deskripsi_judul='$deskripsi', tujuan='$tujuan',
                        studi_kasus='$sk', status_judul='Menunggu' WHERE id_judul='$judul'")
or die (mysqli_error($conn));
if ($insertpa) {
echo "<script>
alert('Berhasil Mengajukan Judul')
windows.location.href('datajudul.php')
</script>";
}else {
echo "<script>
alert('Judul Gagal Diajukan ')
windows.location.href('datajudul.php')
</script>";
}
}
}
}
// pengajuan ke dosen
// var_dump($_POST["ajukandosen"]);
// if (isset($_POST["ajukandosen"])) {
//   $cekpkl = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE nim='$nim' AND status_pkl='Lulus'");
//   if (mysqli_num_rows($cekpkl)===0) {
//     echo "<script>
//     alert('Anda Belum Lulus PKL, atau status pkl anda belum diubah, hubungi tata usaha')
//     windows.location.href('datajudul.php')
//     </script>";
//   }else{
// $dosbing1 = $_POST["dosbing1"];
// $judul1 = $_POST["judul_skripsi"];
// $deskripsi1 = $_POST["deskripsi_judul"];
// $sk1 = $_POST["studikasus1"];
// // cek sudah ada judul yang disetujui ?
// $ceksetuju = mysqli_query($conn, "SELECT * FROM judul WHERE nim='$nim' AND status_judul='Disetujui'");
// if (mysqli_num_rows($ceksetuju) > 0) {
// echo "<script>
// alert('Anda Sudah Mempunyai Judul Yang Disetujui ! Tidak Bisa Mengajukan Judul Lagi !')
// windows.location.href('datajudul.php')
// </script>";
// }
// else {
// $insertdosen = mysqli_query($conn, "INSERT INTO judul (nim, judul, deskripsi_judul, tujuan, studi_kasus) VALUES ('$nim', '$judul1', '$deskripsi1', '$dosbing1', '$sk1')") or die (mysqli_erorr($conn));
// if ($insertdosen) {
// echo "<script>
// alert('Judul Berhasil Diajukan ke Dosen')
// windows.location.href('datajudul.php')
// </script>";
// }else {
// echo "<script>
// alert('Judul Gagal Diajukan')
// windows.location.href('datajudul.php')
// </script>";
// }
// }
// }
// }
// ubah judul
if (isset($_POST["ubahjudul"])) {
$id_judul = $_POST["id"];
$judul = $_POST["judul"];
$deskrip = $_POST["deskripsi"];
$sk2 = $_POST["studikasus"];
// cek judul apakah masih ditolak?
$cekstatujudul1 = mysqli_query($conn, "SELECT * FROM judul WHERE status_judul='Ditolak' AND id_judul='$id_judul'") or die (mysqli_query($conn));
if (mysqli_num_rows($cekstatujudul1)>0) {
echo "<script>
alert('Status Judul Yang Anda Ubah Ditolak, Anda Tidak Dapat Mengubah Judul Silahkan ')
windows.location.href('datajudul.php')
</script>";
}else {
$update = mysqli_query($conn, "UPDATE judul SET
judul='$judul',
deskripsi_judul='$deskrip',
studi_kasus='$sk2'
WHERE id_judul='$id_judul'") or die (mysqli_erorr($conn));
if ($update) {
echo "<script>
alert('Judul Berhasil Diubah')
windows.location.href('datajudul.php')
</script>";
}else {
echo "<script>
alert('Judul Gagal Diubah')
windows.location.href('datajudul.php')
</script>";
}
}
}

// ubah judul
if (isset($_POST["hapusjudul"])) {
  $id_judul = $_POST["id"];
  // cek judul apakah masih ditolak?
  $cekstatujudul1 = mysqli_query($conn, "SELECT * FROM judul WHERE status_judul='Disetujui' AND id_judul='$id_judul'") or die (mysqli_query($conn));
  if (mysqli_num_rows($cekstatujudul1)>0) {
  echo "<script>
  alert('Status Judul Yang Anda Hapus Sudah Disetujui, Anda Tidak Dapat Menghapus Judul Ini')
  windows.location.href('datajudul.php')
  </script>";
  }else {
  $update = mysqli_query($conn, "UPDATE judul SET
  status='1'
  WHERE id_judul='$id_judul'") or die (mysqli_erorr($conn));
  if ($update) {
  echo "<script>
  alert('Judul Berhasil dihapus')
  windows.location.href('datajudul.php')
  </script>";
  }else {
  echo "<script>
  alert('Judul Gagal Dihapus')
  windows.location.href('datajudul.php')
  </script>";
  }
  }
  }
//ambil data peasihat akademik
$pemb1 = mysqli_query($conn, "SELECT * FROM dosen WHERE tipe_akun='PenasihatAkademik' AND jabatan IS NOT NULL") or die (mysqli_error($conn));
//ambil data dosen
$pemb = mysqli_query($conn, "SELECT * FROM dosen WHERE jabatan IS NOT NULL") or die (mysqli_error($conn));
// ambil data judul
$judul123 = mysqli_query($conn, "SELECT * FROM judul WHERE status='0' AND nim='$nim'") or die (mysqli_error($conn));


if (isset($_POST["tambahjudul"])) {
$j = $_POST["judul"]; 

$sql = mysqli_query($conn, "INSERT INTO judul (judul, nim, status_judul) 
                    VALUES ('$j','$nim','')");
if ($sql) {
  echo "<script>
  alert('Judul Berhasil Ditambahkan')
  windows.location.href('datajudul.php')
  </script>";
}else{
  echo "<script>
  alert('Judul Gagal Ditambahkan')
  windows.location.href('datajudul.php')
  </script>";
}
}

$pdos = mysqli_query($conn, "SELECT d.nama_dosen FROM proposal LEFT JOIN dosen d 
                    ON proposal.dosbing=d.nidn LEFT JOIN judul ON proposal.id_judul=judul.id_judul
                    LEFT JOIN mahasiswa ON judul.nim=mahasiswa.nim WHERE mahasiswa.nim='$nim'");
$q = mysqli_fetch_array($pdos);
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Data Judul | SIM-PS | Mahasiswa</title>
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
        <div class="col-sm-6">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
          </ul>
          <!-- <h1 class="m-0 text-dark">Data Judul Skripsi Mahasiswa</h1> -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <center>
              <h1 class="m-0 text-dark">Progress Pengajuan Judul Skripsi</h1>
              <hr>
            </center>
            <!-- <button class="btn-sm btn-primary" data-toggle="modal" data-target="#modaljudul">
                    <i class="fas fa-plus"></i> Tambah Judul
                  </button>
                  <hr> -->
            <!-- cek apakah sudah ada judul -->
            <?php
                    $judul = mysqli_query($conn, "SELECT * FROM judul WHERE nim='$nim'");
                    if (mysqli_num_rows($judul)===0) {
                    ?>
            <div class="alert alert-danger" role="alert">
              <b>Anda Belum Mempunyai Judul Skripsi</b>, Silahkan Tambah Judul Anda, dan Pilih Opsi Pengajuan Judul
              Skripsi di Bawah.
            </div>
            <?php } ?>
            <!-- cek ada yg ditolak? -->
            <?php
                    $ignore = mysqli_query($conn, "SELECT * FROM judul WHERE nim='$nim' AND status_judul='Ditolak' AND status='0'");
                    if (mysqli_num_rows($ignore)>0) {
                    ?>
            <div class="alert alert-danger" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <b>Judul Yang Anda Ajukan Ditolak</b>, Silahkan Ajukan Judul Lain, Pilih Opsi Pengajuan Judul Skripsi di
              Bawah. <b>Dan Hapus Judul Yang Ditolak Untuk Menghilangkan Notifikasi Ini</b>
            </div>
            <?php } ?>
            <center>
              <!-- <h2>Ajukan Judul Skripsi</h2> -->
              <button class="btn btn-success" data-toggle="modal" data-target="#modal-lg1">Ajukan Judul</button>
              <!-- <button class="btn btn-warning" data-toggle="modal" data-target="#modal-lg">Ajukan Ke Dosen</button> -->
            </center>
            <br>
            <?php
                    if (mysqli_num_rows($pdos)<1) {
                    ?>
            Pembimbing Proposal Anda : <b>Belum Dipilih</b>
            <?php }else{?>
            Pembimbing Proposal Anda : <?= $q["nama_dosen"] ?>
            <?php } ?>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <!-- cek sudah ada judul belum -->
            <section class="col-lg-12 connectedSortable">
              <!-- form start -->
              <table id="example1" class="table table-bordered table-striped">
                <thead align="center">
                  <tr>
                    <!-- <th>id</th> -->
                    <!-- <th>No</th> -->
                    <th width="350px">Judul</th>
                    <th width="200px">Studi Kasus</th>
                    <th width="50px">Status</th>
                    <th width="70px">Tgl</th>
                    <th width="200px">Ajukan Ke</th>
                    <th width="90px">Tujuan</th>
                    <th width="60px">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                          //ambi data judul
                          $getdata = mysqli_query($conn,
                          "SELECT * FROM judul
                          LEFT JOIN dosen
                          ON judul.tujuan=dosen.nidn
                          WHERE judul.nim='$nim' AND dosen.jabatan IS NOT NULL AND judul.status='0'") or die (mysqli_erorr($conn));
                          while ($data=mysqli_fetch_array($getdata)) {
                          $no=1;
                          ?>
                  <td><?= $data["judul"] ?></td>
                  <td><?= $data["studi_kasus"] ?></td>
                  <td align="center">
                    <!-- ubah tulisan -->
                    <?php
                            if ($data["status_judul"]=="Menunggu") {
                            ?>
                    <span class="badge badge-primary">
                      <?php } else if ($data["status_judul"]=="Ditolak"){
                              ?>
                      <span class="badge badge-danger">
                        <?php }else if($data["status_judul"]=="Disetujui") {
                                ?>
                        <span class="badge badge-success">
                          <?php } ?>
                          <?= $data["status_judul"] ?></span></td>
                  <td><?= $data["tanggal_pengajuan"] ?></td>
                  <td><?= $data["nama_dosen"] ?></td>
                  <td><?= $data["tipe_akun"] ?></td>
                  <td align="center">
                    <?php
                                  $encode = base64_encode($data["id_judul"]); ?>
                    <button class="btn-xs btn-dark" id="detailjudul" data-toggle="modal" data-target="#modal-lg3"
                      data-judul="<?= $data["judul"]?>" data-id="<?= $data["id_judul"]?>"
                      data-deskripsi="<?= $data["deskripsi_judul"]?>" data-sk="<?= $data["studi_kasus"]?>"><i
                        class="fas fa-edit"></i>
                    </button>
                    <button class="btn-xs btn-danger" id="detailjudul" data-toggle="modal" data-target="#modal-lg4"
                      data-judul="<?= $data["judul"]?>" data-id="<?= $data["id_judul"]?>"
                      data-deskripsi="<?= $data["deskripsi_judul"]?>"><i class="fas fa-trash"></i>
                    </button>
                  </td>
                  </tr>
                  <?php   } ?>
                </tbody>
              </table>

          </div>
  </section>

  <!-- kumpulan draft judul -->
  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <center>
              <h3 class="m-0 text-dark">Data Draft Judul Skripsi</h3>
              <hr>
            </center>
            <button class="btn-sm btn-primary" data-toggle="modal" data-target="#modaljudul">
              <i class="fas fa-plus"></i> Tambah Judul
            </button>
            <hr>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <!-- cek sudah ada judul belum -->
            <section class="col-lg-12 connectedSortable">
              <!-- form start -->
              <table id="example1" class="table table-bordered table-striped">
                <thead align="center">
                  <tr>
                    <!-- <th>id</th> -->
                    <!-- <th>No</th> -->
                    <th width="350px">Judul</th>
                    <th width="100px">Status</th>
                    <!-- <th width="50px">Status</th>
                            <th width="70px">Tgl</th>
                            <th width="200px">Ajukan Ke</th>
                            <th width="90px">Tujuan</th> -->
                    <th width="60px">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                          //ambi data judul
                          $getdata = mysqli_query($conn,
                          "SELECT * FROM judul
                          WHERE judul.nim='$nim' AND status='0'") or die (mysqli_erorr($conn));
                          while ($data=mysqli_fetch_array($getdata)) {
                          $no=1;
                          ?>
                  <td><?= $data["judul"] ?></td>
                  <td><?= $data["status_judul"] ?></td>
                  <td align="center">
                    <?php
                                  $encode = base64_encode($data["id_judul"]); ?>
                    <button class="btn-xs btn-dark" id="detailjudul" data-toggle="modal" data-target="#modal-lg3"
                      data-judul="<?= $data["judul"]?>" data-id="<?= $data["id_judul"]?>"
                      data-deskripsi="<?= $data["deskripsi_judul"]?>" data-sk="<?= $data["studi_kasus"]?>"><i
                        class="fas fa-edit"></i>
                    </button>
                    <button class="btn-xs btn-danger" id="detailjudul" data-toggle="modal" data-target="#modal-lg4"
                      data-judul="<?= $data["judul"]?>" data-id="<?= $data["id_judul"]?>"
                      data-deskripsi="<?= $data["deskripsi_judul"]?>"><i class="fas fa-trash"></i>
                    </button>
                  </td>
                  </tr>
                  <?php   } ?>
                </tbody>
              </table>
            </section>
            <!-- kumpulan draft judul -->
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
              <h3 class="m-0 text-dark">Judul Skripsi Teknik Informatika</h3>
            </center>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <!-- cek sudah ada judul belum -->
            <section class="col-lg-12 connectedSortable">
              <!-- form start -->
              <table id="example5" class="table table-bordered table-striped">
                <thead align="center">
                  <tr>
                    <th width="50px">NIM</th>
                    <th width="100px">Nama</th>
                    <th width="100px">Judul</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                          //ambi data judul
                          $getdata = mysqli_query($conn,
                          "SELECT * FROM judul INNER JOIN mahasiswa
                          ON judul.nim=mahasiswa.nim
                          WHERE judul.status_judul='Disetujui'") or die (mysqli_erorr($conn));
                          while ($data=mysqli_fetch_array($getdata)) {
                          $no=1;
                          ?>
                  <td><?= $data["nim"] ?></td>
                  <td><?= $data["nama"] ?></td>
                  <td><?= $data["judul"] ?></td>
                  </tr>
                  <?php   } ?>
                </tbody>
              </table>
            </section>
            <!-- kumpulan draft judul -->
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
</div>
</section>
<!-- /.content -->
</div>
</div>
<!-- modal ajukan ke pa -->
<div class="modal fade" id="modal-lg1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-tittle">Form Pengajuan Judul</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" class="form-horizontal">
          <div class="card-body">
            <div class="form-group row">
              <label for="tujuan" class="col-sm-3 co-form-label">Nama Dosen</label>
              <div class="col-sm-9">
                <select class="form-control" name="tujuan" id="tujuan" required="required">
                  <option value="">Pilih</option>
                  <?php
                      while ($datapemb1 = mysqli_fetch_array($pemb1)) {
                      ?>
                  <option value="<?=$datapemb1["nidn"]?>"><?=$datapemb1["nama_dosen"]?> (<?=$datapemb1["tipe_akun"]?>)
                  </option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="judul" class="col-sm-3 co-form-label">Judul</label>
              <div class="col-sm-9">
                <select class="form-control" name="judul" id="judul" required="required">
                  <option value="">Pilih</option>
                  <?php
                      while ($d = mysqli_fetch_array($judul123)) {
                      ?>
                  <option value="<?=$d["id_judul"]?>"><?=$d["judul"]?>
                  </option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi Judul</label>
              <div class="col-sm-9">
                <textarea class="form-control" rows="3" placeholder="Jelaskan Mengenai Judul Anda Disini (Max 500)"
                  name="deskripsi" id="deskripsi" required="required"></textarea>
                <small id="emailHelp" class="form-text text-muted">Jelaskan Judul/Topik Yang Anda Ajukan
                  Sejelas-jelasnya dan Mudah dimengerti.</small>
              </div>
            </div>
            <div class="form-group row">
              <label for="studikasus" class="col-sm-3 co-form-label">Studi Kasus</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="studikasus1" name="studikasus1"
                  placeholder="Rencana Studi Kasus" required="required">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="ajukanpa"
              id="ajukanpa">Ajukan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- /.modal ajukan ke pa -->

<!-- modal ajukan ke dosen -->
<!-- <div class="modal fade"  id="modal-lg">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-tittle">Form Pengajuan Judul Ke Dosen</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" class="form-horizontal">
              <div class="card-body">
                <div class="from-group row">
                  <div class="col-sm-9">
                    <div class="form-group row">
                      <label for="dosbing1" class="col-sm-3 co-form-label">Dosen Pembimbing 1</label>
                      <div class="col-sm-9">
                        <select class="form-control" name="dosbing1" id="dosbing1" required="required">
                          <option disabled selected>Pilih</option>
                          <?php
                          while ($datapemb = mysqli_fetch_array($pemb)) {
                          ?>
                          <option value="<?=$datapemb["nidn"]?>"><?=$datapemb["nama_dosen"]?>
                          </option>
                          <?php } ?>
                        </select>
                        <small id="emailHelp" class="form-text text-muted">Dosen Pembimbing 1 Akan Menjadi Dosen Pembimbing Proposal Anda</small>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="judul_skripsi" class="col-sm-3 co-form-label">Judul</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="judul_skripsi" name="judul_skripsi" placeholder="Judul Skripsi" required="required">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi Judul</label>
                      <div class="col-sm-9">
                        <textarea class="form-control" rows="3" placeholder="Jelaskan Mengenai Judul Anda Disini" name="deskripsi_judul" id="deskripsi_judul" required="required"></textarea>
                        <small id="emailHelp" class="form-text text-muted">Jelaskan Judul/Topik Yang Anda Ajukan Sejelas-jelasnya dan Mudah dimengerti.</small>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="studikasus" class="col-sm-3 co-form-label">Studi Kasus</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="studikasus1" name="studikasus1" placeholder="Judul Skripsi" required="required">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="ajukandosen" id="ajukandosen">Ajukan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div> -->
<!-- /.modal ajukan ke dosen -->
<!-- modal ubah -->
<div class="modal fade" id="modal-lg3">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-tittle">Form Ubah Judul</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" class="form-horizontal">
          <div class="card-body">
            <div class="from-group row">
              <div class="col-sm-9">
                <div class="form-group row">
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="id" name="id" required="required" hidden readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="judul" class="col-sm-3 co-form-label">Judul</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="judul" name="judul" placeholder="Judul Skripsi"
                      required="required">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi Judul</label>
                  <div class="col-sm-9">
                    <textarea class="form-control" rows="3" name="deskripsi" id="deskripsi"
                      required="required"></textarea>
                    <small id="emailHelp" class="form-text text-muted">Jelaskan Judul/Topik Yang Anda Ajukan
                      Sejelas-jelasnya dan Mudah dimengerti.</small>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="studikasus" class="col-sm-3 co-form-label">Studi Kasus</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="studikasus" name="studikasus"
                      placeholder="Judul Skripsi" required="required">
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="ubahjudul" id="ubahjudul">Ubah</button>
      </div>
      </form>
    </div>
  </div>
</div>
</div>
<!-- /. modal ubah -->

<!-- modal hapus -->
<div class="modal fade" id="modal-lg4">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-body">
        <form method="post" class="form-horizontal">
          <div class="card-body">
            <div class="from-group row">
              <div class="col-sm-12">
                <div class="form-group row">
                  <div class="col-sm-12">
                    <input type="text" class="form-control" id="id" name="id" required="required" readonly hidden>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="studikasus" class="col-sm-12 co-form-label">
                    <center>
                      <h2>Apakah Anda Yakin Ingin Menghapus ?</h2>
                    </center>
                  </label>
                </div>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary toastrDefaultDanger" name="hapusjudul"
          id="hapusjudul">Hapus</button>
      </div>
      </form>
    </div>
  </div>
</div>
</div>
<!-- /. modal hapus -->

<!-- modal tambah judul -->
<div class="modal fade" id="modaljudul">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-tittle">Form Tambah Judul Skripsi</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" class="form-horizontal">
          <div class="card-body">
            <div class="form-group row">
              <label for="judul_skripsi" class="col-sm-3 co-form-label">Judul</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="judul" name="judul" placeholder="Judul Skripsi"
                  required="required">
              </div>
            </div>
            <!-- <div class="form-group row">
                  <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi Judul</label>
                  <div class="col-sm-9">
                    <textarea class="form-control" rows="3" placeholder="Deksipsi Judul (Max 500)" name="desk" id="desk" required="required"></textarea>
                  </div>
                </div> -->
            <!-- <div class="form-group row">
                  <label for="studikasus" class="col-sm-3 co-form-label">Studi Kasus</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="studi_kasus" name="studi_kasus" placeholder="Studi K" required="required">
                  </div>
                </div>
              </div> -->
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="tambahjudul"
                id="tambahjudul">Simpan</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
<!-- /.modal tambah judul -->
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
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
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
  $(document).on("click", "#detailjudul", function () {
    let id = $(this).data('id');
    let judul = $(this).data('judul');
    let deskripsi = $(this).data('deskripsi');
    let sk = $(this).data('sk');
    $("#modal-lg3 #id").val(id);
    $("#modal-lg4 #id").val(id);
    $("#modal-lg3 #judul").val(judul);
    $("#modal-lg3 #deskripsi").val(deskripsi);
    $("#modal-lg3 #studikasus").val(sk);
  });
</script>
<!-- <script type="text/javascript">
  function isi_otomatis(){
      var id_judul = $("#modal-lg1 #id_judul").val();
      $.ajax({
          url: 'assets/ajax.php',
          data:"id_judul="+id_judul ,
      }).success(function (data) {
            var json = data,
            obj = JSON.parse(json);
            $('#deskripsi').val(obj.deskripsi);
          });
    }
</script> -->
</body>

</html>