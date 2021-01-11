-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Jan 2021 pada 08.27
-- Versi server: 10.3.16-MariaDB
-- Versi PHP: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sim_ps_new`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `dosen`
--

CREATE TABLE `dosen` (
  `nidn` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nama_dosen` varchar(100) NOT NULL,
  `foto_dosen` varchar(256) NOT NULL DEFAULT 'profil.png',
  `jabatan` varchar(20) DEFAULT NULL,
  `tipe_akun` enum('Kaprodi','PenasihatAkademik','Dosen') NOT NULL,
  `status` enum('Aktif','Tidak Aktif') NOT NULL DEFAULT 'Tidak Aktif'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `dosen`
--

INSERT INTO `dosen` (`nidn`, `nama`, `password`, `nama_dosen`, `foto_dosen`, `jabatan`, `tipe_akun`, `status`) VALUES
('0017057402', 'Supriyono,M.Cs', 'MTIzMzQz', 'Supriyono,M.Cs', 'profil.png', 'Lekor', 'Dosen', 'Aktif'),
('0402057307', 'Freddy Wicaksono, M.Kom', 'MDQwMjA1NzMwNw==', 'Freddy Wicaksono, M.Kom', 'profil.png', 'Asisten Ahli', 'Dosen', 'Aktif'),
('0403079201', 'Lia Farhatuaini,M.Cs', 'MDQwMzA3OTIwMQ==', 'Lia Farhatuaini,M.Cs', 'profil.png', NULL, 'Dosen', 'Aktif'),
('0405108905', 'Sokid', 'MDQwNTEwODkwNQ==', 'Sokid', 'profil.png', NULL, 'Dosen', 'Aktif'),
('0406067407', 'Maksudi,M.T', 'MDQwNjA2NzQwNw==', 'Maksudi,M.T', 'profil.png', 'Asisten Ahli', 'PenasihatAkademik', 'Aktif'),
('0407039501', 'Vega Purwayoga,S.Kom,M.Kom', 'MDQwNzAzOTUwMQ==', 'Vega Purwayoga,S.Kom,M.Kom', 'profil.png', NULL, 'Dosen', 'Aktif'),
('0408118304', 'Harry Gunawan,M.Kom', 'MDQwODExODMwNA==', 'Harry Gunawan,M.Kom', 'profil.png', 'Asisten Ahli', 'Dosen', 'Aktif'),
('0409046101', 'Suhana Minah Jaya, M.T', 'MDQwOTA0NjEwMQ==', 'Suhana Minah Jaya, M.T', 'profil.png', 'Lektor', 'Dosen', 'Aktif'),
('0412068907', 'MUHAMAD IMAM', 'MDQxMjA2ODkwNw==', 'MUHAMAD IMAM', 'profil.png', NULL, 'Dosen', 'Aktif'),
('0413118803', 'PAHLA WIDHIANI', 'MDQxMzExODgwMw==', 'PAHLA WIDHIANI', 'profil.png', NULL, 'Dosen', 'Aktif'),
('0416018007', 'LUKMAN NURHAKIM', 'MDQxNjAxODAwNw==', 'LUKMAN NURHAKIM', 'profil.png', NULL, 'Dosen', 'Aktif'),
('0416086408', 'Agust Isa Martinus, M.T', 'MDQxNjA4NjQwOA==', 'Agust Isa Martinus, M.T', 'profil.png', 'Asisten Ahli', 'PenasihatAkademik', 'Aktif'),
('0421117105', 'Dian Novianti, M.Kom', 'MDQyMTExNzEwNQ==', 'Dian Novianti, M.Kom', 'profil.png', 'Lektor', 'Kaprodi', 'Aktif'),
('0424038902', 'DENI', 'MDQyNDAzODkwMg==', 'DENI', 'profil.png', NULL, 'Dosen', 'Aktif'),
('0425036001', 'ISKANDAR', 'MDQyNTAzNjAwMQ==', 'ISKANDAR', 'profil.png', 'Lektor', 'Dosen', 'Aktif'),
('0428117601', 'Dr. Wahyu Triono, M.MPd', 'MDQyODExNzYwMQ==', 'Dr. Wahyu Triono, M.MPd', 'profil.png', 'Lekor', 'Dosen', 'Aktif'),
('9904005002', 'ARIEF RAHMAN', 'OTkwNDAwNTAwMg==', 'ARIEF RAHMAN', 'profil.png', NULL, 'Dosen', 'Aktif'),
('9904006197', 'HANDI EKO PRASETYO', 'OTkwNDAwNjE5Nw==', 'HANDI EKO PRASETYO', 'profil.png', NULL, 'Dosen', 'Aktif');

--
-- Trigger `dosen`
--
DELIMITER $$
CREATE TRIGGER `delete_dosen` AFTER DELETE ON `dosen` FOR EACH ROW BEGIN
  INSERT INTO dosen_log
  (action,u_create,
   nidn,nama_dosen,password,nama,foto_dosen,jabatan,tipe_akun)
   VALUES
   (@action2, @user ,old.nidn, old.nama_dosen, old.password, old.nama, 		 	old.foto_dosen,old.jabatan, old.tipe_akun);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_dosen` AFTER INSERT ON `dosen` FOR EACH ROW BEGIN
  INSERT INTO dosen_log
  (action,u_create,
   nidn,nama_dosen,password,nama,foto_dosen,jabatan,tipe_akun)
   VALUES
   (@action1, @user ,new.nidn, new.nama_dosen, new.password, new.nama, 		 	new.foto_dosen,new.jabatan, new.tipe_akun);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_dosen` AFTER UPDATE ON `dosen` FOR EACH ROW BEGIN
  INSERT INTO dosen_log
  (action,u_create,
   nidn,nama_dosen,password,nama,foto_dosen,jabatan,tipe_akun,status)
   VALUES
   (@action, @user ,old.nidn, old.nama_dosen, old.password, old.nama, 		 	old.foto_dosen,old.jabatan, old.tipe_akun, old.status);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `dosen_log`
--

