<?php
session_start();
if (!isset($_SESSION["login_tu"])) {
header("location:../../index.php");
exit();
}
  // defenisikan koneksi
  require "../../koneksi.php";

    // $u_create = $_SESSION["nama"];
  // cek apakah ada parameter ID dikirim
  if (isset($_GET['id'])) {
    // jika ada, ambil nilai id
    $id     = $_GET['id'];
    // hapus data pada database
    $query  = mysqli_query($conn,
      "DELETE 
      mahasiswa, pkl, pkl_bim, pkl_file, pkl_syarat, pkl_sidang, pkl_nilai, pkl_syarat_sidang,
      judul, proposal, proposal_bim, proposal_file, proposal_sidang, proposal_sidang_syarat,
      proposal_penguji, skripsi, skripsi_bim, skripsi_dosbing, skripsi_file, skripsi_syarat,
      draft_sidang, draft_penguji, draft_sidang_syarat, draft_nilai, pend_sidang, pend_penguji,
      pend_sidang_syarat, pend_nilai FROM mahasiswa 
    -- pkl
      INNER JOIN pkl ON mahasiswa.nim=pkl.nim
      INNER JOIN pkl_bim ON pkl.id_pkl=pkl_bim.id_pkl
      INNER JOIN pkl_file ON pkl.id_pkl=pkl_file.id_pkl
      INNER JOIN pkl_syarat ON mahasiswa.nim=pkl_syarat.nim
      INNER JOIN pkl_sidang ON pkl.id_pkl=pkl_sidang.id_pkl
      INNER JOIN pkl_nilai ON pkl_sidang.id_sidpkl=pkl_nilai.id_sidang
      INNER JOIN pkl_syarat_sidang ON pkl_sidang.id_sidpkl=pkl_syarat_sidang.id_sidang
      -- judul
      INNER JOIN judul ON mahasiswa.nim=judul.nim
      -- proposal
      INNER JOIN proposal ON judul.id_judul=proposal.id_proposal
      INNER JOIN proposal_bim ON proposal.id_proposal=proposal_bim.id_proposal
      INNER JOIN proposal_file ON proposal.id_proposal=proposal_file.id_proposal
      INNER JOIN proposal_sidang ON proposal_sidang.id_proposal=proposal.id_proposal
      INNER JOIN proposal_sidang_syarat ON proposal_sidang.id_sidang=proposal_sidang_syarat.id_sidang
      INNER JOIN proposal_penguji ON proposal_sidang.id_sidang=proposal_penguji.id_sidang
      -- skrpisi
      INNER JOIN skripsi ON proposal.id_proposal=skripsi.id_skripsi
      INNER JOIN skripsi_bim ON skripsi.id_skripsi=skripsi_bim.id_skripsi
      INNER JOIN skripsi_dosbing ON skripsi_dosbing.id_skripsi=skripsi.id_skripsi
      INNER JOIN skripsi_file ON skripsi.id_skripsi=skripsi_file.id_skripsi
      INNER JOIN skripsi_syarat ON mahasiswa.nim=skripsi_syarat.nim
      -- draft
      INNER JOIN draft_sidang ON skripsi.id_skripsi=draft_sidang.id_skripsi
      INNER JOIN draft_penguji ON draft_sidang.id_sidang=draft_penguji.id_sidang
      INNER JOIN draft_sidang_syarat ON draft_sidang.id_sidang=draft_sidang_syarat.id_sidang
      INNER JOIN draft_nilai ON draft_sidang.id_sidang=draft_nilai.id_sidang
      -- pend
      INNER JOIN pend_sidang ON skripsi.id_skripsi=pend_sidang.id_skripsi
      INNER JOIN pend_penguji ON pend_sidang.id_sidang=pend_penguji.id_sidang
      INNER JOIN pend_sidang_syarat ON pend_sidang.id_sidang=pend_sidang_syarat.id_sidang
      INNER JOIN pend_nilai ON pend_sidang.id_sidang=pend_nilai.id_sidang
      -- where mahasiswa nim
      WHERE mahasiswa.nim='$id'");
    // cek apakah proses hapus data berhasil
    if(mysqli_affected_rows($conn)) {
      // jika berhasil, redirect kehalaman index.php
    echo "<script>
    alert('Data Mahasiswa Berhasil Di Hapus')
    windows.location.href('datamahasiswa.php')
    </script>";
    ?> <a href="datamahasiswa.php">Jika Tidak Kembali Klik Disini</a>
    <?php
   } else {
      // jika tidak redirect juga kehalaman index.php
      echo "<script>
      alert('Data Mahasiswa Gagal Di Hapus')
      windows.location.href('datamahasiswa.php')
      </script>";
      ?>
      <a href="datamahasiswa.php">Jika Tidak Kembali Klik Disini</a>
    <?php 
    }
  }
 ?>