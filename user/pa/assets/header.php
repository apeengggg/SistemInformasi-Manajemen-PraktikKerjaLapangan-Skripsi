<style>
  .content-wrapper {
    background-image: url("../../umc.jpg");
  }

  h1 {
    background-color: #FFFFFF;
  }
</style>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link">
        <img src="../../logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">SIM-PKL & SKRIPSI</span>
      </a>
      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <?php
$nidn = $_SESSION["nidn"];
$ambilfoto = mysqli_query($conn, "SELECT * FROM dosen WHERE nidn='$nidn'");
$foto = mysqli_fetch_array($ambilfoto); ?>
            <img src="../../assets/foto/<?php echo $foto["foto_dosen"]?>" class="img-circle elevation-2"
              alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"><?php echo $foto["nama_dosen"]; ?></a>
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
              <a href="../pa/index.php" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="profile.php" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>
                  Data Profil
                </p>
              </a>
            </li>

            <!-- penasihat akademik/kaprodi -->
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user-tie"></i>
                <p>
                  Penasihat Akademik
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-edit" style="text-indent: 10px;"></i>
                    <p>
                      Data User
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="datamahasiswa.php" class="nav-link">
                        <i class="nav-cion fas fa-eye" style="text-indent: 15px;"></i>
                        <p>Data Mahasiswa</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="datadosen.php" class="nav-link">
                        <i class="nav-cion fas fa-eye" style="text-indent: 15px;"></i>
                        <p>Data Dosen</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="dosenwali.php" class="nav-link">
                        <i class="nav-cion fas fa-eye" style="text-indent: 15px;"></i>
                        <p>Data Dosen Wali</p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-pencil-ruler" style="text-indent: 10px;"></i>
                    <p>
                      PKL
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="../pa/pa_datapkl.php" class="nav-link">
                        <i class="nav-cion fas fa-eye" style="text-indent: 15px;"></i>
                        <p>Data PKL</p>
                      </a>
                    </li>
<!-- 
                    <li class="nav-item">
                      <a href="../pa/pa_pendaftarsidangpkl.php" class="nav-link">
                        <i class="nav-cion fas fa-eye" style="text-indent: 15px;"></i>
                        <p>Penjadwalan Sidang PKL</p>
                      </a>
                    </li> -->
                    <li class="nav-item">
                      <a href="../pa/pa_sidangpkl.php" class="nav-link">
                        <i class="nav-cion fas fa-eye" style="text-indent: 15px;"></i>
                        <p>Sidang PKL</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../pa/pa_filepkl.php" class="nav-link">
                        <i class="nav-cion fas fa-eye" style="text-indent: 15px;"></i>
                        <p>File PKL</p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-book" style="text-indent: 10px;"></i>
                    <p>
                      Data Judul
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="pengajuanjudul.php" class="nav-link">
                        <i class="nav-cion fas fa-eye" style="text-indent: 15px;"></i>
                        <p style="text-indent: 15px;">Pengajuan Judul</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="pemilihandosbing.php" class="nav-link">
                        <i class="nav-cion fas fa-eye" style="text-indent: 15px;"></i>
                        <p style="text-indent: 15px;">Pemilihan Dosbing Proposal</p>
                      </a>
                    </li>
                    <!-- <li class="nav-item">
<a href="pemilihandosbing.php" class="nav-link">
<i class="nav-cion fas fa-eye"></i>
<p>Pemilihan Dosbing Proposal</p>
</a>
</li> -->
                  </ul>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-swatchbook"></i>
                    <p>
                      Proposal
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="../pa/pa_dataproposal.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>Data Proposal</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../pa/pa_sidangproposal.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>Sidang Proposal</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../pa/pa_fileproposal.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>File Proposal</p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-adjust"></i>
                    <p>
                      Skripsi
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="../pa/pa_dataskripsi.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>Data Skripsi</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../pa/pa_sidangdraft.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>Sidang Draft</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../pa/pa_sidangpend.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>Sidang Pendadaran</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../pa/pa_fileskripsi.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>File Skripsi</p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
            <!-- ./penasihat akademik/kaprodi -->
            <!-- penguji -->
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user-shield"></i>
                <p>
                  Penguji
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-pencil-ruler"></i>
                    <p>
                      PKL
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="../dosen/p_sidangpkl.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>Sidang PKL</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../dosen/p_bimbinganpascapkl.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>Bimbingan Pasca Sidang</p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-swatchbook"></i>
                    <p>
                      Proposal
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="../dosen/p_sidangproposal.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>Sidang Proposal</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../dosen/p_bimbinganpascaprop.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>Bim. Pasca Proposal</p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-adjust"></i>
                    <p>
                      Skripsi
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="../dosen/p_sidangdraft.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>Sidang Draft</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../dosen/p_bimbinganpend.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>Bim. Pendadaran</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../dosen/p_sidangpend.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>Sidang Pendadaran</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../dosen/p_pascapend.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>Bim. Pasca Sidan Pendadaran</p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
            <!-- ./penguji -->

            <!-- pembimbing -->
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user-tag"></i>
                <p>
                  Pembimbing
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <!-- <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-book"></i>
                    <p>
                      Data Judul
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="pengajuanjudul.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>Pengajuan Judul</p>
                      </a>
                    </li>
                  </ul> -->
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-pencil-ruler"></i>
                    <p>
                      PKL
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="../dosen/b_datapkl.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>Data PKL</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../dosen/b_bimbinganpkl.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>Bimbingan Lap. PKL</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../pa/pa_validasisidpkl.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>Pendaftaran Sidang Pkl</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../dosen/b_sidangpkl.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>Sidang PKL</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../dosen/b_filepkl.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>File PKL</p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-swatchbook"></i>
                    <p>
                      Proposal
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="../dosen/b_dataproposal.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>Data Proposal</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../dosen/b_bimbinganproposal.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>Bimbingan Proposal</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../pa/pa_validasisidprop.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>Pendaftaran Sidang Proposal</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../dosen/b_sidangproposal.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>Sidang Proposal</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../dosen/b_fileproposal.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>File Proposal</p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-adjust"></i>
                    <p>
                      Skripsi
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="../dosen/b_dataskripsi.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>Skripsi</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../dosen/b_bimbingandraft.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>Bimbingan Draft</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../pa/pa_validasisiddraft.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>Pendaftaran Sidang Draft</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../dosen/b_sidangdraft.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>Sidang Draft</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../pa/pa_validasisidpend.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>Pendaftaran Sidang Pendadaran</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../dosen/b_sidangpend.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>Sidang Pendadaran</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../dosen/b_fileskripsi.php" class="nav-link">
                        <i class="nav-cion fas fa-eye"></i>
                        <p>File Skripsi</p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
            <!-- <li class="nav-item">
              <a href="../../logout.php" class="nav-link">
                <i class="nav-cion fas fa-power-off"></i>
                <p>Penga</p>
              </a>
            </li> -->
            <li class="nav-item">
              <a href="../../logout.php" class="nav-link">
                <i class="nav-cion fas fa-power-off"></i>
                <p>Logout</p>
              </a>
            </li>
            <!-- ./ pembimbing -->
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>