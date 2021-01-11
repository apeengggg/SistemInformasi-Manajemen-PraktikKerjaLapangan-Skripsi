<?php 
session_start();
require "../../../koneksi.php";
if (!isset($_SESSION["login_kaprodi"])) {
header("location:../../index.php");
exit();
}
if	(isset($_POST['jadwalkan'])) {
$angkatan = $_POST["angkatan"];
$tgl_awal = $_POST["tgl_awal"];
$tgl_akhir = $_POST["tgl_akhir"];
// $a = strtotime($tgl_awal);
// $a = strtotime($tgl_a);
// echo $a; die;
// jika tanggal awal kosong
if ($tgl_awal =="" AND $tgl_akhir !=="") {
$sql = mysqli_query($conn, "SELECT mahasiswa.nim, mahasiswa.nama,
pkl.judul_laporan, d1.nama_dosen AS pem,
pkl_sidang.tgl_sid, d2.nama_dosen AS peng, pkl_sidang.status_sid
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
WHERE mahasiswa.angkatan='$angkatan' AND 
pkl_sidang.tgl_sid = '$tgl_akhir' 
ORDER BY mahasiswa.nim ASC") or die (mysqli_erorr($conn));
// jika tgl akhir kosong
    }elseif ($tgl_akhir=="" AND $tgl_awal !=="") {
        $sql = mysqli_query($conn, "SELECT mahasiswa.nim, mahasiswa.nama,
        pkl.judul_laporan, d1.nama_dosen AS pem,
        pkl_sidang.tgl_sid, d2.nama_dosen AS peng, pkl_sidang.status_sid
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
        WHERE mahasiswa.angkatan='$angkatan' AND 
        pkl_sidang.tgl_sid = '$tgl_awal' 
        ORDER BY mahasiswa.nim ASC") or die (mysqli_erorr($conn));
// jika tanggal akhir dan awal tidak kosong
        }elseif ($tgl_awal!=="" AND $tgl_akhir!=="") {
            $sql = mysqli_query($conn, "SELECT mahasiswa.nim, mahasiswa.nama,
            pkl.judul_laporan, d1.nama_dosen AS pem,
            pkl_sidang.tgl_sid, d2.nama_dosen AS peng, pkl_sidang.status_sid
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
            WHERE mahasiswa.angkatan='$angkatan' AND 
            (pkl_sidang.tgl_sid BETWEEN '$tgl_awal' AND'$tgl_akhir') 
            ORDER BY mahasiswa.nim ASC") or die (mysqli_erorr($conn));
}elseif ($tgl_awal =='' && $tgl_akhir==''){
    $sql = mysqli_query($conn, "SELECT mahasiswa.nim, mahasiswa.nama,
    pkl.judul_laporan, d1.nama_dosen AS pem,
    pkl_sidang.tgl_sid, d2.nama_dosen AS peng, pkl_sidang.status_sid
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
    WHERE mahasiswa.angkatan='$angkatan'
    ORDER BY mahasiswa.nim ASC") or die (mysqli_erorr($conn));
}

require_once "../../../plugins/mpdf/autoload.php";

$mpdf = new \Mpdf\Mpdf(['format' => 'Legal']);
$mpdf->AddPage('L');

$data .= '
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Sidang Praktik Kerja Lapangan</title>
</head>
<body>';

$data .= '
<table align="center">
<tr>
<td align="center" colspan="3"><h3>LAPORAN SIDANG PRAKTIK KERJA LAPANGAN MAHASISWA</h3></td>
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
$tgl_aw = date('d-M-Y', strtotime($tgl_awal));
$tgl_ak = date('d-M-Y', strtotime($tgl_akhir));
$data .='
        <h3>Dicetak Pada : '.$tgl.'</h3>
        <h3>Angkatan : '.$angkatan.'</h3>';
if ($tgl_awal !=="" AND $tgl_akhir !=="") {
$data.= '<h3>Laporan Sidang Praktik Kerja Lapangan, Tanggal : '.$tgl_aw.' s/d '.$tgl_ak.'</h3>';
}elseif($tgl_awal =="" AND $tgl_akhir !==""){
    $data.= '<h3>Laporan Sidang Praktik Kerja Lapangan, Tanggal : '.$tgl_ak.'</h3>';
}elseif($tgl_akhir =="" AND $tgl_awal !==""){
    $data.= '<h3>Laporan Sidang Praktik Kerja Lapangan, Tanggal : '.$tgl_aw.'</h3>';
}elseif($tgl_awal =='' && $tgl_akhir==''){
    $data.= '<h3>Laporan Sidang Praktik Kerja Lapangan, Tanggal : Keseluruhan</h3>';
}
$data .='<h3>Dicetak Oleh : Kaprodi</h3>';
$data.= '<table border="1" cellpadding="10" cellspacing="0">
            <thead align="center">
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th width="200px">NAMA</th>
                    <th width="250px">JUDUL</th>
                    <th width="200px">PEMBIMBING</th>
                    <th width="80">TANGGAL SIDANG</th>
                    <th width="200px">PENGUJI</th>
                    <th width="70px">HASIL SIDANG</th>
                </tr>
            </thead>';
        $no = 1;
       foreach ($sql as $key => $d) {
                $date = $d["tgl_sid"];
                $tgl = date('d-M-Y', strtotime($date));
                if ($date == "") {
                    $tgl="";
                }
                $data .=  '<tr height="700px">
                            <td>'.$no++.'</td>
                            <td>'.$d["nim"].'</td>
                            <td>'.$d["nama"].'</td>
                            <td>'.$d["judul_laporan"].'</td>
                            <td>'.$d["pem"].'</td>
                            <td>'.$tgl.'</td>
                            <td>'.$d["peng"].'</td>
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