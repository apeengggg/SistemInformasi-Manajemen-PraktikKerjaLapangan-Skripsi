<?php
session_start();
require "../../koneksi.php";
if (!isset($_SESSION["login_pa"])) {
header("location:../../index.php");
exit();
}

$nidn = $_SESSION["nidn"];
?>



<!-- jadwalkan sidang -->
<?php
if (isset($_POST["jadwalkan"])) {
$id_skripsi=$_POST["id_skripsi"];
$cekpem = mysqli_query($conn, "SELECT status_dosbing FROM skripsi_dosbing sd LEFT JOIN dosen d
                        ON sd.nidn=d.nidn LEFT JOIN skripsi s ON sd.id_skripsi=s.id_skripsi 
                        WHERE sd.nidn='$nidn' AND s.id_skripsi='$id_skripsi'");
$q = mysqli_fetch_array($cekpem);
$w = $q["status_dosbing"];
if ($w == 'Pembimbing 1') {
    $id=$_POST["id_sidang"];
    $val = $_POST["valdosbing"];
    $pesan = $_POST["pesan"];
    $sqljadwal = mysqli_query($conn, "UPDATE draft_sidang SET
    val_dosbing1='$val',
    pesan1='$pesan'
    WHERE id_sidang='$id'") or die (mysqli_erorr($conn));
    if ($sqljadwal AND $val!='' AND $pesan!='') {
    echo "<script>
    alert('Berhasil Memvalidasi Pendaftaran Sidang Mahasiswa')
    windows.location.href('kp_validasisiddraft.php')
    </script>";
    }else {
    echo "<script>
    alert('Gagal Memvalidasi Pendaftaran Sidang PKL')
    windows.location.href('kp_validasisiddraft.php')
    </script>";
    } 
}else{
    $id=$_POST["id_sidang"];
    $val = $_POST["valdosbing"];
    $pesan = $_POST["pesan"];
    $sqljadwal = mysqli_query($conn, "UPDATE draft_sidang SET
    val_dosbing2='$val',
    pesan2='$pesan'
    WHERE id_sidang='$id'") or die (mysqli_erorr($conn));
    if ($sqljadwal AND $val!='' AND $pesan!='') {
    echo "<script>
    alert('Berhasil Memvalidasi Pendaftaran Sidang Mahasiswa')
    windows.location.href('kp_validasisiddraft.php')
    </script>";
    }else {
    echo "<script>
    alert('Gagal Memvalidasi Pendaftaran Sidang PKL')
    windows.location.href('kp_validasisiddraft.php')
    </script>";
    }   
}
}

if (isset($_POST["jadwalkan1"])) {
$id_skripsi=$_POST["id_skripsi"];
$cekpem = mysqli_query($conn, "SELECT status_dosbing FROM skripsi_dosbing sd LEFT JOIN dosen d
                        ON sd.nidn=d.nidn LEFT JOIN skripsi s ON sd.id_skripsi=s.id_skripsi 
                        WHERE sd.nidn='$nidn' AND s.id_skripsi='$id_skripsi'");
$q = mysqli_fetch_array($cekpem);
$w = $q["status_dosbing"];
if ($w == 'Pembimbing 1') {
    $id=$_POST["id_sidang"];
    $val = $_POST["valdosbing"];
    $pesan = $_POST["pesan"];
    $cs = mysqli_query($conn, "SELECT status_sidang FROM draft_sidang WHERE id_sidang='$id' AND (status_sidang='Lulus' OR status_sidang='Tidak Lulus')");
        if (mysqli_num_rows($cs)===1) {
        echo "<script>
        alert('Sidang Sudah Dilakukan, Tidak Dapat Mengubah Validasi')
        windows.location.href('kp_validasisiddraft.php')
        </script>";
        }else{
    $sqljadwal = mysqli_query($conn, "UPDATE draft_sidang SET
    val_dosbing1='$val',
    pesan1='$pesan'
    WHERE id_sidang='$id'") or die (mysqli_erorr($conn));
    if ($sqljadwal AND $val!='' AND $pesan!='') {
    echo "<script>
    alert('Berhasil Mengubah validasi Pendaftaran Sidang Mahasiswa')
    windows.location.href('kp_validasisiddraft.php')
    </script>";
    }else {
    echo "<script>
    alert('Gagal Mengubah validasi Pendaftaran Sidang PKL')
    windows.location.href('kp_validasisiddraft.php')
    </script>";
    }
  }
}else{
    $id=$_POST["id_sidang"];
    $val = $_POST["valdosbing"];
    $pesan = $_POST["pesan"];
    $cs = mysqli_query($conn, "SELECT status_sidang FROM draft_sidang WHERE id_sidang='$id' AND (status_sidang='Lulus' OR status_sidang='Tidak Lulus')");
        if (mysqli_num_rows($cs)===1) {
        echo "<script>
        alert('Sidang Sudah Dilakukan, Tidak Dapat Mengubah Validasi')
        windows.location.href('kp_validasisiddraft.php')
        </script>";
        }else{
    $sqljadwal = mysqli_query($conn, "UPDATE draft_sidang SET
    val_dosbing2='$val',
    pesan2='$pesan'
    WHERE id_sidang='$id'") or die (mysqli_erorr($conn));
    if ($sqljadwal AND $val!='' AND $pesan!='') {
    echo "<script>
    alert('Berhasil Memvalidasi Pendaftaran Sidang Mahasiswa')
    windows.location.href('kp_validasisiddraft.php')
    </script>";
    }else {
    echo "<script>
    alert('Gagal Memvalidasi Pendaftaran Sidang PKL')
    windows.location.href('kp_validasisiddraft.php')
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
    <title>Validasi Pendaftar Sidang Draft | SIM-PS | Penasihat Akademik</title>
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
                <!-- <h1 class="m-0 text-dark">Data Pendaftaran Sidang Proposal</h1> -->
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
                    <h2 class="m-0 text-dark">Data Pendaftaran Sidang Draft Mahasiswa Bimbingan</h2></center></div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                        <thead align="center">
                            <tr>
                            <th width="180px">Nama</th>
                            <th width="250px">Judul</th>
                            <th width="200px">Pembimbing 1</th>
                            <th width="80px">Validasi1</th>
                            <th width="200px">Pembimbing 2</th>
                            <th width="80px">Valdasi2</th>
                            <th width="50px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                         // ambil data penguji
                        $datasidang = mysqli_query($conn,
                        "SELECT mhs.nama,
                        judul.judul,
                        -- pem 1
                        (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd
                        ON d1.nidn=sd.nidn WHERE sd.id_skripsi=s.id_skripsi 
                        AND status_dosbing='Pembimbing 1' AND sd.status='Aktif'
                        LIMIT 0,1) AS pem1,
                        -- pem2
                        (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd
                        ON d1.nidn=sd.nidn WHERE sd.id_skripsi=s.id_skripsi 
                        AND status_dosbing='Pembimbing 2' AND sd.status='Aktif'
                        LIMIT 0,1) AS pem2,
                        --   penguji 1
                        (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN draft_penguji dp
                        ON d1.nidn=dp.penguji WHERE dp.id_sidang=ds.id_sidang
                        AND dp.status_penguji='Penguji 1' AND dp.status='Aktif'
                        LIMIT 0,1) AS penguji1,
                        -- penguji 2
                        (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN draft_penguji dp
                        ON d1.nidn=dp.penguji WHERE dp.id_sidang=ds.id_sidang
                        AND dp.status_penguji='Penguji 2' AND dp.status='Aktif'
                        LIMIT 0,1) AS penguji2,
                        ds.tgl_sidang AS tgl,
                        ds.waktu_sidang AS waktu,
                        ds.ruang_sidang AS ruang, ds.id_sidang,
                        ds.val_dosbing1, ds.val_dosbing2,
                        s.id_skripsi
                        FROM draft_sidang ds 
                        LEFT JOIN skripsi s
                        ON ds.id_skripsi=s.id_skripsi
                        LEFT JOIN skripsi_dosbing sd
                        ON s.id_skripsi=sd.id_skripsi
                        LEFT JOIN proposal p
                        ON s.id_proposal=p.id_proposal
                        LEFT JOIN judul  
                        ON p.id_judul=judul.id_judul
                        LEFT JOIN mahasiswa mhs
                        ON judul.nim=mhs.nim
                        WHERE (ds.val_dosbing1='0' OR ds.val_dosbing2='0')
                        AND ((sd.nidn='$nidn' AND sd.status_dosbing ='Pembimbing 1')
                        OR (sd.nidn='$nidn' AND sd.status_dosbing ='Pembimbing 2'))") or die (mysqli_error($conn));
                        if (mysqli_num_rows($datasidang) > 0) {
                        while ($data1=mysqli_fetch_array($datasidang) ) {
                            if ($data1["val_dosbing1"]==0) {
                                $val1 ='Menunggu';
                              }elseif ($data1["val_dosbing1"]==1) {
                                $val1 ='Ditolak';
                              }elseif ($data1["val_dosbing1"]==2) {
                                $val1 ='Disetujui';
                              }
                              if ($data1["val_dosbing2"]==0) {
                                $val2 ='Menunggu';
                              }elseif ($data1["val_dosbing2"]==1) {
                                $val2 ='Ditolak';
                              }elseif ($data1["val_dosbing2"]==2) {
                                $val2 ='Disetujui';
                              }
                        
                        ?>
                        <!-- tampilkan data --> 
                        <tr>
                        <td><?= $data1["nama"] ?></td>
                        <td><?= $data1["judul"] ?></td>
                        <td><?= $data1["pem1"] ?></td >
                        <td align="center"><?php if ($val1=="Menunggu") {
                            ?>
                            <span class="badge badge-primary">
                              <?php } else if ($val1=="Disetujui"){
                              ?>
                              <span class="badge badge-success">
                                <?php }else if ($val1=="Ditolak"){
                                ?>
                                <span class="badge badge-danger">
                                  <?php } ?> 
                            <?= $val1  ?></td>
                        <td><?= $data1["pem2"] ?></td >
                        <td  align="center"><?php if ($val2=="Menunggu") {
                            ?>
                            <span class="badge badge-primary">
                              <?php } else if ($val2=="Disetujui"){
                              ?>
                              <span class="badge badge-success">
                                <?php }else if ($val2=="Ditolak"){
                                ?>
                                <span class="badge badge-danger">
                                  <?php } ?>
                            <?= $val2  ?></td>
                        <td  align="center"> 
                            <button type="submit" id="detaildata" class="btn-xs btn-warning" data-toggle="modal" data-target="#modal-lg"
                            data-idskripsi="<?= $data1["id_skripsi"] ?>"
                            data-id="<?= $data1["id_sidang"] ?>"
                            data-nama="<?= $data1["nama"] ?>"
                            data-judul="<?= $data1["judul"] ?>"
                            data-dosbing1="<?= $data1["pem1"] ?>"
                            data-dosbing2="<?= $data1["pem2"] ?>"
                            data-tgl="<?= $data1["tgl"] ?>"
                            data-penguji1="<?= $data1["penguji1"] ?>"
                            data-penguji2="<?= $data1["penguji2"] ?>"
                            data-ruang="<?= $data1["ruang"] ?>"><i class="fas fa-cogs"></i></button>
                        </td>
                        </tr>
                        <?php  }
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
                    <h2 class="m-0 text-dark">Riwayat Validasi Pendaftar Sidang</h2></center></div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example3" class="table table-bordered table-striped">
                        <thead align="center">
                            <tr>
                            <th width="180px">Nama</th>
                            <th width="250px">Judul</th>
                            <th width="200px">Pembimbing 1</th>
                            <th width="80px">Validasi1</th>
                            <th width="200px">Pembimbing 2</th>
                            <th width="80px">Valdasi2</th>
                            <th width="50px">Ubah</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                         // ambil data penguji
                        $datasidang1 = mysqli_query($conn,
                        "SELECT mhs.nama,
                        judul.judul,
                        -- pem 1
                        (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd
                        ON d1.nidn=sd.nidn WHERE sd.id_skripsi=s.id_skripsi 
                        AND status_dosbing='Pembimbing 1' AND sd.status='Aktif'
                        LIMIT 0,1) AS pem1,
                        -- pem2
                        (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd
                        ON d1.nidn=sd.nidn WHERE sd.id_skripsi=s.id_skripsi 
                        AND status_dosbing='Pembimbing 2' AND sd.status='Aktif'
                        LIMIT 0,1) AS pem2,
                        --   penguji 1
                        (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN draft_penguji dp
                        ON d1.nidn=dp.penguji WHERE dp.id_sidang=ds.id_sidang
                        AND dp.status_penguji='Penguji 1' AND dp.status='Aktif'
                        LIMIT 0,1) AS penguji1,
                        -- penguji 2
                        (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN draft_penguji dp
                        ON d1.nidn=dp.penguji WHERE dp.id_sidang=ds.id_sidang
                        AND dp.status_penguji='Penguji 2' AND dp.status='Aktif'
                        LIMIT 0,1) AS penguji2,
                        ds.tgl_sidang AS tgl,
                        ds.waktu_sidang AS waktu,
                        ds.ruang_sidang AS ruang, ds.id_sidang,
                        ds.val_dosbing1, ds.val_dosbing2,
                        s.id_skripsi
                        FROM draft_sidang ds 
                        LEFT JOIN skripsi s
                        ON ds.id_skripsi=s.id_skripsi
                        LEFT JOIN skripsi_dosbing sd
                        ON s.id_skripsi=sd.id_skripsi
                        LEFT JOIN proposal p
                        ON s.id_proposal=p.id_proposal
                        LEFT JOIN judul  
                        ON p.id_judul=judul.id_judul
                        LEFT JOIN mahasiswa mhs
                        ON judul.nim=mhs.nim
                        WHERE ((ds.val_dosbing1='1' OR ds.val_dosbing2='1') OR (ds.val_dosbing1='2' OR ds.val_dosbing2='2'))
                        AND (sd.nidn='$nidn' AND sd.status_dosbing ='Pembimbing 1')
                        OR (sd.nidn='$nidn' AND sd.status_dosbing ='Pembimbing 2')") or die (mysqli_error($conn));
                        if (mysqli_num_rows($datasidang1) > 0) {
                        while ($data2=mysqli_fetch_array($datasidang1) ) {
                            if ($data2["val_dosbing1"]==0) {
                                $val1 ='Menunggu';
                              }elseif ($data2["val_dosbing1"]==1) {
                                $val1 ='Ditolak';
                              }elseif ($data2["val_dosbing1"]==2) {
                                $val1 ='Disetujui';
                              }
                              if ($data2["val_dosbing2"]==0) {
                                $val2 ='Menunggu';
                              }elseif ($data2["val_dosbing2"]==1) {
                                $val2 ='Ditolak';
                              }elseif ($data2["val_dosbing2"]==2) {
                                $val2 ='Disetujui';
                              }
                        
                        ?>
                        <!-- tampilkan data --> 
                        <tr>
                        <td><?= $data2["nama"] ?></td>
                        <td><?= $data2["judul"] ?></td>
                        <td><?= $data2["pem1"] ?></td >
                        <td align="center"><?php if ($val1=="Menunggu") {
                            ?>
                            <span class="badge badge-primary">
                              <?php } else if ($val1=="Disetujui"){
                              ?>
                              <span class="badge badge-success">
                                <?php }else if ($val1=="Ditolak"){
                                ?>
                                <span class="badge badge-danger">
                                  <?php } ?> 
                            <?= $val1  ?></td>
                        <td><?= $data2["pem2"] ?></td >
                        <td  align="center"><?php if ($val2=="Menunggu") {
                            ?>
                            <span class="badge badge-primary">
                              <?php } else if ($val2=="Disetujui"){
                              ?>
                              <span class="badge badge-success">
                                <?php }else if ($val2=="Ditolak"){
                                ?>
                                <span class="badge badge-danger">
                                  <?php } ?>
                            <?= $val2  ?></td>
                        <td  align="center"> 
                            <button type="submit" id="detaildata1" class="btn-xs btn-warning" data-toggle="modal" data-target="#modal-lg1"
                            data-idskripsi="<?= $data2["id_skripsi"] ?>"
                            data-id="<?= $data2["id_sidang"] ?>"
                            data-nama="<?= $data2["nama"] ?>"
                            data-judul="<?= $data2["judul"] ?>"
                            data-dosbing1="<?= $data2["pem1"] ?>"
                            data-dosbing2="<?= $data2["pem2"] ?>"
                            data-tgl="<?= $data2["tgl"] ?>"
                            data-penguji1="<?= $data2["penguji1"] ?>"
                            data-penguji2="<?= $data2["penguji2"] ?>"
                            data-ruang="<?= $data2["ruang"] ?>"
                            data-val1="<?= $val1 ?>"
                            data-val2="<?= $val2 ?>"><i class="fas fa-edit"></i></button>
                        </td>
                        </tr>
                        <?php  }
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

             <!-- modal tambah bimbingan -->
             <div class="modal fade" id="modal-lg">
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content"> 
                        <div class="modal-header">
                        <h4 class="modal-title">Validasi Pendaftaran Sidang Draft</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                        <form class="form-horizontal" method="post">
                            <div class="card-body">
                            <div class="form-group row">
                                <div class="col-sm-9">
                                <input type="text" class="form-control" id="id_sidang" name="id_sidang" required="required" hidden>
                                <input type="text" class="form-control" id="id_skripsi" name="id_skripsi" required="required" hidden>
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
                                <input type="text" class="form-control" id="judul_laporan" name="judul_laporan" required="required" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="id_dosenwali1" class="col-sm-3 col-form-label">Pembimbing 1</label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" id="id_dosenwali1" name="id_dosenwali1" required="required" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="id_dosenwali2" class="col-sm-3 col-form-label">Pembimbing 2</label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" id="id_dosenwali2" name="id_dosenwali2" required="required" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="valdosbing" class="col-sm-3 col-form-label">Validasi</label>
                                <div class="col-sm-9">
                                <select name="valdosbing" id="valdosbing" class="form-control" required>
                                    <option value="">Pilih Validasi...</option>
                                    <option value="2">Setuju</option>
                                    <option value="1">Tolak</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="pesan" class="col-sm-3 col-form-label">Pesan Validasi</label>
                                <div class="col-sm-9">
                                <textarea name="pesan" id="pesan" cols="30" rows="2" class="form-control" required></textarea>
                                </div>
                            </div>
                            </div>
                            <!-- /.card-body -->
                            </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="jadwalkan" id="jadwalkan">Validasi</button>
                        </div>
                        </div>
                    </form>
                    <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
                <!-- modal tambah bimbingan --> 

                 <!-- modal ubah validasi -->
             <div class="modal fade" id="modal-lg1">
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content"> 
                        <div class="modal-header">
                        <h4 class="modal-title">Ubah Validasi Pendaftaran Sidang Draft</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                        <form class="form-horizontal" method="post">
                            <div class="card-body">
                            <div class="form-group row">
                                <div class="col-sm-9">
                                <input type="text" class="form-control" id="id_sidang" name="id_sidang" required="required" hidden>
                                <input type="text" class="form-control" id="id_skripsi" name="id_skripsi" required="required" hidden>
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
                                <input type="text" class="form-control" id="judul_laporan" name="judul_laporan" required="required" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="id_dosenwali1" class="col-sm-3 col-form-label">Pembimbing 1</label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" id="id_dosenwali1" name="id_dosenwali1" required="required" readonly>
                                </div>
                            </div> 
                            <div class="form-group row">
                                <label for="validasi1" class="col-sm-3 col-form-label">Validasi 1</label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" id="validasi1" name="validasi1" required="required" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="id_dosenwali2" class="col-sm-3 col-form-label">Pembimbing 2</label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" id="id_dosenwali2" name="id_dosenwali2" required="required" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="validasi2" class="col-sm-3 col-form-label">Validasi 2</label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" id="validasi2" name="validasi2" required="required" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="valdosbing" class="col-sm-3 col-form-label">Validasi</label>
                                <div class="col-sm-9">
                                <select name="valdosbing" id="valdosbing" class="form-control" required>
                                    <option value="">Pilih Validasi...</option>
                                    <option value="2">Setuju</option>
                                    <option value="1">Tolak</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="pesan" class="col-sm-3 col-form-label">Pesan Validasi</label>
                                <div class="col-sm-9">
                                <textarea name="pesan" id="pesan" cols="30" rows="2" class="form-control" required></textarea>
                                </div>
                            </div>
                            </div>
                            <!-- /.card-body -->
                            </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="jadwalkan1" id="jadwalkan1">Ubah Validasi</button>
                        </div>
                        </div>
                    </form>
                    <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
                <!-- modal ubah validasi --> 
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
        $("#modal-lg #id_sidang").val(id);
        $("#modal-lg #id_skripsi").val(idskripsi);
        $("#modal-lg #nama").val(nama);
        $("#modal-lg #judul_laporan").val(judul);
        $("#modal-lg #id_dosenwali1").val(dosbing1);
        $("#modal-lg #id_dosenwali2").val(dosbing2);
        $("#modal-lg #tgl_sid").val(tgl);
        $("#modal-lg #ruangsid").val(ruang);
        });

         // detail data mhs
         $(document).on("click", "#detaildata1", function(){
        let id = $(this).data('id');
        let idskripsi = $(this).data('idskripsi');
        let nama = $(this).data('nama');
        let judul = $(this).data('judul');
        let dosbing1 = $(this).data('dosbing1');
        let dosbing2 = $(this).data('dosbing2');
        let tgl = $(this).data('tgl');
        let ruang = $(this).data('ruang');
        let val1 = $(this).data('val1');
        let val2 = $(this).data('val2');
        $("#modal-lg1 #id_sidang").val(id);
        $("#modal-lg1 #id_skripsi").val(idskripsi);
        $("#modal-lg1 #nama").val(nama);
        $("#modal-lg1 #judul_laporan").val(judul);
        $("#modal-lg1 #id_dosenwali1").val(dosbing1);
        $("#modal-lg1 #id_dosenwali2").val(dosbing2);
        $("#modal-lg1 #tgl_sid").val(tgl);
        $("#modal-lg1 #ruangsid").val(ruang);
        $("#modal-lg1 #validasi1").val(val1);
        $("#modal-lg1 #validasi2").val(val2);
        });
        </script>
        </body>
    </html>