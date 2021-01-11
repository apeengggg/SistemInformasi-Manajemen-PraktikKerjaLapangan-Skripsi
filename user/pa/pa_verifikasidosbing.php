<?php
session_start();
require "../../koneksi.php";
if (!isset($_SESSION["login_pa"])) {
header("location:../../index.php");
exit();
}

if (isset($_POST["submit"])) {
  if (empty($_POST["pem1"]) OR empty($_POST["pem2"])) {
echo "<script>
alert('Dosen Pembimbing Harus Dipilih !')
windows.location.href='verifikasidosbing.php'
</script>";    
  }else {
  $pem1 = $_POST["pem1"];
  $pem2 = $_POST["pem2"];
  $id = $_POST["id_skripsi"];
  $p1 = "Pembimbing 1";
  $p2 = "Pembimbing 2";
if ($pem1 == $pem2) {
  echo "<script>
  alert('Dosen pembimbing1 dan 2 tidak boleh sama !')
  windows.location.href='verifikasidosbing.php'
  </script>";
}else {
  $sql2 = mysqli_query($conn, "INSERT INTO skripsi_dosbing (nidn, id_skripsi, status_dosbing) VALUES ('$pem1', '$id', '$p1')");
  $sql3 = mysqli_query($conn, "INSERT INTO skripsi_dosbing (nidn, id_skripsi, status_dosbing) VALUES ('$pem2', '$id', '$p2')");
 if ($sql2 && $sql3) {
echo "<script>
alert('Berhasil Memverifikasi Dosen Pembimbing Skripsi')
windows.location.href='verifikasidosbing.php'
</script>";
 }else {
echo "<script>
alert('Gagal Memverifikasi Dosen Pembimbing Skripsi')
windows.location.href='verifikasidosbing.php'
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
    <title>Verifikasi Dosbing 1 dan 2 | SIM-PS | Penasihat Akademik</title>
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
          <div class="col-sm-12">
            <!-- <h1 class="m-0 text-dark">Daftar Permintaan Dosbing 1 dan 2 Skripsi</h1> -->
            </div><!-- /.col -->
            </div><!-- /.row -->
            </div><!-- /.container-fluid -->
          </section>
          <!-- Main content -->
          <section class="content">
            <!-- data file mahasiswa bimbingan -->
            <div class="row">
              <div class="col-12">
                <div class="card">
                <div class="card-header">
                <center><h1 class="m-0 text-dark">Pemilihan Dosen Pembimbing 1 dan 2 Skripsi</h1></center></div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead align="center">
                        <tr>
                          <th width="200px">Nama</th>
                          <th width="250px">Judul Skripsi</th>
                          <th width="150px">Studi Kasus</th>
                          <th width="120px">Status Proposal</th>
                          <th width="50px">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        //ambi data pendaftar
                        $datapkl = mysqli_query($conn,
                        "SELECT DISTINCT
                        mahasiswa.nim, mahasiswa.nama, mahasiswa.foto,
                        mahasiswa.status_proposal,
                        judul.judul,
                        judul.studi_kasus,
                        dosen.nama_dosen,
                        s.id_skripsi,
                        (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd
                        ON d1.nidn=sd.nidn
                        WHERE sd.id_skripsi=s.id_skripsi) AS pem1,
                        (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN skripsi_dosbing sd
                        ON d2.nidn=sd.nidn
                        WHERE sd.id_skripsi=s.id_skripsi) AS pem2
                        FROM skripsi s LEFT JOIN proposal
                        ON s.id_proposal=proposal.id_proposal
                        LEFT JOIN judul
                        ON proposal.id_judul=judul.id_judul
                        LEFT JOIN dosen
                        ON proposal.dosbing=dosen.nidn
                        LEFT JOIN mahasiswa
                        ON judul.nim=mahasiswa.nim 
                        LEFT JOIN skripsi_dosbing sd
                        ON s.id_skripsi=sd.id_skripsi
                        WHERE judul.status_judul='Disetujui' AND sd.nidn IS NULL")
                        or die (mysqli_error($conn));

                        if (mysqli_num_rows($datapkl) > 0) {
                        while ($data1=mysqli_fetch_array($datapkl) ) {
                        ?>

                        <!-- tampilkan data -->
                        <tr>
                          <td><?php echo $data1["nama"] ?></td>
                          <td><?php echo $data1["judul"] ?></td>
                          <td><?php echo $data1["studi_kasus"] ?></td>
                          <td align="center"><?php echo $data1["status_proposal"] ?></td>
                          <td align="center">
                            <button 
                            class="btn btn-info"
                            type="submit" 
                            name="verif" 
                            data-toggle="modal" 
                            id="verif" 
                            data-target="#modal1"
                            data-id_skripsi="<?= $data1["id_skripsi"]?>"
                            data-dosbing="<?=  $data1["nama_dosen"]?>"
                            data-nama="<?=  $data1["nama"]?>"
                            data-nim="<?=  $data1["nim"]?>"
                            data-judul="<?=  $data1["judul"]?>"
                            data-foto="<?=  $data1["foto"]?>"
                            data-status="<?=  $data1["status_proposal"]?>"
                            >
                            <i class="fas fa-edit"></i>
                            </button>
                          </td>
                        </tr>
                        <?php  }
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
            <!-- /. data file maahsiswa bimbingan -->      
              <!-- modal tambah bimbingan -->
                  <div class="modal fade" id="modal1">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Verifikasi Dosen Pembimbing 1 dan 2 Skripsi</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="card-body">
                            <center>
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <img src="" alt="" width="140px" height="150px" id="foto">
                                </div>
                              </div>
                              </center>
                              <div class="form-group row">
                                <div class="col-sm-4">
                                <label for="nim" class="col-sm-3 col-form-label">NIM</label>
                                  <input type="text" class="form-control" id="nim" name="nim" required="required" readonly>
                                </div>
                                <div class="col-sm-8">
                                <label for="Nama" class="col-sm-3 col-form-label">Nama</label>
                                  <input type="text" class="form-control" id="nama" name="nama" required="required" readonly>
                                </div>
                              </div>
                              <div class="form-group row">
                                <div class="col-sm-12">
                                <label for="judul" class="col-sm-3 col-form-label">Judul Skripsi</label>
                                  <textarea name="judul" id="judul" cols="30" rows="2" class="form-control" required="required" readonly></textarea>
                                </div>
                              </div>
                              <div class="form-group row">
                                <div class="col-sm-8">
                                <label for="dosbing" class="col-sm-5 col-form-label">Pembimbing Proposal</label>
                                  <input type="text" class="form-control" id="dosbing" name="dosbing" required="required" readonly>
                                </div>
                                <div class="col-sm-4">
                                <label for="stat_prop" class="col-sm-7 col-form-label">Status Proposal</label>
                                  <input type="text" class="form-control" id="stat_prop" name="stat_prop" required="required" readonly>
                                </div>
                              </div>
                              <div class="form-group row">
                                <div class="col-sm-6">
                                <label for="pem1" class="col-sm-5 col-form-label">Pembimbing 1</label>
                                <select name="pem1" id="pem 1" class="form-control" required>
                                <option disabled selected>Pilih...</option> 
                                  <?php   
                                  $getdosen = mysqli_query($conn,
                                              "SELECT * FROM dosen WHERE jabatan IS NOT NULL");
                                  while ($data=mysqli_fetch_array($getdosen)) {
                                  ?>
                                  <option value="<?= $data["nidn"] ?>"><?= $data["nama_dosen"]?></option>
                                <?php   } ?>
                                </select>
                                </div>
                                <div class="col-sm-6">
                                <label for="pem2" class="col-sm-5 col-form-label">Pembimbing 2</label>
                                <select name="pem2" id="pem2" class="form-control" required>
                                <option disabled selected>Pilih...</option>
                                  <?php   
                                  $getdosen1 = mysqli_query($conn,
                                              "SELECT * FROM dosen WHERE jabatan IS NOT NULL");
                                  while ($dataa=mysqli_fetch_array($getdosen1)) {
                                  ?>
                                  <option value="<?= $dataa["nidn"] ?>"><?= $dataa["nama_dosen"]?></option>
                                <?php   } ?>
                              </select>
                                </div>
                              </div>
                              <div class="form-group row">
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" id="id_skripsi" name="id_skripsi" required="required">
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="submit" id="submit">Submit</button>
                          </div>
                        </div>
                      </form>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>
                  <!-- /.modal -->
                  <!-- modal tambah bimbingan -->
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

// detail data
$(document).on("click", "#verif", function(){
let id = $(this).data('id_skripsi');
let foto = $(this).data('foto');
let nim = $(this).data('nim');
let nama = $(this).data('nama');
let judul = $(this).data('judul');
let dosbing = $(this).data('dosbing');
let status = $(this).data('status');
$("#modal1 #foto").attr("src", "../../assets/foto/"+foto);
$("#modal1 #id_skripsi").val(id);
$("#modal1 #nim").val(nim);
$("#modal1 #nama").val(nama);
$("#modal1 #judul").val(judul);
$("#modal1 #dosbing").val(dosbing);
$("#modal1 #stat_prop").val(status);
});
                    
      </script>
    </body>
  </html>