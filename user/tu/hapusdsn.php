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
    $query  = mysqli_query($conn,"DELETE FROM dosen WHERE nidn='$id'");
    // cek apakah proses hapus data berhasil
    if($query) {
      // jika berhasil, redirect kehalaman index.php
    echo "<script>
    alert('Data Dosen Berhasil Di Hapus')
    windows.location.href('datadosen.php')
    </script>";
    ?> <a href="datadosen.php">Jika Tidak Kembali Klik Disini</a>
    <?php
   } else {
      // jika tidak redirect juga kehalaman index.php
      echo "<script>
      alert('Data Dosen Gagal Di Hapus')
      windows.location.href('datadosen.php')
      </script>";
      ?> <a href="datadosen.php">Jika Tidak Kembali Klik Disini</a>
    <?php
    }
  }

 ?>