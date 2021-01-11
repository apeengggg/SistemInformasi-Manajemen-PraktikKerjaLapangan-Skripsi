<?php
session_start();
if (!isset($_SESSION["login_pa"])) {
header("location:../../index.php");
exit();
}
require "../../koneksi.php";
$nidn = $_SESSION["nidn"];

// // ambil data bimbingan mahasiswa
// $getbim = mysqli_query($conn, "SELECT * FROM bimpkl WHERE nidn='$nidn'") or die (mysqli_erorr($conn));

// var_dump($_POST["verifikasi"]);
// verifikasi judul 
    if (isset($_POST["verifikasi"])) {
    $id = $_POST["id_judul"];
    $dosbing = $_POST["dosbing"];
    mysqli_autocommit($conn, FALSE);
    $insertproposal = mysqli_query($conn,"INSERT INTO proposal (id_judul, dosbing)
                                        VALUES ('$id', '$dosbing')") or die (mysqli_erorr($conn));
    $id_prop = mysqli_insert_id($conn);
    $insertskripsi = mysqli_query($conn, "INSERT INTO skripsi (id_proposal) 
                                        VALUES ('$id_prop')") or die (mysqli_error($conn));
    if ($insertskripsi && $insertproposal) {
        mysqli_commit($conn);
        echo "<script>
            alert('Dosen Pembimbing Berhasil Dipilih')
            windows.location.href('pemilihandosbing.php')
            </script>";
    }else {
        mysqli_rollback($conn);
        echo "<script>
            alert('Dosen Pembimbing Gagal Dipilih')
            windows.location.href('pemilihandosbing.php')
            </script>";
    }
}

$dosen = mysqli_query($conn, "SELECT * FROM dosen WHERE jabatan IS NOT NULL") or die (mysqli_error($conn));

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pemilihan Dosen Pembimbing Proposal | SIM-PS | Penasihat Akademik</title>
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
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
        <ul class="navbar-nav">
            <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
        </ul> 
               
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
                                <h2 class="m-0 text-dark">Pemilihan Dosen Pembimbing Proposal</h2>
                                </center>
                            </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead align="center">
                            <tr>
                                <th width="50px">NIM</th>
                                <th width="200px">Nama</th>
                                <th width="50px">Angkatan</th>
                                <th width="300px">Judul Skripsi</th>
                                <th width="200px">Dosen Tujuan</th>
                                <th width="50px">Status</th>
                                <th width="50px">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php 
                            //ambi data judul semua join mahasiswa
                            $getdata = mysqli_query($conn, 
                                    "SELECT m.nama, m.nim, m.angkatan, j.judul, d.nama_dosen,
                                    j.status_judul, m.foto, m.status_pkl, m.prodi,
                                    j.deskripsi_judul, j.id_judul, j.tujuan
                                    FROM judul j LEFT JOIN mahasiswa m
                                    ON j.nim=m.nim
                                    LEFT JOIN dosen d ON j.tujuan=d.nidn
                                    LEFT JOIN proposal p
                                    ON j.id_judul=p.id_judul
                                    WHERE j.status_judul='Disetujui' AND p.dosbing IS NULL") 
                                    or die (mysqli_erorr($conn));
                            if (mysqli_num_rows($getdata) > 0) {
                            while ($data=mysqli_fetch_array($getdata)) {
                            ?>
                            <tr>
                                <td><?= $data["nim"]?></td>
                                <td><?= $data["nama"]?></td>
                                <td><?= $data["angkatan"]?></td>
                                <td><?= $data["judul"]?></td>
                                <td><?= $data["nama_dosen"]?></td>
                                <td align="center">
                                <!-- ubah tulisan -->
                                <?php 
                                if ($data["status_judul"]=="Menunggu") {
                                ?>
                                <span class="badge badge-primary">   
                                <?php } else if ($data["status_judul"]=="Ditolak"){
                                ?>
                                <span class="badge badge-danger">
                                <?php }else if($data["status_judul"]=="Disetujui") {
                                ?>
                                <span class="badge badge-success">
                                <?php } ?>
                                <?= $data["status_judul"] ?></span></td>
                                <td>
                                <button class="btn-sm btn-dark" id="detaildata" data-toggle="modal" data-target="#modal-lg3"
                                    data-id="<?php echo $data['id_judul'];?>"
                                    data-nim="<?php echo $data['nim'];?>"
                                    data-nama="<?php echo $data['nama'];?>"
                                    data-angkatan="<?php echo $data['angkatan'];?>"
                                    data-prodi="<?php echo $data['prodi'];?>"
                                    data-foto="<?php echo $data['foto'];?>"
                                    data-pkl="<?php echo $data['status_pkl'];?>"
                                    data-judul="<?php echo $data['judul'];?>"
                                    data-status="<?php echo $data['status_judul'];?>"
                                    data-tujuan="<?php echo $data['tujuan'];?>"
                                    data-deskripsi="<?php echo $data['deskripsi_judul'];?>"
                                    data-sk="<?php echo $data['studi_kasus'];?>"
                                    ><i class="fas fa-user"></i>
                                </button>
                                </td>
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
                
                </section>
                <!-- /.content -->

                </div>
                <!-- /.content-wrapper -->
                    
                    <?php include 'assets/footer.php'; ?>
                    <!-- modal ubah -->
        <div class="modal fade"  id="modal-lg3">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-tittle">Form Pemilihan Dosen Pembimbing Proposal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" class="form-horizontal">
                <div class="card-body">
                    <div class="form-row">
                                <div class="form-group col-md-12">
                                    <center>
                                    <img src="" alt="" id="foto" name="foto" width="100px" height="120px">
                                </center>
                                </div>
                                </div>
                                <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="nim">NIM</label>
                                    <input type="nim" class="form-control" id="nim" name="nim" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" readonly>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="angkatan">Angkatan</label>
                                    <input type="text" class="form-control" id="angkatan" name="angkatan" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="status_pkl">Status PKL</label>
                                    <input type="text" class="form-control" id="status_pkl" name="status_pkl" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="prodi">Prodi</label>
                                    <input type="text" class="form-control" id="prodi" name="prodi" readonly>
                                </div>
                                </div>
                                <div class="form-row">
                                <div class="form-group col-md-6">
                                <label for="judul_skripsi">Judul</label>
                                <textarea name="judul_skripsi" id="judul_skripsi" cols="100" rows="3" class="form-control" readonly></textarea>
                                </div>
                                <div class="form-gorup col-md-6">
                                <label for="deskripsi_judul">Deskripsi Judul</label>
                                <textarea class="form-control" name="deskripsi_judul" id="deskripsi_judul" cols="100" rows="3" readonly></textarea>
                                </div>
                                </div>
                                <div class="form-row">
                                <!-- <div class="form-group col-md-6">
                                    <label for="status_judul">Status judul</label>
                                    <select id="status_judul" class="form-control" name="status_judul">
                                    <option readonly selected>Pilih..</option>
                                    <option value="Ditolak">Tolak</option>
                                    <option value="Disetujui">Setujui</option>
                                    </select>
                                </div> -->
                                <div class="form-group col-md-6">
                                    <label for="status_judul">Status judul</label>
                                    <input type="text" name="status_judul" id="status_judul" class="form-control" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                <label for="dosbing">Dosen Pembimbing</label>
                                    <select id="dosbing" class="form-control" name="dosbing" required="required">
                                    <option value="">Pilih..</option>
                                    <?php while ($d = mysqli_fetch_array($dosen)) {
                                    ?>
                                    <option value="<?= $d["nidn"]?>"><?= $d["nama_dosen"]?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <input type="id_judul" class="form-control" id="id_judul" name="id_judul" hidden readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <input type="tujuan" class="form-control" id="tujuan" name="tujuan" hidden readonly>
                                </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="verifikasi" id="verifikasi">Pilih</button>
                </div>
            </form>
            </div>
        </div>
        </div>
    </div>
    <!-- /. modal ubah -->
    
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
        $(document).on("click", "#detaildata", function(){
        let id = $(this).data('id');
        let nim = $(this).data('nim');
        let nama = $(this).data('nama');
        let angkatan = $(this).data('angkatan');
        let prodi = $(this).data('prodi');
        let foto = $(this).data('foto');
        let pkl = $(this).data('pkl');
        let judul = $(this).data('judul');
        let status = $(this).data('status');
        let deskripsi = $(this).data('deskripsi');
        let tujuan = $(this).data('tujuan');
        let sk = $(this).data('sk');
        $(".modal-body #studikasus").val(sk);
        $(".modal-body #id_judul").val(id);
        $(".modal-body #nim").val(nim);
        $(".modal-body #nama").val(nama);
        $(".modal-body #angkatan").val(angkatan);
        $(".modal-body #prodi").val(prodi);
        $(".modal-body #foto").attr('src', '../../assets/foto/'+foto)
        $(".modal-body #status_pkl").val(pkl);
        $(".modal-body #judul_skripsi").val(judul);
        $(".modal-body #status_judul").val(status);
        $(".modal-body #tujuan").val(tujuan);
        $(".modal-body #deskripsi_judul").val(deskripsi);
        });
            </script>
          </body>
        </html>