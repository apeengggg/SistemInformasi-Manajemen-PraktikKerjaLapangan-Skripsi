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
$id=$_POST["id_sidang"];
$val = $_POST["valdosbing"];
$pesan = $_POST["pesan"];
$sqljadwal = mysqli_query($conn, "UPDATE proposal_sidang SET
val_dosbing='$val',
pesan='$pesan'
WHERE id_sidang='$id'") or die (mysqli_erorr($conn));
if ($sqljadwal AND $val!='' AND $pesan!='') {
echo "<script>
alert('Berhasil Memvalidasi Pendaftaran Sidang Mahasiswa')
windows.location.href('kp_validasisidprop.php')
</script>";
}else {
echo "<script>
alert('Gagal Memvalidasi Pendaftaran Sidang PKL')
windows.location.href('kp_validasisidprop.php')
</script>";
}
}

if (isset($_POST["jadwalkan1"])) {
$id=$_POST["id_sidang"];
$val = $_POST["valdosbing"];
$pesan = $_POST["pesan"];
$cs = mysqli_query($conn, "SELECT status_sidang FROM proposal_sidang WHERE id_sidang='$id' AND (status_sidang='Lulus' OR status_sidang='Tidak Lulus')");
if (mysqli_num_rows($cs)===1) {
echo "<script>
alert('Sidang Sudah Dilakukan, Tidak Dapat Mengubah Validasi')
windows.location.href('kp_validasisidpkl.php')
</script>";
}else{
$sqljadwal = mysqli_query($conn, "UPDATE proposal_sidang SET
val_dosbing='$val',
pesan='$pesan'
WHERE id_sidang='$id'") or die (mysqli_erorr($conn)); 
if ($sqljadwal AND $val!='' AND $pesan!='') {
echo "<script>
alert('Berhasil Mengubah validasi Pendaftaran Sidang Mahasiswa')
windows.location.href('kp_validasisidpkl.php')
</script>";
}else {
echo "<script>
alert('Gagal Mengubah validasi Pendaftaran Sidang PKL')
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
  <title>Validasi Pendaftar Sidang Proposal | SIM-PS | Kaprodi</title>
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
          <!-- <h1 class="m-0 text-dark">Data Pendaftaran Sidang Proposal</h1> -->
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
              <h2 class="m-0 text-dark">Data Pendaftaran Sidang Proposal Mahasiswa Bimbingan</h2>
            </center>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="180px">Nama</th>
                  <th width="250px">Judul</th>
                  <th width="200px">Pembimbing</th>
                  <th width="50px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                         // ambil data penguji
                        $datasidang = mysqli_query($conn,
                        "SELECT DISTINCT 
                          mhs.nama,
                          judul.judul,
                          d1.nama_dosen AS pembimbing,
                          ps.tgl_sidang AS tgl,
                          ps.waktu_sidang AS waktu,
                          ps.ruang_sidang AS ruang, ps.id_sidang, ps.val_dosbing,
                          (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN proposal_penguji pp
                          ON d1.nidn=pp.penguji WHERE pp.id_sidang=ps.id_sidang
                          AND status_penguji='Penguji 1' AND pp.status='Aktif'
                          LIMIT 0,1) AS penguji1,
                          (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN proposal_penguji pp
                          ON d1.nidn=pp.penguji WHERE pp.id_sidang=ps.id_sidang
                          AND status_penguji='Penguji 2' AND pp.status='Aktif'
                          LIMIT 0,1) AS penguji2
                          FROM proposaL_sidang ps 
                          LEFT JOIN proposal p
                          ON ps.id_proposal=p.id_proposal
                          LEFT JOIN dosen d1
                          ON d1.nidn=p.dosbing
                          LEFT JOIN judul  
                          ON p.id_judul=judul.id_judul
                          LEFT JOIN mahasiswa mhs
                          ON judul.nim=mhs.nim
                          WHERE p.dosbing='$nidn' AND ps.val_dosbing='0'") or die (mysqli_error($conn));
                        if (mysqli_num_rows($datasidang) > 0) {
                        while ($data1=mysqli_fetch_array($datasidang) ) {
                        ?>
                <!-- tampilkan data -->
                <tr>
                  <td><?php echo $data1["nama"] ?></td>
                  <td><?php echo $data1["judul"] ?></td>
                  <td><?php echo $data1["pembimbing"] ?></td>
                  <td>
                    <button type="submit" id="detaildata" class="btn btn-warning" data-toggle="modal"
                      data-target="#modal-lg" data-id="<?php echo $data1["id_sidang"] ?>"
                      data-nama="<?php echo $data1["nama"] ?>" data-judul="<?php echo $data1["judul"] ?>"
                      data-dosbing="<?php echo $data1["pembimbing"] ?>" data-tgl="<?php echo $data1["tgl"] ?>"
                      data-penguji1="<?php echo $data1["penguji1"] ?>" data-penguji2="<?php echo $data1["penguji2"] ?>"
                      data-ruang="<?php echo $data1["ruang_sid"] ?>" data-status="<?php echo $status ?>"><i
                        class="fas fa-edit"></i></button>
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
  <!-- /.content -->

  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <center>
              <h2 class="m-0 text-dark">Riwayat Validasi Pendaftar Sidang</h2>
            </center>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example3" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="180px">Nama</th>
                  <th width="250px">Judul</th>
                  <th width="200px">Pembimbing</th>
                  <th width="80px">Status Validasi</th>
                  <th width="50px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                         // ambil data penguji
                        $datasidang1 = mysqli_query($conn,
                        "SELECT DISTINCT 
                          mhs.nama,
                          judul.judul,
                          d1.nama_dosen AS pembimbing,
                          ps.tgl_sidang AS tgl,
                          ps.waktu_sidang AS waktu,
                          ps.ruang_sidang AS ruang, ps.id_sidang, ps.val_dosbing,
                          (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN proposal_penguji pp
                          ON d1.nidn=pp.penguji WHERE pp.id_sidang=ps.id_sidang
                          AND status_penguji='Penguji 1' AND pp.status='Aktif'
                          LIMIT 0,1) AS penguji1,
                          (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN proposal_penguji pp
                          ON d1.nidn=pp.penguji WHERE pp.id_sidang=ps.id_sidang
                          AND status_penguji='Penguji 2' AND pp.status='Aktif'
                          LIMIT 0,1) AS penguji2
                          FROM proposaL_sidang ps 
                          LEFT JOIN proposal p
                          ON ps.id_proposal=p.id_proposal
                          LEFT JOIN dosen d1
                          ON d1.nidn=p.dosbing
                          LEFT JOIN judul  
                          ON p.id_judul=judul.id_judul
                          LEFT JOIN mahasiswa mhs
                          ON judul.nim=mhs.nim
                          WHERE p.dosbing='$nidn' AND (ps.val_dosbing='1' OR ps.val_dosbing='2')") or die (mysqli_error($conn));
                        if (mysqli_num_rows($datasidang1) > 0) {
                        while ($data2=mysqli_fetch_array($datasidang1) ) {
                        ?>
                <!-- tampilkan data -->
                <tr>
                  <td><?php echo $data2["nama"] ?></td>
                  <td><?php echo $data2["judul"] ?></td>
                  <td><?php echo $data2["pembimbing"] ?></td>
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
                  <td>
                    <button type="submit" id="detaildata1" class="btn btn-warning" data-toggle="modal"
                      data-target="#modal-lg1" data-id="<?php echo $data2["id_sidang"] ?>"
                      data-nama="<?php echo $data2["nama"] ?>" data-judul="<?php echo $data2["judul"] ?>"
                      data-dosbing="<?php echo $data2["pembimbing"] ?>" data-tgl="<?php echo $data2["tgl"] ?>"
                      data-penguji1="<?php echo $data2["penguji1"] ?>" data-penguji2="<?php echo $data2["penguji2"] ?>"
                      data-ruang="<?php echo $data2["ruang_sid"] ?>" data-status="<?php echo $status ?>"><i
                        class="fas fa-edit"></i></button>
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
  <!-- /.content -->

  <!-- modal ubah validasi-->
  <div class="modal fade" id="modal-lg1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Ubah Validasi Pendaftaran Sidang Proposal</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" method="post">
            <div class="card-body">
              <div class="form-group row">
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="id_sidang" name="id_sidang" required="required" hidden>
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
  <!-- modal ubah validasi-->

  <!-- modal ubah validasi-->
  <div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Validasi Pendaftaran Sidang Proposal</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" method="post">
            <div class="card-body">
              <div class="form-group row">
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="id_sidang" name="id_sidang" required="required" hidden>
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
  <!-- modal ubah validasi-->
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
    $("#modal-lg #id_sidang").val(id);
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
    $("#modal-lg1 #id_sidang").val(id);
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