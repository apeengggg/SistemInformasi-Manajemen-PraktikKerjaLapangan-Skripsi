<style>
      .content-wrapper {
    background-image: url("../../umc.jpg");
  }

  h1 {
    background-color: #FFFFFF;
  }

  </style>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="../../logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">SIM-PKL&SKRIPSI</span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <?php
                        $nidn = $_SESSION["nidn"];
                        $ambilfoto = mysqli_query($conn, "SELECT * FROM tata_usaha WHERE nidn='$nidn'");
                        $foto = mysqli_fetch_array($ambilfoto); ?>
                        <img src="../../assets/foto/<?php echo $foto["foto"] ?>" class="img-circle" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?php echo $foto["nama"]; ?></a>
                        <P>
                            <a href="#" class="d-block"><?php echo $foto["nidn"] ?></a>
                    </div>
                </div>
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="index.php" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                   Validasi Persyaratan
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="validasipersyaratan.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>PKL</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="validasipersyaratan1.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Skripsi</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="suratobservasi.php" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Buat Surat Observasi
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-edit"></i>
                                <p>
                                    Data User
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="datamahasiswa.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Mahasiswa</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="datadosen.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Dosen</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="dosenwali.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Dosen Wali</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    PKL
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="datapkl.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data PKL</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="val_sidangpkl.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Validasi Sidang PKL</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="sidangpkl.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Sidang PKL</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="filepkl.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>File PKL</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    Proposal
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="dataproposal.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Proposal</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="val_sidangprop.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Validasi Sidang Proposal</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="sidangproposal.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Sidang Proposal</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="fileproposal.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>File Proposal</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                Skripsi
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                            <li class="nav-item">
                                    <a href="datajudul.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Judul</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="dataskripsi.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Skripsi</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="val_sidangdraft.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Validasi Sidang Draft</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="sidangdraft.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Sidang Draft</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="val_sidangpend.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Validasi Sidang Pendadaran</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="sidangpend.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Sidang Pendadaran</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="fileskripsi.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>File Skripsi</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="../../logout.php" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Logout
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>