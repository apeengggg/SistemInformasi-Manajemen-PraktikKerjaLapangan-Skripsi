<?php

$date = date('Y-m-d');

// cek bimbingan pkl baru
$pkl1 = mysqli_query($conn, "SELECT * FROM pkl_bim WHERE nidn='$nidn' 
 AND status_dosbing='Belum Dibaca' AND status='Bimbingan Laporan'") 
or die (mysqli_error($conn));
// bimbingan pascsa sidang pkl
$pkl2 = mysqli_query($conn, "SELECT * FROM pkl_bim WHERE nidn='$nidn' 
 AND status='Bimbingan Pasca' AND status_dosbing='Belum Dibaca'") 
or die (mysqli_error($conn));
// bimbingan proposal
$prop1 = mysqli_query($conn, "SELECT * FROM proposal_bim WHERE pembimbing='$nidn' 
 AND status='Bimbingan Proposal' AND status_dosbing='Belum Dibaca'") 
or die (mysqli_error($conn));
// bimbingan pasca propsoal
$prop2 = mysqli_query($conn, "SELECT * FROM proposal_bim WHERE pembimbing='$nidn' 
 AND status='Bimbingan Pasca' AND status_dosbing='Belum Dibaca'") 
or die (mysqli_error($conn));
// bimbingan draft
$draft = mysqli_query($conn, "SELECT * FROM skripsi_bim WHERE pembimbing='$nidn' 
 AND status='Bimbingan Draft' AND status_dosbing='Belum Dibaca'") 
or die (mysqli_error($conn));
// bimbingan pendadaran
$pend = mysqli_query($conn, "SELECT * FROM skripsi_bim WHERE pembimbing='$nidn' 
 AND status='Bimbingan Pendadaran' AND status_dosbing='Belum Dibaca'") 
or die (mysqli_error($conn));
// bimbingan pasca sidang
$pend2 = mysqli_query($conn, "SELECT * FROM skripsi_bim WHERE pembimbing='$nidn' 
 AND status='Bimbingan Pasca' AND status_dosbing='Belum Dibaca'") 
or die (mysqli_error($conn));
// pengajuan judul
$judul = mysqli_query($conn, "SELECT * FROM judul WHERE tujuan='$nidn' 
 AND status_judul='Menunggu'") 
or die (mysqli_error($conn));

$valpkl = mysqli_query($conn, "SELECT * FROM pkl_sidang ps INNER JOIN pkl p ON ps.id_pkl=p.id_pkl INNER JOIN dosen_wali dw
ON p.id_dosenwali=dw.id_dosenwali INNER JOIN dosen d 
ON dw.nidn=d.nidn WHERE d.nidn='$nidn' AND val_dosbing='0'");

$valprop = mysqli_query($conn, "SELECT * FROM proposal_sidang ps INNER JOIN proposal p ON ps.id_proposal=p.id_proposal
INNER JOIN dosen d ON p.dosbing=d.nidn WHERE p.dosbing='$nidn' AND val_dosbing='0'");

$valdraft = mysqli_query($conn, "SELECT * FROM draft_sidang ds INNER JOIN skripsi s
ON ds.id_skripsi=s.id_skripsi INNER JOIN skripsi_dosbing sd 
ON s.id_skripsi=sd.id_skripsi WHERE sd.nidn='$nidn' AND (val_dosbing1='0' OR val_dosbing2='0')");

$valpend = mysqli_query($conn, "SELECT * FROM pend_sidang ps INNER JOIN skripsi s
ON ps.id_skripsi=s.id_skripsi INNER JOIN skripsi_dosbing sd 
ON s.id_skripsi=sd.id_skripsi WHERE sd.nidn='$nidn' AND (val_dosbing1='0' OR val_dosbing2='0')");

$jadpkl = mysqli_query($conn, "SELECT * FROM pkl_sidang ps WHERE val_dosbing='2' AND 
(ps.tgl_sid IS NULL OR ps.ruang_sid IS NULL OR ps.waktu IS NULL  OR ps.penguji IS NULL) 
AND ps.status_sid IS NULL ");

$jadprop = mysqli_query($conn, "SELECT * FROM proposal_sidang ps LEFT JOIN proposal_penguji pp
ON ps.id_sidang=pp.id_sidang WHERE val_dosbing='2' AND 
(ps.tgl_sidang IS NULL OR ps.ruang_sidang IS NULL OR ps.waktu_sidang IS NULL  OR 
(pp.penguji IS NULL OR pp.penguji='')) 
AND ps.status_sidang IS NULL ");

$jaddraft = mysqli_query($conn, "SELECT * FROM draft_sidang ds LEFT JOIN draft_penguji dp
ON ds.id_sidang=dp.id_sidang WHERE (val_dosbing1='2' OR val_dosbing2='2') AND 
(ds.tgl_sidang IS NULL OR ds.ruang_sidang IS NULL OR ds.waktu_sidang IS NULL  OR 
(dp.penguji IS NULL OR dp.penguji='')) 
AND ds.status_sidang IS NULL ");

$jadpend = mysqli_query($conn, "SELECT * FROM pend_sidang ps LEFT JOIN pend_penguji pp
ON ps.id_sidang=pp.id_sidang WHERE (val_dosbing1='2' OR val_dosbing2='2') AND 
(ps.tgl_sidang IS NULL OR ps.ruang_sidang IS NULL OR ps.waktu_sidang IS NULL  OR 
(pp.penguji IS NULL OR pp.penguji='')) 
AND ps.status_sidang IS NULL ");

// $valdos = mysqli_query($conn, "SELECT * FROM mahasiswa m LEFT JOIN judul j ON m.nim=j.nim
// LEFT JOIN proposal p ON j.id_judul=p.id_judul LEFT JOIN skripsi s ON p.id_proposal=s.id_proposal
// LEFT JOIN skripsi_dosbing sd ON s.id_skripsi=sd.id_skripsi WHERE p.id_proposal IS NOT NULL 
// AND s.id_skripsi IS NOT NULL AND (sd.nidn IS NULL OR sd.nidn='')");

$dosprop = mysqli_query($conn, "SELECT * FROM judul INNER JOIN proposal p ON judul.id_judul=p.id_judul
WHERE judul.status_judul='Disetujui' AND (p.dosbing IS NULL OR p.dosbing='')");


$pkl1a = mysqli_num_rows($pkl1);
$pkl2a = mysqli_num_rows($pkl2);
$prop1a = mysqli_num_rows($prop1);
$prop2a = mysqli_num_rows($prop2);
$drafta = mysqli_num_rows($draft);
$penda = mysqli_num_rows($pend);
$pend2a = mysqli_num_rows($pend2);
$valpkla = mysqli_num_rows($valpkl);
$valpropa = mysqli_num_rows($valprop);
$valdrafta = mysqli_num_rows($valdraft);
$valpenda = mysqli_num_rows($valpend);
$jadpkla = mysqli_num_rows($jadpkl);
$jadpropa = mysqli_num_rows($jadprop);
$jaddrafta = mysqli_num_rows($jaddraft);
$jadpenda = mysqli_num_rows($jadpend);
// $valdosa = mysqli_num_rows($valdos);
$judula = mysqli_num_rows($judul);
$dospropa = mysqli_num_rows($dosprop);
$count = $dospropa+$pkl1a+$pkl2a+$prop1a+$prop2a+$drafta+$penda+$pend2a+$valpkla+$valpropa+$valdrafta+$valpenda+$judula+$jadpkla+$jadpropa+$jaddrafta+$jadpenda;
?>