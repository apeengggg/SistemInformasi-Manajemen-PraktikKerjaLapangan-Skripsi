<?php
session_start();
require "../../koneksi.php";
if (!isset($_SESSION["login_pa"])) {
header("location:../../index.php");
exit();
}

$nidn=$_SESSION["nidn"];
?>

<!-- jadwalkan sidang -->
<?php

// jadwal sidang
$date = date('Y-m-d');
$jadwalsidang = mysqli_query($conn, 
                        "SELECT mhs.nama, mhs.nim,
                        judul.judul,
                        -- pembimbing 1
                        (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd 
                        ON d1.nidn=sd.nidn 
                        WHERE sd.id_skripsi=s.id_skripsi AND status_dosbing='Pembimbing 1'
                        AND sd.status='Aktif' LIMIT 0,1 ) AS pem1, 
                        -- pembimbing2
                        (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN skripsi_dosbing sd
                        ON d2.nidn=sd.nidn 
                        WHERE sd.id_skripsi=s.id_skripsi AND status_dosbing='Pembimbing 2'
                        AND sd.status='Aktif' LIMIT 0,1) as pem2,
                        -- data sdaing
                        ps.tgl_sidang AS tgl,
                        ps.waktu_sidang AS waktu,
                        ps.ruang_sidang AS ruang, ps.id_sidang,
                        ps.status_sidang AS status,
                        -- penguji 1
                        (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN pend_penguji ppe
                        ON d1.nidn=ppe.penguji 
                        WHERE ppe.id_sidang=ps.id_sidang AND status_penguji='Penguji 1'
                        AND ppe.status='Aktif' LIMIT 0,1) AS penguji1, 
                        -- ambil data penguji2
                        (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN pend_penguji ppe
                        ON d2.nidn=ppe.penguji 
                        WHERE ppe.id_sidang=ps.id_sidang AND status_penguji='Penguji 2'
                        AND ppe.status='Aktif' LIMIT 0,1) as penguji2
                        FROM pend_sidang ps 
                        LEFT JOIN skripsi s
                        ON ps.id_skripsi=s.id_skripsi
                        LEFT JOIN proposal
                        ON s.id_proposal=proposal.id_proposal
                        LEFT JOIN judul 
                        ON proposal.id_judul=judul.id_judul
                        LEFT JOIN mahasiswa mhs
                        ON judul.nim=mhs.nim
                        LEFT JOIN pend_penguji ppe
                        ON ps.id_sidang=ppe.id_sidang
                        WHERE ps.tgl_sidang IS NOT NULL AND ps.status_sidang IS NULL") 
                        or die (mysqli_error($conn));

// seluruh data sidang
$datasidang = mysqli_query($conn,
                        "SELECT mhs.nama, mhs.nim,
                          judul.judul,
                           -- pembimbing 1
                          (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd 
                          ON d1.nidn=sd.nidn 
                          WHERE sd.id_skripsi=s.id_skripsi  AND status_dosbing='Pembimbing 1'
                        AND sd.status='Aktif' LIMIT 0,1 ) AS pem1, 
                          -- pembimbing2
                          (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN skripsi_dosbing sd
                          ON d2.nidn=sd.nidn 
                          WHERE sd.id_skripsi=s.id_skripsi  AND status_dosbing='Pembimbing 2'
                        AND sd.status='Aktif' LIMIT 0,1 ) as pem2,
                              -- penguji 1
                          (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN pend_penguji ppe
                          ON d1.nidn=ppe.penguji 
                          WHERE ppe.id_sidang=ps.id_sidang AND status_penguji='Penguji 1'
                        AND ppe.status='Aktif' LIMIT 0,1) AS penguji1, 
                          -- ambil data penguji2
                          (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN pend_penguji ppe
                          ON d2.nidn=ppe.penguji 
                          WHERE ppe.id_sidang=ps.id_sidang AND status_penguji='Penguji 2'
                        AND ppe.status='Aktif' LIMIT 0,1) as penguji2,
                          ps.tgl_sidang AS tgl,
                          ps.waktu_sidang AS waktu,
                          ps.ruang_sidang AS ruang, ps.id_sidang,
                          ps.ruang_sidang AS ruang, 
                          ps.status_sidang AS status
                          FROM pend_sidang ps 
                          LEFT JOIN skripsi s
                          ON ps.id_skripsi=s.id_skripsi
                          LEFT JOIN proposal
                          ON s.id_proposal=proposal.id_proposal
                          LEFT JOIN judul 
                          ON proposal.id_judul=judul.id_judul
                          LEFT JOIN mahasiswa mhs
                          ON judul.nim=mhs.nim
                          LEFT JOIN pend_penguji ppe
                          ON ps.id_sidang=ppe.id_sidang
                          WHERE ppe.status='Aktif'
                          GROUP BY mhs.nim") 
                        or die (mysqli_error($conn));
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Data Sidang Pendadaran | SIM-PS | Penasihat Akademik</title>
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
                  <center> <h1 class="m-0 text-dark" id="penguji">Jadwal Pengujian Sidang Pendadaran</h1><br></center>
                    <!-- <a href="#bim" class="btn btn-primary">Data Sidang Mahasiswa Bimbingan</a> -->
                    <a href="#all" class="btn btn-primary">Semua Data Sidang Mahasiswa</a>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                      <style>
                        .thead {
                          width: absoulute;
                        }
                      </style>
                      <thead class="thead">
                        <tr>
                          <th>Nama</th>
                          <th>Tgl</th>
                          <th>Waktu</th>
                          <th>Ruangan</th>
                          <th>Penguji 1</th>
                          <th>Penguji 2</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if (mysqli_num_rows($jadwalsidang) > 0) {
                        while ($data1=mysqli_fetch_array($jadwalsidang) ) {
                        $nim = $data1["nim"]; 
                        $id = base64_encode($nim);
                        ?>

                        <!-- tampilkan data -->
                        <tr>
                          <td><a href="detailsidangpend.php?id=<?= $id ?>"><?php echo $data1["nama"] ?></a></td>
                          <td><?php echo $data1["tgl"] ?></td>
                          <td><?php echo $data1["waktu"] ?></td>
                          <td><?php echo $data1["ruang"] ?></td>
                          <td><?php echo $data1["penguji1"] ?></td>
                          <td><?php echo $data1["penguji2"] ?></td>
                          <td><?php echo $data1["status"] ?></td>
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
          <!-- /.section 2 -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <!-- <h1 class="m-0 text-dark" id="all">Data Sidang Pendadaran Mahasiswa</h1> -->
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
                  <center><h1 class="m-0 text-dark" id="all">Data Sidang Pendadaran Mahasiswa</h1><br></center>
                  <!-- <button type="submit" class="btn btn-warning" data-toggle="modal" data-target="#modal-md"><i class="fas fa-print"></i> Cetak Laporan</button> -->
                    <a href="#penguji" class="btn btn-primary">Data Jadwal Pengujian</a>
                    <!-- <a href="#bim" class="btn btn-primary">Data Sidang Mahasiswa Bimbingan</a> -->
                    </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="example5" class="table table-bordered table-striped">
                      <style>
                        .thead {
                          width: absoulute;
                        }
                      </style>
                      <thead class="thead">
                        <tr>
                          <th width="200px">Nama</th>
                          <th width="200px">Pembimbing 1</th>
                          <th width="200px">Pembimbing 2</th>
                          <th width="200px">Judul</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php
                        if (mysqli_num_rows($datasidang) > 0) {
                        while ($data1=mysqli_fetch_array($datasidang) ) {
                        $nim2 = $data1["nim"];
                        $id2 = base64_encode($nim2)
                        ?>

                        <!-- tampilkan data -->
                        <tr>
                          <td><a href="detailsidangpend.php?id=<?= $id2 ?>"><?php echo $data1["nama"] ?></a></td>
                          <td><?php echo $data1["pem1"] ?></td>
                          <td><?php echo $data1["pem2"] ?></td>
                          <td><?php echo $data1["judul"] ?></td>
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
                
                                  <!-- modal cetak laporan -->
                                  <div class="modal fade" id="modal-md">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Cetak Laporan Sidang Pendadaran Mahasiswa</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form class="form-horizontal" method="post" action="assets/reportpend.php">
                            <div class="card-body">
                              <div class="form-group row">
                                <label for="angkatan" class="col-sm-3 col-form-label">Tahun Angkatan</label>
                                <div class="col-sm-9">
                                  <select class="form-control" name="angkatan" id="angkatan" required="required">
                                    <option disabled selected>Pilih Penguji...</option>
                                    <?php
                                    //ambil data dosen
                                    $sql = mysqli_query($conn, "SELECT angkatan FROM mahasiswa GROUP BY angkatan") or die (mysqli_erorr($conn));
                                    while ($dosen1 = mysqli_fetch_array($sql)) {
                                    ?>
                                    <option value="<?=$dosen1["angkatan"]?>"><?=$dosen1["angkatan"]?>
                                    </option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="jadwalkan" id="jadwalkan">Cetak</button>
                          </div>
                        </div>
                      </form>
                       </div>
                      </div>
                  <!-- modal cetak laporan -->

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
      let nama = $(this).data('nama');
      let judul = $(this).data('judul');
      let dosbing = $(this).data('dosbing');
      let tgl = $(this).data('tgl');
      let ruang = $(this).data('ruang');
      let penguji1 = $(this).data('penguji1');
      let penguji2 = $(this).data('penguji2');
      $(".modal-body #id_sidang").val(id);
      $(".modal-body #nama").val(nama);
      $(".modal-body #judul_laporan").val(judul);
      $(".modal-body #id_dosenwali").val(dosbing);
      $(".modal-body #tgl_sid").val(tgl);
      $(".modal-body #ruangsid").val(ruang);
      $(".modal-body #penguji1").val(penguji1);
      $(".modal-body #penguji2").val(penguji2);
      });
      </script>
    </body>
  </html>