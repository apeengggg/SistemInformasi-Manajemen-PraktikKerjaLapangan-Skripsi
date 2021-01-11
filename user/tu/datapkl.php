<?php
session_start();
require "../../koneksi.php";
if (!isset($_SESSION["login_tu"])) {
header("location:../../index.php");
exit();
}

if (isset($_POST["ubahdata"])) {
  $pem = $_POST["pembimbing"];
  $instansi = $_POST["instansi"];
  $judul = $_POST["judul"];
  $id = $_POST["id"];
  $sql = mysqli_query($conn, "UPDATE pkl SET id_dosenwali='$pem',
                                             instansi='$instansi',
                                             judul_laporan='$judul'
                                             WHERE id_pkl='$id'") or die (mysqli_error($conn));
  if ($sql) {
    echo "<script>
    alert('Data PKL berhasil diubah')
    windows.location.href('datapkl.php')
    </script>";
  }else {
    echo "<script>
    alert('Data PKL gagal diubah')
    windows.location.href('datapkl.php')
    </script>";
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Data Praktik Kerja Lapangan | SIM-PS | TU</title>
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
              <h1 class="m-0 text-dark">Data Praktik Kerja Lapangan</h1><br>
            </center>
            <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#modal-md"><i
                class="fas fa-print"></i> Cetak</button>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead align="center">
                <tr>
                  <th width="50px">NIM</th>
                  <th width="200px">Nama</th>
                  <th width="200px">Pembimbing</th>
                  <th width="150px">Judul Laporan</th>
                  <th width="100px">Instansi</th>
                  <th>Surat</th>
                  <th>Aksi</th>
                  <!-- <th>Aksi</th> -->
                </tr>
              </thead>
              <tbody>
                <?php
                        //ambi data pendaftar
                        $datapkl = mysqli_query($conn,
                        "SELECT mahasiswa.nama,mahasiswa.nim,
                        dosen.nama_dosen, dosen_wali.nidn, 
                        pkl.judul_laporan,
                        pkl.instansi,
                        pkl.surat_balasan, pkl.id_pkl FROM mahasiswa JOIN pkl 
                        ON mahasiswa.nim=pkl.nim JOIN dosen_wali
                        ON pkl.id_dosenwali=dosen_wali.id_dosenwali JOIN dosen
                        ON dosen_wali.nidn=dosen.nidn")
                        or die (mysqli_erorr($conn));

                        if (mysqli_num_rows($datapkl) > 0) {
                        while ($data1=mysqli_fetch_array($datapkl) ) {
                        ?>

                <!-- tampilkan data -->
                <tr>
                  <td><?php echo $data1["nim"] ?></td>
                  <td><?php echo $data1["nama"] ?></td>
                  <td><?php echo $data1["nama_dosen"] ?></td>
                  <td><?php echo $data1["judul_laporan"] ?></td>
                  <td><?php echo $data1["instansi"] ?></td>
                  <td align="center"><a href="assets/downloadsurat.php?filename=<?=$data1["surat_balasan"]?>"
                      class="btn-sm btn-info"><i class="fas fa-download"></i></a>
                  </td>
                  <td align="center">
                    <button class="btn-sm btn-warning" id="ubah" name="ubah" data-toggle="modal"
                      data-target="#modalubah" data-id="<?= $data1["id_pkl"]?>"
                      data-judul="<?= $data1["judul_laporan"]?>" data-pem="<?= $data1["nama_dosen"]?>"
                      data-instansi="<?= $data1["instansi"]?>">
                      <i class="fas fa-edit"></i></button></td>
                </tr>
                <?php  }
                        }
                        ?>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->

          <!-- modal cetak laporan pkl -->
          <div class="modal fade" id="modal-md">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Cetak Laporan Data Praktik Kerja Lapangan</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form class="form-horizontal" method="post" action="assets/reportpkl.php">
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
          <!-- modal cetak laporan pkl -->

          <!-- ubah data pkl -->
          <div class="modal fade" id="modalubah">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Form Ubah Data Praktik Kerja Lapangan</h4>
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
                        <label for="pembimbing" class="col-sm-3 col-form-label">Nama Pembimbing</label>
                        <div class="col-sm-9">
                          <select class="form-control" name="pembimbing" id="pembimbing" required="required">
                            <option value="">Pilih Pembimbing...</option>
                            <?php
                                    //ambil data dosen
                                    $sql = mysqli_query($conn, "SELECT dw.id_dosenwali, d.nama_dosen FROM dosen_wali dw INNER JOIN dosen d ON dw.nidn=d.nidn") or die (mysqli_erorr($conn));
                                    while ($dosen1 = mysqli_fetch_array($sql)) {
                                    ?>
                            <option value="<?=$dosen1["id_dosenwali"]?>"><?=$dosen1["nama_dosen"]?>
                            </option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="judul" class="col-sm-3 col-form-label">Judul Laporan</label>
                        <div class="col-sm-9">
                          <input type="text" name="judul" id="judul" class="form form-control" required="required">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="instansi" class="col-sm-3 col-form-label">Instansi</label>
                        <div class="col-sm-9">
                          <input type="text" name="instansi" id="instansi" class="form form-control"
                            required="required">
                        </div>
                      </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="ubahdata"
                    id="ubahdata">Ubah</button>
                </div>
              </div>
              </form>
            </div>
          </div>
          <!-- ubah data pkl -->

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
  //detail data mhs
  $(document).on("click", "#ubah", function () {
    let id = $(this).data('id');
    let judul = $(this).data('judul');
    let pem = $(this).data('pem');
    let instansi = $(this).data('instansi');
    $("#modalubah #id").val(id);
    $("#modalubah #judul").val(judul);
    $("#modalubah #pembimbing").attr("value", +pem);
    $("#modalubah #instansi").val(instansi);
  });
</script>
</body>

</html>