<?php
session_start();
if (!isset($_SESSION["login_dosen"])) {
  if (!isset($_SESSION["login_kaprodi"])){
    if (!isset($_SESSION["login_pa"])) {
      header("location:../../index.php");
      exit();
    }
  }
}
require "../../koneksi.php";
$nidn = $_SESSION["nidn"];
// ambil data bimbingan mahasiswa
$getbim = mysqli_query($conn, "SELECT * FROM skripsi_bim WHERE pembimbing='$nidn'") or die (mysqli_erorr($conn));
// kirim hasil bimbingan
if (isset($_POST["hasilbim"])) {
  $ekstensi = array("pdf");
  $hasilbim = $_FILES["file_hasilbim"]["name"];
  $ukuran = $_FILES["file_hasilbim"]["size"];
  $ambil_ekstensi = explode(".", $hasilbim);
  $eks = $ambil_ekstensi[1];
  $tgl=date('Y-m-d');
  $idbim=$_POST["id"];
  $newfile = $nidn.'-'.$namefile.'-'.$hasilbim;
  $savepath = '../../assets/bim_draft_dosen/'.$newfile;
  $pesan = $_POST["pesan"];
  $status = $_POST["status_bim"];
  $read = 'Dibalas';
  $n='Belum Dibaca';
  if (in_array($eks, $ekstensi)) {
    if ($ukuran > 20000000) {
      echo "<script>
      alert('Gagal Meunggah File, Maximal Size 20 MB')
      windows.location.href='b_bimbingandraft.php'
      </script>";
    }else{
      $tmp_hasilbim = $_FILES["file_hasilbim"]["tmp_name"];
      if (move_uploaded_file($tmp_hasilbim, $savepath)) {
        $send = mysqli_query($conn, "UPDATE skripsi_bim SET
        file_hasilbim='$newfile',
        tgl_hasil='$tgl',
        saran='$pesan',
        status_bim='$status',
        status_dosbing='$read',
        status_mhs='$n'
        WHERE id_bim='$idbim'") or die (mysqli_erorr($conn));
        if ($send) {
          echo "<script>
          alert('Hasil Bimbingan Terkirim !')
          windows.location.href='b_bimbingandraft.php'
          </script>";
        }else {
          echo "<script>
          alert('Hasil Bimbingan Gagal Terkirim !')
          windows.location.href='b_bimbingandraft.php'
          </script>";
        }
      }else {
        echo "<script>
        alert('File Hasil Bimbingan Gagal di Unggah !')
        windows.location.href='b_bimbingandraft.php'
        </script>";
      }
    }
  }else {
    echo "<script>
    alert('File yang diupload bukan PDF')
    windows.location.href='b_bimbingandraft.php'
    </script>";
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Data Bimbingan Draft | SIM-PS | Dosen</title>
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
<?php 
if (isset($_SESSION["login_kaprodi"])) {
  include '../kaprodi/assets/header.php';
}elseif (isset($_SESSION["login_pa"])) {
  include '../pa/assets/header.php';
}elseif (isset($_SESSION["login_dosen"])) {
  include 'assets/header.php';
} ?>
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
              <h1 class="m-0 text-dark">Data Bimbingan Skripsi Belum Dibalas</h1>
            </center>
          </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead align="center">
                <tr>
                  <th>NIM</th>
                  <th>Nama</th>
                  <th>Judul</th>
                  <th>Tanggal</th>
                  <th>Subjek</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
//ambi data bimbingan
$getdata = mysqli_query($conn,
"SELECT DISTINCT
mhs.nim, mhs.nama, mhs.foto,
j.judul,
bim.tgl_bim, bim.subjek, bim.status_bim,
bim.id_bim AS id, bim.file_bim, bim.file_hasilbim, bim.deskripsi, bim.saran
,bim.status, bim.status_dosbing, bim.pembimbing,
-- pem1
(SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd
ON d1.nidn=sd.nidn WHERE sd.id_skripsi=s.id_skripsi AND status_dosbing='Pembimbing 1'
AND sd.status='Aktif' LIMIT 0,1) AS pem1,
-- pem2
(SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd
ON d1.nidn=sd.nidn WHERE sd.id_skripsi=s.id_skripsi AND status_dosbing='Pembimbing 2'
AND sd.status='Aktif' LIMIT 0,1) AS pem2
FROM skripsi_bim bim LEFT JOIN skripsi s
ON bim.id_skripsi=s.id_skripsi
LEFT JOIN proposal p
ON s.id_proposal=p.id_proposal
LEFT JOIN judul j
ON p.id_judul=j.id_judul
LEFT JOIN mahasiswa mhs
ON j.nim=mhs.nim
WHERE bim.pembimbing='$nidn' AND bim.status_dosbing='Belum Dibaca' AND bim.status='Bimbingan Draft'")
or die (mysqli_erorr($conn));
if (mysqli_num_rows($getdata) > 0) {
  while ($data=mysqli_fetch_array($getdata)) {
    $nim = $data["nim"];
    $id = base64_encode($nim);
    ?>
                <tr>
                  <td><?= $data['nim'] ?></td>
                  <td><a href="detailbimdraft.php?id=<?= $id  ?>"><?= $data['nama'] ?></a></td>
                  <td><?= $data['judul']?></td>
                  <td><?= $data['tgl_bim']?></td>
                  <td><?= $data['subjek'] ?></td>
                  <td align="center">
                    <?php
    if ($data["status_dosbing"]=="Belum Dibaca") {
      ?>
                    <span class="badge badge-danger">
                      <?php } else if ($data["status_dosbing"]=="Dibalas"){
        ?>
                      <span class="badge badge-success">
                        <?php }else if ($data["status_dosbing"]=="Dibaca"){
          ?>
                        <span class="badge badge-primary">
                          <?php } ?>
                          <?= $data['status_dosbing'] ?>
                  </td>
                  <td align="center">
                    <button type="submit" class="btn-sm btn-dark" name="detail" data-toggle="modal"
                      data-target="#modal-lg" id="detaildata" data-id="<?php echo $data["id"]?>"
                      data-nim="<?php echo $data["nim"]?>" data-nama="<?php echo $data["nama"]?>"
                      data-foto="<?php echo $data["foto"]?>" data-judul="<?php echo $data["judul"]?>"
                      data-filebim="<?php echo $data["file_bim"]?>" data-hasilbim="<?php echo $data["file_hasilbim"]?>"
                      data-tanggal_bim="<?php echo $data["tgl_bim"]?>" data-subjek="<?php echo $data["subjek"]?>"
                      data-desk="<?php echo $data["deskripsi"]?>" data-pesan="<?php echo $data["saran"]?>"
                      data-status="<?php echo $data["status_bim"]?>"
                      data-status_dosbing="<?php echo $data["status_dosbing"]?>" data-pem1="<?php echo $data["pem1"]?>"
                      data-pem2="<?php echo $data["pem2"]?>">
                      <i class="fas fa-edit"></i></button>
                  </td>
                </tr>
                <?php }
        }
        ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- data mahasiswa bimbingan -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <!-- <h1 class="m-0 text-dark">Data Bimbingan Proposal Mahasiswa</h1> -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <center>
              <h1 class="m-0 text-dark">Data Bimbingan Draft Mahasiswa</h1>
            </center>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example3" class="table table-bordered table-striped">
              <thead align="center">
                <tr>
                  <th>NIM</th>
                  <th>Nama</th>
                  <th>Judul</th>
                </tr>
              </thead>
              <tbody>
                <?php
        //ambi data bimbingan
        $getdata = mysqli_query($conn,
        "SELECT DISTINCT
        mhs.nim, mhs.nama, mhs.foto,
        j.judul,
        bim.tgl_bim, bim.subjek, bim.status_bim,
        bim.id_bim AS id, bim.file_bim, bim.file_hasilbim, bim.deskripsi, bim.saran
        ,bim.status, bim.status_dosbing, bim.pembimbing
        FROM skripsi_bim bim LEFT JOIN skripsi s
        ON bim.id_skripsi=s.id_skripsi
        LEFT JOIN proposal p
        ON s.id_proposal=p.id_proposal
        LEFT JOIN judul j
        ON p.id_judul=j.id_judul
        LEFT JOIN mahasiswa mhs
        ON j.nim=mhs.nim
        WHERE bim.pembimbing='$nidn' AND bim.status='Bimbingan Draft'
        GROUP by mhs.nim")
        or die (mysqli_erorr($conn));
        if (mysqli_num_rows($getdata) > 0) {
          while ($data=mysqli_fetch_array($getdata)) {
            $nim1 = $data["nim"];
            $id1 = base64_encode($nim1);
            ?>
                <tr>
                  <td><?= $data['nim'] ?></td>
                  <td><a href="detailbimdraft.php?id=<?= $id1  ?>"><?= $data['nama'] ?></a></td>
                  <td><?= $data['judul']?></td>
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
<!-- modal detail bimbingan -->
<div class="modal fade" id="modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <style>
          .modal-header,
          .modal-footer {
            background-color: #292929;
            color: #FFFFFF;
          }
        </style>
        <h5 class="modal-title" id="exampleModalLabel">Detail Bimbingan Draft</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- form body modal -->
        <form action="" method="post" enctype="multipart/form-data">
          <div class="form-row">
            <div class="form-group col-md-12">
              <center>
                <img src="" alt="" width="120" height="150" id="foto">
              </center>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4">
              <input type="text" class="form-control" id="id" name="id" hidden>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="nim">NIM</label>
              <input type="text" class="form-control" id="nim" name="nim" readonly>
            </div>
            <div class="form-group col-md-6">
              <label for="nama">Nama</label>
              <input type="text" class="form-control" id="nama" name="nama" readonly>
            </div>
            <div class="form-group col-md-2">
              <label for="filebim">File Bimbingan</label>
              <br>
              <a class="btn-sm btn-primary" href="" id="filebim" name="filebim">Unduh</a>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="desk">Materi Bimbingan</label>
              <input type="text" class="form-control" id="desk" name="desk" readonly>
            </div>
            <div class="form-group col-md-3">
              <label for="subjek">Subjek Bimbingan</label>
              <input type="text" class="form-control" id="subjek" name="subjek" readonly>
            </div>
            <div class="form-group col-md-3">
              <label for="tanggal">Tanggal Bimbingan</label>
              <input type="text" class="form-control" id="tanggal" name="tanggal" readonly>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="judul">Judul Laporan</label>
              <input type="text" class="form-control" id="judul" name="judul" readonly>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="pem1">Dosen Pembimbing 1</label>
              <input type="text" class="form-control" id="pem1" name="pem1" readonly>
            </div>
            <div class="form-group col-md-6">
              <label for="pem2">Dosen Pembimbing 2</label>
              <input type="text" class="form-control" id="pem2" name="pem2" readonly>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-3">
              <label for="file_hasilbim">File Hasil Bimbingan</label>
              <input type="file" id="file_hasilbim" name="file_hasilbim" required>
              <br>
              <small><b>PDF, Max File Size 20 MB</b></small>
            </div>
            <div class="form-group col-md-6">
              <label for="pesan">Pesan</label>
              <textarea name="pesan" id="pesan" cols="1" rows="1" class="form-control" required></textarea>
            </div>
            <!-- <div class="form-group col-md-3">
          <label for="tgl_sid">Tanggal Sidang</label>
          <input type="text" class="form-control" id="tgl_sid" name="tgl_sid" readonly>
          </div>
          <div class="form-group col-md-3">
          <label for="waktu">Waktu Sidang</label>
          <input type="text" class="form-control" id="waktu" name="waktu" readonly>
          </div>
          <div class="form-group col-md-3">
          <label for="ruang_sid">Ruang Sidang</label>
          <input type="text" class="form-control" id="ruang_sid" name="ruang_sid" readonly>
          </div> -->
            <div class="form-group col-md-3">
              <label for="status_bim">Hasil Bimbingan</label>
              <select id="status_bim" class="form-control" name="status_bim" required>
                <option value="">Pilih...</option>
                <option value="Revisi">Revisi</option>
                <option value="Lanjut BAB">Lanjut Bab Selanjutnya</option>
                <option value="Layak">Layak / Sidang</option>
              </select>
            </div>
          </div>
          <!-- /.card-body -->
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="hasilbim"
              id="hasilbim">Kirim</button>
          </div>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- /. modal detail bimbingan -->
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
  // detail data
  $(document).on("click", "#detaildata", function () {
    let foto = $(this).data('foto');
    let nim = $(this).data('nim');
    let nama = $(this).data('nama');
    let filebim = $(this).data('filebim');
    let hasilbim = $(this).data('hasilbim');
    let pesan = $(this).data('pesan');
    let subjek = $(this).data('subjek');
    let tanggalbim = $(this).data('tanggal_bim');
    let judul = $(this).data('judul');
    let pembimbing = $(this).data('dosbing');
    let status = $(this).data('status');
    let id = $(this).data('id');
    let desk = $(this).data('desk');
    let pem1 = $(this).data('pem1');
    let pem2 = $(this).data('pem2');
    $("#modal-lg #pem1").val(pem1);
    $("#modal-lg #pem2").val(pem2);
    $("#modal-lg #desk").val(desk);
    $("#modal-lg #nim").val(nim);
    $("#modal-lg #nama").val(nama);
    $("#modal-lg #filebim").attr("href", "assets/downloadbimdraft.php?filename=" + filebim);
    $("#modal-lg #file_hasilbim").attr("href", "assets/downloadhasilbimdraft.php?filename=" + hasilbim);
    $("#modal-lg #pesan1").val(pesan);
    $("#modal-lg #subjek").val(subjek);
    $("#modal-lg #tanggal").val(tanggalbim);
    $("#modal-lg #judul").val(judul);
    $("#modal-lg #pembimbing").val(pembimbing);
    $("#modal-lg #status_bim1").val(status);
    $("#modal-lg #id").val(id);
    $("#modal-lg #foto").attr("src", "../../assets/foto/" + foto);
  });
</script>
</body>

</html>