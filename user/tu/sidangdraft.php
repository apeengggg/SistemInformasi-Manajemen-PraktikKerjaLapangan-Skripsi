<?php
session_start();
require "../../koneksi.php";
if (!isset($_SESSION["login_tu"])) {
header("location:../../index.php");
exit();
}
$nidn=$_SESSION["nidn"];
?>

<!-- jadwalkan sidang -->
<?php
if (isset($_POST["ubah"])) {
  $id = $_POST["id"];
  $hasil = $_POST["status"];
  $sql = mysqli_query($conn, "UPDATE draft_sidang SET status_sidang='$hasil' WHERE id_sidang='$id'");
  if ($sql) {
echo "<script>
alert('Status Sidang Berhasil DiUbah')
windows.location.href('sidangdraft.php')
</script>";
  }else {
    echo "<script>
alert('Status Sidang Gagal Diubah')
windows.location.href('sidangdraft.php')
</script>";
  }
}



// jadwal sidang
$date = date('Y-m-d');
$jadwalsidang = mysqli_query($conn,
                        "SELECT DISTINCT mhs.nama, mhs.nim,
                        j.judul,
                        ds.status_sidang,
                        ds.tgl_sidang AS tgl,
                        ds.waktu_sidang AS waktu,
                        ds.ruang_sidang AS ruang, ds.id_sidang, 
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
                        dn.dos1_pen AS dos1p1, dn.dos1_peng AS dos1p11, dn.dos1_sis AS dos1sis, dn.dos1_ap AS dos1ap,
                        dn.dos2_pen AS dos2p1, dn.dos2_peng AS dos2p11, dn.dos2_sis AS dos2sis, dn.dos2_ap AS dos2ap,
                        dn.peng1_pen AS peng1p1, dn.peng1_peng AS peng1p11, dn.peng1_sis AS peng1sis, dn.peng1_ap AS peng1ap,
                        dn.peng2_pen AS peng2p1, dn.peng2_peng AS peng2p11, dn.peng2_sis AS peng2sis, dn.peng2_ap As peng2ap
                        FROM draft_sidang ds 
                        LEFT JOIN skripsi s
                        ON ds.id_skripsi=s.id_skripsi
                        LEFT JOIN proposal p
                        ON s.id_proposal=p.id_proposal
                        LEFT JOIN judul j
                        ON p.id_judul=j.id_judul
                        LEFT JOIN mahasiswa mhs
                        ON j.nim=mhs.nim
                        LEFT JOIN draft_penguji dp
                        ON ds.id_sidang=dp.id_sidang
                        LEFT JOIN draft_nilai dn
                        ON ds.id_sidang=dn.id_sidang
                        WHERE ds.tgl_sidang IS NOT NULL AND ds.status_sidang IS NULL
                        AND (ds.val_dosbing1='2' OR ds.val_dosbing2='2') ORDER BY ds.tgl_sidang ASC") 
                        or die (mysqli_error($conn));


// seluruh data sidang
$datasidang = mysqli_query($conn,
                        "SELECT DISTINCT mhs.nama, mhs.nim,
                        (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd 
                        ON d1.nidn=sd.nidn 
                        WHERE sd.id_skripsi=s.id_skripsi LIMIT 0,1) AS pem1, 
                        (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN skripsi_dosbing sd
                        ON d2.nidn=sd.nidn 
                        WHERE sd.id_skripsi=s.id_skripsi LIMIT 1,1) as pem2, 
                        mhs.nama, mhs.nim, mhs.status_skripsi, judul.judul 
                        FROM draft_sidang ds INNER JOIN skripsi s
                        ON ds.id_skripsi=s.id_skripsi 
                        INNER JOIN proposal 
                        ON s.id_proposal=proposal.id_proposal 
                        INNER JOIN judul
                        ON proposal.id_judul=judul.id_judul 
                        INNER JOIN mahasiswa mhs
                        ON judul.nim=mhs.nim 
                        INNER JOIN skripsi_dosbing sd 
                        ON s.id_skripsi=sd.id_skripsi
                       GROUP BY mhs.nim") 
                        or die (mysqli_error($conn));

// $peng1_pen = $_POST["pen_penguji1"];
// $peng1_peng = $_POST["peng_penguji1"];
// $peng1_sis = $_POST["sis_penguji1"];
// $peng1_ap = $_POST["ap_penguji1"];
// $dos1_pen = $_POST["pen_dos1"];
// $dos1_peng = $_POST["peng_dos1"];
// $dos1_sis = $_POST["sis_dos1"];
// $dos1_ap = $_POST["ap_dos1"];

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
  $statusq = $_POST["hasilsidang1"];
  // var_dump($_POST); die;

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
  windows.location.href='sidangdraft.php'
  </script>";
  }else {
  echo "<script>
  alert('Nilai gagal diinput !')
  windows.location.href='sidangdraft.php'
  </script>";
  }
  }

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Data Sidang Draft | SIM-PS | Tata Usaha</title>
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
          <div class="card-header">
            <center>
              <h1 class="m-0 text-dark" id="penguji">Jadwal Pengujian Sidang Draft</h1>
            </center>
            <!-- <br>  <a href="#bim" class="btn btn-primary">Data Sidang Mahasiswa Bimbingan</a> -->
            <a href="assets/jadwalsidangdraft.php" target="_blank" class="btn btn-success">
              <i class="fas fa-file-export"></i> Export Jadwal
            </a>
            <a href="#all" class="btn btn-primary">Semua Data Sidang</a>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <style>
                .thead {
                  width: absoulute;
                }
              </style>
              <thead class="thead" align="center">
                <tr>
                  <th width="80px">NIM</th>
                  <th width="200px">Nama</th>
                  <th width="120px">Waktu</th>
                  <th width="100px">Ruangan</th>
                  <th width="200px">Penguji 1</th>
                  <th width="200px">Penguji 2</th>
                  <th width="50px">Nilai</th>
                </tr>
              </thead>
              <tbody>
                <?php
                        if (mysqli_num_rows($jadwalsidang) > 0) {
                        while ($data1=mysqli_fetch_array($jadwalsidang) ) {
                        $nim = $data1["nim"]; 
                        $id = base64_encode($nim);
                        $d = $data1["tgl"];
                        $tgl = date('d-M-Y', strtotime($d));
                        ?>

                <!-- tampilkan data -->
                <tr>
                  <td><?php echo $data1["nim"] ?></td>
                  <td><a href="detailsidangdraft.php?id=<?= $id ?>"><?php echo $data1["nama"] ?></a></td>
                  <td align="center"><?php echo $tgl ?><br><?php echo $data1["waktu"] ?></td>
                  <td align="center"><?php echo $data1["ruang"] ?></td>
                  <td><?php echo $data1["penguji1"] ?></td>
                  <td><?php echo $data1["penguji2"] ?></td>
                  <td align="center">
                    <button class="btn-xs btn-dark" data-toggle="modal" data-target="#modalnilai1" id="nilai1"
                      data-id="<?php echo $data1["id_sidang"] ?>" data-ids="<?php echo $data1["id_skripsi"] ?>"
                      data-dos1p1="<?php echo $data1["dos1p1"] ?>" data-dos1p11="<?php echo $data1["dos1p11"] ?>"
                      data-dos1sis="<?php echo $data1["dos1sis"] ?>" data-dos1ap="<?php echo $data1["dos1ap"] ?>"
                      data-dos2p1="<?php echo $data1["dos2p1"] ?>" data-dos2p11="<?php echo $data1["dos2p11"] ?>"
                      data-dos2sis="<?php echo $data1["dos2sis"] ?>" data-dos2ap="<?php echo $data1["dos2ap"] ?>"
                      data-peng1p1="<?php echo $data1["peng1p1"] ?>" data-peng1p11="<?php echo $data1["peng1p11"] ?>"
                      data-peng1sis="<?php echo $data1["peng1sis"] ?>" data-peng1ap="<?php echo $data1["peng1ap"] ?>"
                      data-peng2p1="<?php echo $data1["peng2p1"] ?>" data-peng2p11="<?php echo $data1["peng2p11"] ?>"
                      data-peng2sis="<?php echo $data1["peng2sis"] ?>" data-peng2ap="<?php echo $data1["peng2ap"] ?>"
                      data-status="<?php echo $data1["status_sidang"]?>">
                      <i class="fas fa-file"></i></button>
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
  <!-- /.section 2 -->

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <!-- <h1 class="m-0 text-dark" id="all">Data Sidang Draft Mahasiswa</h1> -->
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
              <h1 class="m-0 text-dark" id="all">Data Sidang Draft Mahasiswa</h1>
            </center><br>
            <button type="submit" class="btn btn-warning" data-toggle="modal" data-target="#modal-md"><i
                class="fas fa-print"></i> Cetak Laporan</button>
            <a href="#penguji" class="btn btn-primary">Data Jadwal Pengujian</a>
            <!-- <a href="#bim" class="btn btn-primary">Data Sidang Mahasiswa Bimbingan</a> -->
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example5" class="table table-bordered table-striped">
              <style>
                .thead {
                  width: absoulute;
                }
              </style>
              <thead class="thead">
                <tr>
                  <th width="80px">NIM</th>
                  <th width="200px">Nama</th>
                  <th width="200px">Pembimbing 1</th>
                  <th width="200px">Pembimbing 2</th>
                  <th width="200px">Judul</th>
                </tr>
              </thead>
              <tbody>
                <?php
                        if (mysqli_num_rows($datasidang) > 0) {
                        while ($data1=mysqli_fetch_array($datasidang) ) {
                        $nim2 = $data1["nim"];
                        $id2 = base64_encode($nim2)
                        ?>

                <!-- tampilkan data -->
                <tr>
                  <td><?php echo $data1["nim"] ?></td>
                  <td><a href="detailsidangdraft.php?id=<?= $id2 ?>"><?php echo $data1["nama"] ?></a></td>
                  <td><?php echo $data1["pem1"] ?></td>
                  <td><?php echo $data1["pem2"] ?></td>
                  <td><?php echo $data1["judul"] ?></td>
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

        <!-- modal cetak laporan -->
        <div class="modal fade" id="modal-md">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Cetak Laporan Sidang Draft Mahasiswa</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="form-horizontal" method="post" action="assets/reportdraft.php">
                  <div class="card-body">
                    <div class="form-group row">
                      <label for="angkatan" class="col-sm-3 col-form-label">Tahun Angkatan</label>
                      <div class="col-sm-9">
                        <select class="form-control" name="angkatan" id="angkatan" required="required">
                          <option value="">Pilih Angkatan...</option>
                          <?php
                                    //ambil data dosen
                                    $sql = mysqli_query($conn, "SELECT angkatan FROM mahasiswa GROUP BY angkatan") or die (mysqli_erorr($conn));
                                    while ($dosen1 = mysqli_fetch_array($sql)) {
                                    ?>
                          <option value="<?=$dosen1["angkatan"]?>"><?=$dosen1["angkatan"]?>
                          </option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="angkatan" class="col-sm-3 col-form-label">Tanggal Sidang/Bulan</label>
                      <div class="col-sm-9">
                        <input type="date" name="tgl_awal" id="tgl_awal" class="form-control-sm">
                        -
                        <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control-sm">
                        <br>
                        <small><b>*Jika Ingin Mencetak Semua Data Sidang, Kosongkan Kolom Tanggal Sidang Pertama dan Kedua<br>
                        *Jika Ingin Mencetak Selama Satu Bulan, Isi Kolom Pertama Tanggal Sidang Pertama Pada
                        Tanggal 1 dan Isi Kolom Kedua Tanggal Sidang Kedua Pada Tanggal Terakhir (28/29/30/31) </b></small>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="jadwalkan"
                  id="jadwalkan">Cetak</button>
              </div>
            </div>
            </form>
          </div>
        </div>
        <!-- modal cetak laporan -->


        <!-- modal tambah bimbingan -->
        <div class="modal fade" id="modalnilai1">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Nilai Sidang Draft</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="form-horizontal" method="post">
                  <div class="card-body">
                    <div class="form-row">
                      <input type="text" class="form-control" id="id" name="id" hidden>
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
                        <label for="hasilsidang1">Hasil Sidang</label>
                        <select name="hasilsidang1" id="hasilsidang1" class="form-control" required="require">
                          <option value="">Pilih Hasil Sidang...</option>
                          <option value="Lulus">Lulus</option>
                          <option value="Tidak Lulus">Tidak Lulus</option>
                        </select>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="hasilsidang">Hasil Sidang</label>
                        <input type="text" class="form-control" id="hasilsidang" name="hasilsidang" readonly>
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
        <!-- modal tambah bimbingan -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>

  <!-- /.section 2 -->
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
    let hasil = $(this).data('status');
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
    $("#modalnilai1 #hasilsidang1").val(hasil);
    $("#modalnilai1 #hasilsidang").val(hasil);
  });
</script>
</body>

</html>