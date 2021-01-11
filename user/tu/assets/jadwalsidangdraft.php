<?php
// Load file koneksi.php
include "../../../koneksi.php";

// Load plugin PHPExcel nya
require_once '../../../plugins/PHPExcel/PHPExcel.php';

// Panggil class PHPExcel nya
$excel = new PHPExcel();

// Settingan awal file excel
$excel->getProperties()->setCreator('Admin')
             ->setLastModifiedBy('Admin')
             ->setTitle("Jadwal Sidang Draft")
             ->setSubject("SidangDraft")
             ->setDescription("Jadwal Sidang Draft")
             ->setKeywords("Sidang Draft");

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

$excel->setActiveSheetIndex(0)->setCellValue('A1', "JADWAL PESERTA SIDANG DRAFT"); // Set kolom A1 dengan tulisan "DATA SISWA"
$excel->getActiveSheet()->mergeCells('A1:I1'); // Set Merge Cell pada kolom A1 sampai F1
$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

$excel->setActiveSheetIndex(0)->setCellValue('A2', "PRODI TEKNIK INFORMATIKA"); // Set kolom A2 dengan tulisan "DATA SISWA"
$excel->getActiveSheet()->mergeCells('A2:I2'); // Set Merge Cell pada kolom A2 sampai F1
$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A2
$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(15); // Set font size 15 untuk kolom A2
$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A2

// Buat header tabel nya pada baris ke 3
$excel->setActiveSheetIndex(0)->setCellValue('A4', "NO"); // Set kolom A4 dengan tulisan "NO"
$excel->setActiveSheetIndex(0)->setCellValue('B4', "TANGGAL"); // Set kolom B4 dengan tulisan "NIS"
$excel->setActiveSheetIndex(0)->setCellValue('C4', "WAKTU"); // Set kolom C4 dengan tulisan "NAMA"
$excel->setActiveSheetIndex(0)->setCellValue('D4', "RUANG"); // Set kolom D4 dengan tulisan "JENIS KELAMIN"
$excel->setActiveSheetIndex(0)->setCellValue('E4', "NIM"); // Set kolom E4 dengan tulisan "TELEPON"
$excel->setActiveSheetIndex(0)->setCellValue('F4', "NAMA"); // Set kolom F4 dengan tulisan "ALAMAT"
$excel->setActiveSheetIndex(0)->setCellValue('G4', "JUDUL LAPORAN"); // Set kolom F4 dengan tulisan "ALAMAT"
$excel->setActiveSheetIndex(0)->setCellValue('H4', "PEMBIMBING 1"); // Set kolom F4 dengan tulisan "ALAMAT"
$excel->setActiveSheetIndex(0)->setCellValue('I4', "PEMBIMBING 2"); // Set kolom F4 dengan tulisan "ALAMAT"
$excel->setActiveSheetIndex(0)->setCellValue('J4', "PENGUJI 1"); // Set kolom F4 dengan tulisan "ALAMAT"
$excel->setActiveSheetIndex(0)->setCellValue('K4', "PENGUJI 2");

// Apply style header yang telah kita buat tadi ke masing-masing kolom header
$excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('I4')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('J4')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('K4')->applyFromArray($style_col);

// Set height baris ke 1, 2 dan 3
$excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
$excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
$excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

// Buat query untuk menampilkan semua data siswa
$sql = mysqli_query($conn, 
                        "SELECT DISTINCT mhs.nama, mhs.nim,
                        j.judul,
                        ds.status_sidang AS status,
                        ds.tgl_sidang AS tgl,
                        ds.waktu_sidang AS waktu,
                        ds.ruang_sidang AS ruang, ds.id_sidang,
                        -- PEMBIMBING 1
                        (SELECT d3.nama_dosen FROM dosen d3 INNER JOIN skripsi_dosbing sd
                        ON d3.nidn=sd.nidn WHERE sd.id_skripsi=s.id_skripsi
                        AND status_dosbing='Pembimbing 1' AND sd.status='Aktif' LIMIT 0,1) AS pembimbing1,
                        -- PEMBIMBING 2
                        (SELECT d4.nama_dosen FROM dosen d4 INNER JOIN skripsi_dosbing sd
                        ON d4.nidn=sd.nidn WHERE sd.id_skripsi=s.id_skripsi
                        AND status_dosbing='Pembimbing 2' AND sd.status='Aktif' LIMIT 0,1) AS pembimbing2,
                        -- ambil data penguji1
                        (SELECT d1.nama_dosen FROM dosen d1 INNER JOIN draft_penguji dp
                        ON d1.nidn=dp.penguji 
                        WHERE dp.id_sidang=ds.id_sidang AND status_penguji='Penguji 1'
                        AND dp.status='Aktif' LIMIT 0,1) AS penguji1, 
                        -- ambil data penguji2
                        (SELECT d2.nama_dosen FROM dosen d2 INNER JOIN draft_penguji dp
                        ON d2.nidn=dp.penguji 
                        WHERE dp.id_sidang=ds.id_sidang AND status_penguji='Penguji 2'
                        AND dp.status='Aktif' LIMIT 0,1) as penguji2
                        FROM draft_sidang ds 
                        LEFT JOIN skripsi s
                        ON ds.id_skripsi=s.id_skripsi
                        LEFT JOIN proposal p
                        ON s.id_proposal=p.id_proposal
                        LEFT JOIN judul j
                        ON p.id_judul=j.id_judul
                        LEFT JOIN mahasiswa mhs
                        ON j.nim=mhs.nim
                        LEFT JOIN draft_penguji dp
                        ON ds.id_sidang=dp.id_sidang
                        WHERE ds.tgl_sidang IS NOT NULL AND ds.status_sidang IS NULL")
                        or die (mysqli_erorr($conn));

$no = 1; // Untuk penomoran tabel, di awal set dengan 1
$numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 4
while($data = mysqli_fetch_array($sql)){ // Ambil semua data dari hasil eksekusi $sql
  $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
  $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['tgl']);
  $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data['waktu']);
  $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data['ruang']);
  $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data['nim']);
  $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data['nama']);
  $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data['judul']);
  $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data['pembimbing1']);
  $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $data['pembimbing2']);
  $excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $data['penguji1']);
  $excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $data['penguji2']);
  
  // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
  $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
  
  $excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
  
  $no++; // Tambah 1 setiap kali looping
  $numrow++; // Tambah 1 setiap kali looping
}

// Set width kolom
$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
$excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
$excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
$excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
$excel->getActiveSheet()->getColumnDimension('E')->setWidth(15); // Set width kolom E
$excel->getActiveSheet()->getColumnDimension('F')->setWidth(30); // Set width kolom F
$excel->getActiveSheet()->getColumnDimension('G')->setWidth(30); // Set width kolom F
$excel->getActiveSheet()->getColumnDimension('H')->setWidth(30); // Set width kolom F
$excel->getActiveSheet()->getColumnDimension('I')->setWidth(30); // Set width kolom F
$excel->getActiveSheet()->getColumnDimension('J')->setWidth(30); // Set width kolom F
$excel->getActiveSheet()->getColumnDimension('K')->setWidth(30); // Set width kolom F


// Set orientasi kertas jadi LANDSCAPE
$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

// Set judul file excel nya
$excel->getActiveSheet(0)->setTitle("JadwalSidang");
$excel->setActiveSheetIndex(0);

// Proses file excel
ob_end_clean();
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="jadwal-sidang-draft.xlsx"'); // Set nama file excel nya
header('Cache-Control: max-age=0');

$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
$write->save('php://output');
ob_end_clean();
?>