<?php
session_start();
if (!isset($_SESSION["login_tu"])) {
header("location:../../index.php");
exit();
}
require "../../koneksi.php";
$nidn = $_SESSION["nidn"];

if (isset($_POST["ubahdata"])) {
  $id = $_POST["id"];
  $nidn = $_POST["dosen_wali"];
// cek dosen sudah menjadi dosen wali ?
$cek = mysqli_query($conn, "SELECT * FROM dosen_wali WHERE nidn='$nidn'") or die (mysqli_erorr($conn));
if (mysqli_num_rows($cek)===1) {
echo "<script>
alert('Dosen Ini, Sudah Terdaftar Menjadi Dosen Wali !')
windows.location.href('dosenwali.php')
</script>";
}else {
  $insert = mysqli_query($conn, "UPDATE dosen_wali SET nidn='$nidn' WHERE id_dosenwali='$id'") or die (mysqli_erorr($conn));
if ($insert) {
echo "<script>
alert('Dosen Wali Berhasil Diubah !')
windows.location.href('dosenwali.php')
</script>";
}else {
echo "<script>
alert('Dosen Wali Gagal Diubah !')
windows.location.href('dosenwali.php')
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
  <title>Data Dosen Wali | SIM-PS | Tata Usaha </title>
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
              <h1 class="m-0 text-dark">Data Dosen Wali</h1>
            </center>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example3" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="150px">Kode Dosen Wali</th>
                  <th>NIDN</th>
                  <th>Nama Dosen</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                            //ambi data bimbingan
                            $getdata = mysqli_query($conn, 
                              "SELECT dosen_wali.id_dosenwali, dosen.nama_dosen, dosen.nidn FROM dosen_wali JOIN dosen ON dosen_wali.nidn=dosen.nidn ORDER BY dosen_wali.id_dosenwali") or die (mysqli_erorr($conn));
                            if (mysqli_num_rows($getdata) > 0) {
                            while ($data=mysqli_fetch_array($getdata)) {
                              ?>
                <tr>
                  <td><?= $data['id_dosenwali']?></td>
                  <td><?= $data['nidn']?></td>
                  <td><?= $data['nama_dosen']?></td>
                  <td width="30px" align="center">
                    <button type="submit" class="btn btn-sm btn-dark" id="detail" data-toggle="modal"
                      data-target="#modal" data-id="<?= $data['id_dosenwali'] ?>"
                      data-nama="<?= $data['nama_dosen'] ?>"><i class="fas fa-edit"></i></button>
                  </td>
                </tr>
                <?php  }
                            }
                            ?>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <!-- modal ubah -->
          <div class="modal fade" id="modal">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Ubah Data Dosen Wali</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form class="form-horizontal" method="post">
                    <div class="card-body">
                      <div class="form-group row">
                        <label for="nidn" class="col-sm-3 col-form-label">Id Dosen Wali</label>
                        <div class="col-sm-9">
                          <input type="number" class="form-control" id="id" name="id" placeholder="NIDN"
                            required="required" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="nama_dosen" class="col-sm-3 col-form-label">Nama Dosen</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="nama_dosen" name="nama_dosen" required="required"
                            readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="subjek" class="col-sm-3 col-form-label">Dosen Wali Baru</label>
                        <div class="col-sm-9">
                          <select class="form-control" name="dosen_wali" id="dosen_wali" required="required">
                            <?php 
                                      $get= mysqli_query($conn, "SELECT * FROM dosen"); ?>
                            <option value="">Pilih Dosen Baru</option>
                            <?php while ($data1=mysqli_fetch_array($get)) {
                                        ?>
                            <option value="<?= $data1["nidn"]  ?>"><?=$data1["nama_dosen"]  ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="ubahdata" id="ubahdata">Ubah
                    Data</button>
                </div>
              </div>
              </form>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- /. modal ubah -->

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
  $(document).on("click", "#detail", function () {
    let id = $(this).data('id');
    let nama = $(this).data('nama');
    $(".modal-body #id").val(id);
    $(".modal-body #nama_dosen").val(nama);
  });
</script>
</body>

</html>