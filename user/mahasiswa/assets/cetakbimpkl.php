<?php 
session_start();
require "../../../koneksi.php";
if (!isset($_SESSION["login_mhs"])) {
header("location:../../index.php");
exit();
}
$nim = $_SESSION["nim"];

$status = mysqli_query($conn, "SELECT * FROM pkl_bim WHERE nim='$nim' AND status='Bimbingan Laporan'
                        AND status_bim='Layak'");
if (mysqli_num_rows($status)===0) {
    echo "<script>
    window.alert('gagal mencetak atau mengeksport kartu bimbingan')
    window.location.href('../bimbinganpkl.php')
    </script>
    <a href='../bimbinganpkl.php'>Klik disini jika tidak kembali ke halaman Bimbingan PKL</a>
";
}else{

// ambil data pkl mahasiswa
$bio = mysqli_query($conn, 
"SELECT mhs.nim, mhs.nama, mhs.prodi, pkl.judul_laporan, pkl.instansi, dosen.nama_dosen
FROM mahasiswa mhs LEFT JOIN pkl
ON mhs.nim=pkl.nim 
LEFT JOIN dosen_wali
ON pkl.id_dosenwali=dosen_wali.id_dosenwali
LEFT JOIN dosen 
ON dosen_wali.nidn=dosen.nidn
WHERE mhs.nim='$nim'") or die (mysqli_error($conn));
$d1 = mysqli_fetch_array($bio);
//  ambil data bimbingan mahasiswa
$bim = mysqli_query($conn, 
"SELECT bim.subjek, bim.tanggal, bim.pesan, bim.status_bim
        FROM pkl_bim bim LEFT JOIN pkl
        ON bim.id_pkl=pkl.id_pkl
        LEFT JOIN mahasiswa mhs
        ON pkl.nim=mhs.nim 
        LEFT JOIN dosen
        ON bim.nidn=dosen.nidn
        WHERE bim.nim='$nim' ORDER BY tanggal ASC") or die (mysqli_error($conn));

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
<td align="center" colspan="3"><h3>PROGRESS BIMBINGAN</h3></td>
</tr>
<tr>
<td align="center" colspan="3"><h3>PRAKTIK KERJA LAPANGAN</h3></td>
</tr>
<tr>
<td align="center" colspan="3"><br></td>
</tr>
<tr>
<td width="180px">NAMA</td>
<td width="20px">:</td>
<td width="500px">'.$d1["nama"].'</td>
</tr>
<tr>
<td width="180px">NIM</td>
<td width="20px">:</td>
<td width="500px">'.$d1["nim"].'</td>
</tr>
<tr>
<td width="180px">PROGRAM STUDI</td>
<td width="20px">:</td>
<td width="500px">'.$d1["prodi"].'</td>
</tr>
<tr>
<td width="180px">PEMBIMBING</td>
<td width="20px">:</td>
<td width="500px">'.$d1["nama_dosen"].'</td>
</tr>
<tr>
<td width="180px">JUDUL</td>
<td width="20px">:</td>
<td width="500px">'.$d1["judul_laporan"].'</td>
</tr>
</table>
<BR>';

$data .='
        <table border="1" cellpadding="10" cellspacing="0" width="700px">
            <thead align="center">
                <tr>
                    <th width="30px">No</th>
                    <th width="100px">Tanggal</th>
                    <th width="150px">Subjek Bimbingan</th>
                    <th width="150px">Hasil Bimbingan</th>
                    <th width="100px">Keterangan</th>
                </tr>
            </thead>';
        $no = 1;
        foreach ($bim as $key => $d) {
            $data .=  '<tr height="700px">
            <td>'.$no++.'</td>
            <td>'.$d["tanggal"].'</td>
            <td>'.$d["subjek"].'</td>
            <td>'.$d["pesan"].'</td>
            <td>'.$d["status_bim"].'</td>
            </tr>';
        }

$data .='
        </tbody>
        </table>';

$data .='
Dinyatakan mengikuti / tidak seminar pkl
<br>
<table>
<tr>
<td width="180px" height="50px" colspan="4">Cirebon, .................................... </td>
</tr>
<tr>
<td width="180px">Pembimbing</td>
<td width="180px"></td>
<td width="200px"></td>
<td width="170px">Pembimbing Lapangan</td>
</tr>
<tr>
<td width="180px"></td>
<td width="180px"></td>
<td width="200px"></td>
<td width="170px" height="120px"></td>
</tr>
<tr>
<td width="180px">(Nama Jelas & Gelar)</td>
<td width="180px"></td>
<td width="200px"></td>
<td width="170px" height="50px">(Nama Jelas & Gelar)</td>
</tr>
<tr>
<td width="180px" colspan="4">* Coret yang tidak perlu (minimal 10 kali Bimbingan)</td>
</tr>
</table>
</body>
</html>
';


$mpdf->WriteHTML($data);
$mpdf->Output('kartu-bimbingan.pdf', 'D');
    }
?>