CREATE TABLE `dosen_log` (
  `id_row` int(11) NOT NULL,
  `action` varchar(50) DEFAULT NULL,
  `u_create` varchar(50) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `nidn` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nama_dosen` varchar(100) NOT NULL,
  `foto_dosen` varchar(256) NOT NULL,
  `jabatan` varchar(20) DEFAULT NULL,
  `tipe_akun` enum('Kaprodi','PenasihatAkademik','Dosen') NOT NULL,
  `status` enum('Aktif','Tidak Aktif') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `dosen_wali`
--

CREATE TABLE `dosen_wali` (
  `id_dosenwali` varchar(5) NOT NULL,
  `nidn` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `dosen_wali`
--

INSERT INTO `dosen_wali` (`id_dosenwali`, `nidn`) VALUES
('0', '0421117105'),
('1', '0409046101'),
('2', '0408118304'),
('3', '0428117601'),
('4', '0402057307'),
('5', '0403079201'),
('6', '0406067407'),
('7', '0017057402'),
('8', '0407039501'),
('9', '0416086408');

--
-- Trigger `dosen_wali`
--
DELIMITER $$
CREATE TRIGGER `delete_dw` BEFORE DELETE ON `dosen_wali` FOR EACH ROW BEGIN
  INSERT INTO dosen_wali_log
  (action,u_create,
   id_dosenwali,nidn)
   VALUES
   (@action, @user ,old.id_dosenwali, old.nidn);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_dw` AFTER UPDATE ON `dosen_wali` FOR EACH ROW BEGIN
  INSERT INTO dosen_wali_log
  (action,u_create,
   id_dosenwali,nidn)
   VALUES
   (@action, @user ,old.id_dosenwali, old.nidn);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `dosen_wali_log`
--

CREATE TABLE `dosen_wali_log` (
  `id_row` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `u_create` varchar(50) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_dosenwali` varchar(5) NOT NULL,
  `nidn` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `draft_nilai`
--

CREATE TABLE `draft_nilai` (
  `id_nilai` int(11) NOT NULL,
  `id_sidang` int(11) NOT NULL,
  `dos1_pen` float DEFAULT NULL,
  `dos1_peng` float DEFAULT NULL,
  `dos1_sis` float DEFAULT NULL,
  `dos1_ap` float DEFAULT NULL,
  `dos2_pen` float DEFAULT NULL,
  `dos2_peng` float DEFAULT NULL,
  `dos2_sis` float DEFAULT NULL,
  `dos2_ap` float DEFAULT NULL,
  `peng1_pen` float DEFAULT NULL,
  `peng1_peng` float DEFAULT NULL,
  `peng1_sis` float DEFAULT NULL,
  `peng1_ap` float DEFAULT NULL,
  `peng2_pen` float DEFAULT NULL,
  `peng2_peng` float DEFAULT NULL,
  `peng2_sis` float DEFAULT NULL,
  `peng2_ap` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `draft_nilai`
--

INSERT INTO `draft_nilai` (`id_nilai`, `id_sidang`, `dos1_pen`, `dos1_peng`, `dos1_sis`, `dos1_ap`, `dos2_pen`, `dos2_peng`, `dos2_sis`, `dos2_ap`, `peng1_pen`, `peng1_peng`, `peng1_sis`, `peng1_ap`, `peng2_pen`, `peng2_peng`, `peng2_sis`, `peng2_ap`) VALUES
(1, 1, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80);

--
-- Trigger `draft_nilai`
--
DELIMITER $$
CREATE TRIGGER `delete_dn` AFTER DELETE ON `draft_nilai` FOR EACH ROW BEGIN
  INSERT INTO `draft_nilai_log` (action, u_create,`id_nilai`, `id_sidang`, `dos1_pen`, `dos1_peng`, `dos1_sis`, `dos1_ap`, `dos2_pen`, `dos2_peng`, `dos2_sis`, `dos2_ap`, `peng1_pen`, `peng1_peng`, `peng1_sis`, `peng1_ap`, `peng2_pen`, `peng2_peng`, `peng2_sis`, `peng2_ap`) VALUES
(@action2, @user,old.id_nilai, old.id_sidang, old.dos1_pen, old.dos1_peng, old.dos1_sis, old.dos1_ap, old.dos2_pen, old.dos2_peng, old.dos2_sis, old.dos2_ap, old.peng1_pen, old.peng1_peng, old.peng1_sis, old.peng1_ap, old.peng2_pen, old.peng2_pen, old.peng2_sis, old.peng2_ap);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_dn` AFTER INSERT ON `draft_nilai` FOR EACH ROW BEGIN
 INSERT INTO draft_nilai_log (action, u_create,id_nilai, id_sidang, dos1_pen, dos1_peng, dos1_sis, dos1_ap, dos2_pen, dos2_peng, dos2_sis, dos2_ap, peng1_pen, peng1_peng, peng1_sis, peng1_ap, peng2_pen, peng2_peng, peng2_sis, peng2_ap) VALUES
(@action1, @user,new.id_nilai, new.id_sidang, new.dos1_pen, new.dos1_peng, new.dos1_sis, new.dos1_ap, new.dos2_pen, new.dos2_peng, new.dos2_sis, new.dos2_ap, new.peng1_pen, new.peng1_peng, new.peng1_sis, new.peng1_ap, new.peng2_pen, new.peng2_pen, new.peng2_sis, new.peng2_ap);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_dn` AFTER UPDATE ON `draft_nilai` FOR EACH ROW BEGIN
  INSERT INTO `draft_nilai_log` (action, u_create,`id_nilai`, `id_sidang`, `dos1_pen`, `dos1_peng`, `dos1_sis`, `dos1_ap`, `dos2_pen`, `dos2_peng`, `dos2_sis`, `dos2_ap`, `peng1_pen`, `peng1_peng`, `peng1_sis`, `peng1_ap`, `peng2_pen`, `peng2_peng`, `peng2_sis`, `peng2_ap`) VALUES
(@action, @user,old.id_nilai, old.id_sidang, old.dos1_pen, old.dos1_peng, old.dos1_sis, old.dos1_ap, old.dos2_pen, old.dos2_peng, old.dos2_sis, old.dos2_ap, old.peng1_pen, old.peng1_peng, old.peng1_sis, old.peng1_ap, old.peng2_pen, old.peng2_pen, old.peng2_sis, old.peng2_ap);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `draft_nilai_log`
--

CREATE TABLE `draft_nilai_log` (
  `id_row` int(11) NOT NULL,
  `action` int(50) NOT NULL,
  `u_create` varchar(50) NOT NULL,
  `time` timestamp NULL DEFAULT current_timestamp(),
  `id_nilai` int(11) NOT NULL,
  `id_sidang` int(11) NOT NULL,
  `dos1_pen` float DEFAULT NULL,
  `dos1_peng` float DEFAULT NULL,
  `dos1_sis` float DEFAULT NULL,
  `dos1_ap` float DEFAULT NULL,
  `dos2_pen` float DEFAULT NULL,
  `dos2_peng` float DEFAULT NULL,
  `dos2_sis` float DEFAULT NULL,
  `dos2_ap` float DEFAULT NULL,
  `peng1_pen` float DEFAULT NULL,
  `peng1_peng` float DEFAULT NULL,
  `peng1_sis` float DEFAULT NULL,
  `peng1_ap` float DEFAULT NULL,
  `peng2_pen` float DEFAULT NULL,
  `peng2_peng` float DEFAULT NULL,
  `peng2_sis` float DEFAULT NULL,
  `peng2_ap` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `draft_nilai_log`
--

INSERT INTO `draft_nilai_log` (`id_row`, `action`, `u_create`, `time`, `id_nilai`, `id_sidang`, `dos1_pen`, `dos1_peng`, `dos1_sis`, `dos1_ap`, `dos2_pen`, `dos2_peng`, `dos2_sis`, `dos2_ap`, `peng1_pen`, `peng1_peng`, `peng1_sis`, `peng1_ap`, `peng2_pen`, `peng2_peng`, `peng2_sis`, `peng2_ap`) VALUES
(1, 0, 'Dian Novianti, M.Kom', '2021-01-10 07:19:15', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 0, 'Tatang', '2021-01-10 07:19:35', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `draft_penguji`
--

CREATE TABLE `draft_penguji` (
  `id_penguji` int(11) NOT NULL,
  `id_sidang` int(11) NOT NULL,
  `penguji` varchar(20) NOT NULL,
  `status_penguji` enum('Penguji 1','Penguji 2') NOT NULL,
  `status` enum('Aktif','Tidak Aktif') NOT NULL DEFAULT 'Aktif',
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `draft_penguji`
--

INSERT INTO `draft_penguji` (`id_penguji`, `id_sidang`, `penguji`, `status_penguji`, `status`, `time`) VALUES
(1, 1, '0421117105', 'Penguji 1', 'Aktif', '2021-01-10 07:19:15'),
(2, 1, '0408118304', 'Penguji 2', 'Aktif', '2021-01-10 07:19:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `draft_sidang`
--

CREATE TABLE `draft_sidang` (
  `id_sidang` int(11) NOT NULL,
  `id_skripsi` int(11) NOT NULL,
  `val_dosbing1` tinyint(1) NOT NULL,
  `pesan1` varchar(100) DEFAULT NULL,
  `val_dosbing2` tinyint(1) NOT NULL,
  `pesan2` varchar(100) DEFAULT NULL,
  `tgl_sidang` date DEFAULT NULL,
  `waktu_sidang` varchar(10) DEFAULT NULL,
  `ruang_sidang` varchar(50) DEFAULT NULL,
  `status_sidang` enum('Lulus','Tidak Lulus') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `draft_sidang`
--

INSERT INTO `draft_sidang` (`id_sidang`, `id_skripsi`, `val_dosbing1`, `pesan1`, `val_dosbing2`, `pesan2`, `tgl_sidang`, `waktu_sidang`, `ruang_sidang`, `status_sidang`) VALUES
(1, 1, 2, 'ok', 2, 'ok', '2021-01-10', '08:00', 'Lab Informatika', 'Lulus');

--
-- Trigger `draft_sidang`
--
DELIMITER $$
CREATE TRIGGER `delete_ds` AFTER DELETE ON `draft_sidang` FOR EACH ROW BEGIN

INSERT INTO draft_sidang_log (action,u_create,id_sidang, id_skripsi, val_dosbing1, pesan1, val_dosbing2, pesan2, tgl_sidang, waktu_sidang, ruang_sidang, status_sidang) VALUES
(@action2, @user, old.id_sidang, old.id_skripsi, old.val_dosbing1, old.pesan1, old.val_dosbing2, old.pesan2, old.tgl_sidang, old.waktu_sidang, old.ruang_sidang, old.status_sidang);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_ds` AFTER INSERT ON `draft_sidang` FOR EACH ROW BEGIN

INSERT INTO draft_sidang_log (action,u_create,id_sidang, id_skripsi, val_dosbing1, pesan1, val_dosbing2, pesan2, tgl_sidang, waktu_sidang, ruang_sidang, status_sidang) VALUES
(@action1, @user, new.id_sidang, new.id_skripsi, new.val_dosbing1, new.pesan1, new.val_dosbing2, new.pesan2, new.tgl_sidang, new.waktu_sidang, new.ruang_sidang, new.status_sidang);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_ds` AFTER UPDATE ON `draft_sidang` FOR EACH ROW BEGIN

INSERT INTO draft_sidang_log (action,u_create,id_sidang, id_skripsi, val_dosbing1, pesan1, val_dosbing2, pesan2, tgl_sidang, waktu_sidang, ruang_sidang, status_sidang) VALUES
(@action, @user, old.id_sidang, old.id_skripsi, old.val_dosbing1, old.pesan1, old.val_dosbing2, old.pesan2, old.tgl_sidang, old.waktu_sidang, old.ruang_sidang, old.status_sidang);

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `draft_sidang_log`
--

CREATE TABLE `draft_sidang_log` (
  `id_row` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `u_create` varchar(50) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_sidang` int(11) NOT NULL,
  `id_skripsi` int(11) NOT NULL,
  `val_dosbing1` tinyint(1) NOT NULL,
  `pesan1` varchar(100) DEFAULT NULL,
  `val_dosbing2` tinyint(1) NOT NULL,
  `pesan2` varchar(100) DEFAULT NULL,
  `tgl_sidang` date DEFAULT NULL,
  `waktu_sidang` varchar(10) DEFAULT NULL,
  `ruang_sidang` varchar(50) DEFAULT NULL,
  `status_sidang` enum('Lulus','Tidak Lulus') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `draft_sidang_log`
--

INSERT INTO `draft_sidang_log` (`id_row`, `action`, `u_create`, `time`, `id_sidang`, `id_skripsi`, `val_dosbing1`, `pesan1`, `val_dosbing2`, `pesan2`, `tgl_sidang`, `waktu_sidang`, `ruang_sidang`, `status_sidang`) VALUES
(1, 'insert', 'Mohamad Irfan Manaf', '2021-01-10 07:15:01', 1, 1, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(2, 'update', 'Agust Isa Martinus, M.T', '2021-01-10 07:18:02', 1, 1, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(3, 'update', 'Dr. Wahyu Triono, M.MPd', '2021-01-10 07:18:29', 1, 1, 2, 'ok', 0, NULL, NULL, NULL, NULL, NULL),
(4, 'update', 'Dian Novianti, M.Kom', '2021-01-10 07:19:15', 1, 1, 2, 'ok', 2, 'ok', NULL, NULL, NULL, NULL),
(5, 'update', 'Tatang', '2021-01-10 07:19:35', 1, 1, 2, 'ok', 2, 'ok', '2021-01-10', '08:00', 'Lab Informatika', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `draft_sidang_syarat`
--

CREATE TABLE `draft_sidang_syarat` (
  `id_syarat` int(11) NOT NULL,
  `file` varchar(256) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `id_sidang` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `draft_sidang_syarat`
--

INSERT INTO `draft_sidang_syarat` (`id_syarat`, `file`, `status`, `id_sidang`) VALUES
(1, '160511030-10-Jan-2021-02-15-01-c7f8b5ca27404a7094dd253e746ffccd.pdf', 2, '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `judul`
--

CREATE TABLE `judul` (
  `id_judul` int(11) NOT NULL,
  `judul` varchar(256) NOT NULL,
  `studi_kasus` varchar(100) DEFAULT NULL,
  `tanggal_pengajuan` date NOT NULL DEFAULT current_timestamp(),
  `status_judul` enum('Disetujui','Ditolak','Menunggu') DEFAULT 'Menunggu',
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `tujuan` varchar(20) NOT NULL,
  `deskripsi_judul` varchar(500) NOT NULL,
  `saran_judul` varchar(500) DEFAULT NULL,
  `nim` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `judul`
--

INSERT INTO `judul` (`id_judul`, `judul`, `studi_kasus`, `tanggal_pengajuan`, `status_judul`, `status`, `tujuan`, `deskripsi_judul`, `saran_judul`, `nim`) VALUES
(1, 'Sistem Informasi Manajemen Praktik Kerja Lapangan dan Skripsi', 'Teknik Informatika Universitas Muhammadiyah Cirebon', '2021-01-10', 'Disetujui', '0', '0416086408', 'Sistem Informasi Manajemen Praktik Kerja Lapangan dan Skripsi', 'ok', '160511030');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nim` varchar(11) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `foto` varchar(256) NOT NULL DEFAULT 'profil.png',
  `alamat_rumah` varchar(256) DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `prodi` varchar(25) NOT NULL,
  `angkatan` varchar(5) NOT NULL,
  `ttl` varchar(50) DEFAULT NULL,
  `status_mhs` varchar(15) NOT NULL DEFAULT 'Tidak Aktif',
  `status_pkl` varchar(20) NOT NULL DEFAULT '-',
  `status_proposal` varchar(20) NOT NULL DEFAULT '-',
  `status_skripsi` varchar(20) NOT NULL DEFAULT '-',
  `time_create` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `mahasiswa`
--

INSERT INTO `mahasiswa` (`nim`, `password`, `nama`, `foto`, `alamat_rumah`, `no_hp`, `prodi`, `angkatan`, `ttl`, `status_mhs`, `status_pkl`, `status_proposal`, `status_skripsi`, `time_create`) VALUES
('160511001', 'MTYwNTExMDAx', 'Andhika Budi Prasetya', 'profil.png', 'Brebes', '08815223912', 'Teknik Informatika', '2016', 'Brebes, 12 Juni 1995', 'Aktif', 'Lulus', 'Lulus', '-', '2020-09-24 08:15:31'),
('160511006', 'MTYwNTExMDA2', 'Tiefani Permata Sari', 'profil.png', 'Perumahan griya jadimulya blok A2 no5', '089512275398', 'Teknik Informatika', '2016', 'Cirebon,06-12-98', 'Aktif', 'Lulus', 'Lulus', '-', '2020-09-24 08:15:31'),
('160511009', '160577+9XTQ=', 'Anita Widiyanthi', 'profil.png', 'Dusun karanganyar rt/rw 008/003 desa ciwiru kecamatan pasawahan kabupaten kuningan', '082121002682', 'Teknik Informatika', '2016', 'Kuningan, 18 juli 1998', 'Aktif', 'Lulus', '-', '-', '2020-09-24 08:15:31'),
('160511013', 'MTYwNTExMDEz', 'Muhammad Irwan', 'profil.png', 'Gembongan mekar kec. Babakan cirebon', '083823334277', 'Teknik Informatika', '2016', 'Cirebon 1 april 1996', 'Aktif', 'Lulus', 'Lulus', '-', '2020-09-24 08:15:31'),
('160511026', 'MTYwNTExMDI2', 'Vatmawati', 'profil.png', 'Desa megu cilik, blok pengadangan rt/rw 02/02 kec. Weru kab. Cirebon', '083120141302', 'Teknik Informatika', '2016', 'Cirebon 04 oktober 1996', 'Aktif', 'Lulus', 'Lulus', '-', '2020-10-14 16:10:54'),
('160511030', 'YXBlbmc=', 'Mohamad Irfan Manaf', '13102020225826-profil.png', 'Jl Pinus V No 202 BAS', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', 'Lulus', 'Lulus', 'Lulus', '2020-09-24 08:15:31'),
('160511031', 'MTYwNTExMDMx', 'Reza Rizky Fahlevi', 'profil.png', 'Bumi Kalijaga Permai Timur Jalan Durian no. 11 BKPT', '081286460824', 'Teknik Informatika', '2016', 'Cirebon, 14 Oktober 1997', 'Aktif', 'Lulus', 'Lulus', '-', '2020-09-24 08:15:31'),
('160511039', '160577+9XTc=', 'Rizky anwar sudiyono', 'profil.png', 'Gg 4 selatan karangampel kidul indramayu', '089611623879', 'Teknik Informatika', '2016', 'Indramayu 18 november 1997', 'Aktif', 'Lulus', 'Lulus', '-', '2020-09-24 08:15:31'),
('160511040', 'MTYwNTExMDQw', 'Lili Rahayu', 'profil.png', 'Jalan BAP 1 Desa Pamijahan, Plumbon, Cirebon', '089613112073', 'Teknik Informatika', '2016', 'Cirebon, 6 April 1997\r\n', 'Aktif', 'Lulus', 'Lulus', '-', '2020-09-24 08:15:31'),
('160511051', 'MTYwNTExMDUx', 'Wawan Hendrawan', 'profil.png', 'jl. pangeran kejaksan gg. sadewa no.11 kel. babakan kec. sumber kab. cirebon', '083877323158\r\n', 'Teknik Informatika', '2016', 'Cirebon, 09 Februari 1997', 'Aktif', 'Lulus', '-', '-', '2020-09-24 08:15:31'),
('160511052', 'MTYwNTExMDUy', 'Muhamad Luffi Dwi Daliana', 'profil.png', 'Jl. Janur Dusun 01 Rto2/Rw03 Desa Karangasem Kec.Karangwareng Kab. Cirebon', '082117938068', 'Teknik Informatika', '2016', 'Cirebon, 21 Agustus 1998', 'Aktif', 'Lulus', 'Lulus', '-', '2020-09-24 08:15:31'),
('160511053', '160577+9XTk=', 'Dede muchidin', 'profil.png', 'Dusun 01 rt 02 rw 01 ds gebang kec gebang', '089665830991', 'Teknik Informatika', '2016', 'Cirebon,12 juni 1997', 'Aktif', 'Lulus', '-', '-', '2020-09-24 08:15:31'),
('160511054', 'MTYwNTExMDU0', 'Budi Setiawan', 'profil.png', 'Desa Gebang Kec. Gebang Kab. Cirebon', '087829890388', 'Teknik Informatika', '2016', 'Cirebon, 20 November 1997', 'Aktif', 'Lulus', 'Lulus', '-', '2020-09-24 08:15:31'),
('160511055', 'MTYwNTExMDU1', 'Hayya Athiyah', 'profil.png', 'bekasi\r\n', '087808094792', 'Teknik Informatika', '2016', 'bekasi, 26-08-1997', 'Aktif', 'Lulus', 'Lulus', '-', '2020-09-24 08:15:31'),
('160511060', 'MTYwNTExMDYw', 'Nikmayanti', 'profil.png', 'Ds.Panguragan Wetan', '089506173030\r\n', 'Teknik Informatika', '2016', 'Cirebon, 31 12 1996', 'Aktif', 'Lulus', '-', '-', '2020-09-24 08:15:31'),
('160511063', 'MTYwNTExMDYz', 'Arif Wahfiudin', 'profil.png', 'Blok prapatan, desa getasan, kec. Depok, kab. Cirebon', '083824810184', 'Teknik Informatika', '2016', 'Cirebon, 15 april 1997', 'Aktif', 'Lulus', 'Lulus', '-', '2020-09-24 08:15:31'),
('160511064', 'MTYwNTExMDY0', 'Hilda Azzahra Erlindita', 'profil.png', 'Jl. Karangsarimulya No.74, RT 03/ RW 08, Kp. Margasari, Kel. Sunyaragi, Kec. Kesambi, Kota Cirebon', '085324402004\r\n', 'Teknik Informatika', '2016', 'Kuningan, 09 Mei 1998', 'Aktif', 'Lulus', '-', '-', '2020-09-24 08:15:31'),
('160511068', 'MTYwNTExMDY4', 'Aay Humairoh', 'profil.png', 'Babakan cirebon\r\n', '085846740743\r\n', 'Teknik Informatika', '2016', 'Cirebon, 29 maret 1999\r\n', 'Aktif', 'Lulus', 'Lulus', '-', '2020-09-24 08:15:31'),
('170511004', 'MTcwNTExMDA0', 'Ali Latukau', 'profil.png', NULL, NULL, 'Teknik Informatika', '2017', NULL, 'Tidak Aktif', '-', '-', '-', '2020-09-24 08:15:31'),
('170511005', 'MTcwNTExMDA1', 'Dede Armadi', 'profil.png', NULL, NULL, 'Teknik Informatika', '2017', NULL, 'Tidak Aktif', '-', '-', '-', '2020-09-24 08:15:31'),
('170511023', 'MTcwNTExMDIz', 'Syifa Ramadhan', 'profil.png', NULL, NULL, 'Teknik Informatika', '2017', NULL, 'Tidak Aktif', '-', '-', '-', '2020-09-24 08:15:31'),
('170511032', 'MTcwNTExMDMy', 'Nugi Rifkiyanto', 'profil.png', NULL, NULL, 'Teknik Informatika', '2017', NULL, 'Tidak Aktif', '-', '-', '-', '2020-09-24 08:15:31'),
('170511033', 'MTcwNTExMDMz', 'Hafied Hafriandy', 'profil.png', NULL, NULL, 'Teknik Informatika', '2017', NULL, 'Tidak Aktif', '-', '-', '-', '2020-09-24 08:15:31'),
('170511048', 'MTcwNTExMDQ4', 'Mohammad Husni Mubarok', 'profil.png', NULL, NULL, 'Teknik Informatika', '2017', NULL, 'Tidak Aktif', '-', '-', '-', '2020-09-24 08:15:31'),
('170511056', 'MTcwNTExMDU2', 'Halimatus syadiah', 'profil.png', NULL, NULL, 'Teknik Informatika', '2017', NULL, 'Tidak Aktif', '-', '-', '-', '2020-09-24 08:15:31'),
('170511065', 'MTcwNTExMDY1', 'Sekar Dwi Asih', 'profil.png', NULL, NULL, 'Teknik Informatika', '2017', NULL, 'Tidak Aktif', '-', '-', '-', '2020-09-24 08:15:31'),
('180511081', 'MTgwNTExMDgx', 'Windi rizky pratama', 'profil.png', NULL, NULL, 'Teknik Informatika', '2018', NULL, 'Tidak Aktif', '-', '-', '-', '2020-09-24 08:15:31'),
('180511086', 'MTgwNTExMDg2', 'RISMA ISLAMIATI', 'profil.png', NULL, NULL, 'Teknik Informatika', '2018', NULL, 'Tidak Aktif', '-', '-', '-', '2020-09-24 08:15:31'),
('190511059', 'MTkwNTExMDU5', 'Alvin Prayudha', 'profil.png', NULL, NULL, 'Teknik Informatika', '2019', NULL, 'Tidak Aktif', '-', '-', '-', '2020-09-24 08:15:31'),
('190511082', 'MTkwNTExMDgy', 'REFKA ANELKA YOGATAMA', 'profil.png', NULL, NULL, 'Teknik Informatika', '2019', NULL, 'Tidak Aktif', '-', '-', '-', '2020-09-24 08:15:31'),
('190511089', 'MTkwNTExMDg5', 'Sanpria Anugrah', 'profil.png', NULL, NULL, 'Teknik Informatika', '2019', NULL, 'Tidak Aktif', '-', '-', '-', '2020-09-24 08:15:31'),
('190511114', 'MTkwNTExMTE0', 'Muhammad Rifqi Khoiru Kholqillah', 'profil.png', NULL, NULL, 'Teknik Informatika', '2019', NULL, 'Tidak Aktif', '-', '-', '-', '2020-09-24 08:15:31');

--
-- Trigger `mahasiswa`
--
DELIMITER $$
CREATE TRIGGER `delete` AFTER DELETE ON `mahasiswa` FOR EACH ROW BEGIN
  INSERT INTO mahasiswa_log
  (action,u_create,
   nim,password,nama,foto,alamat_rumah,no_hp,prodi,angkatan,ttl,
   status_mhs,status_pkl,status_proposal,status_skripsi)
   VALUES
   (@action2, @user ,old.nim, old.password, old.nama, old.foto, 		old.alamat_rumah, 	 
         old.no_hp,old.prodi, old.angkatan, old.ttl, old.status_mhs,  	
         old.status_pkl, old.status_proposal, old.status_skripsi);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert` AFTER INSERT ON `mahasiswa` FOR EACH ROW BEGIN
  INSERT INTO mahasiswa_log
  (action,u_create,
   nim,password,nama,foto,alamat_rumah,no_hp,prodi,angkatan,ttl,
   status_mhs,status_pkl,status_proposal,status_skripsi)
   VALUES
   (@action1, @user ,new.nim, new.password, new.nama, new.foto, 		new.alamat_rumah, 	 
         new.no_hp,new.prodi, new.angkatan, new.ttl, new.status_mhs,  	
         new.status_pkl, new.status_proposal, new.status_skripsi);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_mahasiswa` AFTER UPDATE ON `mahasiswa` FOR EACH ROW BEGIN
  INSERT INTO mahasiswa_log
  (action,u_create,
   nim,password,nama,foto,alamat_rumah,no_hp,prodi,angkatan,ttl,
   status_mhs,status_pkl,status_proposal,status_skripsi)
   VALUES
   (@action, @user ,old.nim, old.password, old.nama, old.foto, 		old.alamat_rumah, 	 
         old.no_hp,old.prodi, old.angkatan, old.ttl, old.status_mhs,  	
         old.status_pkl, old.status_proposal, old.status_skripsi);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa_log`
--

CREATE TABLE `mahasiswa_log` (
  `id_row` int(11) NOT NULL,
  `action` varchar(15) DEFAULT NULL,
  `u_create` varchar(50) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `nim` varchar(11) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `foto` varchar(256) NOT NULL DEFAULT 'profil.png',
  `alamat_rumah` varchar(256) DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `prodi` varchar(25) NOT NULL,
  `angkatan` varchar(5) NOT NULL,
  `ttl` varchar(50) DEFAULT NULL,
  `status_mhs` varchar(15) NOT NULL DEFAULT 'Tidak Aktif',
  `status_pkl` varchar(20) NOT NULL DEFAULT '-',
  `status_proposal` varchar(20) NOT NULL DEFAULT '-',
  `status_skripsi` varchar(20) NOT NULL DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `mahasiswa_log`
--

INSERT INTO `mahasiswa_log` (`id_row`, `action`, `u_create`, `time`, `nim`, `password`, `nama`, `foto`, `alamat_rumah`, `no_hp`, `prodi`, `angkatan`, `ttl`, `status_mhs`, `status_pkl`, `status_proposal`, `status_skripsi`) VALUES
(1, 'update', 'Tatang', '2021-01-10 07:07:00', '160511030', 'YXBlbmc=', 'Mohamad Irfan Manaf', '13102020225826-profil.png', 'Jl Pinus V No 202 BAS', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', 'Lulus', 'Lulus', '-'),
(2, 'update', 'Tatang', '2021-01-10 07:22:54', '160511030', 'YXBlbmc=', 'Mohamad Irfan Manaf', '13102020225826-profil.png', 'Jl Pinus V No 202 BAS', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', 'Lulus', 'Lulus', '-');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pend_nilai`
--

CREATE TABLE `pend_nilai` (
  `id_nilai` int(11) NOT NULL,
  `id_sidang` int(11) NOT NULL,
  `dos1_pen` float DEFAULT NULL,
  `dos1_peng` float DEFAULT NULL,
  `dos1_sis` float DEFAULT NULL,
  `dos1_ap` float DEFAULT NULL,
  `dos2_pen` float DEFAULT NULL,
  `dos2_peng` float DEFAULT NULL,
  `dos2_sis` float DEFAULT NULL,
  `dos2_ap` float DEFAULT NULL,
  `peng1_pen` float DEFAULT NULL,
  `peng1_peng` float DEFAULT NULL,
  `peng1_sis` float DEFAULT NULL,
  `peng1_ap` float DEFAULT NULL,
  `peng2_pen` float DEFAULT NULL,
  `peng2_peng` float DEFAULT NULL,
  `peng2_sis` float DEFAULT NULL,
  `peng2_ap` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pend_nilai`
--

INSERT INTO `pend_nilai` (`id_nilai`, `id_sidang`, `dos1_pen`, `dos1_peng`, `dos1_sis`, `dos1_ap`, `dos2_pen`, `dos2_peng`, `dos2_sis`, `dos2_ap`, `peng1_pen`, `peng1_peng`, `peng1_sis`, `peng1_ap`, `peng2_pen`, `peng2_peng`, `peng2_sis`, `peng2_ap`) VALUES
(1, 1, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80);

--
-- Trigger `pend_nilai`
--
DELIMITER $$
CREATE TRIGGER `delete_pn` AFTER DELETE ON `pend_nilai` FOR EACH ROW BEGIN
  INSERT INTO `pend_nilai_log` (action, u_create,`id_nilai`, `id_sidang`, `dos1_pen`, `dos1_peng`, `dos1_sis`, `dos1_ap`, `dos2_pen`, `dos2_peng`, `dos2_sis`, `dos2_ap`, `peng1_pen`, `peng1_peng`, `peng1_sis`, `peng1_ap`, `peng2_pen`, `peng2_peng`, `peng2_sis`, `peng2_ap`) VALUES
(@action2, @user,old.id_nilai, old.id_sidang, old.dos1_pen, old.dos1_peng, old.dos1_sis, old.dos1_ap, old.dos2_pen, old.dos2_peng, old.dos2_sis, old.dos2_ap, old.peng1_pen, old.peng1_peng, old.peng1_sis, old.peng1_ap, old.peng2_pen, old.peng2_pen, old.peng2_sis, old.peng2_ap);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_pn` AFTER INSERT ON `pend_nilai` FOR EACH ROW BEGIN
 INSERT INTO pend_nilai_log (action, u_create,id_nilai, id_sidang, dos1_pen, dos1_peng, dos1_sis, dos1_ap, dos2_pen, dos2_peng, dos2_sis, dos2_ap, peng1_pen, peng1_peng, peng1_sis, peng1_ap, peng2_pen, peng2_peng, peng2_sis, peng2_ap) VALUES
(@action1, @user,new.id_nilai, new.id_sidang, new.dos1_pen, new.dos1_peng, new.dos1_sis, new.dos1_ap, new.dos2_pen, new.dos2_peng, new.dos2_sis, new.dos2_ap, new.peng1_pen, new.peng1_peng, new.peng1_sis, new.peng1_ap, new.peng2_pen, new.peng2_pen, new.peng2_sis, new.peng2_ap);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_pn` AFTER UPDATE ON `pend_nilai` FOR EACH ROW BEGIN
  INSERT INTO `pend_nilai_log` (action, u_create,`id_nilai`, `id_sidang`, `dos1_pen`, `dos1_peng`, `dos1_sis`, `dos1_ap`, `dos2_pen`, `dos2_peng`, `dos2_sis`, `dos2_ap`, `peng1_pen`, `peng1_peng`, `peng1_sis`, `peng1_ap`, `peng2_pen`, `peng2_peng`, `peng2_sis`, `peng2_ap`) VALUES
(@action, @user,old.id_nilai, old.id_sidang, old.dos1_pen, old.dos1_peng, old.dos1_sis, old.dos1_ap, old.dos2_pen, old.dos2_peng, old.dos2_sis, old.dos2_ap, old.peng1_pen, old.peng1_peng, old.peng1_sis, old.peng1_ap, old.peng2_pen, old.peng2_pen, old.peng2_sis, old.peng2_ap);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pend_nilai_log`
--

CREATE TABLE `pend_nilai_log` (
  `id_row` int(11) NOT NULL,
  `action` int(50) NOT NULL,
  `u_create` varchar(50) NOT NULL,
  `time` timestamp NULL DEFAULT current_timestamp(),
  `id_nilai` int(11) NOT NULL,
  `id_sidang` int(11) NOT NULL,
  `dos1_pen` float DEFAULT NULL,
  `dos1_peng` float DEFAULT NULL,
  `dos1_sis` float DEFAULT NULL,
  `dos1_ap` float DEFAULT NULL,
  `dos2_pen` float DEFAULT NULL,
  `dos2_peng` float DEFAULT NULL,
  `dos2_sis` float DEFAULT NULL,
  `dos2_ap` float DEFAULT NULL,
  `peng1_pen` float DEFAULT NULL,
  `peng1_peng` float DEFAULT NULL,
  `peng1_sis` float DEFAULT NULL,
  `peng1_ap` float DEFAULT NULL,
  `peng2_pen` float DEFAULT NULL,
  `peng2_peng` float DEFAULT NULL,
  `peng2_sis` float DEFAULT NULL,
  `peng2_ap` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pend_nilai_log`
--

INSERT INTO `pend_nilai_log` (`id_row`, `action`, `u_create`, `time`, `id_nilai`, `id_sidang`, `dos1_pen`, `dos1_peng`, `dos1_sis`, `dos1_ap`, `dos2_pen`, `dos2_peng`, `dos2_sis`, `dos2_ap`, `peng1_pen`, `peng1_peng`, `peng1_sis`, `peng1_ap`, `peng2_pen`, `peng2_peng`, `peng2_sis`, `peng2_ap`) VALUES
(0, 0, 'Dian Novianti, M.Kom', '2021-01-10 07:22:30', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 0, 'Tatang', '2021-01-10 07:22:54', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pend_penguji`
--

CREATE TABLE `pend_penguji` (
  `id_penguji` int(11) NOT NULL,
  `id_sidang` int(11) NOT NULL,
  `penguji` varchar(20) NOT NULL,
  `status_penguji` enum('Penguji 1','Penguji 2') NOT NULL,
  `status` enum('Aktif','Tidak Aktif') NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pend_penguji`
--

INSERT INTO `pend_penguji` (`id_penguji`, `id_sidang`, `penguji`, `status_penguji`, `status`, `time`) VALUES
(1, 1, '0421117105', 'Penguji 1', 'Aktif', '2021-01-10 07:22:30'),
(2, 1, '0408118304', 'Penguji 2', 'Aktif', '2021-01-10 07:22:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pend_sidang`
--

CREATE TABLE `pend_sidang` (
  `id_sidang` int(11) NOT NULL,
  `id_skripsi` int(11) NOT NULL,
  `val_dosbing1` tinyint(1) NOT NULL,
  `pesan1` varchar(100) DEFAULT NULL,
  `val_dosbing2` tinyint(1) NOT NULL,
  `pesan2` varchar(100) DEFAULT NULL,
  `tgl_sidang` date DEFAULT NULL,
  `waktu_sidang` varchar(10) DEFAULT NULL,
  `ruang_sidang` varchar(50) DEFAULT NULL,
  `status_sidang` enum('Lulus','Tidak Lulus') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pend_sidang`
--

INSERT INTO `pend_sidang` (`id_sidang`, `id_skripsi`, `val_dosbing1`, `pesan1`, `val_dosbing2`, `pesan2`, `tgl_sidang`, `waktu_sidang`, `ruang_sidang`, `status_sidang`) VALUES
(1, 1, 2, 'ok', 2, 'ok', '2021-01-10', '10:00', 'Lab Informatika', 'Lulus');

--
-- Trigger `pend_sidang`
--
DELIMITER $$
CREATE TRIGGER `delete_ps` AFTER DELETE ON `pend_sidang` FOR EACH ROW BEGIN

INSERT INTO pend_sidang_log (action,u_create,id_sidang, id_skripsi, val_dosbing1, pesan1, val_dosbing2, pesan2, tgl_sidang, waktu_sidang, ruang_sidang, status_sidang) VALUES
(@action2, @user, old.id_sidang, old.id_skripsi, old.val_dosbing1, old.pesan1, old.val_dosbing2, old.pesan2, old.tgl_sidang, old.waktu_sidang, old.ruang_sidang, old.status_sidang);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_ps` AFTER INSERT ON `pend_sidang` FOR EACH ROW BEGIN

INSERT INTO pend_sidang_log (action,u_create,id_sidang, id_skripsi, val_dosbing1, pesan1, val_dosbing2, pesan2, tgl_sidang, waktu_sidang, ruang_sidang, status_sidang) VALUES
(@action1, @user, new.id_sidang, new.id_skripsi, new.val_dosbing1, new.pesan1, new.val_dosbing2, new.pesan2, new.tgl_sidang, new.waktu_sidang, new.ruang_sidang, new.status_sidang);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_ps` AFTER UPDATE ON `pend_sidang` FOR EACH ROW BEGIN

INSERT INTO pend_sidang_log (action,u_create,id_sidang, id_skripsi, val_dosbing1, pesan1, val_dosbing2, pesan2, tgl_sidang, waktu_sidang, ruang_sidang, status_sidang) VALUES
(@action, @user, old.id_sidang, old.id_skripsi, old.val_dosbing1, old.pesan1, old.val_dosbing2, old.pesan2, old.tgl_sidang, old.waktu_sidang, old.ruang_sidang, old.status_sidang);

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pend_sidang_log`
--

CREATE TABLE `pend_sidang_log` (
  `id_row` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `u_create` varchar(50) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_sidang` int(11) NOT NULL,
  `id_skripsi` int(11) NOT NULL,
  `val_dosbing1` tinyint(1) NOT NULL,
  `pesan1` varchar(100) DEFAULT NULL,
  `val_dosbing2` tinyint(1) NOT NULL,
  `pesan2` varchar(100) DEFAULT NULL,
  `tgl_sidang` date DEFAULT NULL,
  `waktu_sidang` varchar(10) DEFAULT NULL,
  `ruang_sidang` varchar(50) DEFAULT NULL,
  `status_sidang` enum('Lulus','Tidak Lulus') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pend_sidang_log`
--

INSERT INTO `pend_sidang_log` (`id_row`, `action`, `u_create`, `time`, `id_sidang`, `id_skripsi`, `val_dosbing1`, `pesan1`, `val_dosbing2`, `pesan2`, `tgl_sidang`, `waktu_sidang`, `ruang_sidang`, `status_sidang`) VALUES
(1, 'insert', 'Mohamad Irfan Manaf', '2021-01-10 07:20:30', 1, 1, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(2, 'update', 'Agust Isa Martinus, M.T', '2021-01-10 07:21:13', 1, 1, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(3, 'update', 'Dr. Wahyu Triono, M.MPd', '2021-01-10 07:21:30', 1, 1, 2, 'ok', 0, NULL, NULL, NULL, NULL, NULL),
(4, 'update', 'Dian Novianti, M.Kom', '2021-01-10 07:22:30', 1, 1, 2, 'ok', 2, 'ok', NULL, NULL, NULL, NULL),
(5, 'update', 'Tatang', '2021-01-10 07:22:54', 1, 1, 2, 'ok', 2, 'ok', '2021-01-10', '10:00', 'Lab Informatika', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pend_sidang_syarat`
--

CREATE TABLE `pend_sidang_syarat` (
  `id_syarat` int(11) NOT NULL,
  `file` varchar(256) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `id_sidang` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pend_sidang_syarat`
--

INSERT INTO `pend_sidang_syarat` (`id_syarat`, `file`, `status`, `id_sidang`) VALUES
(1, '160511030-10-Jan-2021-02-20-30-c7f8b5ca27404a7094dd253e746ffccd.pdf', 2, '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pkl`
--

CREATE TABLE `pkl` (
  `id_pkl` int(11) NOT NULL,
  `judul_laporan` varchar(150) NOT NULL,
  `instansi` varchar(100) NOT NULL,
  `surat_balasan` varchar(256) DEFAULT NULL,
  `nim` varchar(11) NOT NULL,
  `id_dosenwali` varchar(5) NOT NULL,
  `lem_rev` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pkl`
--

INSERT INTO `pkl` (`id_pkl`, `judul_laporan`, `instansi`, `surat_balasan`, `nim`, `id_dosenwali`, `lem_rev`) VALUES
(1, 'Sistem Informasi Manajemen Praktik Kerja Lapangan', 'Dinas Komunikasi Informatika Dan Statistik', NULL, '160511030', '0', '160511030-10-Jan-2021-02-07-39-contoh lembar revisi.pdf');

--
-- Trigger `pkl`
--
DELIMITER $$
CREATE TRIGGER `delete_pkl` AFTER DELETE ON `pkl` FOR EACH ROW BEGIN

INSERT INTO pkl_log (action, u_create, id_pkl, judul_laporan, instansi, surat_balasan, nim, id_dosenwali, lem_rev) VALUES
(@action2, @user, old.id_pkl, old.judul_laporan, old.instansi, old.surat_balasan, old.nim, old.id_dosenwali, old.lem_rev);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_pkl` AFTER INSERT ON `pkl` FOR EACH ROW BEGIN

INSERT INTO `pkl_log` (action, u_create, `id_pkl`, `judul_laporan`, `instansi`, `surat_balasan`, `nim`, `id_dosenwali`, `lem_rev`) VALUES
(@action1, @user, new.id_pkl, new.judul_laporan, new.instansi, new.surat_balasan, new.nim, new.id_dosenwali, new.lem_rev);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_pkl` AFTER UPDATE ON `pkl` FOR EACH ROW BEGIN

INSERT INTO pkl_log (action, u_create, id_pkl, judul_laporan, instansi, surat_balasan, nim, id_dosenwali, lem_rev) VALUES
(@action, @user, old.id_pkl, old.judul_laporan, old.instansi, old.surat_balasan, old.nim, old.id_dosenwali, old.lem_rev);

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pkl_bim`
--

CREATE TABLE `pkl_bim` (
  `id_bimPKL` int(11) NOT NULL,
  `id_pkl` int(11) NOT NULL,
  `subjek` varchar(100) DEFAULT NULL,
  `deskripsi` varchar(100) DEFAULT NULL,
  `tanggal` date NOT NULL DEFAULT current_timestamp(),
  `nim` int(11) NOT NULL,
  `nidn` varchar(20) DEFAULT NULL,
  `file_bim` varchar(100) DEFAULT NULL,
  `file_hasilbim` varchar(100) DEFAULT NULL,
  `pesan` varchar(256) DEFAULT NULL,
  `status` enum('Bimbingan Laporan','Bimbingan Pasca') DEFAULT NULL,
  `status_dosbing` varchar(15) DEFAULT 'Belum Dibaca',
  `status_mhs` varchar(15) DEFAULT NULL,
  `status_bim` enum('Layak','Revisi','Lanjut BAB') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pkl_bim`
--

INSERT INTO `pkl_bim` (`id_bimPKL`, `id_pkl`, `subjek`, `deskripsi`, `tanggal`, `nim`, `nidn`, `file_bim`, `file_hasilbim`, `pesan`, `status`, `status_dosbing`, `status_mhs`, `status_bim`) VALUES
(1, 1, 'Bimbingan 1', 'bimbingan bu', '2021-01-10', 160511030, '0421117105', '160511030-2021-01-10-01-57-24-Contoh-File-Bimbingan.pdf', '0421117105-10-Jan-2021-02-04-58-Contoh-File-Bimbingan.pdf', 'ok', 'Bimbingan Laporan', 'Dibalas', 'Dibaca', 'Layak'),
(2, 1, 'Bimbingan 1', 'ok', '2021-01-10', 160511030, '0421117105', '160511030-10-Jan-2021-02-07-31-Contoh-File-Bimbingan.pdf', '0421117105-10-Jan-2021-02-08-03-Contoh-File-Bimbingan.pdf', 'ok', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Layak');

--
-- Trigger `pkl_bim`
--
DELIMITER $$
CREATE TRIGGER `delete_pklbim` AFTER DELETE ON `pkl_bim` FOR EACH ROW BEGIN

INSERT INTO pkl_bim_log (action, u_create, id_bimPKL, id_pkl, subjek, deskripsi, tanggal, nim, nidn, file_bim, file_hasilbim, pesan, status, status_dosbing, status_mhs, status_bim) VALUES
(@action2, @user, old.id_bimPKL, old.id_pkl, old.subjek, old.deskripsi, old.tanggal, old.nim, old.nidn, old.file_bim, old.file_hasilbim, old.pesan, old.status, old.status_dosbing, old.status_mhs, old.status_bim);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_bimpkl` AFTER INSERT ON `pkl_bim` FOR EACH ROW BEGIN

INSERT INTO `pkl_bim_log` (action, u_create, `id_bimPKL`, `id_pkl`, `subjek`, `deskripsi`, `tanggal`, `nim`, `nidn`, `file_bim`, `file_hasilbim`, `pesan`, `status`, `status_dosbing`, `status_mhs`, `status_bim`) VALUES
(@action1, @user, new.id_bimPKL, new.id_pkl, new.subjek, new.deskripsi, new.tanggal, new.nim, new.nidn, new.file_bim, new.file_hasilbim, new.pesan, new.status, new.status_dosbing, new.status_mhs, new.status_bim);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_bimpkl` AFTER UPDATE ON `pkl_bim` FOR EACH ROW BEGIN

INSERT INTO pkl_bim_log (action, u_create, id_bimPKL, id_pkl, subjek, deskripsi, tanggal, nim, nidn, file_bim, file_hasilbim, pesan, status, status_dosbing, status_mhs, status_bim) VALUES
(@action, @user, old.id_bimPKL, old.id_pkl, old.subjek, old.deskripsi, old.tanggal, old.nim, old.nidn, old.file_bim, old.file_hasilbim, old.pesan, old.status, old.status_dosbing, old.status_mhs, old.status_bim);

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pkl_bim_log`
--

CREATE TABLE `pkl_bim_log` (
  `id_row` int(11) NOT NULL,
  `action` varchar(56) NOT NULL,
  `u_create` varchar(56) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_bimPKL` int(11) NOT NULL,
  `id_pkl` int(11) NOT NULL,
  `subjek` varchar(100) DEFAULT NULL,
  `deskripsi` varchar(100) DEFAULT NULL,
  `tanggal` date NOT NULL DEFAULT current_timestamp(),
  `nim` int(11) NOT NULL,
  `nidn` varchar(20) DEFAULT NULL,
  `file_bim` varchar(100) DEFAULT NULL,
  `file_hasilbim` varchar(100) DEFAULT NULL,
  `pesan` varchar(256) DEFAULT NULL,
  `status` enum('Bimbingan Laporan','Bimbingan Pasca') DEFAULT NULL,
  `status_dosbing` varchar(15) DEFAULT 'Belum Dibaca',
  `status_mhs` varchar(15) DEFAULT NULL,
  `status_bim` enum('Layak','Revisi','Lanjut BAB') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pkl_bim_log`
--

INSERT INTO `pkl_bim_log` (`id_row`, `action`, `u_create`, `time`, `id_bimPKL`, `id_pkl`, `subjek`, `deskripsi`, `tanggal`, `nim`, `nidn`, `file_bim`, `file_hasilbim`, `pesan`, `status`, `status_dosbing`, `status_mhs`, `status_bim`) VALUES
(1, 'insert', 'Mohamad Irfan Manaf', '2021-01-10 06:57:25', 1, 1, 'Bimbingan 1', 'bimbingan bu', '2021-01-10', 160511030, '0421117105', '160511030-2021-01-10-01-57-24-Contoh-File-Bimbingan.pdf', NULL, NULL, 'Bimbingan Laporan', 'Belum Dibaca', NULL, NULL),
(2, 'update', 'Dian Novianti, M.Kom', '2021-01-10 07:04:58', 1, 1, 'Bimbingan 1', 'bimbingan bu', '2021-01-10', 160511030, '0421117105', '160511030-2021-01-10-01-57-24-Contoh-File-Bimbingan.pdf', NULL, NULL, 'Bimbingan Laporan', 'Belum Dibaca', NULL, NULL),
(3, 'update', 'Mohamad Irfan Manaf', '2021-01-10 07:05:06', 1, 1, 'Bimbingan 1', 'bimbingan bu', '2021-01-10', 160511030, '0421117105', '160511030-2021-01-10-01-57-24-Contoh-File-Bimbingan.pdf', '0421117105-10-Jan-2021-02-04-58-Contoh-File-Bimbingan.pdf', 'ok', 'Bimbingan Laporan', 'Dibalas', 'Belum Dibaca', 'Layak'),
(4, 'insert', 'Mohamad Irfan Manaf', '2021-01-10 07:07:31', 2, 1, 'Bimbingan 1', 'ok', '2021-01-10', 160511030, '0421117105', '160511030-10-Jan-2021-02-07-31-Contoh-File-Bimbingan.pdf', NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', NULL, NULL),
(5, 'update', 'Dian Novianti, M.Kom', '2021-01-10 07:08:03', 2, 1, 'Bimbingan 1', 'ok', '2021-01-10', 160511030, '0421117105', '160511030-10-Jan-2021-02-07-31-Contoh-File-Bimbingan.pdf', NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', NULL, NULL),
(6, 'update', 'Mohamad Irfan Manaf', '2021-01-10 07:25:24', 2, 1, 'Bimbingan 1', 'ok', '2021-01-10', 160511030, '0421117105', '160511030-10-Jan-2021-02-07-31-Contoh-File-Bimbingan.pdf', '0421117105-10-Jan-2021-02-08-03-Contoh-File-Bimbingan.pdf', 'ok', 'Bimbingan Pasca', 'Dibalas', 'Belum Dibaca', 'Layak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pkl_file`
--

CREATE TABLE `pkl_file` (
  `id_filePKL` int(11) NOT NULL,
  `filePKL` varchar(100) NOT NULL,
  `id_pkl` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pkl_file`
--

INSERT INTO `pkl_file` (`id_filePKL`, `filePKL`, `id_pkl`) VALUES
(1, '160511030-10-Jan-2021-02-08-20-Contoh-File-Bimbingan.pdf', 1);

--
-- Trigger `pkl_file`
--
DELIMITER $$
CREATE TRIGGER `delete_filepkl` AFTER DELETE ON `pkl_file` FOR EACH ROW BEGIN

INSERT INTO pkl_file_log (action, u_create, id_filePKL, filePKL, id_pkl) VALUES
(@action2, @user, old.id_filePKL, old.filePKL, old.id_pkl);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_filepkl` AFTER INSERT ON `pkl_file` FOR EACH ROW BEGIN

INSERT INTO `pkl_file_log` (action, u_create, `id_filePKL`, `filePKL`, `id_pkl`) VALUES
(@action1, @user, new.id_filePKL, new.filePKL, new.id_pkl);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_filepkl` AFTER UPDATE ON `pkl_file` FOR EACH ROW BEGIN

INSERT INTO pkl_file_log (action, u_create, id_filePKL, filePKL, id_pkl) VALUES
(@action1, @user, old.id_filePKL, old.filePKL, old.id_pkl);

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pkl_file_log`
--

CREATE TABLE `pkl_file_log` (
  `id_row` int(11) NOT NULL,
  `action` varchar(56) NOT NULL,
  `u_create` varchar(56) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_filePKL` int(11) NOT NULL,
  `filePKL` varchar(100) NOT NULL,
  `id_pkl` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pkl_file_log`
--

INSERT INTO `pkl_file_log` (`id_row`, `action`, `u_create`, `time`, `id_filePKL`, `filePKL`, `id_pkl`) VALUES
(1, 'insert', 'Mohamad Irfan Manaf', '2021-01-10 07:08:20', 1, '160511030-10-Jan-2021-02-08-20-Contoh-File-Bimbingan.pdf', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pkl_log`
--

CREATE TABLE `pkl_log` (
  `id_row` int(11) NOT NULL,
  `action` varchar(56) NOT NULL,
  `u_create` varchar(56) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_pkl` int(11) NOT NULL,
  `judul_laporan` varchar(150) NOT NULL,
  `instansi` varchar(100) NOT NULL,
  `surat_balasan` varchar(256) DEFAULT NULL,
  `nim` varchar(11) NOT NULL,
  `id_dosenwali` varchar(5) NOT NULL,
  `lem_rev` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pkl_log`
--

INSERT INTO `pkl_log` (`id_row`, `action`, `u_create`, `time`, `id_pkl`, `judul_laporan`, `instansi`, `surat_balasan`, `nim`, `id_dosenwali`, `lem_rev`) VALUES
(1, 'insert', 'Mohamad Irfan Manaf', '2021-01-10 06:51:56', 1, 'Sistem Informasi Manajemen Praktik Kerja Lapangan', 'Dinas Komunikasi Informatika Dan Statistik', NULL, '160511030', '0', NULL),
(2, 'update', 'Mohamad Irfan Manaf', '2021-01-10 07:07:39', 1, 'Sistem Informasi Manajemen Praktik Kerja Lapangan', 'Dinas Komunikasi Informatika Dan Statistik', NULL, '160511030', '0', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pkl_nilai`
--

CREATE TABLE `pkl_nilai` (
  `id_nilai` int(11) NOT NULL,
  `id_sidang` int(11) NOT NULL,
  `pem_pen_mat` float DEFAULT NULL,
  `pem_peng_mat` float DEFAULT NULL,
  `pem_sis` float DEFAULT NULL,
  `peng_pen_mat` float DEFAULT NULL,
  `peng_peng_mat` float DEFAULT NULL,
  `peng_sis` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pkl_nilai`
--

INSERT INTO `pkl_nilai` (`id_nilai`, `id_sidang`, `pem_pen_mat`, `pem_peng_mat`, `pem_sis`, `peng_pen_mat`, `peng_peng_mat`, `peng_sis`) VALUES
(1, 1, 90, 90, 90, 90, 90, 90);

--
-- Trigger `pkl_nilai`
--
DELIMITER $$
CREATE TRIGGER `delete_pklnilai` AFTER DELETE ON `pkl_nilai` FOR EACH ROW BEGIN

INSERT INTO pkl_nilai_log (action, u_create, id_nilai, id_sidang, pem_pen_mat, pem_peng_mat, pem_sis, peng_pen_mat, peng_peng_mat, peng_sis) VALUES
(@action2, @user, old.id_nilai, old.id_sidang, old.pem_pen_mat, old.pem_peng_mat, old.pem_sis, old.peng_pen_mat, old.peng_peng_mat, old.peng_sis);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_pklnilai` AFTER INSERT ON `pkl_nilai` FOR EACH ROW BEGIN

INSERT INTO `pkl_nilai_log` (action, u_create, `id_nilai`, `id_sidang`, `pem_pen_mat`, `pem_peng_mat`, `pem_sis`, `peng_pen_mat`, `peng_peng_mat`, `peng_sis`) VALUES
(@action1, @user, new.id_nilai, new.id_sidang, new.pem_pen_mat, new.pem_peng_mat, new.pem_sis, new.peng_pen_mat, new.peng_peng_mat, new.peng_sis);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_nilaipkl` AFTER UPDATE ON `pkl_nilai` FOR EACH ROW BEGIN

INSERT INTO pkl_nilai_log (action, u_create, id_nilai, id_sidang, pem_pen_mat, pem_peng_mat, pem_sis, peng_pen_mat, peng_peng_mat, peng_sis) VALUES
(@action, @user, old.id_nilai, old.id_sidang, old.pem_pen_mat, old.pem_peng_mat, old.pem_sis, old.peng_pen_mat, old.peng_peng_mat, old.peng_sis);

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pkl_nilai_log`
--

CREATE TABLE `pkl_nilai_log` (
  `id_row` int(11) NOT NULL,
  `action` varchar(56) NOT NULL,
  `u_create` varchar(56) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_nilai` int(11) NOT NULL,
  `id_sidang` int(11) NOT NULL,
  `pem_pen_mat` float DEFAULT NULL,
  `pem_peng_mat` float DEFAULT NULL,
  `pem_sis` float DEFAULT NULL,
  `peng_pen_mat` float DEFAULT NULL,
  `peng_peng_mat` float DEFAULT NULL,
  `peng_sis` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pkl_nilai_log`
--

INSERT INTO `pkl_nilai_log` (`id_row`, `action`, `u_create`, `time`, `id_nilai`, `id_sidang`, `pem_pen_mat`, `pem_peng_mat`, `pem_sis`, `peng_pen_mat`, `peng_peng_mat`, `peng_sis`) VALUES
(1, 'insert', 'Dian Novianti, M.Kom', '2021-01-10 07:06:38', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'update', 'Tatang', '2021-01-10 07:07:00', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pkl_sidang`
--

CREATE TABLE `pkl_sidang` (
  `id_sidpkl` int(11) NOT NULL,
  `id_pkl` int(11) NOT NULL,
  `val_dosbing` tinyint(1) NOT NULL,
  `pesan` varchar(100) DEFAULT NULL,
  `penguji` varchar(20) DEFAULT NULL,
  `tgl_sid` date DEFAULT NULL,
  `waktu` varchar(10) DEFAULT NULL,
  `ruang_sid` varchar(50) DEFAULT NULL,
  `status_sid` enum('Lulus','Tidak Lulus') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pkl_sidang`
--

INSERT INTO `pkl_sidang` (`id_sidpkl`, `id_pkl`, `val_dosbing`, `pesan`, `penguji`, `tgl_sid`, `waktu`, `ruang_sid`, `status_sid`) VALUES
(1, 1, 2, 'ok', '0403079201', '2021-01-10', '08:00', 'Lab Informatika', 'Lulus');

--
-- Trigger `pkl_sidang`
--
DELIMITER $$
CREATE TRIGGER `delete_pklsidang` AFTER DELETE ON `pkl_sidang` FOR EACH ROW BEGIN

INSERT INTO pkl_sidang_log (action, u_create, id_sidpkl, id_pkl, val_dosbing, pesan, penguji, tgl_sid, waktu, ruang_sid, status_sid) VALUES
(@action2, @user, old.id_sidpkl, old.id_pkl, old.val_dosbing, old.pesan, old.penguji, old.tgl_sid, old.waktu, old.ruang_sid, old.status_sid);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_pklsidang` AFTER INSERT ON `pkl_sidang` FOR EACH ROW BEGIN

INSERT INTO `pkl_sidang_log` (action, u_create, `id_sidpkl`, `id_pkl`, `val_dosbing`, `pesan`, `penguji`, `tgl_sid`, `waktu`, `ruang_sid`, `status_sid`) VALUES
(@action1, @user, new.id_sidpkl, new.id_pkl, new.val_dosbing, new.pesan, new.penguji, new.tgl_sid, new.waktu, new.ruang_sid, new.status_sid);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_pklsidang` AFTER UPDATE ON `pkl_sidang` FOR EACH ROW BEGIN

INSERT INTO pkl_sidang_log (action, u_create, id_sidpkl, id_pkl, val_dosbing, pesan, penguji, tgl_sid, waktu, ruang_sid, status_sid) VALUES
(@action, @user, old.id_sidpkl, old.id_pkl, old.val_dosbing, old.pesan, old.penguji, old.tgl_sid, old.waktu, old.ruang_sid, old.status_sid);

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pkl_sidang_log`
--

CREATE TABLE `pkl_sidang_log` (
  `id_row` int(11) NOT NULL,
  `action` varchar(56) NOT NULL,
  `u_create` varchar(56) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_sidpkl` int(11) NOT NULL,
  `id_pkl` int(11) NOT NULL,
  `val_dosbing` tinyint(1) NOT NULL,
  `pesan` varchar(100) DEFAULT NULL,
  `penguji` varchar(20) DEFAULT NULL,
  `tgl_sid` date DEFAULT NULL,
  `waktu` varchar(10) DEFAULT NULL,
  `ruang_sid` varchar(50) DEFAULT NULL,
  `status_sid` enum('Lulus','Tidak Lulus') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pkl_sidang_log`
--

INSERT INTO `pkl_sidang_log` (`id_row`, `action`, `u_create`, `time`, `id_sidpkl`, `id_pkl`, `val_dosbing`, `pesan`, `penguji`, `tgl_sid`, `waktu`, `ruang_sid`, `status_sid`) VALUES
(1, 'insert', 'Mohamad Irfan Manaf', '2021-01-10 07:05:20', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'update', 'Dian Novianti, M.Kom', '2021-01-10 07:05:35', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'update', 'Dian Novianti, M.Kom', '2021-01-10 07:06:38', 1, 1, 2, 'ok', NULL, NULL, NULL, NULL, NULL),
(4, 'update', 'Tatang', '2021-01-10 07:07:00', 1, 1, 2, 'ok', '0403079201', '2021-01-10', '08:00', 'Lab Informatika', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pkl_syarat`
--

CREATE TABLE `pkl_syarat` (
  `id_syarat` int(11) NOT NULL,
  `tanggal` date NOT NULL DEFAULT current_timestamp(),
  `file` varchar(256) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `pesan` varchar(100) DEFAULT NULL,
  `nim` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pkl_syarat`
--

INSERT INTO `pkl_syarat` (`id_syarat`, `tanggal`, `file`, `status`, `pesan`, `nim`) VALUES
(1, '2021-01-10', '160511030-10-Jan-2021-01-43-11-c7f8b5ca27404a7094dd253e746ffccd.pdf', 2, 'ok', '160511030');

--
-- Trigger `pkl_syarat`
--
DELIMITER $$
CREATE TRIGGER `delete_pklsyarat` AFTER DELETE ON `pkl_syarat` FOR EACH ROW BEGIN

INSERT INTO pkl_syarat_log (action, u_create, id_syarat, tanggal, file, status, pesan, nim) VALUES
(@action2, @user, old.id_syarat, old.tanggal, old.file, old.status, old.pesan, old.nim);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_pklsyarat` AFTER INSERT ON `pkl_syarat` FOR EACH ROW BEGIN

INSERT INTO `pkl_syarat_log` (action, u_create, `id_syarat`, `tanggal`, `file`, `status`, `pesan`, `nim`) VALUES
(@action1, @user, new.id_syarat, new.tanggal, new.file, new.status, new.pesan, new.nim);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_pklsyarat` AFTER UPDATE ON `pkl_syarat` FOR EACH ROW BEGIN

INSERT INTO pkl_syarat_log (action, u_create, id_syarat, tanggal, file, status, pesan, nim) VALUES
(@action, @user, old.id_syarat, old.tanggal, old.file, old.status, old.pesan, old.nim);

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pkl_syarat_log`
--

CREATE TABLE `pkl_syarat_log` (
  `id_row` int(11) NOT NULL,
  `action` varchar(56) NOT NULL,
  `u_create` varchar(56) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_syarat` int(11) NOT NULL,
  `tanggal` date NOT NULL DEFAULT current_timestamp(),
  `file` varchar(256) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `pesan` varchar(100) DEFAULT NULL,
  `nim` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pkl_syarat_log`
--

INSERT INTO `pkl_syarat_log` (`id_row`, `action`, `u_create`, `time`, `id_syarat`, `tanggal`, `file`, `status`, `pesan`, `nim`) VALUES
(1, 'insert', 'Mohamad Irfan Manaf', '2021-01-10 06:43:11', 1, '2021-01-10', '160511030-10-Jan-2021-01-43-11-c7f8b5ca27404a7094dd253e746ffccd.pdf', 0, NULL, '160511030'),
(2, 'update', 'Tatang', '2021-01-10 06:48:57', 1, '2021-01-10', '160511030-10-Jan-2021-01-43-11-c7f8b5ca27404a7094dd253e746ffccd.pdf', 0, NULL, '160511030');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pkl_syarat_sidang`
--

CREATE TABLE `pkl_syarat_sidang` (
  `id_syarat` int(11) NOT NULL,
  `file` varchar(256) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `id_sidang` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pkl_syarat_sidang`
--

INSERT INTO `pkl_syarat_sidang` (`id_syarat`, `file`, `status`, `id_sidang`) VALUES
(1, '160511030-10-Jan-2021-02-05-20-contoh lembar revisi.pdf', 2, '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `proposal`
--

CREATE TABLE `proposal` (
  `id_proposal` int(11) NOT NULL,
  `id_judul` int(11) NOT NULL,
  `dosbing` varchar(20) DEFAULT NULL,
  `lem_rev` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `proposal`
--

INSERT INTO `proposal` (`id_proposal`, `id_judul`, `dosbing`, `lem_rev`) VALUES
(1, 1, '0416086408', '160511030-10-Jan-2021-02-12-57-c7f8b5ca27404a7094dd253e746ffccd.pdf');

--
-- Trigger `proposal`
--
DELIMITER $$
CREATE TRIGGER `delete_proposal` AFTER DELETE ON `proposal` FOR EACH ROW BEGIN

INSERT INTO proposal_log (action, u_create, id_proposal, id_judul, dosbing, lem_rev) VALUES
(@action2, @user, old.id_proposal, old.id_judul, old.dosbing, old.lem_rev);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_proposal` AFTER INSERT ON `proposal` FOR EACH ROW BEGIN

INSERT INTO `proposal_log` (action, u_create, `id_proposal`, `id_judul`, `dosbing`, `lem_rev`) VALUES
(@action1, @user, new.id_proposal, new.id_judul, new.dosbing, new.lem_rev);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_proposal` AFTER UPDATE ON `proposal` FOR EACH ROW BEGIN

INSERT INTO proposal_log (action, u_create, id_proposal, id_judul, dosbing, lem_rev) VALUES
(@action, @user, old.id_proposal, old.id_judul, old.dosbing, old.lem_rev);

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `proposal_bim`
--

CREATE TABLE `proposal_bim` (
  `id_bim` int(11) NOT NULL,
  `id_proposal` int(11) NOT NULL,
  `subjek` varchar(100) NOT NULL,
  `deskripsi` varchar(256) NOT NULL,
  `tgl_bim` date NOT NULL,
  `nim` int(11) NOT NULL,
  `pembimbing` varchar(20) NOT NULL,
  `file_bim` varchar(256) NOT NULL,
  `tgl_hasil` date DEFAULT NULL,
  `saran` varchar(500) DEFAULT NULL,
  `file_hasilbim` varchar(256) DEFAULT NULL,
  `status` enum('Bimbingan Proposal','Bimbingan Pasca') DEFAULT NULL,
  `status_dosbing` varchar(15) NOT NULL DEFAULT 'Belum Dibaca',
  `status_mhs` varchar(15) DEFAULT 'Belum Dibaca',
  `status_bim` enum('Layak','Revisi','Lanjut Bab') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `proposal_bim`
--

INSERT INTO `proposal_bim` (`id_bim`, `id_proposal`, `subjek`, `deskripsi`, `tgl_bim`, `nim`, `pembimbing`, `file_bim`, `tgl_hasil`, `saran`, `file_hasilbim`, `status`, `status_dosbing`, `status_mhs`, `status_bim`) VALUES
(1, 1, 'Bimbingan 1', 'bimbingan', '2021-01-10', 160511030, '0416086408', '160511030-10-Jan-2021-02-11-06-Contoh-File-Bimbingan.pdf', '0000-00-00', 'ok', '0416086408-10-Jan-2021-02-11-27-Contoh-File-Bimbingan.pdf', 'Bimbingan Proposal', 'Dibalas', 'Dibaca', 'Layak'),
(2, 1, 'Bimbingan 1', 'asda', '2021-01-10', 160511030, '0416086408', '160511030-10-Jan-2021-02-13-07-Contoh-File-Bimbingan.pdf', NULL, 'ok', '0416086408-10-Jan-2021-02-13-23-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Layak');

--
-- Trigger `proposal_bim`
--
DELIMITER $$
CREATE TRIGGER `delete_propbim` AFTER DELETE ON `proposal_bim` FOR EACH ROW BEGIN

INSERT INTO proposal_bim_log (action, u_create, id_bim, id_proposal, subjek, deskripsi, tgl_bim, nim, pembimbing, file_bim, tgl_hasil, saran, file_hasilbim, status, status_dosbing, status_mhs, status_bim) VALUES
(@action2, @user, old.id_bim, old.id_proposal, old.subjek, old.deskripsi, old.tgl_bim, old.nim, old.pembimbing, old.file_bim, old.tgl_hasil, old.saran,old.file_hasilbim, old.status, old.status_dosbing, old.status_mhs, old.status_bim);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_propbim` AFTER INSERT ON `proposal_bim` FOR EACH ROW BEGIN

INSERT INTO `proposal_bim_log` (action, u_create, `id_bim`, `id_proposal`, `subjek`, `deskripsi`, `tgl_bim`, `nim`, `pembimbing`, `file_bim`, `tgl_hasil`, `saran`, `file_hasilbim`, `status`, `status_dosbing`, `status_mhs`, `status_bim`) VALUES
(@action1, @user, new.id_bim, new.id_proposal, new.subjek, new.deskripsi, new.tgl_bim, new.nim, new.pembimbing, new.file_bim, new.tgl_hasil, new.saran,new.file_hasilbim, new.status, new.status_dosbing, new.status_mhs, new.status_bim);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_propbim` AFTER UPDATE ON `proposal_bim` FOR EACH ROW BEGIN

INSERT INTO proposal_bim_log (action, u_create, id_bim, id_proposal, subjek, deskripsi, tgl_bim, nim, pembimbing, file_bim, tgl_hasil, saran, file_hasilbim, status, status_dosbing, status_mhs, status_bim) VALUES
(@action, @user, old.id_bim, old.id_proposal, old.subjek, old.deskripsi, old.tgl_bim, old.nim, old.pembimbing, old.file_bim, old.tgl_hasil, old.saran,old.file_hasilbim, old.status, old.status_dosbing, old.status_mhs, old.status_bim);

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `proposal_bim_log`
--

CREATE TABLE `proposal_bim_log` (
  `id_row` int(11) NOT NULL,
  `action` varchar(56) DEFAULT NULL,
  `u_create` varchar(56) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_bim` int(11) NOT NULL,
  `id_proposal` int(11) NOT NULL,
  `subjek` varchar(100) NOT NULL,
  `deskripsi` varchar(256) NOT NULL,
  `tgl_bim` date NOT NULL,
  `nim` int(11) NOT NULL,
  `pembimbing` varchar(20) NOT NULL,
  `file_bim` varchar(256) NOT NULL,
  `tgl_hasil` date DEFAULT NULL,
  `saran` varchar(500) DEFAULT NULL,
  `file_hasilbim` varchar(256) DEFAULT NULL,
  `status` enum('Bimbingan Proposal','Bimbingan Pasca') DEFAULT NULL,
  `status_dosbing` varchar(15) NOT NULL DEFAULT 'Belum Dibaca',
  `status_mhs` varchar(15) DEFAULT 'Belum Dibaca',
  `status_bim` enum('Layak','Revisi','Lanjut Bab') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `proposal_bim_log`
--

INSERT INTO `proposal_bim_log` (`id_row`, `action`, `u_create`, `time`, `id_bim`, `id_proposal`, `subjek`, `deskripsi`, `tgl_bim`, `nim`, `pembimbing`, `file_bim`, `tgl_hasil`, `saran`, `file_hasilbim`, `status`, `status_dosbing`, `status_mhs`, `status_bim`) VALUES
(1, 'insert', 'Mohamad Irfan Manaf', '2021-01-10 07:11:06', 1, 1, 'Bimbingan 1', 'bimbingan', '2021-01-10', 160511030, '0416086408', '160511030-10-Jan-2021-02-11-06-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Proposal', 'Belum Dibaca', 'Belum Dibaca', NULL),
(2, 'update', 'Agust Isa Martinus, M.T', '2021-01-10 07:11:27', 1, 1, 'Bimbingan 1', 'bimbingan', '2021-01-10', 160511030, '0416086408', '160511030-10-Jan-2021-02-11-06-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Proposal', 'Belum Dibaca', 'Belum Dibaca', NULL),
(3, 'insert', 'Mohamad Irfan Manaf', '2021-01-10 07:13:07', 2, 1, 'Bimbingan 1', 'asda', '2021-01-10', 160511030, '0416086408', '160511030-10-Jan-2021-02-13-07-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', 'Belum Dibaca', NULL),
(4, 'update', 'Agust Isa Martinus, M.T', '2021-01-10 07:13:23', 2, 1, 'Bimbingan 1', 'asda', '2021-01-10', 160511030, '0416086408', '160511030-10-Jan-2021-02-13-07-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', 'Belum Dibaca', NULL),
(5, 'update', 'Mohamad Irfan Manaf', '2021-01-10 07:13:29', 2, 1, 'Bimbingan 1', 'asda', '2021-01-10', 160511030, '0416086408', '160511030-10-Jan-2021-02-13-07-Contoh-File-Bimbingan.pdf', NULL, 'ok', '0416086408-10-Jan-2021-02-13-23-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Belum Dibaca', 'Layak'),
(6, 'update', 'Mohamad Irfan Manaf', '2021-01-10 07:25:33', 1, 1, 'Bimbingan 1', 'bimbingan', '2021-01-10', 160511030, '0416086408', '160511030-10-Jan-2021-02-11-06-Contoh-File-Bimbingan.pdf', '0000-00-00', 'ok', '0416086408-10-Jan-2021-02-11-27-Contoh-File-Bimbingan.pdf', 'Bimbingan Proposal', 'Dibalas', 'Belum Dibaca', 'Layak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `proposal_file`
--

CREATE TABLE `proposal_file` (
  `id_file` int(11) NOT NULL,
  `file` varchar(256) NOT NULL,
  `id_proposal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `proposal_file`
--

INSERT INTO `proposal_file` (`id_file`, `file`, `id_proposal`) VALUES
(1, '160511030-10-Jan-2021-02-13-38-Contoh-File-Bimbingan.pdf', 1);

--
-- Trigger `proposal_file`
--
DELIMITER $$
CREATE TRIGGER `delete_fileprop` AFTER DELETE ON `proposal_file` FOR EACH ROW BEGIN

INSERT INTO proposal_file_log (action, u_create, id_file, file, id_proposal) VALUES
(@action, @user, old.id_file, old.file, old.id_proposal);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_propfile` AFTER INSERT ON `proposal_file` FOR EACH ROW BEGIN

INSERT INTO `proposal_file_log` (action, u_create, `id_file`, `file`, `id_proposal`) VALUES
(@action1, @user, new.id_file, new.file, new.id_proposal);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_fileprop` AFTER UPDATE ON `proposal_file` FOR EACH ROW BEGIN

INSERT INTO proposal_file_log (action, u_create, id_file, file, id_proposal) VALUES
(@action, @user, old.id_file, old.file, old.id_proposal);

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `proposal_file_log`
--

CREATE TABLE `proposal_file_log` (
  `id_row` int(11) NOT NULL,
  `action` varchar(56) NOT NULL,
  `u_create` varchar(56) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_file` int(11) NOT NULL,
  `file` varchar(256) NOT NULL,
  `id_proposal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `proposal_file_log`
--

INSERT INTO `proposal_file_log` (`id_row`, `action`, `u_create`, `time`, `id_file`, `file`, `id_proposal`) VALUES
(1, 'insert', 'Mohamad Irfan Manaf', '2021-01-10 07:13:38', 1, '160511030-10-Jan-2021-02-13-38-Contoh-File-Bimbingan.pdf', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `proposal_log`
--

CREATE TABLE `proposal_log` (
  `id_row` int(11) NOT NULL,
  `action` varchar(56) NOT NULL,
  `u_create` varchar(56) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_proposal` int(11) NOT NULL,
  `id_judul` int(11) NOT NULL,
  `dosbing` varchar(20) DEFAULT NULL,
  `lem_rev` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `proposal_log`
--

INSERT INTO `proposal_log` (`id_row`, `action`, `u_create`, `time`, `id_proposal`, `id_judul`, `dosbing`, `lem_rev`) VALUES
(1, 'insert', 'Agust Isa Martinus, M.T', '2021-01-10 07:10:35', 1, 1, '0416086408', NULL),
(2, 'update', 'Mohamad Irfan Manaf', '2021-01-10 07:12:57', 1, 1, '0416086408', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `proposal_penguji`
--

CREATE TABLE `proposal_penguji` (
  `id_penguji` int(11) NOT NULL,
  `id_sidang` int(11) NOT NULL,
  `penguji` varchar(20) NOT NULL,
  `status_penguji` enum('Penguji 1','Penguji 2','','') NOT NULL,
  `status` enum('Aktif','Tidak Aktif') NOT NULL DEFAULT 'Aktif',
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `proposal_penguji`
--

INSERT INTO `proposal_penguji` (`id_penguji`, `id_sidang`, `penguji`, `status_penguji`, `status`, `time`) VALUES
(1, 1, '0402057307', 'Penguji 1', 'Aktif', '2021-01-10 07:12:30'),
(2, 1, '0409046101', 'Penguji 2', 'Aktif', '2021-01-10 07:12:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `proposal_sidang`
--

CREATE TABLE `proposal_sidang` (
  `id_sidang` int(11) NOT NULL,
  `id_proposal` int(11) NOT NULL,
  `val_dosbing` tinyint(1) NOT NULL,
  `pesan` varchar(100) DEFAULT NULL,
  `tgl_sidang` date DEFAULT NULL,
  `waktu_sidang` varchar(10) DEFAULT NULL,
  `ruang_sidang` varchar(50) DEFAULT NULL,
  `status_sidang` enum('Lulus','Tidak Lulus') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `proposal_sidang`
--

INSERT INTO `proposal_sidang` (`id_sidang`, `id_proposal`, `val_dosbing`, `pesan`, `tgl_sidang`, `waktu_sidang`, `ruang_sidang`, `status_sidang`) VALUES
(1, 1, 2, 'ok', '2021-01-10', '09:00', 'Lab Informatika', 'Lulus');

--
-- Trigger `proposal_sidang`
--
DELIMITER $$
CREATE TRIGGER `delete_propsid` AFTER DELETE ON `proposal_sidang` FOR EACH ROW BEGIN

INSERT INTO proposal_sidang_log (action, u_create, id_sidang, id_proposal, val_dosbing, pesan, tgl_sidang, waktu_sidang, ruang_sidang, status_sidang) VALUES
(@action, @user, old.id_sidang, old.id_proposal, old.val_dosbing, old.pesan, old.tgl_sidang, old.waktu_sidang, old.ruang_sidang, old.status_sidang);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_propsid` AFTER INSERT ON `proposal_sidang` FOR EACH ROW BEGIN

INSERT INTO `proposal_sidang_log` (action, u_create, `id_sidang`, `id_proposal`, `val_dosbing`, `pesan`, `tgl_sidang`, `waktu_sidang`, `ruang_sidang`, `status_sidang`) VALUES
(@action1, @user, new.id_sidang, new.id_proposal, new.val_dosbing, new.pesan, new.tgl_sidang, new.waktu_sidang, new.ruang_sidang, new.status_sidang);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_propsid` AFTER UPDATE ON `proposal_sidang` FOR EACH ROW BEGIN

INSERT INTO proposal_sidang_log (action, u_create, id_sidang, id_proposal, val_dosbing, pesan, tgl_sidang, waktu_sidang, ruang_sidang, status_sidang) VALUES
(@action, @user, old.id_sidang, old.id_proposal, old.val_dosbing, old.pesan, old.tgl_sidang, old.waktu_sidang, old.ruang_sidang, old.status_sidang);

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `proposal_sidang_log`
--

CREATE TABLE `proposal_sidang_log` (
  `id_row` int(11) NOT NULL,
  `action` varchar(56) NOT NULL,
  `u_create` varchar(56) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_sidang` int(11) NOT NULL,
  `id_proposal` int(11) NOT NULL,
  `val_dosbing` tinyint(1) NOT NULL,
  `pesan` varchar(100) DEFAULT NULL,
  `tgl_sidang` date DEFAULT NULL,
  `waktu_sidang` varchar(10) DEFAULT NULL,
  `ruang_sidang` varchar(50) DEFAULT NULL,
  `status_sidang` enum('Lulus','Tidak Lulus') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `proposal_sidang_log`
--

INSERT INTO `proposal_sidang_log` (`id_row`, `action`, `u_create`, `time`, `id_sidang`, `id_proposal`, `val_dosbing`, `pesan`, `tgl_sidang`, `waktu_sidang`, `ruang_sidang`, `status_sidang`) VALUES
(1, 'insert', 'Mohamad Irfan Manaf', '2021-01-10 07:11:36', 1, 1, 0, NULL, NULL, NULL, NULL, NULL),
(2, 'update', 'Agust Isa Martinus, M.T', '2021-01-10 07:11:53', 1, 1, 0, NULL, NULL, NULL, NULL, NULL),
(3, 'update', 'Dian Novianti, M.Kom', '2021-01-10 07:12:30', 1, 1, 2, 'ok', NULL, NULL, NULL, NULL),
(4, 'update', 'Tatang', '2021-01-10 07:12:46', 1, 1, 2, 'ok', '2021-01-10', '09:00', 'Lab Informatika', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `proposal_sidang_syarat`
--

CREATE TABLE `proposal_sidang_syarat` (
  `id_syarat` int(11) NOT NULL,
  `file` varchar(256) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `id_sidang` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `proposal_sidang_syarat`
--

INSERT INTO `proposal_sidang_syarat` (`id_syarat`, `file`, `status`, `id_sidang`) VALUES
(1, '160511030-10-Jan-2021-02-11-36-c7f8b5ca27404a7094dd253e746ffccd.pdf', 2, '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `skripsi`
--

CREATE TABLE `skripsi` (
  `id_skripsi` int(11) NOT NULL,
  `id_proposal` int(11) NOT NULL,
  `lem_rev_draft` varchar(256) DEFAULT NULL,
  `lem_rev_pend` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `skripsi`
--

INSERT INTO `skripsi` (`id_skripsi`, `id_proposal`, `lem_rev_draft`, `lem_rev_pend`) VALUES
(1, 1, '160511030-10-Jan-2021-02-19-51-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511030-10-Jan-2021-02-23-13-c7f8b5ca27404a7094dd253e746ffccd.pdf');

--
-- Trigger `skripsi`
--
DELIMITER $$
CREATE TRIGGER `delete_skripsi` AFTER DELETE ON `skripsi` FOR EACH ROW BEGIN

INSERT INTO skripsi_log (action, u_create, id_skripsi, id_proposal, lem_rev_draft, lem_rev_pend) VALUES
(@action, @user, old.id_skripsi, old.id_proposal, old.lem_rev_draft, old.lem_rev_pend);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_skrip` AFTER INSERT ON `skripsi` FOR EACH ROW BEGIN

INSERT INTO `skripsi_log` (action, u_create, `id_skripsi`, `id_proposal`, `lem_rev_draft`, `lem_rev_pend`) VALUES
(@action1, @user, new.id_skripsi, new.id_proposal, new.lem_rev_draft, new.lem_rev_pend);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_skripsi` AFTER UPDATE ON `skripsi` FOR EACH ROW BEGIN

INSERT INTO skripsi_log (action, u_create, id_skripsi, id_proposal, lem_rev_draft, lem_rev_pend) VALUES
(@action, @user, old.id_skripsi, old.id_proposal, old.lem_rev_draft, old.lem_rev_pend);

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `skripsi_bim`
--

CREATE TABLE `skripsi_bim` (
  `id_bim` int(11) NOT NULL,
  `id_skripsi` int(11) NOT NULL,
  `subjek` varchar(100) NOT NULL,
  `deskripsi` varchar(256) NOT NULL,
  `tgl_bim` date NOT NULL,
  `nim` varchar(11) NOT NULL,
  `pembimbing` varchar(20) NOT NULL,
  `file_bim` varchar(256) NOT NULL,
  `tgl_hasil` date DEFAULT NULL,
  `saran` varchar(500) DEFAULT NULL,
  `file_hasilbim` varchar(256) DEFAULT NULL,
  `status` enum('Bimbingan Draft','Bimbingan Pendadaran','Bimbingan Pasca') NOT NULL,
  `status_dosbing` varchar(15) NOT NULL DEFAULT 'Belum Dibaca',
  `status_mhs` varchar(15) NOT NULL DEFAULT 'Belum Dibaca',
  `status_bim` enum('Layak','Revisi','Lanjut Bab') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `skripsi_bim`
--

INSERT INTO `skripsi_bim` (`id_bim`, `id_skripsi`, `subjek`, `deskripsi`, `tgl_bim`, `nim`, `pembimbing`, `file_bim`, `tgl_hasil`, `saran`, `file_hasilbim`, `status`, `status_dosbing`, `status_mhs`, `status_bim`) VALUES
(1, 1, 'Bimbingan 1', 'asda', '2021-01-10', '160511030', '0416086408', '160511030-10-Jan-2021-02-14-18-Contoh-File-Bimbingan.pdf', '2021-01-10', 'ok', '0416086408-10-Jan-2021-02-14-48-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Draft', 'Dibalas', 'Dibaca', 'Layak'),
(2, 1, 'ok', 'ok', '2021-01-10', '160511030', '0416086408', '160511030-10-Jan-2021-02-20-02-Contoh-File-Hasil_Bimbingan.pdf', NULL, 'ok', '0416086408-10-Jan-2021-02-20-19-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pendadaran', 'Dibalas', 'Dibaca', 'Layak'),
(3, 1, 'Bimbingan 1', 'ok', '2021-01-10', '160511030', '0421117105', '160511030-10-Jan-2021-02-23-23-Contoh-File-Bimbingan.pdf', NULL, 'ok', '0421117105-10-Jan-2021-02-23-38-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Layak');

--
-- Trigger `skripsi_bim`
--
DELIMITER $$
CREATE TRIGGER `delete_skripsibim` AFTER DELETE ON `skripsi_bim` FOR EACH ROW BEGIN

INSERT INTO skripsi_bim_log (action, u_create, id_bim, id_skripsi, subjek, deskripsi, tgl_bim, nim, pembimbing, file_bim, tgl_hasil, saran, file_hasilbim, status, status_dosbing, status_mhs, status_bim) VALUES
(@action, @user, old.id_bim, old.id_skripsi, old.subjek, old.deskripsi, old.tgl_bim, old.nim, old.pembimbing, old.file_bim, old.tgl_hasil, old.saran,old.file_hasilbim, old.status, old.status_dosbing, old.status_mhs, old.status_bim);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_skripsibim` AFTER INSERT ON `skripsi_bim` FOR EACH ROW BEGIN

INSERT INTO `skripsi_bim_log` (action, u_create, `id_bim`, `id_skripsi`, `subjek`, `deskripsi`, `tgl_bim`, `nim`, `pembimbing`, `file_bim`, `tgl_hasil`, `saran`, `file_hasilbim`, `status`, `status_dosbing`, `status_mhs`, `status_bim`) VALUES
(@action1, @user, new.id_bim, new.id_skripsi, new.subjek, new.deskripsi, new.tgl_bim, new.nim, new.pembimbing, new.file_bim, new.tgl_hasil, new.saran,new.file_hasilbim, new.status, new.status_dosbing, new.status_mhs, new.status_bim);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_skripsibim` AFTER UPDATE ON `skripsi_bim` FOR EACH ROW BEGIN

INSERT INTO skripsi_bim_log (action, u_create, id_bim, id_skripsi, subjek, deskripsi, tgl_bim, nim, pembimbing, file_bim, tgl_hasil, saran, file_hasilbim, status, status_dosbing, status_mhs, status_bim) VALUES
(@action, @user, old.id_bim, old.id_skripsi, old.subjek, old.deskripsi, old.tgl_bim, old.nim, old.pembimbing, old.file_bim, old.tgl_hasil, old.saran,old.file_hasilbim, old.status, old.status_dosbing, old.status_mhs, old.status_bim);

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `skripsi_bim_log`
--

CREATE TABLE `skripsi_bim_log` (
  `id_row` int(11) NOT NULL,
  `action` varchar(56) NOT NULL,
  `u_create` varchar(56) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_bim` int(11) NOT NULL,
  `id_skripsi` int(11) NOT NULL,
  `subjek` varchar(100) NOT NULL,
  `deskripsi` varchar(256) NOT NULL,
  `tgl_bim` date NOT NULL,
  `nim` varchar(11) NOT NULL,
  `pembimbing` varchar(20) NOT NULL,
  `file_bim` varchar(256) NOT NULL,
  `tgl_hasil` date DEFAULT NULL,
  `saran` varchar(500) DEFAULT NULL,
  `file_hasilbim` varchar(256) DEFAULT NULL,
  `status` enum('Bimbingan Draft','Bimbingan Pendadaran','Bimbingan Pasca') NOT NULL,
  `status_dosbing` varchar(15) NOT NULL DEFAULT 'Belum Dibaca',
  `status_mhs` varchar(15) NOT NULL DEFAULT 'Belum Dibaca',
  `status_bim` enum('Layak','Revisi','Lanjut Bab') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `skripsi_bim_log`
--

INSERT INTO `skripsi_bim_log` (`id_row`, `action`, `u_create`, `time`, `id_bim`, `id_skripsi`, `subjek`, `deskripsi`, `tgl_bim`, `nim`, `pembimbing`, `file_bim`, `tgl_hasil`, `saran`, `file_hasilbim`, `status`, `status_dosbing`, `status_mhs`, `status_bim`) VALUES
(1, 'insert', 'Mohamad Irfan Manaf', '2021-01-10 07:14:18', 1, 1, 'Bimbingan 1', 'asda', '2021-01-10', '160511030', '0416086408', '160511030-10-Jan-2021-02-14-18-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Draft', 'Belum Dibaca', 'Belum Dibaca', NULL),
(2, 'update', 'Agust Isa Martinus, M.T', '2021-01-10 07:14:48', 1, 1, 'Bimbingan 1', 'asda', '2021-01-10', '160511030', '0416086408', '160511030-10-Jan-2021-02-14-18-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Draft', 'Belum Dibaca', 'Belum Dibaca', NULL),
(3, 'insert', 'Mohamad Irfan Manaf', '2021-01-10 07:20:02', 2, 1, 'ok', 'ok', '2021-01-10', '160511030', '0416086408', '160511030-10-Jan-2021-02-20-02-Contoh-File-Hasil_Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Pendadaran', 'Belum Dibaca', 'Belum Dibaca', NULL),
(4, 'update', 'Agust Isa Martinus, M.T', '2021-01-10 07:20:19', 2, 1, 'ok', 'ok', '2021-01-10', '160511030', '0416086408', '160511030-10-Jan-2021-02-20-02-Contoh-File-Hasil_Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Pendadaran', 'Belum Dibaca', 'Belum Dibaca', NULL),
(5, 'insert', 'Mohamad Irfan Manaf', '2021-01-10 07:23:23', 3, 1, 'Bimbingan 1', 'ok', '2021-01-10', '160511030', '0421117105', '160511030-10-Jan-2021-02-23-23-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', 'Belum Dibaca', NULL),
(6, 'update', 'Dian Novianti, M.Kom', '2021-01-10 07:23:38', 3, 1, 'Bimbingan 1', 'ok', '2021-01-10', '160511030', '0421117105', '160511030-10-Jan-2021-02-23-23-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', 'Belum Dibaca', NULL),
(7, 'update', 'Mohamad Irfan Manaf', '2021-01-10 07:25:37', 1, 1, 'Bimbingan 1', 'asda', '2021-01-10', '160511030', '0416086408', '160511030-10-Jan-2021-02-14-18-Contoh-File-Bimbingan.pdf', '2021-01-10', 'ok', '0416086408-10-Jan-2021-02-14-48-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Draft', 'Dibalas', 'Belum Dibaca', 'Layak'),
(8, 'update', 'Mohamad Irfan Manaf', '2021-01-10 07:25:42', 2, 1, 'ok', 'ok', '2021-01-10', '160511030', '0416086408', '160511030-10-Jan-2021-02-20-02-Contoh-File-Hasil_Bimbingan.pdf', NULL, 'ok', '0416086408-10-Jan-2021-02-20-19-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pendadaran', 'Dibalas', 'Belum Dibaca', 'Layak'),
(9, 'update', 'Mohamad Irfan Manaf', '2021-01-10 07:25:50', 3, 1, 'Bimbingan 1', 'ok', '2021-01-10', '160511030', '0421117105', '160511030-10-Jan-2021-02-23-23-Contoh-File-Bimbingan.pdf', NULL, 'ok', '0421117105-10-Jan-2021-02-23-38-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Belum Dibaca', 'Layak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `skripsi_dosbing`
--

CREATE TABLE `skripsi_dosbing` (
  `id_alias` int(11) NOT NULL,
  `nidn` varchar(25) NOT NULL,
  `id_skripsi` int(11) NOT NULL,
  `status_dosbing` enum('Pembimbing 1','Pembimbing 2') DEFAULT NULL,
  `status` enum('Aktif','Tidak Aktif') NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `skripsi_dosbing`
--

INSERT INTO `skripsi_dosbing` (`id_alias`, `nidn`, `id_skripsi`, `status_dosbing`, `status`, `time`) VALUES
(1, '0416086408', 1, 'Pembimbing 1', 'Aktif', '2021-01-10 07:14:00'),
(2, '0428117601', 1, 'Pembimbing 2', 'Aktif', '2021-01-10 07:14:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `skripsi_file`
--

CREATE TABLE `skripsi_file` (
  `id_file` int(11) NOT NULL,
  `id_skripsi` int(11) NOT NULL,
  `draft_doc` varchar(100) DEFAULT NULL,
  `draft_pdf` varchar(100) DEFAULT NULL,
  `jurnal_pdf` varchar(100) DEFAULT NULL,
  `jurnal_doc` varchar(100) DEFAULT NULL,
  `aplikasi` varchar(100) DEFAULT NULL,
  `kartu_bim` varchar(100) DEFAULT NULL,
  `lem_pengesahan` varchar(100) DEFAULT NULL,
  `cover` varchar(100) DEFAULT NULL,
  `poster` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `skripsi_file`
--

INSERT INTO `skripsi_file` (`id_file`, `id_skripsi`, `draft_doc`, `draft_pdf`, `jurnal_pdf`, `jurnal_doc`, `aplikasi`, `kartu_bim`, `lem_pengesahan`, `cover`, `poster`) VALUES
(1, 1, '160511030-10-Jan-2021-02-24-58-d baru 1.docx', '160511030-10-Jan-2021-02-24-58-Contoh-File-Bimbingan.pdf', '160511030-10-Jan-2021-02-24-58-contoh khs dan sertif kkm.pdf', '160511030-10-Jan-2021-02-24-58-MBA NOVI 1.docx', '160511030-10-Jan-2021-02-24-58-Import.rar', '160511030-10-Jan-2021-02-24-58-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511030-10-Jan-2021-02-24-58-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511030-10-Jan-2021-02-24-58-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511030-10-Jan-2021-02-24-58-kerangka berfikir.jpg');

--
-- Trigger `skripsi_file`
--
DELIMITER $$
CREATE TRIGGER `delete_file_skripsi` AFTER DELETE ON `skripsi_file` FOR EACH ROW BEGIN

INSERT into skripsi_file_log (action, u_create, id_file, id_skripsi,  draft_doc, draft_pdf, jurnal_pdf, jurnal_doc,aplikasi, kartu_bim, lem_pengesahan, cover, poster) VALUES (@action1, @user, old.id_file, old.id_skripsi, old.draft_doc, old.draft_pdf, old.jurnal_pdf, old.jurnal_doc, old.aplikasi, old.kartu_bim, old.lem_pengesahan, old.cover, old.poster);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_fileskripsi` AFTER INSERT ON `skripsi_file` FOR EACH ROW BEGIN

INSERT into skripsi_file_log (action, u_create, id_file, id_skripsi, draft_doc, draft_pdf, jurnal_pdf, jurnal_doc,aplikasi, kartu_bim, lem_pengesahan, cover, poster) VALUES (@action1, @user, new.id_file, new.id_skripsi, new.draft_doc, new.draft_pdf, new.jurnal_pdf, new.jurnal_doc, new.aplikasi, new.kartu_bim, new.lem_pengesahan, new.cover, new.poster);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_file_skripsi` AFTER UPDATE ON `skripsi_file` FOR EACH ROW BEGIN

INSERT into skripsi_file_log (action, u_create, id_file, id_skripsi,  draft_doc, draft_pdf, jurnal_pdf, jurnal_doc,aplikasi, kartu_bim, lem_pengesahan, cover, poster) VALUES (@action1, @user, old.id_file, old.id_skripsi, old.draft_doc, old.draft_pdf, old.jurnal_pdf, old.jurnal_doc, old.aplikasi, old.kartu_bim, old.lem_pengesahan, old.cover, old.poster);

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `skripsi_file_log`
--

CREATE TABLE `skripsi_file_log` (
  `id_row` int(11) NOT NULL,
  `action` varchar(56) NOT NULL,
  `u_create` varchar(56) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_file` int(11) NOT NULL,
  `id_skripsi` int(11) NOT NULL,
  `draft_doc` varchar(100) DEFAULT NULL,
  `draft_pdf` varchar(100) DEFAULT NULL,
  `jurnal_pdf` varchar(100) DEFAULT NULL,
  `jurnal_doc` varchar(100) DEFAULT NULL,
  `aplikasi` varchar(100) DEFAULT NULL,
  `kartu_bim` varchar(100) DEFAULT NULL,
  `lem_pengesahan` varchar(100) DEFAULT NULL,
  `cover` varchar(100) DEFAULT NULL,
  `poster` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `skripsi_file_log`
--

INSERT INTO `skripsi_file_log` (`id_row`, `action`, `u_create`, `time`, `id_file`, `id_skripsi`, `draft_doc`, `draft_pdf`, `jurnal_pdf`, `jurnal_doc`, `aplikasi`, `kartu_bim`, `lem_pengesahan`, `cover`, `poster`) VALUES
(1, 'insert', 'Mohamad Irfan Manaf', '2021-01-10 07:24:59', 1, 1, '160511030-10-Jan-2021-02-24-58-d baru 1.docx', '160511030-10-Jan-2021-02-24-58-Contoh-File-Bimbingan.pdf', '160511030-10-Jan-2021-02-24-58-contoh khs dan sertif kkm.pdf', '160511030-10-Jan-2021-02-24-58-MBA NOVI 1.docx', '160511030-10-Jan-2021-02-24-58-Import.rar', '160511030-10-Jan-2021-02-24-58-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511030-10-Jan-2021-02-24-58-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511030-10-Jan-2021-02-24-58-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511030-10-Jan-2021-02-24-58-kerangka berfikir.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `skripsi_log`
--

CREATE TABLE `skripsi_log` (
  `id_row` int(11) NOT NULL,
  `action` varchar(56) NOT NULL,
  `u_create` varchar(56) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_skripsi` int(11) NOT NULL,
  `id_proposal` int(11) NOT NULL,
  `lem_rev_draft` varchar(256) DEFAULT NULL,
  `lem_rev_pend` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `skripsi_log`
--

INSERT INTO `skripsi_log` (`id_row`, `action`, `u_create`, `time`, `id_skripsi`, `id_proposal`, `lem_rev_draft`, `lem_rev_pend`) VALUES
(1, 'insert', 'Agust Isa Martinus, M.T', '2021-01-10 07:10:35', 1, 1, NULL, NULL),
(2, 'update', 'Mohamad Irfan Manaf', '2021-01-10 07:19:51', 1, 1, NULL, NULL),
(3, 'update', 'Mohamad Irfan Manaf', '2021-01-10 07:23:13', 1, 1, '160511030-10-Jan-2021-02-19-51-c7f8b5ca27404a7094dd253e746ffccd.pdf', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `skripsi_syarat`
--

CREATE TABLE `skripsi_syarat` (
  `id_syarat` int(11) NOT NULL,
  `tanggal` date NOT NULL DEFAULT current_timestamp(),
  `file` varchar(256) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `pesan` varchar(100) DEFAULT NULL,
  `nim` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `skripsi_syarat`
--

INSERT INTO `skripsi_syarat` (`id_syarat`, `tanggal`, `file`, `status`, `pesan`, `nim`) VALUES
(1, '2021-01-10', '160511030-10-Jan-2021-02-08-38-c7f8b5ca27404a7094dd253e746ffccd.pdf', 2, 'ok', '160511030');

--
-- Trigger `skripsi_syarat`
--
DELIMITER $$
CREATE TRIGGER `delete_skripsi_syarat` AFTER DELETE ON `skripsi_syarat` FOR EACH ROW BEGIN

INSERT INTO `skripsi_syarat_log` (action, u_create, `id_syarat`, `tanggal`, `file`, `status`, `pesan`, `nim`) VALUES
(@action, @user, old.id_syarat, old.tanggal, old.file, old.status, old.pesan, old.nim);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_skripsisyarat` AFTER INSERT ON `skripsi_syarat` FOR EACH ROW BEGIN

INSERT INTO `skripsi_syarat_log` (action, u_create, `id_syarat`, `tanggal`, `file`, `status`, `pesan`, `nim`) VALUES
(@action1, @user, new.id_syarat, new.tanggal, new.file, new.status, new.pesan, new.nim);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_skripsisyarat` AFTER UPDATE ON `skripsi_syarat` FOR EACH ROW BEGIN

INSERT INTO `skripsi_syarat_log` (action, u_create, `id_syarat`, `tanggal`, `file`, `status`, `pesan`, `nim`) VALUES
(@action, @user, old.id_syarat, old.tanggal, old.file, old.status, old.pesan, old.nim);

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `skripsi_syarat_log`
--

CREATE TABLE `skripsi_syarat_log` (
  `id_row` int(11) NOT NULL,
  `action` varchar(56) NOT NULL,
  `u_create` varchar(56) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_syarat` int(11) NOT NULL,
  `tanggal` date NOT NULL DEFAULT current_timestamp(),
  `file` varchar(256) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `pesan` varchar(100) DEFAULT NULL,
  `nim` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `skripsi_syarat_log`
--

INSERT INTO `skripsi_syarat_log` (`id_row`, `action`, `u_create`, `time`, `id_syarat`, `tanggal`, `file`, `status`, `pesan`, `nim`) VALUES
(1, 'insert', 'Mohamad Irfan Manaf', '2021-01-10 07:08:38', 1, '2021-01-10', '160511030-10-Jan-2021-02-08-38-c7f8b5ca27404a7094dd253e746ffccd.pdf', 0, NULL, '160511030'),
(2, 'update', 'Tatang', '2021-01-10 07:08:48', 1, '2021-01-10', '160511030-10-Jan-2021-02-08-38-c7f8b5ca27404a7094dd253e746ffccd.pdf', 0, NULL, '160511030');

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat`
--

CREATE TABLE `surat` (
  `id_surat` int(11) NOT NULL,
  `jenis` varchar(40) NOT NULL,
  `tanggal` date NOT NULL DEFAULT current_timestamp(),
  `nomor` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tata_usaha`
--

CREATE TABLE `tata_usaha` (
  `nidn` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `foto` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tata_usaha`
--

INSERT INTO `tata_usaha` (`nidn`, `password`, `nama`, `foto`) VALUES
('tatausaha', 'YWRtaW4=', 'Tatang', 'profil.png');

--
-- Trigger `tata_usaha`
--
DELIMITER $$
CREATE TRIGGER `insert_tu` AFTER INSERT ON `tata_usaha` FOR EACH ROW BEGIN

INSERT INTO `tata_usaha_log` (action, u_create, `nidn`, `password`, `nama`, `foto`) VALUES
(@action1, @user, new.nidn, new.password, new.nama, new.foto);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_tu` AFTER UPDATE ON `tata_usaha` FOR EACH ROW BEGIN

INSERT INTO tata_usaha_log (action, u_create, nidn, password, nama, foto) VALUES
(@action, @user, old.nidn, old.password, old.nama, old.foto);

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tata_usaha_log`
--

CREATE TABLE `tata_usaha_log` (
  `id_row` int(11) NOT NULL,
  `action` varchar(56) NOT NULL,
  `u_create` varchar(56) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `nidn` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `foto` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`nidn`);

--
-- Indeks untuk tabel `dosen_log`
--
ALTER TABLE `dosen_log`
  ADD PRIMARY KEY (`id_row`);

--
-- Indeks untuk tabel `dosen_wali`
--
ALTER TABLE `dosen_wali`
  ADD PRIMARY KEY (`id_dosenwali`);

--
-- Indeks untuk tabel `dosen_wali_log`
--
ALTER TABLE `dosen_wali_log`
  ADD PRIMARY KEY (`id_row`);

--
-- Indeks untuk tabel `draft_nilai`
--
ALTER TABLE `draft_nilai`
  ADD PRIMARY KEY (`id_nilai`);

--
-- Indeks untuk tabel `draft_nilai_log`
--
ALTER TABLE `draft_nilai_log`
  ADD PRIMARY KEY (`id_row`);

--
-- Indeks untuk tabel `draft_penguji`
--
ALTER TABLE `draft_penguji`
  ADD PRIMARY KEY (`id_penguji`);

--
-- Indeks untuk tabel `draft_sidang`
--
ALTER TABLE `draft_sidang`
  ADD PRIMARY KEY (`id_sidang`);

--
-- Indeks untuk tabel `draft_sidang_log`
--
ALTER TABLE `draft_sidang_log`
  ADD PRIMARY KEY (`id_row`);

--
-- Indeks untuk tabel `draft_sidang_syarat`
--
ALTER TABLE `draft_sidang_syarat`
  ADD PRIMARY KEY (`id_syarat`);

--
-- Indeks untuk tabel `judul`
--
ALTER TABLE `judul`
  ADD PRIMARY KEY (`id_judul`);

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nim`);

--
-- Indeks untuk tabel `mahasiswa_log`
--
ALTER TABLE `mahasiswa_log`
  ADD PRIMARY KEY (`id_row`);

--
-- Indeks untuk tabel `pend_nilai`
--
ALTER TABLE `pend_nilai`
  ADD PRIMARY KEY (`id_nilai`);

--
-- Indeks untuk tabel `pend_penguji`
--
ALTER TABLE `pend_penguji`
  ADD PRIMARY KEY (`id_penguji`);

--
-- Indeks untuk tabel `pend_sidang`
--
ALTER TABLE `pend_sidang`
  ADD PRIMARY KEY (`id_sidang`);

--
-- Indeks untuk tabel `pend_sidang_log`
--
ALTER TABLE `pend_sidang_log`
  ADD PRIMARY KEY (`id_row`);

--
-- Indeks untuk tabel `pend_sidang_syarat`
--
ALTER TABLE `pend_sidang_syarat`
  ADD PRIMARY KEY (`id_syarat`);

--
-- Indeks untuk tabel `pkl`
--
ALTER TABLE `pkl`
  ADD PRIMARY KEY (`id_pkl`),
  ADD UNIQUE KEY `nim` (`nim`);

--
-- Indeks untuk tabel `pkl_bim`
--
ALTER TABLE `pkl_bim`
  ADD PRIMARY KEY (`id_bimPKL`);

--
-- Indeks untuk tabel `pkl_bim_log`
--
ALTER TABLE `pkl_bim_log`
  ADD PRIMARY KEY (`id_row`);

--
-- Indeks untuk tabel `pkl_file`
--
ALTER TABLE `pkl_file`
  ADD PRIMARY KEY (`id_filePKL`);

--
-- Indeks untuk tabel `pkl_file_log`
--
ALTER TABLE `pkl_file_log`
  ADD PRIMARY KEY (`id_row`);

--
-- Indeks untuk tabel `pkl_log`
--
ALTER TABLE `pkl_log`
  ADD PRIMARY KEY (`id_row`);

--
-- Indeks untuk tabel `pkl_nilai`
--
ALTER TABLE `pkl_nilai`
  ADD PRIMARY KEY (`id_nilai`);

--
-- Indeks untuk tabel `pkl_nilai_log`
--
ALTER TABLE `pkl_nilai_log`
  ADD PRIMARY KEY (`id_row`);

--
-- Indeks untuk tabel `pkl_sidang`
--
ALTER TABLE `pkl_sidang`
  ADD PRIMARY KEY (`id_sidpkl`);

--
-- Indeks untuk tabel `pkl_sidang_log`
--
ALTER TABLE `pkl_sidang_log`
  ADD PRIMARY KEY (`id_row`);

--
-- Indeks untuk tabel `pkl_syarat`
--
ALTER TABLE `pkl_syarat`
  ADD PRIMARY KEY (`id_syarat`);

--
-- Indeks untuk tabel `pkl_syarat_log`
--
ALTER TABLE `pkl_syarat_log`
  ADD PRIMARY KEY (`id_row`);

--
-- Indeks untuk tabel `pkl_syarat_sidang`
--
ALTER TABLE `pkl_syarat_sidang`
  ADD PRIMARY KEY (`id_syarat`);

--
-- Indeks untuk tabel `proposal`
--
ALTER TABLE `proposal`
  ADD PRIMARY KEY (`id_proposal`);

--
-- Indeks untuk tabel `proposal_bim`
--
ALTER TABLE `proposal_bim`
  ADD PRIMARY KEY (`id_bim`);

--
-- Indeks untuk tabel `proposal_bim_log`
--
ALTER TABLE `proposal_bim_log`
  ADD PRIMARY KEY (`id_row`);

--
-- Indeks untuk tabel `proposal_file`
--
ALTER TABLE `proposal_file`
  ADD PRIMARY KEY (`id_file`);

--
-- Indeks untuk tabel `proposal_file_log`
--
ALTER TABLE `proposal_file_log`
  ADD PRIMARY KEY (`id_row`);

--
-- Indeks untuk tabel `proposal_log`
--
ALTER TABLE `proposal_log`
  ADD PRIMARY KEY (`id_row`);

--
-- Indeks untuk tabel `proposal_penguji`
--
ALTER TABLE `proposal_penguji`
  ADD PRIMARY KEY (`id_penguji`);

--
-- Indeks untuk tabel `proposal_sidang`
--
ALTER TABLE `proposal_sidang`
  ADD PRIMARY KEY (`id_sidang`);

--
-- Indeks untuk tabel `proposal_sidang_log`
--
ALTER TABLE `proposal_sidang_log`
  ADD PRIMARY KEY (`id_row`);

--
-- Indeks untuk tabel `proposal_sidang_syarat`
--
ALTER TABLE `proposal_sidang_syarat`
  ADD PRIMARY KEY (`id_syarat`);

--
-- Indeks untuk tabel `skripsi`
--
ALTER TABLE `skripsi`
  ADD PRIMARY KEY (`id_skripsi`);

--
-- Indeks untuk tabel `skripsi_bim`
--
ALTER TABLE `skripsi_bim`
  ADD PRIMARY KEY (`id_bim`);

--
-- Indeks untuk tabel `skripsi_bim_log`
--
ALTER TABLE `skripsi_bim_log`
  ADD PRIMARY KEY (`id_row`);

--
-- Indeks untuk tabel `skripsi_dosbing`
--
ALTER TABLE `skripsi_dosbing`
  ADD PRIMARY KEY (`id_alias`);

--
-- Indeks untuk tabel `skripsi_file`
--
ALTER TABLE `skripsi_file`
  ADD PRIMARY KEY (`id_file`);

--
-- Indeks untuk tabel `skripsi_file_log`
--
ALTER TABLE `skripsi_file_log`
  ADD PRIMARY KEY (`id_row`);

--
-- Indeks untuk tabel `skripsi_log`
--
ALTER TABLE `skripsi_log`
  ADD PRIMARY KEY (`id_row`);

--
-- Indeks untuk tabel `skripsi_syarat`
--
ALTER TABLE `skripsi_syarat`
  ADD PRIMARY KEY (`id_syarat`);

--
-- Indeks untuk tabel `skripsi_syarat_log`
--
ALTER TABLE `skripsi_syarat_log`
  ADD PRIMARY KEY (`id_row`);

--
-- Indeks untuk tabel `surat`
--
ALTER TABLE `surat`
  ADD PRIMARY KEY (`id_surat`);

--
-- Indeks untuk tabel `tata_usaha`
--
ALTER TABLE `tata_usaha`
  ADD PRIMARY KEY (`nidn`);

--
-- Indeks untuk tabel `tata_usaha_log`
--
ALTER TABLE `tata_usaha_log`
  ADD PRIMARY KEY (`id_row`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `dosen_log`
--
ALTER TABLE `dosen_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `dosen_wali_log`
--
ALTER TABLE `dosen_wali_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `draft_nilai`
--
ALTER TABLE `draft_nilai`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `draft_nilai_log`
--
ALTER TABLE `draft_nilai_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `draft_penguji`
--
ALTER TABLE `draft_penguji`
  MODIFY `id_penguji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `draft_sidang`
--
ALTER TABLE `draft_sidang`
  MODIFY `id_sidang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `draft_sidang_log`
--
ALTER TABLE `draft_sidang_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `draft_sidang_syarat`
--
ALTER TABLE `draft_sidang_syarat`
  MODIFY `id_syarat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `judul`
--
ALTER TABLE `judul`
  MODIFY `id_judul` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `mahasiswa_log`
--
ALTER TABLE `mahasiswa_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pend_nilai`
--
ALTER TABLE `pend_nilai`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pend_penguji`
--
ALTER TABLE `pend_penguji`
  MODIFY `id_penguji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pend_sidang`
--
ALTER TABLE `pend_sidang`
  MODIFY `id_sidang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pend_sidang_log`
--
ALTER TABLE `pend_sidang_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pend_sidang_syarat`
--
ALTER TABLE `pend_sidang_syarat`
  MODIFY `id_syarat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pkl`
--
ALTER TABLE `pkl`
  MODIFY `id_pkl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pkl_bim`
--
ALTER TABLE `pkl_bim`
  MODIFY `id_bimPKL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pkl_bim_log`
--
ALTER TABLE `pkl_bim_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `pkl_file`
--
ALTER TABLE `pkl_file`
  MODIFY `id_filePKL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pkl_file_log`
--
ALTER TABLE `pkl_file_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pkl_log`
--
ALTER TABLE `pkl_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pkl_nilai`
--
ALTER TABLE `pkl_nilai`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pkl_nilai_log`
--
ALTER TABLE `pkl_nilai_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pkl_sidang`
--
ALTER TABLE `pkl_sidang`
  MODIFY `id_sidpkl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pkl_sidang_log`
--
ALTER TABLE `pkl_sidang_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pkl_syarat`
--
ALTER TABLE `pkl_syarat`
  MODIFY `id_syarat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pkl_syarat_log`
--
ALTER TABLE `pkl_syarat_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pkl_syarat_sidang`
--
ALTER TABLE `pkl_syarat_sidang`
  MODIFY `id_syarat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `proposal`
--
ALTER TABLE `proposal`
  MODIFY `id_proposal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `proposal_bim`
--
ALTER TABLE `proposal_bim`
  MODIFY `id_bim` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `proposal_bim_log`
--
ALTER TABLE `proposal_bim_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `proposal_file`
--
ALTER TABLE `proposal_file`
  MODIFY `id_file` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `proposal_file_log`
--
ALTER TABLE `proposal_file_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `proposal_log`
--
ALTER TABLE `proposal_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `proposal_penguji`
--
ALTER TABLE `proposal_penguji`
  MODIFY `id_penguji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `proposal_sidang`
--
ALTER TABLE `proposal_sidang`
  MODIFY `id_sidang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `proposal_sidang_log`
--
ALTER TABLE `proposal_sidang_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `proposal_sidang_syarat`
--
ALTER TABLE `proposal_sidang_syarat`
  MODIFY `id_syarat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `skripsi`
--
ALTER TABLE `skripsi`
  MODIFY `id_skripsi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `skripsi_bim`
--
ALTER TABLE `skripsi_bim`
  MODIFY `id_bim` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `skripsi_bim_log`
--
ALTER TABLE `skripsi_bim_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `skripsi_dosbing`
--
ALTER TABLE `skripsi_dosbing`
  MODIFY `id_alias` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `skripsi_file`
--
ALTER TABLE `skripsi_file`
  MODIFY `id_file` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `skripsi_file_log`
--
ALTER TABLE `skripsi_file_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `skripsi_log`
--
ALTER TABLE `skripsi_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `skripsi_syarat`
--
ALTER TABLE `skripsi_syarat`
  MODIFY `id_syarat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `skripsi_syarat_log`
--
ALTER TABLE `skripsi_syarat_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `surat`
--
ALTER TABLE `surat`
  MODIFY `id_surat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tata_usaha_log`
--
ALTER TABLE `tata_usaha_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
