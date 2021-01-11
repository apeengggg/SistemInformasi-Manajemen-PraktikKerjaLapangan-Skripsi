<?php
session_start();
if (!isset($_SESSION["login_tu"])) {
header("location:../../index.php");
exit();
}
require "../../koneksi.php";
$nidn = $_SESSION["nidn"];

// ambil id BImbingan di get
if (isset($_GET["id"])) {
$decode = base64_decode($_GET["id"]);
}
//ambi data bimbingan
$getdataa = mysqli_query($conn,
                        "SELECT DISTINCT mhs.nama, mhs.nim, mhs.foto,
                        judul.judul, ps.id_sidang As id,
                        d1.nama_dosen AS pembimbing,
                        ps.tgl_sidang AS tgl,
                        ps.waktu_sidang AS waktu,
                        ps.ruang_sidang AS ruang, ps.id_sidang, proposal.id_proposal,
                        -- ambil data penguji1
                        (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN proposal_penguji pp
                        ON d1.nidn=pp.penguji 
                        WHERE pp.id_sidang=ps.id_sidang AND pp.status='Aktif'
                        AND status_penguji='Penguji 1' LIMIT 0,1 ) AS penguji1, 
                        -- ambil data penguji2
                        (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN proposal_penguji pp
                        ON d2.nidn=pp.penguji 
                        WHERE pp.id_sidang=ps.id_sidang  AND pp.status='Aktif' 
                        AND status_penguji='Penguji 2' LIMIT 0,1) as penguji2,
                        (SELECT d4.nidn FROM dosen d4 INNER JOIN proposal_penguji pp
                        ON d4.nidn=pp.penguji 
                        WHERE pp.id_sidang=ps.id_sidang AND pp.status='Aktif'
                        AND status_penguji='Penguji 1' LIMIT 0,1) AS nidn1, 
                        (SELECT d5.nidn FROM dosen d5 INNER JOIN proposal_penguji pp
                        ON d5.nidn=pp.penguji 
                        WHERE pp.id_sidang=ps.id_sidang  AND pp.status='Aktif'
                        AND status_penguji='Penguji 2' LIMIT 0,1) as nidn2,
                        ps.status_sidang AS status
                        FROM proposaL_sidang ps 
                        LEFT JOIN proposal
                        ON ps.id_proposal=proposal.id_proposal
                        LEFT JOIN dosen d1
                        ON d1.nidn=proposal.dosbing
                        LEFT JOIN judul 
                        ON proposal.id_judul=judul.id_judul
                        LEFT JOIN mahasiswa mhs
                        ON judul.nim=mhs.nim
                        LEFT JOIN proposal_penguji pp
                        ON ps.id_sidang=pp.id_sidang
                        WHERE mhs.nim='$decode' AND ps.tgl_sidang IS NOT NULL ORDER BY ps.tgl_sidang DESC") 
                        or die (mysqli_error($conn));

$getdata = mysqli_query($conn,
                        "SELECT DISTINCT mhs.nama, mhs.nim, mhs.foto,
                        judul.judul,
                        d1.nama_dosen AS pembimbing,
                        ps.tgl_sidang AS tgl,
                        ps.waktu_sidang AS waktu,
                        ps.ruang_sidang AS ruang, ps.id_sidang,
                        (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN proposal_penguji pp
                        ON d2.nidn=pp.penguji 
                        WHERE pp.id_sidang=ps.id_sidang AND pp.status='Aktif'
                        AND status_penguji='Penguji 1' LIMIT 0,1) AS penguji1, 
                        (SELECT d3.nama_dosen FROM dosen d3 INNER JOIN proposal_penguji pp
                        ON d3.nidn=pp.penguji 
                        WHERE pp.id_sidang=ps.id_sidang  AND pp.status='Aktif'
                        AND status_penguji='Penguji 2' LIMIT 0,1) as penguji2,
                        (SELECT d4.nidn FROM dosen d4 INNER JOIN proposal_penguji pp
                        ON d4.nidn=pp.penguji 
                        WHERE pp.id_sidang=ps.id_sidang AND pp.status='Aktif' LIMIT 0,1) AS nidn1, 
                        (SELECT d5.nidn FROM dosen d5 INNER JOIN proposal_penguji pp
                        ON d5.nidn=pp.penguji 
                        WHERE pp.id_sidang=ps.id_sidang  AND pp.status='Aktif' LIMIT 1,1) as nidn2,
                        ps.status_sidang AS status
                        FROM proposaL_sidang ps 
                        LEFT JOIN proposal
                        ON ps.id_proposal=proposal.id_proposal
                        LEFT JOIN dosen d1
                        ON d1.nidn=proposal.dosbing
                        LEFT JOIN judul 
                        ON proposal.id_judul=judul.id_judul
                        LEFT JOIN mahasiswa mhs
                        ON judul.nim=mhs.nim
                        LEFT JOIN proposal_penguji pp
                        ON ps.id_sidang=pp.id_sidang
                          WHERE mhs.nim='$decode' ORDER BY ps.tgl_sidang desc") 
                        or die (mysqli_error($conn));
$data1 = mysqli_fetch_array($getdata);

if (isset($_POST["ubahdata"])) {
  $tgl = $_POST["tanggal"];
  $waktu = $_POST["waktu"];
  $ruang = $_POST["ruang"];
  $status = $_POST["status"];
  $id = $_POST["id"];
  $ceksid = mysqli_query($conn, "SELECT * FROM proposal_sidang WHERE id_sidang='$id' AND status_sidang IS NOT NULL");
  if (mysqli_num_rows($ceksid)>0) {
    echo "<script>
        alert('Sidang Sudah Dilaksanakan, Tidak Dapat Diubah')
        windows.location.href('sidangproposal.php')
        </script>";
  }else{
  $cekjadwal = mysqli_query($conn, "SELECT tgl_sidang, waktu_sidang, ruang_sidang FROM proposal_sidang 
                          WHERE tgl_sidang='$tgl' AND waktu_sidang='$waktu' AND ruang_sidang='$ruang'
                          AND status_sidang IS NULL");
  if (mysqli_num_rows($cekjadwal)>0) {
      echo "<script>
      alert('Gagal mengubah data Sidang, Terdapat jadwal dan atau penguji yang sama dalam satuw waktu')
      windows.location.href('detailsidangprop.php')
      </script>";
    }else{
  if ($status == NULL OR $status == '') {
    $sql3 = mysqli_query($conn, "UPDATE proposal_sidang SET tgl_sidang='$tgl', 
                                waktu_sidang='$waktu', ruang_sidang='$ruang'
                                WHERE id_sidang='$id'"); 
    if ($sql3) {
      echo "<script>
    alert('Data Sidang Berhasil diubah')
    windows.location.href('sidangproposal.php')
    </script>";
    }else {
      echo "<script>
      alert('Data Sidang Gagal diubah')
      windows.location.href('sidangproposal.php')
      </script>";
    }
  }else {
    $sql3 = mysqli_query($conn, "UPDATE proposal_sidang SET tgl_sidang='$tgl', 
                                waktu_sidang='$waktu', ruang_sidang='$ruang', status_sidang='$status'
                                WHERE id_sidang='$id'");
    if ($sql3) {
      echo "<script>
    alert('Data Sidang Berhasil diubah')
    windows.location.href('sidangproposal.php')
    </script>";
    }else {
      echo "<script>
      alert('Data Sidang Gagal diubah')
      windows.location.href('sidangproposal.php')
      </script>";
      } 
    }
  }
}
}
  if (isset($_POST["ubahpeng"])) {
    $peng1 = $_POST["penguji1"];
    $peng2 = $_POST["penguji2"];
    $ni1 = $_POST["nidn11"];
    $ni2 = $_POST["nidn12"];
    $id = $_POST["id"];
    $prop = $_POST["idprop"];
    $tgl = $_POST["tanggal"];
    $waktu = $_POST["waktu"];
    $ruang = $_POST["ruang"];
    // var_dump($_POST); die;
    $ceksid = mysqli_query($conn, "SELECT * FROM proposal_sidang WHERE id_sidang='$id' AND status_sidang IS NOT NULL");
if (mysqli_num_rows($ceksid)>0) {
  echo "<script>
      alert('Sidang Sudah Dilaksanakan, Tidak Dapat Diubah')
      windows.location.href('sidangproposal.php')
      </script>";
}else{
  
  $cekpenguji = mysqli_query($conn, "SELECT DISTINCT
  tgl_sidang, waktu_sidang, ruang_sidang FROM proposal_sidang ps INNER JOIN proposal_penguji pp ON ps.id_sidang=pp.id_sidang
  WHERE tgl_sidang='$tgl' AND waktu_sidang='$waktu'
  AND status_sidang IS NULL AND 
  (penguji = (SELECT penguji FROM proposal_penguji pp INNER JOIN dosen d
  ON d.nidn=pp.penguji
  WHERE pp.id_sidang=ps.id_sidang AND status_penguji='Penguji 1' AND status='Aktif' AND penguji='$peng1') OR 
  penguji = (SELECT penguji FROM proposal_penguji pp INNER JOIN dosen d
  ON d.nidn=pp.penguji
  WHERE pp.id_sidang=ps.id_sidang AND status_penguji='Penguji 2' AND status='Aktif' AND penguji='$peng2'))");

  $cekpembimbing = mysqli_query($conn, "SELECT dosbing FROM proposal WHERE id_proposal='$prop'");
  
  $q = mysqli_fetch_array($cekpembimbing);
  $qa = $q["dosbing"];
  if ($peng1==$qa || $peng2==$qa) {
    echo "<script>
  alert('Penguji sidang tidak boleh sama dengan pembimbing proposal mahasiswa')
  windows.location.href('detailsidangprop.php')
  </script>";
  }else{
    if (mysqli_num_rows($cekpenguji)>0) {
      echo "<script>
      alert('Gagal mengubah data Sidang, Terdapat jadwal dan atau penguji yang sama dalam satuw waktu')
      windows.location.href('detailsidangprop.php')
      </script>";
      }else{
    if ($peng1==$peng2) {
      echo "<script>
      alert('Penguji 1 dan 2 Tidak Boleh Sama')
      windows.location.href('sidangproposal.php')
      </script>";
    }else{
    if ($peng1!=$ni1) {
      $nonaktif = mysqli_query($conn, "UPDATE proposal_penguji SET status='Tidak Aktif'
                              WHERE penguji='$ni1' AND status_penguji='Penguji 1' AND id_sidang='$id'");
          if ($nonaktif) {
            $tambah = mysqli_query($conn, "INSERT INTO proposal_penguji (id_sidang, penguji, status_penguji)
                            VALUES ('$id','$peng1','Penguji 1')");
            if ($tambah) {
              echo "<script>
              alert('Data Penguji 1 Berhasil diubah')
              windows.location.href('sidangproposal.php')
              </script>";
            } else {
              echo "<script>
              alert('Data Penguji 2 Gagal diubah')
              windows.location.href('sidangproposal.php')
              </script>";
            }
      }
     if ($peng2!=$ni2) {
      $nonaktif2 = mysqli_query($conn, "UPDATE proposal_penguji SET status='Tidak Aktif'
                               WHERE penguji='$ni2' AND status_penguji='Penguji 2' AND id_sidang='$id'");
        if ($nonaktif2) {
          $tambah1 = mysqli_query($conn, "INSERT INTO proposal_penguji (id_sidang, penguji, status_penguji)
                          VALUES ('$id','$peng2','Penguji 2')");
            if ($tambah1) {
              echo "<script>
              alert('Data Penguji 2 Berhasil diubah')
              windows.location.href('sidangproposal.php')
              </script>";
            } else {
              echo "<script>
              alert('Data Penguji 2 Gagal diubah')
              windows.location.href('sidangproposal.php')
              </script>";
            }
        }
     } else {
      echo "<script>
      alert('Data Penguji 2 Tidak diubah')
      windows.location.href('sidangproposal.php')
      </script>";
     }
    }else {
      echo "<script>
      alert('Data Penguji 1 Tidak diubah')
      windows.location.href('sidangproposal.php')
      </script>";
    }
  }
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
  <title>Detail Sidang Proposal | SIM-PS | Tata Usaha</title>
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
<?php include 'assets/header.php'; ?>
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
              <a href="sidangproposal.php" class="btn btn-warning">Kembali</a>
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
                <td colspan="3" align="center">
                  <img src="../../assets/foto/<?= $data1["foto"]?>" alt="" width="130px" height="130px">
                </td>
              </tr>
              <tr>
                <td colspan="3">
                  <hr>
                </td>
              </tr>
              <tr>
                <td align="left">
                  <h5>Nama</h5>
                </td>
                <td align="left">
                  <h5>:</h5>
                </td>
                <td>
                  <h5><?= $data1["nama"] ?></h5>
                </td>
              </tr>
              <tr>
                <td colspan="3">
                  <hr>
                </td>
              </tr>
              <tr>
                <td align="left">
                  <h5>Judul</h5>
                </td>
                <td align="left">
                  <h5>:</h5>
                </td>
                <td>
                  <h5><?= $data1["judul"] ?></h5>
                </td>
              </tr>
              <tr>
                <td colspan="3">
                  <hr>
                </td>
              </tr>
              <tr>
                <td align="left">
                  <h5>Pembimbing</h5>
                </td>
                <td align="left">
                  <h5>:</h5>
                </td>
                <td>
                  <h5><?= $data1["pembimbing"] ?></h5>
                </td>
              </tr>
              <tr>
                <td colspan="3">
                  <hr>
                </td>
              </tr>
              <tr>
                <td align="left">
                  <h5>Jumlah </h5>
                </td>
                <td align="left">
                  <h5>:</h5>
                </td>
                <?php $jml = mysqli_num_rows($getdata) ?>
                <td>
                  <h5><?= $jml.' Kali Sidang' ?></h5>
                </td>
              </tr>

            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <center>
              <h3 class="m-0 text-dark">Data Sidang Proposal,
                <?=$data1["nama"] ?></h3>
            </center>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead align="center">
                <tr>
                  <th width="10px">No</th>
                  <th width="200px">Penguji 1</th>
                  <th width="200px">Penguji 2</th>
                  <th width="120px">Waktu</th>
                  <th width="50px">Ruang</th>
                  <th width="50px">Hasil</th>
                  <th width="67px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                        $no=1;
                        if (mysqli_num_rows($getdataa) > 0) {
                        while ($data=mysqli_fetch_array($getdataa)) {
                        $d = $data["tgl"];
                        $tgl = date('d-M-Y', strtotime($d));
                        ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $data['penguji1'] ?></td>
                  <td><?= $data['penguji2'] ?></td>
                  <td align="center"><?= $tgl ?><br><?= $data['waktu'] ?></td>
                  <td align="center"><?= $data['ruang'] ?></td>
                  <td><?= $data['status'] ?></td>
                  <td align="center">
                    <button class="btn-xs btn-warning" id="ubah" data-toggle="modal" data-target="#modalubah"
                      data-id="<?= $data["id"]?>" data-idprop="<?= $data["id_proposal"]?>"
                      data-ruang="<?= $data["ruang"]?>" data-tanggal="<?= $data["tgl"]?>"
                      data-waktu="<?= $data["waktu"]?>" data-penguji1="<?= $data["penguji1"]?>"
                      data-penguji2="<?= $data["penguji2"]?>" data-nidn1="<?= $data["nidn1"]?>"
                      data-nidn2="<?= $data["nidn2"]?>" data-status="<?= $data["status"]?>">
                      <i class="fas fa-edit"></i></button>
                    <button class="btn-xs btn-warning" id="ubahp" data-toggle="modal" data-target="#modalpenguji"
                      data-id="<?= $data["id"]?>" data-idprop="<?= $data["id_proposal"]?>"
                      data-penguji1="<?= $data["penguji1"]?>" data-penguji2="<?= $data["penguji2"]?>"
                      data-ruang="<?= $data["ruang"]?>" data-tanggal="<?= $data["tgl"]?>"
                      data-waktu="<?= $data["waktu"]?>" data-nidn1="<?= $data["nidn1"]?>"
                      data-nidn2="<?= $data["nidn2"]?>">
                      <i class="fas fa-user"></i></button>
                  </td>
                </tr>
                <?php }
                              }
                              ?>
              </tbody>
            </table>

          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- form ubah data sidang -->
        <div class="modal fade" id="modalubah">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Form Ubah Sidang Proposal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="form-horizontal" method="post">
                  <div class="card-body">
                    <div class="form-group row">
                      <div class="col-sm-9">
                        <input type="text" name="id" id="id" class="form form-control" readonly hidden>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="tanggal" class="col-sm-3 col-form-label">Tanggal Sidang</label>
                      <div class="col-sm-9">
                        <input type="date" name="tanggal" id="tanggal" class="form form-control" required>
                        <!-- <input type="text" name="tanggal1" id="tanggal1" class="form-control"> -->
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="waktu" class="col-sm-3 col-form-label">Waktu Sidang</label>
                      <div class="col-sm-9">
                        <input type="time" name="waktu" id="waktu" class="form form-control" required>
                      </div>
                    </div>
                    <!-- <div class="form-group row">
                                <label for="instansi" class="col-sm-3 col-form-label">Instansi</label>
                                <div class="col-sm-9">
                                <input type="text" name="instansi" id="instansi" class="form form-control">
                                </div>
                              </div> -->
                    <div class="form-group row">
                      <label for="ruang" class="col-sm-3 col-form-label">Ruang Sidang</label>
                      <div class="col-sm-9">
                        <select class="form-control" name="ruang" id="ruang" required="required">
                          <option value="">Pilih Ruangan...</option>
                          <option value="Lab Informatika">Lab Informatika</option>
                          <option value="Lab Peternakan">Lab Peternakan</option>
                          <option value="Perpustakaan">Perpusatakaan</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="status" class="col-sm-3 col-form-label">Hasil Sidang</label>
                      <div class="col-sm-9">
                        <select class="form-control" name="status" id="status" required>
                          <option value="">Pilih Hasil Sidang...</option>
                          <option value="Lulus">Lulus</option>
                          <option value="Tidak Lulus">Tidak Lulus</option>
                          <!-- <option value="Perpustakaan">Perpusatakaan</option> -->
                        </select>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="ubahdata" id="ubahdata">Ubah
                  Data</button>
              </div>
            </div>
            </form>
          </div>
        </div>
        <!-- form ubah data sidang -->

        <!-- form ubah penguji -->
        <div class="modal fade" id="modalpenguji">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Form Ubah Penguji Sidang Proposal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="form-horizontal" method="post">
                  <div class="card-body">
                    <div class="form-group row">
                      <div class="col-sm-9">
                        <input type="text" name="id" id="id" class="form form-control" readonly hidden>
                        <input type="text" name="idprop" id="idprop" class="form form-control" readonly hidden>
                      </div>
                    </div>
                    <div class="form-group row">

                      <div class="col-sm-9">
                        <input type="date" name="tanggal" id="tanggal" class="form form-control" required hidden>
                        <input type="time" name="waktu" id="waktu" class="form form-control" required hidden>
                        <select class="form-control" name="ruang" id="ruang" required="required">
                          <option value="">Pilih Ruangan...</option>
                          <option value="Lab Informatika">Lab Informatika</option>
                          <option value="Lab Peternakan">Lab Peternakan</option>
                          <option value="Perpustakaan">Perpusatakaan</option>
                        </select>
                        <!-- <input type="text" name="tanggal1" id="tanggal1" class="form-control"> -->
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="penguji1" class="col-sm-3 col-form-label">Nama penguji 1</label>
                      <div class="col-sm-9">
                        <select class="form-control" name="penguji1" id="penguji1" required>
                          <option value="">Pilih Penguji 1...</option>
                          <?php
                                    //ambil data dosen
                                    $sql = mysqli_query($conn, "SELECT * FROM dosen") or die (mysqli_erorr($conn));
                                    while ($dosen1 = mysqli_fetch_array($sql)) {
                                    ?>
                          <option value="<?=$dosen1["nidn"]?>"><?=$dosen1["nama_dosen"]?>
                          </option>
                          <?php } ?>
                        </select>
                      </div>
                      <label for="penguji11" class="col-sm-3 col-form-label">Nama Penguji 1 Saat Ini</label>
                      <div class="col-sm-5">
                        <input type="text" name="penguji11" id="penguji11" class="form-control" readonly>
                      </div>
                      <div class="col-sm-4">
                        <input type="text" name="nidn11" id="nidn11" class="form-control" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="penguji2" class="col-sm-3 col-form-label">Nama Penguji 2</label>
                      <div class="col-sm-9">
                        <select class="form-control" name="penguji2" id="penguji2" required>
                          <option value="">Pilih Penguji 2...</option>
                          <?php
                                    //ambil data dosen
                                    $sql = mysqli_query($conn, "SELECT * FROM dosen") or die (mysqli_erorr($conn));
                                    while ($dosen1 = mysqli_fetch_array($sql)) {
                                    ?>
                          <option value="<?=$dosen1["nidn"]?>"><?=$dosen1["nama_dosen"]?>
                          </option>
                          <?php } ?>
                        </select>
                      </div>
                      <label for="penguji12" class="col-sm-3 col-form-label">Nama Penguji 2 Saat Ini</label>
                      <div class="col-sm-5">
                        <input type="text" name="penguji12" id="penguji12" class="form-control" readonly>
                      </div>
                      <div class="col-sm-4">
                        <input type="text" name="nidn12" id="nidn12" class="form-control" readonly>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="ubahpeng" id="ubahpeng">Ubah
                  Data</button>
              </div>
            </div>
            </form>
          </div>
        </div>
        <!-- form ubah penguji -->

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
  $(document).on("click", "#ubah", function () {
    let id = $(this).data('id');
    let penguji1 = $(this).data('penguji1');
    let penguji2 = $(this).data('penguji2');
    let nidn1 = $(this).data('nidn1');
    let nidn2 = $(this).data('nidn2');
    let tanggal = $(this).data('tanggal');
    let ruang = $(this).data('ruang');
    let waktu = $(this).data('waktu');
    let status = $(this).data('status');
    $("#modalubah #status").val(status);
    $("#modalubah #id").val(id);
    $("#modalubah #penguji1").val(penguji1);
    $("#modalubah #penguji11").val(penguji1);
    $("#modalubah #penguji2").val(penguji2);
    $("#modalubah #penguji12").val(penguji2);
    $("#modalubah #nidn11").val(nidn1);
    $("#modalubah #nidn12").val(nidn2);
    $("#modalubah #waktu").val(waktu);
    $("#modalubah #ruang").val(ruang);
    $("#modalubah #tanggal").val(tanggal);
  });

  // detail data
  $(document).on("click", "#ubahp", function () {
    let id = $(this).data('id');
    let penguji1 = $(this).data('penguji1');
    let penguji2 = $(this).data('penguji2');
    let nidn1 = $(this).data('nidn1');
    let nidn2 = $(this).data('nidn2');
    let tanggal = $(this).data('tanggal');
    let ruang = $(this).data('ruang');
    let waktu = $(this).data('waktu');
    let idprop = $(this).data('idprop');
    $("#modalpenguji #id").val(id);
    $("#modalpenguji #penguji1").val(penguji1);
    $("#modalpenguji #penguji11").val(penguji1);
    $("#modalpenguji #penguji2").val(penguji2);
    $("#modalpenguji #penguji12").val(penguji2);
    $("#modalpenguji #nidn11").val(nidn1);
    $("#modalpenguji #nidn12").val(nidn2);
    $("#modalpenguji #waktu").val(waktu);
    $("#modalpenguji #ruang").val(ruang);
    $("#modalpenguji #tanggal").val(tanggal);
    $("#modalpenguji #idprop").val(idprop);
  });
</script>
</body>

</html>