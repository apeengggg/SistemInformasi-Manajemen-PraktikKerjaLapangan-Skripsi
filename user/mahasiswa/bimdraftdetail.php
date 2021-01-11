<?php
session_start();
if (!isset($_SESSION["login_mhs"])) {
header("location:../../index.php");
exit();
}
require "../../koneksi.php";
$nim = $_SESSION["nim"];
// ambil data bimbingan mahasiswa
$getbim = mysqli_query($conn, "SELECT * FROM skripsi_bim WHERE nim='$nim' AND status='Bimbingan Draft'") or die (mysqli_erorr($conn));
// kirim hasil bimbingan
if (isset($_POST["hasilbim"])) {
$ekstensi2 = array("doc", "docx", "ppt", "pptx", "rar", "zip", "pdf");
$nidn = $_POST["nidn"];
$tgl = $tanggal;
$subjek = $_POST["subjek"];
$desk = $_POST["deskripsi"];
$idpkl = $getid["id_skripsi"];
$status='Bimbingan Draft';
$filebim= $_FILES["filebim"]["name"];
$ambil_ekstensi2 = explode(".", $filebim);
$eks2 = $ambil_ekstensi2[1];
$newfilebim = $nim.'-'.$filebim;
$pathfilebim = '../../assets/bim_draft/'.$newfilebim;
if (in_array($eks2, $ekstensi2)) {
$filebim_tmp = $_FILES["filebim"]["tmp_name"];  
if (move_uploaded_file($filebim_tmp, $pathfilebim)) {
$tambahbim = mysqli_query($conn, "INSERT INTO skripsi_bim (id_skripsi, nim, pembimbing, tgl_bim, subjek, deskripsi, file_bim)
VALUES ('$idpkl' ,'$nim', '$nidn', '$tgl', '$subjek', '$desk', '$newfilebim')") or die (mysqli_error($conn));
if ($tambahbim) {
echo "<script>
alert('Berhasil Melakukan Bimbingan!')
windows.location.href='bimbingandraft.php'
</script>";
}else {
echo "<script>
alert('Gagal Melakukan Bimbingan!')
windows.location.href='bimbingandraft.php'
</script>";
}
}
}else {
 echo "<script>
alert('Gagal Melakukan Bimbingan, File yang diunggah Harus doc, docx, ppt, pptx, pdf, rar, atau zip!')
windows.location.href='bimbingandraft.php'
</script>";   
}}

// baca mahasiswa
if(isset($_POST["baca"])) {
$id=$_POST["id"];
$status_mhs = "Dibaca";
// cek apakah sudah terisi filehasil bimbingannya
$cekfile = mysqli_query($conn, "SELECT file_hasilbim FROM skripsi_bim WHERE id_bim='$id' AND file_hasilbim IS NULL");
if(mysqli_num_rows($cekfile)===1) {
echo "<script>
windows.location.href='bimbingandraft.php'
</script>";
}else{
$update = mysqli_query($conn, "UPDATE skripsi_bim SET status_mhs='$status_mhs' WHERE id_bim='$id'");
}
}

// ambil id BImbingan di get
if (isset($_GET["id"])) {
$decode = base64_decode($_GET["id"]);
}
//ambi data bimbingan
$getdata = mysqli_query($conn,
"SELECT 
mhs.nim AS nim, mhs.nama AS nama,
d1.nidn AS nidn,
d1.nama_dosen AS pembimbing,
d1.foto_dosen AS foto_dosen,
bim.file_bim AS filebim, bim.file_hasilbim AS hasilbim,
bim.tgl_bim AS tanggal_bim, bim.subjek AS subjek_bim,
bim.deskripsi AS deskripsi_bim, bim.saran AS pesan_bim,
bim.status_bim AS status_bim, bim.status_dosbing AS dosbing,
bim.id_bim AS id
FROM skripsi_bim bim LEFT JOIN skripsi
ON bim.id_skripsi=skripsi.id_skripsi
LEFT JOIN skripsi_dosbing
ON skripsi.id_skripsi=skripsi_dosbing.id_skripsi
LEFT JOIN proposal
ON skripsi.id_proposal=proposal.id_proposal
LEFT JOIN dosen d1
ON skripsi_dosbing.nidn=d1.nidn
LEFT JOIN judul
ON proposal.id_judul=judul.id_judul
LEFT JOIN mahasiswa mhs
ON judul.nim=mhs.nim
WHERE bim.nim='$nim'AND bim.pembimbing='$decode' AND 
skripsi_dosbing.nidn='$decode' AND bim.status='Bimbingan Draft' 
ORDER BY bim.status_dosbing ASC") or die (mysqli_erorr($conn));

//ambi data bimbingan
$getdataa = mysqli_query($conn,
"SELECT d1.nama_dosen AS nama, d1.foto_dosen AS foto, d1.nidn AS nidn
FROM skripsi_dosbing LEFT JOIN skripsi ON skripsi_dosbing.id_skripsi=skripsi.id_skripsi
LEFT JOIN proposal ON skripsi.id_proposal=proposal.id_proposal
LEFT JOIN judul ON proposal.id_judul=judul.id_judul
LEFT JOIN mahasiswa ON judul.nim=mahasiswa.nim
LEFT JOIN dosen d1 
ON skripsi_dosbing.nidn=d1.nidn
WHERE mahasiswa.nim='$nim' AND skripsi_dosbing.nidn='$decode'") or die (mysqli_erorr($conn));
$data1=mysqli_fetch_array($getdataa);
$data2 = mysqli_num_rows($getdata);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Detail Bimbingan Draft | SIM-PS | Mahasiswa</title>
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
  thead{
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
          <div class="col-sm-12">
            <a href="bimbingandraft.php" class="btn btn-warning">Kembali</a>
            <h1 class="m-0 text-dark">Data Bimbingan Draft</h1>
            </div><!-- /.col -->
            </div><!-- /.row -->
            </div><!-- /.container-fluid -->
          </section>
          <!-- Main content -->
          <section class="content">
            <div class="row">
              <div class="col-3">
                <div class="card">
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table>
                      <tr>
                        <td colspan="3" align="center">
                          <img src="../../assets/foto/<?= $data1["foto"]?>" alt="" width="100px" height="100px">
                        </td>
                      </tr>
                      <tr>
                        <td><font size="2">NIDN</font></td>
                        <td><font size="2">:</font></td>
                        <td><font size="2"><?= $data1["nidn"] ?></font></td>
                      </tr>
                      <tr>
                        <td><font size="2">Nama</font></td>
                        <td><font size="2">:</font></td>
                        <td><font size="2"><?= $data1["nama"] ?></font></td>
                      </tr>
                      <tr>
                        <td><font size="2">Jml Bim</font></td>
                        <td><font size="2">:</font></td>
                        <td><font size="2"><?= $data2  ?></font></td>
                      </tr>
                    </table>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <div class="col-9">
                <div class="card">
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead align="center">
                        <tr>
                          <th width="10px">No</th>
                          <th width="75px">Tanggal</th>
                          <th width="100px">Subjek</th>
                          <th width="50px">Dosen</th>
                          <th width="130px">Hasil</th>
                          <th width="50px">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $no=1;
                        if (mysqli_num_rows($getdata) > 0) {
                        while ($data=mysqli_fetch_array($getdata)) {
                        ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $data['tanggal_bim'] ?></td>
                          <td><?= $data['subjek_bim'] ?></td>
                          <td align="center">
                            <?php
                            if ($data["dosbing"]=="Belum Dibaca") {
                            ?>
                            <span class="badge badge-danger">
                              <?php } else if ($data["dosbing"]=="Dibalas"){
                              ?>
                              <span class="badge badge-success">
                                <?php }else if ($data["dosbing"]=="Dibaca"){
                                ?>
                                <span class="badge badge-primary">
                                  <?php } ?>
                                  <?= $data['dosbing'] ?>
                                </td>
                                <td align="center">
                                  <?php
                                  if ($data["status_bim"]=="Revisi") {
                                  ?>
                                  <span class="badge badge-danger">
                                    <?php } else if ($data["status_bim"]=="Layak"){
                                    ?>
                                    <span class="badge badge-success">
                                      <?php }else if ($data["status_bim"]=="Lanjut"){
                                      ?>
                                      <span class="badge badge-primary">
                                        <?php } ?>
                                        <?= $data['status_bim'] ?>
                                      </td>
                                      <td align="center">
                                        <button type="submit" class="btn-sm btn-dark" name="detail" data-toggle="modal" data-target="#modal-lg" id="detaildata"
                                        data-id="<?php echo $data["id"]?>"
                                        data-dosbing="<?php echo $data["pembimbing"]?>"
                                        data-nim="<?php echo $data["nim"]?>"
                                        data-nama="<?php echo $data["nama"]?>"
                                        data-foto="<?php echo $data["foto"]?>"
                                        data-judul="<?php echo $data["judul"]?>"
                                        data-filebim="<?php echo $data["filebim"]?>"
                                        data-hasilbim="<?php echo $data["hasilbim"]?>"
                                        data-tanggal_bim="<?php echo $data["tanggal_bim"]?>"
                                        data-subjek="<?php echo $data["subjek_bim"]?>"
                                        data-desk="<?php echo $data["deskripsi_bim"]?>"
                                        data-pesan="<?php echo $data["pesan_bim"]?>"
                                        data-status="<?php echo $data["status_bim"]?>"
                                        data-status_dosbing="<?php echo $data["dosbing"]?>"
                                        data-lemrev="<?php echo $data["lem_rev"]?>">
                                        <i class="fas fa-edit"></i></button>
                                      </td>
                                    </tr>
                                    <?php }
                                    }
                                    ?>
                                  </tbody>
                                </table>

                                <!-- modal detail bimbingan -->
                      <!-- Modal -->
                      <div class="modal fade" id="modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <style>
                              .modal-header, .modal-footer {
                              background-color: #292929;
                              color:  #FFFFFF;
                              }
                              </style>
                              <h5 class="modal-title" id="exampleModalLabel">Detail Bimbingan Draft</h5>
                              
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <!-- form body modal -->
                              <form action="" method="post" enctype="multipart/form-data" >
          <!--                       <div class="form-row">
                                  <div class="form-group col-md-12">
                                    <center>
                                    <img src="" alt="" width="120" height="150" id="foto">
                                    </center>
                                  </div>
                                </div>
           -->                      <div class="form-row">
                                  <div class="form-group col-md-4">
                                    <input type="text" class="form-control" id="id" name="id" hidden>
                                  </div>
                                </div>
                                <div class="form-row">
                                  <div class="form-group col-md-3">
                                    <label for="nim">NIM</label>
                                    <input type="text" class="form-control" id="nim" name="nim" disabled>
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" disabled>
                                  </div>
                                  <div class="form-group col-md-2">
                                    <label for="filebim">File Bimbingan</label>
                                    <br>
                                    <a class="btn-sm btn-primary" href="" id="filebim" name="filebim">Unduh</a>
                                  </div>
                                  <?php
                                  $cekhasilbim = mysqli_query($conn, "SELECT * FROM skripsi_bim WHERE nim='$nim' AND pembimbing='$decode' AND status='Bimbingan Draft' AND file_hasilbim IS NULL");
                                  if (mysqli_num_rows($cekhasilbim)>0) {
                                  ?>
                                  <div class="form-group col-md-3">
                                    <label for="file_hasilbim">File Hasil Bimbingan</label>
                                    <input type="file" id="file_hasilbim" name="file_hasilbim" required>
                                  </div>
                                  <?php }else {
                                  ?>
                                  <div class="form-group col-md-3">
                                    <label for="file_hasilbim">File Hasil Bimbingan</label>
                                    <br>
                                    <a class="btn-sm btn-primary" href=" " id="file_hasilbim">Unduh</a>
                                  </div>
                                  <?php }
                                  ?>
                                  
                                </div>
                                <div class="form-row">
                                  <div class="form-group col-md-3">
                                    <label for="pesan">Pesan</label>
                                    <textarea name="pesan1" id="pesan1" cols="1" rows="1" class="form-control" disabled></textarea>
                                  </div>
                                  <div class="form-group col-md-3">
                                    <label for="subjek">Subjek Bimbingan</label>
                                    <input type="text" class="form-control" id="subjek" name="subjek" disabled>
                                  </div>
                                  <div class="form-group col-md-3">
                                    <label for="tanggal">Tanggal Bimbingan</label>
                                    <input type="text" class="form-control" id="tanggal" name="tanggal" disabled>
                                  </div>
                                  <div class="form-group col-md-3">
                                    <label for="status_bim1">Hasil Bimbingan</label>
                                    <input type="text" class="form-control" id="status_bim1" name="status_bim1" disabled>
                                  </div>
                                </div>
<!--                                 <div class="form-row">
                                  <div class="form-group col-md-12">
                                    <label for="judul">Judul Laporan</label>
                                    <input type="text" class="form-control" id="judul" name="judul" disabled>
                                  </div>
                                </div> -->
                                <!-- /.card-body -->
                                <div class="modal-footer justify-content-between">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                  <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="baca" id="baca">Kirim</button>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    <!-- /. modal detail bimbingan -->
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
                  <script>
                  $(function () {
                  $("#example1").DataTable();
                  $('#example2').DataTable({
                  "paging": true,
                  "lengthChange": false,
                  "searching": false,
                  "ordering": true,
                  "info": true,
                  "autoWidth": false,
                  });
                  });
                  // detail data
                  $(document).on("click", "#detaildata", function(){
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
                  $("#modal-lg #nim").val(nim);
                  $("#modal-lg #nama").val(nama);
                  $("#modal-lg #filebim").attr("href", "assets/downloadbimdraft.php?filename="+filebim);
                  $("#modal-lg #file_hasilbim").attr("href", "assets/downloadhasilbimdraft.php?filename="+hasilbim);
                  $("#modal-lg #pesan1").val(pesan);
                  $("#modal-lg #subjek").val(subjek);
                  $("#modal-lg #tanggal").val(tanggalbim);
                  $("#modal-lg #judul").val(judul);
                  $("#modal-lg #pembimbing").val(pembimbing);
                  $("#modal-lg #tgl_sid").val(tglsid);
                  $("#modal-lg #ruang_sid ").val(ruangsid);
                  $("#modal-lg #waktu").val(waktusid);
                  $("#modal-lg #status_bim1").val(status);
                  $("#modal-lg #id").val(id);
                  $("#modal-lg #foto").attr("src", "../../assets/foto/"+foto);
                  });
                  </script>
                </body>
              </html>