<?php
session_start();
$nim = $_SESSION["nim"];
// Load file koneksi.php
include "../../../koneksi.php";
// Load plugin PHPExcel nya
require_once '../../../plugins/PHPExcel/PHPExcel.php';

// Buat query untuk menampilkan semua data siswa

$sql = mysqli_query($conn, "SELECT 
                        m.nim, m.nama, m.prodi, d1.nama_dosen, pkl.judul_laporan
                        FROM pkl
                        LEFT JOIN dosen_wali
                        ON pkl.id_dosenwali=dosen_wali.id_dosenwali
                        LEFT JOIN dosen d1 
                        ON dosen_wali.nidn=d1.nidn
                        LEFT JOIN mahasiswa m
                        ON pkl.nim=m.nim 
                        WHERE m.nim='$nim'")
                        or die (mysqli_erorr($conn));
$data = mysqli_fetch_array($sql);
$nama=$data["nama"];
$niim=$data["nim"];
$prodi=$data["prodi"];
$pem=$data["nama_dosen"];
$judul=$data["judul_laporan"];


// Panggil class PHPExcel nya
$excel = new PHPExcel();

// Settingan awal file excel
$excel->getProperties()->setCreator('Mahasiswa')
             ->setLastModifiedBy('Mahasiswa')
             ->setTitle("Kartu-Bim-PKL")
             ->setSubject("KartuBimbingan")
             ->setDescription("KartuBimbingan")
             ->setKeywords("KartuBimbingan");

// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
$style_col = array(
'font' => array('bold' => true), // Set font nya jadi bold
'alignment' => array(
'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
),
'borders' => array(
'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
  )
);

// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
$style_row = array(
  'alignment' => array(
    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
  ),
  'borders' => array(
    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
  )
);

$excel->setActiveSheetIndex(0)->setCellValue('A1', "Kartu Bimbingan Laporan Praktik Kerja Lapangan"); // Set kolom A1 dengan tulisan "DATA SISWA"
$excel->getActiveSheet()->mergeCells('A1:I1'); // Set Merge Cell pada kolom A1 sampai F1
$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

$excel->setActiveSheetIndex(0)->setCellValue('A2', "NAMA"); // Set kolom A2 dengan tulisan "DATA SISWA"
$excel->getActiveSheet()->mergeCells('A2:B2'); // Set Merge Cell pada kolom A2 sampai F1
$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A2
$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(15); // Set font size 15 untuk kolom A2
$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); // Set text center untuk kolom A2
$excel->setActiveSheetIndex(0)->setCellValue('C2', "$nama"); // Set kolom A2 dengan tulisan "DATA SISWA"
$excel->getActiveSheet()->mergeCells('C2:D2'); // Set Merge Cell pada kolom A2 sampai F1
$excel->getActiveSheet()->getStyle('C2')->getFont()->setBold(TRUE); // Set bold kolom A2
$excel->getActiveSheet()->getStyle('C2')->getFont()->setSize(15); // Set font size 15 untuk kolom A2
$excel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); // Set text LEFT untuk kolom A2

$excel->setActiveSheetIndex(0)->setCellValue('A3', "NIM"); // Set kolom A3 dengan tulisan "DATA SISWA"
$excel->getActiveSheet()->mergeCells('A3:B3'); // Set Merge Cell pada kolom A3 sampai F1
$excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE); // Set bold kolom A3
$excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(15); // Set font size 15 untuk kolom A3
$excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); // Set text center untuk kolom A2
$excel->setActiveSheetIndex(0)->setCellValue('C3', "$niim"); // Set kolom B3 dengan tulisan "DATA SISWA"
$excel->getActiveSheet()->mergeCells('C3:D3'); // Set Merge Cell pada kolom B3 sampai F1
$excel->getActiveSheet()->getStyle('C3')->getFont()->setBold(TRUE); // Set bold kolom B3
$excel->getActiveSheet()->getStyle('C3')->getFont()->setSize(15); // Set font size 15 untuk kolom B3
$excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); // Set text center untuk kolom A2

$excel->setActiveSheetIndex(0)->setCellValue('A4', "PRODI"); // Set kolom A4 dengan tulisan "DATA SISWA"
$excel->getActiveSheet()->mergeCells('A4:B4'); // Set Merge Cell pada kolom A4 sampai F1
$excel->getActiveSheet()->getStyle('A4')->getFont()->setBold(TRUE); // Set bold kolom A4
$excel->getActiveSheet()->getStyle('A4')->getFont()->setSize(15); // Set font size 15 untuk kolom A4
$excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); // Set text center untuk kolom A2
$excel->setActiveSheetIndex(0)->setCellValue('C4', "$prodi"); // Set kolom B4 dengan tulisan "DATA SISWA"
$excel->getActiveSheet()->mergeCells('C4:D4'); // Set Merge Cell pada kolom B4 sampai F1
$excel->getActiveSheet()->getStyle('C4')->getFont()->setBold(TRUE); // Set bold kolom B4
$excel->getActiveSheet()->getStyle('C4')->getFont()->setSize(15); // Set font size 15 untuk kolom B4
$excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); // Set text center untuk kolom A2

