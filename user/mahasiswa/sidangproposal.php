<?php
session_start();
require "../../koneksi.php";
if (!isset($_SESSION["login_mhs"])) {
  header("location:../../index.php");
  exit();
}
$nimm = $_SESSION["nim"];
$nim = $_SESSION["nim"];
$tanggal = date('Y-m-d');


//ambil data mahasiswa
$id = mysqli_query($conn, " SELECT mhs.nama AS nama,
mhs.nim AS nim, mhs.ttl AS ttl,
mhs.alamat_rumah AS alamat, mhs.no_hp AS hp,
judul.judul,
proposal.id_proposal
FROm mahasiswa mhs 
LEFT JOIN judul
ON mhs.nim=judul.nim
LEFT JOIN proposal  
ON judul.id_judul=proposal.id_judul
WHERE mhs.nim='$nim'") 
or die (mysqli_error($conn));
$getid = mysqli_fetch_array($id);

if (isset($_POST["sidang"])) {
  $idprop = $_POST["id_proposal"];
  $file = $_FILES["syarat"]["name"];
  $ukuran = $_FILES["syarat"]["size"];
  // cek apakah sidang belum terlaksana atau sudah lulus?
  $check = mysqli_query($conn,
  "SELECT * FROM proposal_sidang sidang 
  LEFT JOIN proposal 
  ON sidang.id_proposal=proposal.id_proposal
  LEFT JOIN judul 
  ON proposal.id_judul=judul.id_judul
  LEFT JOIN mahasiswa
  ON judul.nim=mahasiswa.nim 
  LEFT JOIN proposal_sidang_syarat ps
  ON sidang.id_sidang=ps.id_sidang
  WHERE mahasiswa.nim='$nim' AND (sidang.status_sidang='Lulus' OR sidang.status_sidang IS NULL)
  AND (sidang.val_dosbing='2' OR sidang.val_dosbing='0') AND (ps.status='2' OR ps.status='0')");
  if (mysqli_num_rows($check) > 0) {
    echo "<script>
    alert('Anda Belum Melaksanakan Sidang atau Anda Sudah Mengikuti Sidang dan Lulus !')
    windows.location.href('sidangproposal.php')
    </script>";
  }else{
    $ekstensi2 = array("pdf");
    $ambil_ekstensi1 = explode(".", $file);
    $eks = $ambil_ekstensi1[1];
    $newsyarat = $nim.'-'.$namefile.'-'.$file;
    $pathsyarat = '../../assets/syarat_sidang_proposal/'.$newsyarat;
    if (in_array($eks, $ekstensi2)) {
      if ($ukuran > 250000) {
        echo "<script>
        alert('Gagal Mengunggah Syarat Sidang, File Maximal 250 KB')
        windows.location.href='sidangproposal.php'
        </script>"; 
      }else{
        $file_tmp = $_FILES["syarat"]["tmp_name"];
        if (move_uploaded_file($file_tmp, $pathsyarat)) {
          $daftar = mysqli_query($conn, "INSERT INTO proposal_sidang (id_sidang, id_proposal) VALUES ('','$idprop')") or die (mysqli_erorr($conn));
          $id_sidang = mysqli_insert_id($conn);
          $syarat_sidang = mysqli_query($conn, "INSERT INTO proposal_sidang_syarat (file, status, id_sidang) VALUES ('$newsyarat', '0', '$id_sidang')") or die (mysqli_erorr($conn));
          if ($daftar && $syarat_sidang) {
            echo "<script>
            alert('Berhasil Melakukan Daftar Sidang')
            windows.location.href('sidangproposal.php')
            </script>";
          }else {
            echo "<script>
            alert('Gagal Melakukan Daftar Sidang')
            windows.location.href('sidangproposal.php')
            </script>";
          }
        }
      }
    }else{
      echo "<script>
      alert('Gagal Mengunggah File Persyaratan, File Harus PDF !')
      windows.location.href('sidangpkl.php')
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
  <title> Data Sidang Proposal | SIM-PS | Mahasiswa</title>
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
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
          </ul>
          <!-- <h1 class="m-0 text-dark">Data File Laporan Praktik Kerja Lapangan</h1> -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
    <?php
$a = mysqli_query($conn, "SELECT * FROM judul WHERE nim='$nim' AND status_judul='Disetujui'");
$b = mysqli_query($conn, "SELECT * FROM proposal_bim pb LEFT JOIN proposal p ON pb.id_proposal=p.id_proposal
LEFT JOIN judul j ON p.id_judul=j.id_judul
LEFT JOIN mahasiswa m ON j.nim=m.nim WHERE m.nim='$nim' AND status_bim='Layak' AND pb.status='Bimbingan Proposal'");
if (mysqli_num_rows($a)>0) {
  if (mysqli_num_rows($b)>0) {
    ?>
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="card-header">
            <center>
              <h1 class="m-0 text-dark">Data Sidang Proposal</h1><br>
            </center>
          </div>
          <button type="button" id="daftarsidang" class="btn btn-primary" data-toggle="modal" data-target="#modal-lg"
            data-id="<?php echo $getid["id_proposal"] ?>" data-nama="<?php echo $getid["nama"] ?>"
            data-nim="<?php echo $getid["nim"] ?>" data-ttl="<?php echo $getid["ttl"] ?>"
            data-alamat="<?php echo $getid["alamat"] ?>" data-hp="<?php echo $getid["hp"] ?>"
            data-judul="<?php echo $getid["judul"] ?>">
            <i class="fas fa-plus"></i> Daftar Sidang Proposal
          </button>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead align="center">
              <tr>
                <th width="160px">Penguji</th>
                <th width="65px">Waktu</th>
                <th width="100px">Ruangan</th>
                <th width="30px">Hasil</th>
                <th width="80px">Validasi Pembimbing</th>
                <th width="80px">Validasi Syarat</th>
              </tr>
            </thead>
            <tbody>
              <?php                        
    //ambi data sidang
    $datasidang = mysqli_query($conn,
    "SELECT
    -- penguji 1 foto
    (SELECT d1.foto_dosen FROM dosen d1 INNER JOIN proposal_penguji pp
    ON d1.nidn=pp.penguji WHERE pp.id_sidang=ps.id_sidang AND pp.status='Aktif' LIMIT 0,1) AS foto1,
    -- penguji 2 foto
    (SELECT d2.foto_dosen FROM dosen d2 INNER JOIN proposal_penguji pp
    ON d2.nidn=pp.penguji WHERE pp.id_sidang=ps.id_sidang AND pp.status='Aktif' LIMIT 1,1) AS foto2,
    -- penguji 1 nidn
    (SELECT d3.nidn FROM dosen d3 INNER JOIN proposal_penguji pp
    ON d3.nidn=pp.penguji WHERE pp.id_sidang=ps.id_sidang AND pp.status='Aktif' LIMIT 0,1) AS nidn1,
    -- penguji 2 nidn
    (SELECT d4.nidn FROM dosen d4 INNER JOIN proposal_penguji pp
    ON d4.nidn=pp.penguji WHERE pp.id_sidang=ps.id_sidang AND pp.status='Aktif' LIMIT 1,1) AS nidn2,
    -- penguji 1 nama
    (SELECT d5.nama_dosen FROM dosen d5 INNER JOIN proposal_penguji pp
    ON d5.nidn=pp.penguji WHERE pp.id_sidang=ps.id_sidang AND pp.status='Aktif' LIMIT 0,1) AS penguji1,
    -- penguji 2 nama
    (SELECT d6.nama_dosen FROM dosen d6 INNER JOIN proposal_penguji pp
    ON d6.nidn=pp.penguji WHERE pp.id_sidang=ps.id_sidang AND pp.status='Aktif' LIMIT 1,1) AS penguji2,
    mhs.nim, j.judul,
    ps.tgl_sidang AS tanggal, ps.ruang_sidang AS ruang, ps.status_sidang AS hasil, ps.waktu_sidang AS waktu,
    ps.val_dosbing, pss.status
    FROM proposal_sidang ps LEFT JOIN proposal p
    ON ps.id_proposal=p.id_proposal 
    LEFT JOIN judul j
    ON p.id_judul=j.id_judul
    LEFT JOIN mahasiswa mhs
    ON j.nim=mhs.nim
    LEFT JOIN proposal_sidang_syarat pss
    ON ps.id_sidang=pss.id_sidang
    WHERE mhs.nim='$nim' AND j.status_judul='Disetujui'") or die (mysqli_erorr($conn));
    if (mysqli_num_rows($datasidang) > 0) {
      while ($data=mysqli_fetch_array($datasidang)) {
        $tanggal = $data["tanggal"];
        $tgl = date('d-M-Y', strtotime($tanggal));
        if ($tanggal=="") {
          $tgl = "";
        }
        if ($data["val_dosbing"]==0) {
          $val ='Menunggu';
        }elseif ($data["val_dosbing"]==1) {
          $val ='Ditolak';
        }elseif ($data["val_dosbing"]==2) {
          $val ='Disetujui';
        }
        if ($data["status"]==0) {
          $status ='Menunggu';
        }elseif ($data["status"]==1) {
          $status ='Ditolak';
        }elseif ($data["status"]==2) {
          $status ='Disetujui';
        }
        $foto1 = $data["foto1"];
        $nidn1 = $data["nidn1"];
        $penguji1 = $data["penguji1"];
        $foto2 = $data["foto2"];
        $nidn2 = $data["nidn2"];
        $penguji2 = $data["penguji2"];
        
        ?>
              <tr>
                <td align="center">
                <?php
                if ($foto1=="" AND $nidn1=="" AND $penguji1=="" AND $foto2=="" AND $nidn2=="" AND $penguji2=="") {
                  echo 'Penguji Belum Dipilih'; 
                }else{
                ?>
                  <button type="button" id="pengujisidang" class="btn btn-primary" data-toggle="modal"
                    data-target="#modal-lg99" 
                    data-foto1="<?php echo $data["foto1"] ?>"
                    data-nidn1="<?php echo $data["nidn1"] ?>" 
                    data-penguji1="<?php echo $data["penguji1"] ?>"
                    data-foto2="<?php echo $data["foto2"] ?>" 
                    data-nidn2="<?php echo $data["nidn2"] ?>"
                    data-penguji2="<?php echo $data["penguji2"] ?>">
                    <i class="fas fa-info-circle"></i> Lihat Penguji
                  </button>
                <?php } ?>
                </td>
                <td align="center"><?php echo $tgl.'<br>'.$data["waktu"] ?></td>
                <td><?php echo $data["ruang"] ?></td>
                <td><?php echo $data["hasil"] ?></td>
                <td align="center"> <?php
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
                        <?= $val  ?></td>
                <td align="center"> <?php
              if ($status=="Menunggu") {
                ?>
                  <span class="badge badge-primary">
                    <?php } else if ($status=="Disetujui"){
                  ?>
                    <span class="badge badge-success">
                      <?php }else if ($status=="Ditolak"){
                    ?>
                      <span class="badge badge-danger">
                        <?php } ?>
                        <?= $status  ?></td>
              </tr>
              <?php  }
                  }
                  ?>
            </tbody>
          </table>
        </div>

        <!-- MODAL TAMBAH DATA MAHASISWA -->
        <div class="modal fade" id="modal-lg99">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Penguji Sidang</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="card-body">
                  <div class="card-body">
                  <!-- <center> -->
                  <div class="form-group row">
                    <div class="col-sm-12">
                      <center>
                      <h5>Penguji 1</h5>
                      <img src="" width="140px" height="150px" alt="" class="foto1">
                      </center>
                      <input type="text" class="form-control" id="penguji1" name="penguji1" required="required" readonly>
                      <input type="text" class="form-control" id="nidn1" name="nidn1" required="required" readonly>
                    </div>
                  </div>
                  <hr>
                  <div class="form-group row">
                    <div class="col-sm-12">
                      <center>
                      <h5>Penguji 2</h5>
                      <img src="" width="140px" height="150px" alt="" class="foto2">
                      </center>
                      <input type="text" class="form-control" id="penguji2" name="penguji2" required="required" readonly>
                      <input type="text" class="form-control" id="nidn2" name="nidn2" required="required" readonly>
                    </div>
                  </div>
                  <!-- </center> -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
<!-- /.MODAL TAMBAH DATA MAHASISWA -->

<!-- MODAL TAMBAH DATA MAHASISWA -->
<div class="modal fade" id="modal-lg">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Formulir Pendaftaran Sidang Sidang</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="card-body">
            <div class="form-group row">
              <div class="col-sm-9">
                <input type="text" class="form-control" id="id_proposal" name="id_proposal" required="required" hidden>
              </div>
            </div>
            <div class="form-group row">
              <label for="nama" class="col-sm-3 col-form-label">Nama</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="nama" name="nama" required="required" readonly>
              </div>
            </div>
            <div class="form-group row">
              <label for="nim" class="col-sm-3 col-form-label">NIM</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="nim" name="nim" required="required" readonly>
              </div>
            </div>
            <div class="form-group row">
              <label for="ttl" class="col-sm-3 col-form-label">Tempat, Tanggal Lahir</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="ttl" name="ttl" required="required" readonly>
              </div>
            </div>
            <div class="form-group row">
              <label for="alamat_rumah" class="col-sm-3 col-form-label">Alamat Rumah</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="alamat_rumah" name="alamat_rumah" required="required"
                  readonly>
              </div>
            </div>
            <div class="form-group row">
              <label for="no_hp" class="col-sm-3 col-form-label">No HP</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="no_hp" name="no_hp" required="required" readonly>
              </div>
            </div>
            <div class="form-group row">
              <label for="judul_laporan" class="col-sm-3 col-form-label">Judul Proposal</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="judul_laporan" name="judul_laporan" required="required"
                  readonly>
              </div>
            </div>
            <div class="form-group row">
              <label for="syarat" class="col-sm-3 col-form-label">Formulir Sidang</label>
              <div class="col-sm-9">
                <input type="file" id="syarat" name="syarat" required="required">
                <br>
                <small><b>PDF, Max Size 200kb</b></small>
              </div>
            </div>
          </div>
          <!-- /.card-body -->
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="sidang" id="sidang">Daftar
          Sidang</button>
      </div>
    </div>
    </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.MODAL TAMBAH DATA MAHASISWA -->

<!-- /.card-body -->
</div>
<!-- /.card -->
</div>
<!-- /.col -->
</div>
<!-- /.row -->
</section>
<!-- /.content -->
<?php }else{?>
<div class="alert alert-danger" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <b>Anda Belum Memiliki Judul Yang Disetujui Atau Anda Belum Mempunyai Judul, Silahkan Ajukan Judul Terlebih Dahulu</b>
</div>
<?php }}else{?>
<div class="alert alert-danger" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <b>Bimbingan Anda Belum Ada Yang Layak Untuk Sidang! Silahkan Hubungi Dosen Pembimbing Proposal Anda</b>
</div>
<?php } ?>
</div>
<!-- /.content-wrappeclude-- Control Sidebar -->
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
<!-- AdminLTE for emo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- page scrip
                      t -->
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
  $(document).on("click", "#daftarsidang", function () {
    let id = $(this).data('id');
    let nama = $(this).data('nama');
    let nim = $(this).data('nim');
    let alamat = $(this).data('alamat');
    let ttl = $(this).data('ttl');
    let hp = $(this).data('hp');
    let judul = $(this).data('judul');
    $(".modal-body #id_proposal").val(id);
    $(".modal-body #nama").val(nama);
    $(".modal-body #nim").val(nim);
    $(".modal-body #alamat_rumah").val(alamat);
    $(".modal-body #ttl").val(ttl);
    $(".modal-body #no_hp").val(hp);
    $(".modal-body #judul_laporan").val(judul);
  });

  // detail data mhs
  $(document).on("click", "#pengujisidang", function () {
    let foto1 = $(this).data('foto1');
    let foto2 = $(this).data('foto2');
    let nidn1 = $(this).data('nidn1');
    let nidn2 = $(this).data('nidn2');
    let penguji1 = $(this).data('penguji1');
    let penguji2 = $(this).data('penguji2');
    $("#modal-lg99 .foto1").attr("src", "../../assets/foto/" + foto1);
    $("#modal-lg99 .foto2").attr("src", "../../assets/foto/" + foto2);
    $("#modal-lg99 #nidn1").val(nidn1);
    $("#modal-lg99 #nidn2").val(nidn2);
    $("#modal-lg99 #penguji1").val(penguji1);
    $("#modal-lg99 #penguji2").val(penguji2);
  });
</script>
</body>

</html>