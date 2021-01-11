        <?php
        session_start();
        require "../../koneksi.php";
        if (!isset($_SESSION["login_tu"])) {
        header("location:../../index.php");
        exit();
        }
        $nidn=$_SESSION["nidn"];
        ?>

        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title>Data Sidang Draft | SIM-PS | Tata Usaha</title>
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
                                    <h1 class="m-0 text-dark" id="penguji">Buat Surat Observasi</h1>
                                </center>
                                <!-- <br>  <a href="#bim" class="btn btn-primary">Data Sidang Mahasiswa Bimbingan</a> -->
                                <!-- <a href="assets/jadwalsidangdraft.php" target="_blank" class="btn btn-success">
                            <i class="fas fa-file-export"></i> Export Jadwal
                            </a>
                            <a href="#all" class="btn btn-primary">Semua Data Sidang</a> -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <center></center>
                                <form action="assets/suratobservasi.php" method="POST" id="form1">
                                    <table class="table-common">
                                        <div class="form-group row">
                                            <label for="subjek" class="col-md-2 col-form-label">Jenis Surat</label>

                                            <select name="tujuan" id="tujuan" class="form-control" required>
                                                <option value="">Pilih Jenis Surat</option>
                                                <option value="0">Praktik Kerja Lapangan (External)</option>
                                                <option value="1">Praktik Kerja Lapangan (Internal)</option>
                                                <option value="2">Tugas Akhir/Skripsi (External)</option>
                                                <option value="3">Tugas Akhir/Skripsi (Internal)</option>
                                            </select>
                                        </div>
                                        <div class="form-group row">
                                            <label for="subjek" class="col-md-2 col-form-label">Data Instansi</label>
                                            <input type="text" name="nama_perusahaan" id="nama_perusahaan"
                                                placeholder="NAMA INSTANSI" class="form-control" required>
                                            <br> <br>
                                            <input type="text" name="alamat" id="alamat" class="form-control"
                                                placeholder="ALAMAT INSTANSI" required>

                                        </div>
                                        <div class="form-group row">
                                            <label for="subjek">Data Mahasiswa</label><br><br>

                                            <input type="text" name="nim[]" id="nim" placeholder="NIM MAHASISWA"
                                                class="form-control" maxlength="9" required>
                                            <br><br>
                                            <input type="text" name="nama[]" id="nama" class="form-control"
                                                placeholder="NAMA MAHASISWA" required>
                                            <br><br>
                                            <input type="text" name="prodi[]" id="prodi" class="form-control"
                                                placeholder="PRODI MAHASISWA" value="Teknik Informatika" readonly>
                                        </div>
                                    </table>
                                    <a onclick="tambah()" style="cursor:pointer;text-decoration:underline;">Tambah
                                        Mahasiswa</a><br /><br />
                                    <div class="form-group row">
                                        <!-- <label for="subjek" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-3">
                                    <a onclick="tambah()" style="cursor:pointer;text-decoration:underline;">Tambah Mahasiswa</a><br/><br/>
                            </div> -->
                                    </div>
                                    <br>
                                    <button type="submit" name="submit" class="btn btn-info">Buat Surat</button>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.section 2 -->
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script type="text/javascript">
            function isi_otomatis() {
                var nim = $("#nim").val();
                $.ajax({
                    url: 'ajax.php',
                    data: "nim=" + nim,
                }).success(function (data) {
                    var json = data,
                        obj = JSON.parse(json);
                    $('#nama').val(obj.nama);
                    $('#prodi').val(obj.prodi);
                });
            }
        </script>

        <script>
            function tambah() {
                $(".table-common").append(
                    '<div class="form-group row"> <label for="subjek">Data Mahasiswa</label><br><br><input type="text" name="nim[]" id="nim[]" placeholder="NIM MAHASISWA" class="form-control"  maxlength="9" required><br><br><input type="text" name="nama[]" id="nama[]" class="form-control" placeholder="NAMA MAHASISWA" required><br><br><input type="text" name="prodi[]" id="prodi[]" class="form-control" placeholder="PRODi MAHASISWA" value="Teknik Informatika" readonly></div>'
                    ).children(':last');
            }
        </script>

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
        </script>
        </body>

        </html>