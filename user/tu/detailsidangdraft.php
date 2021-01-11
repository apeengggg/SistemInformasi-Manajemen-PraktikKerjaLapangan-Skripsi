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
$id_sid = mysqli_query($conn, "SELECT dn.id_sidang FROM draft_nilai dn INNER JOIN draft_sidang ds
ON dn.id_sidang=ds.id_sidang INNER JOIN skripsi s
ON ds.id_skripsi=s.id_skripsi INNER JOIN proposal p ON s.id_proposal=p.id_proposal
INNER JOIN judul j ON p.id_judul=j.id_judul INNER JOIN mahasiswa m ON j.nim=m.nim
WHERE m.nim='$decode'  AND dos1_pen IS NOT NULL AND dos2_pen IS NOT NULL AND peng1_pen IS NOT NULL
AND peng2_pen IS NOT NULL");
$id_ = mysqli_fetch_array($id_sid);
$ida = $id_["id_sidang"];
$getdataa = mysqli_query($conn,
                        "SELECT mhs.nama, mhs.nim, mhs.foto,
                        judul.judul,
                        ds.tgl_sidang AS tgl,
                        ds.waktu_sidang AS waktu,
                        ds.ruang_sidang AS ruang, ds.id_sidang AS id, s.id_skripsi,
                        ds.ruang_sidang AS ruang, 
                        ds.status_sidang AS status,
                        -- pembiming 1
                        (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd 
                        ON d1.nidn=sd.nidn 
                        WHERE sd.id_skripsi=s.id_skripsi AND status_dosbing='Pembimbing 1'
                        AND sd.status='Aktif' LIMIT 0,1) AS pem1, 
                        -- pembimbing 2
                        (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN skripsi_dosbing sd
                        ON d2.nidn=sd.nidn 
                        WHERE sd.id_skripsi=s.id_skripsi AND status_dosbing='Pembimbing 2'
                        AND sd.status='Aktif' LIMIT 0,1) as pem2,
                         -- ambil data penguji1 
                        (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN draft_penguji dp
                        ON d1.nidn=dp.penguji 
                        WHERE dp.id_sidang=ds.id_sidang AND status_penguji='Penguji 1'
                        AND dp.status='Aktif' LIMIT 0,1) AS penguji1, 
                        -- ambil data penguji2
                        (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN draft_penguji dp
                        ON d2.nidn=dp.penguji 
                        WHERE dp.id_sidang=ds.id_sidang AND status_penguji='Penguji 2'
                        AND dp.status='Aktif' LIMIT 0,1) as penguji2,
                         -- ambil data nidn1
                         (SELECT d1.nidn FROM dosen d1 INNER JOIN draft_penguji dp
                        ON d1.nidn=dp.penguji 
                        WHERE dp.id_sidang=ds.id_sidang AND status_penguji='Penguji 1'
                        AND dp.status='Aktif' LIMIT 0,1) AS nidn1, 
                        -- ambil data nidn2
                        (SELECT d2.nidn FROM dosen d2 INNER JOIN draft_penguji dp
                        ON d2.nidn=dp.penguji 
                        WHERE dp.id_sidang=ds.id_sidang AND status_penguji='Penguji 2'
                        AND dp.status='Aktif' LIMIT 0,1) as nidn2,
                        dn.dos1_pen AS dos1p1, dn.dos1_peng AS dos1p11, dn.dos1_sis AS dos1sis, dn.dos1_ap AS dos1ap,
                        dn.dos2_pen AS dos2p1, dn.dos2_peng AS dos2p11, dn.dos2_sis AS dos2sis, dn.dos2_ap AS dos2ap,
                        dn.peng1_pen AS peng1p1, dn.peng1_peng AS peng1p11, dn.peng1_sis AS peng1sis, dn.peng1_ap AS peng1ap,
                        dn.peng2_pen AS peng2p1, dn.peng2_peng AS peng2p11, dn.peng2_sis AS peng2sis, dn.peng2_ap As peng2ap,
                        (SELECT ((dos1_pen+dos1_peng+dos1_sis+dos1_ap+dos2_pen+dos2_peng+dos2_sis+dos2_ap+
                        peng1_pen+peng1_peng+peng1_sis+peng1_ap+peng2_pen+peng2_peng+peng2_sis+peng2_ap)/16)
                        FROM draft_nilai WHERE id_sidang='$ida') AS total
                        FROM draft_sidang ds 
                        LEFT JOIN skripsi s
                        ON ds.id_skripsi=s.id_skripsi
                        LEFT JOIN proposal
                        ON s.id_proposal=proposal.id_proposal
                        LEFT JOIN judul 
                        ON proposal.id_judul=judul.id_judul
                        LEFT JOIN mahasiswa mhs
                        ON judul.nim=mhs.nim
                        LEFT JOIN draft_nilai dn
                        ON ds.id_sidang=dn.id_sidang
                        WHERE mhs.nim='$decode' AND ds.tgl_sidang IS NOT NULL ORDER BY ds.tgl_sidang ASC") 
                        or die (mysqli_error($conn));

$getdata = mysqli_query($conn,
                        "SELECT mhs.nama, mhs.nim, mhs.foto,
                        judul.judul,
                        ds.tgl_sidang AS tgl,
                        ds.waktu_sidang AS waktu,
                        ds.ruang_sidang AS ruang, ds.id_sidang,
                        ds.ruang_sidang AS ruang, 
                        ds.status_sidang,
                         -- pembiming 1
                      (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd 
                      ON d1.nidn=sd.nidn 
                      WHERE sd.id_skripsi=s.id_skripsi AND status_dosbing='Pembimbing 1'
                      AND sd.status='Aktif' LIMIT 0,1) AS pem1, 
                      -- pembimbing 2
                      (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN skripsi_dosbing sd
                      ON d2.nidn=sd.nidn 
                      WHERE sd.id_skripsi=s.id_skripsi AND status_dosbing='Pembimbing 2'
                      AND sd.status='Aktif' LIMIT 0,1) as pem2,
                       -- ambil data penguji1
                      (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN draft_penguji dp
                      ON d1.nidn=dp.penguji 
                      WHERE dp.id_sidang=ds.id_sidang AND status_penguji='Penguji 1'
                      AND dp.status='Aktif' LIMIT 0,1) AS penguji1, 
                      -- ambil data penguji2
                      (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN draft_penguji dp
                      ON d2.nidn=dp.penguji 
                      WHERE dp.id_sidang=ds.id_sidang AND status_penguji='Penguji 2'
                      AND dp.status='Aktif' LIMIT 0,1) as penguji2,
                       -- ambil data nidn1
                       (SELECT d1.nidn FROM dosen d1 INNER JOIN draft_penguji dp
                        ON d1.nidn=dp.penguji 
                        WHERE dp.id_sidang=ds.id_sidang AND status_penguji='Penguji 1'
                        AND dp.status='Aktif' LIMIT 0,1) AS nidn1, 
                        -- ambil data nidn2
                        (SELECT d2.nidn FROM dosen d2 INNER JOIN draft_penguji dp
                        ON d2.nidn=dp.penguji 
                        WHERE dp.id_sidang=ds.id_sidang AND status_penguji='Penguji 2'
                        AND dp.status='Aktif' LIMIT 0,1) as nidn2
                        FROM draft_sidang ds 
                        LEFT JOIN skripsi s
                        ON ds.id_skripsi=s.id_skripsi
                        LEFT JOIN proposal
                        ON s.id_proposal=proposal.id_proposal
                        LEFT JOIN judul 
                        ON proposal.id_judul=judul.id_judul
                        LEFT JOIN mahasiswa mhs
                        ON judul.nim=mhs.nim 
                        WHERE mhs.nim='$decode' AND ds.tgl_sidang IS NOT NULL ORDER BY ds.tgl_sidang DESC") 
                        or die (mysqli_error($conn));
$data1 = mysqli_fetch_array($getdata);

if (isset($_POST["ubah1"])) {
  $id = $_POST["id"];
  $peng1_pen = $_POST["pen_penguji1"];
  $peng1_peng = $_POST["peng_penguji1"];
  $peng1_sis = $_POST["sis_penguji1"];
  $peng1_ap = $_POST["ap_penguji1"];
  $peng2_pen = $_POST["pen_penguji2"];
  $peng2_peng = $_POST["peng_penguji2"];
  $peng2_sis = $_POST["sis_penguji2"];
  $peng2_ap = $_POST["ap_penguji2"];
  $dos1_pen = $_POST["pen_dos1"];
  $dos1_peng = $_POST["peng_dos1"];
  $dos1_sis = $_POST["sis_dos1"];
  $dos1_ap = $_POST["ap_dos1"];
  $dos2_pen = $_POST["pen_dos2"];
  $dos2_peng = $_POST["peng_dos2"];
  $dos2_sis = $_POST["sis_dos2"];
  $dos2_ap = $_POST["ap_dos2"];
  $statusq = $_POST["hasilsidang"];
  // var_dump($_POST); die;
  if ($statusq == "Tidak Lulus" || $statusq == "" ) {
    $usid = mysqli_query($conn, "UPDATE draft_sidang SET status_sidang='Tidak Lulus' 
                                  WHERE id_sidang='$id'");
    $unilai = mysqli_query($conn, "UPDATE draft_nilai SET
                  dos1_pen='0', dos1_peng='0', dos1_sis='0', dos1_ap='0',
                  dos2_pen='0', dos2_peng='0', dos2_sis='0', dos2_ap='0',
                  peng1_pen='0', peng1_peng='0', peng1_sis='0', peng1_ap='0',
                  peng2_pen='0', peng2_peng='0', peng2_sis='0', peng2_ap='0'
                  WHERE id_sidang='$id'");
      if ($unilai && $usid) {
        echo "<script>
      alert('Nilai Berhasil diubah !')
      windows.location.href=('detailsidangdraft.php')
      </script>";
      }else {
      echo "<script>
      alert('Nilai gagal diubah !')
      windows.location.href=('detailsidangdraft.php')
      </script>";
      }
  }else{
  $sql = mysqli_query($conn, "UPDATE draft_nilai SET
        dos1_pen='$dos1_pen', dos1_peng='$dos1_peng', dos1_sis='$dos1_sis', dos1_ap='$dos1_ap',
        dos2_pen='$dos2_pen', dos2_peng='$dos2_peng', dos2_sis='$dos2_sis', dos2_ap='$dos2_ap',
        peng1_pen='$peng1_pen', peng1_peng='$peng1_peng', peng1_sis='$peng1_sis', peng1_ap='$peng1_ap',
        peng2_pen='$peng2_pen', peng2_peng='$peng2_peng', peng2_sis='$peng2_sis', peng2_ap='$peng2_ap'
        WHERE id_sidang='$id'")
        ;
  $sql2 = mysqli_query($conn, "UPDATE draft_sidang SET status_sidang='$statusq' WHERE id_sidang='$id'");
  if ($sql && $sql2) {
    echo "<script>
  alert('Nilai Berhasil Diinput !')
  windows.location.href='detailsidangdraft.php'
  </script>";
  }else {
  echo "<script>
  alert('Nilai gagal diinput !')
  windows.location.href='detailsidangdraft.php'
  </script>";
  }
  }
}

if (isset($_POST["ubahdata"])) {
  $tgl = $_POST["tanggal"];
  $waktu = $_POST["waktu"];
  $ruang = $_POST["ruang"];
  $id = $_POST["id"];
// var_dump($_POST); die;
$ceksid = mysqli_query($conn, "SELECT * FROM draft_sidang WHERE id_sidang='$id' AND status_sidang IS NOT NULL");
if (mysqli_num_rows($ceksid)>0) {
  echo "<script>
      alert('Sidang Sudah Dilaksanakan, Tidak Dapat Diubah')
      windows.location.href('detailsidangdraft.php')
      </script>";
}else{
$cekjadwal = mysqli_query($conn, "SELECT tgl_sidang, waktu_sidang, ruang_sidang 
                          FROM draft_sidang WHERE tgl_sidang='$tgl' AND waktu_sidang='$waktu' 
                          AND ruang_sidang='$ruang' AND status_sidang IS NULL");
if (mysqli_num_rows($cekjadwal)>0) {
      echo "<script>
      alert('Gagal mengubah data Sidang, Terdapat jadwal dan atau penguji yang sama dalam satuw waktu')
      windows.location.href('detaildetailsidangdraft.php')
      </script>";
    }else{
    $sql3 = mysqli_query($conn, "UPDATE draft_sidang SET tgl_sidang='$tgl', 
                                waktu_sidang='$waktu', ruang_sidang='$ruang'
                                WHERE id_sidang='$id'");
    if ($sql3) {
      echo "<script>
    alert('Data Sidang Berhasil diubah')
    windows.location.href('detailsidangdraft.php')
    </script>";
    }else {
      echo "<script>
      alert('Data Sidang Gagal diubah')
      windows.location.href('detailsidangdraft.php')
      </script>";
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
    $skrip = $_POST["idskrip"];
    $tgl = $_POST["tanggal"];
    $waktu = $_POST["waktu"];
    $ruang = $_POST["ruang"];
    if ($peng1 === $ni1 || $peng1=== $ni2 AND $peng2 === $ni1 || $peng2=== $ni2 ) {
      echo "<script>
      alert('Penguji Tidak Diubah')
      windows.location.href('detaildetailsidangdraft.php')
      </script>";
    }else{
    $ceksid = mysqli_query($conn, "SELECT * FROM draft_sidang WHERE id_sidang='$id' AND status_sidang IS NOT NULL");
if (mysqli_num_rows($ceksid)>0) {
  echo "<script>
      alert('Sidang Sudah Dilaksanakan, Tidak Dapat Diubah')
      windows.location.href('detaildetailsidangdraft.php')
      </script>";
}else{
  $cekpenguji = mysqli_query($conn, "SELECT penguji, tgl_sidang, waktu_sidang, ruang_sidang, ds.id_sidang
                          FROM draft_sidang ds LEFT JOIN draft_penguji dp
                          ON ds.id_sidang=dp.id_sidang
                          WHERE (dp.penguji='$peng1' OR dp.penguji='$peng2') AND ds.id_sidang !='$id'
                          AND tgl_sidang='$tgl' AND waktu_sidang='$waktu' AND ruang_sidang='$ruang' AND status_sidang IS NULL AND dp.status='Aktif'");

$cekpem = mysqli_query($conn, "SELECT 
                      (SELECT d1.nidn FROM dosen d1 LEFT JOIN skripsi_dosbing sd
                      ON d1.nidn=sd.nidn
                      WHERE id_skripsi='$skrip' AND sd.status_dosbing='Pembimbing 1' AND sd.status='Aktif' LIMIT 0,1) AS pem1,
                      (SELECT d1.nidn FROM dosen d1 LEFT JOIN skripsi_dosbing sd
                      ON d1.nidn=sd.nidn
                      WHERE id_skripsi='$skrip' AND sd.status_dosbing='Pembimbing 2' AND sd.status='Aktif' LIMIT 0,1) AS pem2
                      ");
$q = mysqli_fetch_array($cekpem);

$qa1 = $q["pem1"];
$qa2 = $q["pem2"];
if ($peng1==$qa1 || $peng2==$qa1 || $peng1==$qa2 || $peng2==$qa2) {
  echo "<script>
alert('Penguji sidang tidak boleh sama dengan pembimbing skripsi mahasiswa')
windows.location.href('detaildetailsidangdraft.php')
</script>";
}else{
    if (mysqli_num_rows($cekpenguji)>0) {
      echo "<script>
      alert('Gagal mengubah data Sidang, Terdapat jadwal dan atau penguji yang sama dalam satuw waktu')
      windows.location.href('detaildetailsidangdraft.php')
      </script>";
      }else{
    if ($peng1!=$ni1) {
      $nonaktif = mysqli_query($conn, "UPDATE draft_penguji SET status='Tidak Aktif'
                              WHERE penguji='$ni1' AND status_penguji='Penguji 1' AND id_sidang='$id'");
          if ($nonaktif) {
            $tambah = mysqli_query($conn, "INSERT INTO draft_penguji (id_sidang, penguji, status_penguji)
                            VALUES ('$id','$peng1','Penguji 1')");
            if ($tambah) {
              echo "<script>
              alert('Data Penguji 1 Berhasil diubah')
              windows.location.href('detailsidangdraft.php')
              </script>";
            } else {
              echo "<script>
              alert('Data Penguji 2 Gagal diubah')
              windows.location.href('detailsidangdraft.php')
              </script>";
            }
          }
     if ($peng2!=$ni2) {
      $nonaktif2 = mysqli_query($conn, "UPDATE draft_penguji SET status='Tidak Aktif'
                               WHERE penguji='$ni2' AND status_penguji='Penguji 2' AND id_sidang='$id'");
        if ($nonaktif2) {
          $tambah1 = mysqli_query($conn, "INSERT INTO draft_penguji (id_sidang, penguji, status_penguji)
                          VALUES ('$id','$peng2','Penguji 2')");
            if ($tambah1) {
              echo "<script>
              alert('Data Penguji 2 Berhasil diubah')
              windows.location.href('detailsidangdraft.php')
              </script>";
            } else {
              echo "<script>
              alert('Data Penguji 2 Gagal diubah')
              windows.location.href('detailsidangdraft.php')
              </script>";
            }
        }
     } else {
      echo "<script>
      alert('Data Penguji 2 Tidak diubah')
      windows.location.href('detailsidangdraft.php')
      </script>";
     }
    }else {
      if ($peng2!=$ni2) {
        $nonaktif2 = mysqli_query($conn, "UPDATE draft_penguji SET status='Tidak Aktif'
                                 WHERE penguji='$ni2' AND status_penguji='Penguji 2' AND id_sidang='$id'");
          if ($nonaktif2) {
            $tambah1 = mysqli_query($conn, "INSERT INTO draft_penguji (id_sidang, penguji, status_penguji)
                            VALUES ('$id','$peng2','Penguji 2')");
              if ($tambah1) {
                echo "<script>
                alert('Data Penguji 2 Berhasil diubah')
                windows.location.href('detailsidangdraft.php')
                </script>";
              } else {
                echo "<script>
                alert('Data Penguji 2 Gagal diubah')
                windows.location.href('detailsidangdraft.php')
                </script>";
              }
          }
       } else {
        echo "<script>
        alert('Data Penguji 2 Tidak diubah')
        windows.location.href('detailsidangdraft.php')
        </script>";
       }
      echo "<script>
      alert('Data Penguji 1 Tidak diubah')
      windows.location.href('detailsidangdraft.php')
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
  <title>Detail Sidang Draft | SIM-PS | Tata Usaha</title>
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
              <a href="sidangdraft.php" class="btn btn-warning">Kembali</a>
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
          <!-- <div class="card-header">
                 </div> -->
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
                  <h5>Pem 1</h5>
                </td>
                <td align="left">
                  <h5>:</h5>
                </td>
                <td>
                  <h5><?= $data1["pem1"] ?></h5>
                </td>
              </tr>
              <tr>
                <td colspan="3">
                  <hr>
                </td>
              </tr>
              <tr>
                <td align="left">
                  <h5>Pem 2</h5>
                </td>
                <td align="left">
                  <h5>:</h5>
                </td>
                <td>
                  <h5><?= $data1["pem2"] ?></h5>
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
              <tr>
                <td colspan="3">
                  <hr>
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
              <h3 class="m-0 text-dark">Data Sidang Draft,
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
                  <th width="110px">Waktu</th>
                  <th width="50px">Ruang</th>
                  <th width="90px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                        $no=1;
                        if (mysqli_num_rows($getdataa) > 0) {
                        while ($data=mysqli_fetch_array($getdataa)) {
                          $d = $data["tgl"];
                          $tgl = date('d-M-Y', strtotime($d));
                          $dataq = $data["total"];
                          if ($dataq > 85) {
                            $grade = 'A';
                          }elseif ($dataq > 70 AND $dataq < 85) {
                            $grade = 'B';
                          }elseif ($dataq > 55 AND $dataq < 70) {
                            $grade = 'C';
                          }elseif ($dataq > 40 AND $dataq < 55) {
                            $grade = 'D';
                          }elseif ($dataq > 0 AND $dataq < 40) {
                            $grade = 'E';
                          }elseif ($dataq = "" OR $dataq == 0){
                            $grade = "";
                          }
                        ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $data['penguji1'] ?></td>
                  <td><?= $data['penguji2'] ?></td>
                  <td align="center"><?= $tgl ?><br><?= $data['waktu'] ?></td>
                  <td align="center"><?= $data['ruang'] ?></td>
                  <td align="center">
                    <button class="btn-xs btn-warning" id="ubah" data-toggle="modal" data-target="#modalubah"
                      data-id="<?= $data["id"]?>" data-ruang="<?= $data["ruang"]?>" data-tanggal="<?= $data["tgl"]?>"
                      data-waktu="<?= $data["waktu"]?>" data-penguji1="<?= $data["penguji1"]?>"
                      data-penguji2="<?= $data["penguji2"]?>" data-nidn1="<?= $data["nidn1"]?>"
                      data-nidn2="<?= $data["nidn2"]?>" data-status="<?= $data["status"]?>">
                      <i class="fas fa-edit"></i></button>
                    <button class="btn-xs btn-warning" id="ubahp" data-toggle="modal" data-target="#modalpenguji"
                      data-id="<?= $data["id"]?>" data-ids="<?= $data["id_skripsi"]?>" data-ruang="<?= $data["ruang"]?>"
                      data-tanggal="<?= $data["tgl"]?>" data-waktu="<?= $data["waktu"]?>"
                      data-penguji1="<?= $data["penguji1"]?>" data-penguji2="<?= $data["penguji2"]?>"
                      data-nidn1="<?= $data["nidn1"]?>" data-nidn2="<?= $data["nidn2"]?>">
                      <i class="fas fa-user"></i></button>
                    <button class="btn-xs btn-danger" data-toggle="modal" data-target="#modalnilai1" id="nilai1"
                      data-id="<?php echo $data["id"] ?>" data-ids="<?php echo $data["id_skripsi"] ?>"
                      data-dos1p1="<?php echo $data["dos1p1"] ?>" data-dos1p11="<?php echo $data["dos1p11"] ?>"
                      data-dos1sis="<?php echo $data["dos1sis"] ?>" data-dos1ap="<?php echo $data["dos1ap"] ?>"
                      data-dos2p1="<?php echo $data["dos2p1"] ?>" data-dos2p11="<?php echo $data["dos2p11"] ?>"
                      data-dos2sis="<?php echo $data["dos2sis"] ?>" data-dos2ap="<?php echo $data["dos2ap"] ?>"
                      data-peng1p1="<?php echo $data["peng1p1"] ?>" data-peng1p11="<?php echo $data["peng1p11"] ?>"
                      data-peng1sis="<?php echo $data["peng1sis"] ?>" data-peng1ap="<?php echo $data["peng1ap"] ?>"
                      data-peng2p1="<?php echo $data["peng2p1"] ?>" data-peng2p11="<?php echo $data["peng2p11"] ?>"
                      data-peng2sis="<?php echo $data["peng2sis"] ?>" data-peng2ap="<?php echo $data["peng2ap"] ?>"
                      data-status="<?php echo $data["status"] ?>" data-total="<?php echo $data["total"] ?>"
                      data-grade="<?php echo $grade ?>">
                      <i class="fas fa-info-circle"></i></button>
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
                <h4 class="modal-title">Form Ubah Sidang Draft</h4>
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
                    <!-- <div class="form-group row">
                      <label for="status" class="col-sm-3 col-form-label">Hasil Sidang</label>
                      <div class="col-sm-9">
                        <select class="form-control" name="status" id="status">
                          <option value="">Pilih Hasil Sidang...</option>
                          <option value="Lulus">Lulus</option>
                          <option value="Tidak Lulus">Tidak Lulus</option>
                          <option value="Perpustakaan">Perpusatakaan</option>
                        </select>
                      </div>
                    </div> -->
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
                <h4 class="modal-title">Form Ubah Penguji Sidang Draft</h4>
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
                        <input type="text" name="idskrip" id="idskrip" class="form form-control" readonly hidden>
                        <input type="date" name="tanggal" id="tanggal" class="form form-control" required readonly
                          hidden>
                        <input type="time" name="waktu" id="waktu" class="form form-control" required readonly hidden>
                        <select class="form-control" name="ruang" id="ruang" required="required">
                          <option value="">Pilih Ruangan...</option>
                          <option value="Lab Informatika">Lab Informatika</option>
                          <option value="Lab Peternakan">Lab Peternakan</option>
                          <option value="Perpustakaan">Perpusatakaan</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="penguji1" class="col-sm-3 col-form-label">Nama penguji 1</label>
                      <div class="col-sm-9">
                        <select class="form-control" name="penguji1" id="penguji1" required>
                          <option value="">Pilih Penguji 1...</option>
                          <?php
                                    //ambil data dosen
                                    $sql = mysqli_query($conn, "SELECT * FROM dosen WHERE jabatan IS NOT NULL") or die (mysqli_erorr($conn));
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
                                    $sql = mysqli_query($conn, "SELECT * FROM dosen WHERE jabatan IS NOT NULL") or die (mysqli_erorr($conn));
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

        <!-- formnilai -->
        <div class="modal fade" id="modalnilai1">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Ubah/Detail Nilai Sidang Draft</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="form-horizontal" method="post">
                  <div class="card-body">
                    <div class="form-row">
                      <input type="text" class="form-control" id="id" name="id" readonly hidden>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-3">
                        <label for="npm1">Penyampaian Materi Penguji1</label>
                        <input type="number" class="form-control" id="pen_penguji1" name="pen_penguji1" max="100"
                          min="0">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="npm11">Penyampaian Materi Penguji2</label>
                        <input type="number" class="form-control" id="pen_penguji2" name="pen_penguji2" max="100"
                          min="0">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="npm11">Penyampaian Materi Pemb1</label>
                        <input type="number" class="form-control" id="pen_dos1" name="pen_dos1" max="100" min="0">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="npm11">Penyampaian Materi Pemb2</label>
                        <input type="number" class="form-control" id="pen_dos2" name="pen_dos2" max="100" min="0">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-3">
                        <label for="npm2">Penguasaan Penguji1</label>
                        <input type="number" class="form-control" id="peng_penguji1" name="peng_penguji1" max="100"
                          min="0">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="npm22">Penguasaan Materi Penguji2</label>
                        <input type="number" class="form-control" id="peng_penguji2" name="peng_penguji2" max="100"
                          min="0">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="npm11">Penguasaan Materi Pemb1</label>
                        <input type="number" class="form-control" id="peng_dos1" name="peng_dos1" max="100" min="0">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="npm11">Penguasaan Materi Pemb2</label>
                        <input type="number" class="form-control" id="peng_dos2" name="peng_dos2" max="100" min="0">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-3">
                        <label for="sistematika">Sistematika Penulisan Penguji1</label>
                        <input type="number" class="form-control" id="sis_penguji1" name="sis_penguji1" max="100"
                          min="0">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="sistematika1">Sitematika Penulisan Penguji2</label>
                        <input type="number" class="form-control" id="sis_penguji2" name="sis_penguji2" max="100"
                          min="0">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="npm11">Sistematika Penulisan Pemb1</label>
                        <input type="number" class="form-control" id="sis_dos1" name="sis_dos1" max="100" min="0">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="npm11">Sistematika Penulisan Pemb2</label>
                        <input type="number" class="form-control" id="sis_dos2" name="sis_dos2" max="100" min="0">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-3">
                        <label for="sistematika">TanggungJawab Aplikasi Penguji1</label>
                        <input type="number" class="form-control" id="ap_penguji1" name="ap_penguji1" max="100" min="0">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="sistematika1">TanggungJawab Aplikasi Penguji2</label>
                        <input type="number" class="form-control" id="ap_penguji2" name="ap_penguji2" max="100" min="0">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="npm11">TanggungJawab Aplikasi Pemb1</label>
                        <input type="number" class="form-control" id="ap_dos1" name="ap_dos1" max="100" min="0">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="npm11">TanggungJawab Aplikasi Pemb2</label>
                        <input type="number" class="form-control" id="ap_dos2" name="ap_dos2" max="100" min="0">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="hasilsidang">Hasil Sidang</label>
                        <select class="form-control" name="hasilsidang" id="hasilsidang" required>
                          <option value="">Pilih Hasil Sidang...</option>
                          <option value="Lulus">Lulus</option>
                          <option value="Tidak Lulus">Tidak Lulus</option>
                          <!-- <option value="Perpustakaan">Perpusatakaan</option> -->
                        </select>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="sistematika1">Rata-rata Nilai</label>
                        <input type="number" class="form-control" id="total" name="total" max="100" min="0" readonly>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="sistematika1">Mutu Nilai</label>
                        <input type="text" class="form-control" id="grade" name="grade" readonly>
                      </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                      <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="ubah1"
                        id="ubah1">Kirim</button>
                    </div>
                  </div>
                </form>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
          </div>
        </div>
        <!-- /.modal -->
        <!-- /. form nilai -->

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
    let ids = $(this).data('ids');
    let tanggal = $(this).data('tanggal');
    let ruang = $(this).data('ruang');
    let waktu = $(this).data('waktu');
    $("#modalpenguji #id").val(id);
    $("#modalpenguji #penguji1").val(penguji1);
    $("#modalpenguji #penguji11").val(penguji1);
    $("#modalpenguji #penguji2").val(penguji2);
    $("#modalpenguji #penguji12").val(penguji2);
    $("#modalpenguji #nidn11").val(nidn1);
    $("#modalpenguji #nidn12").val(nidn2);
    $("#modalpenguji #idskrip").val(ids);
    $("#modalpenguji #waktu").val(waktu);
    $("#modalpenguji #ruang").val(ruang);
    $("#modalpenguji #tanggal").val(tanggal);
  });

  /// detail data
  $(document).on("click", "#nilai1", function () {
    let d = $(this).data('id');
    let dos1p1 = $(this).data('dos1p1');
    let dos1p11 = $(this).data('dos1p11');
    let dos1sis = $(this).data('dos1sis');
    let dos1ap = $(this).data('dos1ap');
    let dos2p1 = $(this).data('dos2p1');
    let dos2p11 = $(this).data('dos2p11');
    let dos2sis = $(this).data('dos2sis');
    let dos2ap = $(this).data('dos2ap');
    let peng1p1 = $(this).data('peng1p1');
    let peng1p11 = $(this).data('peng1p11');
    let peng1sis = $(this).data('peng1sis');
    let peng1ap = $(this).data('peng1ap');
    let peng2p1 = $(this).data('peng2p1');
    let peng2p11 = $(this).data('peng2p11');
    let peng2sis = $(this).data('peng2sis');
    let peng2ap = $(this).data('peng2ap');
    let total = $(this).data('total');
    let hasil = $(this).data('status');
    let grade = $(this).data('grade');
    $("#modalnilai1 #id").val(d);
    $("#modalnilai1 #pen_penguji1").val(peng1p1);
    $("#modalnilai1 #pen_penguji2").val(peng2p1);
    $("#modalnilai1 #pen_dos1").val(dos1p1);
    $("#modalnilai1 #pen_dos2").val(dos2p1);
    $("#modalnilai1 #peng_penguji1").val(peng1p11);
    $("#modalnilai1 #peng_penguji2").val(peng2p11);
    $("#modalnilai1 #peng_dos1").val(dos1p11);
    $("#modalnilai1 #peng_dos2").val(dos2p11);
    $("#modalnilai1 #sis_penguji1").val(peng1sis);
    $("#modalnilai1 #sis_penguji2").val(peng2sis);
    $("#modalnilai1 #sis_dos1").val(dos1sis);
    $("#modalnilai1 #sis_dos2").val(dos2sis);
    $("#modalnilai1 #ap_penguji1").val(peng1ap);
    $("#modalnilai1 #ap_penguji2").val(peng2ap);
    $("#modalnilai1 #ap_dos1").val(dos1ap);
    $("#modalnilai1 #ap_dos2").val(dos2ap);
    $("#modalnilai1 #hasilsidang").val(hasil);
    $("#modalnilai1 #total").val(total);
    $("#modalnilai1 #grade").val(grade);
  });
</script>
</body>

</html>