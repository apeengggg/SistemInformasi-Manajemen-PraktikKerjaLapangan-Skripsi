    <?php
    session_start();
    if (!isset($_SESSION["login_tu"])) {
        header("location:../../index.php");
        exit();
    }
    require "../../koneksi.php";
    $nidn = $_SESSION["nidn"];
    // $u_create = $_SESSION["nama"];
    // $action = "update";
    // $set = mysqli_query($conn, "SET @action ='$action', @user = '$u_create'");

    //  input mahasiswa manual
    if (isset($_POST["inputmhs"])) {
        $nim = $_POST["id"];
        $nama = $_POST["validasi"];
        $prodi = $_POST["pesan"];
        $insertakun = mysqli_query($conn, "UPDATE skripsi_syarat SET status='$nama',
        pesan='$prodi' WHERE id_syarat='$nim'");
        if ($insertakun) {
                echo "<script>
                alert('Persyaratan Berhasil Divalidasi')
                windows.location.href('validasipersyaratan.php')
                </script>"; 
            }else {
                echo "<script>
                alert('Persyaratan Gagal Divalidasi')
                windows.location.href('validasipersyaratan.php')
                </script>"; 
    }
}

    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>SIM-PS | Validasi Persyaratan Skripsi | Tata Usaha </title>
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
                        <!-- <h1 class="m-0 text-dark">Data Pendaftaran Sidang SKRIPSI</h1> -->
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
                                <h1 class="m-0 text-dark" id="all">Mahasiswa Belum Di Validasi</h1><br>
                            </center>
                            <a href="#riwayat" class="btn btn-primary"><i class="fas fa-clock"></i> Riwayat Validasi</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example3" class="table table-bordered table-striped">
                                <thead align="center">
                                    <tr>
                                        <th width="80px">NIM</th>
                                        <th width="200px">Nama</th>
                                        <th width="50px">Angkatan</th>
                                        <th width="100px">Tanggal</th>
                                        <th width="100px">File Persyaratan</th>
                                        <th width="80px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                $getdata = mysqli_query($conn,
                "SELECT * FROM skripsi_syarat INNER JOIN mahasiswa ON skripsi_syarat.nim=mahasiswa.nim
                WHERE status='0' ORDER BY tanggal DESC") or die (mysqli_erorr($conn));
                if (mysqli_num_rows($getdata) > 0) {
                    while ($data=mysqli_fetch_array($getdata)) {
                    $tanggal = $data["tanggal"];
                    $tgl = date('d-M-Y', strtotime($tanggal));
             ?>
                                    <tr>
                                        <td><?php echo $data['nim']?></td>
                                        <td><?php echo $data['nama']?></td>
                                        <td><?php echo $data['angkatan']?></td>
                                        <td align="center"><?php echo $tgl ?></td>
                                        <td align="center"><a
                                                href="../../assets/persyaratan_skripsi/<?= $data["file"] ?>"
                                                class="btn btn-info" target="_blank"><i class="fas fa-download"></i></a>
                                        </td>
                                        <td width="30px" align="center">
                                            <button type="submit" id="detaildata" class="btn btn-dark"
                                                data-toggle="modal" data-target="#modal-xl" data-target="#modal-xl"
                                                data-nim="<?= $data['id_syarat']; ?>">
                                                <i class="fas fa-info-circle"></i></button>
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
                                <h1 class="m-0 text-dark" id="riwayat">Riwayat Validasi</h1><br>
                            </center>
                            <a href="#all" class="btn btn-primary"><i class="fas fa-stop"></i> Data Belum Divalidasi</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead align="center">
                                    <tr>
                                        <th width="80px">NIM</th>
                                        <th width="200px">Nama</th>
                                        <th width="50px">Angkatan</th>
                                        <th width="100px">Tanggal</th>
                                        <th width="120px">File Persyaratan</th>
                                        <th width="100px">Hasil Validasi</th>
                                        <th width="80px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                $getdata = mysqli_query($conn,
                "SELECT * FROM skripsi_syarat INNER JOIN mahasiswa ON skripsi_syarat.nim=mahasiswa.nim
                WHERE status='1' OR status ='2' ORDER BY tanggal DESC") or die (mysqli_erorr($conn));
                if (mysqli_num_rows($getdata) > 0) {
                    while ($data=mysqli_fetch_array($getdata)) {
                    $tanggal = $data["tanggal"];
                    $tgl = date('d-M-Y', strtotime($tanggal));
                ?>
                                    <tr>
                                        <td><?php echo $data['nim']?></td>
                                        <td><?php echo $data['nama']?></td>
                                        <td><?php echo $data['angkatan']?></td>
                                        <td align="center"><?php echo $tgl ?></td>
                                        <td align="center"><a
                                                href="../../assets/persyaratan_skripsi/<?= $data["file"] ?>"
                                                class="btn btn-info" target="_blank"><i class="fas fa-download"></i></a>
                                        </td>
                                        <td align="center"> <?php
                            if ($data["status"]=="0") {
                            ?>
                                            <span class="badge badge-primary">
                                                <?php echo 'Menunggu' ?>
                                                <?php } else if ($data["status"]=="2"){
                              ?>
                                                <span class="badge badge-success">
                                                    <?php echo 'Disetujui' ?>
                                                    <?php }else if ($data["status"]=="1"){
                                ?>
                                                    <span class="badge badge-danger">
                                                        <?php echo 'Ditolak' ?>
                                                        <?php } ?></span></td>
                                        <td width="30px" align="center">
                                            <button type="submit" id="detaildata1" class="btn btn-dark"
                                                data-toggle="modal" data-target="#modal-xl1"
                                                data-nim="<?= $data['id_syarat']; ?>" data-val="<?= $data['status']; ?>"
                                                data-pesan="<?= $data['pesan']; ?>">
                                                <i class="fas fa-edit"></i></button>
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

        <!-- MODAL TAMBAH DATA MAHASISWA -->
        <div class="modal fade" id="modal-xl">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">FORM VALIDASI PERSYARATAN SKRIPSI</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" method="post">
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" id="id" name="id" hidden>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="validasi" class="col-sm-3 col-form-label">Valdiasi</label>
                                    <div class="col-sm-9">
                                        <select name="validasi" id="validasi" class="form-control" required>
                                            <option value="">Pilih Status Validasi..</option>
                                            <option value="2">Setuju</option>
                                            <option value="1">Tolak</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="pesan  " class="col-sm-3 col-form-label">Pesan Validasi</label>
                                    <div class="col-sm-9">
                                        <textarea name="pesan" id="pesan" cols="30" rows="2" class="form-control"
                                            required></textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="inputmhs"
                            id="inputmhs">Kirim</button>
                    </div>
                </div>
                </form>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.MODAL TAMBAH DATA MAHASISWA -->


        <!-- MODAL TAMBAH DATA MAHASISWA -->
        <div class="modal fade" id="modal-xl1">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">FORM VALIDASI PERSYARATAN SKRIPSI</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" method="post">
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" id="id" name="id" hidden>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="validasi" class="col-sm-3 col-form-label">Valdiasi</label>
                                    <div class="col-sm-9">
                                        <select name="validasi" id="validasi" class="form-control" required>
                                            <option value="">Pilih Status Validasi..</option>
                                            <option value="2">Setuju</option>
                                            <option value="1">Tolak</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="pesan  " class="col-sm-3 col-form-label">Pesan Validasi</label>
                                    <div class="col-sm-9">
                                        <textarea name="pesan" id="pesan" cols="30" rows="2" class="form-control"
                                            required></textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="inputmhs"
                            id="inputmhs">Kirim</button>
                    </div>
                </div>
                </form>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.MODAL TAMBAH DATA MAHASISWA -->
    </div>
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
            let nim = $(this).data('nim');
            $("#modal-xl #id").val(nim);
        });

        // detail data
        $(document).on("click", "#detaildata1", function () {
            let nim = $(this).data('nim');
            let val = $(this).data('val');
            let pesan = $(this).data('pesan');
            $("#modal-xl1 #id").val(nim);
            $("#modal-xl1 #validasi").val(val);
            $("#modal-xl1 #pesan").val(pesan);
        });
        // cek show password
        $(document).ready(function () {
            $('.form-check-label').click(function () {
                if ($(this).is(':checked')) {
                    $('#password1').attr('type', 'text');
                } else {
                    $('#password1').attr('type', 'password');
                }
            });
        });
    </script>

    <script language="JavaScript" type="text/javascript">
        function hapusData(nim) {
            if (confirm("Apakah anda yakin akan menghapus data ini?")) {
                window.location.href = 'hapusmhs.php?id=' + nim;
            }
        }
    </script>
    </body>

    </html>