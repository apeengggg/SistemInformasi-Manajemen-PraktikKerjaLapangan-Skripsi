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
  // var_dump($_POST); die;
  $pem1 = $_POST["pembimbing1"];
  $pem2 = $_POST["pembimbing2"];
  $p1 = $_POST["nidn1"];
  $p2 =$_POST["nidn2"];

  if ($pem1==$pem2) {
    echo "<script>
      alert('Pembimbing 1 dan 2 Tidak Boleh Sama !')
      windows.location.href('dataskripsi.php')
      </script>";
  }else{
    if ($pem1!=$p1) {
    $nonaktif = mysqli_query($conn, "UPDATE skripsi_dosbing SET status='Tidak Aktif'
    WHERE nidn='$p1' AND status_dosbing='Pembimbing 1' AND id_skripsi='$id'");
    if ($nonaktif) {
    $tambah = mysqli_query($conn, "INSERT INTO skripsi_dosbing (id_skripsi, nidn, status_dosbing)
      VALUES ('$id','$pem1','Pembimbing 1')");
    if ($tambah) {
    echo "<script>
    alert('Data Pembimbing 1 Berhasil diubah')
    windows.location.href('dataskripsi.php')
    </script>";
    } else {
    echo "<script>
    alert('Data Pembimbing 1 Gagal diubah')
    windows.location.href('dataskripsi.php')
    </script>";
    }
  }else{
    echo "<script>
    alert('Data Pembimbing 1 Gagal diubah')
    windows.location.href('dataskripsi.php')
    </script>";
  }
  if ($pem2!=$p2) {
    $nonaktif2 = mysqli_query($conn, "UPDATE skripsi_dosbing SET status='Tidak Aktif'
                             WHERE nidn='$p2' AND status_dosbing='Pembimbing 2' AND id_skripsi='$id'");
      if ($nonaktif2) {
        $tambah1 = mysqli_query($conn, "INSERT INTO skripsi_dosbing (id_skripsi, nidn, status_dosbing)
                        VALUES ('$id','$pem2','Pembimbing 2')");
          if ($tambah1) {
            echo "<script>
            alert('Data Pembimbing 2 Berhasil diubah')
            windows.location.href('dataskripsi.php')
            </script>";
          } else {
            echo "<script>
            alert('Data Pembimbing 2 Gagal diubah')
            windows.location.href('dataskripsi.php')
            </script>";
          }
      }else{
        echo "<script>
        alert('Data Pembimbing 2 Gagal diubah')
        windows.location.href('dataskripsi.php')
        </script>";
      }
   }else {
    echo "<script>
    alert('Data Pembimbing 2 Tidak diubah')
    windows.location.href('dataskripsi.php')
    </script>";
   }
  }else {
    echo "<script>
    alert('Data Pembimbing 1 Tidak diubah')
    windows.location.href('dataskripsi.php')
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
  <title>Data Skripsi | SIM-PS | Tata Usaha</title>
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
              <h1 class="m-0 text-dark" id="semua">Data Skripsi</h1>
              <br>
            </center>
            <button type="submit" class="btn btn-warning" data-toggle="modal" data-target="#modal-md"><i
                class="fas fa-print"></i> Cetak Laporan</button>
            <!-- <a href="#bim" class="btn btn-primary">Mahasiswa Bimbingan</a> -->
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead align="center">
                <tr>
                  <!-- <th width="70px">Foto</th> -->
                  <th width="55px">NIM</th>
                  <th width="200px">Nama</th>
                  <th width="200px">Judul</th>
                  <th width="200px">Pembimbing1</th>
                  <th width="200px">Pembimbing2</th>
                  <th width="10px">Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                        $getdata = mysqli_query($conn,
                        "SELECT 
                        -- nidn pem1
                        (SELECT d1.nidn FROM dosen d1 INNER JOIN skripsi_dosbing sd 
                       ON d1.nidn=sd.nidn 
                       WHERE sd.id_skripsi=s.id_skripsi AND status_dosbing='Pembimbing 1'
                       AND sd.status='Aktif' LIMIT 0,1) AS nidn1, 
                       -- nama pem1
                       (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN skripsi_dosbing sd 
                       ON d2.nidn=sd.nidn 
                       WHERE sd.id_skripsi=s.id_skripsi AND status_dosbing='Pembimbing 1'
                       AND sd.status='Aktif' LIMIT 0,1) AS pem1, 
                        -- nidn pem2
                        (SELECT d3.nidn FROM dosen d3 INNER JOIN skripsi_dosbing sd 
                       ON d3.nidn=sd.nidn 
                       WHERE sd.id_skripsi=s.id_skripsi AND status_dosbing='Pembimbing 2'
                       AND sd.status='Aktif' LIMIT 0,1) AS nidn2, 
                       -- nama pem2
                       (SELECT d4.nama_dosen FROM dosen d4 INNER JOIN skripsi_dosbing sd
                       ON d4.nidn=sd.nidn 
                       WHERE sd.id_skripsi=s.id_skripsi AND status_dosbing='Pembimbing 2'
                       AND sd.status='Aktif' LIMIT 0,1) as pem2, 
                       mhs.nama, mhs.nim, mhs.status_skripsi, judul.judul, s.id_skripsi AS id
                       FROM skripsi s INNER JOIN proposal 
                       ON s.id_proposal=proposal.id_proposal 
                       INNER JOIN judul 
                       ON proposal.id_judul=judul.id_judul 
                       INNER JOIN mahasiswa mhs
                       ON judul.nim=mhs.nim 
                       WHERE judul.status_judul='Disetujui'")
                        or die (mysqli_erorr($conn));
                        if (mysqli_num_rows($getdata) > 0) {
                        while ($data=mysqli_fetch_array($getdata)) {
                        ?>
                <tr>
                  <td><?= $data['nim'] ?></td>
                  <td><?= $data['nama'] ?></td>
                  <td><?= $data['judul']?></td>
                  <td><?= $data['pem1']?></td>
                  <td><?= $data['pem2']?></td>
                  <td><?= $data['status_skripsi']?></td>
                  <td align="center"><button class="btn-sm btn-dark" id="detaildata" data-toggle="modal"
                      data-target="#modal12" data-id="<?= $data["id"] ?>" data-judul="<?= $data["judul"] ?>"
                      data-pem1="<?= $data["pem1"] ?>" data-pem2="<?= $data["pem2"] ?>"
                      data-nidn1="<?= $data["nidn1"] ?>" data-nidn2="<?= $data["nidn2"] ?>">
                      <i class="fas fa-edit"></i></button></td>
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
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- modal cetak laporan -->
    <div class="modal fade" id="modal-md">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Cetak Laporan Skripsi Mahasiswa</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" method="post" action="assets/reportskripsi.php">
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
    <!-- modal cetak laporan -->

    <!-- modal edit data proposal -->
    <div class="modal fade" id="modal12">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Ubah Pembimbing Skripsi</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" method="post">
              <div class="card-body">
                <div class="form-group row">
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="id" name="id" required="required" hidden readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="pembimbing" class="col-sm-3 col-form-label">Pembimbing 1 Saat Ini</label>
                  <div class="col-sm-4">
                    <input type="text" name="pem1" id="pem1" class="form-control" readonly>
                  </div>
                  <div class="col-sm-4">
                    <input type="text" name="nidn1" id="nidn1" class="form-control" readonly>
                  </div>
                  <label for="pembimbing1" class="col-sm-3 col-form-label">Nama Pembimbing 1</label>
                  <div class="col-sm-9">
                    <select class="form-control" name="pembimbing1" id="pembimbing1" required="required">
                      <option disabled selected>Pilih Pembimbing...</option>
                      <?php $pembimbing = mysqli_query($conn, "SELECT * FROM dosen WHERE jabatan IS NOT NULL");
                                    while ($d=mysqli_fetch_array($pembimbing)) {
                                    ?>
                      <option value="<?=$d["nidn"]?>"><?= $d["nama_dosen"]?></option>
                      <?php }?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="pembimbing" class="col-sm-3 col-form-label">Pembimbing 2 Saat Ini</label>
                  <div class="col-sm-4">
                    <input type="text" name="pem2" id="pem2" class="form-control" readonly>
                  </div>
                  <div class="col-sm-4">
                    <input type="text" name="nidn2" id="nidn2" class="form-control" readonly>
                  </div>
                  <label for="pembimbing2" class="col-sm-3 col-form-label">Nama Pembimbing 2</label>
                  <div class="col-sm-9">
                    <select class="form-control" name="pembimbing2" id="pembimbing2" required="required">
                      <option disabled selected>Pilih Pembimbing...</option>
                      <?php $pembimbing = mysqli_query($conn, "SELECT * FROM dosen WHERE jabatan IS NOT NULL");
                                    while ($d=mysqli_fetch_array($pembimbing)) {
                                    ?>
                      <option value="<?=$d["nidn"]?>"><?= $d["nama_dosen"]?></option>
                      <?php }?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="judul" class="col-sm-3 col-form-label">Judul Skripsi</label>
                  <div class="col-sm-9">
                    <textarea name="judul" id="judul" cols="20" rows="3" class="form form-control" readonly></textarea>
                    <!-- <input type="text" name="judul" id="judul" class="form form-control" required> -->
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
    <!-- /. modal edit data proposal -->

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
  $(document).on("click", "#detaildata", function () {
    let id = $(this).data('id');
    let judul = $(this).data('judul');
    let pem1 = $(this).data('pem1');
    let pem2 = $(this).data('pem2');
    let nidn1 = $(this).data('nidn1');
    let nidn2 = $(this).data('nidn2');
    $("#modal12 #id").val(id);
    $("#modal12 #pem1").val(pem1);
    $("#modal12 #pem2").val(pem2);
    $("#modal12 #judul").val(judul);
    $("#modal12 #nidn1").val(nidn1);
    $("#modal12 #nidn2").val(nidn2);
    $("#modal12 #pembimbing1").val(pem1);
    $("#modal12 #pembimbing2").val(pem2);
  });
</script>
</body>

</html>