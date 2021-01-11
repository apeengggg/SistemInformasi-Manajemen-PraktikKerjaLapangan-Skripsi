<?php
// error_reporting(0);
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
$id=$_POST["id_sidpkl"];
$val = $_POST["valdosbing"];
$pesan = $_POST["pesan"];
$sqljadwal = mysqli_query($conn, "UPDATE pkl_sidang SET
val_dosbing='$val',
pesan='$pesan'
WHERE id_sidpkl='$id'") or die (mysqli_erorr($conn)); 
if ($sqljadwal AND $val!='' AND $pesan!='') {
echo "<script>
alert('Berhasil Memvalidasi Pendaftaran Sidang Mahasiswa')
windows.location.href('kp_validasisidpkl.php')
</script>";
}else {
echo "<script>
alert('Gagal Memvalidasi Pendaftaran Sidang PKL')
windows.location.href('kp_validasisidpkl.php')
</script>";
}
}
 
if (isset($_POST["jadwalkan1"])) {
$id=$_POST["id_sidpkl"];
$val = $_POST["valdosbing"];
$pesan = $_POST["pesan"];
$cs = mysqli_query($conn, "SELECT status_sid FROM pkl_sidang WHERE id_sidpkl='$id' AND (status_sid='Lulus' OR status_sid='Tidak Lulus')");
if (mysqli_num_rows($cs)===1) {
echo "<script>
alert('Sidang Sudah Dilakukan, Tidak Dapat Mengubah Validasi')
windows.location.href('kp_validasisidpkl.php')
</script>";
}else{
$sqljadwal = mysqli_query($conn, "UPDATE pkl_sidang SET
val_dosbing='$val',
pesan='$pesan'
WHERE id_sidpkl='$id'") or die (mysqli_erorr($conn)); 
if ($sqljadwal AND $val!='' AND $pesan!='') {
echo "<script>
alert('Berhasil Mengubah Memvalidasi Pendaftaran Sidang Mahasiswa')
windows.location.href('kp_validasisidpkl.php')
</script>";
}else {
echo "<script>
alert('Gagal Mengubah Memvalidasi Pendaftaran Sidang PKL')
windows.location.href('kp_validasisidpkl.php')
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
  <title>Validasi Pendaftaran Sidang PKL | SIM-PS | Kaprodi</title>
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
              <h2 class="m-0 text-dark">Data Pendaftaran Sidang PKL Mahasiswa Bimbingan</h2>
            </center>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead align="center">
                <tr>
                  <th width="80px">NIM</th>
                  <th width="180px">Nama</th>
                  <th width="200px">Judul</th>
                  <th width="200px">Pembimbing</th>
                  <th width="50px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                        //ambi data pendaftar
                        $datasidang = mysqli_query($conn,
                        "SELECT m.nama, m.nim, p.judul_laporan, d.nama_dosen, ps.id_sidpkl
                        FROM pkl_sidang ps LEFT JOIN pkl p
                        ON ps.id_pkl=p.id_pkl 
                        LEFT JOIN mahasiswa m
                        ON p.nim=m.nim
                        LEFT JOIN dosen_wali dw
                        ON p.id_dosenwali=dw.id_dosenwali
                        LEFT JOIN dosen d
                        ON dw.nidn=d.nidn
                        WHERE d.nidn='$nidn' AND ps.val_dosbing='0'")
                        or die (mysqli_erorr($conn));
                        while ($data1=mysqli_fetch_array($datasidang) ) {
                        ?>
                <!-- tampilkan data -->
                <tr>
                  <td><?php echo $data1["nim"] ?></td>
                  <td><?php echo $data1["nama"] ?></td>
                  <td><?php echo $data1["judul_laporan"] ?></td>
                  <td><?php echo $data1["nama_dosen"] ?></td>
                  <td align="center">
                    <button type="submit" id="detaildata" class="btn btn-warning" data-toggle="modal"
                      data-target="#modal-lg" data-id="<?php echo $data1["id_sidpkl"] ?>"
                      data-nama="<?php echo $data1["nama"] ?>" data-judul="<?php echo $data1["judul_laporan"] ?>"
                      data-dosbing="<?php echo $data1["nama_dosen"] ?>"><i class="fas fa-cogs"></i></button>
                  </td>
                </tr>
                <?php  }
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

  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <center>
              <h2 class="m-0 text-dark">Riwayat Validasi Pendaftaran Sidang</h2>
            </center>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example3" class="table table-bordered table-striped">
              <thead align="center">
                <tr>
                  <th width="80px">NIM</th>
                  <th width="180px">Nama</th>
                  <th width="200px">Judul</th>
                  <th width="200px">Pembimbing</th>
                  <th width="80px">Validasi</th>
                  <th width="50px">Ubah</th>
                </tr>
              </thead>
              <tbody>
                <?php
                        //ambi data pendaftar
                        $datasidang1 = mysqli_query($conn,
                        "SELECT m.nama, m.nim, p.judul_laporan, d.nama_dosen, ps.id_sidpkl,
                        ps.val_dosbing
                        FROM pkl_sidang ps LEFT JOIN pkl p
                        ON ps.id_pkl=p.id_pkl 
                        LEFT JOIN mahasiswa m
                        ON p.nim=m.nim
                        LEFT JOIN dosen_wali dw
                        ON p.id_dosenwali=dw.id_dosenwali
                        LEFT JOIN dosen d
                        ON dw.nidn=d.nidn
                        WHERE d.nidn='$nidn' AND (ps.val_dosbing='1' OR ps.val_dosbing='2' )")
                        or die (mysqli_erorr($conn));
                        while ($data2=mysqli_fetch_array($datasidang1) ) {
                        $status = $data2["val_dosbing"];
                        if ($status=='1') {
                          
                        }
                        ?>
                <!-- tampilkan data -->
                <tr>
                  <td><?php echo $data2["nim"] ?></td>
                  <td><?php echo $data2["nama"] ?></td>
                  <td><?php echo $data2["judul_laporan"] ?></td>
                  <td><?php echo $data2["nama_dosen"] ?></td>
                  <td align="center">
                    <?php
                            if ($data2["val_dosbing"]=="1") {
                              $status = "Ditolak";
                            ?>
                    <span class="badge badge-danger">
                      <?php } else if ($data2["val_dosbing"]=="2"){
                                $status = "Disetujui";
                              ?>
                      <span class="badge badge-success">
                        <?php }?>
                        <?= $status ?>
                  </td>
                  <td align="center">
                    <button type="submit" id="detaildata1" class="btn btn-warning" data-toggle="modal"
                      data-target="#modal-lg1" data-id="<?php echo $data2["id_sidpkl"] ?>"
                      data-nama="<?php echo $data2["nama"] ?>" data-judul="<?php echo $data2["judul_laporan"] ?>"
                      data-dosbing="<?php echo $data2["nama_dosen"] ?>" data-status="<?php echo $status ?>"><i
                        class="fas fa-edit"></i></button>
                  </td>
                </tr>
                <?php  }
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
          <h4 class="modal-title">Validasi Pendaftaran Sidang PKL</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" method="post">
            <div class="card-body">
              <div class="form-group row">
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="id_sidpkl" name="id_sidpkl" required="required" hidden
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
                  <input type="text" class="form-control" id="judul_laporan" name="judul_laporan" required="required"
                    readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="id_dosenwali" class="col-sm-3 col-form-label">Pembimbing</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="id_dosenwali" name="id_dosenwali" required="required"
                    readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="valdosbing" class="col-sm-3 col-form-label">Validasi</label>
                <div class="col-sm-9">
                  <select name="valdosbing" id="valdosbing" class="form-control" required>
                    <option value="">Pilih Validasi...</option>
                    <option value="2">Setuju</option>
                    <option value="1">Tolak</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="pesan" class="col-sm-3 col-form-label">Pesan Validasi</label>
                <div class="col-sm-9">
                  <textarea name="pesan" id="pesan" cols="30" rows="2" class="form-control" required></textarea>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="jadwalkan"
            id="jadwalkan">Validasi</button>
        </div>
      </div>
      </form>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  <!-- modal tambah bimbingan -->

  <!-- modal ubah validasi -->
  <div class="modal fade" id="modal-lg1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Ubah Validasi Pendaftaran Sidang PKL</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" method="post">
            <div class="card-body">
              <div class="form-group row">
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="id_sidpkl" name="id_sidpkl" required="required" hidden
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
                  <input type="text" class="form-control" id="judul_laporan" name="judul_laporan" required="required"
                    readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="id_dosenwali" class="col-sm-3 col-form-label">Pembimbing</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="id_dosenwali" name="id_dosenwali" required="required"
                    readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="validasi" class="col-sm-3 col-form-label">Status Validasi</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="validasi" name="validasi" required="required" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="valdosbing" class="col-sm-3 col-form-label">Validasi Ulang</label>
                <div class="col-sm-9">
                  <select name="valdosbing" id="valdosbing" class="form-control" required>
                    <option value="">Pilih Validasi...</option>
                    <option value="2">Setuju</option>
                    <option value="1">Tolak</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="pesan" class="col-sm-3 col-form-label">Pesan Validasi</label>
                <div class="col-sm-9">
                  <textarea name="pesan" id="pesan" cols="30" rows="2" class="form-control" required></textarea>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="jadwalkan1" id="jadwalkan1">Ubah
            Validasi</button>
        </div>
      </div>
      </form>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  <!-- modal ubah validasi -->
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
    $("#modal-lg #id_sidpkl").val(id);
    $("#modal-lg #nama").val(nama);
    $("#modal-lg #judul_laporan").val(judul);
    $("#modal-lg #id_dosenwali").val(dosbing);
    $("#modal-lg #tgl_sid").val(tgl);
    $("#modal-lg #ruangsid").val(ruang);
  });

  // detail data mhs
  $(document).on("click", "#detaildata1", function () {
    let id = $(this).data('id');
    let nama = $(this).data('nama');
    let judul = $(this).data('judul');
    let dosbing = $(this).data('dosbing');
    let tgl = $(this).data('tgl');
    let ruang = $(this).data('ruang');
    let status = $(this).data('status');
    $("#modal-lg1 #id_sidpkl").val(id);
    $("#modal-lg1 #nama").val(nama);
    $("#modal-lg1 #judul_laporan").val(judul);
    $("#modal-lg1 #id_dosenwali").val(dosbing);
    $("#modal-lg1 #tgl_sid").val(tgl);
    $("#modal-lg1 #ruangsid").val(ruang);
    $("#modal-lg1 #validasi").val(status);
  });
</script>
</body>

</html>