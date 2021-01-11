<?php

// cek bimbingan pkl baru
$pkl1 = mysqli_query($conn, "SELECT * FROM pkl_bim WHERE nim='$nim' 
AND status_mhs='Belum Dibaca' AND status_dosbing='Dibalas' AND status='Bimbingan Laporan'") 
or die (mysqli_error($conn));
// bimbingan pascsa sidang pkl
$pkl2 = mysqli_query($conn, "SELECT * FROM pkl_bim WHERE nim='$nim' 
AND status_mhs='Belum Dibaca' AND status='Bimbingan Pasca' AND status_dosbing='Dibalas'") 
or die (mysqli_error($conn));
// bimbingan proposal
$prop1 = mysqli_query($conn, "SELECT * FROM proposal_bim WHERE nim='$nim' 
AND status_mhs='Belum Dibaca' AND status='Bimbingan Proposal' AND status_dosbing='Dibalas'") 
or die (mysqli_error($conn));
// bimbingan pasca propsoal
$prop2 = mysqli_query($conn, "SELECT * FROM proposal_bim WHERE nim='$nim' 
AND status_mhs='Belum Dibaca' AND status='Bimbingan Pasca' AND status_dosbing='Dibalas'") 
or die (mysqli_error($conn));
// bimbingan draft
$draft = mysqli_query($conn, "SELECT * FROM skripsi_bim WHERE nim='$nim' 
AND status_mhs='Belum Dibaca' AND status='Bimbingan Draft' AND status_dosbing='Dibalas'") 
or die (mysqli_error($conn));
// bimbingan pendadaran
$pend = mysqli_query($conn, "SELECT * FROM skripsi_bim WHERE nim='$nim' 
AND status_mhs='Belum Dibaca' AND status='Bimbingan Pendadaran' AND status_dosbing='Dibalas'") 
or die (mysqli_error($conn));
// bimbingan pasca sidang
$pend2 = mysqli_query($conn, "SELECT * FROM skripsi_bim WHERE nim='$nim' 
AND status_mhs='Belum Dibaca' AND status='Bimbingan Pasca'") 
or die (mysqli_error($conn));

$p1 = mysqli_num_rows($pkl1);
$p2 = mysqli_num_rows($pkl2);
$p11 = mysqli_num_rows($prop1);
$p12 = mysqli_num_rows($prop2);
$d1 = mysqli_num_rows($draft);
$pe1 = mysqli_num_rows($pend);
$pe2 = mysqli_num_rows($pend2);

$count = $p1+$p2+$p11+$p12+$d1+$pe1+$pe2;
if ($count > 0) {
?>
<style>
.jumlah {
  animation: blink-animation 1s steps(5, start) infinite;
  -webkit-animation: blink-animation 1s steps(5, start) infinite;
}
@keyframes blink-animation {
  to {
    visibility: hidden;
  }
}
@-webkit-keyframes blink-animation {
  to {
    visibility: hidden;
  }
}
</style>
<?php }
?>