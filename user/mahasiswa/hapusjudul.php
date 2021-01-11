<?php 
require '../../koneksi.php';
$id=$_GET["id_judul"];
$decode = base64_decode($id);
// cek status judul 
$cekstatus = mysqli_query($conn, "SELECT * FROM judul WHERE id_judul='$decode' AND status_judul='Menunggu'") or die (mysqli_erorr($conn));
$cekstatus2 = mysqli_query($conn, "SELECT * FROM judul WHERE id_judul='$decode' AND status_judul='Disetujui'") or die (mysqli_erorr($conn));
if (mysqli_num_rows($cekstatus)>0) {
	echo "<script>
      alert('Status Judul Anda Masih Menunggu! Anda Tidak Dapat Menghapus Judul Ini !! ')
      windows.location.href('datajudul.php')
      </script>";
}else if (mysqli_num_rows($cekstatus2)>0) {
	echo "<script>
      alert('Status Judul Anda Sudah Disetujui! Anda Tidak Dapat Menghapus Judul Ini !! ')
      windows.location.href('datajudul.php')
      </script>";
}else {
//hapus atau nonaktifkan judul
  $updatejudul = mysqli_query($conn, "UPDATE judul SET status='1' WHERE id_judul='$decode'") or die (mysqli_erorr($conn));
  if ($updatejudul) {
    echo "<script>
      alert('Judul Berhasil Dihapus')
      window.location.href('datajudul.php')
      </script>";
    // header('location:datajudul.php');
  }else {
    echo "<script>
      alert('Judul Gagal Dihapus')
      window.location.href('datajudul.php')
      </script>";
  }
}
 ?>