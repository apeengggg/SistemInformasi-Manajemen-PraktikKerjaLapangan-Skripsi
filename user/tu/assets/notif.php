<?php
$date = date('Y-m-d');

// pendaftar sidang pkl
$pdpkl = mysqli_query($conn, "SELECT * FROM pkl_sidang LEFT JOIN pkl ON pkl_sidang.id_pkl=pkl.id_pkl 
                      LEFT JOIN mahasiswa ON pkl.nim=mahasiswa.nim
                      LEFT JOIN dosen ON pkl_sidang.penguji=dosen.nidn 
                      WHERE pkl_sidang.penguji IS NULL AND pkl_sidang.tgl_sid IS NULL 
                      AND pkl_sidang.waktu IS NULL AND pkl_sidang.ruang_sid IS NULL 
                      AND pkl_sidang.status_sid IS NULL AND pkl_sidang.val_dosbing='2'")
                      or die (mysqli_error($conn));
// pendaftar sidang proposal
$pdprop = mysqli_query($conn, "SELECT * FROM proposal_sidang ps LEFT JOIN proposal_penguji pp ON ps.id_sidang=pp.id_sidang
                        LEFT JOIN proposal p ON ps.id_proposal=p.id_proposal 
                        LEFT JOIN judul j ON p.id_judul=j.id_judul
                        LEFT JOIN mahasiswa m ON j.nim=m.nim 
                        LEFT JOIN dosen ON pp.penguji=dosen.nidn
                        WHERE ps.tgl_sidang IS NULL AND ps.waktu_sidang IS NULL 
                        AND ps.waktu_sidang IS NULL AND ps.ruang_sidang IS NULL
                        AND ps.status_sidang IS NULL AND ps.val_dosbing='2'")
                        or die (mysqli_error($conn));
// pendaftar sidang draft
$pddraft = mysqli_query($conn, "SELECT * FROM draft_sidang ds LEFT JOIN draft_penguji dp 
                                ON ds.id_sidang=dp.id_sidang LEFT JOIN skripsi s ON ds.id_skripsi=s.id_skripsi 
                                LEFT JOIN proposal p ON s.id_proposal=p.id_proposal
                                LEFT JOIN judul j ON p.id_judul=j.id_judul 
                                LEFT JOIN mahasiswa m ON j.nim=m.nim
                                WHERE ds.tgl_sidang IS NULL AND ds.waktu_sidang IS NULL 
                                AND ds.ruang_sidang IS NULL AND ds.status_sidang IS NULL
                                AND (val_dosbing1='2' OR val_dosbing2='2')")
                                or die (mysqli_error($conn));
// pendaftar sidang draft
$pdpend = mysqli_query($conn, "SELECT * FROM pend_sidang ps LEFT JOIN pend_penguji pp 
                      ON ps.id_sidang=pp.id_sidang LEFT JOIN skripsi s ON ps.id_skripsi=s.id_skripsi
                      LEFT JOIN proposal p ON s.id_proposal=p.id_proposal LEFT JOIN judul j ON p.id_judul=j.id_judul 
                      LEFT JOIN mahasiswa m ON j.nim=m.nim
                      WHERE ps.tgl_sidang IS NULL AND ps.waktu_sidang IS NULL AND ps.ruang_sidang IS NULL
                      AND ps.status_sidang IS NULL AND (val_dosbing1='2' OR val_dosbing2='2')")
                      or die (mysqli_error($conn));

$v1 = mysqli_query($conn, "SELECT * FROM pkl_syarat WHERE status='0'");
$v2 = mysqli_query($conn, "SELECT * FROM skripsi_syarat WHERE status='0'");
$sidpkl = mysqli_query($conn, "SELECT * FROM pkl_sidang WHERE tgl_sid='$date' AND status_sid IS NULL");
$sidprop = mysqli_query($conn, "SELECT * FROM proposal_sidang WHERE tgl_sidang='$date' AND status_sidang IS NULL");
$siddraft = mysqli_query($conn, "SELECT * FROM draft_sidang WHERE tgl_sidang='$date' AND status_sidang IS NULL");
$sidpend = mysqli_query($conn, "SELECT * FROM pend_sidang WHERE tgl_sidang='$date' AND status_sidang IS NULL");
?>




<?php
$pkl = mysqli_num_rows($pdpkl);
$prop = mysqli_num_rows($pdprop);
$draft = mysqli_num_rows($pddraft);
$pend = mysqli_num_rows($pdpend);
$vpkl = mysqli_num_rows($v1);
$vskripsi = mysqli_num_rows($v2);
$spkl = mysqli_num_rows($sidpkl);
$sprop = mysqli_num_rows($sidprop);
$sdraft = mysqli_num_rows($siddraft);
$spend = mysqli_num_rows($sidpend);

$count = $spkl+$sprop+$sdraft+$spend+$pkl+$prop+$draft+$pend+$vpkl+$vskripsi;

if ($count > 0) {
?>
<style>
.jumlah  {
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
<?php  } ?>

<!-- pendaftar sidang pendadaran -->