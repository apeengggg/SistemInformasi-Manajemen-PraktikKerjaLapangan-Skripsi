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
if	(isset($_POST['jadwalkan'])) {
$angkatan = $_POST["angkatan"];
$sql = mysqli_query($conn, "SELECT mahasiswa.nim, mahasiswa.nama,
                            pkl.judul_laporan, d1.nama_dosen AS pem,
                            pkl_sidang.tgl_sid, d2.nama_dosen AS peng, pkl_sidang.status_sid, d2.nidn
                            FROM mahasiswa LEFT JOIN pkl
                            ON mahasiswa.nim=pkl.nim
                            LEFT JOIN dosen_wali
                            ON pkl.id_dosenwali=dosen_wali.id_dosenwali
                            LEFT JOIN dosen d1
                            ON dosen_wali.nidn=d1.nidn
                            LEFT JOIN pkl_sidang
                            ON pkl.id_pkl=pkl_sidang.id_pkl
                            LEFT JOIN dosen d2
                            ON pkl_sidang.penguji=d2.nidn
                            WHERE mahasiswa.angkatan='$angkatan' AND d2.nidn='$nidn' ORDER BY mahasiswa.nim ASC") or die
                            (mysqli_erorr($conn));
                            
$sql2 = mysqli_query($conn, "SELECT d2.nama_dosen AS peng
                            FROM mahasiswa LEFT JOIN pkl
                            ON mahasiswa.nim=pkl.nim
                            LEFT JOIN dosen_wali
                            ON pkl.id_dosenwali=dosen_wali.id_dosenwali
                            LEFT JOIN dosen d1
                            ON dosen_wali.nidn=d1.nidn
                            LEFT JOIN pkl_sidang
                            ON pkl.id_pkl=pkl_sidang.id_pkl
                            LEFT JOIN dosen d2
                            ON pkl_sidang.penguji=d2.nidn
                            WHERE mahasiswa.angkatan='$angkatan' AND d2.nidn='$nidn' ORDER BY mahasiswa.nim ASC") or die
                            (mysqli_erorr($conn));
$result = mysqli_fetch_array($sql2);
$peng = $result['peng'];


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
<td align="center" colspan="3"><h3>LAPORAN PENGUJIAN SIDANG PRAKTIK KERJA LAPANGAN MAHASISWA</h3></td>
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
        <h3>Nama Penguji : '.$peng.'</h3>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead align="center">
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th width="200px">NAMA</th>
                    <th width="550px">JUDUL</th>
                    <th width="200px">PEMBIMBING</th>
                    <th width="80">TANGGAL SIDANG</th>
                    <th width="70px">HASIL SIDANG</th>
                </tr>
            </thead>';
        $no = 1;
       foreach ($sql as $key => $d) {
                $date = $d["tgl_sid"];
                $tgl = date('d-M-Y', strtotime($date));
                $data .=  '<tr height="700px">
                            <td>'.$no++.'</td>
                            <td>'.$d["nim"].'</td>
                            <td>'.$d["nama"].'</td>
                            <td>'.$d["judul_laporan"].'</td>
                            <td>'.$d["pem"].'</td>
                            <td>'.$tgl.'</td>
                            <td>'.$d["status_sid"].'</td>
                            </tr>';
             }

$data .='
        </tbody>
        </table>
</body>
</html>
';


$mpdf->WriteHTML($data);
$mpdf->Output('laporan-sidang-pkl.pdf', 'I');
}
?>