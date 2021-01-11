<?php 
session_start();
require "../../../koneksi.php";
if (!isset($_SESSION["login_dosen"])) {
    if (!isset($_SESSION["login_kaprodi"])){
      if (!isset($_SESSION["login_pa"])) {
        header("location:../../index.php");
        exit();
      }
    }
  }
$nidn=$_SESSION["nidn"];
$nama = $_SESSION["nama_dosen"];
if	(isset($_POST['jadwalkan'])) {
$angkatan = $_POST["angkatan"];
$sql = mysqli_query($conn, "SELECT DISTINCT 
mahasiswa.nim, mahasiswa.nama, judul.judul, judul.status_judul,
d1.nama_dosen AS pem, ps.tgl_sidang, ps.status_sidang,
-- ambil data penguji1
(SELECT d2.nama_dosen FROM dosen d2 INNER JOIN proposal_penguji pp
ON d2.nidn=pp.penguji 
WHERE pp.id_sidang=ps.id_sidang AND status_penguji='Penguji 1' AND pp.status='Aktif') AS penguji1,
-- ambil data penguji1
(SELECT d2.nidn FROM dosen d2 INNER JOIN proposal_penguji pp
ON d2.nidn=pp.penguji 
WHERE pp.id_sidang=ps.id_sidang AND status_penguji='Penguji 1' AND pp.status='Aktif') AS nidn1,
-- ambil data penguji2
(SELECT d3.nama_dosen FROM dosen d3 INNER JOIN proposal_penguji pp
ON d3.nidn=pp.penguji 
WHERE pp.id_sidang=ps.id_sidang AND status_penguji='Penguji 2' AND pp.status='Aktif') as penguji2,
-- ambil data penguji2
(SELECT d3.nidn FROM dosen d3 INNER JOIN proposal_penguji pp
ON d3.nidn=pp.penguji 
WHERE pp.id_sidang=ps.id_sidang AND status_penguji='Penguji 2' AND pp.status='Aktif') as nidn2
FROM mahasiswa LEFT JOIN judul 
ON mahasiswa.nim=judul.nim
LEFT JOIN proposal
ON judul.id_judul=proposal.id_judul
LEFT JOIN dosen d1
ON proposal.dosbing=d1.nidn
LEFT JOIN proposal_sidang ps 
ON proposal.id_proposal=ps.id_proposal
LEFT JOIN proposal_penguji pp
ON ps.id_sidang=pp.id_sidang
WHERE pp.penguji ='$nidn' AND pp.status='Aktif' AND mahasiswa.angkatan='$angkatan' ORDER BY ps.tgl_sidang ASC") or die (mysqli_erorr($conn));

require_once "../../../plugins/mpdf/autoload.php";

$mpdf = new \Mpdf\Mpdf(['format' => 'Legal']);
$mpdf->AddPage('L');
$data .= '
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Pengujian Sidang</title>
</head>

<body>';

$data .= '
<table align="center">
<tr>
<td align="center" colspan="3"><h3>LAPORAN PENGUJIAN SIDANG PROPOSAL MAHASISWA</h3></td>
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
        <h3>Nama Penguji : '.$nama.'</h3>
        <table border="1" cellpadding="10" cellspacing="0" align="center">
            <thead align="center">
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th width="200px">NAMA</th>
                    <th width="200px">JUDUL</th>
                    <th width="200px">PEMBIMBING</th>
                    <th width="70px">TANGGAL SIDANG</th>
                    <th width="200px">PENGUJI 1</th>
                    <th width="200px">PENGUJI 2</th>
                    <th width="50px">HASIL</th>
                </tr>
            </thead>';
        $no = 1;
       foreach ($sql as $key => $d) {
        $date = $d["tgl_sidang"];
        $tgl = date('d-M-Y', strtotime($date));
                $data .=  '<tr height="700px">
                            <td>'.$no++.'</td>
                            <td>'.$d["nim"].'</td>
                            <td>'.$d["nama"].'</td>
                            <td>'.$d["judul"].'</td>
                            <td>'.$d["pem"].'</td>
                            <td>'.$tgl.'</td>
                            <td>'.$d["penguji1"].'</td>
                            <td>'.$d["penguji2"].'</td>
                            <td>'.$d["status_sidang"].'</td>
                            </tr>';
             }

$data .='
        </tbody>
        </table>
</body>
</html>
';


$mpdf->WriteHTML($data);
$mpdf->Output('laporan-sidang-proposal.pdf', 'I');
}
?>