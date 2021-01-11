<?php 
session_start();
$_SESSION["login_mhs"];
$_SESSION["login_tu"];
$_SESSION["login_kaprodi"];
$_SESSION["login_pa"];
$_SESSION["login_dosen"];
$_SESSION["nim"];
$_SESSION["nama"];
$_SESSION["foto"];
$_SESSION["status_pkl"];
$_SESSION["status_proposal"];
$_SESSION["status_pendadaran"];
$_SESSION["nidn"];
$_SESSION["nama_dosen"];

unset($_SESSION["login_mhs"]);
unset($_SESSION["login_tu"]);
unset($_SESSION["login_kaprodi"]);
unset($_SESSION["login_pa"]);
unset($_SESSION["login_dosen"]);
unset($_SESSION["nim"]);
unset($_SESSION["nama"]);
unset($_SESSION["foto"]);
unset($_SESSION["status_pkl"]);
unset($_SESSION["status_proposal"]);
unset($_SESSION["status_pendadaran"]);
unset($_SESSION["status_draft"]);
unset($_SESSION["nidn"]);
unset($_SESSION["nama_dosen"]);

session_unset();
session_destroy();

header("location:index.php?logout")
?>