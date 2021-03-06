<?php
session_start();
if (!isset($_SESSION["login_tu"])) {
header("location:../../index.php");
exit();
}
require "../../koneksi.php";
// ambil data bimbingan mahasiswa
// $getbim = mysqli_query($conn, "SELECT * FROM pkl_bim LEFT JOIN pkl ON pkl_bim.id_pkl=pkl.id_pkl LEFT JOIN dosen_wali ON pkl.id_dosenwali=dosen_wali.id_dosenwali LEFT JOIN dosen ON dosen_wali.nidn=dosen.nidn WHERE dosen.nidn='$nidn' AND status='Bimbingan Laporan'") or die (mysqli_erorr($conn));

// ambil id BImbingan di get
if (isset($_GET["id"])) {
$decode = base64_decode($_GET["id"]);
}
// echo $decode;
//ambi data bimbingan
$getdataa = mysqli_query($conn, 
"SELECT DISTINCT 		
mahasiswa.nama, mahasiswa.nim, mahasiswa.foto,
judul.judul,
judul.studi_kasus,
sf.jurnal_pdf, sf.id_file,
(SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd 
ON d1.nidn=sd.nidn 
WHERE sd.id_skripsi=s.id_skripsi LIMIT 0,1) AS pem1, 
(SELECT d2.nama_dosen FROM dosen d2 INNER JOIN skripsi_dosbing sd
ON d2.nidn=sd.nidn 
WHERE sd.id_skripsi=s.id_skripsi LIMIT 1,1) as pem2 
FROM skripsi_file sf LEFT JOIN skripsi s
ON sf.id_skripsi=s.id_skripsi
LEFT JOIN skripsi_dosbing sd
ON s.id_skripsi=sd.id_skripsi
LEFT JOIN proposal
ON s.id_proposal=proposal.id_proposal
LEFT JOIN judul
ON proposal.id_judul=judul.id_judul
LEFT JOIN mahasiswa
ON judul.nim=mahasiswa.nim
WHERE sf.id_file='$decode'") or die (mysqli_erorr($conn));
$data1 = mysqli_fetch_array($getdataa);

// $getdata = mysqli_query($conn,
// "SELECT d1.nama_dosen AS pembimbing,
// mhs.nim AS nim, 
// mhs.nama AS nama, 
// mhs.foto AS foto,
// pkl.judul_laporan AS judul, pkl.lem_rev,
// bim.file_bim AS filebim, 
// bim.file_hasilbim AS hasilbim,
// bim.tanggal AS tanggal_bim, 
// bim.subjek AS subjek_bim,
// bim.deskripsi AS deskripsi_bim, 
// bim.pesan AS pesan_bim,
// bim.status_bim AS status_bim, 
// bim.status_dosbing AS dosbing,
// bim.id_bimPKL AS id
// FROM pkl_bim bim LEFT JOIN pkl
// ON bim.id_pkl=pkl.id_pkl
// LEFT JOIN dosen_wali
// ON pkl.id_dosenwali=dosen_wali.id_dosenwali
// LEFT JOIN dosen d1
// ON pkl.id_dosenwali=d1.nidn
// LEFT JOIN mahasiswa mhs
// ON pkl.nim=mhs.nim
// WHERE bim.nidn='$nidn'AND bim.status='Bimbingan Laporan' AND bim.nim='$decode' ORDER BY bim.tanggal DESC") or die (mysqli_erorr($conn));

// if (isset($_POST["ubahbim"])) {
//   $id = $_POST["id"];
//   $pesan = $_POST["pesan"];
//   $hasil = $_POST["status_bim2"];
//   $n = 'Belum Dibaca';
//   $ekstensi2 = array("doc", "docx", "ppt", "pptx", "rar", "zip", "pdf");
//   $filebim= $_FILES["file_hasilbim"]["name"];
//   // var_dump($filebim); die;
//  if (empty($filebim)) {
//     $sql = mysqli_query($conn, "UPDATE pkl_bim SET pesan='$pesan', status_bim='$hasil', status_mhs='$n'
//                         WHERE id_bimPKL='$id'");
//     if ($sql) {
//       echo "<script>
//     alert('Bimbingan Berhasil diubah tanpa perubahan pada file bimbingan')
//     windows.location.href='bimbinganpkl.php'
//     </script>";
//     }else {
//       echo "<script>
//       alert('Bimbingan Gagal diubah')
//       windows.location.href='bimbinganpkl.php'
//       </script>";
//     } 
//   }else {
//     $ambil_ekstensi1 = explode(".", $filebim);
//     $eks = $ambil_ekstensi1[1];
//     $newfilebim = $nidn.'-'.$filebim;
//     $pathfilebim = '../../assets/dosen_bimPKL/'.$newfilebim;
//     $filelama = mysqli_query($conn, "SELECT file_hasilbim FROM pkl_bim WHERE id_bimPKL='$id'");
//     $d = mysqli_fetch_array($filelama);
//     if (in_array($eks, $ekstensi2)) {
//     $filebim_tmp = $_FILES["file_hasilbim"]["tmp_name"];
//     if (move_uploaded_file($filebim_tmp, $pathfilebim)) {
//     unlink('../../assets/dosen_bimPKL/'.$d["file_hasilbim"]);
//     $tambahbim = mysqli_query($conn, "UPDATE pkl_bim SET pesan='$pesan', status_bim='$hasil',
//                             file_hasilbim='$newfilebim', status_mhs='$n'
//                             WHERE id_bimPKL='$id'") or die (mysqli_error($conn));
//     if ($tambahbim) {
//     echo "<script>
//     alert('Berhasil Mengubah Bimbingan!')
//     windows.location.href='bimbinganpkl.php'
//     </script>";
//     }else {
//     echo "<script>
//     alert('Gagal Mengubah Bimbingan!')
//     windows.location.href='bimbinganpkl.php'
//     </script>";
//     }
//     }
//     }else {
//     echo "<script>
//     alert('Gagal Melakukan Bimbingan, File yang harus di unggah hanya bisa doc, docx, ppt, pptx, rar, pdf, atau zip!')
//     windows.location.href='bimbinganpkl.php'
//     </script>";    
//     }
//     }
//   }

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Detail File Laporan PKL | SIM-PS | Tata Usaha</title>
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
              <a href="fileskripsi.php" class="btn btn-warning">Kembali</a>
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
          <!-- /.card-header -->
          <div class="card-body">
            <table align="center">
              <tr>
                <td colspan="3" align="center">
                  <img src="../../assets/foto/<?= $data1["foto"]?>" alt="foto mahasiswa" width="130px" height="130px">
                </td>
              </tr>
              <tr>
                <td colspan="3">
                  <hr>
                </td>
              </tr>
              <tr>
                <td align="left">
                  <h5>Nama</h5>
                </td>
                <td align="left">
                  <h5>:</h5>
                </td>
                <td>
                  <h5><?= $data1["nama"] ?></h5>
                </td>
              </tr>
              <tr>
                <td colspan="3">
                  <hr>
                </td>
              </tr>
              <tr>
                <td align="left">
                  <h5>NIM</h5>
                </td>
                <td align="left">
                  <h5>:</h5>
                </td>
                <td>
                  <h5><?= $data1["nim"] ?></h5>
                </td>
              </tr>
              <tr>
                <td colspan="3">
                  <hr>
                </td>
              </tr>
              <tr>
                <td align="left">
                  <h5>Pemb1</h5>
                </td>
                <td align="left">
                  <h5>:</h5>
                </td>
                <td>
                  <h5><?= $data1["pem1"] ?></h5>
                </td>
              </tr>
              <tr>
                <td colspan="3">
                  <hr>
                </td>
              </tr>
              <tr>
                <td align="left">
                  <h5>Pemb2</h5>
                </td>
                <td align="left">
                  <h5>:</h5>
                </td>
                <td>
                  <h5><?= $data1["pem2"] ?></h5>
                </td>
              </tr>
              <tr>
                <td colspan="3">
                  <hr>
                </td>
              </tr>
              <tr>
                <td align="left">
                  <h5>Judul</h5>
                </td>
                <td align="left">
                  <h5>:</h5>
                </td>
                <td>
                  <h5><?= $data1["judul"] ?></h5>
                </td>
              </tr>
              <tr>
                <td colspan="3">
                  <hr>
                </td>
              </tr>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <center>
              <h3 class="m-0 text-dark">Detail File Skripsi</h3>
            </center>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <!-- <object data="../../assets/laporan_pkl/<?=$data1["filePKL"]?>" type="application/pdf"
                  width="100" height="500"></object> -->
            <embed src="../../assets/skripsi_jurnal_pdf/<?=$data1["jurnal_pdf"]?>" type="application/pdf" width="100%"
              height="500"></embed>
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
    let foto = $(this).data('foto');
    let nim = $(this).data('nim');
    let nama = $(this).data('nama');
    let lemrev = $(this).data('lemrev');
    let filebim = $(this).data('filebim');
    let hasilbim = $(this).data('hasilbim');
    let pesan = $(this).data('pesan');
    let subjek = $(this).data('subjek');
    let tanggalbim = $(this).data('tanggal_bim');
    let judul = $(this).data('judul');
    let pembimbing = $(this).data('dosbing');
    let tglsid = $(this).data('tglsid');
    let ruangsid = $(this).data('ruangsid');
    let waktusid = $(this).data('waktusid');
    let status = $(this).data('status');
    let id = $(this).data('id');
    let desk = $(this).data('desk');
    $("#modal-lg #id").val(id);
    $("#modal-lg #nim").val(nim);
    $("#modal-lg #nama").val(nama);
    $("#modal-lg #filebim").attr("href", "assets/download.php?filename=" + filebim);
    $("#modal-lg #file_hasilbim").attr("href", "assets/downloadhasilbimpkl.php?filename=" + hasilbim);
    $("#modal-lg #pesan1").val(pesan);
    $("#modal-lg #subjek").val(subjek);
    $("#modal-lg #desk").val(desk);
    $("#modal-lg #tanggal").val(tanggalbim);
    $("#modal-lg #judul").val(judul);
    $("#modal-lg #pembimbing").val(pembimbing);
    $("#modal-lg #tgl_sid").val(tglsid);
    $("#modal-lg #ruang_sid ").val(ruangsid);
    $("#modal-lg #waktu").val(waktusid);
    $("#modal-lg #status_bim1").val(status);
    $("#modal-lg #foto").attr("src", "../../assets/foto/" + foto);
  });

  // detail data
  $(document).on("click", "#detaildata1", function () {
    let foto = $(this).data('foto');
    let nim = $(this).data('nim');
    let nama = $(this).data('nama');
    let lemrev = $(this).data('lemrev');
    let filebim = $(this).data('filebim');
    let hasilbim = $(this).data('hasilbim');
    let pesan = $(this).data('pesan');
    let subjek = $(this).data('subjek');
    let tanggalbim = $(this).data('tanggal_bim');
    let judul = $(this).data('judul');
    let pembimbing = $(this).data('dosbing');
    let tglsid = $(this).data('tglsid');
    let ruangsid = $(this).data('ruangsid');
    let waktusid = $(this).data('waktusid');
    let status = $(this).data('status');
    let id = $(this).data('id');
    let desk = $(this).data('desk');
    $("#modal-lg1 #id").val(id);
    $("#modal-lg1 #nim").val(nim);
    $("#modal-lg1 #nama").val(nama);
    $("#modal-lg1 #filebim").attr("href", "assets/download.php?filename=" + filebim);
    $("#modal-lg1 #file_hasilbim").attr("href", "assets/downloadhasilbimpkl.php?filename=" + hasilbim);
    $("#modal-lg1 #pesan").val(pesan);
    $("#modal-lg1 #subjek").val(subjek);
    $("#modal-lg1 #desk").val(desk);
    $("#modal-lg1 #tanggal").val(tanggalbim);
    $("#modal-lg1 #judul").val(judul);
    $("#modal-lg1 #pembimbing").val(pembimbing);
    $("#modal-lg1 #tgl_sid").val(tglsid);
    $("#modal-lg1 #ruang_sid ").val(ruangsid);
    $("#modal-lg1 #waktu").val(waktusid);
    $("#modal-lg1 #status_bim1").val(status);
    $("#modal-lg1 #status_bim2").val(status);
    $("#modal-lg1 #hasilbim2").val(hasilbim);
    $("#modal-lg1 #foto").attr("src", "../../assets/foto/" + foto);
  });
</script>
</body>

</html>