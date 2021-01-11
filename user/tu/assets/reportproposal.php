<?php 
session_start();
require "../../../koneksi.php";
if (!isset($_SESSION["login_tu"])) {
header("location:../../index.php");
exit();
}
if	(isset($_POST['jadwalkan'])) {
$angkatan = $_POST["angkatan"];
$sql = mysqli_query($conn, "SELECT mahasiswa.nim, mahasiswa.nama, mahasiswa.status_proposal AS status,
                            judul.judul, d.nama_dosen AS pem, proposal.id_proposal AS id
                            FROM mahasiswa LEFT JOIN judul 
                            ON mahasiswa.nim=judul.nim
                            LEFT JOIN proposal
                            ON judul.id_judul=proposal.id_judul
                            LEFT JOIN dosen d
                            ON proposal.dosbing=d.nidn
                            WHERE (mahasiswa.angkatan='$angkatan' AND (judul.status_judul='Disetujui' OR judul.status_judul='Ditolak')
                            AND proposal.id_proposal IS NOT NULL) OR
                            (mahasiswa.angkatan='$angkatan' AND judul.status_judul IS NULL 
                            AND proposal.id_proposal IS NULL)
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
<td align="center" colspan="3"><h3>LAPORAN PROPOSAL MAHASISWA</h3></td>
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
                    <th width="250px">NAMA</th>
                    <th width="380px">JUDUL</th>
                    <th width="250px">PEMBIMBING</th>
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
                            <td>'.$d["pem"].'</td>
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