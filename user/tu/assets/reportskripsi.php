<?php 
session_start();
require "../../../koneksi.php";
if (!isset($_SESSION["login_tu"])) {
header("location:../../index.php");
exit();
}
if	(isset($_POST['jadwalkan'])) {
$angkatan = $_POST["angkatan"];
$sql = mysqli_query($conn, "SELECT DISTINCT 
                            mahasiswa.nim, mahasiswa.nama, mahasiswa.status_skripsi AS status,
                            judul.judul, s.id_skripsi AS id,
                            (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd 
                            ON d1.nidn=sd.nidn 
                            WHERE sd.id_skripsi=s.id_skripsi LIMIT 0,1) AS pem1, 
                            (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN skripsi_dosbing sd
                            ON d2.nidn=sd.nidn 
                            WHERE sd.id_skripsi=s.id_skripsi LIMIT 1,1) as pem2 
                            FROM mahasiswa LEFT JOIN judul 
                            ON mahasiswa.nim=judul.nim
                            LEFT JOIN proposal
                            ON judul.id_judul=proposal.id_judul
                            LEFT JOIN skripsi s
                            ON proposal.id_proposal=s.id_proposal
                            LEFT JOIN skripsi_dosbing sd
                            ON s.id_skripsi=sd.id_skripsi
                            WHERE (mahasiswa.angkatan='2016' AND (judul.status_judul='Disetujui' OR 										judul.status_judul='Ditolak')
                            AND s.id_skripsi IS NOT NULL) OR
                            (mahasiswa.angkatan='2016' AND judul.status_judul IS NULL 
                            AND s.id_skripsi IS NULL)
                            ORDER BY mahasiswa.nim ASC") or die
                            (mysqli_erorr($conn));

require_once "../../../plugins/mpdf/autoload.php";

$mpdf = new \Mpdf\Mpdf(['format' => 'Legal']);
$mpdf->AddPage('L');

$data .= '
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cetak kartu bimbingan</title>
</head>

<body>';

$data .= '
<table align="center">
<tr>
<td align="center" colspan="3"><h3>LAPORAN SKRIPSI MAHASISWA</h3></td>
</tr>
<tr>
<td align="center" colspan="3"><h3>PRODI TEKNIK INFROMATIKA</h3></td>
</tr>
<tr>
<td align="center" colspan="3"><br></td>
</tr>
</table>
<BR>';
$tgl = date('d-M-Y');
$data .='
<h3>Dicetak Pada : '.$tgl.'</h3>
<h3>Angkatan : '.$angkatan.'</h3>
<h3>Dicetak Oleh : Tata Usaha</h3>
        <table border="1" cellpadding="10" cellspacing="0" align="center">
            <thead align="center">
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th width="200px">NAMA</th>
                    <th width="300px">JUDUL</th>
                    <th width="200px">PEMBIMBING 1</th>
                    <th width="200px">PEMBIMBING 2</th>
                    <th width="70px">STATUS</th>
                    <th>KETERANGAN</th>
                </tr>
            </thead>';
        $no = 1;
       foreach ($sql as $key => $d) {
        if ($d["id"]=="" OR $d["id"] == NULL) {
           $a = "Belum Melaksanakan";
        }else {
           $a = "Sudah/Sedang Melaksanakan";
        }
                $data .=  '<tr height="700px">
                            <td>'.$no++.'</td>
                            <td>'.$d["nim"].'</td>
                            <td>'.$d["nama"].'</td>
                            <td>'.$d["judul"].'</td>
                            <td>'.$d["pem1"].'</td>
                            <td>'.$d["pem2"].'</td>
                            <td>'.$d["status"].'</td>
                            <td>'.$a.'</td>
                            </tr>';
             }

$data .='
        </tbody>
        </table>
</body>
</html>
';


$mpdf->WriteHTML($data);
$mpdf->Output('laporan-data-proposal.pdf', 'I');
}
?>