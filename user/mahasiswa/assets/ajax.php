<?php

require "../../../koneksi.php";

//variabel nim yang dikirimkan form.php
$id_judul = $_GET['id_judul'];

//mengambil data
$query = mysqli_query($conn, "SELECT * FROM judul WHERE id_judul='$id_judul'");
$mahasiswa = mysqli_fetch_array($query);
$data = array(
            'deskripsi' =>  $mahasiswa['deskripsi_judul'],);
//tampil data
echo json_encode($data);
?>