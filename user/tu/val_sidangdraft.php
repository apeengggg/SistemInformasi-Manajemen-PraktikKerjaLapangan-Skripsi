<?php
// error_reporting(0);
session_start();
require "../../koneksi.php";
if (!isset($_SESSION["login_tu"])) {
header("location:../../index.php");
exit();
}
?>
<!-- jadwalkan sidang -->
<?php
if (isset($_POST["jadwalkan"])) {
$ids=$_POST["ids"];
$val = $_POST["valdosbing"];
// var_dump($_POST); die;
$sqljadwal = mysqli_query($conn, "UPDATE draft_sidang_syarat SET
status='$val'
WHERE id_syarat='$ids'") or die (mysqli_erorr($conn)); 
if ($sqljadwal AND $val!='') {
echo "<script>
alert('Berhasil Memvalidasi Pendaftaran Sidang Mahasiswa')
windows.location.href('val_sidangdraft.php')
</script>";
}else {
echo "<script>
alert('Gagal Memvalidasi Pendaftaran Sidang PKL')
windows.location.href('val_sidangdraft.php')
</script>";
}
}
 
if (isset($_POST["jadwalkan1"])) {
$id=$_POST["id_sidpkl"];
$ids=$_POST["ids"];
$val = $_POST["valdosbing"];
// var_dump($_POST); die;
// var_dump($_POST);  die;
$cs = mysqli_query($conn, "SELECT status_sidang FROM draft_sidang WHERE id_sidang='$id' AND (status_sidang='Lulus' OR status_sidang='Tidak Lulus')");
if (mysqli_num_rows($cs)>0) {
echo "<script>
alert('Sidang Sudah Dilakukan, Tidak Dapat Mengubah Validasi')
windows.location.href('val_sidangdraft.php')
</script>";
}else{
$sqljadwal = mysqli_query($conn, "UPDATE draft_sidang_syarat SET
status='$val'
WHERE id_syarat='$ids'") or die (mysqli_erorr($conn)); 
if ($sqljadwal) {
echo "<script>
alert('Berhasil Mengubah Memvalidasi Pendaftaran Sidang Mahasiswa')
windows.location.href('val_sidangdraft.php')
</script>";
}else {
echo "<script>
alert('Gagal Mengubah Memvalidasi Pendaftaran Sidang Draft')
windows.location.href('val_sidangdraft.php')
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
  <title>Validasi Pendaftaran Sidang Draft | SIM-PS | Tata Usaha</title>
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
              <h2 class="m-0 text-dark">Data Pendaftaran Sidang Draft</h2>
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
                  <th width="80px">Validasi Pembimbing1</th>
                  <th width="80px">Validasi Pembimbing2</th>
                  <th width="80px">File</th>
                  <th width="50px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                        //ambi data pendaftar
                        $datasidang = mysqli_query($conn,
                        "SELECT m.nim, m.nama, j.judul, ds.val_dosbing1, ds.val_dosbing2, dss.file
                        , dss.id_syarat, dss.status,
                        -- pem 1
                        (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd
                        ON d1.nidn=sd.nidn WHERE sd.id_skripsi=s.id_skripsi 
                        AND status_dosbing='Pembimbing 1' AND sd.status='Aktif'
                        LIMIT 0,1) AS pem1,
                        -- pem2
                        (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd
                        ON d1.nidn=sd.nidn WHERE sd.id_skripsi=s.id_skripsi 
                        AND status_dosbing='Pembimbing 2' AND sd.status='Aktif'
                        LIMIT 0,1) AS pem2 
                        FROM draft_sidang ds LEFT JOIN skripsi s 
                        ON ds.id_skripsi=s.id_skripsi LEFT JOIN proposal p
                        ON s.id_proposal=p.id_proposal
                        LEFT JOIN judul j ON p.id_judul=j.id_judul
                        LEFT JOIN mahasiswa m ON j.nim=m.nim
                        LEFT JOIN draft_sidang_syarat dss ON ds.id_sidang=dss.id_sidang
                        WHERE (ds.val_dosbing1='2' AND ds.val_dosbing2='2') AND dss.status='0'")
                        or die (mysqli_erorr($conn));
                        while ($data1=mysqli_fetch_array($datasidang) ) {
                            if ($data1["val_dosbing1"]==0) {
                                $val ='Menunggu';
                              }elseif ($data1["val_dosbing1"]==1) {
                                $val ='Ditolak';
                              }elseif ($data1["val_dosbing1"]==2) {
                                $val ='Disetujui';
                              }
                              if ($data1["val_dosbing2"]==0) {
                                $val1 ='Menunggu';
                              }elseif ($data1["val_dosbing2"]==1) {
                                $val1 ='Ditolak';
                              }elseif ($data1["val_dosbing2"]==2) {
                                $val1 ='Disetujui';
                              }
                        ?>
                <!-- tampilkan data -->
                <tr>
                  <td><?php echo $data1["nim"] ?></td>
                  <td><?php echo $data1["nama"] ?></td>
                  <td><?php echo $data1["judul"] ?></td>
                  <td align="center">
                    <?php
                            if ($val=="Menunggu") {
                            ?>
                    <span class="badge badge-primary">
                      <?php } else if ($val=="Disetujui"){
                              ?>
                      <span class="badge badge-success">
                        <?php }else if ($val=="Ditolak"){
                                ?>
                        <span class="badge badge-danger">
                          <?php } ?>
                          <?= $val  ?>
                  </td>
                  <td align="center">
                    <?php
                            if ($val1=="Menunggu") {
                            ?>
                    <span class="badge badge-primary">
                      <?php } else if ($val1=="Disetujui"){
                              ?>
                      <span class="badge badge-success">
                        <?php }else if ($val1=="Ditolak"){
                                ?>
                        <span class="badge badge-danger">
                          <?php } ?>
                          <?= $val1  ?>
                  </td>
                  <td align="center"><a href="assets/downsiddraft.php?filename=<?= $data1["file"]?>"
                      class="btn btn-info"><i class="fas fa-download"></i></a></td>
                  <td align="center">
                    <button type="submit" id="detaildata" class="btn btn-warning" data-toggle="modal"
                      data-target="#modal-lg" data-id="<?php echo $data1["id_sidang"] ?>"
                      data-ids="<?php echo $data1["id_syarat"] ?>" data-nama="<?php echo $data1["nama"] ?>"
                      data-judul="<?php echo $data1["judul"] ?>" data-dosbing1="<?php echo $data1["pem1"] ?>"
                      data-dosbing2="<?php echo $data1["pem2"] ?>"><i class="fas fa-cogs"></i></button>
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
                  <th width="80px">Validasi Persyaratan</th>
                  <th width="80px">File</th>
                  <th width="50px">Ubah</th>
                </tr>
              </thead>
              <tbody>
                <?php
                        //ambi data pendaftar
                        $datasidang = mysqli_query($conn,
                        "SELECT m.nim, m.nama, j.judul, ds.val_dosbing1, ds.val_dosbing2, dss.file
                        , dss.id_syarat, dss.status, ds.id_sidang,
                        -- pem 1
                        (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd
                        ON d1.nidn=sd.nidn WHERE sd.id_skripsi=s.id_skripsi 
                        AND status_dosbing='Pembimbing 1' AND sd.status='Aktif'
                        LIMIT 0,1) AS pem1,
                        -- pem2
                        (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd
                        ON d1.nidn=sd.nidn WHERE sd.id_skripsi=s.id_skripsi 
                        AND status_dosbing='Pembimbing 2' AND sd.status='Aktif'
                        LIMIT 0,1) AS pem2 
                        FROM draft_sidang ds LEFT JOIN skripsi s 
                        ON ds.id_skripsi=s.id_skripsi LEFT JOIN proposal p
                        ON s.id_proposal=p.id_proposal
                        LEFT JOIN judul j ON p.id_judul=j.id_judul
                        LEFT JOIN mahasiswa m ON j.nim=m.nim
                        LEFT JOIN draft_sidang_syarat dss ON ds.id_sidang=dss.id_sidang
                        WHERE dss.status='2' OR dss.status='1'")
                        or die (mysqli_erorr($conn));
                        while ($data1=mysqli_fetch_array($datasidang) ) {
                            if ($data1["status"]==0) {
                                $val ='Menunggu';
                              }elseif ($data1["status"]==1) {
                                $val ='Ditolak';
                              }elseif ($data1["status"]==2) {
                                $val ='Disetujui';
                              }
                        ?>
                <!-- tampilkan data -->
                <tr>
                  <td><?php echo $data1["nim"] ?></td>
                  <td><?php echo $data1["nama"] ?></td>
                  <td><?php echo $data1["judul"] ?></td>
                  <td align="center">
                    <?php
                            if ($val=="Menunggu") {
                            ?>
                    <span class="badge badge-primary">
                      <?php } else if ($val=="Disetujui"){
                              ?>
                      <span class="badge badge-success">
                        <?php }else if ($val=="Ditolak"){
                                ?>
                        <span class="badge badge-danger">
                          <?php } ?>
                          <?= $val  ?>
                  </td>
                  <td align="center"><a href="../../assets/syarat_sidang_draft/<?= $data1["file"]?>"
                      class="btn btn-info" target="_blank"><i class="fas fa-download"></i></a></td>
                  <td align="center">
                    <button type="submit" id="detaildata1" class="btn btn-warning" data-toggle="modal"
                      data-target="#modal-lg1" data-id="<?php echo $data1["id_sidang"] ?>"
                      data-ids="<?php echo $data1["id_syarat"] ?>" data-nama="<?php echo $data1["nama"] ?>"
                      data-judul="<?php echo $data1["judul"] ?>" data-dosbing1="<?php echo $data1["pem1"] ?>"
                      data-dosbing2="<?php echo $data1["pem2"] ?>" data-status="<?php echo $val ?>"><i
                        class="fas fa-cogs"></i></button>
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
          <h4 class="modal-title">Validasi Pendaftaran Sidang Draft</h4>
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
                  <input type="text" class="form-control" id="ids" name="ids" required="required" hidden readonly>
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
                <label for="id_dosenwali" class="col-sm-3 col-form-label">Pembimbing 1</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="id_dosenwali" name="id_dosenwali" required="required"
                    readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="id_dosenwali1" class="col-sm-3 col-form-label">Pembimbing 2</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="id_dosenwali1" name="id_dosenwali1" required="required"
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
                  <input type="text" class="form-control" id="id_sidpkl" name="id_sidpkl" required="required" hidden
                    readonly>
                  <input type="text" class="form-control" id="ids" name="ids" required="required" hidden readonly>
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
                <label for="id_dosenwali" class="col-sm-3 col-form-label">Pembimbing 1</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="id_dosenwali" name="id_dosenwali" required="required"
                    readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="id_dosenwali1" class="col-sm-3 col-form-label">Pembimbing 2</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="id_dosenwali1" name="id_dosenwali1" required="required"
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
    let ids = $(this).data('ids');
    let nama = $(this).data('nama');
    let judul = $(this).data('judul');
    let dosbing1 = $(this).data('dosbing1');
    let dosbing2 = $(this).data('dosbing2');
    let tgl = $(this).data('tgl');
    let ruang = $(this).data('ruang');
    $("#modal-lg #id_sidpkl").val(id);
    $("#modal-lg #ids").val(ids);
    $("#modal-lg #nama").val(nama);
    $("#modal-lg #judul_laporan").val(judul);
    $("#modal-lg #id_dosenwali").val(dosbing1);
    $("#modal-lg #id_dosenwali1").val(dosbing2);
    $("#modal-lg #tgl_sid").val(tgl);
    $("#modal-lg #ruangsid").val(ruang);
  });

  // detail data mhs
  $(document).on("click", "#detaildata1", function () {
    let id = $(this).data('id');
    let ids = $(this).data('ids');
    let nama = $(this).data('nama');
    let judul = $(this).data('judul');
    let dosbing1 = $(this).data('dosbing1');
    let dosbing2 = $(this).data('dosbing2');
    let tgl = $(this).data('tgl');
    let ruang = $(this).data('ruang');
    let status = $(this).data('status');
    $("#modal-lg1 #id_sidpkl").val(id);
    $("#modal-lg1 #ids").val(ids);
    $("#modal-lg1 #nama").val(nama);
    $("#modal-lg1 #judul_laporan").val(judul);
    $("#modal-lg1 #id_dosenwali").val(dosbing1);
    $("#modal-lg1 #id_dosenwali1").val(dosbing2);
    $("#modal-lg1 #tgl_sid").val(tgl);
    $("#modal-lg1 #ruangsid").val(ruang);
    $("#modal-lg1 #validasi").val(status);
  });
</script>
</body>

</html>