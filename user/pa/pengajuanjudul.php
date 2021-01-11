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
  $status = $_POST["status_judul"];
  $status1 = $_POST["status_judul"];  
  $pesan = $_POST["pesan"];
  $id = $_POST["id_judul"];
  $tujuan = $_POST["tujuan"];
  if ($status1==='Ditolak') {
    $verifikasi = mysqli_query($conn,"UPDATE judul SET 
    status_judul='$status',
    saran_judul='$pesan'
    WHERE id_judul='$id'") or die (mysqli_erorr($conn));
    if ($verifikasi) {
      echo "<script>
      alert('Judul Berhasil Diverifikasi')
      windows.location.href('pengajuanjudul.php')
      </script>";
    }else {
      echo "<script>
      alert('Judul Gagal Diverifikasi')
      windows.location.href('pengajuanjudul.php')
      </script>";
    }
  }else {
    $dosbing = $_POST["dosbing"];
    mysqli_autocommit($conn, FALSE);
    // kalo disetujui
    $verifikasi2 = mysqli_query($conn,"UPDATE judul SET 
    status_judul='$status',
    saran_judul='$pesan'
    WHERE id_judul='$id'") or die (mysqli_erorr($conn));
    $insertproposal = mysqli_query($conn,"INSERT INTO proposal (id_judul, dosbing)
    VALUES ('$id', '$dosbing')") or die (mysqli_erorr($conn));
    $id_prop = mysqli_insert_id($conn);
    $insertskripsi = mysqli_query($conn, "INSERT INTO skripsi (id_proposal) 
    VALUES ('$id_prop')") or die (mysqli_error($conn)); 
    // mysqli_commit($conn);
    
    if ($verifikasi2 && $insertproposal && $insertskripsi) {
      mysqli_commit($conn);
      echo "<script>
      alert('Judul Berhasil Diverifikasi')
      windows.location.href('pengajuanjudul.php')
      </script>";
    }else {
      mysqli_rollback($conn);
      echo "<script>
      alert('Judul Gagal Diverifikasi')
      windows.location.href('pengajuanjudul.php')
      </script>"; 
      // mysqli_rollback($conn);
    }
  }
}

if (isset($_POST["tambah"])) {
  $status = $_POST["status_judul"];
  $status1 = $_POST["status_judul"];  
  $pesan = $_POST["pesan"];
  $id = $_POST["id_judul"];
  $tujuan = $_POST["tujuan"];
  $nim = $_POST["nim"];
  // var_dump($nim)
  $cek = mysqli_query($conn, "SELECT * FROM judul WHERE nim='$nim' AND status_judul='Disetujui'");
  if (mysqli_num_rows($cek)>0) {
    echo "<script>
    alert('Mahasiswa Ini Sudah Mempunyai Judul Yang Disetujui, Gagal Mengubah Verifikasi Judul')
    windows.location.href('pengajuanjudul.php')
    </script>";
  }else{
    $verifikasix = mysqli_query($conn,"UPDATE judul SET 
    status_judul='$status',
    saran_judul='$pesan'
    WHERE id_judul='$id'") or die (mysqli_erorr($conn));
    if ($verifikasix) {
      echo "<script>
      alert('Berhasil Mengubah Verifkasi Judul')
      windows.location.href('pengajuanjudul.php')
      </script>";
    }else{
      echo "<script>
      alert('Berhasil Mengubah Verifkasi Judul')
      windows.location.href('pengajuanjudul.php')
      </script>";
    }
  }
}

$dosen = mysqli_query($conn, "SELECT * FROM dosen WHERE jabatan IS NOT NULL") or die (mysqli_error($conn));

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Pengaju Judul | SIM-PS | Penasihat Akademik</title>
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
          <!-- <h1 class="m-0 text-dark">Daftar Pengaju Judul Skripsi</h1> -->
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
              <h2 class="m-0 text-dark">Daftar Pengaju Judul Skripsi</h2>
            </center>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example3" class="table table-bordered table-striped">
              <thead align="center">
                <tr>
                  <th width="50px">NIM</th>
                  <th width="200px">Nama</th>
                  <th width="50px">Angkatan</th>
                  <th width="300px">Judul Skripsi</th>
                  <th width="50px">Status</th>
                  <th width="50px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php 
//ambi data judul semua join mahasiswa
$getdata = mysqli_query($conn, 
"SELECT * FROM judul LEFT JOIN mahasiswa
ON judul.nim=mahasiswa.nim
WHERE status_judul='Menunggu' AND tujuan='$nidn'") 
or die (mysqli_erorr($conn));
if (mysqli_num_rows($getdata) > 0) {
  while ($data=mysqli_fetch_array($getdata)) {
    ?>
                <tr>
                  <td><?= $data["nim"]?></td>
                  <td><?= $data["nama"]?></td>
                  <td><?= $data["angkatan"]?></td>
                  <td><?= $data["judul"]?></td>
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
                      data-id="<?php echo $data['id_judul'];?>" data-nim="<?php echo $data['nim'];?>"
                      data-nama="<?php echo $data['nama'];?>" data-angkatan="<?php echo $data['angkatan'];?>"
                      data-prodi="<?php echo $data['prodi'];?>" data-foto="<?php echo $data['foto'];?>"
                      data-pkl="<?php echo $data['status_pkl'];?>" data-judul="<?php echo $data['judul'];?>"
                      data-status="<?php echo $data['status_judul'];?>" data-tujuan="<?php echo $data['tujuan'];?>"
                      data-deskripsi="<?php echo $data['deskripsi_judul'];?>"
                      data-sk="<?php echo $data['studi_kasus'];?>">Aksi
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


  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <center>
              <h2 class="m-0 text-dark">Riwayat Verfikasi Judul</h2>

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
                  <th width="50px">Status</th>
                  <th width="50px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php 
        //ambi data judul semua join mahasiswa
        $getdata = mysqli_query($conn, 
        "SELECT * FROM mahasiswa LEFT JOIN judul
        ON judul.nim=mahasiswa.nim
        WHERE (status_judul='Disetujui' OR status_judul='Ditolak') AND tujuan='$nidn'") 
        or die (mysqli_erorr($conn));
        if (mysqli_num_rows($getdata) > 0) {
          while ($data=mysqli_fetch_array($getdata)) {
            ?>
                <tr>
                  <td><?= $data["nim"]?></td>
                  <td><?= $data["nama"]?></td>
                  <td><?= $data["angkatan"]?></td>
                  <td><?= $data["judul"]?></td>
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
                    <button class="btn-sm btn-dark" id="detaildata1" data-toggle="modal" data-target="#modal-lg31"
                      data-id="<?php echo $data['id_judul'];?>" data-nim="<?php echo $data['nim'];?>"
                      data-nama="<?php echo $data['nama'];?>" data-angkatan="<?php echo $data['angkatan'];?>"
                      data-prodi="<?php echo $data['prodi'];?>" data-foto="<?php echo $data['foto'];?>"
                      data-pkl="<?php echo $data['status_pkl'];?>" data-judul="<?php echo $data['judul'];?>"
                      data-status="<?php echo $data['status_judul'];?>" data-tujuan="<?php echo $data['tujuan'];?>"
                      data-deskripsi="<?php echo $data['deskripsi_judul'];?>"
                      data-sk="<?php echo $data['studi_kasus'];?>"><i class="fas fa-edit"></i>
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

  <!-- modal ubah -->
  <div class="modal fade" id="modal-lg3">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-tittle">Form Verifikasi Judul Mahasiswa</h4>
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
                  <input type="text" class="form-control" id="angkatan" name="angkatan" readonly="">
                </div>
                <div class="form-group col-md-2">
                  <label for="status_pkl">Status PKL</label>
                  <input type="text" class="form-control" id="status_pkl" name="status_pkl" readonly="">
                </div>
                <div class="form-group col-md-3">
                  <label for="prodi">Prodi</label>
                  <input type="text" class="form-control" id="prodi" name="prodi" readonly="">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="judul_skripsi">Judul</label>
                  <textarea name="judul_skripsi" id="judul_skripsi" cols="100" rows="3" class="form-control"
                    readonly></textarea>
                </div>
                <div class="form-gorup col-md-6">
                  <label for="deskripsi_judul">Deskripsi Judul</label>
                  <textarea class="form-control" name="deskripsi_judul" id="deskripsi_judul" cols="100" rows="3"
                    readonly></textarea>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="status_judul">Status judul</label>
                  <select id="status_judul" class="form-control" name="status_judul" required>
                    <option value="">Pilih..</option>
                    <option value="Ditolak">Tolak</option>
                    <option value="Disetujui">Setujui</option>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="dosbing">Dosen Pembimbing</label>
                  <select id="dosbing" class="form-control" name="dosbing" required>
                    <option value="">Pilih..</option>
                    <?php while ($d = mysqli_fetch_array($dosen)) {
                  ?>
                    <option value="<?= $d["nidn"]?>"><?= $d["nama_dosen"]?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="nim">Pesan</label>
                  <textarea name="pesan" id="pesan" cols="100" rows="2" class="form-control" required></textarea>
                  <small id="emailHelp" class="form-text text-muted">
                </div>
              </div>
              <div class="form-group col-md-2">
                <input type="id_judul" class="form-control" id="id_judul" name="id_judul" hidden>
              </div>
              <div class="form-group col-md-2">
                <input type="tujuan" class="form-control" id="tujuan" name="tujuan" hidden>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="verifikasi"
                id="verifikasi">Ubah</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- /. modal ubah -->

  <!-- modal ubah -->
  <div class="modal fade" id="modal-lg31">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-tittle">Ubah Verifikasi Judul</h4>
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
                  <textarea name="judul_skripsi" id="judul_skripsi" cols="100" rows="3" class="form-control"
                    readonly></textarea>
                </div>
                <div class="form-gorup col-md-6">
                  <label for="deskripsi_judul">Deskripsi Judul</label>
                  <textarea class="form-control" name="deskripsi_judul" id="deskripsi_judul" cols="100" rows="3"
                    readonly></textarea>
                </div>
              </div>
              <div class="form-row">
              <div class="form-group col-md-6">
                <label for="verifikasi">Status Verifikasi</label>
                <input type="text" class="form-control" id="verifikasi" name="verifikasi" readonly>
              </div>
                <div class="form-group col-md-6">
                  <label for="status_judul">Verifikasi Judul Baru</label>
                  <select id="status_judul" class="form-control" name="status_judul">
                    <option value="">Pilih..</option>
                    <option value="Ditolak">Tolak</option>
                    <option value="Disetujui">Setujui</option>
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="nim">Pesan</label>
                  <textarea name="pesan" id="pesan" cols="100" rows="2" class="form-control" required></textarea>
                  <small id="emailHelp" class="form-text text-muted">
                </div>
              </div>
              <div class="form-group col-md-2">
                <input type="id_judul" class="form-control" id="id_judul" name="id_judul" hidden>
              </div>
              <div class="form-group col-md-2">
                <input type="tujuan" class="form-control" id="tujuan" name="tujuan" hidden>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="tambah"
                id="tambah">Ubah Verifikasi</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- /. modal ubah -->
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
    $("#modal-lg3 #studikasus").val(sk);
    $("#modal-lg3 #id_judul").val(id);
    $("#modal-lg3 #nim").val(nim);
    $("#modal-lg3 #nama").val(nama);
    $("#modal-lg3 #angkatan").val(angkatan);
    $("#modal-lg3 #prodi").val(prodi);
    $("#modal-lg3 #foto").attr('src', '../../assets/foto/' + foto)
    $("#modal-lg3 #status_pkl").val(pkl);
    $("#modal-lg3 #judul_skripsi").val(judul);
    $("#modal-lg3 #tujuan").val(tujuan);
    $("#modal-lg3 #deskripsi_judul").val(deskripsi);
  });

  // detail data
  $(document).on("click", "#detaildata1", function () {
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
    $("#modal-lg31 #studikasus").val(sk);
    $("#modal-lg31 #id_judul").val(id);
    $("#modal-lg31 #nim").val(nim);
    $("#modal-lg31 #nama").val(nama);
    $("#modal-lg31 #angkatan").val(angkatan);
    $("#modal-lg31 #prodi").val(prodi);
    $("#modal-lg31 #foto").attr('src', '../../assets/foto/' + foto)
    $("#modal-lg31 #status_pkl").val(pkl);
    $("#modal-lg31 #judul_skripsi").val(judul);
    $("#modal-lg31 #status_judul").val(status);
    $("#modal-lg31 #tujuan").val(tujuan);
    $("#modal-lg31 #deskripsi_judul").val(deskripsi);
    $("#modal-lg31 #verifikasi").val(status);
  });
</script>
</body>

</html>