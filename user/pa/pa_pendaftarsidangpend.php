<?php
session_start();
require "../../koneksi.php";
if (!isset($_SESSION["login_pa"])) {
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
  windows.location.href('pendaftarsidangpend.php') 
  </script>";
}else{
$cekjadwal = mysqli_query($conn, "SELECT tgl_sidang, waktu_sidang, ruang_sidang 
                          FROM pend_sidang WHERE tgl_sidang='$tgl' AND waktu_sidang='$waktu' 
                          AND ruang_sidang='$ruang' AND status_sidang IS NULL");
$cekpenguji = mysqli_query($conn, "SELECT penguji, tgl_sidang, waktu_sidang, ruang_sidang 
                          FROM pend_sidang ps LEFT JOIN pend_penguji pp
                          ON ps.id_sidang=pp.id_sidang
                          WHERE (pp.penguji='$penguji1' OR pp.penguji='$penguji2')
                          AND tgl_sidang='$tgl' AND waktu_sidang='$waktu' 
                          AND status_sidang IS NULL");
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
windows.location.href('pendaftarsidangpend.php')
</script>";
}else{
if (mysqli_num_rows($cekjadwal)>0 OR mysqli_num_rows($cekpenguji)>0) {
echo "<script>
alert('Gagal Menjadwalkan Sidang, Terdapat jadwal dan atau penguji yang sama dalam satuw waktu')
windows.location.href('pendaftarsidangpend.php')
</script>";
}else{
mysqli_autocommit($conn, FALSE);

$sqljadwal = mysqli_query($conn, "UPDATE pend_sidang SET
                          tgl_sidang='$tgl',
                          waktu_sidang='$waktu',
                          ruang_sidang='$ruang' 
                          WHERE id_sidang='$id'") 
                          or die (mysqli_erorr($conn));

// masukan ke tbl proposal_penguji untuk penguji 1
$sqlpenguji1 = mysqli_query($conn, "INSERT INTO pend_penguji (id_sidang, penguji, status_penguji) VALUES ('$id', '$penguji1', '$p1' )") or die (mysqli_erorr($conn));
// masukan ke tbl_proposal_penguji untuk penguji 2
$sqlpenguji2 = mysqli_query($conn, "INSERT INTO pend_penguji (id_sidang, penguji, status_penguji) VALUES ('$id', '$penguji2', '$p2' )") or die (mysqli_erorr($conn));

$sqlnilai = mysqli_query($conn, "INSERT INTO pend_nilai (id_sidang) VALUES ('$id')");

if ($sqljadwal && $sqlpenguji1 && $sqlpenguji2 && $sqlnilai) {
mysqli_commit($conn);
echo "<script>
alert('Berhasil Menjadwalan Sidang')
windows.location.href('pendaftarsidangpend.php')
</script>";
}else {
mysqli_rollback($conn);
echo "<script>
alert('Gagal Menjadwalkan Sidang')
windows.location.href('pendaftarsidangpend.php')
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
    <title>Penjadwalan Sidang Pendadaran | SIM-PS | Penasihat Akademik</title>
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
            <!-- <h1 class="m-0 text-dark">Data Pendaftaran Sidang Pendadaran</h1> -->
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
                  <h1 class="m-0 text-dark">Penjadwalan Sidang Pendadaran</h1></center></div>
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
                        judul.judul,
                        (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd 
                        ON d1.nidn=sd.nidn 
                        WHERE sd.id_skripsi=s.id_skripsi LIMIT 0,1) AS pem1,
                        (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN skripsi_dosbing sd
                        ON d2.nidn=sd.nidn 
                        WHERE sd.id_skripsi=s.id_skripsi LIMIT 1,1) as pem2,
                        (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN draft_penguji dp
                        ON d1.nidn=dp.penguji 
                        WHERE dp.id_sidang=ds.id_sidang LIMIT 0,1) AS draft1,
                        (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN draft_penguji dp
                        ON d2.nidn=dp.penguji 
                        WHERE dp.id_sidang=ds.id_sidang LIMIT 1,1) as draft2,
                        ps.id_sidang, s.id_skripsi
                        FROM pend_sidang ps 
                        LEFT JOIN skripsi s
                        ON ps.id_skripsi=s.id_skripsi
                        LEFT JOIN proposal p
                        ON s.id_proposal=p.id_proposal
                        LEFT JOIN draft_sidang ds
                        ON s.id_skripsi=ds.id_skripsi
                        LEFT JOIN judul 
                        ON p.id_judul=judul.id_judul
                        LEFT JOIN mahasiswa mhs
                        ON judul.nim=mhs.nim
                        LEFT JOIN pend_penguji ppe
                        ON ps.id_sidang=ppe.id_sidang
                        WHERE (ps.val_dosbing1='2' AND ps.val_dosbing2='2' ) 
                        AND ppe.penguji IS NULL
                        AND ps.status_sidang IS NULL") or die (mysqli_error($conn));
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
                            <button type="submit" id="detaildata" class="btn btn-warning" data-toggle="modal" data-target="#modal-lg"
                            data-id="<?php echo $data1["id_sidang"] ?>"
                            data-idskripsi="<?php echo $data1["id_skripsi"] ?>"
                            data-nama="<?php echo $data1["nama"] ?>"
                            data-judul="<?php echo $data1["judul"] ?>"
                            data-dosbing1="<?php echo $data1["pem1"] ?>"
                            data-dosbing2="<?php echo $data1["pem2"] ?>"
                            data-peng1="<?php echo $data1["draft1"] ?>"
                            data-peng2="<?php echo $data1["draft2"] ?>"
                            data-tgl="<?php echo $data1["tgl_sid"] ?>"
                            data-penguji1="<?php echo $data1["penguji1"] ?>"
                            data-penguji2="<?php echo $data1["penguji2"] ?>"
                            data-ruang="<?php echo $data1["ruang_sid"] ?>"><i class="fas fa-cogs"></i></button>
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
                          <h4 class="modal-title">Penjadwalan Sidang Pendadaran</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form class="form-horizontal" method="post">
                            <div class="card-body">
                              <div class="form-group row">
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" id="id_sidang" name="id_sidang" required="required">
                                  <input type="text" class="form-control" id="id_skripsi" name="id_skripsi" required="required">
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
                                  <!-- <input type="text" class="form-control" id="judul_laporan" name="judul_laporan" required="required" readonly> -->
                                  <textarea name="judul_laporan" id="judul_laporan" cols="62" rows="2" class="form-control" readonly></textarea>
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="id_dosenwali1" class="col-sm-3 col-form-label">Pembimbing1</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" id="id_dosenwali1" name="id_dosenwali1" required="required" readonly>
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="id_dosenwali2" class="col-sm-3 col-form-label">Pembimbing2</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" id="id_dosenwali2" name="id_dosenwali2" required="required" readonly>
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="id_dosenwali3" class="col-sm-3 col-form-label">Penguji 1 Sidang Draft</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" id="id_dosenwali3" name="id_dosenwali3" required="required" readonly>
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="id_dosenwali4" class="col-sm-3 col-form-label">Penguji 2 Sidang Draft</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" id="id_dosenwali4" name="id_dosenwali4" required="required" readonly>
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
                                    <option disabled selected>Pilih Penguji...</option>
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
                                <label for="penguji2" class="col-sm-3 col-form-label">Pilih Penguji 2</label>
                                <div class="col-sm-9">
                                  <select class="form-control" name="penguji2" id="penguji2" required="required">
                                    <option disabled selected>Pilih Penguji...</option>
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
                                    <option disabled selected>Pilih</option>
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
                            <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="jadwalkan" id="jadwalkan">Jadwalkan</button>
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
      $(document).on("click", "#detaildata", function(){
      let id = $(this).data('id');
      let idskripsi = $(this).data('idskripsi');
      let nama = $(this).data('nama');
      let judul = $(this).data('judul');
      let dosbing1 = $(this).data('dosbing1');
      let dosbing2 = $(this).data('dosbing2');
      let tgl = $(this).data('tgl');
      let ruang = $(this).data('ruang');
      let peng1 = $(this).data('peng1');
      let peng2 = $(this).data('peng2');
      $(".modal-body #id_sidang").val(id);
      $(".modal-body #id_skripsi").val(idskripsi);
      $(".modal-body #nama").val(nama);
      $(".modal-body #judul_laporan").val(judul);
      $(".modal-body #id_dosenwali1").val(dosbing1);
      $(".modal-body #id_dosenwali2").val(dosbing2);
      $(".modal-body #id_dosenwali3").val(peng1);
      $(".modal-body #id_dosenwali4").val(peng2);
      $(".modal-body #tgl_sid").val(tgl);
      $(".modal-body #ruangsid").val(ruang);
      });
      </script>
    </body>
  </html>