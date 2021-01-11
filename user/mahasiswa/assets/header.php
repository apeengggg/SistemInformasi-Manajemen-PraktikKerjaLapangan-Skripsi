  <style>
      .content-wrapper {
    background-image: url("../../umc.jpg");
    background-size : cover;
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
          <img src="../../logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
          style="opacity: .8">
          <span class="brand-text font-weight-light">SIM-PKL & SKRIPSI</span>
        </a>
        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <?php
              $niim = $_SESSION["nim"];
              $ambilfoto = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE nim='$niim'");
              $foto = mysqli_fetch_array($ambilfoto); ?>
              <img src="../../assets/foto/<?php echo $foto["foto"]?>" class="img-circle elevation-2" alt="User Image" >
            </div>
            <div class="info">
              <a href="#" class="d-block"><?php echo $foto["nama"]; ?></a>
              <P>
                <a href="#" class="d-block"><?php echo $foto["nim"] ?></a>
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
                <?php 
                
                $cekuser = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE nim='$nim'
                AND status_mhs='Aktif'");
                if (mysqli_num_rows($cekuser)>0) {
                ?>
                <li class="nav-item has-treeview">
                  <a href="datauser.php" class="nav-link">
                    <i class="nav-icon fas fa-edit"></i>
                    <p>
                      Profil
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
                      <a href="validasipkl.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                          <p>PKL</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="validasiskripsi.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                          <p>Skripsi</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <?php
                $cekval = mysqli_query($conn, "SELECT * FROM pkl_syarat WHERE nim='$nim' AND status='2'");
                if (mysqli_num_rows($cekval)>0) {
                ?>
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-pencil-ruler"></i>
                    <p>
                      PKL
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="datapkl.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p style="text-indent: 20px;">Data PKL</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="bimbinganpkl.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p style="text-indent: 20px;">Bimbingan PKL</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="sidangpkl.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p style="text-indent: 20px;">Sidang PKL</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="pascasidang.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p style="text-indent: 20px;">Bim. Pasca Sidang</p>
                      </a>
                    </li>
                     
                  </ul>
                </li>
                <?php } ?>
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-book"></i>
                    <p>
                      Pengajuan Judul
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="datajudul.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p style="text-indent: 20px;">Data Judul</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <?php
                 $cekval1 = mysqli_query($conn, "SELECT * FROM skripsi_syarat WHERE nim='$nim' AND status='2'");
                 if (mysqli_num_rows($cekval1)>0) {
                ?>
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-swatchbook"></i>
                    <p>
                      Proposal
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="dataproposal.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p style="text-indent: 20px;">Data Proposal</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="bimbinganproposal.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p style="text-indent: 20px;">Bimbingan Proposal</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="sidangproposal.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p style="text-indent: 20px;">Sidang Proposal</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="pascaproposal.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p style="text-indent: 20px;">Bim. Pasca Sidang</p>
                      </a>
                    </li>
                    
                  </ul>
                </li>
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-adjust"></i>
                    <p>
                      Skripsi
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="datadraft.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p style="text-indent: 20px;">Data Draft</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="bimbingandraft.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p style="text-indent: 20px;">Bimbingan Draft</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="sidangdraft.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p style="text-indent: 20px;">Sidang Draft</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="bimbinganpendadaran.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p style="text-indent: 20px;">Bim. Pendadaran</p>
                      </a>
                    </li>
                   <li class="nav-item">
                      <a href="sidangpendadaran.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p style="text-indent: 20px;">Sidang Pendadaran</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="pascaspend.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p style="text-indent: 20px;">Bim. Pasca Sidang Pendadaran</p>
                      </a>
                    </li>
                    
                  </ul>
                </li>
                 <?php } ?>
                 <li class="nav-item">
                      <a href="filelaporanpkl.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>File Laporan PKL</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="fileproposal.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>File Proposal</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="fileskripsi.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>File Skripsi</p>
                      </a>
                    </li> 
                <li class="nav-item">
                  <a href="../../index.php" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                      Logout
                    </p>
                  </a>
                </li>
                 <?php }else{?>
                  <li class="nav-item">
                  <a href="../../index.php" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                      Logout
                    </p>
                  </a>
                </li>
                <?php }?>
              </ul>
            </nav>
            <!-- /.sidebar-menu -->
          </div>
          <!-- /.sidebar -->
        </aside>