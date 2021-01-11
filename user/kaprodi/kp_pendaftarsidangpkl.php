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
$idpkl =$_POST["idpkl"];
$id=$_POST["id_sidpkl"];
$penguji=$_POST["penguji"];
$tgl=$_POST["tgl_sid"]; 
$waktu=$_POST["waktu"];
$ruang=$_POST["ruang_sid"];
$cekjadwal = mysqli_query($conn, "SELECT tgl_sid, waktu, ruang_sid FROM pkl_sidang 
                          WHERE tgl_sid='$tgl' AND waktu='$waktu' AND ruang_sid='$ruang'
                          AND status_sid IS NULL");
$cekpenguji = mysqli_query($conn, "SELECT penguji, tgl_sid, waktu, ruang_sid FROM pkl_sidang 
                            WHERE penguji='$penguji' AND tgl_sid='$tgl' AND waktu='$waktu'
                            AND status_sid IS NULL");
$cekpem = mysqli_query($conn, "SELECT d1.nidn FROM dosen d1 LEFT JOIN dosen_wali dw
                      ON d1.nidn=dw.nidn LEFT JOIN pkl p ON dw.id_dosenwali=p.id_dosenwali
                      WHERE id_pkl='$idpkl'");
$q = mysqli_fetch_array($cekpem);
$qa = $q["nidn"];
if ($penguji==$qa) {
  echo "<script>
alert('Penguji sidang tidak boleh sama dengan pembimbing')
windows.location.href('kp_pendaftarsidangpkl.php')
</script>";
}else{
if (mysqli_num_rows($cekjadwal)>0 OR mysqli_num_rows($cekpenguji)>0) {
echo "<script>
alert('Gagal Menjadwalkan Sidang, Terdapat jadwal dan atau penguji yang sama dalam satuw waktu')
windows.location.href('kp_pendaftarsidangpkl.php')
</script>";
}else{
$sqljadwal = mysqli_query($conn, "UPDATE pkl_sidang SET
penguji='$penguji',  
tgl_sid='$tgl',
waktu='$waktu',
ruang_sid='$ruang' WHERE id_sidpkl='$id'") or die (mysqli_erorr($conn));
$sqlnilai = mysqli_query($conn, "INSERT INTO pkl_nilai (id_sidang) VALUES('$id')");
if ($sqljadwal && $sqlnilai) {
echo "<script>
alert('Berhasil Menjadwalan Sidang')
windows.location.href('kp_pendaftarsidangpkl.php')
</script>";
}else {
echo "<script>
alert('Gagal Menjadwalkan Sidang')
windows.location.href('kp_pendaftarsidangpkl.php')
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
  <title>Penjadwalan Sidang PKL | SIM-PS | Kaprodi</title>
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
              <h1 class="m-0 text-dark">Penjadwalan Sidang PKL</h1>
            </center>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead align="center">
                <tr>
                  <th width="180px">Nama</th>
                  <th width="180px">Judul</th>
                  <th width="180px">Pembimbing</th>
                  <th width="50px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                        //ambi data pendaftar
                        $datasidang = mysqli_query($conn,
                        "SELECT pkl_sidang.id_sidpkl,
                        mahasiswa.nama,
                        pkl.judul_laporan, pkl.id_pkl,
                        pkl.id_dosenwali,
                        dosen.nama_dosen,
                        pkl_sidang.tgl_sid,
                        pkl_sidang.penguji,
                        pkl_sidang.ruang_sid, pkl_sidang.waktu
                        FROM dosen JOIN dosen_wali
                        ON dosen.nidn=dosen_wali.nidn
                        JOIN pkl ON dosen_wali.id_dosenwali=pkl.id_dosenwali
                        JOIN pkl_sidang ON pkl.id_pkl=pkl_sidang.id_pkl
                        JOIN mahasiswa ON pkl.nim=mahasiswa.nim 
                        JOIN pkl_syarat_sidang pss ON pkl_sidang.id_sidPKL=pss.id_sidang
                        WHERE pkl_sidang.val_dosbing ='2' AND pss.status='2'
                        AND pkl_sidang.penguji IS NULL AND pkl_sidang.status_sid IS NULL")
                        or die (mysqli_erorr($conn));
                        while ($data1=mysqli_fetch_array($datasidang) ) {
                        ?>
                <!-- tampilkan data -->
                <tr>
                  <td><?php echo $data1["nama"] ?></td>
                  <td><?php echo $data1["judul_laporan"] ?></td>
                  <td><?php echo $data1["nama_dosen"] ?></td>
                  <td align="center">
                    <button type="submit" id="detaildata" class="btn btn-warning" data-toggle="modal"
                      data-target="#modal-lg" data-id="<?php echo $data1["id_sidpkl"] ?>"
                      data-idpkl="<?php echo $data1["id_pkl"] ?>" data-nama="<?php echo $data1["nama"] ?>"
                      data-judul="<?php echo $data1["judul_laporan"] ?>"
                      data-dosbing="<?php echo $data1["nama_dosen"] ?>" data-tgl="<?php echo $data1["tgl_sid"] ?>"
                      data-penguji="<?php echo $data1["penguji"] ?>" data-ruang="<?php echo $data1["ruang_sid"] ?>"><i
                        class="fas fa-cogs"></i></button>
                  </td>
                </tr>
                <?php  }
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
                  <h4 class="modal-title">Penjadwalan Sidang Praktik Kerja Lapangan</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form class="form-horizontal" method="post">
                    <div class="card-body">
                      <div class="form-group row">
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="id_sidpkl" name="id_sidpkl" required="required"
                            hidden readonly>
                          <input type="text" class="form-control" id="idpkl" name="idpkl" required="required" hidden
                            readonly>
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
                        <label for="id_dosenwali" class="col-sm-3 col-form-label">Pembimbing</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="id_dosenwali" name="id_dosenwali"
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
                        <label for="penguji" class="col-sm-3 col-form-label">Pilih Penguji</label>
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
    let nama = $(this).data('nama');
    let judul = $(this).data('judul');
    let dosbing = $(this).data('dosbing');
    let tgl = $(this).data('tgl');
    let ruang = $(this).data('ruang');
    let idpkl = $(this).data('idpkl');
    $(".modal-body #id_sidpkl").val(id);
    $(".modal-body #nama").val(nama);
    $(".modal-body #judul_laporan").val(judul);
    $(".modal-body #id_dosenwali").val(dosbing);
    $(".modal-body #tgl_sid").val(tgl);
    $(".modal-body #ruangsid").val(ruang);
    $(".modal-body #idpkl").val(idpkl);
  });
</script>
</body>

</html>