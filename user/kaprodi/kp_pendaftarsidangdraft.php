<?php
session_start();
require "../../koneksi.php";
if (!isset($_SESSION["login_kaprodi"])) {
header("location:../../index.php");
exit();
}
?>

<!-- jadwalkan sidang -->
<?php
if (isset($_POST["jadwalkan"])) {
$id_skripsi = $_POST["id_skripsi"];
$id=$_POST["id_sidang"]; 
$penguji1=$_POST["penguji1"];
$penguji2=$_POST["penguji2"];
$tgl=$_POST["tgl_sid"];
$waktu=$_POST["waktu"];
$ruang=$_POST["ruang_sid"];
$p1 = 'Penguji 1';
$p2 = 'Penguji 2';
if ($penguji1==$penguji2) {
  echo "<script>
  alert('Penguji 1 dan 2 Tidak Boleh Sama')
  windows.location.href('kp_pendaftarsidangdraft.php') 
  </script>";
}else{ 
$cekjadwal = mysqli_query($conn, "SELECT tgl_sidang, waktu_sidang, ruang_sidang 
                          FROM draft_sidang WHERE tgl_sidang='$tgl' AND waktu_sidang='$waktu' 
                          AND ruang_sidang='$ruang' AND status_sidang IS NULL");
$cekpenguji = mysqli_query($conn, "SELECT penguji, tgl_sidang, waktu_sidang, ruang_sidang 
                          FROM draft_sidang ds LEFT JOIN draft_penguji dp
                          ON ds.id_sidang=dp.id_sidang
                          WHERE (dp.penguji='$penguji1' OR dp.penguji='$penguji2')
                          AND tgl_sidang='$tgl' AND waktu_sidang='$waktu' AND status_sidang IS NULL");
$cekpem = mysqli_query($conn, "SELECT 
                      (SELECT d1.nidn FROM dosen d1 LEFT JOIN skripsi_dosbing sd
                      ON d1.nidn=sd.nidn
                      WHERE id_skripsi='$id_skripsi' AND sd.status_dosbing='Pembimbing 1' AND sd.status='Aktif' LIMIT 0,1) AS pem1,
                      (SELECT d1.nidn FROM dosen d1 LEFT JOIN skripsi_dosbing sd
                      ON d1.nidn=sd.nidn
                      WHERE id_skripsi='$id_skripsi' AND sd.status_dosbing='Pembimbing 2' AND sd.status='Aktif' LIMIT 0,1) AS pem2
                      ");
$q = mysqli_fetch_array($cekpem);
$qa1 = $q["pem1"];
$qa2 = $q["pem2"];
if ($penguji1==$qa1 || $penguji2==$qa1 || $penguji1==$qa2 || $penguji2==$qa2) {
  echo "<script>
alert('Penguji sidang tidak boleh sama dengan pembimbing skripsi mahasiswa')
windows.location.href('kp_pendaftarsidangdraft.php')
</script>";
}else{
if (mysqli_num_rows($cekjadwal)>0 OR mysqli_num_rows($cekpenguji)>0) {
echo "<script>
alert('Gagal Menjadwalkan Sidang, Terdapat jadwal dan atau penguji yang sama dalam satuw waktu')
windows.location.href('kp_pendaftarsidangdraft.php')
</script>";
}else{
mysqli_autocommit($conn, FALSE);
$sqljadwal = mysqli_query($conn, "UPDATE draft_sidang SET
                          tgl_sidang='$tgl',
                          waktu_sidang='$waktu',
                          ruang_sidang='$ruang'
                          WHERE id_sidang='$id'") 
                          or die (mysqli_erorr($conn));

// masukan ke tbl proposal_penguji untuk penguji 1
$sqlpenguji1 = mysqli_query($conn, "INSERT INTO draft_penguji (id_sidang, penguji, status_penguji) VALUES ('$id', '$penguji1', '$p1' )") or die (mysqli_erorr($conn));
// masukan ke tbl_proposal_penguji untuk penguji 2
$sqlpenguji2 = mysqli_query($conn, "INSERT INTO draft_penguji (id_sidang, penguji, status_penguji) VALUES ('$id', '$penguji2', '$p2' )") or die (mysqli_erorr($conn));

$sqlnilai = mysqli_query($conn, "INSERT INTO draft_nilai (id_sidang) VALUES ('$id')");

if ($sqljadwal && $sqlpenguji1 && $sqlpenguji2 && $sqlnilai) {
mysqli_commit($conn);
echo "<script>
alert('Berhasil Menjadwalan Sidang')
windows.location.href('kp_pendaftarsidangdraft.php')
</script>";
}else {
mysqli_rollback($conn);
echo "<script>
alert('Gagal Menjadwalkan Sidang')
windows.location.href('kp_pendaftarsidangdraft.php')
</script>";
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
  <title>Penjadwalan Sidang Draft | SIM-PS | Kaprodi</title>
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
          <!-- <h1 class="m-0 text-dark">Data Pendaftaran Sidang Draft</h1> -->
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
              <h1 class="m-0 text-dark">Penjadwalan Sidang Draft</h1>
            </center>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead align="center">
                <tr>
                  <th width="250px">Nama</th>
                  <th width="300px">Judul</th>
                  <th width="300px">Pembimbing 1</th>
                  <th width="300px">Pembimbing 2</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                         // ambil data penguji
                        $datasidang = mysqli_query($conn,
                        "SELECT mhs.nama,
                          judul.judul, sidang.id_sidang As id,
                          sidang.tgl_sidang AS tgl, sidang.ruang_sidang As ruang,
                          (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd 
                          ON d1.nidn=sd.nidn 
                          WHERE sd.id_skripsi=s.id_skripsi LIMIT 0,1) AS pem1, 
                          (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN skripsi_dosbing sd
                          ON d2.nidn=sd.nidn 
                          WHERE sd.id_skripsi=s.id_skripsi LIMIT 1,1) as pem2,
                          s.id_skripsi
                          FROM draft_sidang sidang 
                          LEFT JOIN skripsi s
                          ON sidang.id_skripsi=s.id_skripsi
                          LEFT JOIN proposal p
                          ON s.id_proposal=p.id_proposal
                          LEFT JOIN judul 
                          ON p.id_judul=judul.id_judul
                          LEFT JOIN mahasiswa mhs
                          ON judul.nim=mhs.nim
                          LEFT JOIN draft_penguji penguji
                          ON sidang.id_sidang=penguji.id_sidang
                          LEFT JOIN draft_sidang_syarat dss
                          ON sidang.id_sidang=dss.id_sidang
                          WHERE dss.status='2' 
                          AND penguji.penguji IS NULL
                          AND sidang.status_sidang IS NULL") or die (mysqli_error($conn));
                        if (mysqli_num_rows($datasidang) > 0) {
                        while ($data1=mysqli_fetch_array($datasidang) ) {
                        ?>
                <!-- tampilkan data -->
                <tr>
                  <td><?php echo $data1["nama"] ?></td>
                  <td><?php echo $data1["judul"] ?></td>
                  <td><?php echo $data1["pem1"] ?></td>
                  <td><?php echo $data1["pem2"] ?></td>
                  <td>
                    <button type="submit" id="detaildata" class="btn btn-warning" data-toggle="modal"
                      data-target="#modal-lg" data-id="<?php echo $data1["id"] ?>"
                      data-idskripsi="<?php echo $data1["id_skripsi"] ?>" data-nama="<?php echo $data1["nama"] ?>"
                      data-judul="<?php echo $data1["judul"] ?>" data-dosbing1="<?php echo $data1["pem1"] ?>"
                      data-dosbing2="<?php echo $data1["pem2"] ?>" data-tgl="<?php echo $data1["tgl"] ?>"
                      data-penguji1="<?php echo $data1["penguji1"] ?>" data-penguji2="<?php echo $data1["penguji2"] ?>"
                      data-ruang="<?php echo $data1["ruang"] ?>"><i class="fas fa-cogs"></i></button>
                  </td>
                </tr>
                <?php  }
                        }
                        ?>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->

          <!-- modal tambah bimbingan -->
          <div class="modal fade" id="modal-lg">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Penjadwalan Sidang Draft</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form class="form-horizontal" method="post">
                    <div class="card-body">
                      <div class="form-group row">
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="id_sidang" name="id_sidang" required="required"
                            readonly hidden>
                          <input type="text" class="form-control" id="id_skripsi" name="id_skripsi" required="required"
                            readonly hidden>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="nama" name="nama" required="required" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="judul_laporan" class="col-sm-3 col-form-label">Judul</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="judul_laporan" name="judul_laporan"
                            required="required" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="id_dosenwali1" class="col-sm-3 col-form-label">Pembimbing1</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="id_dosenwali1" name="id_dosenwali1"
                            required="required" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="id_dosenwali2" class="col-sm-3 col-form-label">Pembimbing2</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="id_dosenwali2" name="id_dosenwali2"
                            required="required" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="tgl_sid" class="col-sm-3 col-form-label">Tanggal Sidang</label>
                        <div class="col-sm-9">
                          <input type="date" class="form-control" id="tgl_sid" name="tgl_sid" required="required">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="waktu" class="col-sm-3 col-form-label">Waktu</label>
                        <div class="col-sm-9">
                          <input type="time" class="form-control" id="waktu" name="waktu" required="required">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="penguji1" class="col-sm-3 col-form-label">Pilih Penguji 1</label>
                        <div class="col-sm-9">
                          <select class="form-control" name="penguji1" id="penguji1" required="required">
                            <option value="">Pilih Penguji...</option>
                            <?php
                                    //ambil data dosen
                                    $sql = mysqli_query($conn, "SELECT * FROM dosen WHERE jabatan IS NOT NULL OR jabatan=''") or die (mysqli_erorr($conn));
                                    while ($dosen1 = mysqli_fetch_array($sql)) {
                                    ?>
                            <option value="<?=$dosen1["nidn"]?>"><?=$dosen1["nama_dosen"]?>
                            </option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="penguji2" class="col-sm-3 col-form-label">Pilih Penguji 2</label>
                        <div class="col-sm-9">
                          <select class="form-control" name="penguji2" id="penguji2" required="required">
                            <option value="">Pilih Penguji...</option>
                            <?php
                                    //ambil data dosen
                                    $sql = mysqli_query($conn, "SELECT * FROM dosen WHERE jabatan IS NOT NULL OR jabatan=''") or die (mysqli_erorr($conn));
                                    while ($dosen1 = mysqli_fetch_array($sql)) {
                                    ?>
                            <option value="<?=$dosen1["nidn"]?>"><?=$dosen1["nama_dosen"]?>
                            </option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="ruang_sid" class="col-sm-3 col-form-label">Ruang Sidang</label>
                        <div class="col-sm-9">
                          <select class="form-control" name="ruang_sid" id="ruang_sid" required="required">
                            <option value="">Pilih</option>
                            <option value="Lab Informatika">Laboratorium Informatika</option>
                            <option value="Lab Peternakan">Laboratorium Peternakan</option>
                            <option value="Perpustakaan">Perpustakaan</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="jadwalkan"
                    id="jadwalkan">Jadwalkan</button>
                </div>
              </div>
              </form>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- /.modal -->
          <!-- modal tambah bimbingan -->

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
  // detail data mhs
  $(document).on("click", "#detaildata", function () {
    let id = $(this).data('id');
    let idskripsi = $(this).data('idskripsi');
    let nama = $(this).data('nama');
    let judul = $(this).data('judul');
    let dosbing1 = $(this).data('dosbing1');
    let dosbing2 = $(this).data('dosbing2');
    let tgl = $(this).data('tgl');
    let ruang = $(this).data('ruang');
    $(".modal-body #id_sidang").val(id);
    $(".modal-body #id_skripsi").val(idskripsi);
    $(".modal-body #nama").val(nama);
    $(".modal-body #judul_laporan").val(judul);
    $(".modal-body #id_dosenwali1").val(dosbing1);
    $(".modal-body #id_dosenwali2").val(dosbing2);
    $(".modal-body #tgl_sid").val(tgl);
    $(".modal-body #ruangsid").val(ruang);
  });
</script>
</body>

</html>