<?php
error_reporting(0);
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
  "SELECT 
  mahasiswa.nama AS nama,
  mahasiswa.foto AS fotomhs,
  d1.foto_dosen AS fotopem,
  d2.foto_dosen AS fotopeng,
  pkl.judul_laporan AS judul,
  d1.nama_dosen AS pembimbing,
  d2.nama_dosen AS penguji,
  sid.tgl_sid AS tanggal,
  sid.ruang_sid AS ruang,
  sid.waktu AS waktu,
  sid.status_sid AS hasil
  FROM pkl_sidang sid 
  LEFT JOIN pkl
  ON sid.id_pkl=pkl.id_pkl
  LEFT JOIN dosen_wali
  ON pkl.id_dosenwali=dosen_wali.id_dosenwali
  LEFT JOIN dosen d1
  ON dosen_wali.nidn=d1.nidn
  LEFT JOIN dosen d2
  ON sid.penguji=d2.nidn
  LEFT JOIN mahasiswa
  ON pkl.nim=mahasiswa.nim
  WHERE mahasiswa.nim='$decode' ORDER BY sid.tgl_sid ASC") or die (mysqli_erorr($conn));
  $data1 = mysqli_fetch_array($getdataa);
  
  $id_sid = mysqli_query($conn, "SELECT id_sidang FROM pkl_nilai pn INNER JOIN pkl_sidang ps
  ON pn.id_sidang=ps.id_sidpkl INNER JOIN pkl p ON ps.id_pkl=p.id_pkl INNER JOIN mahasiswa m
  ON p.nim=m.nim WHERE m.nim='$decode'");
  $id_ = mysqli_fetch_array($id_sid);
  $ida = $id_["id_sidang"];
  $getdata = mysqli_query($conn,
  "SELECT 
  mahasiswa.nama AS nama,
  mahasiswa.foto AS fotomhs,
  d1.foto_dosen AS fotopem,
  d2.foto_dosen AS fotopeng,
  pkl.judul_laporan AS judul,
  d1.nama_dosen AS pembimbing,
  d2.nama_dosen AS penguji,
  sid.tgl_sid AS tanggal,
  sid.ruang_sid AS ruang, 
  sid.waktu AS waktu,
  sid.status_sid AS hasil, sid.id_sidpkl AS id, pkl.id_pkl,
  pn.peng_pen_mat AS p1, pn.peng_peng_mat AS p2, pn.peng_sis AS sis,
  pn.pem_peng_mat AS p11, pn.pem_peng_mat AS p22, pn.pem_sis AS sis1,
  (SELECT ((pem_pen_mat+pem_peng_mat+pem_sis+peng_peng_mat+peng_pen_mat+peng_sis)/6) 
  FROM pkl_nilai WHERE id_sidang='$ida') AS total
  FROM pkl_sidang sid 
  LEFT JOIN pkl
  ON sid.id_pkl=pkl.id_pkl
  LEFT JOIN dosen_wali
  ON pkl.id_dosenwali=dosen_wali.id_dosenwali
  LEFT JOIN dosen d1
  ON dosen_wali.nidn=d1.nidn
  LEFT JOIN dosen d2
  ON sid.penguji=d2.nidn
  LEFT JOIN mahasiswa
  ON pkl.nim=mahasiswa.nim
  LEFT JOIN pkl_nilai pn 
  ON sid.id_sidpkl=pn.id_sidang
  WHERE mahasiswa.nim='$decode' AND sid.tgl_sid IS NOT NULL ORDER BY sid.tgl_sid ASC") or die (mysqli_erorr($conn));

if (isset($_POST["ubahdata"])) {
  // var_dump($_POST); die;
  $peng = $_POST["penguji"];
  $ruang = $_POST["ruang"];
  $tgl = $_POST["tanggal"];
  $waktu = $_POST["waktu"];
  // $status= $_POST["status"]; 
  $id = $_POST["id"];
  $idpkl = $_POST["idpkl"];
$ceksd = mysqli_query($conn, "SELECT status_sid FROM pkl_sidang WHERE id_sidpkl='$id' AND status_sid IS NOT NULL");
  if (mysqli_num_rows($ceksd)>0) {
    echo "<script>
alert('Sidang sudah dilaksanakan, tidak dapat diubah')
windows.location.href('detailsidangpkl.php')
</script>";
  }else{
$cekjadwal = mysqli_query($conn, "SELECT tgl_sid, waktu, ruang_sid FROM pkl_sidang 
                          WHERE tgl_sid='$tgl' AND waktu='$waktu' AND ruang_sid='$ruang'
                          AND status_sid IS NULL");
$cekpenguji = mysqli_query($conn, "SELECT penguji, tgl_sid, waktu, ruang_sid FROM pkl_sidang 
                            WHERE penguji='$peng' AND tgl_sid='$tgl' AND waktu='$waktu'
                            AND status_sid IS NULL");
$cekpem = mysqli_query($conn, "SELECT d1.nidn FROM dosen d1 LEFT JOIN dosen_wali dw
                      ON d1.nidn=dw.nidn LEFT JOIN pkl p ON dw.id_dosenwali=p.id_dosenwali
                      WHERE id_pkl='$idpkl'");
$q = mysqli_fetch_array($cekpem);
$qa = $q["nidn"];
// var_dump($_POST);
// var_dump($qa); die;
if ($peng==$qa) {
  echo "<script>
alert('Penguji sidang tidak boleh sama dengan pembimbing pkl mahasiswa')
windows.location.href('detailsidangpkl.php')
</script>";
}else{
  if (mysqli_num_rows($cekjadwal)>0 OR mysqli_num_rows($cekpenguji)>0) {
    echo "<script>
    alert('Gagal mengubah data Sidang, Terdapat jadwal dan atau penguji yang sama dalam satuw waktu')
    windows.location.href('detailsidangpkl.php')
    </script>";
    }else{
        $sql = mysqli_query($conn, "UPDATE pkl_sidang SET 
        penguji='$peng',
        tgl_sid='$tgl',
        ruang_sid='$ruang',
        waktu='$waktu'
        WHERE id_sidpkl='$id'");
          if ($sql) {
          echo "<script>
          alert('Berhasil Merubah Data Sidangss')
          windows.location.href('detailsidang.php')
          </script>";
          } else {
          echo "<script>
          alert('Gagal merubah data sidang')
          windows.location.href('detailsidang.php')
          </script>";
          }
      }
      }
} 
}

if (isset($_POST["ubah"])) {
  $id = $_POST["id"];
  $hasil = $_POST["hasilsidang"];
  $p1 = $_POST["npm1"]; 
  $p11 = $_POST["npm11"];
  $sis1 = $_POST["sistematika"];
  $p2 = $_POST["npm2"];
  $p22 = $_POST["npm22"];
  $sis2 = $_POST["sistematika1"];
  if ($hasil == "Tidak Lulus" || $hasil == "" ) {
    $ustatus = mysqli_query($conn, "UPDATE mahasiswa
                LEFT JOIN pkl ON mahasiswa.nim=pkl.nim
                LEFT JOIN pkl_sidang ps ON pkl.id_pkl=ps.id_pkl  
                SET mahasiswa.status_pkl ='-'
                WHERE ps.id_sidpkl='$id'");
    $usid = mysqli_query($conn, "UPDATE pkl_sidang SET status_sid='Tidak Lulus' 
                                  WHERE id_sidpkl='$id'");
    $unilai = mysqli_query($conn, "UPDATE pkl_nilai SET
                      pem_pen_mat='0', pem_peng_mat='0',
                      pem_sis='0', peng_pen_mat='0', peng_peng_mat='0', peng_sis='0'
                      WHERE id_sidang='$id'");
      if ($unilai && $usid && $ustatus) {
        echo "<script>
      alert('Nilai Berhasil diubah !')
      windows.location.href=('detailsidangdraft.php')
      </script>";
      }else {
      echo "<script>
      alert('Nilai gagal diubah123 !')
      windows.location.href=('detailsidangdraft.php')
      </script>";
      }
  }else{
  $sql = mysqli_query($conn, "UPDATE pkl_nilai SET pem_pen_mat='$p11', pem_peng_mat='$p22',
                      pem_sis='$sis2', peng_pen_mat='$p1', peng_peng_mat='$p2', peng_sis='$sis1'
                      WHERE id_sidang='$id'");
  $sql2 = mysqli_query($conn, "UPDATE pkl_sidang SET status_sid='$hasil' WHERE id_sidpkl='$id'");
  if ($sql && $sql2) {
echo "<script>
alert('Nilai Berhasil Diubah')
windows.location.href('datasidang.php')
</script>";
  }else {
    echo "<script>
alert('Nilai Gagal Diubah')
windows.location.href('datasidang.php')
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
  <title>Detail Sidang PKL | SIM-PS | Tata Usaha</title>
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
              <a href="detailsidang.php" class="btn btn-warning">Kembali</a>
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
                  <img src="../../assets/foto/<?= $data1["fotomhs"]?>" alt="foto mahasiswa" width="130px"
                    height="130px">
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
                <?php $jml = mysqli_num_rows($getdataa) ?>
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
              <h3 class="m-0 text-dark">Data Sidang PKL,
                <?=$data1["nama"] ?></h3>
            </center>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead align="center">
                <tr>
                  <th width="10px">No</th>
                  <th width="180px">Penguji</th>
                  <th width="100px">Waktu</th>
                  <th width="50px">Ruang</th>
                  <th width="50px">Hasil</th>
                  <th width="50px">Aksi</th>
                  <th width="50px">Nilai</th>
                </tr>
              </thead>
              <tbody>
                <?php
                        $no=1;
                        if (mysqli_num_rows($getdata) > 0) {
                        while ($data=mysqli_fetch_array($getdata)) {
                          $tanggal = $data["tanggal"];
                          $tgl = date('d-M-Y', strtotime($tanggal));
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
                          }elseif ($dataq == '' OR $dataq == 0) {
                            $grade = '';
                          }
                        ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $data['penguji'] ?></td>
                  <td align="center"><?= $tgl ?><br><?= $data['waktu'] ?></td>
                  <td align="center"><?= $data['ruang'] ?></td>
                  <td><?= $data['hasil'] ?></td>
                  <td align="center">
                    <button class="btn-xs btn-warning" id="ubah" data-toggle="modal" data-target="#modalubah"
                      data-id="<?= $data["id"]?>" data-ruang="<?= $data["ruang"]?>"
                      data-tanggal="<?= $data["tanggal"]?>" data-waktu="<?= $data["waktu"]?>"
                      data-penguji="<?= $data["penguji"]?>" data-status="<?= $data["hasil"]?>"
                      data-idpkl="<?= $data["id_pkl"]?>">
                      <i class="fas fa-edit"></i></button>
                  </td>
                  <td align="center"> <button class="btn-xs btn-danger" data-toggle="modal" data-target="#modalnilai1"
                      id="nilai1" data-id="<?php echo $data["id"] ?>" data-p1="<?php echo $data["p1"] ?>"
                      data-p2="<?php echo $data["p2"] ?>" data-sis="<?php echo $data["sis"] ?>"
                      data-p11="<?php echo $data["p11"] ?>" data-p22="<?php echo $data["p22"] ?>"
                      data-sis1="<?php echo $data["sis1"] ?>" data-status="<?php echo $data["hasil"] ?>"
                      data-total="<?php echo $data["total"] ?>" data-grade="<?php echo $grade ?>">
                      <i class="fas fa-info-circle"></i></button></td>
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
                <h4 class="modal-title">Form Ubah Sidang Praktik Kerja Lapangan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="form-horizontal" method="post">
                  <div class="card-body">
                    <div class="form-group row">
                      <div class="col-sm-9">
                        <input type="text" name="id" id="id" class="form form-control" hidden readonly>
                        <input type="text" name="idpkl" id="idpkl" class="form form-control" hidden readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="penguji" class="col-sm-3 col-form-label">Nama Penguji</label>
                      <div class="col-sm-9">
                        <select class="form-control" name="penguji" id="penguji" required="required">
                          <option value="">Pilih Penguji...</option>
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
                    </div>
                    <div class="form-group row">
                      <label for="tanggal" class="col-sm-3 col-form-label">Tanggal Sidang</label>
                      <div class="col-sm-9">
                        <input type="date" name="tanggal" id="tanggal" class="form form-control">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="waktu" class="col-sm-3 col-form-label">Waktu Sidang</label>
                      <div class="col-sm-9">
                        <input type="time" name="waktu" id="waktu" class="form form-control">
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
                          <option value="TidakLulus">Tidak Lulus</option>
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

        <!-- modal tambah bimbingan -->
        <div class="modal fade" id="modalnilai1">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Nilai Sidang PKL</h4>
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
                      <div class="form-group col-md-6">
                        <label for="npm1">Nilai Penyampaian Materi Penguji</label>
                        <input type="number" class="form-control" id="npm1" name="npm1" max="100" min="0">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="npm11">Nilai Penyampaian Materi Pembimbing</label>
                        <input type="number" class="form-control" id="npm11" name="npm11" max="100" min="0">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="npm2">Nilai Penguasaan Penguji</label>
                        <input type="number" class="form-control" id="npm2" name="npm2" max="100" min="0">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="npm22">Nilai Penguasaan Materi Pembimbing</label>
                        <input type="number" class="form-control" id="npm22" name="npm22" max="100" min="0">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="sistematika">Nilai Sistematika Penulisan Penguji</label>
                        <input type="number" class="form-control" id="sistematika" name="sistematika" max="100" min="0">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="sistematika1">Nilai Sitematika Penulisan Pembimbing</label>
                        <input type="number" class="form-control" id="sistematika1" name="sistematika1" max="100"
                          min="0">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="hasilsidang">Hasil Sidang</label>
                        <select name="hasilsidang" id="hasilsidang" class="form-control">
                          <option disabled selected>Pilih Hasil Sidang</option>
                          <option value="Lulus">Lulus</option>
                          <option value="Tidak Lulus">Tidak Lulus</option>
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
                      <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="ubah" id="ubah">Ubah
                        Data</button>
                    </div>
                    <!-- /.card-body -->
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
    let penguji = $(this).data('penguji');
    let idpkl = $(this).data('idpkl');
    let tanggal = $(this).data('tanggal');
    let ruang = $(this).data('ruang');
    let waktu = $(this).data('waktu');
    let status = $(this).data('status');
    $("#modalubah #status").val(status);
    $("#modalubah #id").val(id);
    $("#modalubah #idpkl").val(idpkl);
    $("#modalubah #penguji ").val(penguji);
    $("#modalubah #waktu").val(waktu);
    $("#modalubah #ruang").val(ruang);
    $("#modalubah #tanggal").val(tanggal);
  });

  /// detail data
  $(document).on("click", "#nilai1", function () {
    let d = $(this).data('id');
    let p1 = $(this).data('p1');
    let p2 = $(this).data('p2');
    let p11 = $(this).data('p11');
    let p22 = $(this).data('p22');
    let sis = $(this).data('sis');
    let sis1 = $(this).data('sis1');
    let hasil = $(this).data('status');
    let total = $(this).data('total');
    let grade = $(this).data('grade');
    $("#modalnilai1 #id").val(d);
    $("#modalnilai1 #npm1").val(p1);
    $("#modalnilai1 #npm2").val(p2);
    $("#modalnilai1 #npm11").val(p11);
    $("#modalnilai1 #npm22").val(p22);
    $("#modalnilai1 #sistematika").val(sis);
    $("#modalnilai1 #sistematika1").val(sis1);
    $("#modalnilai1 #hasilsidang").val(hasil);
    $("#modalnilai1 #total").val(total);
    $("#modalnilai1 #grade").val(grade);
  });
</script>
</body>

</html>