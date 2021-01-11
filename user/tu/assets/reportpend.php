<?php 
session_start();
require "../../../koneksi.php";
if (!isset($_SESSION["login_tu"])) {
header("location:../../index.php");
exit();
}
if	(isset($_POST['jadwalkan'])) {
$angkatan = $_POST["angkatan"];
$tgl_awal = $_POST["tgl_awal"];
$tgl_akhir = $_POST["tgl_akhir"];
if ($tgl_awal =="" AND $tgl_akhir !=="") {
    $sql = mysqli_query($conn, "SELECT DISTINCT
                            mahasiswa.nim, mahasiswa.nama, judul.judul, ps.tgl_sidang, ps.status_sidang,
                            (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd 
                            ON d1.nidn=sd.nidn 
                            WHERE sd.id_skripsi=s.id_skripsi LIMIT 0,1) AS pem1, 
                            (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN skripsi_dosbing sd
                            ON d2.nidn=sd.nidn 
                            WHERE sd.id_skripsi=s.id_skripsi LIMIT 1,1) as pem2,  
                            -- ambil data penguji1
                            (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN pend_penguji ppe
                            ON d1.nidn=ppe.penguji 
                            WHERE ppe.id_sidang=ps.id_sidang LIMIT 0,1) AS penguji1, 
                            -- ambil data penguji2
                            (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN pend_penguji ppe
                            ON d2.nidn=ppe.penguji 
                            WHERE ppe.id_sidang=ps.id_sidang LIMIT 1,1) as penguji2
                            FROM mahasiswa LEFT JOIN judul 
                            ON mahasiswa.nim=judul.nim
                            LEFT JOIN proposal
                            ON judul.id_judul=proposal.id_judul
                            LEFT JOIN skripsi s
                            ON proposal.id_proposal=s.id_proposal
                            LEFT JOIN dosen d1
                            ON proposal.dosbing=d1.nidn
                            LEFT JOIN pend_sidang ps 
                            ON s.id_skripsi=ps.id_skripsi
                            LEFT JOIN pend_penguji ppe
                            ON ps.id_sidang=ppe.id_sidang
                            WHERE mahasiswa.angkatan='$angkatan' AND 
                            ps.tgl_sidang ='$tgl_akhir' 
                            ORDER BY mahasiswa.nim ASC") or die (mysqli_erorr($conn));
    }elseif ($tgl_akhir=="" AND $tgl_awal !=="") {
        $sql = mysqli_query($conn, "SELECT DISTINCT
                            mahasiswa.nim, mahasiswa.nama, judul.judul, ps.tgl_sidang, ps.status_sidang,
                            (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd 
                            ON d1.nidn=sd.nidn 
                            WHERE sd.id_skripsi=s.id_skripsi LIMIT 0,1) AS pem1, 
                            (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN skripsi_dosbing sd
                            ON d2.nidn=sd.nidn 
                            WHERE sd.id_skripsi=s.id_skripsi LIMIT 1,1) as pem2,  
                            -- ambil data penguji1
                            (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN pend_penguji ppe
                            ON d1.nidn=ppe.penguji 
                            WHERE ppe.id_sidang=ps.id_sidang LIMIT 0,1) AS penguji1, 
                            -- ambil data penguji2
                            (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN pend_penguji ppe
                            ON d2.nidn=ppe.penguji 
                            WHERE ppe.id_sidang=ps.id_sidang LIMIT 1,1) as penguji2
                            FROM mahasiswa LEFT JOIN judul 
                            ON mahasiswa.nim=judul.nim
                            LEFT JOIN proposal
                            ON judul.id_judul=proposal.id_judul
                            LEFT JOIN skripsi s
                            ON proposal.id_proposal=s.id_proposal
                            LEFT JOIN dosen d1
                            ON proposal.dosbing=d1.nidn
                            LEFT JOIN pend_sidang ps 
                            ON s.id_skripsi=ps.id_skripsi
                            LEFT JOIN pend_penguji ppe
                            ON ps.id_sidang=ppe.id_sidang
                            WHERE mahasiswa.angkatan='$angkatan' AND 
                            ps.tgl_sidang ='$tgl_awal' 
                            ORDER BY mahasiswa.nim ASC") or die (mysqli_erorr($conn));
        }elseif ($tgl_awal!=="" AND $tgl_akhir!=="") {
            $sql = mysqli_query($conn, "SELECT DISTINCT
                            mahasiswa.nim, mahasiswa.nama, judul.judul, ps.tgl_sidang, ps.status_sidang,
                            (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd 
                            ON d1.nidn=sd.nidn 
                            WHERE sd.id_skripsi=s.id_skripsi LIMIT 0,1) AS pem1, 
                            (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN skripsi_dosbing sd
                            ON d2.nidn=sd.nidn 
                            WHERE sd.id_skripsi=s.id_skripsi LIMIT 1,1) as pem2,  
                            -- ambil data penguji1
                            (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN pend_penguji ppe
                            ON d1.nidn=ppe.penguji 
                            WHERE ppe.id_sidang=ps.id_sidang LIMIT 0,1) AS penguji1, 
                            -- ambil data penguji2
                            (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN pend_penguji ppe
                            ON d2.nidn=ppe.penguji 
                            WHERE ppe.id_sidang=ps.id_sidang LIMIT 1,1) as penguji2
                            FROM mahasiswa LEFT JOIN judul 
                            ON mahasiswa.nim=judul.nim
                            LEFT JOIN proposal
                            ON judul.id_judul=proposal.id_judul
                            LEFT JOIN skripsi s
                            ON proposal.id_proposal=s.id_proposal
                            LEFT JOIN dosen d1
                            ON proposal.dosbing=d1.nidn
                            LEFT JOIN pend_sidang ps 
                            ON s.id_skripsi=ps.id_skripsi
                            LEFT JOIN pend_penguji ppe
                            ON ps.id_sidang=ppe.id_sidang
                            WHERE mahasiswa.angkatan='$angkatan' AND 
                            (ps.tgl_sidang BETWEEN '$tgl_awal' AND'$tgl_akhir') 
                            ORDER BY mahasiswa.nim ASC") or die (mysqli_erorr($conn));
            }elseif ($tgl_awal =='' && $tgl_akhir=='') {
                $sql = mysqli_query($conn, "SELECT DISTINCT
                            mahasiswa.nim, mahasiswa.nama, judul.judul, ps.tgl_sidang, ps.status_sidang,
                            (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN skripsi_dosbing sd 
                            ON d1.nidn=sd.nidn 
                            WHERE sd.id_skripsi=s.id_skripsi LIMIT 0,1) AS pem1, 
                            (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN skripsi_dosbing sd
                            ON d2.nidn=sd.nidn 
                            WHERE sd.id_skripsi=s.id_skripsi LIMIT 1,1) as pem2,  
                            -- ambil data penguji1
                            (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN pend_penguji ppe
                            ON d1.nidn=ppe.penguji 
                            WHERE ppe.id_sidang=ps.id_sidang LIMIT 0,1) AS penguji1, 
                            -- ambil data penguji2
                            (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN pend_penguji ppe
                            ON d2.nidn=ppe.penguji 
                            WHERE ppe.id_sidang=ps.id_sidang LIMIT 1,1) as penguji2
                            FROM mahasiswa LEFT JOIN judul 
                            ON mahasiswa.nim=judul.nim
                            LEFT JOIN proposal
                            ON judul.id_judul=proposal.id_judul
                            LEFT JOIN skripsi s
                            ON proposal.id_proposal=s.id_proposal
                            LEFT JOIN dosen d1
                            ON proposal.dosbing=d1.nidn
                            LEFT JOIN pend_sidang ps 
                            ON s.id_skripsi=ps.id_skripsi
                            LEFT JOIN pend_penguji ppe
                            ON ps.id_sidang=ppe.id_sidang
                            WHERE (mahasiswa.angkatan='2016' AND judul.status_judul='Disetujui' 
                            AND s.id_skripsi IS NOT NULL) OR
                            (mahasiswa.angkatan='2016' AND judul.status_judul IS NULL 
                            AND ps.id_sidang IS NULL)
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
  <title>Laporan Sidang Pendadaran</title>
</head>

<body>';

$data .= '
<table align="center">
<tr>
<td align="center" colspan="3"><h3>LAPORAN SIDANG PENDADARAN MAHASISWA</h3></td>
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
$data.= '<h3>Laporan Sidang Proposal, Tanggal : '.$tgl_aw.' s/d '.$tgl_ak.'</h3>';
}elseif($tgl_awal =="" AND $tgl_akhir !==""){
    $data.= '<h3>Laporan Sidang Proposal, Tanggal : '.$tgl_ak.'</h3>';
}elseif($tgl_akhir =="" AND $tgl_awal !==""){
    $data.= '<h3>Laporan Sidang Proposal, Tanggal : '.$tgl_aw.'</h3>';
}elseif($tgl_awal =='' && $tgl_akhir==''){
    $data.= '<h3>Laporan Sidang Proposal, Tanggal : Keseluruhan</h3>';
}
$data .='<h3>Dicetak Oleh : Tata Usaha</h3>';
$data .='   <table border="1" cellpadding="10" cellspacing="0" align="center">
            <thead align="center">
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th width="200px">NAMA</th>
                    <th width="200px">JUDUL</th>
                    <th width="200px">PEMBIMBING 1</th>
                    <th width="200px">PEMBIMBING 2</th>
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
        if ($date == "") {
            $tgl="";
         }
                $data .=  '<tr height="700px">
                            <td>'.$no++.'</td>
                            <td>'.$d["nim"].'</td>
                            <td>'.$d["nama"].'</td>
                            <td>'.$d["judul"].'</td>
                            <td>'.$d["pem1"].'</td>
                            <td>'.$d["pem2"].'</td>
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
$mpdf->Output('laporan-data-pendadaran.pdf', 'I');
}
?>