$excel->setActiveSheetIndex(0)->setCellValue('A5', "NAMA PEMBIMBING"); // Set kolom A4 dengan tulisan "DATA SISWA"
$excel->getActiveSheet()->mergeCells('A5:B5'); // Set Merge Cell pada kolom A5 sampai F1
$excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE); // Set bold kolom A5
$excel->getActiveSheet()->getStyle('A5')->getFont()->setSize(15); // Set font size 15 untuk kolom A5
$excel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); // Set text center untuk kolom A2
$excel->setActiveSheetIndex(0)->setCellValue('C5', "$pem"); // Set kolom B5 dengan tulisan "DATA SISWA"
$excel->getActiveSheet()->mergeCells('C5:D5'); // Set Merge Cell pada kolom B5 sampai F1
$excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(TRUE); // Set bold kolom B5
$excel->getActiveSheet()->getStyle('C5')->getFont()->setSize(15); // Set font size 15 untuk kolom B5
$excel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); // Set text center untuk kolom A2

$excel->setActiveSheetIndex(0)->setCellValue('A6', "JUDUL"); // Set kolom A4 dengan tulisan "DATA SISWA"
$excel->getActiveSheet()->mergeCells('A6:B6'); // Set Merge Cell pada kolom A6 sampai F1
$excel->getActiveSheet()->getStyle('A6')->getFont()->setBold(TRUE); // Set bold kolom A6
$excel->getActiveSheet()->getStyle('A6')->getFont()->setSize(15); // Set font size 16 untuk kolom A6
$excel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); // Set text center untuk kolom A2
$excel->setActiveSheetIndex(0)->setCellValue('C6', "$judul"); // Set kolom B5 dengan tulisan "DATA SISWA"
$excel->getActiveSheet()->mergeCells('C6:D6'); // Set Merge Cell pada kolom B5 sampai F1
$excel->getActiveSheet()->getStyle('C6')->getFont()->setBold(TRUE); // Set bold kolom B5
$excel->getActiveSheet()->getStyle('C6')->getFont()->setSize(15); // Set font size 15 untuk kolom B5
$excel->getActiveSheet()->getStyle('C6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); // Set text center untuk kolom A2

// Buat header tabel nya pada baris ke 3
$excel->setActiveSheetIndex(0)->setCellValue('A8', "NO"); // Set kolom A4 dengan tulisan "NO"
$excel->setActiveSheetIndex(0)->setCellValue('B8', "TANGGAL"); // Set kolom B4 dengan tulisan "NIS"
$excel->setActiveSheetIndex(0)->setCellValue('C8', "SUBJEK BIMBINGAN"); // Set kolom C4 dengan tulisan "NAMA"
$excel->setActiveSheetIndex(0)->setCellValue('D8', "HASIL BIMBINGAN"); // Set kolom D4 dengan tulisan "JENIS KELAMIN"
$excel->setActiveSheetIndex(0)->setCellValue('E8', "KETERANGAN"); // Set kolom E4 dengan tulisan "TELEPON"

// Apply style header yang telah kita buat tadi ke masing-masing kolom header
$excel->getActiveSheet()->getStyle('A8')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('B8')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('C8')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('D8')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('E8')->applyFromArray($style_col);

// Set height baris ke 1, 2 dan 3
$excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
$excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
$excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

$sql1 = mysqli_query($conn, "SELECT 
                        m.nim, m.nama, m.prodi, d1.nama_dosen, pkl.judul_laporan,
                        bim.subjek, bim.pesan, bim.status_bim, bim.tanggal
                        FROM pkl_bim bim LEFT JOIN pkl
                        ON bim.id_pkl=pkl.id_pkl
                        LEFT JOIN dosen_wali
                        ON pkl.id_dosenwali=dosen_wali.id_dosenwali
                        LEFT JOIN dosen d1 
                        ON dosen_wali.nidn=d1.nidn
                        LEFT JOIN mahasiswa m
                        ON pkl.nim=m.nim 
                        WHERE m.nim='$nim' AND bim.status='Bimbingan Laporan'")
                        or die (mysqli_erorr($conn));

$no = 1; // Untuk penomoran tabel, di awal set dengan 1
$numrow = 9; // Set baris pertama untuk isi tabel adalah baris ke 4
while($data1 = mysqli_fetch_array($sql1)){ // Ambil semua data dari hasil eksekusi $sql
  $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
  $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data1['tanggal']);
  $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data1['subjek']);
  $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data1['pesan']);
  $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data1['status_bim']);
  
  // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
  $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
  
  $excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
  
  $no++; // Tambah 1 setiap kali looping
  $numrow++; // Tambah 1 setiap kali looping
}

// Set width kolom
$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
$excel->getActiveSheet()->getColumnDimension('B')->setWidth(25); // Set width kolom B
$excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
$excel->getActiveSheet()->getColumnDimension('D')->setWidth(25); // Set width kolom D
$excel->getActiveSheet()->getColumnDimension('E')->setWidth(15); // Set width kolom E

// Set orientasi kertas jadi LANDSCAPE
$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);

// Set judul file excel nya
$excel->getActiveSheet(0)->setTitle("KartubimPKL");
$excel->setActiveSheetIndex(0);

// Proses file excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="kartu_bim.xlsx"'); // Set nama file excel nya
header('Cache-Control: max-age=0');


$write = PHPExcel_IOFactory::createWriter($excel,'Excel2007');
$write->save('php://output');
?>