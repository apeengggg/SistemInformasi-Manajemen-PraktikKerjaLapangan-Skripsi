<?php 
session_start();
require "../../../koneksi.php";
if (!isset($_SESSION["login_mhs"])) {
header("location:../../index.php");
exit();
}
$nim = $_SESSION["nim"];

$status = mysqli_query($conn, "SELECT * FROM skripsi_bim WHERE nim='$nim' AND status='Bimbingan Draft'
                        AND status_bim='Layak'");
if (mysqli_num_rows($status)===0) {
    echo "<script>
    window.alert('gagal mencetak atau mengeksport kartu bimbingan')
    window.location.href('../bimbingandraft.php')
    </script>
    <a href='../bimbingandraft.php'>Klik disini jika tidak kembali ke halaman Bimbingan PKL</a>
";
}else{

// ambil data pkl mahasiswa
$bio = mysqli_query($conn, 
"SELECT m.nim, m.nama, j.judul, 
(SELECT d.nama_dosen FROM dosen d INNER JOIN skripsi_dosbing sd ON d.nidn=sd.nidn
       WHERE sd.id_skripsi=s.id_skripsi AND sd.status='Aktif' AND sd.status_dosbing='Pembimbing 1') AS pem1,
(SELECT d.nama_dosen FROM dosen d INNER JOIN skripsi_dosbing sd ON d.nidn=sd.nidn
       WHERE sd.id_skripsi=s.id_skripsi AND sd.status='Aktif' AND sd.status_dosbing='Pembimbing 2') AS pem2
FROM mahasiswa m INNER JOIN judul j ON m.nim=j.nim INNER JOIN proposal p
ON j.id_judul=p.id_judul INNER JOIN skripsi s ON p.id_proposal=s.id_proposal
WHERE m.nim='$nim'") or die (mysqli_error($conn));
$d1 = mysqli_fetch_array($bio);
//  ambil data bimbingan mahasiswa
$bim = mysqli_query($conn, 
"SELECT bim.subjek, bim.tgl_bim, bim.saran, bim.status_bim
FROM skripsi_bim bim INNER JOIN skripsi s
ON bim.id_skripsi=s.id_skripsi INNER JOIN proposal p
ON s.id_proposal=p.id_proposal INNER JOIN judul j
ON p.id_judul=j.id_judul INNER JOIN mahasiswa m
ON j.nim=m.nim WHERE m.nim='$nim' AND bim.status='Bimbingan Draft'
ORDER BY bim.tgl_bim ASC") or die (mysqli_error($conn));

require_once "../../../plugins/mpdf/autoload.php";

$mpdf = new \Mpdf\Mpdf();

$data = '
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cetak kartu bimbingan</title>
</head>

<body>';

$data .= '
<table>
		<tr>
		<td><img src="../../../assets/logo.png" alt="logo-umc" width="100" height="100"></td>
		<td>
		<center>
			<font size="6" class="univ">UNIVERSITAS MUHAMMADIYAH CIREBON</font><BR>
			<font size="5" class="fakultas">FAKULTAS TEKNIK</font><BR>
			<font size="2">Kampus 1 : Jl. Tuparev No 70 Cirebon 45153 Telp. +62-231-209608, +62-231-204276, Fax +62-231-209608, +62-231-209617</font><BR>
			<font size="2">Email : ft@umc.ac.id Website : www.umc.ac.id </font><BR>
			<font size="2">Kampus 2 : Jl. Fathaillah - Watubelah - Cirebon, Email : rektorat@umc.ac.id Website : www.umc.ac.id</font><BR>
		</center>
		</td>
		</tr>
		<tr>
			<td colspan="2"><hr></td>
		</tr>
		</table>
<table>
<tr> 
<td align="center" colspan="3"><h4>LAPORAN KEMAJUAN TUGAS AKHIR/SKRIPSI</h4></td>
</tr>
<tr>
<td align="center" colspan="3"><h4>PROGRAM STUDI TEKNIK INFORMATIKA</h4></td>
</tr>
<tr>
<td align="center" colspan="3"><br></td>
</tr>
<tr>
<td width="180px">NIM</td>
<td width="10px">:</td>
<td width="500px">'.$d1["nim"].'</td>
</tr>
<tr>
<td width="180px">NAMA</td>
<td width="20px">:</td>
<td width="500px">'.$d1["nama"].'</td>
</tr>
<tr>
<td width="180px">PEMBIMBING 1</td>
<td width="20px">:</td>
<td width="500px">'.$d1["pem1"].'</td>
</tr>
<tr>
<td width="180px">PEMBIMBING 2</td>
<td width="20px">:</td>
<td width="500px">'.$d1["pem2"].'</td>
</tr>
<tr>
<td width="180px">JUDUL SKRIPSI</td>
<td width="20px">:</td>
<td width="500px">'.$d1["judul"].'</td>
</tr>
</table>
<BR>';

$data .='
        <table border="1" cellpadding="10" cellspacing="0" width="700px">
            <thead align="center">
                <tr>
                    <th width="30px">No</th>
                    <th width="100px">Tanggal</th>
                    <th width="100px">Subjek Bimbingan</th>
                    <th width="200px">Materi Bimbingan</th>
                    <th width="100px">Keterangan</th>
                </tr>
            </thead>';
        $no = 1;
        foreach ($bim as $key => $d) {
            $tgl = $d["tgl_bim"];
            $t = date('d-M-Y', strtotime($tgl));
            $data .=  '<tr height="700px">
            <td>'.$no++.'</td>
            <td>'.$t.'</td>
            <td>'.$d["subjek"].'</td>
            <td>'.$d["saran"].'</td>
            <td>'.$d["status_bim"].'</td>
            </tr>';
        }

$data .='
        </tbody>
        </table>';

$data .='
Berdasarkan hasil bimbingan diatas, kami selaku tim pembibing skripsi menyatakan bahwa mahasiswa tersebut layak untuk mengikuti sidang.
<br>
<table>
<tr>
<td width="180px" height="50px" colspan="4">Cirebon, .................................... </td>
</tr>
<tr>
<td width="180px">Pembimbing 1</td>
<td width="180px"></td>
<td width="200px"></td>
<td width="170px">Pembimbing 2</td>
</tr>
<tr>
<td width="180px"></td>
<td width="180px"></td>
<td width="200px"></td>
<td width="170px" height="80px"></td>
</tr>
<tr>
<td width="180px">..............................</td>
<td width="180px"></td>
<td width="200px"></td>
<td width="170px" height="50px">..............................</td>
</tr>
</table>
</body>
</html>
';


$mpdf->WriteHTML($data);
$mpdf->Output('kartu-bimbingan-draft.pdf', 'I');
    }
?>