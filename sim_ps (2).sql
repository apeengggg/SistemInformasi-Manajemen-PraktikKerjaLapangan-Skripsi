-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Feb 2021 pada 15.41
-- Versi server: 10.4.17-MariaDB
-- Versi PHP: 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sim_ps`
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

--
-- Dumping data untuk tabel `dosen_log`
--

INSERT INTO `dosen_log` (`id_row`, `action`, `u_create`, `time`, `nidn`, `nama`, `password`, `nama_dosen`, `foto_dosen`, `jabatan`, `tipe_akun`, `status`) VALUES
(1, 'update', 'Tatang', '2020-11-01 15:01:58', '0017057402', 'Supriyono,M.Cs', 'MTIzMzQz', 'Supriyono,M.Cs', 'profil.png', '', 'Dosen', 'Aktif'),
(2, 'update', 'Tatang', '2020-11-01 15:02:05', '0017057402', 'Supriyono,M.Css', 'MTIzMzQz', 'Supriyono,M.Css', 'profil.png', '', 'Dosen', 'Aktif'),
(3, 'update', 'Tatang', '2020-11-01 15:02:11', '0017057402', 'Supriyono,M.Cs', 'MTIzMzQz', 'Supriyono,M.Cs', 'profil.png', '', 'Dosen', 'Aktif'),
(4, 'update', 'Tatang', '2020-11-21 08:29:41', '0017057402', 'Supriyono,M.Cs', 'MTIzMzQz', 'Supriyono,M.Cs', 'profil.png', 'Lekor', 'Dosen', 'Aktif'),
(5, 'update', 'Tatang', '2020-11-21 08:29:46', '0402057307', 'Freddy Wicaksono, M.Kom', 'MDQwMjA1NzMwNw==', 'Freddy Wicaksono, M.Kom', 'profil.png', 'Asisten Ahli', 'Dosen', 'Aktif'),
(6, 'update', 'Tatang', '2020-11-21 08:29:50', '0403079201', 'Lia Farhatuaini,M.Cs', 'MDQwMzA3OTIwMQ==', 'Lia Farhatuaini,M.Cs', 'profil.png', NULL, 'Dosen', 'Aktif'),
(7, 'update', 'Tatang', '2020-11-21 08:29:54', '0405108905', 'Sokid', 'MDQwNTEwODkwNQ==', 'Sokid', 'profil.png', '', 'Dosen', 'Aktif'),
(8, 'update', 'Tatang', '2020-11-21 08:29:59', '0406067407', 'Maksudi,M.T', 'MDQwNjA2NzQwNw==', 'Maksudi,M.T', 'profil.png', 'Asisten Ahli', 'PenasihatAkademik', 'Aktif'),
(9, 'update', 'Tatang', '2020-11-21 08:30:05', '0407039501', 'Vega Purwayoga,S.Kom,M.Kom', 'MDQwNzAzOTUwMQ==', 'Vega Purwayoga,S.Kom,M.Kom', 'profil.png', NULL, 'Dosen', 'Aktif'),
(10, 'update', 'Tatang', '2020-11-21 08:30:09', '0408118304', 'Harry Gunawan,M.Kom', 'MDQwODExODMwNA==', 'Harry Gunawan,M.Kom', 'profil.png', 'Asisten Ahli', 'Dosen', 'Aktif'),
(11, 'update', 'Tatang', '2020-11-21 08:30:15', '0409046101', 'Suhana Minah Jaya, M.T', 'MDQwOTA0NjEwMQ==', 'Suhana Minah Jaya, M.T', 'profil.png', 'Lektor', 'Dosen', 'Aktif'),
(12, 'update', 'Tatang', '2020-11-21 08:30:20', '0412068907', 'MUHAMAD IMAM', 'MDQxMjA2ODkwNw==', 'MUHAMAD IMAM', 'profil.png', NULL, 'Dosen', 'Aktif'),
(13, 'update', 'Tatang', '2020-11-21 08:30:24', '0413118803', 'PAHLA WIDHIANI', 'MDQxMzExODgwMw==', 'PAHLA WIDHIANI', 'profil.png', NULL, 'Dosen', 'Aktif'),
(14, 'update', 'Tatang', '2020-11-21 08:30:31', '0416018007', 'LUKMAN NURHAKIM', 'MDQxNjAxODAwNw==', 'LUKMAN NURHAKIM', 'profil.png', NULL, 'Dosen', 'Aktif'),
(15, 'update', 'Tatang', '2020-11-21 08:30:36', '0416086408', 'Agust Isa Martinus, M.T', 'MDQxNjA4NjQwOA==', 'Agust Isa Martinus, M.T', 'profil.png', 'Asisten Ahli', 'PenasihatAkademik', 'Aktif'),
(16, 'update', 'Tatang', '2020-11-21 08:30:41', '0421117105', 'Dian Novianti, M.Kom', 'MDQyMTExNzEwNQ==', 'Dian Novianti, M.Kom', 'profil.png', 'Lektor', 'Kaprodi', 'Aktif'),
(17, 'update', 'Tatang', '2020-11-21 08:30:47', '0424038902', 'DENI', 'MDQyNDAzODkwMg==', 'DENI', 'profil.png', NULL, 'Dosen', 'Aktif'),
(18, 'update', 'Tatang', '2020-11-21 08:30:52', '0425036001', 'ISKANDAR', 'MDQyNTAzNjAwMQ==', 'ISKANDAR', 'profil.png', 'Lektor', 'Dosen', 'Aktif'),
(19, 'update', 'Tatang', '2020-11-21 08:31:04', '0428117601', 'Dr. Wahyu Triono, M.MPd', 'MDQyODExNzYwMQ==', 'Dr. Wahyu Triono, M.MPd', 'profil.png', 'Lekor', 'Dosen', 'Aktif'),
(20, 'update', 'Tatang', '2020-11-21 08:31:09', '9904005002', 'ARIEF RAHMAN', 'OTkwNDAwNTAwMg==', 'ARIEF RAHMAN', 'profil.png', NULL, 'Dosen', 'Aktif'),
(21, 'update', 'Tatang', '2020-11-21 08:31:14', '9904006197', 'HANDI EKO PRASETYO', 'OTkwNDAwNjE5Nw==', 'HANDI EKO PRASETYO', 'profil.png', NULL, 'Dosen', 'Aktif'),
(22, 'update', 'Tatang', '2020-11-21 08:37:34', '0402057307', 'Freddy Wicaksono, M.Kom', 'MDQwMjA1NzMwNw==', 'Freddy Wicaksono, M.Kom', 'profil.png', 'Asisten Ahli', 'Dosen', 'Aktif'),
(23, 'update', 'Tatang', '2020-11-21 08:37:47', '0402057307', 'Freddy Wicaksono, M.Kom', 'MDQwMjA1NzMwNw==', 'Freddy Wicaksono, M.Kom', 'profil.png', 'Asisten Ahli', 'Dosen', 'Tidak Aktif'),
(24, 'update', 'Tatang', '2020-11-21 08:38:22', '0402057307', 'Freddy Wicaksono, M.Kom', 'MDQwMjA1NzMwNw==', 'Freddy Wicaksono, M.Kom', 'profil.png', 'Asisten Ahli', 'Dosen', 'Aktif'),
(25, 'update', 'Tatang', '2020-11-21 08:38:33', '0402057307', 'Freddy Wicaksono, M.Kom', 'MDQwMjA1NzMwNw==', 'Freddy Wicaksono, M.Kom', 'profil.png', 'Asisten Ahli', 'Dosen', 'Tidak Aktif'),
(26, NULL, NULL, '2020-11-22 20:09:45', '0403079201', 'Lia Farhatuaini,M.Cs', 'MDQwMzA3OTIwMQ==', 'Lia Farhatuaini,M.Cs', 'profil.png', '', 'Dosen', 'Aktif'),
(27, NULL, NULL, '2020-11-22 20:09:47', '0405108905', 'Sokid', 'MDQwNTEwODkwNQ==', 'Sokid', 'profil.png', '', 'Dosen', 'Aktif'),
(28, NULL, NULL, '2020-11-22 20:09:50', '0407039501', 'Vega Purwayoga,S.Kom,M.Kom', 'MDQwNzAzOTUwMQ==', 'Vega Purwayoga,S.Kom,M.Kom', 'profil.png', '', 'Dosen', 'Aktif'),
(29, NULL, NULL, '2020-11-22 20:09:54', '0412068907', 'MUHAMAD IMAM', 'MDQxMjA2ODkwNw==', 'MUHAMAD IMAM', 'profil.png', '', 'Dosen', 'Aktif'),
(30, NULL, NULL, '2020-11-22 20:09:57', '0413118803', 'PAHLA WIDHIANI', 'MDQxMzExODgwMw==', 'PAHLA WIDHIANI', 'profil.png', '', 'Dosen', 'Aktif'),
(31, NULL, NULL, '2020-11-22 20:09:59', '0416018007', 'LUKMAN NURHAKIM', 'MDQxNjAxODAwNw==', 'LUKMAN NURHAKIM', 'profil.png', '', 'Dosen', 'Aktif'),
(32, NULL, NULL, '2020-11-22 20:10:01', '0424038902', 'DENI', 'MDQyNDAzODkwMg==', 'DENI', 'profil.png', '', 'Dosen', 'Aktif'),
(33, NULL, NULL, '2020-11-22 20:10:04', '9904005002', 'ARIEF RAHMAN', 'OTkwNDAwNTAwMg==', 'ARIEF RAHMAN', 'profil.png', '', 'Dosen', 'Aktif'),
(34, NULL, NULL, '2020-11-22 20:10:06', '9904006197', 'HANDI EKO PRASETYO', 'OTkwNDAwNjE5Nw==', 'HANDI EKO PRASETYO', 'profil.png', '', 'Dosen', 'Aktif'),
(35, 'update', 'Agust Isa Martinus, M.T', '2020-12-15 20:03:06', '0416086408', 'Agust Isa Martinus, M.T', 'MDQxNjA4NjQwOA==', 'Agust Isa Martinus, M.T', 'profil.png', 'Asisten Ahli', 'PenasihatAkademik', 'Aktif'),
(36, 'update', 'Agust Isa Martinus, M.T', '2020-12-15 20:03:12', '0416086408', 'Agust Isa Martinus, M.T', 'MDQxNjA4NjQwOA==', 'Agust Isa Martinus, M.T1', 'profil.png', 'Asisten Ahli', 'PenasihatAkademik', 'Aktif'),
(37, 'update', 'Agust Isa Martinus, M.T', '2020-12-15 20:03:21', '0416086408', 'Agust Isa Martinus, M.T', 'MDQxNjA4NjQwOA==', 'Agust Isa Martinus, M.T', 'profil.png', 'Asisten Ahli', 'PenasihatAkademik', 'Aktif'),
(38, 'update', 'Agust Isa Martinus, M.T', '2020-12-15 20:03:29', '0416086408', 'Agust Isa Martinus, M.T', 'MTIz', 'Agust Isa Martinus, M.T', 'profil.png', 'Asisten Ahli', 'PenasihatAkademik', 'Aktif'),
(39, 'insert', 'Tatang', '2020-12-15 20:50:07', '1234567', 'ok', 'MTIzNDU2Nw==', 'ok', 'profil.png', 'asd', 'Dosen', 'Aktif'),
(40, 'update', 'Tatang', '2020-12-15 20:50:13', '1234567', 'ok', 'MTIzNDU2Nw==', 'ok', 'profil.png', 'asd', 'Dosen', 'Tidak Aktif'),
(41, 'insert', 'Tatang', '2020-12-15 20:50:29', '123', '123', 'MTIz', '123', 'profil.png', '123', '', 'Aktif'),
(42, 'insert', 'Tatang', '2020-12-15 20:50:29', '321', '321', 'MzIx', '321', 'profil.png', '321', '', 'Aktif'),
(43, 'update', 'Tatang', '2020-12-15 20:52:24', '1234567', 'ok123', 'MTIzNDU2Nw==', 'ok123', 'profil.png', 'asd', 'Dosen', 'Tidak Aktif'),
(44, 'delete', 'Tatang', '2020-12-15 20:54:04', '1234567', 'ok123', 'MTIzNDU2Nw==', 'ok123', 'profil.png', 'asd', 'Dosen', 'Aktif'),
(45, 'delete', 'Tatang', '2020-12-15 20:54:08', '321', '321', 'MzIx', '321', 'profil.png', '321', '', 'Aktif'),
(46, 'delete', 'Tatang', '2020-12-15 20:54:12', '123', '123', 'MTIz', '123', 'profil.png', '123', '', 'Aktif'),
(47, 'update', 'Harry Gunawan,M.Kom', '2020-12-20 15:37:05', '0408118304', 'Harry Gunawan,M.Kom', 'MDQwODExODMwNA==', 'Harry Gunawan,M.Kom', 'profil.png', 'Asisten Ahli', 'Dosen', 'Aktif'),
(48, 'update', 'Harry Gunawan,M.Kom', '2020-12-20 15:37:10', '0408118304', 'Harry Gunawan,M.Kom', 'MDQwODExODMwNA==', 'Harry Gunawan,M.Kom 123', 'profil.png', 'Asisten Ahli', 'Dosen', 'Aktif'),
(49, 'update', 'Harry Gunawan,M.Kom', '2020-12-20 15:37:22', '0408118304', 'Harry Gunawan,M.Kom', 'MDQwODExODMwNA==', 'Harry Gunawan,M.Kom', 'profil.png', 'Asisten Ahli', 'Dosen', 'Aktif'),
(50, 'update', 'Harry Gunawan,M.Kom', '2020-12-20 15:37:34', '0408118304', 'Harry Gunawan,M.Kom', 'MTIz', 'Harry Gunawan,M.Kom', 'profil.png', 'Asisten Ahli', 'Dosen', 'Aktif'),
(51, 'update', 'Agust Isa Martinus, M.T', '2020-12-20 16:02:25', '0416086408', 'Agust Isa Martinus, M.T', 'MDQxNjA4NjQwOA==', 'Agust Isa Martinus, M.T', 'profil.png', 'Asisten Ahli', 'PenasihatAkademik', 'Aktif'),
(52, 'update', 'Agust Isa Martinus, M.T', '2020-12-20 16:02:33', '0416086408', 'Agust Isa Martinus, M.T', 'MDQxNjA4NjQwOA==', 'Agust Isa Martinus, M.T 123', 'profil.png', 'Asisten Ahli', 'PenasihatAkademik', 'Aktif'),
(53, 'update', 'Agust Isa Martinus, M.T', '2020-12-20 16:02:43', '0416086408', 'Agust Isa Martinus, M.T', 'MDQxNjA4NjQwOA==', 'Agust Isa Martinus, M.T', 'profil.png', 'Asisten Ahli', 'PenasihatAkademik', 'Aktif'),
(54, 'update', 'Agust Isa Martinus, M.T', '2020-12-20 16:02:52', '0416086408', 'Agust Isa Martinus, M.T', 'MTIz', 'Agust Isa Martinus, M.T', 'profil.png', 'Asisten Ahli', 'PenasihatAkademik', 'Aktif'),
(55, 'insert', 'Tatang', '2020-12-27 16:19:49', '1234323453', 'asdasd', 'MTIzNDMyMzQ1Mw==', 'asdasd', 'profil.png', 'Lekor', 'Dosen', 'Aktif'),
(56, 'delete', 'Tatang', '2020-12-27 16:19:59', '1234323453', 'asdasd', 'MTIzNDMyMzQ1Mw==', 'asdasd', 'profil.png', 'Lekor', 'Dosen', 'Aktif');

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

--
-- Dumping data untuk tabel `dosen_wali_log`
--

INSERT INTO `dosen_wali_log` (`id_row`, `action`, `u_create`, `time`, `id_dosenwali`, `nidn`) VALUES
(1, 'update', 'Tatang', '2020-11-01 15:06:04', '0', '0412068907'),
(2, 'update', 'Tatang', '2020-12-15 20:54:28', '0', '0421117105'),
(3, 'update', 'Tatang', '2020-12-15 20:54:34', '0', '0424038902');

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
(4, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 12, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80),
(7, 13, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80),
(8, 14, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80),
(11, 22, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80);

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
(1, 0, 'Dian Novianti, M.Kom', '2020-11-01 19:19:07', 5, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 0, 'Harry Gunawan,M.Kom', '2020-11-01 19:19:34', 5, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 0, 'Dian Novianti, M.Kom', '2020-11-01 19:22:29', 5, 11, NULL, NULL, NULL, NULL, 90, 90, 90, 90, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 0, 'Agust Isa Martinus, M.T', '2020-11-01 19:22:57', 5, 11, 90, 80, 97, 95, 90, 90, 90, 90, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 0, 'Tatang', '2020-11-01 19:27:05', 5, 11, 90, 80, 97, 95, 90, 90, 90, 90, 90, 90, 87, 77, NULL, NULL, NULL, NULL),
(6, 0, 'Agust Isa Martinus, M.T', '2020-11-01 21:29:15', 6, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 0, 'Agust Isa Martinus, M.T', '2020-11-01 21:41:47', 7, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 0, 'Agust Isa Martinus, M.T', '2020-11-01 21:42:07', 8, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 0, 'Dian Novianti, M.Kom', '2020-11-22 20:11:46', 9, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 0, 'Tatang', '2020-11-22 20:14:33', 9, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 0, 'Tatang', '2020-12-15 21:05:16', 7, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 0, 'Tatang', '2020-12-15 21:05:28', 6, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 0, 'Tatang', '2020-12-15 21:05:40', 8, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 0, 'Tatang', '2020-12-15 21:09:41', 9, 15, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80),
(15, 0, 'Dian Novianti, M.Kom', '2020-12-20 18:28:30', 10, 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 0, 'Tatang', '2020-12-20 19:01:08', 10, 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 0, 'Dian Novianti, M.Kom', '2020-12-20 20:27:47', 11, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 0, 'Tatang', '2020-12-20 20:28:53', 11, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 0, 'Tatang', '2020-12-28 17:09:36', 11, 22, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80),
(20, 0, 'Tatang', '2020-12-28 17:09:52', 11, 22, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(21, 0, 'Tatang', '2020-12-28 17:10:08', 11, 22, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(22, 0, 'Tatang', '2020-12-28 17:10:24', 11, 22, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(23, 0, 'Tatang', '2020-12-28 17:10:36', 11, 22, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

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
(33, 9, '0421117105', 'Penguji 1', 'Aktif', '2020-11-01 15:33:13'),
(34, 9, '0406067407', 'Penguji 2', 'Aktif', '2020-11-01 15:33:13'),
(39, 12, '0421117105', 'Penguji 1', 'Aktif', '2020-11-01 21:29:15'),
(40, 12, '0408118304', 'Penguji 2', 'Aktif', '2020-11-01 21:29:15'),
(41, 13, '0416086408', 'Penguji 1', 'Aktif', '2020-11-01 21:41:47'),
(42, 13, '0402057307', 'Penguji 2', 'Aktif', '2020-11-01 21:41:47'),
(43, 14, '0421117105', 'Penguji 1', 'Aktif', '2020-11-01 21:42:07'),
(44, 14, '0405108905', 'Penguji 2', 'Aktif', '2020-11-01 21:42:07'),
(53, 22, '0408118304', 'Penguji 1', 'Aktif', '2020-12-20 20:27:47'),
(54, 22, '0428117601', 'Penguji 2', 'Aktif', '2020-12-20 20:27:47');

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
(12, 1, 2, 'ok', 2, 'Setuju\r\n', '2020-11-02', '09:00', 'Lab Peternakan', 'Lulus'),
(13, 19, 2, 'setuju', 2, 'setuju', '2020-11-02', '11:00', 'Lab Peternakan', 'Lulus'),
(14, 3, 2, 'setuju', 2, 'setuju', '2020-11-02', '13:00', 'Lab Peternakan', 'Lulus'),
(22, 50, 2, 'asdsa', 2, 'asdas', '2020-12-21', '11:00', 'Lab Informatika', 'Lulus');

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
(1, 'insert', 'Mahasiswa 1', '2020-11-01 19:14:40', 11, 44, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(2, 'update', 'Dian Novianti, M.Kom', '2020-11-01 19:14:53', 11, 44, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(3, 'update', 'Harry Gunawan,M.Kom', '2020-11-01 19:15:21', 11, 44, 2, 'setuju', 0, NULL, NULL, NULL, NULL, NULL),
(4, 'update', 'Dian Novianti, M.Kom', '2020-11-01 19:19:07', 11, 44, 2, 'setuju', 2, 'setuju', NULL, NULL, NULL, NULL),
(5, 'update', 'Agust Isa Martinus, M.T', '2020-11-01 19:22:57', 11, 44, 2, 'setuju', 2, 'setuju', '2020-11-02', '09:00', 'Lab Informatika', NULL),
(6, 'update', 'Tatang', '2020-11-01 19:26:48', 9, 1, 2, NULL, 2, NULL, '2020-11-02', '11:00', 'Lab Informatika', NULL),
(7, 'update', 'Tatang', '2020-11-01 19:27:05', 11, 44, 2, 'setuju', 2, 'setuju', '2020-11-02', '09:00', 'Lab Informatika', 'Lulus'),
(8, 'insert', 'Mohamad Irfan Manaf', '2020-11-01 21:27:15', 12, 1, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(9, 'update', 'Agust Isa Martinus, M.T', '2020-11-01 21:27:41', 12, 1, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(10, 'update', 'Dr. Wahyu Triono, M.MPd', '2020-11-01 21:28:33', 12, 1, 2, 'Setuju', 0, NULL, NULL, NULL, NULL, NULL),
(11, 'update', 'Agust Isa Martinus, M.T', '2020-11-01 21:29:15', 12, 1, 2, 'Setuju', 2, 'Setuju\r\n', NULL, NULL, NULL, NULL),
(12, 'insert', 'Andhika Budi Prasetya', '2020-11-01 21:32:25', 13, 19, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(13, 'update', 'Harry Gunawan,M.Kom', '2020-11-01 21:32:47', 13, 19, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(14, 'update', 'Maksudi,M.T', '2020-11-01 21:33:38', 13, 19, 2, 'setuju', 0, NULL, NULL, NULL, NULL, NULL),
(15, 'insert', 'Muhammad Irwan', '2020-11-01 21:34:36', 14, 3, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(16, 'update', 'Agust Isa Martinus, M.T', '2020-11-01 21:34:50', 14, 3, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(17, 'update', 'Dr. Wahyu Triono, M.MPd', '2020-11-01 21:35:11', 14, 3, 2, 'setuju', 0, NULL, NULL, NULL, NULL, NULL),
(18, 'update', 'Agust Isa Martinus, M.T', '2020-11-01 21:41:47', 13, 19, 2, 'setuju', 2, 'setuju', NULL, NULL, NULL, NULL),
(19, 'update', 'Agust Isa Martinus, M.T', '2020-11-01 21:42:07', 14, 3, 2, 'setuju', 2, 'setuju', NULL, NULL, NULL, NULL),
(20, 'insert', 'Mahasiswa 1', '2020-11-22 19:05:17', 15, 45, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(21, 'update', 'Harry Gunawan,M.Kom', '2020-11-22 19:15:00', 15, 45, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(22, 'update', 'Dian Novianti, M.Kom', '2020-11-22 19:16:36', 15, 45, 2, 'ok', 0, NULL, NULL, NULL, NULL, NULL),
(23, 'update', 'Dian Novianti, M.Kom', '2020-11-22 19:16:56', 15, 45, 2, 'ok', 2, 'ok', NULL, NULL, NULL, NULL),
(24, 'update', 'Dian Novianti, M.Kom', '2020-11-22 19:17:01', 15, 45, 2, 'ok', 1, 'asda', NULL, NULL, NULL, NULL),
(25, 'update', 'Dian Novianti, M.Kom', '2020-11-22 19:17:14', 15, 45, 2, 'ok', 2, 'ok', NULL, NULL, NULL, NULL),
(26, 'update', 'Dian Novianti, M.Kom', '2020-11-22 19:17:24', 15, 45, 2, 'ok', 1, 'a', NULL, NULL, NULL, NULL),
(27, 'update', 'Dian Novianti, M.Kom', '2020-11-22 20:11:46', 15, 45, 2, 'ok', 2, 'a', NULL, NULL, NULL, NULL),
(28, 'update', 'Tatang', '2020-11-22 20:14:33', 15, 45, 2, 'ok', 2, 'a', '2020-11-23', '03:00', 'Lab Informatika', NULL),
(29, 'update', 'Agust Isa Martinus, M.T', '2020-12-15 19:57:32', 12, 1, 2, 'Setuju', 2, 'Setuju\r\n', '2020-11-02', '09:00', 'Lab Peternakan', NULL),
(30, 'update', 'Agust Isa Martinus, M.T', '2020-12-15 19:57:43', 12, 1, 1, 'ok', 2, 'Setuju\r\n', '2020-11-02', '09:00', 'Lab Peternakan', NULL),
(31, 'update', 'Agust Isa Martinus, M.T', '2020-12-15 20:14:32', 12, 1, 2, 'ok', 2, 'Setuju\r\n', '2020-11-02', '09:00', 'Lab Peternakan', NULL),
(32, 'update', 'Agust Isa Martinus, M.T', '2020-12-15 20:14:39', 12, 1, 1, 'ok', 2, 'Setuju\r\n', '2020-11-02', '09:00', 'Lab Peternakan', NULL),
(33, 'update', 'Tatang', '2020-12-15 21:05:16', 13, 19, 2, 'setuju', 2, 'setuju', '2020-11-02', '11:00', 'Lab Peternakan', NULL),
(34, 'update', 'Tatang', '2020-12-15 21:05:28', 12, 1, 2, 'ok', 2, 'Setuju\r\n', '2020-11-02', '09:00', 'Lab Peternakan', NULL),
(35, 'update', 'Tatang', '2020-12-15 21:05:40', 14, 3, 2, 'setuju', 2, 'setuju', '2020-11-02', '13:00', 'Lab Peternakan', NULL),
(36, 'update', 'Tatang', '2020-12-15 21:09:41', 15, 45, 2, 'ok', 2, 'a', '2020-11-23', '03:00', 'Lab Informatika', 'Lulus'),
(37, 'update', 'Tatang', '2020-12-15 21:09:46', 15, 45, 2, 'ok', 2, 'a', '2020-11-23', '03:00', 'Lab Informatika', 'Lulus'),
(38, 'update', 'Tatang', '2020-12-15 21:09:55', 15, 45, 2, 'ok', 2, 'a', '2020-11-23', '03:00', 'Lab Informatika', 'Tidak Lulus'),
(39, 'update', 'Tatang', '2020-12-15 21:10:17', 15, 45, 2, 'ok', 2, 'a', '2020-11-23', '03:00', 'Lab Informatika', 'Lulus'),
(40, 'insert', 'Mahasiswa1', '2020-12-20 17:55:02', 16, 49, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(41, 'update', 'Dian Novianti, M.Kom', '2020-12-20 18:04:52', 16, 49, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(42, 'insert', 'Mahasiswa1', '2020-12-20 18:05:01', 17, 49, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(43, 'update', 'Dian Novianti, M.Kom', '2020-12-20 18:15:44', 16, 49, 1, '123', 0, NULL, NULL, NULL, NULL, NULL),
(44, 'update', 'Harry Gunawan,M.Kom', '2020-12-20 18:16:15', 16, 49, 2, 'ok', 0, NULL, NULL, NULL, NULL, NULL),
(45, 'insert', 'Mahasiswa1', '2020-12-20 18:16:28', 18, 49, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(46, 'update', 'Harry Gunawan,M.Kom', '2020-12-20 18:16:53', 16, 49, 2, 'ok', 1, 'ok', NULL, NULL, NULL, NULL),
(47, 'insert', 'Mahasiswa1', '2020-12-20 18:17:25', 19, 49, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(48, 'insert', 'Mahasiswa1', '2020-12-20 18:20:39', 20, 49, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(49, 'update', 'Dian Novianti, M.Kom', '2020-12-20 18:21:57', 20, 49, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(50, 'insert', 'Mahasiswa1', '2020-12-20 18:22:08', 21, 49, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(51, 'update', 'Dian Novianti, M.Kom', '2020-12-20 18:27:22', 21, 49, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(52, 'update', 'Harry Gunawan,M.Kom', '2020-12-20 18:27:34', 21, 49, 2, 'ok', 0, NULL, NULL, NULL, NULL, NULL),
(53, 'update', 'Harry Gunawan,M.Kom', '2020-12-20 18:27:39', 20, 49, 1, 'asd', 0, NULL, NULL, NULL, NULL, NULL),
(54, 'update', 'Dian Novianti, M.Kom', '2020-12-20 18:28:30', 21, 49, 2, 'ok', 2, 'asd', NULL, NULL, NULL, NULL),
(55, 'update', 'Tatang', '2020-12-20 18:40:47', 21, 49, 2, 'ok', 2, 'asd', '2020-12-21', '11:00', 'Lab Informatika', NULL),
(56, 'update', 'Tatang', '2020-12-20 19:01:08', 21, 49, 2, 'ok', 2, 'asd', '2020-12-21', '11:01', 'Lab Informatika', NULL),
(57, 'insert', 'Mahasiswa 1', '2020-12-20 20:26:44', 22, 50, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(58, 'update', 'Dian Novianti, M.Kom', '2020-12-20 20:26:59', 22, 50, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(59, 'update', 'Agust Isa Martinus, M.T', '2020-12-20 20:27:10', 22, 50, 2, 'asdsa', 0, NULL, NULL, NULL, NULL, NULL),
(60, 'update', 'Dian Novianti, M.Kom', '2020-12-20 20:27:47', 22, 50, 2, 'asdsa', 2, 'asdas', NULL, NULL, NULL, NULL),
(61, 'update', 'Tatang', '2020-12-20 20:28:53', 22, 50, 2, 'asdsa', 2, 'asdas', '2020-12-21', '11:00', 'Lab Informatika', NULL),
(62, 'update', 'Tatang', '2020-12-28 17:09:36', 22, 50, 2, 'asdsa', 2, 'asdas', '2020-12-21', '11:00', 'Lab Informatika', 'Lulus'),
(63, 'update', 'Tatang', '2020-12-28 17:09:52', 22, 50, 2, 'asdsa', 2, 'asdas', '2020-12-21', '11:00', 'Lab Informatika', 'Tidak Lulus'),
(64, 'update', 'Tatang', '2020-12-28 17:10:08', 22, 50, 2, 'asdsa', 2, 'asdas', '2020-12-21', '11:00', 'Lab Informatika', 'Tidak Lulus'),
(65, 'update', 'Tatang', '2020-12-28 17:10:24', 22, 50, 2, 'asdsa', 2, 'asdas', '2020-12-21', '11:00', 'Lab Informatika', 'Tidak Lulus'),
(66, 'update', 'Tatang', '2020-12-28 17:10:36', 22, 50, 2, 'asdsa', 2, 'asdas', '2020-12-21', '11:00', 'Lab Informatika', 'Tidak Lulus');

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
(2, '160511000-21-Dec-2020-12-55-02-c7f8b5ca27404a7094dd253e746ffccd.pdf', 1, '16'),
(3, '160511000-21-Dec-2020-01-05-01-c7f8b5ca27404a7094dd253e746ffccd.pdf', 0, '17'),
(4, '160511000-21-Dec-2020-01-16-28-c7f8b5ca27404a7094dd253e746ffccd.pdf', 0, '18'),
(5, '160511000-21-Dec-2020-01-17-25-c7f8b5ca27404a7094dd253e746ffccd.pdf', 0, '19'),
(6, '160511000-21-Dec-2020-01-20-39-c7f8b5ca27404a7094dd253e746ffccd.pdf', 0, '20'),
(8, '160511000-21-Dec-2020-03-26-44-c7f8b5ca27404a7094dd253e746ffccd.pdf', 2, '22');

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
(7, 'sistem informasi pelayanan publik tingkat RW menggunakan algoritma fifo', '-', '2020-09-21', 'Ditolak', '0', '0421117105', '-', '123', '160511006'),
(8, 'sistem informasi pelayanan publik tingkat RW menggunakan algoritma fifo', '-', '2020-09-21', 'Ditolak', '0', '0421117105', '-', '-', '160511006'),
(9, 'Implementasi algoritma C45 untuk memprediksi masa studi mahasiswa Teknik informatika berbasis web\r\n', 'universitas Muhammadiyah Cirebon (teknik informatika)', '2020-09-21', 'Disetujui', '0', '0421117105', '-', '123', '160511006'),
(10, 'Spk penerima karyawan yang cocok berdasarkan hasi tes psikotes metode RSAD', '-', '2020-09-21', 'Ditolak', '0', '0416086408', '-', '123', '160511013'),
(11, 'Penerapan metode wp promethe dalam menentukan warga penerima bantuan rutilahu', 'Desa gembongan mekar', '2020-09-21', 'Disetujui', '0', '0416086408', '-', '-', '160511013'),
(13, 'Sistem informasi pembayaran spp berbasis web dengan whatsapp sms gateway', '-', '2020-09-21', 'Ditolak', '0', '0416086408', '-', '-', '160511068'),
(14, 'SPK Perekrutan Guru dengan metode AHP-MOORA', 'Yayasan Al Irsyad Ciledug', '2020-09-21', 'Disetujui', '0', '0416086408', '-', '-', '160511068'),
(15, 'Penerapan metode ahp dan profile matching dalam menentukan posisi olahraga baseball\r\n', 'Perbasi Kota Cirebon', '2020-09-21', 'Disetujui', '0', '0406067407', '-', '-', '160511031'),
(17, 'Point of sale, pengelolaan data tabungan sekolah, sistem informasi akademik', '-', '2020-09-21', 'Ditolak', '0', '0402057307', '-', 'ok', '160511052'),
(18, 'Sistem Informasi Akademik berbasis web android\r\n', 'Universitas Muhammadiyah Cirebon', '2020-09-21', 'Disetujui', '0', '0402057307', '-', '-', '160511052'),
(19, 'Sistem informasi pengajuan dana desa', 'Desa gebang', '2020-09-21', 'Disetujui', '0', '0416086408', '-', '-', '160511053'),
(21, 'Peneran metode fuzzy dalam menentukan nilai mahasiswa', 'Prodi Teknik informatika universitas muhammadiyah cirebon', '2020-09-21', 'Disetujui', '0', '0416086408', '-', '-', '160511039'),
(22, '\"1. Sistem Pendukung Keputusan Pemilihan Jenis Rotan untuk Furniture Menggunakan Metode WP-TOPSIS\r\n2. Sistem Pendukung Keputusan Pengelompokan Jenis Rotan untuk Furniture Menggunakan Metode WP-TOPSIS\"', 'Aditya Rattan', '2020-09-21', 'Ditolak', '0', '0416086408', '-', '-', '160511040'),
(23, 'Sistem Pendukung Keputusan Pengelompokan Jenis Rotan untuk Furniture Menggunakan Metode WP-TOPSIS', 'Aditya Rattan', '2020-09-21', 'Disetujui', '0', '0416086408', '-', '-', '160511040'),
(24, 'Sistem pendukung keputusan pemilihan lokasi usaha cafe menggunakan metode ahp dan wp', 'Cirebon', '2020-09-21', 'Disetujui', '0', '0416086408', '-', '-', '160511063'),
(25, 'Sistem Informasi Pemantauan Pencapain Kinerja di CV. IPTEK', 'CV IPTEK', '2020-09-21', 'Ditolak', '0', '0416086408', '-', '-', '160511064'),
(26, 'Sistem Pendukung Keputusan Pemilihan Dosen dan Karyawan Terbaik', 'UMC\r\n', '2020-09-21', 'Disetujui', '0', '0416086408', '-', '-', '160511064'),
(27, 'Sistem Pendukung Keputusan Pemilihan Kelas Terbaik Menggunakan Metode WASPAS dan AHP', 'SMA Windu Wacana Kota Cirebon', '2020-09-21', 'Ditolak', '1', '0416086408', 'Sistem Pendukung Keputusan Pemilihan Kelas Terbaik Menggunakan Metode WASPAS dan AHP', 'Coba cari judul yang lain', '160511030'),
(28, 'Sistem Informasi Manajemen Praktik Kerja Lapangan dan Skripsi', 'Teknik Informatika Universitas Muhammadiyah Cirebon', '2020-09-21', 'Disetujui', '0', '0416086408', 'Sistem Informasi Manajemen Praktik Kerja Lapangan dan Skripsi12', 'SEYUJU', '160511030'),
(29, 'Sistem Pakar Penyesuaian Lahan Untuk Tanaman Pangan Berdasarkan Tanah Dengan Metode Bayes', NULL, '2020-09-22', 'Disetujui', '0', '0416086408', '-', '-', '160511054'),
(30, 'Penerapan Metode AHP - TOPSIS Pada Penerima Bantuan Sosial', 'Desa Gebang Kabupaten Cirebon', '2020-09-22', 'Disetujui', '0', '0416086408', '-', '-', '160511001'),
(31, 'Sistem Pendukung Keputusan Pelayanan Publik Menggunakan Metode Service Quality (SERVQUAL) dan Metode Analytical Hierarchy Process (AHP)', 'Universitas Muhamamdiyah Cirebon', '2020-09-22', 'Disetujui', '0', '0416086408', '-', '-', '160511055'),
(32, 'Sistem Pendukung Keputusan Perkembangan Anak Berkebutuhan Menggunakan Metode AHP-VIKOR', 'SLB', '2020-09-22', 'Disetujui', '0', '0416086408', '-', '-', '160511026'),
(58, 'Judul 1', 'asdas', '2020-12-21', 'Disetujui', '0', '0416086408', 'adas', 'ok', '160511000'),
(59, 'judul 1', NULL, '2020-12-21', '', '0', '', '', NULL, '160511100');

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
('160511030', 'YXBlbmc=', 'Mohamad Irfan Manaf', '13102020225826-profil.png', 'Jl Pinus V No 202 BAS', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', 'Lulus', 'Lulus', '-', '2020-09-24 08:15:31'),
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
(12, 'update', 'Tatang', '2020-10-02 01:05:05', '160511000', 'MTYwNTExMDAw', 'apeng', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(13, 'update', 'apeng', '2020-10-02 01:06:12', '160511000', 'MTYwNTExMDAw', 'apeng', 'profil.png', '', '', 'Teknik Informatika', '2016', '', 'Aktif', '-', '-', '-'),
(14, 'update', 'apeng', '2020-10-02 03:31:46', '160511000', 'MTYwNTExMDAw', 'apeng', 'profil.png', 'Jl. Cirebon', '0881', 'Teknik Informatika', '2016', 'Cirebon', 'Aktif', '-', '-', '-'),
(15, 'update', 'Tatang', '2020-10-02 03:35:39', '160511000', 'MTYwNTExMDAw', 'apeng', 'profil.png', 'Jl. Cirebon', '0881', 'Teknik Informatika', '2016', 'Cirebonccc', 'Aktif', '-', '-', '-'),
(16, 'update', 'Mohamad Irfan Manaf', '2020-10-13 15:58:26', '160511030', 'YXBlbmc=', 'Mohamad Irfan Manaf', '22092020212547-DSC_0885.JPG', 'Jl Pinus V', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 Apri 1998', 'Aktif', 'Lulus', 'Lulus', '-'),
(17, 'insert', 'Tatang', '2020-10-13 19:31:29', '16011', 'MTYwMTE=', 'apg', 'profil.png', NULL, NULL, 'apg', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(18, 'insert', 'Tatang', '2020-10-13 19:44:14', '160511000', 'MTYwNTExMDAw', 'apeng', 'profil.png', NULL, NULL, 'apeng', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(19, 'delete', 'Tatang', '2020-10-13 19:44:14', '160511000', 'MTYwNTExMDAw', 'apeng', 'profil.png', NULL, NULL, 'apeng', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(20, 'delete', 'Tatang', '2020-10-13 19:45:05', 'ap', 'ap', 'ap', 'profil.png', 'ap', 'ap', 'ap', '2016', 'ap', 'Aktif', '-', '-', '-'),
(21, 'delete', 'Tatang', '2020-10-13 19:45:32', 'apeng', 'apeng', 'apeng', 'profil.png', 'apeng', 'apeng', 'apeng', '2016', 'apeng', 'Tidak Aktif', '-', '-', '-'),
(22, 'insert', 'Tatang', '2020-10-14 16:03:16', '000', 'MDAw', '123', 'profil.png', NULL, NULL, '123', '123', NULL, 'Tidak Aktif', '-', '-', '-'),
(25, 'insert', 'Tatang', '2020-10-14 16:14:27', '1233', 'MTIzMw==', '123', 'profil.png', NULL, NULL, '123', '123', NULL, 'Tidak Aktif', '-', '-', '-'),
(26, 'delete', '', '2020-10-14 16:15:07', '1233', 'MTIzMw==', '123', 'profil.png', NULL, NULL, '123', '123', NULL, 'Tidak Aktif', '-', '-', '-'),
(27, 'update', 'Tatang', '2020-10-14 16:21:27', '000', 'MDAw', '123', 'profil.png', NULL, NULL, '123', '123', NULL, 'Tidak Aktif', '-', '-', '-'),
(28, 'update', 'Tatang', '2020-10-14 16:21:47', '000', 'MDAw', '123AAA', 'profil.png', '', '', '123', '123', '', 'Tidak Aktif', '-', '-', '-'),
(29, '', NULL, '2020-10-14 16:22:24', '000', 'MDAw', '123AAAZZZ', 'profil.png', '', '', '123', '123', '', 'Tidak Aktif', '-', '-', '-'),
(30, 'delete', '', '2020-10-14 16:22:37', '12312', 'MDAw', '123AAAZZZ', 'profil.png', '', '', '123', '123', '', 'Tidak Aktif', '-', '-', '-'),
(31, 'insert', 'Tatang', '2020-10-14 16:23:50', '123', 'MTIz', '123', 'profil.png', NULL, NULL, '123', '123', NULL, 'Tidak Aktif', '-', '-', '-'),
(32, 'delete', 'Tatang', '2020-10-14 16:24:16', '123', 'MTIz', '123', 'profil.png', NULL, NULL, '123', '123', NULL, 'Tidak Aktif', '-', '-', '-'),
(33, 'insert', 'Tatang', '2020-10-14 16:24:39', '123111', 'MTIzMTEx', '123', 'profil.png', NULL, NULL, '13', '123', NULL, 'Tidak Aktif', '-', '-', '-'),
(34, 'delete', 'Tatang', '2020-10-14 16:25:04', '123111', 'MTIzMTEx', '123', 'profil.png', NULL, NULL, '13', '123', NULL, 'Tidak Aktif', '-', '-', '-'),
(35, 'insert', 'Tatang', '2020-10-14 16:38:13', '123', 'MTIz', '123', 'profil.png', NULL, NULL, '123', '123', NULL, 'Tidak Aktif', '-', '-', '-'),
(36, 'update', 'Mohamad Irfan Manaf', '2020-10-14 16:47:36', '160511030', 'YXBlbmc=', 'Mohamad Irfan Manaf', '13102020225826-profil.png', 'Jl Pinus V', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 Apri 1998', 'Aktif', 'Lulus', 'Lulus', '-'),
(37, 'update', 'Mohamad Irfan Manaf', '2020-10-14 16:47:42', '160511030', 'YXBlbmc=', 'Mohamad Irfan Manaf', '13102020225826-profil.png', 'Jl Pinus V', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 Apri 1998', 'Aktif', 'Lulus', 'Lulus', '-'),
(38, 'update', 'Tatang', '2020-10-14 16:50:33', '123', 'MTIz', '123', 'profil.png', NULL, NULL, '123', '123', NULL, 'Tidak Aktif', '-', '-', '-'),
(39, 'update', 'Tatang', '2020-10-14 20:56:47', '160511030', 'YXBlbmc=', 'Mohamad Irfan Manaf', '13102020225826-profil.png', 'Jl Pinus V', '08815223912', 'Teknik Informatika', '2016', '', 'Aktif', 'Lulus', 'Lulus', '-'),
(40, 'update', 'Mohamad Irfan Manaf', '2020-10-15 08:38:50', '160511030', 'YXBlbmc=', 'Mohamad Irfan Manaf', '13102020225826-profil.png', 'Jl Pinus V', '08815223912', 'Teknik Informatika', '2016', '', 'Aktif', 'Lulus', 'Lulus', '-'),
(41, 'update', 'Mohamad Irfan Manaf', '2020-10-15 18:08:50', '160511030', 'YXBlbmc=', 'Mohamad Irfan Manaf', '13102020225826-profil.png', 'Jl Pinus V', '08815223912', 'Teknik Informatika', '2016', '', 'Aktif', 'Lulus', 'Lulus', '-'),
(42, 'insert', 'Tatang', '2020-10-24 11:45:32', '160511000', 'MTYwNTExMDAw', 'Apeng', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(43, 'update', 'Apeng', '2020-10-24 14:56:58', '160511000', 'MTYwNTExMDAw', 'Apeng', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(44, 'delete', 'Tatang', '2020-10-25 13:37:04', '160511000', 'MTYwNTExMDAw', 'Apeng', 'profil.png', 'Cirebon', '081535353', 'Teknik Informatika', '2016', 'Cirebon', 'Tidak Aktif', '-', '-', '-'),
(45, 'delete', 'Tatang', '2020-10-25 13:37:34', '123', 'MTIz', '123', 'profil.png', '', '', '123', '123', '', 'Aktif', '-', '-', '-'),
(46, 'insert', 'Tatang', '2020-10-25 13:38:32', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(47, 'update', 'Tatang', '2020-10-25 13:42:24', '160511030', 'YXBlbmc=', 'Mohamad Irfan Manaf', '13102020225826-profil.png', 'Jl Pinus V', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', 'Lulus', 'Lulus', '-'),
(48, 'update', 'Tatang', '2020-10-25 13:43:22', '160511001', 'MTYwNTExMDAx', 'Andhika Budi Prasetya', 'profil.png', 'Brebes', '085869595134', 'Teknik Informatika', '2016', 'Brebes, 12 Juni 1995', 'Aktif', 'Lulus', 'Lulus', '-'),
(49, 'update', 'Tatang', '2020-10-25 13:43:34', '160511030', 'YXBlbmc=', 'Mohamad Irfan Manaf', '13102020225826-profil.png', 'Jl Pinus V No 202 BAS', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', 'Lulus', 'Lulus', '-'),
(50, 'update', 'Tatang', '2020-10-25 13:44:02', '160511001', 'YXBlbmc=', 'Mohamad Irfan Manaf', 'profil.png', 'Jl Pinus V No 202 BAS', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', 'Lulus', 'Lulus', '-'),
(51, 'insert', 'Tatang', '2020-10-25 14:04:41', 'INPUT MULAI', 'SU5QVVQgTVVMQUkgREFSSSBCQVJJUyBJTkk=', 'INPUT MULAI DARI BARIS INI', 'profil.png', NULL, NULL, 'INPUT MULAI DARI BARIS IN', 'INPUT', NULL, 'Tidak Aktif', '-', '-', '-'),
(52, 'insert', 'Tatang', '2020-10-25 14:04:41', '', '', '', 'profil.png', NULL, NULL, '', '', NULL, 'Tidak Aktif', '-', '-', '-'),
(53, NULL, NULL, '2020-10-25 14:11:55', 'INPUT MULAI', 'SU5QVVQgTVVMQUkgREFSSSBCQVJJUyBJTkk=', 'INPUT MULAI DARI BARIS INI', 'profil.png', NULL, NULL, 'INPUT MULAI DARI BARIS IN', 'INPUT', NULL, 'Tidak Aktif', '-', '-', '-'),
(54, NULL, NULL, '2020-10-25 14:11:57', '', '', '', 'profil.png', NULL, NULL, '', '', NULL, 'Tidak Aktif', '-', '-', '-'),
(55, 'insert', 'Tatang', '2020-10-25 14:23:48', '160511100', 'MTYwNTExMTAw', 'Mahasiswa 2', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(56, 'insert', 'Tatang', '2020-10-25 14:23:48', '160511101', 'MTYwNTExMTAx', 'Mahasiswaa 3', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(57, 'insert', 'Tatang', '2020-10-25 14:23:48', '', '', '', 'profil.png', NULL, NULL, '', '', NULL, 'Tidak Aktif', '-', '-', '-'),
(58, NULL, NULL, '2020-10-25 14:24:13', '', '', '', 'profil.png', NULL, NULL, '', '', NULL, 'Tidak Aktif', '-', '-', '-'),
(59, 'insert', 'Tatang', '2020-10-25 14:27:03', '', '', '', 'profil.png', NULL, NULL, '', '', NULL, 'Tidak Aktif', '-', '-', '-'),
(60, NULL, NULL, '2020-10-25 14:27:24', '160511100', 'MTYwNTExMTAw', 'Mahasiswa 2', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(61, NULL, NULL, '2020-10-25 14:27:26', '160511101', 'MTYwNTExMTAx', 'Mahasiswaa 3', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(62, NULL, NULL, '2020-10-25 14:27:28', '', '', '', 'profil.png', NULL, NULL, '', '', NULL, 'Tidak Aktif', '-', '-', '-'),
(63, 'insert', 'Tatang', '2020-10-25 14:27:38', '160511100', 'MTYwNTExMTAw', 'Mahasiswa 2', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(64, 'insert', 'Tatang', '2020-10-25 14:27:38', '160511101', 'MTYwNTExMTAx', 'Mahasiswaa 3', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(65, 'insert', 'Tatang', '2020-10-25 14:27:38', '', '', '', 'profil.png', NULL, NULL, '', '', NULL, 'Tidak Aktif', '-', '-', '-'),
(66, NULL, NULL, '2020-10-25 14:32:00', '', '', '', 'profil.png', NULL, NULL, '', '', NULL, 'Tidak Aktif', '-', '-', '-'),
(67, NULL, NULL, '2020-10-25 14:32:05', '160511100', 'MTYwNTExMTAw', 'Mahasiswa 2', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(68, NULL, NULL, '2020-10-25 14:32:08', '160511101', 'MTYwNTExMTAx', 'Mahasiswaa 3', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(69, 'insert', 'Tatang', '2020-10-25 14:32:23', '160511100', 'MTYwNTExMTAw', 'Mahasiswa 2', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(70, 'insert', 'Tatang', '2020-10-25 14:32:23', '160511101', 'MTYwNTExMTAx', 'Mahasiswaa 3', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(71, 'insert', 'Tatang', '2020-10-25 14:32:23', '', '', '', 'profil.png', NULL, NULL, '', '', NULL, 'Tidak Aktif', '-', '-', '-'),
(72, NULL, NULL, '2020-10-25 14:33:00', '', '', '', 'profil.png', NULL, NULL, '', '', NULL, 'Tidak Aktif', '-', '-', '-'),
(73, NULL, NULL, '2020-10-25 14:33:00', '160511101', 'MTYwNTExMTAx', 'Mahasiswaa 3', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(74, NULL, NULL, '2020-10-25 14:33:00', '160511100', 'MTYwNTExMTAw', 'Mahasiswa 2', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(75, 'insert', 'Tatang', '2020-10-25 14:45:53', '123', 'MTIz', '123', 'profil.png', NULL, NULL, 'teknik informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(76, 'insert', 'Tatang', '2020-10-25 14:45:53', '321', 'MzIx', '321', 'profil.png', NULL, NULL, 'teknik informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(77, 'delete', 'Tatang', '2020-10-25 14:46:04', '123', 'MTIz', '123', 'profil.png', NULL, NULL, 'teknik informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(78, 'delete', 'Tatang', '2020-10-25 14:46:49', '321', 'MzIx', '321', 'profil.png', NULL, NULL, 'teknik informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(79, 'insert', 'Tatang', '2020-10-25 14:47:42', '123', 'MTIz', '123', 'profil.png', NULL, NULL, 'teknik informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(80, 'insert', 'Tatang', '2020-10-25 14:47:42', '321', 'MzIx', '321', 'profil.png', NULL, NULL, 'teknik informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(81, 'delete', 'Tatang', '2020-10-25 14:47:47', '123', 'MTIz', '123', 'profil.png', NULL, NULL, 'teknik informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(82, 'delete', 'Tatang', '2020-10-25 14:48:02', '321', 'MzIx', '321', 'profil.png', NULL, NULL, 'teknik informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(83, 'insert', 'Tatang', '2020-10-25 14:49:40', '123', 'MTIz', '160511100', 'profil.png', NULL, NULL, 'Mahasiswa 2', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(84, 'insert', 'Tatang', '2020-10-25 14:49:40', '321', 'MzIx', '160511101', 'profil.png', NULL, NULL, 'Mahasiswa 3', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(85, NULL, NULL, '2020-10-25 14:52:03', '123', 'MTIz', '160511100', 'profil.png', NULL, NULL, 'Mahasiswa 2', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(86, NULL, NULL, '2020-10-25 14:52:03', '321', 'MzIx', '160511101', 'profil.png', NULL, NULL, 'Mahasiswa 3', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(87, 'insert', 'Tatang', '2020-10-25 14:52:11', '123', 'MTIz', 'Mahasiswa 2', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(88, 'insert', 'Tatang', '2020-10-25 14:52:11', '321', 'MzIx', 'Mahasiswa 3', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(89, NULL, NULL, '2020-10-25 14:52:51', '123', 'MTIz', 'Mahasiswa 2', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(90, NULL, NULL, '2020-10-25 14:52:51', '321', 'MzIx', 'Mahasiswa 3', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(91, 'insert', 'Tatang', '2020-10-25 14:52:58', '160511100', 'MTYwNTExMTAw', 'Mahasiswa 2', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(92, 'insert', 'Tatang', '2020-10-25 14:52:58', '160511101', 'MTYwNTExMTAx', 'Mahasiswa 3', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(93, 'update', 'Mohamad Irfan Manaf', '2020-10-25 14:56:00', '160511030', 'YXBlbmc=', 'Mohamad Irfan Manaf', '13102020225826-profil.png', 'Jl Pinus V No 202 BAS', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', 'Lulus', 'Lulus', '-'),
(94, NULL, NULL, '2020-10-25 15:44:00', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(95, 'update', 'Mahasiswa 1', '2020-10-25 16:10:32', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', 'Lulus', '-', '-'),
(96, NULL, NULL, '2020-10-31 17:21:00', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Cirebon', '08815223912', 'Teknik Informatika', '2016', 'Cirebon', 'Tidak Aktif', 'Lulus', '-', '-'),
(97, NULL, NULL, '2020-10-31 17:25:45', '160511100', 'MTYwNTExMTAw', 'Mahasiswa 2', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(98, NULL, NULL, '2020-10-31 17:25:45', '160511101', 'MTYwNTExMTAx', 'Mahasiswa 3', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(99, 'insert', 'Tatang', '2020-12-31 19:14:07', '160511100', 'MTYwNTExMTAw', 'mahasiswa1', 'profil.png', NULL, NULL, 'teknik informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(100, 'delete', 'Tatang', '2020-12-31 19:14:18', '160511100', 'MTYwNTExMTAw', 'mahasiswa1', 'profil.png', NULL, NULL, 'teknik informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(101, 'insert', 'Tatang', '2020-12-31 19:16:12', '160511100', 'MTYwNTExMTAw', 'mahasiswa1', 'profil.png', NULL, NULL, 'teknik informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(102, 'delete', 'Tatang', '2020-12-31 19:19:55', '160511100', 'MTYwNTExMTAw', 'mahasiswa1', 'profil.png', NULL, NULL, 'teknik informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(103, 'update', 'Tatang', '2020-12-31 19:25:53', '160511006', 'MTYwNTExMDA2', 'Tiefani Permata Sari', 'profil.png', 'Perumahan griya jadimulya blok A2 no5', '089512275398', 'Teknik Informatika', '2016', 'Cirebon,06-12-98', 'Aktif', 'Lulus', '-', '-'),
(104, 'update', 'Tatang', '2020-12-31 19:26:03', '160511026', 'MTYwNTExMDI2', 'Vatmawati', 'profil.png', 'Desa megu cilik, blok pengadangan rt/rw 02/02 kec. Weru kab. Cirebon', '083120141302', 'Teknik Informatika', '2016', 'Cirebon 04 oktober 1996', 'Aktif', '-', '-', '-'),
(105, 'update', 'Tatang', '2020-12-31 19:26:10', '160511031', 'MTYwNTExMDMx', 'Reza Rizky Fahlevi', 'profil.png', 'Bumi Kalijaga Permai Timur Jalan Durian no. 11 BKPT', '081286460824\r\n', 'Teknik Informatika', '2016', 'Cirebon, 14 Oktober 1997', 'Aktif', '-', '-', '-'),
(106, 'update', 'Tatang', '2020-12-31 19:26:17', '160511039', '160511039', 'Rizky anwar sudiyono', 'profil.png', 'Gg 4 selatan karangampel kidul indramayu', '089611623879', 'Teknik Informatika', '2016', 'Indramayu 18 november 1997', 'Aktif', '-', '-', '-'),
(107, 'update', 'Tatang', '2020-12-31 19:26:33', '160511063', 'MTYwNTExMDYz', 'Arif Wahfiudin', 'profil.png', 'Blok prapatan, desa getasan, kec. Depok, kab. Cirebon', '083824810184\r\n', 'Teknik Informatika', '2016', 'Cirebon, 15 april 1997', 'Aktif', 'Lulus', '-', '-'),
(108, 'update', 'Tatang', '2020-12-31 19:26:43', '160511070', '160511070', 'Ahmad Fauzan', 'profil.png', 'Blok. Cemeti Ds. Kedokanbunder Wetan Rt/Rw 011/002 Kec. Kedokanbunder - Indramayu', '08999435314', 'Teknik Informatika', '2016', 'Indramayu,08 Agustus 1993', 'Aktif', '-', 'Lulus', '-'),
(109, 'update', 'Tatang', '2020-12-31 19:26:56', '160511054', 'MTYwNTExMDU0', 'Budi Setiawan', 'profil.png', 'Desa Gebang Kec. Gebang Kab. Cirebon', '087829890388', 'Teknik Informatika', '2016', 'Cirebon, 20 November 1997\r\n', 'Aktif', 'Lulus', '-', '-'),
(110, 'update', 'Tatang', '2020-12-31 19:27:02', '160511009', '160511009', 'Anita Widiyanthi\r\n', 'profil.png', 'Dusun karanganyar rt/rw 008/003 desa ciwiru kecamatan pasawahan kabupaten kuningan', '082121002682', 'Teknik Informatika', '2016', 'Kuningan, 18 juli 1998', 'Aktif', '-', '-', '-'),
(111, 'update', 'Tatang', '2020-12-31 19:27:14', '160511053', '160511053', 'Dede muchidin', 'profil.png', 'Dusun 01 rt 02 rw 01 ds gebang kec gebang', '089665830991', 'Teknik Informatika', '2016', 'Cirebon,12 juni 1997', 'Aktif', '-', '-', '-'),
(112, 'update', 'Tatang', '2020-11-01 14:58:59', '160511001', 'YXBlbmc=', 'Andhika Budi Prasetya', 'profil.png', '', '', 'Teknik Informatika', '2016', '', 'Aktif', 'Lulus', 'Lulus', '-'),
(113, 'update', 'Tatang', '2020-11-01 14:59:06', '160511001', 'YXBlbmc=', 'Andhika Budi Prasetyaa', 'profil.png', '', '', 'Teknik Informatika', '2016', '', 'Aktif', 'Lulus', 'Lulus', '-'),
(114, 'update', 'Tatang', '2020-11-01 15:11:35', '160511030', 'YXBlbmc=', 'Mohamad Irfan Manaf', '13102020225826-profil.png', 'Jl Pinus V No 202 BAS', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', 'Lulus', 'Lulus', '-'),
(115, 'update', 'Tatang', '2020-11-01 15:12:11', '160511030', 'YXBlbmc=', 'Mohamad Irfan Manaf', '13102020225826-profil.png', 'Jl Pinus V No 202 BAS', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Tidak Aktif', 'Lulus', 'Lulus', '-'),
(116, 'insert', 'Tatang', '2020-11-01 18:28:33', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(117, 'update', 'Tatang', '2020-11-01 18:29:44', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(118, 'update', 'Mahasiswa 1', '2020-11-01 18:30:39', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', '', '', 'Teknik Informatika', '2016', '', 'Aktif', '-', '-', '-'),
(119, 'update', 'Tatang', '2020-11-01 18:55:44', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Cirebon Kota', '08815223912', 'Teknik Informatika', '2016', 'Cirebon 08 April 1998', 'Aktif', '-', '-', '-'),
(120, 'update', 'Tatang', '2020-11-01 19:11:33', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Cirebon Kota', '08815223912', 'Teknik Informatika', '2016', 'Cirebon 08 April 1998', 'Aktif', 'Lulus', '-', '-'),
(121, 'update', 'Tatang', '2020-11-01 19:55:42', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Cirebon Kota', '08815223912', 'Teknik Informatika', '2016', 'Cirebon 08 April 1998', 'Aktif', 'Lulus', 'Lulus', '-'),
(122, NULL, NULL, '2020-11-01 19:58:27', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Cirebon Kota', '08815223912', 'Teknik Informatika', '2016', 'Cirebon 08 April 1998', 'Aktif', 'Lulus', 'Lulus', 'Lulus'),
(123, 'update', 'Andhika Budi Prasetya', '2020-11-01 21:31:58', '160511001', 'YXBlbmc=', 'Andhika Budi Prasetya', 'profil.png', '', '', 'Teknik Informatika', '2016', '', 'Aktif', 'Lulus', 'Lulus', '-'),
(124, 'update', 'Andhika Budi Prasetya', '2020-11-01 21:32:10', '160511001', 'YXBlbmc=', 'Andhika Budi Prasetya', 'profil.png', 'Brebes', '08815223912', 'Teknik Informatika', '2016', 'Brebes, 12 Juni 1995', 'Aktif', 'Lulus', 'Lulus', '-'),
(125, 'insert', 'Tatang', '2020-11-02 02:50:39', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(126, 'update', 'Tatang', '2020-11-02 02:52:54', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(127, 'update', 'Mahasiswa 1', '2020-11-02 03:23:53', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', '', '', 'Teknik Informatika', '2016', '', 'Aktif', '-', '-', '-'),
(128, 'update', 'Tatang', '2020-11-22 16:06:22', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Cirebon', '08815223912', 'Teknik Informatika', '2016', 'Cirebon', 'Aktif', '-', '-', '-'),
(129, 'insert', 'Tatang', '2020-12-15 20:44:12', '1231', 'MTIzMQ==', '123', 'profil.png', NULL, NULL, 'Teknik Informatika', '123', NULL, 'Tidak Aktif', '-', '-', '-'),
(130, 'delete', 'Tatang', '2020-12-15 20:44:22', '1231', 'MTIzMQ==', '123', 'profil.png', NULL, NULL, 'Teknik Informatika', '123', NULL, 'Tidak Aktif', '-', '-', '-'),
(131, NULL, NULL, '2020-12-15 21:28:54', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Cirebon', '08815223912', 'Teknik Informatika', '2016', 'Cirebon', 'Aktif', 'Lulus', '-', '-'),
(132, 'insert', 'Tatang', '2020-12-19 10:28:23', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(133, 'insert', 'Tatang', '2020-12-19 10:31:18', '160511999', 'MTYwNTExOTk5', 'mahasiswa999', 'profil.png', NULL, NULL, 'teknik informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(134, 'insert', 'Tatang', '2020-12-19 10:31:18', '160511888', 'MTYwNTExODg4', 'mahasiswa888', 'profil.png', NULL, NULL, 'teknik informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(135, 'insert', 'Tatang', '2020-12-19 10:31:18', '160511777', 'MTYwNTExNzc3', 'mahasiswa777', 'profil.png', NULL, NULL, 'teknik informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(136, 'insert', 'Tatang', '2020-12-19 10:31:18', '160511666', 'MTYwNTExNjY2', 'mahasiswa666', 'profil.png', NULL, NULL, 'teknik informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(137, 'update', 'Tatang', '2020-12-19 10:31:53', '160511666', 'MTYwNTExNjY2', 'mahasiswa666', 'profil.png', NULL, NULL, 'teknik informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(138, 'update', 'Tatang', '2020-12-19 10:32:06', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(139, 'update', 'Mahasiswa 1', '2020-12-19 10:34:52', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', '', '', 'Teknik Informatika', '2016', '', 'Aktif', '-', '-', '-'),
(140, 'update', 'Tatang', '2020-12-19 10:59:30', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Jl. Cirebon No 202', '08815223912', 'Teknik Informatika', '2016', 'Cirebon 08 April 1998', 'Aktif', '-', '-', '-'),
(141, 'update', 'Tatang', '2020-12-19 11:50:00', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Jl. Cirebon No 202', '08815223912', 'Teknik Informatika', '2016', 'Cirebon 08 April 1998', 'Aktif', 'Lulus', '-', '-'),
(142, NULL, NULL, '2020-12-20 16:40:41', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Jl. Cirebon No 202', '08815223912', 'Teknik Informatika', '2016', 'Cirebon 08 April 1998', 'Aktif', 'Lulus', 'Lulus', '-'),
(143, 'insert', 'Tatang', '2020-12-20 16:47:03', '160511000', 'MTYwNTExMDAw', 'Mahasiswa1', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(144, 'update', 'Tatang', '2020-12-20 16:48:40', '160511000', 'MTYwNTExMDAw', 'Mahasiswa1', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(145, 'delete', 'Tatang', '2020-12-20 16:48:50', '160511666', 'MTYwNTExNjY2', 'mahasiswa teladan', 'profil.png', 'cirebon', '08815223912', 'teknik informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', '-', '-', '-'),
(146, 'delete', 'Tatang', '2020-12-20 16:48:59', '160511777', 'MTYwNTExNzc3', 'mahasiswa777', 'profil.png', NULL, NULL, 'teknik informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(147, 'delete', 'Tatang', '2020-12-20 16:49:06', '160511888', 'MTYwNTExODg4', 'mahasiswa888', 'profil.png', NULL, NULL, 'teknik informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(148, 'delete', 'Tatang', '2020-12-20 16:49:12', '160511999', 'MTYwNTExOTk5', 'mahasiswa999', 'profil.png', NULL, NULL, 'teknik informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(149, 'update', 'Mahasiswa1', '2020-12-20 16:51:30', '160511000', 'MTYwNTExMDAw', 'Mahasiswa1', 'profil.png', '', '', 'Teknik Informatika', '2016', '', 'Aktif', '-', '-', '-'),
(150, 'update', 'Tatang', '2020-12-20 17:09:18', '160511000', 'MTYwNTExMDAw', 'Mahasiswa1', 'profil.png', 'Cirebon', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', '-', '-', '-'),
(151, NULL, NULL, '2020-12-20 19:59:49', '160511000', 'MTYwNTExMDAw', 'Mahasiswa1', 'profil.png', 'Cirebon', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', 'Lulus', '-', '-'),
(152, 'insert', 'Tatang', '2020-12-20 20:04:39', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(153, 'insert', 'Tatang', '2020-12-20 20:04:48', '160511999', 'MTYwNTExOTk5', 'mahasiswa999', 'profil.png', NULL, NULL, 'teknik informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(154, 'insert', 'Tatang', '2020-12-20 20:04:48', '160511888', 'MTYwNTExODg4', 'mahasiswa888', 'profil.png', NULL, NULL, 'teknik informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(155, 'insert', 'Tatang', '2020-12-20 20:04:48', '160511777', 'MTYwNTExNzc3', 'mahasiswa777', 'profil.png', NULL, NULL, 'teknik informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(156, 'insert', 'Tatang', '2020-12-20 20:04:48', '160511666', 'MTYwNTExNjY2', 'mahasiswa666', 'profil.png', NULL, NULL, 'teknik informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(157, 'delete', 'Tatang', '2020-12-20 20:04:55', '160511666', 'MTYwNTExNjY2', 'mahasiswa666', 'profil.png', NULL, NULL, 'teknik informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(158, 'update', 'Tatang', '2020-12-20 20:05:02', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(159, 'update', 'Mahasiswa 1', '2020-12-20 20:05:24', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', '', '', 'Teknik Informatika', '2016', '', 'Aktif', '-', '-', '-'),
(160, 'update', 'Tatang', '2020-12-20 20:16:47', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Jl Pinus V No 202 BAS', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', '-', '-', '-'),
(161, 'insert', 'Tatang', '2020-12-21 04:39:21', '160511100', 'MTYwNTExMTAw', 'Hari', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(162, 'update', 'Tatang', '2020-12-21 04:40:08', '160511100', 'MTYwNTExMTAw', 'Hari', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(163, 'update', 'Tatang', '2020-12-21 04:40:44', '160511100', 'MTYwNTExMTAw', 'Hari', 'profil.png', 'xx', '', 'Teknik Informatika', '2016', '', 'Aktif', '-', '-', '-'),
(164, 'insert', 'Tatang', '2020-12-27 16:09:45', '160511123', 'MTYwNTExMTIz', 'ASDASDAS', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(165, 'delete', 'Tatang', '2020-12-27 16:09:49', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Jl Pinus V No 202 BAS', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', 'Lulus', '-', '-'),
(166, 'insert', 'Tatang', '2020-12-27 16:29:28', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(167, 'update', 'Tatang', '2020-12-27 16:29:54', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(168, 'update', 'Tatang', '2020-12-27 16:30:01', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', '', '', 'Teknik Informatika', '2016', '', 'Tidak Aktif', '-', '-', '-'),
(169, 'update', 'Tatang', '2020-12-27 16:30:09', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', '', '', 'Teknik Informatika', '2016', '', 'Aktif', 'Lulus', 'Lulus', 'Lulus'),
(170, NULL, NULL, '2020-12-28 16:00:55', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Cirebon', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', 'Lulus', 'Lulus', 'Lulus'),
(171, 'update', 'Tatang', '2020-12-28 16:01:11', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Cirebon', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', 'Lulus', 'Lulus', 'Lulus'),
(172, NULL, NULL, '2020-12-28 16:01:21', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Cirebon', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', 'Lulus', 'Lulus', '-'),
(173, 'update', 'Tatang', '2020-12-28 16:05:54', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Cirebon', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', 'Lulus', 'Lulus', 'Lulus'),
(174, 'update', 'Tatang', '2020-12-28 16:06:01', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Cirebon', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', 'Lulus', 'Lulus', 'Lulus'),
(175, 'update', 'Tatang', '2020-12-28 16:36:01', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Cirebon', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', 'Lulus', 'Lulus', 'Lulus'),
(176, 'update', 'Tatang', '2020-12-28 16:40:08', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Cirebon', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', 'Lulus', 'Lulus', '-'),
(177, 'update', 'Tatang', '2020-12-28 16:40:36', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Cirebon', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', 'Lulus', 'Lulus', '-'),
(178, 'update', 'Tatang', '2020-12-28 16:46:08', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Cirebon', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', 'Lulus', 'Lulus', '-'),
(179, 'update', 'Tatang', '2020-12-28 16:46:21', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Cirebon', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', 'Lulus', 'Lulus', '-'),
(180, 'update', 'Tatang', '2020-12-28 16:46:58', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Cirebon', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', 'Lulus', 'Lulus', '-'),
(181, 'update', 'Tatang', '2020-12-28 16:47:02', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Cirebon', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', 'Lulus', 'Lulus', '-'),
(182, 'update', 'Tatang', '2020-12-28 16:47:04', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Cirebon', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', 'Lulus', 'Lulus', '-'),
(183, 'update', 'Tatang', '2020-12-28 16:47:05', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Cirebon', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', 'Lulus', 'Lulus', '-'),
(184, 'update', 'Tatang', '2020-12-28 16:47:12', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Cirebon', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', 'Lulus', 'Lulus', '-'),
(185, 'update', 'Tatang', '2020-12-28 16:55:49', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Cirebon', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', 'Lulus', 'Lulus', '-'),
(186, 'update', 'Tatang', '2020-12-28 16:55:58', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Cirebon', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', 'Lulus', 'Lulus', '-'),
(187, 'update', 'Tatang', '2020-12-28 16:58:06', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Cirebon', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', 'Lulus', 'Lulus', '-'),
(188, 'update', 'Tatang', '2020-12-28 17:03:50', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Cirebon', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', 'Lulus', 'Lulus', '-'),
(189, 'update', 'Tatang', '2020-12-28 19:20:09', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Cirebon', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', 'Lulus', 'Lulus', '-'),
(190, NULL, NULL, '2020-12-29 03:01:15', '160511100', 'MTYwNTExMTAw', 'Hari', 'profil.png', 'xx', '', 'Teknik Informatika', '2016', '', 'Aktif', 'Lulus', '-', '-'),
(191, NULL, NULL, '2021-01-08 08:02:35', '160511000', 'MTYwNTExMDAw', 'Mahasiswa 1', 'profil.png', 'Cirebon', '08815223912', 'Teknik Informatika', '2016', 'Kuningan, 08 April 1998', 'Aktif', '-', 'Lulus', '-'),
(192, 'delete', 'Tatang', '2021-01-08 08:03:17', '160511123', 'MTYwNTExMTIz', 'ASDASDAS', 'profil.png', NULL, NULL, 'Teknik Informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(193, 'delete', 'Tatang', '2021-01-08 08:03:36', '160511777', 'MTYwNTExNzc3', 'mahasiswa777', 'profil.png', NULL, NULL, 'teknik informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(194, 'delete', 'Tatang', '2021-01-08 08:03:43', '160511888', 'MTYwNTExODg4', 'mahasiswa888', 'profil.png', NULL, NULL, 'teknik informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(195, 'delete', 'Tatang', '2021-01-08 08:03:54', '160511999', 'MTYwNTExOTk5', 'mahasiswa999', 'profil.png', NULL, NULL, 'teknik informatika', '2016', NULL, 'Tidak Aktif', '-', '-', '-'),
(197, 'delete', 'Tatang', '2021-01-10 06:15:47', '160511070', '160577+9XTs=', 'Ahmad Fauzan', 'profil.png', 'Blok. Cemeti Ds. Kedokanbunder Wetan Rt/Rw 011/002 Kec. Kedokanbunder - Indramayu', '08999435314', 'Teknik Informatika', '2016', 'Indramayu,08 Agustus 1993', 'Aktif', 'Lulus', 'Lulus', '-');

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
(10, 13, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80),
(13, 12, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80);

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
(0, 0, 'Tatang', '2020-11-01 19:48:31', 6, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 0, 'Tatang', '2020-11-01 19:50:07', 6, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 0, 'Dian Novianti, M.Kom', '2020-11-25 04:46:02', 7, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 0, 'Tatang', '2020-11-25 04:47:05', 7, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 0, 'Tatang', '2020-12-15 21:19:36', 7, 10, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80),
(0, 0, 'Dian Novianti, M.Kom', '2020-12-20 19:33:36', 8, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 0, 'Tatang', '2020-12-20 19:36:51', 8, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 0, 'Dian Novianti, M.Kom', '2020-12-20 20:32:28', 9, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 0, 'Tatang', '2020-12-20 20:33:20', 9, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 0, 'Dian Novianti, M.Kom', '2020-12-21 01:12:02', 10, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 0, 'Tatang', '2020-12-27 15:58:00', 10, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 0, 'Tatang', '2020-12-28 16:36:01', 13, 12, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80),
(0, 0, 'Tatang', '2020-12-28 16:40:08', 13, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(0, 0, 'Tatang', '2020-12-28 16:40:28', 13, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(0, 0, 'Tatang', '2020-12-28 16:40:36', 13, 12, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80),
(0, 0, 'Tatang', '2020-12-28 16:46:00', 13, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(0, 0, 'Tatang', '2020-12-28 16:46:08', 13, 12, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 80),
(0, 0, 'Tatang', '2020-12-28 16:46:21', 13, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(0, 0, 'Tatang', '2020-12-28 16:46:58', 13, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(0, 0, 'Tatang', '2020-12-28 16:47:02', 13, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(0, 0, 'Tatang', '2020-12-28 16:47:04', 13, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(0, 0, 'Tatang', '2020-12-28 16:47:05', 13, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(0, 0, 'Tatang', '2020-12-28 16:47:12', 13, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(0, 0, 'Tatang', '2020-12-28 16:47:50', 13, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(0, 0, 'Tatang', '2020-12-28 16:55:49', 13, 12, 89, 98, 56, 67, 9, 98, 87, 56, 90, 87, 87, 89, 90, 90, 78, 89),
(0, 0, 'Tatang', '2020-12-28 16:55:58', 13, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(0, 0, 'Tatang', '2020-12-28 16:58:06', 13, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(0, 0, 'Tatang', '2020-12-28 17:03:50', 13, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(0, 0, 'Tatang', '2020-12-28 17:04:03', 13, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(0, 0, 'Tatang', '2020-12-28 17:04:11', 13, 12, 80, 80, 80, 80, 80, 80, 80, 80, 0, 80, 80, 80, 80, 80, 80, 80);

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
(64, 12, '0408118304', 'Penguji 1', 'Aktif', '2020-12-20 20:32:28'),
(65, 12, '0428117601', 'Penguji 2', 'Aktif', '2020-12-20 20:32:28'),
(66, 13, '0421117105', 'Penguji 1', 'Aktif', '2020-12-21 01:12:02'),
(67, 13, '0408118304', 'Penguji 2', 'Aktif', '2020-12-21 01:12:02');

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
(12, 50, 2, 'asdas', 2, 'asdadsa', '2020-12-28', '13:00', 'Lab Informatika', 'Lulus'),
(13, 1, 2, 'ok', 2, 'ok', '2020-12-21', '13:00', 'Lab Informatika', 'Lulus');

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
(1, 'insert', 'Mahasiswa 1', '2020-11-01 19:43:55', 9, 44, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(2, 'update', 'Dian Novianti, M.Kom', '2020-11-01 19:45:50', 9, 44, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(3, 'update', 'Harry Gunawan,M.Kom', '2020-11-01 19:46:06', 9, 44, 2, 'setuju', 0, NULL, NULL, NULL, NULL, NULL),
(4, 'update', 'Tatang', '2020-11-01 19:48:31', 9, 44, 2, 'setuju', 2, 'setuju', NULL, NULL, NULL, NULL),
(5, 'update', 'Tatang', '2020-11-01 19:50:07', 9, 44, 2, 'setuju', 2, 'setuju', '2020-11-02', '09:00', 'Lab Informatika', NULL),
(6, 'insert', 'Mahasiswa 1', '2020-11-23 07:14:20', 10, 45, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(7, 'update', 'Harry Gunawan,M.Kom', '2020-11-23 07:17:26', 10, 45, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(8, 'update', 'Dian Novianti, M.Kom', '2020-11-23 07:18:14', 10, 45, 2, 'asdsas', 0, NULL, NULL, NULL, NULL, NULL),
(9, 'update', 'Dian Novianti, M.Kom', '2020-11-23 07:18:23', 10, 45, 2, 'asdsas', 2, 'ok', NULL, NULL, NULL, NULL),
(10, 'update', 'Dian Novianti, M.Kom', '2020-11-23 07:18:28', 10, 45, 2, 'asdsas', 1, '123', NULL, NULL, NULL, NULL),
(11, 'update', 'Dian Novianti, M.Kom', '2020-11-25 04:46:02', 10, 45, 2, 'asdsas', 2, 'asdas', NULL, NULL, NULL, NULL),
(12, 'update', 'Tatang', '2020-11-25 04:47:05', 10, 45, 2, 'asdsas', 2, 'asdas', '2020-12-11', '11:11', 'Lab Informatika', NULL),
(13, 'update', 'Tatang', '2020-11-25 04:49:54', 10, 45, 2, 'asdsas', 2, 'asdas', '2020-12-11', '11:11', 'Lab Informatika', 'Lulus'),
(14, 'update', 'Tatang', '2020-12-15 21:19:36', 10, 45, 2, 'asdsas', 2, 'asdas', '2020-12-11', '00:00', 'Lab Informatika', 'Lulus'),
(15, 'insert', 'Mahasiswa1', '2020-12-20 19:27:55', 11, 49, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(16, 'update', 'Dian Novianti, M.Kom', '2020-12-20 19:31:10', 11, 49, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(17, 'update', 'Harry Gunawan,M.Kom', '2020-12-20 19:31:23', 11, 49, 2, 'ok', 0, NULL, NULL, NULL, NULL, NULL),
(18, 'update', 'Dian Novianti, M.Kom', '2020-12-20 19:33:36', 11, 49, 2, 'ok', 2, 'ok', NULL, NULL, NULL, NULL),
(19, 'update', 'Tatang', '2020-12-20 19:36:51', 11, 49, 2, 'ok', 2, 'ok', '2020-12-21', '00:00', 'Lab Informatika', NULL),
(20, 'insert', 'Mahasiswa 1', '2020-12-20 20:30:22', 12, 50, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(21, 'update', 'Dian Novianti, M.Kom', '2020-12-20 20:30:34', 12, 50, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(22, 'update', 'Agust Isa Martinus, M.T', '2020-12-20 20:30:44', 12, 50, 2, 'asdas', 0, NULL, NULL, NULL, NULL, NULL),
(23, 'update', 'Dian Novianti, M.Kom', '2020-12-20 20:32:28', 12, 50, 2, 'asdas', 2, 'asdadsa', NULL, NULL, NULL, NULL),
(24, 'update', 'Tatang', '2020-12-20 20:33:20', 12, 50, 2, 'asdas', 2, 'asdadsa', '2020-12-21', '11:00', 'Lab Informatika', NULL),
(25, 'insert', 'Mohamad Irfan Manaf', '2020-12-21 01:10:31', 13, 1, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(26, 'update', 'Agust Isa Martinus, M.T', '2020-12-21 01:10:47', 13, 1, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(27, 'update', 'Dr. Wahyu Triono, M.MPd', '2020-12-21 01:11:16', 13, 1, 2, 'ok', 0, NULL, NULL, NULL, NULL, NULL),
(28, 'update', 'Dian Novianti, M.Kom', '2020-12-21 01:12:02', 13, 1, 2, 'ok', 2, 'ok', NULL, NULL, NULL, NULL),
(29, 'update', 'Tatang', '2020-12-27 15:58:00', 13, 1, 2, 'ok', 2, 'ok', '2020-12-21', '13:00', 'Lab Informatika', NULL),
(30, 'update', 'Tatang', '2020-12-28 16:03:26', 12, 50, 2, 'asdas', 2, 'asdadsa', '2020-12-21', '11:00', 'Lab Informatika', 'Lulus'),
(31, 'update', 'Tatang', '2020-12-28 16:03:44', 12, 50, 2, 'asdas', 2, 'asdadsa', '2020-12-21', '11:00', 'Lab Informatika', 'Lulus'),
(32, 'update', 'Tatang', '2020-12-28 16:04:03', 12, 50, 2, 'asdas', 2, 'asdadsa', '2020-12-28', '11:00', 'Lab Informatika', 'Lulus'),
(33, 'update', 'Tatang', '2020-12-28 16:08:24', 12, 50, 2, 'asdas', 2, 'asdadsa', '2020-12-28', '11:00', 'Lab Informatika', 'Lulus'),
(34, 'update', 'Tatang', '2020-12-28 16:08:41', 12, 50, 2, 'asdas', 2, 'asdadsa', '2020-12-28', '11:00', 'Lab Informatika', 'Lulus'),
(35, 'update', 'Tatang', '2020-12-28 16:40:28', 12, 50, 2, 'asdas', 2, 'asdadsa', '2020-12-28', '11:00', 'Lab Informatika', 'Lulus'),
(36, 'update', 'Tatang', '2020-12-28 16:46:00', 12, 50, 2, 'asdas', 2, 'asdadsa', '2020-12-28', '11:00', 'Lab Informatika', 'Lulus'),
(37, 'update', 'Tatang', '2020-12-28 16:46:08', 12, 50, 2, 'asdas', 2, 'asdadsa', '2020-12-28', '11:00', 'Lab Informatika', 'Lulus'),
(38, 'update', 'Tatang', '2020-12-28 16:46:21', 12, 50, 2, 'asdas', 2, 'asdadsa', '2020-12-28', '11:00', 'Lab Informatika', 'Tidak Lulus'),
(39, 'update', 'Tatang', '2020-12-28 16:46:58', 12, 50, 2, 'asdas', 2, 'asdadsa', '2020-12-28', '11:00', 'Lab Informatika', 'Tidak Lulus'),
(40, 'update', 'Tatang', '2020-12-28 16:47:02', 12, 50, 2, 'asdas', 2, 'asdadsa', '2020-12-28', '11:00', 'Lab Informatika', 'Tidak Lulus'),
(41, 'update', 'Tatang', '2020-12-28 16:47:04', 12, 50, 2, 'asdas', 2, 'asdadsa', '2020-12-28', '11:00', 'Lab Informatika', 'Tidak Lulus'),
(42, 'update', 'Tatang', '2020-12-28 16:47:05', 12, 50, 2, 'asdas', 2, 'asdadsa', '2020-12-28', '11:00', 'Lab Informatika', 'Tidak Lulus'),
(43, 'update', 'Tatang', '2020-12-28 16:47:12', 12, 50, 2, 'asdas', 2, 'asdadsa', '2020-12-28', '11:00', 'Lab Informatika', 'Tidak Lulus'),
(44, 'update', 'Tatang', '2020-12-28 16:47:24', 12, 50, 2, 'asdas', 2, 'asdadsa', '2020-12-28', '11:00', 'Lab Informatika', 'Tidak Lulus'),
(45, 'update', 'Tatang', '2020-12-28 16:47:50', 12, 50, 2, 'asdas', 2, 'asdadsa', '2020-12-28', '11:00', 'Lab Informatika', 'Lulus'),
(46, 'update', 'Tatang', '2020-12-28 16:54:40', 12, 50, 2, 'asdas', 2, 'asdadsa', '2020-12-28', '11:00', 'Lab Informatika', 'Lulus'),
(47, 'update', 'Tatang', '2020-12-28 16:54:47', 12, 50, 2, 'asdas', 2, 'asdadsa', '2020-12-28', '11:00', 'Lab Peternakan', 'Lulus'),
(48, 'update', 'Tatang', '2020-12-28 16:54:55', 12, 50, 2, 'asdas', 2, 'asdadsa', '2020-12-28', '11:00', 'Lab Informatika', 'Lulus'),
(49, 'update', 'Tatang', '2020-12-28 16:55:49', 12, 50, 2, 'asdas', 2, 'asdadsa', '2020-12-28', '13:00', 'Lab Informatika', 'Lulus'),
(50, 'update', 'Tatang', '2020-12-28 16:55:58', 12, 50, 2, 'asdas', 2, 'asdadsa', '2020-12-28', '13:00', 'Lab Informatika', 'Tidak Lulus'),
(51, 'update', 'Tatang', '2020-12-28 16:56:21', 12, 50, 2, 'asdas', 2, 'asdadsa', '2020-12-28', '13:00', 'Lab Informatika', 'Tidak Lulus'),
(52, 'update', 'Tatang', '2020-12-28 16:56:27', 12, 50, 2, 'asdas', 2, 'asdadsa', '2020-12-28', '13:00', 'Lab Informatika', 'Tidak Lulus'),
(53, 'update', 'Tatang', '2020-12-28 16:56:32', 12, 50, 2, 'asdas', 2, 'asdadsa', '2020-12-28', '13:00', 'Lab Informatika', 'Tidak Lulus'),
(54, 'update', 'Tatang', '2020-12-28 16:58:06', 12, 50, 2, 'asdas', 2, 'asdadsa', '2020-12-28', '13:00', 'Lab Informatika', 'Lulus'),
(55, 'update', 'Tatang', '2020-12-28 17:03:50', 12, 50, 2, 'asdas', 2, 'asdadsa', '2020-12-28', '13:00', 'Lab Informatika', 'Tidak Lulus'),
(56, 'update', 'Tatang', '2020-12-28 17:04:03', 12, 50, 2, 'asdas', 2, 'asdadsa', '2020-12-28', '13:00', 'Lab Informatika', 'Tidak Lulus'),
(57, 'update', 'Tatang', '2020-12-28 17:04:11', 12, 50, 2, 'asdas', 2, 'asdadsa', '2020-12-28', '13:00', 'Lab Informatika', 'Lulus');

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
(3, '160511000-21-Dec-2020-03-30-22-c7f8b5ca27404a7094dd253e746ffccd.pdf', 2, '12'),
(4, '160511030-21-Dec-2020-08-10-31-c7f8b5ca27404a7094dd253e746ffccd.pdf', 2, '13');

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
(6, 'Perancangan Sistem Informasi Pengelolaan Praktik Kerja Lapangan', 'Dinas Komunikasi Informatika dan Statistik', '160511030-Contoh-File-Bimbingan.pdf', '160511030', '0', '160511030-Contoh-Lembar-REvisi.pdf'),
(8, 'Sistem Informasi Pengajuan Cuti Untuk Pegawai Non PNS', 'DISKOMINFO KAB. CIREBON', '160511030-Contoh-File-Bimbingan.pdf', '160511068', '8', '160511030-Lembar-Revisi-Contoh.pdf'),
(9, 'Sistem manajemen arsip', 'Disarpus kab. Cirebon', '160511030-Contoh-File-Bimbingan.pdf', '160511013', '3', '160511030-Lembar-Revisi-Contoh.pdf'),
(10, 'Sistem Informasi Monitoring Pembangunan Berbasis Web', 'Dinas Komunikasi Informatika dan Statistik Kota Cirebon', '160511030-Contoh-File-Bimbingan.pdf', '160511052', '2', '160511030-Lembar-Revisi-Contoh.pdf'),
(11, 'Pengelolaan Data COA..', 'PT.CMS ', '160511030-Contoh-File-Bimbingan.pdf', '160511001', '1', '160511030-Lembar-Revisi-Contoh.pdf'),
(12, 'Perancangan Sistem Pengelolaan Digitalisasi Berkas Pajak Berbasis Web', 'DKIS Kota Cirebon', '160511030-Contoh-File-Bimbingan.pdf', '160511064', '4', '160511030-Lembar-Revisi-Contoh.pdf'),
(13, 'Sistem informasi pengelolaan buku tamu', 'BPS Kabupaten Cirebon', '160511030-Contoh-File-Bimbingan.pdf', '160511006', '6', '160511030-Lembar-Revisi-Contoh.pdf'),
(14, 'rancang bangun aplikasi pengolahan data respon pendengar berbasis web', 'radio republik indonesia kota cirebon', '160511030-Contoh-File-Bimbingan.pdf', '160511060', '0', '160511030-Lembar-Revisi-Contoh.pdf'),
(15, 'Perancangam sistem pengelolaan dokumen arsip pribadi di dinas kearsipan dan perpustakaan kabupaten cirebon', 'Dinas kearsipan dan perpustakaan kabupaten cirebon', '160511030-Contoh-File-Bimbingan.pdf', '160511063', '3', '160511030-Lembar-Revisi-Contoh.pdf'),
(16, 'SI Buku Tamu Berbasis Web', 'DISKOMINFO KAB.Cirebon', '160511030-Contoh-File-Bimbingan.pdf', '160511055', '5', '160511030-Lembar-Revisi-Contoh.pdf'),
(17, 'Perancangan Sistem Informasi Pengaduan Gangguan Jaringan Intranet Pada Dinas Komunikasi dan Informatika Kabupaten Cirebon Berbasis Web', 'Dinas Komunikasi dan Informatika Kabupaten Cirebon', '160511030-Contoh-File-Bimbingan.pdf', '160511040', '0', '160511030-Lembar-Revisi-Contoh.pdf'),
(18, 'Sistem Informasi Trayek Angkutan Umum', 'Dinas Perhubungan Kota Cirebon', '160511030-Contoh-File-Bimbingan.pdf', '160511054', '4', '160511030-Lembar-Revisi-Contoh.pdf'),
(19, 'perancangan sistem pengolahan data peserta pkl di Dinas Kearsipan dan Perpustakaan Kabupaten Cirebon', 'Dinas Kearsipan dan Perpustakaan Kabupaten Cirebon', '160511030-Contoh-File-Bimbingan.pdf', '160511051', '1', '160511030-Lembar-Revisi-Contoh.pdf'),
(21, 'Perancangan Sistem Pengelolaan Retribusi Parkir Di Dinas Perhubungan Kota Cirebon', 'Dinas Perhubungan', '160511030-Contoh-File-Bimbingan.pdf', '160511031', '1', '160511030-Lembar-Revisi-Contoh.pdf'),
(23, 'Perancangan sistem pengelolaan surat berbasis web pada badan pusat statistik kab. Cirebon', 'Badan Pusat Statistik Kabupaten Cirebon', '160511030-Contoh-File-Bimbingan.pdf', '160511026', '6', '160511030-Lembar-Revisi-Contoh.pdf'),
(24, 'Perancangan sistem informasi pengolahan data cuti pegawai berbasis web', 'Dinas kearsipan dan perpustakaan kabupaten cirebon', '160511030-Contoh-File-Bimbingan.pdf', '160511039', '9', '160511030-Lembar-Revisi-Contoh.pdf'),
(25, 'Aplikasi pelayanan prima berbasis android', 'Dinas perhubungan', '160511030-Contoh-File-Bimbingan.pdf', '160511053', '3', '160511030-Lembar-Revisi-Contoh.pdf'),
(26, 'Perancangan sistem informasi pencatatan arsip surat masuk dan surat keluar pada kantor kepala desa ciwiru', 'Kantor kepala desa ciwiru', '160511030-Contoh-File-Bimbingan.pdf', '160511009', '9', '160511030-Lembar-Revisi-Contoh.pdf'),
(42, 'Judul 1', 'Instansi 2', '160511000-21-Dec-2020-03-05-58-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511000', '0', '160511000-21-Dec-2020-03-14-13-c7f8b5ca27404a7094dd253e746ffccd.pdf');

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
(1, 6, 'Bimbingan Laporan PKL', 'Bimbingan Laporan PKL12312w', '2020-09-21', 160511030, '0421117105', '160511030-Contoh-File-Bimbingan.pdf', '0421117105-Contoh-File-Hasil_Bimbingan.pdf', 'Revisi judul laporan', 'Bimbingan Laporan', 'Dibalas', 'Dibaca', 'Revisi'),
(2, 6, 'Bimbingan Bab 1', 'Bimbingan Laporan PKL', '2020-09-21', 160511030, '0421117105', '160511030-Contoh-File-Bimbingan.pdf', '0421117105-Contoh-File-Hasil_Bimbingan.pdf', 'laatar belakang, rumusan masalah, batasan masalah, dan identifikasi masalah', 'Bimbingan Laporan', 'Dibalas', 'Dibaca', 'Revisi'),
(3, 6, 'Menyerahkan Revisi dan Bimbingan Laporan', 'Menyerahkan Revisi dan Bimbingan Laporan', '2020-09-21', 160511030, '0421117105', '160511030-Contoh-File-Bimbingan.pdf', '0421117105-Contoh-File-Hasil_Bimbingan.pdf', 'Lanjut ke bab selanjutnya', 'Bimbingan Laporan', 'Dibalas', 'Dibaca', 'Lanjut BAB'),
(4, 6, 'Bimbingan bab 2', 'bimbingan laporan pkl', '2020-09-21', 160511030, '0421117105', '160511030-Contoh-File-Bimbingan.pdf', '0421117105-Contoh-File-Hasil_Bimbingan.pdf', 'Bab 2', 'Bimbingan Laporan', 'Dibalas', 'Dibaca', 'Lanjut BAB'),
(5, 6, 'Bimbingan Bab 3', 'Bimbingan laporan pkl', '2020-09-21', 160511030, '0421117105', '160511030-Contoh-File-Bimbingan.pdf', '0421117105-Contoh-File-Hasil_Bimbingan.pdf', 'bab 3', 'Bimbingan Laporan', 'Dibalas', 'Dibaca', 'Lanjut BAB'),
(6, 6, 'Bimbingan Bab 4 & 5', 'Bimbingan laporan pkl', '2020-09-21', 160511030, '0421117105', '160511030-Contoh-File-Bimbingan.pdf', '0421117105-Contoh-File-Hasil_Bimbingan.pdf', 'Revsi bab 4 dan 5', 'Bimbingan Laporan', 'Dibalas', 'Dibaca', 'Revisi'),
(7, 6, 'Menyerahkan Revisi Bab 4 & 5', 'Bimbingan laporan pkl', '2020-09-21', 160511030, '0421117105', '160511030-Contoh-File-Bimbingan.pdf', '0421117105-Contoh-File-Hasil_Bimbingan.pdf', 'Silahkan daftar sidang pkl', 'Bimbingan Laporan', 'Dibalas', 'Dibaca', 'Layak'),
(8, 6, 'Bimbingan Revisi Pasca Sidang PKl', 'Bimbingan Revisi Pasca Sidang PKl', '2020-09-21', 160511030, '0403079201', '160511030-Contoh-File-Bimbingan.pdf', '0403079201-Contoh-File-Hasil_Bimbingan.pdf', 'diterima, silahkan cetak laporan', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Layak'),
(9, 11, 'Bimbingan Laporan', 'Bimbingan Laporan PKL', '2020-09-21', 160511001, '0409046101', '160511001-Contoh-File-Bimbingan.pdf', '0409046101-Contoh-File-Hasil_Bimbingan.pdf', 'Silahkan daftar sidang', 'Bimbingan Laporan', 'Dibalas', 'Dibaca', 'Layak'),
(10, 11, 'Bimbingan Pasca Sidang PKL', 'Bimbingan Pasca Sidang PKL', '2020-09-21', 160511001, '0402057307', '160511001-Contoh-File-Bimbingan.pdf', '0402057307-Contoh-File-Hasil_Bimbingan.pdf', 'Silahkan cetak dan kumpulkan ok', 'Bimbingan Pasca', 'Dibalas', 'Belum Dibaca', 'Layak'),
(11, 13, 'Bimbingan Laporan PKL', 'Bimbingan Laporan PKL', '2020-09-21', 160511006, '0406067407', '160511006-Contoh-File-Bimbingan.pdf', '0406067407-Contoh-File-Hasil_Bimbingan.pdf', 'Silahkan Sidang', 'Bimbingan Laporan', 'Dibalas', 'Dibaca', 'Layak'),
(12, 13, 'Bimbingan Pasca Sidang PKL', 'Bimbingan Pasca Sidang PKL', '2020-09-21', 160511006, '0416086408', '160511006-Contoh-File-Bimbingan.pdf', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'sialhakn cetak123', 'Bimbingan Pasca', 'Dibalas', 'Belum Dibaca', 'Layak'),
(13, 26, 'Bimbingan Laporan', 'Bimbingan Laporan', '2020-09-21', 160511009, '0416086408', '160511030-Contoh-File-Bimbingan.pdf', '0403079201-Contoh-File-Hasil_Bimbingan.pdf', 'Sidang', 'Bimbingan Laporan', 'Dibalas', 'Dibaca', 'Layak'),
(14, 26, 'Bimbingan Pasca Sdainga', 'Bimbingan Pasca Sdainga', '2020-09-21', 160511009, '0408118304', '160511030-Contoh-File-Bimbingan.pdf', '0403079201-Contoh-File-Hasil_Bimbingan.pdf', 'Cetak', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Layak'),
(15, 9, 'Bimbingan Laporan PKL', 'Bimbingan Laporan PKL', '2020-09-21', 160511013, '0428117601', '160511013-Contoh-File-Bimbingan.pdf', '0428117601-Contoh-File-Hasil_Bimbingan.pdf', 'Daftar Sidang', 'Bimbingan Laporan', 'Dibalas', 'Dibaca', 'Layak'),
(16, 9, 'Bimbingan Pasca Sidang PKL', 'Bimbingan Pasca Sidang PKL', '2020-09-21', 160511013, '0406067407', '160511013-Contoh-File-Bimbingan.pdf', '0406067407-Contoh-File-Hasil_Bimbingan.pdf', 'Cetak', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Layak'),
(17, 23, 'Bimbingan Laporan', 'Bimbingan Laporan', '2020-09-21', 160511026, '0406067407', 'Contoh-File-Bimbingan.pdf', 'Contoh-File-Bimbingan.pdf', 'Daftar Sidang', 'Bimbingan Laporan', 'Dibalas', 'Dibaca', 'Layak'),
(18, 21, 'Bimbingan Laporan', 'Bimbingan Laporan', '2020-09-21', 160511031, '0409046101', 'Contoh-File-BImbingan.pdf', 'Contoh-File-BImbingan.pdf', 'Daftar Sidang', 'Bimbingan Laporan', 'Dibalas', 'Dibaca', 'Layak'),
(19, 8, 'Bimbingan Laporan', 'Bimbingan Laporan', '2020-09-21', 160511068, '0407039501', 'Contoh-File-BImbingan.pdf', 'Contoh-File-BImbingan.pdf', 'Daftar Sidang', 'Bimbingan Laporan', 'Dibalas', 'Dibaca', 'Layak'),
(20, 10, 'Bimbingan Laporan', 'Bimbingan Laporan', '2020-09-21', 160511052, '0408118304', 'Contoh-File-BImbingan.pdf', 'Contoh-File-BImbingan.pdf', 'Daftar Sidang', 'Bimbingan Laporan', 'Dibalas', 'Dibaca', 'Layak'),
(21, 12, 'Bimbingan Laporan', 'Bimbingan Laporan', '2020-09-21', 160511064, '0402057307', 'Contoh-File-BImbingan.pdf', 'Contoh-File-BImbingan.pdf', 'Daftar Sidang', 'Bimbingan Laporan', 'Dibalas', 'Dibaca', 'Layak'),
(22, 14, 'Bimbingan Laporan', 'Bimbingan Laporan', '2020-09-21', 160511060, '0421117105', 'Contoh-File-BImbingan.pdf', 'Contoh-File-BImbingan.pdf', 'Daftar Sidang', 'Bimbingan Laporan', 'Dibalas', 'Dibaca', 'Layak'),
(23, 15, 'Bimbingan Laporan', 'Bimbingan Laporan', '2020-09-21', 160511063, '0428117601', 'Contoh-File-BImbingan.pdf', 'Contoh-File-BImbingan.pdf', 'Daftar Sidang', 'Bimbingan Laporan', 'Dibalas', 'Dibaca', 'Layak'),
(24, 16, 'Bimbingan Laporan', 'Bimbingan Laporan', '2020-09-21', 160511055, '0403079201', 'Contoh-File-BImbingan.pdf', 'Contoh-File-BImbingan.pdf', 'Daftar Sidang', 'Bimbingan Laporan', 'Dibalas', 'Dibaca', 'Layak'),
(25, 17, 'Bimbingan Laporan', 'Bimbingan Laporan', '2020-09-21', 160511040, '0421117105', 'Contoh-File-BImbingan.pdf', 'Contoh-File-BImbingan.pdf', 'Daftar Sidang', 'Bimbingan Laporan', 'Dibalas', 'Dibaca', 'Layak'),
(26, 18, 'Bimbingan Laporan', 'Bimbingan Laporan', '2020-09-21', 160511054, '0402057307', 'Contoh-File-BImbingan.pdf', 'Contoh-File-BImbingan.pdf', 'Daftar Sidang ok', 'Bimbingan Laporan', 'Dibalas', 'Belum Dibaca', 'Layak'),
(27, 19, 'Bimbingan Laporan', 'Bimbingan Laporan', '2020-09-21', 160511051, '0409046101', 'Contoh-File-BImbingan.pdf', 'Contoh-File-BImbingan.pdf', 'Daftar Sidang', 'Bimbingan Laporan', 'Dibalas', 'Dibaca', 'Layak'),
(29, 24, 'Bimbingan Laporan', 'Bimbingan Laporan', '2020-09-21', 160511039, '0416086408', 'Contoh-File-BImbingan.pdf', 'Contoh-File-BImbingan.pdf', 'Daftar Sidang123', 'Bimbingan Laporan', 'Dibalas', 'Belum Dibaca', 'Layak'),
(30, 8, 'Bimbingan Revisi Pasca Sidang PKl', 'Bimbingan Revisi Pasca Sidang PKl', '2020-09-21', 160511068, '0403079201', '160511030-Contoh-File-Bimbingan.pdf', '0403079201-Contoh-File-Hasil_Bimbingan.pdf', 'diterima, silahkan cetak laporan', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Layak'),
(31, 10, 'Bimbingan Revisi Pasca Sidang PKl', 'Bimbingan Revisi Pasca Sidang PKl', '2020-09-21', 160511052, '0416086408', '160511030-Contoh-File-Bimbingan.pdf', '0403079201-Contoh-File-Hasil_Bimbingan.pdf', 'diterima, silahkan cetak laporan', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Layak'),
(32, 12, 'Bimbingan Revisi Pasca Sidang PKl', 'Bimbingan Revisi Pasca Sidang PKl', '2020-09-21', 160511064, '0416086408', '160511030-Contoh-File-Bimbingan.pdf', '0403079201-Contoh-File-Hasil_Bimbingan.pdf', 'diterima, silahkan cetak laporan', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Layak'),
(33, 14, 'Bimbingan Revisi Pasca Sidang PKl', 'Bimbingan Revisi Pasca Sidang PKl', '2020-09-21', 160511060, '0406067407', '160511030-Contoh-File-Bimbingan.pdf', '0403079201-Contoh-File-Hasil_Bimbingan.pdf', 'diterima, silahkan cetak laporan', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Layak'),
(34, 15, 'Bimbingan Revisi Pasca Sidang PKl', 'Bimbingan Revisi Pasca Sidang PKl', '2020-09-21', 160511060, '0405108905', '160511030-Contoh-File-Bimbingan.pdf', '0403079201-Contoh-File-Hasil_Bimbingan.pdf', 'diterima, silahkan cetak laporan', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Layak'),
(35, 16, 'Bimbingan Revisi Pasca Sidang PKl', 'Bimbingan Revisi Pasca Sidang PKl', '2020-09-21', 160511055, '0421117105', '160511030-Contoh-File-Bimbingan.pdf', '0403079201-Contoh-File-Hasil_Bimbingan.pdf', 'diterima, silahkan cetak laporan', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Layak'),
(36, 17, 'Bimbingan Revisi Pasca Sidang PKl', 'Bimbingan Revisi Pasca Sidang PKl', '2020-09-21', 160511040, '0402057307', '160511030-Contoh-File-Bimbingan.pdf', '0403079201-Contoh-File-Hasil_Bimbingan.pdf', 'diterima, silahkan cetak laporan', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Layak'),
(37, 18, 'Bimbingan Revisi Pasca Sidang PKl', 'Bimbingan Revisi Pasca Sidang PKl', '2020-09-21', 160511054, '0403079201', '160511030-Contoh-File-Bimbingan.pdf', '0403079201-Contoh-File-Hasil_Bimbingan.pdf', 'diterima, silahkan cetak laporan', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Layak'),
(38, 19, 'Bimbingan Revisi Pasca Sidang PKl', 'Bimbingan Revisi Pasca Sidang PKl', '2020-09-21', 160511051, '0416086408', '160511030-Contoh-File-Bimbingan.pdf', '0403079201-Contoh-File-Hasil_Bimbingan.pdf', 'diterima, silahkan cetak laporan', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Layak'),
(39, 21, 'Bimbingan Revisi Pasca Sidang PKl', 'Bimbingan Revisi Pasca Sidang PKl', '2020-09-21', 160511031, '0408118304', '160511030-Contoh-File-Bimbingan.pdf', '0403079201-Contoh-File-Hasil_Bimbingan.pdf', 'diterima, silahkan cetak laporan', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Layak'),
(41, 23, 'Bimbingan Revisi Pasca Sidang PKl', 'Bimbingan Revisi Pasca Sidang PKl', '2020-09-21', 160511026, '0408118304', '160511030-Contoh-File-Bimbingan.pdf', '0403079201-Contoh-File-Hasil_Bimbingan.pdf', 'diterima, silahkan cetak laporan', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Layak'),
(42, 24, 'Bimbingan Revisi Pasca Sidang PKl', 'Bimbingan Revisi Pasca Sidang PKl', '2020-09-21', 160511039, '0421117105', '160511030-Contoh-File-Bimbingan.pdf', '0421117105-Contoh-Lembar-REvisi.pdf', 'diterima, silahkan cetak laporan13', 'Bimbingan Pasca', 'Dibalas', 'Belum Dibaca', 'Layak'),
(43, 25, 'Bimbingan Revisi Pasca Sidang PKl', 'Bimbingan Revisi Pasca Sidang PKl', '2020-09-21', 160511053, '0421117105', '160511030-Contoh-File-Bimbingan.pdf', '0403079201-Contoh-File-Hasil_Bimbingan.pdf', 'diterima, silahkan cetak laporan', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Layak'),
(44, 26, 'Bimbingan Revisi Pasca Sidang PKl', 'Bimbingan Revisi Pasca Sidang PKl', '2020-09-21', 160511009, '0408118304', '160511030-Contoh-File-Bimbingan.pdf', '0403079201-Contoh-File-Hasil_Bimbingan.pdf', 'diterima, silahkan cetak laporan', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Layak'),
(45, 6, 'Bimbingan Bab 1', 'Bimbingan Bab 2', '2020-09-22', 160511030, '0421117105', '160511030-Contoh-File-Bimbingan.pdf', '0421117105-Contoh-File-Laporan.pdf', 'Ganti Saran Lagi12', 'Bimbingan Laporan', 'Dibalas', 'Dibaca', 'Layak'),
(46, 6, 'Bab 1-4', 'adas', '2020-09-22', 160511030, '0421117105', '160511030-Contoh-File-Bimbingan.pdf', '0421117105-Contoh-File-Hasil_Bimbingan.pdf', 'a', 'Bimbingan Laporan', 'Dibalas', 'Dibaca', 'Lanjut BAB'),
(47, 6, 'Bab 1-4', 'adas', '2020-09-22', 160511030, '0421117105', '160511030-Contoh-File-Bimbingan.pdf', '0421117105-Contoh-File-Hasil_Bimbingan.pdf', 'a', 'Bimbingan Laporan', 'Dibalas', 'Dibaca', 'Revisi'),
(48, 6, 'Bab 1-4', 'adas', '2020-09-22', 160511030, '0421117105', '160511030-Contoh-File-Bimbingan.pdf', '0421117105-Contoh-File-Hasil_Bimbingan.pdf', 'a', 'Bimbingan Laporan', 'Dibalas', 'Dibaca', 'Layak'),
(49, 6, 'Bab 1-4', 'a', '2020-09-22', 160511030, '0403079201', '160511030-Contoh-File-Bimbingan.pdf', '0403079201-Contoh-File-Hasil_Bimbingan.pdf', 'asdasd', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Layak'),
(76, 42, 'asd', 'asd', '2020-12-21', 160511000, '0421117105', '160511000-2020-12-21-03-06-12-Contoh-File-Bimbingan.pdf', '0421117105-21-Dec-2020-03-07-02-Contoh-File-Hasil_Bimbingan.pdf', 'asdas', 'Bimbingan Laporan', 'Dibalas', 'Dibaca', 'Layak'),
(77, 42, 'asda', 'asda', '2020-12-21', 160511000, '0416086408', '160511000-21-Dec-2020-03-14-22-Contoh-File-Bimbingan.pdf', '0416086408-21-Dec-2020-03-14-44-Contoh-File-Hasil_Bimbingan.pdf', 'asda', 'Bimbingan Pasca', 'Dibalas', 'Belum Dibaca', 'Layak'),
(78, 42, 'adsa', 'asda', '2020-12-26', 160511000, '0421117105', '160511000-2020-12-26-02-30-23-Contoh-File-Bimbingan.pdf', NULL, NULL, 'Bimbingan Laporan', 'Belum Dibaca', NULL, NULL);

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
(1, 'insert', 'Mahasiswa 1', '2020-11-01 18:37:02', 64, 38, 'Bab 1', 'Bimbingan Bab 1', '2020-11-02', 160511000, '0421117105', '160511000-Contoh-File-Bimbingan.pdf', NULL, NULL, 'Bimbingan Laporan', 'Belum Dibaca', NULL, NULL),
(2, 'update', 'Dian Novianti, M.Kom', '2020-11-01 18:38:06', 64, 38, 'Bab 1', 'Bimbingan Bab 1', '2020-11-02', 160511000, '0421117105', '160511000-Contoh-File-Bimbingan.pdf', NULL, NULL, 'Bimbingan Laporan', 'Belum Dibaca', NULL, NULL),
(3, 'update', 'Mahasiswa 1', '2020-11-01 18:39:18', 64, 38, 'Bab 1', 'Bimbingan Bab 1', '2020-11-02', 160511000, '0421117105', '160511000-Contoh-File-Bimbingan.pdf', '0421117105-Contoh-File-Hasil_Bimbingan.pdf', 'Daftar Sidang', 'Bimbingan Laporan', 'Dibalas', 'Belum Dibaca', 'Layak'),
(4, 'insert', 'Mahasiswa 1', '2020-11-01 18:52:17', 65, 38, 'Bab 1', 'Babb 1', '2020-11-02', 160511000, '0408118304', '160511000-Contoh-File-Hasil_Bimbingan.pdf', NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', NULL, NULL),
(5, 'update', 'Harry Gunawan,M.Kom', '2020-11-01 18:52:43', 65, 38, 'Bab 1', 'Babb 1', '2020-11-02', 160511000, '0408118304', '160511000-Contoh-File-Hasil_Bimbingan.pdf', NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', NULL, NULL),
(6, 'update', 'Mahasiswa 1', '2020-11-01 18:53:43', 65, 38, 'Bab 1', 'Babb 1', '2020-11-02', 160511000, '0408118304', '160511000-Contoh-File-Hasil_Bimbingan.pdf', '0408118304-Contoh-File-Hasil_Bimbingan.pdf', 'Setuju', 'Bimbingan Pasca', 'Dibalas', 'Belum Dibaca', 'Layak'),
(7, 'insert', 'Mahasiswa 1', '2020-11-02 03:23:07', 66, 39, 'bab 1', 'bab1', '2020-11-02', 160511000, '0421117105', '160511000-Contoh-File-Bimbingan.pdf', NULL, NULL, 'Bimbingan Laporan', 'Belum Dibaca', NULL, NULL),
(8, 'update', 'Dian Novianti, M.Kom', '2020-11-02 03:23:29', 66, 39, 'bab 1', 'bab1', '2020-11-02', 160511000, '0421117105', '160511000-Contoh-File-Bimbingan.pdf', NULL, NULL, 'Bimbingan Laporan', 'Belum Dibaca', NULL, NULL),
(9, 'insert', 'Mahasiswa 1', '2020-11-02 03:26:01', 67, 39, 'bab 1', 'bab 1', '2020-11-02', 160511000, '0416086408', '160511000-Contoh-File-Bimbingan.pdf', NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', NULL, NULL),
(10, 'update', 'Agust Isa Martinus, M.T', '2020-11-02 03:26:24', 67, 39, 'bab 1', 'bab 1', '2020-11-02', 160511000, '0416086408', '160511000-Contoh-File-Bimbingan.pdf', NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', NULL, NULL),
(11, 'insert', 'Mahasiswa 1', '2020-11-09 07:56:35', 68, 39, 'asdas', 'asda', '2020-11-09', 160511000, '0421117105', '160511000-Rencana Pengujian Sidang Draft.docx', NULL, NULL, 'Bimbingan Laporan', 'Belum Dibaca', NULL, NULL),
(12, 'insert', 'Mahasiswa 1', '2020-11-09 08:12:10', 69, 39, 'asdaasd', 'asdas', '2020-11-09', 160511000, '0421117105', '160511000-DRAFT SIAP SIDANG.docx', NULL, NULL, 'Bimbingan Laporan', 'Belum Dibaca', NULL, NULL),
(13, 'insert', 'Mahasiswa 1', '2020-11-09 08:33:01', 70, 39, 'asdas', 'asdas', '2020-11-09', 160511000, '0421117105', '160511000-2020-11-09-03-33-01-DRAFT SIAP SIDANG-min.pdf', NULL, NULL, 'Bimbingan Laporan', 'Belum Dibaca', NULL, NULL),
(14, 'update', 'Mahasiswa 1', '2020-11-10 05:30:24', 68, 39, 'asdas', 'asda', '2020-11-09', 160511000, '0421117105', '160511000-Rencana Pengujian Sidang Draft.docx', NULL, NULL, 'Bimbingan Laporan', 'Belum Dibaca', NULL, NULL),
(15, 'update', 'Dian Novianti, M.Kom', '2020-11-10 14:50:45', 68, 39, 'asdas', 'asda', '2020-11-09', 160511000, '0421117105', '160511000-2020-11-10-12-30-24-160511000-2020-11-09-03-33-01-DRAFT SIAP SIDANG-min.pdf', NULL, NULL, 'Bimbingan Laporan', 'Belum Dibaca', NULL, NULL),
(16, 'insert', 'Mahasiswa 1', '2020-11-22 15:47:22', 71, 39, 'asdsa', 'asdas', '2020-11-22', 160511000, '0408118304', '160511000-22-Nov-2020-10-47-22-Contoh-File-Hasil_Bimbingan.pdf', NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', NULL, NULL),
(17, 'update', 'Harry Gunawan,M.Kom', '2020-11-22 15:55:52', 71, 39, 'asdsa', 'asdas', '2020-11-22', 160511000, '0408118304', '160511000-22-Nov-2020-10-47-22-Contoh-File-Hasil_Bimbingan.pdf', NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', NULL, NULL),
(18, 'update', 'Harry Gunawan,M.Kom', '2020-11-22 16:04:35', 71, 39, 'asdsa', 'asdas', '2020-11-22', 160511000, '0408118304', '160511000-22-Nov-2020-10-47-22-Contoh-File-Hasil_Bimbingan.pdf', '0408118304-22-Nov-2020-10-55-52-Contoh-File-Hasil_Bimbingan.pdf', 'ok', 'Bimbingan Pasca', 'Dibalas', 'Belum Dibaca', 'Layak'),
(19, 'update', 'Mahasiswa 1', '2020-11-22 16:04:59', 71, 39, 'asdsa', 'asdas', '2020-11-22', 160511000, '0408118304', '160511000-22-Nov-2020-10-47-22-Contoh-File-Hasil_Bimbingan.pdf', '0408118304-22-Nov-2020-10-55-52-Contoh-File-Hasil_Bimbingan.pdf', 'ok123', 'Bimbingan Pasca', 'Dibalas', 'Belum Dibaca', 'Layak'),
(20, 'update', 'Mahasiswa 1', '2020-11-22 16:06:37', 68, 39, 'asdas', 'asda', '2020-11-09', 160511000, '0421117105', '160511000-2020-11-10-12-30-24-160511000-2020-11-09-03-33-01-DRAFT SIAP SIDANG-min.pdf', '0421117105-DRAFT SIAP SIDANG-min.pdf', 'asdasda', 'Bimbingan Laporan', 'Dibalas', 'Belum Dibaca', 'Layak'),
(21, 'update', 'Freddy Wicaksono, M.Kom', '2020-12-14 01:25:13', 10, 11, 'Bimbingan Pasca Sidang PKL', 'Bimbingan Pasca Sidang PKL', '2020-09-21', 160511001, '0402057307', '160511001-Contoh-File-Bimbingan.pdf', '0402057307-Contoh-File-Hasil_Bimbingan.pdf', 'Silahkan cetak dan kumpulkan', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Layak'),
(22, 'update', 'Freddy Wicaksono, M.Kom', '2020-12-14 01:34:58', 26, 18, 'Bimbingan Laporan', 'Bimbingan Laporan', '2020-09-21', 160511054, '0402057307', 'Contoh-File-BImbingan.pdf', 'Contoh-File-BImbingan.pdf', 'Daftar Sidang', 'Bimbingan Laporan', 'Dibalas', 'Dibaca', 'Layak'),
(23, 'update', 'Dian Novianti, M.Kom', '2020-12-14 02:23:01', 69, 39, 'asdaasd', 'asdas', '2020-11-09', 160511000, '0421117105', '160511000-DRAFT SIAP SIDANG.docx', NULL, NULL, 'Bimbingan Laporan', 'Belum Dibaca', NULL, NULL),
(24, 'update', 'Agust Isa Martinus, M.T', '2020-12-15 19:14:46', 12, 13, 'Bimbingan Pasca Sidang PKL', 'Bimbingan Pasca Sidang PKL', '2020-09-21', 160511006, '0416086408', '160511006-Contoh-File-Bimbingan.pdf', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'sialhakn cetak', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Layak'),
(25, 'update', 'Agust Isa Martinus, M.T', '2020-12-15 19:49:51', 29, 24, 'Bimbingan Laporan', 'Bimbingan Laporan', '2020-09-21', 160511039, '0416086408', 'Contoh-File-BImbingan.pdf', 'Contoh-File-BImbingan.pdf', 'Daftar Sidang', 'Bimbingan Laporan', 'Dibalas', 'Dibaca', 'Layak'),
(26, 'update', 'Agust Isa Martinus, M.T', '2020-12-15 20:09:27', 12, 13, 'Bimbingan Pasca Sidang PKL', 'Bimbingan Pasca Sidang PKL', '2020-09-21', 160511006, '0416086408', '160511006-Contoh-File-Bimbingan.pdf', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'sialhakn cetak1', 'Bimbingan Pasca', 'Dibalas', 'Belum Dibaca', 'Layak'),
(27, 'insert', 'Mahasiswa 1', '2020-12-19 10:39:54', 72, 40, 'Bimbingan 1', 'Deskripsi bimbingan 1', '2020-12-19', 160511000, '0421117105', '160511000-2020-12-19-05-39-54-Contoh-File-Bimbingan.pdf', NULL, NULL, 'Bimbingan Laporan', 'Belum Dibaca', NULL, NULL),
(28, 'update', 'Dian Novianti, M.Kom', '2020-12-19 10:41:38', 72, 40, 'Bimbingan 1', 'Deskripsi bimbingan 1', '2020-12-19', 160511000, '0421117105', '160511000-2020-12-19-05-39-54-Contoh-File-Bimbingan.pdf', NULL, NULL, 'Bimbingan Laporan', 'Belum Dibaca', NULL, NULL),
(29, 'update', 'Mahasiswa 1', '2020-12-19 10:41:56', 72, 40, 'Bimbingan 1', 'Deskripsi bimbingan 1', '2020-12-19', 160511000, '0421117105', '160511000-2020-12-19-05-39-54-Contoh-File-Bimbingan.pdf', '0421117105-19-Dec-2020-05-41-38-Contoh-File-Hasil_Bimbingan.pdf', 'Ini Hasil Bimbingan', 'Bimbingan Laporan', 'Dibalas', 'Belum Dibaca', 'Layak'),
(30, 'insert', 'Mahasiswa 1', '2020-12-19 10:47:29', 73, 40, 'Bimbingan 1', 'Bimbingan Pasca Sidang PKl', '2020-12-19', 160511000, '0416086408', '160511000-19-Dec-2020-05-47-29-Contoh-File-Bimbingan.pdf', NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', NULL, NULL),
(31, 'update', 'Agust Isa Martinus, M.T', '2020-12-19 10:55:38', 73, 40, 'Bimbingan 1', 'Bimbingan Pasca Sidang PKl', '2020-12-19', 160511000, '0416086408', '160511000-19-Dec-2020-05-47-29-Contoh-File-Bimbingan.pdf', NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', NULL, NULL),
(32, 'update', 'Agust Isa Martinus, M.T', '2020-12-19 10:55:53', 73, 40, 'Bimbingan 1', 'Bimbingan Pasca Sidang PKl', '2020-12-19', 160511000, '0416086408', '160511000-19-Dec-2020-05-47-29-Contoh-File-Bimbingan.pdf', '0416086408-19-Dec-2020-05-55-38-Contoh-File-Hasil_Bimbingan.pdf', 'oke setuju', 'Bimbingan Pasca', 'Dibalas', 'Belum Dibaca', ''),
(33, 'update', 'Mahasiswa 1', '2020-12-19 10:57:37', 73, 40, 'Bimbingan 1', 'Bimbingan Pasca Sidang PKl', '2020-12-19', 160511000, '0416086408', '160511000-19-Dec-2020-05-47-29-Contoh-File-Bimbingan.pdf', '0416086408-19-Dec-2020-05-55-38-Contoh-File-Hasil_Bimbingan.pdf', 'oke setuju', 'Bimbingan Pasca', 'Dibalas', 'Belum Dibaca', 'Layak'),
(34, 'insert', 'Mahasiswa1', '2020-12-20 16:57:36', 74, 41, 'Bimbingan 1', 'Bim 1', '2020-12-20', 160511000, '0421117105', '160511000-2020-12-20-11-57-36-Contoh-File-Bimbingan.pdf', NULL, NULL, 'Bimbingan Laporan', 'Belum Dibaca', NULL, NULL),
(35, 'update', 'Dian Novianti, M.Kom', '2020-12-20 16:58:53', 74, 41, 'Bimbingan 1', 'Bim 1', '2020-12-20', 160511000, '0421117105', '160511000-2020-12-20-11-57-36-Contoh-File-Bimbingan.pdf', NULL, NULL, 'Bimbingan Laporan', 'Belum Dibaca', NULL, NULL),
(36, 'update', 'Mahasiswa1', '2020-12-20 16:59:41', 74, 41, 'Bimbingan 1', 'Bim 1', '2020-12-20', 160511000, '0421117105', '160511000-2020-12-20-11-57-36-Contoh-File-Bimbingan.pdf', '0421117105-20-Dec-2020-11-58-53-Contoh-File-Hasil_Bimbingan.pdf', 'setuju, silahkan daftar sidang', 'Bimbingan Laporan', 'Dibalas', 'Belum Dibaca', 'Layak'),
(37, 'insert', 'Mahasiswa1', '2020-12-20 17:06:10', 75, 41, 'Bimbingan 1', 'Bim 1', '2020-12-21', 160511000, '0408118304', '160511000-21-Dec-2020-12-06-10-Contoh-File-Bimbingan.pdf', NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', NULL, NULL),
(38, 'update', 'Harry Gunawan,M.Kom', '2020-12-20 17:07:13', 75, 41, 'Bimbingan 1', 'Bim 1', '2020-12-21', 160511000, '0408118304', '160511000-21-Dec-2020-12-06-10-Contoh-File-Bimbingan.pdf', NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', NULL, NULL),
(39, 'update', 'Mahasiswa1', '2020-12-20 17:08:01', 75, 41, 'Bimbingan 1', 'Bim 1', '2020-12-21', 160511000, '0408118304', '160511000-21-Dec-2020-12-06-10-Contoh-File-Bimbingan.pdf', '0408118304-21-Dec-2020-12-07-13-Contoh-File-Hasil_Bimbingan.pdf', 'setuju', 'Bimbingan Pasca', 'Dibalas', 'Belum Dibaca', 'Layak'),
(40, 'insert', 'Mahasiswa 1', '2020-12-20 20:06:12', 76, 42, 'asd', 'asd', '2020-12-21', 160511000, '0421117105', '160511000-2020-12-21-03-06-12-Contoh-File-Bimbingan.pdf', NULL, NULL, 'Bimbingan Laporan', 'Belum Dibaca', NULL, NULL),
(41, 'update', 'Dian Novianti, M.Kom', '2020-12-20 20:07:02', 76, 42, 'asd', 'asd', '2020-12-21', 160511000, '0421117105', '160511000-2020-12-21-03-06-12-Contoh-File-Bimbingan.pdf', NULL, NULL, 'Bimbingan Laporan', 'Belum Dibaca', NULL, NULL),
(42, 'update', 'Mahasiswa 1', '2020-12-20 20:07:29', 76, 42, 'asd', 'asd', '2020-12-21', 160511000, '0421117105', '160511000-2020-12-21-03-06-12-Contoh-File-Bimbingan.pdf', '0421117105-21-Dec-2020-03-07-02-Contoh-File-Hasil_Bimbingan.pdf', 'asdas', 'Bimbingan Laporan', 'Dibalas', 'Belum Dibaca', 'Layak'),
(43, 'insert', 'Mahasiswa 1', '2020-12-20 20:14:22', 77, 42, 'asda', 'asda', '2020-12-21', 160511000, '0416086408', '160511000-21-Dec-2020-03-14-22-Contoh-File-Bimbingan.pdf', NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', NULL, NULL),
(44, 'update', 'Agust Isa Martinus, M.T', '2020-12-20 20:14:44', 77, 42, 'asda', 'asda', '2020-12-21', 160511000, '0416086408', '160511000-21-Dec-2020-03-14-22-Contoh-File-Bimbingan.pdf', NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', NULL, NULL),
(45, 'insert', 'Mahasiswa 1', '2020-12-25 19:30:23', 78, 42, 'adsa', 'asda', '2020-12-26', 160511000, '0421117105', '160511000-2020-12-26-02-30-23-Contoh-File-Bimbingan.pdf', NULL, NULL, 'Bimbingan Laporan', 'Belum Dibaca', NULL, NULL),
(46, 'update', 'Tatang', '2021-01-10 06:15:47', 28, 22, 'Bimbingan Laporan', 'Bimbingan Laporan', '2020-09-21', 160511070, '0421117105', 'Contoh-File-BImbingan.pdf', 'Contoh-File-BImbingan.pdf', 'Daftar Sidang', 'Bimbingan Laporan', 'Dibalas', 'Dibaca', 'Layak'),
(47, 'update', 'Tatang', '2021-01-10 06:15:47', 40, 22, 'Bimbingan Revisi Pasca Sidang PKl', 'Bimbingan Revisi Pasca Sidang PKl', '2020-09-21', 160511070, '0406067407', '160511030-Contoh-File-Bimbingan.pdf', '0403079201-Contoh-File-Hasil_Bimbingan.pdf', 'diterima, silahkan cetak laporan', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Layak');

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
(4, '160511030-Contoh-File-Laporan.pdf', 6),
(5, '160511001-Contoh-File-Laporan.pdf', 11),
(6, '160511006-Contoh-File-Laporan.pdf', 13),
(7, '160511006-Contoh-File-Laporan.pdf', 26),
(8, '160511013-Contoh-File-Laporan.pdf', 9),
(10, '160511006-Contoh-File-Laporan.pdf', 8),
(11, '160511006-Contoh-File-Laporan.pdf', 10),
(12, '160511006-Contoh-File-Laporan.pdf', 12),
(13, '160511006-Contoh-File-Laporan.pdf', 14),
(14, '160511006-Contoh-File-Laporan.pdf', 15),
(15, '160511006-Contoh-File-Laporan.pdf', 16),
(16, '160511006-Contoh-File-Laporan.pdf', 17),
(17, '160511006-Contoh-File-Laporan.pdf', 18),
(18, '160511006-Contoh-File-Laporan.pdf', 19),
(19, '160511006-Contoh-File-Laporan.pdf', 21),
(21, '160511006-Contoh-File-Laporan.pdf', 23),
(22, '160511006-Contoh-File-Laporan.pdf', 24),
(23, '160511006-Contoh-File-Laporan.pdf', 25),
(44, '160511000-21-Dec-2020-03-15-13-Contoh-File-Bimbingan.pdf', 42);

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
(1, 'insert', 'Mahasiswa 1', '2020-11-01 18:53:54', 39, '160511000-Contoh-File-Laporan.pdf', 38),
(2, 'insert', 'Mahasiswa 1', '2020-11-02 03:26:42', 40, '160511000-Contoh-File-Laporan.pdf', 39),
(3, 'insert', 'Mahasiswa 1', '2020-11-22 16:05:17', 41, '160511000-22-Nov-2020-11-05-17-Contoh-File-Laporan.pdf', 39),
(4, 'insert', 'Mahasiswa 1', '2020-12-19 10:57:55', 42, '160511000-19-Dec-2020-05-57-55-Contoh-File-Laporan.pdf', 40),
(5, 'insert', 'Mahasiswa 1', '2020-12-20 14:10:11', 42, '160511000-19-Dec-2020-05-57-55-Contoh-File-Laporan.pdf', 40),
(6, 'insert', 'Mahasiswa1', '2020-12-20 17:08:13', 43, '160511000-21-Dec-2020-12-08-13-Contoh-File-Bimbingan.pdf', 41),
(7, 'insert', 'Mahasiswa 1', '2020-12-20 20:14:57', 44, '160511000-21-Dec-2020-03-14-57-Contoh-File-Bimbingan.pdf', 42),
(8, 'insert', 'Mahasiswa 1', '2020-12-20 20:15:13', 44, '160511000-21-Dec-2020-03-14-57-Contoh-File-Bimbingan.pdf', 42),
(9, 'insert', 'Tatang', '2021-01-10 06:15:47', 20, '160511006-Contoh-File-Laporan.pdf', 22);

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
(1, 'update', 'Tatang', '2020-11-01 15:53:13', 11, 'Pengelolaan Data COA', 'PT.CMS ', '160511000-Contoh-File-Bimbingan.pdf', '160511001', '1', '160511030-Lembar-Revisi-Contoh.pdf'),
(2, 'insert', 'Mahasiswa 1', '2020-11-01 18:34:25', 38, 'Judul Laporan Praktik Kerja Lapangan', 'Instansi PKL', '160511000-contoh khs dan sertif kkm.pdf', '160511000', '0', NULL),
(3, 'update', 'Mahasiswa 1', '2020-11-01 18:36:18', 38, 'Judul Laporan Praktik Kerja Lapangan', 'Instansi PKL', '160511000-contoh khs dan sertif kkm.pdf', '160511000', '0', NULL),
(4, 'update', 'Mahasiswa 1', '2020-11-01 18:51:59', 38, 'Judul Laporan Praktik Kerja Lapangan 123', 'Instansi PKL', '160511000-contoh khs dan sertif kkm.pdf', '160511000', '0', NULL),
(5, 'insert', 'Mahasiswa 1', '2020-11-02 03:21:40', 39, 'Judul 1', 'Instansi', '160511000-Contoh-File-Bimbingan.pdf', '160511000', '0', NULL),
(6, 'update', 'Mahasiswa 1', '2020-11-02 03:25:47', 39, 'Judul 1', 'Instansi', '160511000-Contoh-File-Bimbingan.pdf', '160511000', '0', NULL),
(7, 'update', 'Tatang', '2020-12-15 20:54:53', 39, 'Judul 1', 'Instansi', '160511000-Contoh-File-Bimbingan.pdf', '160511000', '0', '160511000-contoh lembar revisi.pdf'),
(8, 'update', 'Tatang', '2020-12-15 20:54:59', 39, 'Judul 1', 'Instansi', '160511000-Contoh-File-Bimbingan.pdf', '160511000', '1', '160511000-contoh lembar revisi.pdf'),
(9, 'insert', 'Mahasiswa 1', '2020-12-19 10:37:37', 40, 'Judul Laporan Pratik Kerja Lapangan', 'Instansi PKL', '160511000-19-Dec-2020-05-37-37-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511000', '0', NULL),
(10, 'update', 'Mahasiswa 1', '2020-12-19 10:47:10', 40, 'Judul Laporan Pratik Kerja Lapangan', 'Instansi PKL', '160511000-19-Dec-2020-05-37-37-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511000', '0', NULL),
(11, 'update', 'Tatang', '2020-12-20 16:33:37', 40, 'Judul Laporan Pratik Kerja Lapangan', 'Instansi PKL', '160511030-Contoh-File-Bimbingan.pdf', '160511000', '0', '160511000-19-Dec-2020-05-47-10-contoh lembar revisi.pdf'),
(12, 'update', 'Tatang', '2020-12-20 16:33:44', 40, 'Judul Laporan Pratik Kerja Lapangan', 'Instansi PKL', '160511030-Contoh-File-Bimbingan.pdf', '160511000', '2', '160511000-19-Dec-2020-05-47-10-contoh lembar revisi.pdf'),
(13, 'insert', 'Mahasiswa1', '2020-12-20 16:53:44', 41, 'Judul PKL 1', 'Instasni 1', '160511000-20-Dec-2020-11-53-44-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511000', '0', NULL),
(14, 'update', 'Mahasiswa1', '2020-12-20 17:05:55', 41, 'Judul PKL 1', 'Instasni 1', '160511000-20-Dec-2020-11-53-44-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511000', '0', NULL),
(15, 'insert', 'Mahasiswa 1', '2020-12-20 20:05:58', 42, 'Judul 1', 'Instansi 2', '160511000-21-Dec-2020-03-05-58-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511000', '0', NULL),
(16, 'update', 'Mahasiswa 1', '2020-12-20 20:14:13', 42, 'Judul 1', 'Instansi 2', '160511000-21-Dec-2020-03-05-58-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511000', '0', NULL),
(17, 'update', 'Tatang', '2021-01-10 06:15:47', 22, 'Analisi sistem akses application delivery platform (ADP) di PT. Pertamina EP Asset 3', 'PT. Pertamina EP Asset 3', '160511030-Contoh-File-Bimbingan.pdf', '160511070', '0', '160511030-Lembar-Revisi-Contoh.pdf');

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
(2, 15, 80, 80, 90, 85, 85, 90),
(3, 16, 80, 80, 90, 85, 85, 90),
(4, 17, 80, 80, 90, 85, 85, 90),
(5, 18, 80, 80, 90, 85, 85, 90),
(6, 19, 80, 80, 90, 85, 85, 90),
(7, 20, 80, 80, 90, 85, 85, 90),
(8, 22, 80, 80, 90, 85, 85, 90),
(9, 23, 80, 80, 90, 85, 85, 90),
(10, 24, 80, 80, 90, 85, 85, 90),
(11, 25, 80, 80, 90, 85, 85, 90),
(12, 26, 80, 80, 90, 85, 85, 90),
(13, 27, 80, 80, 90, 85, 85, 90),
(14, 28, 80, 80, 90, 85, 85, 90),
(15, 29, 80, 80, 90, 85, 85, 90),
(16, 30, 80, 80, 90, 85, 85, 90),
(18, 32, 80, 80, 90, 85, 85, 90),
(19, 33, 80, 80, 90, 85, 85, 90),
(20, 34, 80, 80, 90, 85, 85, 90),
(21, 39, 80, 80, 90, 85, 85, 90),
(27, 49, 80, 80, 80, 80, 80, 80),
(28, 50, 0, 0, 0, 0, 0, 0),
(29, 52, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 53, 80, 80, 80, 80, 80, 80),
(34, 59, 80, 80, 80, 80, 80, 80);

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
(1, 'insert', 'Dian Novianti, M.Kom', '2020-11-01 18:41:55', 26, 48, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'update', 'Harry Gunawan,M.Kom', '2020-11-01 18:50:07', 26, 48, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'update', 'Dian Novianti, M.Kom', '2020-11-01 18:51:16', 26, 48, NULL, NULL, NULL, 80, 80, 76),
(4, 'insert', 'Tatang', '2020-11-02 03:25:11', 27, 49, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'update', 'Tatang', '2020-11-02 03:25:32', 27, 49, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'insert', 'Dian Novianti, M.Kom', '2020-11-10 17:52:31', 28, 50, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'update', 'Tatang', '2020-11-10 17:53:34', 28, 50, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'update', 'Tatang', '2020-11-10 17:55:48', 28, 50, 90, 90, 90, 90, 90, 90),
(9, 'insert', 'Dian Novianti, M.Kom', '2020-11-10 18:18:36', 29, 52, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'insert', 'Dian Novianti, M.Kom', '2020-11-22 15:45:47', 30, 53, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'update', 'Tatang', '2020-11-22 15:46:38', 30, 53, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'insert', 'Dian Novianti, M.Kom', '2020-12-14 02:14:31', 31, 54, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'update', 'Tatang', '2020-12-15 20:57:44', 31, 54, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'update', 'Tatang', '2020-12-15 20:58:34', 31, 54, 78, 35, 98, 78, 56, 88),
(15, 'insert', 'Dian Novianti, M.Kom', '2020-12-19 10:45:42', 32, 55, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'update', 'Tatang', '2020-12-19 10:46:34', 32, 55, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'update', 'Tatang', '2020-12-20 16:34:27', 32, 55, 80, 80, 80, 80, 80, 80),
(18, 'insert', 'Dian Novianti, M.Kom', '2020-12-20 17:03:09', 33, 56, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'update', 'Tatang', '2020-12-20 17:04:37', 33, 56, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'insert', 'Dian Novianti, M.Kom', '2020-12-20 20:10:43', 34, 59, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'update', 'Tatang', '2020-12-20 20:11:02', 34, 59, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'update', 'Tatang', '2020-12-27 15:51:49', 4, 17, 80, 80, 90, 85, 85, 90),
(23, 'update', 'Tatang', '2020-12-28 19:17:31', 34, 59, 80, 80, 80, 80, 80, 80),
(24, 'update', 'Tatang', '2020-12-28 19:18:00', 34, 59, 80, 80, 80, 80, 80, 80),
(25, 'update', 'Tatang', '2020-12-28 19:18:05', 34, 59, 80, 80, 80, 80, 80, 80),
(26, 'update', 'Tatang', '2020-12-28 19:18:29', 34, 59, 0, 0, 0, 0, 0, 0),
(27, 'update', 'Tatang', '2020-12-28 19:19:22', 34, 59, 80, 80, 80, 80, 80, 80),
(28, 'update', 'Tatang', '2020-12-28 19:20:03', 34, 59, 0, 0, 0, 0, 0, 0),
(29, 'update', 'Tatang', '2020-12-28 19:20:09', 34, 59, 80, 80, 80, 80, 80, 80),
(30, 'update', 'Tatang', '2020-12-28 19:20:26', 34, 59, 0, 0, 0, 0, 0, 0),
(31, 'update', 'Tatang', '2021-01-10 06:15:47', 17, 31, 80, 80, 90, 85, 85, 90);

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
(15, 6, 2, NULL, '0403079201', '2020-09-21', '09:00', 'Lab Peternakan', 'Lulus'),
(16, 11, 2, NULL, '0402057307', '2020-09-21', '09:00', 'Lab Peternakan', 'Lulus'),
(17, 13, 2, NULL, '0416086408', '2020-09-21', '10:00', 'Perpustakaan', 'Lulus'),
(18, 26, 2, NULL, '0408118304', '2020-10-26', '10:30', 'Lab Peternakan', 'Lulus'),
(19, 9, 2, NULL, '0406067407', '2020-09-21', '11:00', 'Lab Informatika', 'Lulus'),
(20, 8, 2, NULL, '0403079201', '2020-09-21', '10:30', 'Lab Informatika', 'Lulus'),
(22, 10, 2, NULL, '0416086408', '2020-09-21', '10:30', 'Lab Informatika', 'Lulus'),
(23, 12, 2, NULL, '0416086408', '2020-09-21', '10:30', 'Perpustakaan', 'Lulus'),
(24, 14, 2, NULL, '0406067407', '2020-09-21', '10:30', 'Lab Peternakan', 'Lulus'),
(25, 15, 2, NULL, '0405108905', '2020-09-21', '10:30', 'Lab Peternakan', 'Lulus'),
(26, 16, 2, NULL, '0421117105', '2020-09-21', '10:00', 'Lab Informatika', 'Lulus'),
(27, 17, 2, NULL, '0402057307', '2020-09-21', '10:30', 'Lab Peternakan', 'Lulus'),
(28, 18, 2, NULL, '0403079201', '2020-09-21', '10:30', 'Lab Informatika', 'Lulus'),
(29, 19, 2, NULL, '0416086408', '2020-09-21', '10:30', 'Perpustakaan', 'Lulus'),
(30, 21, 2, NULL, '0408118304', '2020-09-21', '10:30', 'Perpustakaan', 'Lulus'),
(32, 23, 2, NULL, '0408118304', '2020-10-01', '10:30', 'Perpustakaan', 'Lulus'),
(33, 24, 2, NULL, '0421117105', '2020-09-21', '10:30', 'Perpustakaan', 'Lulus'),
(34, 25, 2, NULL, '0421117105', '2020-10-02', '10:30', 'Perpustakaan', 'Lulus'),
(59, 42, 2, 'asdas', '0416086408', '2020-12-21', '11:00', 'Lab Informatika', 'Lulus');

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
(1, 'insert', 'Mahasiswa 1', '2020-11-01 18:39:37', 48, 38, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'update', 'Dian Novianti, M.Kom', '2020-11-01 18:40:24', 48, 38, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'update', 'Dian Novianti, M.Kom', '2020-11-01 18:41:55', 48, 38, 2, 'Setuju', NULL, NULL, NULL, NULL, NULL),
(4, 'update', 'Harry Gunawan,M.Kom', '2020-11-01 18:50:07', 48, 38, 2, 'Setuju', '0408118304', '2020-11-02', '09:00', 'Lab Peternakan', NULL),
(5, 'insert', 'Mahasiswa 1', '2020-11-02 03:24:03', 49, 39, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'update', 'Dian Novianti, M.Kom', '2020-11-02 03:24:33', 49, 39, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'update', 'Tatang', '2020-11-02 03:25:11', 49, 39, 2, 'sidang', NULL, NULL, NULL, NULL, NULL),
(8, 'update', 'Tatang', '2020-11-02 03:25:32', 49, 39, 2, 'sidang', '0416086408', '2020-11-02', '09:00', 'Lab Informatika', NULL),
(9, 'insert', 'Mahasiswa 1', '2020-11-10 14:51:39', 50, 39, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'update', 'Dian Novianti, M.Kom', '2020-11-10 16:51:25', 50, 39, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'update', 'Dian Novianti, M.Kom', '2020-11-10 17:52:31', 50, 39, 2, '123', NULL, NULL, NULL, NULL, NULL),
(12, 'update', 'Tatang', '2020-11-10 17:53:34', 50, 39, 2, '123', '0408118304', '2020-11-11', '01:00', 'Lab Informatika', NULL),
(13, 'update', 'Tatang', '2020-11-10 17:55:48', 50, 39, 2, '123', '0408118304', '2020-11-11', '01:00', 'Lab Informatika', 'Lulus'),
(14, 'insert', 'Mahasiswa 1', '2020-11-10 17:55:57', 51, 39, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'insert', 'Mahasiswa 1', '2020-11-10 18:03:25', 52, 39, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'update', 'Dian Novianti, M.Kom', '2020-11-10 18:17:51', 52, 39, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'update', 'Dian Novianti, M.Kom', '2020-11-10 18:18:36', 52, 39, 2, '123', NULL, NULL, NULL, NULL, NULL),
(18, 'insert', 'Mahasiswa 1', '2020-11-22 15:02:19', 53, 39, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'update', 'Dian Novianti, M.Kom', '2020-11-22 15:05:49', 53, 39, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'update', 'Dian Novianti, M.Kom', '2020-11-22 15:45:47', 53, 39, 2, 'setuju', NULL, NULL, NULL, NULL, NULL),
(21, 'update', 'Tatang', '2020-11-22 15:46:38', 53, 39, 2, 'setuju', '0408118304', '2020-11-22', '00:00', 'Lab Informatika', NULL),
(22, 'insert', 'Mahasiswa 1', '2020-11-25 09:22:50', 54, 39, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'update', 'Dian Novianti, M.Kom', '2020-11-25 09:23:14', 54, 39, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'update', 'Dian Novianti, M.Kom', '2020-12-14 02:14:31', 54, 39, 2, '123', NULL, NULL, NULL, NULL, NULL),
(25, 'update', 'Dian Novianti, M.Kom', '2020-12-14 02:24:27', 54, 39, 2, '123', '0402057307', '2020-12-14', '08:00', 'Lab Informatika', NULL),
(26, 'update', 'Dian Novianti, M.Kom', '2020-12-14 02:24:34', 54, 39, 1, 'asd', '0402057307', '2020-12-14', '08:00', 'Lab Informatika', NULL),
(27, 'update', 'Tatang', '2020-12-15 20:57:44', 54, 39, 2, 'asd', '0402057307', '2020-12-14', '08:00', 'Lab Informatika', NULL),
(28, 'update', 'Tatang', '2020-12-15 20:58:34', 54, 39, 2, 'asd', '0402057307', '2020-12-14', '08:00', 'Lab Informatika', 'Lulus'),
(29, 'insert', 'Mahasiswa 1', '2020-12-19 10:43:06', 55, 40, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 'update', 'Dian Novianti, M.Kom', '2020-12-19 10:44:07', 55, 40, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 'update', 'Dian Novianti, M.Kom', '2020-12-19 10:45:42', 55, 40, 2, 'ok', NULL, NULL, NULL, NULL, NULL),
(32, 'update', 'Tatang', '2020-12-19 10:46:34', 55, 40, 2, 'ok', '0416086408', '2020-12-21', '11:00', 'Lab Informatika', NULL),
(33, 'update', 'Tatang', '2020-12-20 16:34:27', 55, 40, 2, 'ok', '0416086408', '2020-12-21', '11:00', 'Lab Informatika', 'Lulus'),
(34, 'insert', 'Mahasiswa1', '2020-12-20 17:00:34', 56, 41, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 'update', 'Dian Novianti, M.Kom', '2020-12-20 17:01:16', 56, 41, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 'update', 'Dian Novianti, M.Kom', '2020-12-20 17:03:09', 56, 41, 2, 'oke', NULL, NULL, NULL, NULL, NULL),
(37, 'update', 'Tatang', '2020-12-20 17:04:37', 56, 41, 2, 'oke', '0408118304', '2020-12-21', '11:00', 'Lab Informatika', NULL),
(38, 'insert', 'Mahasiswa 1', '2020-12-20 20:07:38', 57, 42, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 'insert', 'Mahasiswa 1', '2020-12-20 20:09:19', 58, 42, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 'insert', 'Mahasiswa 1', '2020-12-20 20:09:59', 59, 42, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 'update', 'Dian Novianti, M.Kom', '2020-12-20 20:10:09', 59, 42, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(42, 'update', 'Dian Novianti, M.Kom', '2020-12-20 20:10:43', 59, 42, 2, 'asdas', NULL, NULL, NULL, NULL, NULL),
(43, 'update', 'Tatang', '2020-12-20 20:11:02', 59, 42, 2, 'asdas', '0416086408', '2020-12-21', '11:00', 'Lab Informatika', NULL),
(44, 'update', 'Tatang', '2020-12-27 15:51:49', 17, 13, 2, NULL, '0416086408', '2020-09-21', '10:00', 'Perpustakaan', 'Lulus'),
(45, 'update', 'Tatang', '2020-12-28 19:17:16', 59, 42, 2, 'asdas', '0416086408', '2020-12-21', '11:00', 'Lab Informatika', 'Lulus'),
(46, 'update', 'Tatang', '2020-12-28 19:17:31', 59, 42, 2, 'asdas', '0416086408', '2020-12-21', '11:00', 'Lab Informatika', 'Tidak Lulus'),
(47, 'update', 'Tatang', '2020-12-28 19:17:36', 59, 42, 2, 'asdas', '0416086408', '2020-12-21', '11:00', 'Lab Informatika', 'Lulus'),
(48, 'update', 'Tatang', '2020-12-28 19:18:00', 59, 42, 2, 'asdas', '0416086408', '2020-12-21', '11:00', 'Lab Informatika', 'Tidak Lulus'),
(49, 'update', 'Tatang', '2020-12-28 19:18:05', 59, 42, 2, 'asdas', '0416086408', '2020-12-21', '11:00', 'Lab Informatika', 'Lulus'),
(50, 'update', 'Tatang', '2020-12-28 19:18:29', 59, 42, 2, 'asdas', '0416086408', '2020-12-21', '11:00', 'Lab Informatika', 'Tidak Lulus'),
(51, 'update', 'Tatang', '2020-12-28 19:19:22', 59, 42, 2, 'asdas', '0416086408', '2020-12-21', '11:00', 'Lab Informatika', 'Lulus'),
(52, 'update', 'Tatang', '2020-12-28 19:20:03', 59, 42, 2, 'asdas', '0416086408', '2020-12-21', '11:00', 'Lab Informatika', 'Tidak Lulus'),
(53, 'update', 'Tatang', '2020-12-28 19:20:09', 59, 42, 2, 'asdas', '0416086408', '2020-12-21', '11:00', 'Lab Informatika', 'Lulus'),
(54, 'update', 'Tatang', '2020-12-28 19:20:26', 59, 42, 2, 'asdas', '0416086408', '2020-12-21', '11:00', 'Lab Informatika', 'Tidak Lulus'),
(55, 'update', 'Tatang', '2021-01-10 06:15:47', 31, 22, 2, NULL, '0406067407', '2020-09-21', '10:30', 'Perpustakaan', 'Lulus');

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
(10, '2020-10-25', '160511030-2020-10-25-23-35-40-Contoh-File-Bimbingan.pdf', 2, NULL, '160511030'),
(12, '2020-10-25', '160511030-2020-10-25-23-35-40-Contoh-File-Bimbingan.pdf', 2, '123', '160511001'),
(13, '2020-10-25', '160511030-2020-10-25-23-35-40-Contoh-File-Bimbingan.pdf', 2, '', '160511006'),
(14, '2020-10-25', '160511030-2020-10-25-23-35-40-Contoh-File-Bimbingan.pdf', 2, '', '160511009'),
(15, '2020-10-25', '160511030-2020-10-25-23-35-40-Contoh-File-Bimbingan.pdf', 2, '', '160511013'),
(16, '2020-10-25', '160511030-2020-10-25-23-35-40-Contoh-File-Bimbingan.pdf', 2, '', '160511026'),
(17, '2020-10-25', '160511030-2020-10-25-23-35-40-Contoh-File-Bimbingan.pdf', 2, '', '160511031'),
(18, '2020-10-25', '160511030-2020-10-25-23-35-40-Contoh-File-Bimbingan.pdf', 2, '', '160511039'),
(19, '2020-10-25', '160511030-2020-10-25-23-35-40-Contoh-File-Bimbingan.pdf', 2, '', '160511040'),
(20, '2020-10-25', '160511030-2020-10-25-23-35-40-Contoh-File-Bimbingan.pdf', 2, '', '160511051'),
(21, '2020-10-25', '160511030-2020-10-25-23-35-40-Contoh-File-Bimbingan.pdf', 2, '', '160511052'),
(22, '2020-10-25', '160511030-2020-10-25-23-35-40-Contoh-File-Bimbingan.pdf', 2, '', '160511053'),
(23, '2020-10-25', '160511030-2020-10-25-23-35-40-Contoh-File-Bimbingan.pdf', 2, '', '160511054'),
(24, '2020-10-25', '160511030-2020-10-25-23-35-40-Contoh-File-Bimbingan.pdf', 2, '', '160511055'),
(25, '2020-10-25', '160511030-2020-10-25-23-35-40-Contoh-File-Bimbingan.pdf', 2, '', '160511060'),
(26, '2020-10-25', '160511030-2020-10-25-23-35-40-Contoh-File-Bimbingan.pdf', 2, '', '160511063'),
(27, '2020-10-25', '160511030-2020-10-25-23-35-40-Contoh-File-Bimbingan.pdf', 2, '', '160511064'),
(28, '2020-10-25', '160511030-2020-10-25-23-35-40-Contoh-File-Bimbingan.pdf', 2, '', '160511068'),
(34, '2020-12-21', '160511000-21-Dec-2020-03-05-32-c7f8b5ca27404a7094dd253e746ffccd.pdf', 2, 'asd', '160511000');

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
(1, 'insert', 'Mahasiswa 1', '2020-11-01 18:32:33', 30, '2020-11-02', '160511000-2020-11-02-01-32-33-contoh khs dan sertif kkm.pdf', 0, NULL, '160511000'),
(2, 'update', 'Tatang', '2020-11-01 18:33:28', 30, '2020-11-02', '160511000-2020-11-02-01-32-33-contoh khs dan sertif kkm.pdf', 0, NULL, '160511000'),
(3, 'insert', 'Mahasiswa 1', '2020-11-02 03:19:21', 31, '2020-11-02', '160511000-2020-11-02-10-19-21-contoh khs dan sertif kkm.pdf', 0, NULL, '160511000'),
(4, 'update', 'Tatang', '2020-11-02 03:19:35', 31, '2020-11-02', '160511000-2020-11-02-10-19-21-contoh khs dan sertif kkm.pdf', 0, NULL, '160511000'),
(5, 'update', 'Tatang', '2020-12-15 20:42:49', 31, '2020-11-02', '160511000-2020-11-02-10-19-21-contoh khs dan sertif kkm.pdf', 2, 'SETUJU', '160511000'),
(6, 'update', 'Tatang', '2020-12-15 20:42:54', 31, '2020-11-02', '160511000-2020-11-02-10-19-21-contoh khs dan sertif kkm.pdf', 1, 'SETUJU', '160511000'),
(7, 'insert', 'Mahasiswa 1', '2020-12-19 10:35:20', 32, '2020-12-19', '160511000-19-Dec-2020-05-35-20-contoh lembar revisi.pdf', 0, NULL, '160511000'),
(8, 'update', 'Tatang', '2020-12-19 10:36:36', 32, '2020-12-19', '160511000-19-Dec-2020-05-35-20-contoh lembar revisi.pdf', 0, NULL, '160511000'),
(9, 'insert', 'Mahasiswa1', '2020-12-20 16:52:14', 33, '2020-12-20', '160511000-20-Dec-2020-11-52-14-c7f8b5ca27404a7094dd253e746ffccd.pdf', 0, NULL, '160511000'),
(10, 'update', 'Tatang', '2020-12-20 16:52:47', 33, '2020-12-20', '160511000-20-Dec-2020-11-52-14-c7f8b5ca27404a7094dd253e746ffccd.pdf', 0, NULL, '160511000'),
(11, 'update', 'Tatang', '2020-12-20 16:53:00', 33, '2020-12-20', '160511000-20-Dec-2020-11-52-14-c7f8b5ca27404a7094dd253e746ffccd.pdf', 2, 'oke', '160511000'),
(12, 'update', 'Tatang', '2020-12-20 16:53:12', 33, '2020-12-20', '160511000-20-Dec-2020-11-52-14-c7f8b5ca27404a7094dd253e746ffccd.pdf', 1, 'oke', '160511000'),
(13, 'insert', 'Mahasiswa 1', '2020-12-20 20:05:32', 34, '2020-12-21', '160511000-21-Dec-2020-03-05-32-c7f8b5ca27404a7094dd253e746ffccd.pdf', 0, NULL, '160511000'),
(14, 'update', 'Tatang', '2020-12-20 20:05:39', 34, '2020-12-21', '160511000-21-Dec-2020-03-05-32-c7f8b5ca27404a7094dd253e746ffccd.pdf', 0, NULL, '160511000'),
(15, 'insert', 'Hari', '2020-12-21 04:43:21', 35, '2020-12-21', '160511100-21-Dec-2020-11-43-21-c7f8b5ca27404a7094dd253e746ffccd.pdf', 0, NULL, '160511100'),
(16, 'update', 'Tatang', '2020-12-21 04:44:44', 35, '2020-12-21', '160511100-21-Dec-2020-11-43-21-c7f8b5ca27404a7094dd253e746ffccd.pdf', 0, NULL, '160511100'),
(17, 'update', 'Tatang', '2021-01-10 06:15:47', 29, '2020-10-25', '160511030-2020-10-25-23-35-40-Contoh-File-Bimbingan.pdf', 2, '', '160511070');

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
(10, '160511000-21-Dec-2020-03-07-38-c7f8b5ca27404a7094dd253e746ffccd.pdf', 0, '57'),
(11, '160511000-21-Dec-2020-03-09-19-c7f8b5ca27404a7094dd253e746ffccd.pdf', 0, '58'),
(12, '160511000-21-Dec-2020-03-09-59-c7f8b5ca27404a7094dd253e746ffccd.pdf', 2, '59');

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
(6, 9, '0421117105', '160511013-Contoh-Lembar-REvisi.pdf'),
(7, 11, '0416086408', '160511013-Contoh-Lembar-REvisi.pdf'),
(8, 14, '0408118304', '160511013-Contoh-Lembar-REvisi.pdf'),
(9, 15, '0406067407', '160511013-Contoh-Lembar-REvisi.pdf'),
(10, 18, '0402057307', '160511030-Lembar-Revisi-Contoh.pdf'),
(11, 19, '0017057402', '160511030-Lembar-Revisi-Contoh.pdf'),
(12, 20, '0406067407', '160511030-Lembar-Revisi-Contoh.pdf'),
(13, 21, '0406067407', '160511030-Lembar-Revisi-Contoh.pdf'),
(14, 23, '0416086408', '160511030-Lembar-Revisi-Contoh.pdf'),
(15, 24, '0017057402', '160511030-Lembar-Revisi-Contoh.pdf'),
(16, 26, '0416086408', '160511030-Lembar-Revisi-Contoh.pdf'),
(17, 28, '0416086408', '160511030-Contoh-Lembar-REvisi.pdf'),
(18, 29, '0406067407', '160511030-Lembar-Revisi-Contoh.pdf'),
(19, 30, '0408118304', '160511030-Lembar-Revisi-Contoh.pdf'),
(21, 31, '0408118304', '160511030-Lembar-Revisi-Contoh.pdf'),
(53, 58, '0421117105', '160511000-21-Dec-2020-03-23-49-c7f8b5ca27404a7094dd253e746ffccd.pdf');

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
(1, 17, 'Bimbingan Proposal', 'Bimbingan Proposal', '2020-09-21', 160511030, '0416086408', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Silahkan daftar sidang proposal', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Proposal', 'Dibalas', 'Dibaca', 'Layak'),
(2, 17, 'Bimbingan Pasca Sidang Proposal', 'Bimbingan Pasca Sidang Proposal', '2020-09-21', 160511030, '0416086408', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Cetak dan Kumpulkan', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Layak'),
(3, 6, 'Bimbingan Proposal', 'Bimbingan Proposal\r\n', '2020-09-21', 160511006, '0421117105', '160511006-Contoh-File-Bimbingan.pdf', '0000-00-00', '123', '0421117105-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Proposal', 'Dibalas', 'Belum Dibaca', 'Layak'),
(4, 7, 'Bimbingan Proposal', 'Bimbingan Proposal', '2020-09-21', 160511013, '0416086408', '160511013-Contoh-File-Bimbingan.pdf', '0000-00-00', 'Daftar Sidang123', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Proposal', 'Dibalas', 'Belum Dibaca', 'Layak'),
(5, 7, 'Bimbingan Proposal', 'Bimbingan Proposal', '2020-09-21', 160511013, '0416086408', '160511013-Contoh-File-Bimbingan.pdf', NULL, 'Cetak Proposal', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Layak'),
(6, 8, 'Bimbingan Proposal', 'Bimbingan Proposal', '2020-09-22', 160511068, '0408118304', '160511030-Contoh-File-Bimbingan.pdf', '0000-00-00', 'ok', '0408118304-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Proposal', 'Dibalas', 'Belum Dibaca', 'Layak'),
(7, 9, 'Bimbingan Proposal', 'Bimbingan Proposal', '2020-09-22', 160511031, '0406067407', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Proposal', 'Dibalas', 'Dibaca', 'Layak'),
(8, 10, 'Bimbingan Proposal', 'Bimbingan Proposal', '2020-09-22', 160511052, '0402057307', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Proposal', 'Dibalas', 'Dibaca', 'Layak'),
(10, 12, 'Bimbingan Proposal', 'Bimbingan Proposal', '2020-09-22', 160511026, '0406067407', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Proposal', 'Dibalas', 'Dibaca', 'Layak'),
(11, 13, 'Bimbingan Proposal', 'Bimbingan Proposal', '2020-09-22', 160511039, '0406067407', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Proposal', 'Dibalas', 'Dibaca', 'Layak'),
(12, 14, 'Bimbingan Proposal', 'Bimbingan Proposal', '2020-09-22', 160511040, '0416086408', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Proposal', 'Dibalas', 'Dibaca', 'Layak'),
(13, 15, 'Bimbingan Proposal', 'Bimbingan Proposal', '2020-09-22', 160511063, '0017057402', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Proposal', 'Dibalas', 'Dibaca', 'Layak'),
(14, 16, 'Bimbingan Proposal', 'Bimbingan Proposal', '2020-09-22', 160511064, '0416086408', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Proposal', 'Dibalas', 'Dibaca', 'Layak'),
(15, 18, 'Bimbingan Proposal', 'Bimbingan Proposal', '2020-09-22', 160511054, '0406067407', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Proposal', 'Dibalas', 'Dibaca', 'Layak'),
(16, 19, 'Bimbingan Proposal', 'Bimbingan Proposal', '2020-09-22', 160511001, '0408118304', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Proposal', 'Dibalas', 'Dibaca', 'Layak'),
(18, 21, 'Bimbingan Proposal', 'Bimbingan Proposal', '2020-09-22', 160511055, '0408118304', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Proposal', 'Dibalas', 'Dibaca', 'Layak'),
(19, 6, 'Bimbingan Pasca', 'Bimbingan Pasca', '2020-09-22', 160511006, '0416086408', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang123123', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Belum Dibaca', 'Layak'),
(20, 6, 'Bimbingan Pasca', 'Bimbingan Pasca', '2020-09-22', 160511006, '0406067407', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Layak'),
(21, 8, 'Bimbingan Pasca', 'Bimbingan Pasca', '2020-09-22', 160511068, '0402057307', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Layak'),
(22, 8, 'Bimbingan Pasca', 'Bimbingan Pasca', '2020-09-22', 160511068, '0405108905', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Layak'),
(23, 10, 'Bimbingan Pasca', 'Bimbingan Pasca', '2020-09-22', 160511052, '0416086408', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Revisi'),
(24, 10, 'Bimbingan Pasca', 'Bimbingan Pasca', '2020-09-22', 160511052, '0408118304', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Revisi'),
(25, 12, 'Bimbingan Pasca', 'Bimbingan Pasca', '2020-09-22', 160511070, '0421117105', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Revisi'),
(26, 12, 'Bimbingan Pasca', 'Bimbingan Pasca', '2020-09-22', 160511070, '0403079201', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Revisi'),
(27, 14, 'Bimbingan Pasca', 'Bimbingan Pasca', '2020-09-22', 160511040, '0421117105', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Revisi'),
(28, 14, 'Bimbingan Pasca', 'Bimbingan Pasca', '2020-09-22', 160511040, '0428117601', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Revisi'),
(29, 19, 'Bimbingan Pasca', 'Bimbingan Pasca', '2020-09-22', 160511040, '0425036001', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Revisi'),
(30, 19, 'Bimbingan Pasca', 'Bimbingan Pasca', '2020-09-22', 160511001, '0403079201', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Revisi'),
(33, 21, 'Bimbingan Pasca', 'Bimbingan Pasca', '2020-09-22', 160511055, '0421117105', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Revisi'),
(34, 21, 'Bimbingan Pasca', 'Bimbingan Pasca', '2020-09-22', 160511055, '0402057307', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Revisi'),
(35, 16, 'Bimbingan Pasca', 'Bimbingan Pasca', '2020-09-22', 160511064, '0421117105', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Revisi'),
(36, 16, 'Bimbingan Pasca', 'Bimbingan Pasca', '2020-09-22', 160511064, '0402057307', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Revisi'),
(37, 17, 'Bab 1-4', 'asda', '2020-09-22', 160511030, '0416086408', '160511030-Contoh-File-Bimbingan.pdf', '0000-00-00', 'asdsa', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Proposal', 'Dibalas', 'Dibaca', 'Layak'),
(38, 17, 'bimbingan pasca', 'bimbingan pasca', '2020-09-22', 160511030, '0402057307', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'asdas', '0402057307-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Revisi'),
(48, 17, 'Bab 1', 'Bimbingan Bab 1', '2020-11-02', 160511030, '0416086408', '160511030-Contoh-File-Bimbingan.pdf', '0000-00-00', 'Disetujui', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Proposal', 'Dibalas', 'Dibaca', 'Lanjut Bab'),
(49, 17, 'asda', 'asdas', '2020-11-10', 160511030, '0416086408', '160511030-10-Nov-2020-08-30-33-DRAFT SIAP SIDANG-min.pdf', '0000-00-00', '132', '0416086408-16-Dec-2020-02-51-33-Contoh-File-Bimbingan.pdf', 'Bimbingan Proposal', 'Dibalas', 'Dibaca', 'Lanjut Bab'),
(50, 17, 'asdas', 'asdas', '2020-11-10', 160511030, 'Pilih', '160511030-10-Nov-2020-08-33-10-DRAFT SIAP SIDANG-min.pdf', NULL, NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', 'Belum Dibaca', NULL),
(51, 17, 'asda', 'asda', '2020-11-10', 160511030, '0402057307', '160511030-10-Nov-2020-08-33-23-DRAFT SIAP SIDANG-min.pdf', NULL, 'ok siap', '0402057307-14-Dec-2020-08-28-22-Contoh-File-Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Belum Dibaca', 'Layak');

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
(1, 'update', 'Harry Gunawan,M.Kom', '2020-11-01 18:42:40', 6, 8, 'Bimbingan Proposal', 'Bimbingan Proposal', '2020-09-22', 160511068, '0408118304', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Proposal', 'Belum Dibaca', 'Dibaca', 'Layak'),
(2, 'insert', 'Mahasiswa 1', '2020-11-01 18:58:16', 46, 47, 'Bab 1', 'Bab 1', '2020-11-02', 160511000, '0421117105', '160511000-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Proposal', 'Belum Dibaca', 'Belum Dibaca', NULL),
(3, 'update', 'Dian Novianti, M.Kom', '2020-11-01 19:00:16', 46, 47, 'Bab 1', 'Bab 1', '2020-11-02', 160511000, '0421117105', '160511000-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Proposal', 'Belum Dibaca', 'Belum Dibaca', NULL),
(4, 'update', 'Mahasiswa 1', '2020-11-01 19:00:25', 46, 47, 'Bab 1', 'Bab 1', '2020-11-02', 160511000, '0421117105', '160511000-Contoh-File-Bimbingan.pdf', '0000-00-00', 'Setuju', '0421117105-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Proposal', 'Dibalas', 'Belum Dibaca', 'Layak'),
(5, 'insert', 'Mahasiswa 1', '2020-11-01 19:09:54', 47, 47, 'Bab 1', 'Bab 1', '2020-11-02', 160511000, '0416086408', '160511000-Contoh-File-Hasil_Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', 'Belum Dibaca', NULL),
(6, 'update', 'Agust Isa Martinus, M.T', '2020-11-01 19:10:24', 47, 47, 'Bab 1', 'Bab 1', '2020-11-02', 160511000, '0416086408', '160511000-Contoh-File-Hasil_Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', 'Belum Dibaca', NULL),
(7, 'update', 'Mahasiswa 1', '2020-11-01 19:10:31', 47, 47, 'Bab 1', 'Bab 1', '2020-11-02', 160511000, '0416086408', '160511000-Contoh-File-Hasil_Bimbingan.pdf', NULL, 'ok', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Belum Dibaca', 'Layak'),
(8, 'insert', 'Mohamad Irfan Manaf', '2020-11-02 03:00:09', 48, 17, 'Bab 1', 'Bimbingan Bab 1', '2020-11-02', 160511030, '0416086408', '160511030-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Proposal', 'Belum Dibaca', 'Belum Dibaca', NULL),
(9, 'update', 'Agust Isa Martinus, M.T', '2020-11-02 03:04:43', 48, 17, 'Bab 1', 'Bimbingan Bab 1', '2020-11-02', 160511030, '0416086408', '160511030-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Proposal', 'Belum Dibaca', 'Belum Dibaca', NULL),
(10, 'insert', 'Mohamad Irfan Manaf', '2020-11-10 13:30:33', 49, 17, 'asda', 'asdas', '2020-11-10', 160511030, '0416086408', '160511030-10-Nov-2020-08-30-33-DRAFT SIAP SIDANG-min.pdf', NULL, NULL, NULL, 'Bimbingan Proposal', 'Belum Dibaca', 'Belum Dibaca', NULL),
(11, 'insert', 'Mohamad Irfan Manaf', '2020-11-10 13:33:10', 50, 17, 'asdas', 'asdas', '2020-11-10', 160511030, 'Pilih', '160511030-10-Nov-2020-08-33-10-DRAFT SIAP SIDANG-min.pdf', NULL, NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', 'Belum Dibaca', NULL),
(12, 'insert', 'Mohamad Irfan Manaf', '2020-11-10 13:33:23', 51, 17, 'asda', 'asda', '2020-11-10', 160511030, '0402057307', '160511030-10-Nov-2020-08-33-23-DRAFT SIAP SIDANG-min.pdf', NULL, NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', 'Belum Dibaca', NULL),
(13, 'insert', 'Mahasiswa 1', '2020-11-22 16:55:05', 52, 48, 'Bimbingan 1', 'asdas', '2020-11-22', 160511000, '0408118304', '160511000-22-Nov-2020-11-55-05-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Proposal', 'Belum Dibaca', 'Belum Dibaca', NULL),
(14, 'update', 'Harry Gunawan,M.Kom', '2020-11-22 16:55:54', 52, 48, 'Bimbingan 1', 'asdas', '2020-11-22', 160511000, '0408118304', '160511000-22-Nov-2020-11-55-05-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Proposal', 'Belum Dibaca', 'Belum Dibaca', NULL),
(15, 'update', 'Mahasiswa 1', '2020-11-22 16:56:03', 52, 48, 'Bimbingan 1', 'asdas', '2020-11-22', 160511000, '0408118304', '160511000-22-Nov-2020-11-55-05-Contoh-File-Bimbingan.pdf', '0000-00-00', 'asdsa', '0408118304-22-Nov-2020-11-55-54-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Proposal', 'Dibalas', 'Belum Dibaca', 'Layak'),
(16, 'insert', 'Mahasiswa 1', '2020-11-22 18:18:54', 53, 48, 'Bimbingan 1', 'asdsa', '2020-11-23', 160511000, '0421117105', '160511000-23-Nov-2020-01-18-54-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', 'Belum Dibaca', NULL),
(17, 'update', 'Dian Novianti, M.Kom', '2020-11-22 18:26:08', 53, 48, 'Bimbingan 1', 'asdsa', '2020-11-23', 160511000, '0421117105', '160511000-23-Nov-2020-01-18-54-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', 'Belum Dibaca', NULL),
(18, 'update', 'Mahasiswa 1', '2020-11-22 18:26:14', 53, 48, 'Bimbingan 1', 'asdsa', '2020-11-23', 160511000, '0421117105', '160511000-23-Nov-2020-01-18-54-Contoh-File-Bimbingan.pdf', NULL, '123', '0421117105-23-Nov-2020-01-26-08-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Belum Dibaca', 'Layak'),
(19, 'update', 'Freddy Wicaksono, M.Kom', '2020-12-14 01:28:22', 51, 17, 'asda', 'asda', '2020-11-10', 160511030, '0402057307', '160511030-10-Nov-2020-08-33-23-DRAFT SIAP SIDANG-min.pdf', NULL, NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', 'Belum Dibaca', NULL),
(20, 'update', 'Freddy Wicaksono, M.Kom', '2020-12-14 01:28:42', 51, 17, 'asda', 'asda', '2020-11-10', 160511030, '0402057307', '160511030-10-Nov-2020-08-33-23-DRAFT SIAP SIDANG-min.pdf', NULL, 'ok', '0402057307-14-Dec-2020-08-28-22-Contoh-File-Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Belum Dibaca', 'Layak'),
(21, 'update', 'Agust Isa Martinus, M.T', '2020-12-15 19:15:39', 19, 6, 'Bimbingan Pasca', 'Bimbingan Pasca', '2020-09-22', 160511006, '0416086408', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Layak'),
(22, 'update', 'Agust Isa Martinus, M.T', '2020-12-15 19:51:33', 49, 17, 'asda', 'asdas', '2020-11-10', 160511030, '0416086408', '160511030-10-Nov-2020-08-30-33-DRAFT SIAP SIDANG-min.pdf', NULL, NULL, NULL, 'Bimbingan Proposal', 'Belum Dibaca', 'Belum Dibaca', NULL),
(23, 'update', 'Agust Isa Martinus, M.T', '2020-12-15 19:51:50', 4, 7, 'Bimbingan Proposal', 'Bimbingan Proposal', '2020-09-21', 160511013, '0416086408', '160511013-Contoh-File-Bimbingan.pdf', '0000-00-00', 'Daftar Sidang', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Proposal', 'Dibalas', 'Belum Dibaca', 'Layak'),
(24, 'update', 'Agust Isa Martinus, M.T', '2020-12-15 20:09:58', 19, 6, 'Bimbingan Pasca', 'Bimbingan Pasca', '2020-09-22', 160511006, '0416086408', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang123', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Belum Dibaca', 'Layak'),
(25, 'update', 'Agust Isa Martinus, M.T', '2020-12-15 20:10:07', 19, 6, 'Bimbingan Pasca', 'Bimbingan Pasca', '2020-09-22', 160511006, '0416086408', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang123123', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Belum Dibaca', 'Layak'),
(26, 'update', 'Agust Isa Martinus, M.T', '2020-12-15 20:12:46', 48, 17, 'Bab 1', 'Bimbingan Bab 1', '2020-11-02', 160511030, '0416086408', '160511030-Contoh-File-Bimbingan.pdf', '0000-00-00', 'Disetujui', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Proposal', 'Dibalas', 'Belum Dibaca', ''),
(27, 'insert', 'Mahasiswa 1', '2020-12-19 11:05:54', 54, 49, 'Bimbingan Bab 1', 'Bab 1', '2020-12-19', 160511000, '0421117105', '160511000-19-Dec-2020-06-05-54-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Proposal', 'Belum Dibaca', 'Belum Dibaca', NULL),
(28, 'update', 'Dian Novianti, M.Kom', '2020-12-19 11:14:47', 54, 49, 'Bimbingan Bab 1', 'Bab 1', '2020-12-19', 160511000, '0421117105', '160511000-19-Dec-2020-06-05-54-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Proposal', 'Belum Dibaca', 'Belum Dibaca', NULL),
(29, 'update', 'Mahasiswa 1', '2020-12-19 11:15:18', 54, 49, 'Bimbingan Bab 1', 'Bab 1', '2020-12-19', 160511000, '0421117105', '160511000-19-Dec-2020-06-05-54-Contoh-File-Bimbingan.pdf', '0000-00-00', 'Setuju, silahkan daftar sidang', '0421117105-19-Dec-2020-06-14-47-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Proposal', 'Dibalas', 'Belum Dibaca', 'Layak'),
(30, 'insert', 'Mahasiswa 1', '2020-12-19 11:46:54', 55, 49, 'Bimbingan 1', 'Bimbingan pasca sidang propsal', '2020-12-19', 160511000, '0416086408', '160511000-19-Dec-2020-06-46-54-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', 'Belum Dibaca', NULL),
(31, 'update', 'Agust Isa Martinus, M.T', '2020-12-19 11:47:48', 55, 49, 'Bimbingan 1', 'Bimbingan pasca sidang propsal', '2020-12-19', 160511000, '0416086408', '160511000-19-Dec-2020-06-46-54-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', 'Belum Dibaca', NULL),
(32, 'update', 'Agust Isa Martinus, M.T', '2020-12-19 11:48:52', 55, 49, 'Bimbingan 1', 'Bimbingan pasca sidang propsal', '2020-12-19', 160511000, '0416086408', '160511000-19-Dec-2020-06-46-54-Contoh-File-Bimbingan.pdf', NULL, 'silahkan kumpulkan laporan proposal', '0416086408-19-Dec-2020-06-47-48-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Belum Dibaca', ''),
(33, 'update', 'Mahasiswa 1', '2020-12-19 11:49:11', 55, 49, 'Bimbingan 1', 'Bimbingan pasca sidang propsal', '2020-12-19', 160511000, '0416086408', '160511000-19-Dec-2020-06-46-54-Contoh-File-Bimbingan.pdf', NULL, 'silahkan kumpulkan laporan proposal', '0416086408-19-Dec-2020-06-47-48-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Belum Dibaca', 'Layak'),
(34, 'update', 'Mohamad Irfan Manaf', '2020-12-20 12:59:41', 49, 17, 'asda', 'asdas', '2020-11-10', 160511030, '0416086408', '160511030-10-Nov-2020-08-30-33-DRAFT SIAP SIDANG-min.pdf', '0000-00-00', '132', '0416086408-16-Dec-2020-02-51-33-Contoh-File-Bimbingan.pdf', 'Bimbingan Proposal', 'Dibalas', 'Belum Dibaca', 'Lanjut Bab'),
(35, 'update', 'Mohamad Irfan Manaf', '2020-12-20 12:59:44', 48, 17, 'Bab 1', 'Bimbingan Bab 1', '2020-11-02', 160511030, '0416086408', '160511030-Contoh-File-Bimbingan.pdf', '0000-00-00', 'Disetujui', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Proposal', 'Dibalas', 'Belum Dibaca', 'Lanjut Bab'),
(36, 'insert', 'Mahasiswa1', '2020-12-20 17:34:53', 56, 52, 'Bimbingan 1', 'Bim 1', '2020-12-21', 160511000, '0421117105', '160511000-21-Dec-2020-12-34-53-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Proposal', 'Belum Dibaca', 'Belum Dibaca', NULL),
(37, 'update', 'Dian Novianti, M.Kom', '2020-12-20 17:38:14', 56, 52, 'Bimbingan 1', 'Bim 1', '2020-12-21', 160511000, '0421117105', '160511000-21-Dec-2020-12-34-53-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Proposal', 'Belum Dibaca', 'Belum Dibaca', NULL),
(38, 'update', 'Mahasiswa1', '2020-12-20 17:39:07', 56, 52, 'Bimbingan 1', 'Bim 1', '2020-12-21', 160511000, '0421117105', '160511000-21-Dec-2020-12-34-53-Contoh-File-Bimbingan.pdf', '0000-00-00', '123', '0421117105-21-Dec-2020-12-38-14-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Proposal', 'Dibalas', 'Belum Dibaca', 'Layak'),
(39, 'insert', 'Mahasiswa1', '2020-12-20 17:46:15', 57, 52, 'Bab 1', 'Bimbingan 1', '2020-12-21', 160511000, '0416086408', '160511000-21-Dec-2020-12-46-15-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', 'Belum Dibaca', NULL),
(40, 'update', 'Agust Isa Martinus, M.T', '2020-12-20 17:46:40', 57, 52, 'Bab 1', 'Bimbingan 1', '2020-12-21', 160511000, '0416086408', '160511000-21-Dec-2020-12-46-15-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', 'Belum Dibaca', NULL),
(41, 'update', 'Mahasiswa1', '2020-12-20 17:46:51', 57, 52, 'Bab 1', 'Bimbingan 1', '2020-12-21', 160511000, '0416086408', '160511000-21-Dec-2020-12-46-15-Contoh-File-Bimbingan.pdf', NULL, '123', '0416086408-21-Dec-2020-12-46-40-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Belum Dibaca', 'Layak'),
(42, 'insert', 'Mahasiswa 1', '2020-12-20 20:21:52', 58, 53, 'asdsa', 'asda', '2020-12-21', 160511000, '0421117105', '160511000-21-Dec-2020-03-21-52-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Proposal', 'Belum Dibaca', 'Belum Dibaca', NULL),
(43, 'update', 'Dian Novianti, M.Kom', '2020-12-20 20:22:19', 58, 53, 'asdsa', 'asda', '2020-12-21', 160511000, '0421117105', '160511000-21-Dec-2020-03-21-52-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Proposal', 'Belum Dibaca', 'Belum Dibaca', NULL),
(44, 'insert', 'Mahasiswa 1', '2020-12-20 20:23:59', 59, 53, 'asdas', 'asda', '2020-12-21', 160511000, '0416086408', '160511000-21-Dec-2020-03-23-59-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', 'Belum Dibaca', NULL),
(45, 'update', 'Agust Isa Martinus, M.T', '2020-12-20 20:24:23', 59, 53, 'asdas', 'asda', '2020-12-21', 160511000, '0416086408', '160511000-21-Dec-2020-03-23-59-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', 'Belum Dibaca', NULL),
(46, 'update', 'Mahasiswa 1', '2020-12-20 20:24:44', 59, 53, 'asdas', 'asda', '2020-12-21', 160511000, '0416086408', '160511000-21-Dec-2020-03-23-59-Contoh-File-Bimbingan.pdf', NULL, 'asdas', '0416086408-21-Dec-2020-03-24-23-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Belum Dibaca', 'Layak'),
(47, 'update', 'Tatang', '2021-01-10 06:15:47', 17, 20, 'Bimbingan Proposal', 'Bimbingan Proposal', '2020-09-22', 160511026, '0416086408', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Proposal', 'Dibalas', 'Dibaca', 'Layak'),
(48, 'update', 'Tatang', '2021-01-10 06:15:47', 31, 20, 'Bimbingan Pasca', 'Bimbingan Pasca', '2020-09-22', 160511026, '0428117601', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Revisi'),
(49, 'update', 'Tatang', '2021-01-10 06:15:47', 32, 20, 'Bimbingan Pasca', 'Bimbingan Pasca', '2020-09-22', 160511026, '0408118304', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Revisi'),
(50, NULL, NULL, '2021-01-10 06:28:29', 10, 12, 'Bimbingan Proposal', 'Bimbingan Proposal', '2020-09-22', 160511070, '0406067407', '160511030-Contoh-File-Bimbingan.pdf', NULL, 'Daftar Sidang', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Proposal', 'Dibalas', 'Dibaca', 'Layak'),
(51, NULL, NULL, '2021-01-10 06:28:29', 58, 53, 'asdsa', 'asda', '2020-12-21', 160511000, '0421117105', '160511000-21-Dec-2020-03-21-52-Contoh-File-Bimbingan.pdf', '0000-00-00', 'asdsa', '0421117105-21-Dec-2020-03-22-19-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Proposal', 'Dibalas', 'Belum Dibaca', 'Layak'),
(52, NULL, NULL, '2021-01-10 06:28:29', 59, 53, 'asdas', 'asda', '2020-12-21', 160511000, '0416086408', '160511000-21-Dec-2020-03-23-59-Contoh-File-Bimbingan.pdf', NULL, 'asdas', '0416086408-21-Dec-2020-03-24-23-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Layak');

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
(1, '160511013-Contoh-File-Laporan.pdf', 7),
(2, '160511013-Contoh-File-Laporan.pdf', 8),
(3, '160511013-Contoh-File-Laporan.pdf', 10),
(5, '160511013-Contoh-File-Laporan.pdf', 12),
(6, '160511013-Contoh-File-Laporan.pdf', 14),
(7, '160511030-Contoh-File-Hasil_Bimbingan.pdf', 17),
(8, '160511013-Contoh-File-Laporan.pdf', 19),
(10, '160511013-Contoh-File-Laporan.pdf', 21),
(18, '160511000-21-Dec-2020-03-24-57-Contoh-File-Hasil_Bimbingan.pdf', 53);

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
(1, 'insert', 'Mahasiswa 1', '2020-11-01 19:10:43', 14, '160511000-Contoh-File-Laporan.pdf', 47),
(2, 'insert', 'Mahasiswa 1', '2020-12-14 01:22:50', 15, '160511000-14-Dec-2020-08-22-50-Contoh-File-Laporan.pdf', 48),
(3, 'insert', 'Mahasiswa 1', '2020-12-19 11:49:23', 16, '160511000-19-Dec-2020-06-49-23-Contoh-File-Bimbingan.pdf', 49),
(4, 'update', 'Mahasiswa 1', '2020-12-20 14:07:25', 16, '160511000-19-Dec-2020-06-49-23-Contoh-File-Bimbingan.pdf', 49),
(5, 'insert', 'Mahasiswa1', '2020-12-20 17:47:43', 17, '160511000-21-Dec-2020-12-47-43-Contoh-File-Bimbingan.pdf', 52),
(6, 'insert', 'Mahasiswa 1', '2020-12-20 20:24:52', 18, '160511000-21-Dec-2020-03-24-52-Contoh-File-Hasil_Bimbingan.pdf', 53),
(7, 'update', 'Mahasiswa 1', '2020-12-20 20:24:57', 18, '160511000-21-Dec-2020-03-24-52-Contoh-File-Hasil_Bimbingan.pdf', 53),
(8, 'update', 'Tatang', '2021-01-10 06:15:47', 9, '160511013-Contoh-File-Laporan.pdf', 20);

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
(1, 'insert', 'Agust Isa Martinus, M.T', '2020-11-01 18:56:46', 47, 49, '0421117105', NULL),
(2, 'update', 'Mahasiswa 1', '2020-11-01 19:09:41', 47, 49, '0421117105', NULL),
(3, 'insert', 'Agust Isa Martinus, M.T', '2020-11-02 03:28:45', 48, 49, '0408118304', NULL),
(4, 'update', 'Mahasiswa 1', '2020-11-22 17:55:22', 48, 49, '0408118304', NULL),
(5, 'update', 'Tatang', '2020-12-15 20:59:41', 48, 49, '0408118304', '160511000-23-Nov-2020-12-55-22-contoh lembar revisi.pdf'),
(6, 'update', 'Tatang', '2020-12-15 20:59:48', 48, 49, '0017057402', '160511000-23-Nov-2020-12-55-22-contoh lembar revisi.pdf'),
(7, 'insert', 'Agust Isa Martinus, M.T', '2020-12-19 11:03:39', 49, 51, '0421117105', NULL),
(8, 'update', 'Mahasiswa 1', '2020-12-19 11:46:34', 49, 51, '0421117105', NULL),
(9, 'insert', 'Agust Isa Martinus, M.T', '2020-12-20 16:06:07', 50, 10, '', NULL),
(10, 'update', 'Tatang', '2020-12-20 16:34:59', 49, 51, '0421117105', '160511000-19-Dec-2020-06-46-34-c7f8b5ca27404a7094dd253e746ffccd.pdf'),
(11, 'update', 'Tatang', '2020-12-20 16:35:06', 49, 51, '0408118304', '160511000-19-Dec-2020-06-46-34-c7f8b5ca27404a7094dd253e746ffccd.pdf'),
(12, 'insert', 'Agust Isa Martinus, M.T', '2020-12-20 17:19:31', 51, 53, '', NULL),
(13, 'insert', 'Agust Isa Martinus, M.T', '2020-12-20 17:24:47', 52, 54, '0421117105', NULL),
(14, 'update', 'Mahasiswa1', '2020-12-20 17:45:57', 52, 54, '0421117105', NULL),
(15, 'insert', 'Agust Isa Martinus, M.T', '2020-12-20 20:21:09', 53, 58, '0421117105', NULL),
(16, 'update', 'Mahasiswa 1', '2020-12-20 20:23:49', 53, 58, '0421117105', NULL),
(17, 'update', 'Tatang', '2021-01-10 06:15:47', 20, 32, '0416086408', '160511030-Lembar-Revisi-Contoh.pdf');

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
(1, 1, '0402057307', 'Penguji 1', 'Aktif', '2020-11-01 16:18:59'),
(2, 1, '0409046101', 'Penguji 2', 'Aktif', '2020-11-01 16:18:59'),
(3, 2, '0416086408', 'Penguji 1', 'Aktif', '2020-11-01 16:18:59'),
(4, 2, '0406067407', 'Penguji 2', 'Aktif', '2020-11-01 16:18:59'),
(5, 3, '0409046101', 'Penguji 1', 'Tidak Aktif', '2020-11-01 16:18:59'),
(6, 3, '0428117601', 'Penguji 2', 'Tidak Aktif', '2020-11-01 16:18:59'),
(7, 4, '0402057307', 'Penguji 1', 'Aktif', '2020-11-01 16:18:59'),
(8, 4, '0405108905', 'Penguji 2', 'Aktif', '2020-11-01 16:18:59'),
(9, 5, '0402057307', 'Penguji 1', 'Aktif', '2020-11-01 16:18:59'),
(10, 5, '0408118304', 'Penguji 2', 'Aktif', '2020-11-01 16:18:59'),
(11, 6, '0416086408', 'Penguji 1', 'Aktif', '2020-11-01 16:18:59'),
(12, 6, '0408118304', 'Penguji 2', 'Aktif', '2020-11-01 16:18:59'),
(13, 7, '0421117105', 'Penguji 1', 'Aktif', '2020-11-01 16:18:59'),
(14, 7, '0403079201', 'Penguji 2', 'Aktif', '2020-11-01 16:18:59'),
(15, 8, '0416086408', 'Penguji 1', 'Aktif', '2020-11-01 16:18:59'),
(16, 8, '0402057307', 'Penguji 2', 'Aktif', '2020-11-01 16:18:59'),
(17, 9, '0421117105', 'Penguji 1', 'Aktif', '2020-11-01 16:18:59'),
(18, 9, '0428117601', 'Penguji 2', 'Aktif', '2020-11-01 16:18:59'),
(21, 11, '0421117105', 'Penguji 1', 'Aktif', '2020-11-01 16:18:59'),
(22, 11, '0402057307', 'Penguji 2', 'Aktif', '2020-11-01 16:18:59'),
(23, 12, '0421117105', 'Penguji 1', 'Aktif', '2020-11-01 16:18:59'),
(24, 12, '0402057307', 'Penguji 2', 'Aktif', '2020-11-01 16:18:59'),
(26, 13, '0403079201', 'Penguji 2', 'Aktif', '2020-11-01 16:18:59'),
(29, 15, '0421117105', 'Penguji 1', 'Aktif', '2020-11-01 16:18:59'),
(30, 15, '0402057307', 'Penguji 2', 'Aktif', '2020-11-01 16:18:59'),
(54, 3, '0017057402', 'Penguji 1', 'Tidak Aktif', '2020-11-01 16:18:59'),
(55, 3, '0405108905', 'Penguji 2', 'Tidak Aktif', '2020-11-01 16:18:59'),
(56, 3, '0428117601', 'Penguji 1', 'Aktif', '2020-11-01 16:18:59'),
(57, 3, '0409046101', 'Penguji 2', 'Aktif', '2020-11-01 16:18:59'),
(65, 13, '0425036001', 'Penguji 1', 'Aktif', '2020-11-01 16:18:59'),
(70, 16, '0402057307', 'Penguji 1', 'Aktif', '2020-11-01 16:18:59'),
(71, 16, '0405108905', 'Penguji 2', 'Aktif', '2020-11-01 16:18:59'),
(80, 10, '0408118304', 'Penguji 1', 'Aktif', '2020-11-01 16:18:59'),
(81, 10, '0405108905', 'Penguji 2', 'Aktif', '2020-11-01 16:18:59'),
(91, 23, '0405108905', 'Penguji 2', 'Aktif', '2020-11-01 16:18:59'),
(95, 23, '0408118304', 'Penguji 1', 'Aktif', '2020-11-01 16:18:59'),
(104, 30, '0416086408', 'Penguji 1', 'Aktif', '2020-12-20 20:23:17'),
(105, 30, '0408118304', 'Penguji 2', 'Aktif', '2020-12-20 20:23:17');

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
(1, 17, 2, NULL, '2020-07-03', '09:00', 'Lab Peternakan', 'Lulus'),
(2, 6, 2, NULL, '2020-07-06', '09:00', 'Lab Peternakan', 'Lulus'),
(3, 7, 2, NULL, '2020-07-03', '13:00', 'Lab Informatika', 'Lulus'),
(4, 8, 2, NULL, '2020-07-02', '11:00', 'Lab Informatika', 'Tidak Lulus'),
(5, 9, 2, NULL, '2020-07-01', '09:00', 'Lab Peternakan', 'Lulus'),
(6, 10, 2, NULL, '2020-07-06', '10:00', 'Lab Peternakan', 'Lulus'),
(7, 12, 2, NULL, '2020-07-01', '09:00', 'Lab Informatika', 'Lulus'),
(8, 13, 2, NULL, '2020-07-01', '10:00', 'Lab Informatika', 'Lulus'),
(9, 14, 2, NULL, '2020-07-03', '09:00', 'Lab Informatika', 'Lulus'),
(10, 15, 2, NULL, '2020-07-01', '11:00', 'Lab Peternakan', 'Tidak Lulus'),
(11, 16, 2, NULL, '2020-07-02', '10:00', 'Lab Peternakan', 'Lulus'),
(12, 18, 2, NULL, '2020-07-01', '11:00', 'Lab Informatika', 'Lulus'),
(13, 19, 2, NULL, '2020-07-02', '10:00', 'Lab Informatika', 'Lulus'),
(15, 21, 2, NULL, '2020-07-02', '09:00', 'Lab Peternakan', 'Lulus'),
(16, 8, 2, NULL, '2020-07-08', '08:00', 'Perpustakaan', 'Lulus'),
(23, 15, 2, NULL, '2020-10-08', '10:00', 'Lab Informatika', 'Lulus'),
(30, 53, 2, 'asda', '2020-12-21', '11:00', 'Lab Informatika', 'Lulus');

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
(1, 'insert', 'Mahasiswa 1', '2020-11-01 19:00:30', 24, 47, 0, NULL, NULL, NULL, NULL, NULL),
(2, 'update', 'Dian Novianti, M.Kom', '2020-11-01 19:04:10', 24, 47, 0, NULL, NULL, NULL, NULL, NULL),
(3, 'update', 'Dian Novianti, M.Kom', '2020-11-01 19:07:17', 24, 47, 2, 'setuju', NULL, NULL, NULL, NULL),
(4, 'update', 'Harry Gunawan,M.Kom', '2020-11-01 19:07:56', 24, 47, 2, 'setuju', '2020-11-02', '09:00', 'Lab Informatika', NULL),
(5, 'insert', 'Mahasiswa 1', '2020-11-22 17:15:35', 25, 48, 0, NULL, NULL, NULL, NULL, NULL),
(6, 'insert', 'Mahasiswa 1', '2020-11-22 17:19:23', 26, 48, 0, NULL, NULL, NULL, NULL, NULL),
(7, 'update', 'Harry Gunawan,M.Kom', '2020-11-22 17:28:35', 25, 48, 0, NULL, NULL, NULL, NULL, NULL),
(8, 'update', 'Harry Gunawan,M.Kom', '2020-11-22 17:28:45', 25, 48, 2, 'asdas', NULL, NULL, NULL, NULL),
(9, 'update', 'Harry Gunawan,M.Kom', '2020-11-22 17:28:51', 25, 48, 1, 'asdas', NULL, NULL, NULL, NULL),
(10, 'update', 'Dian Novianti, M.Kom', '2020-11-22 17:50:55', 25, 48, 2, 'asdsa', NULL, NULL, NULL, NULL),
(11, 'update', 'Tatang', '2020-11-22 17:52:11', 25, 48, 2, 'asdsa', '2020-11-23', '14:44', 'Lab Informatika', NULL),
(12, 'insert', 'Mahasiswa 1', '2020-12-19 11:15:46', 27, 49, 0, NULL, NULL, NULL, NULL, NULL),
(13, 'update', 'Dian Novianti, M.Kom', '2020-12-19 11:43:15', 27, 49, 0, NULL, NULL, NULL, NULL, NULL),
(14, 'update', 'Dian Novianti, M.Kom', '2020-12-19 11:44:38', 27, 49, 2, 'oke', NULL, NULL, NULL, NULL),
(15, 'update', 'Tatang', '2020-12-19 11:45:26', 27, 49, 2, 'oke', '2020-12-21', '11:00', 'Lab Informatika', NULL),
(16, 'insert', 'Mohamad Irfan Manaf', '2020-12-20 13:05:55', 28, 17, 0, NULL, NULL, NULL, NULL, NULL),
(17, 'insert', 'Mahasiswa1', '2020-12-20 17:40:25', 29, 52, 0, NULL, NULL, NULL, NULL, NULL),
(18, 'update', 'Dian Novianti, M.Kom', '2020-12-20 17:41:08', 29, 52, 0, NULL, NULL, NULL, NULL, NULL),
(19, 'update', 'Dian Novianti, M.Kom', '2020-12-20 17:42:04', 29, 52, 2, 'oke', NULL, NULL, NULL, NULL),
(20, 'update', 'Tatang', '2020-12-20 17:44:02', 29, 52, 2, 'oke', '2020-12-21', '11:00', '', NULL),
(21, 'update', 'Tatang', '2020-12-20 17:45:39', 29, 52, 2, 'oke', '2020-12-21', '11:00', 'Lab Informatika', NULL),
(22, 'insert', 'Mahasiswa 1', '2020-12-20 20:22:34', 30, 53, 0, NULL, NULL, NULL, NULL, NULL),
(23, 'update', 'Dian Novianti, M.Kom', '2020-12-20 20:22:46', 30, 53, 0, NULL, NULL, NULL, NULL, NULL),
(24, 'update', 'Dian Novianti, M.Kom', '2020-12-20 20:23:17', 30, 53, 2, 'asda', NULL, NULL, NULL, NULL),
(25, 'update', 'Tatang', '2020-12-20 20:23:37', 30, 53, 2, 'asda', '2020-12-21', '11:00', 'Lab Informatika', NULL),
(26, 'update', 'Tatang', '2021-01-10 06:15:47', 14, 20, 2, NULL, '2020-07-03', '14:00', 'Lab Peternakan', 'Lulus');

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
(5, '160511000-19-Dec-2020-06-15-46-c7f8b5ca27404a7094dd253e746ffccd.pdf', 2, '1'),
(6, '160511000-19-Dec-2020-06-15-46-c7f8b5ca27404a7094dd253e746ffccd.pdf', 2, '2'),
(7, '160511000-19-Dec-2020-06-15-46-c7f8b5ca27404a7094dd253e746ffccd.pdf', 2, '3'),
(8, '160511000-19-Dec-2020-06-15-46-c7f8b5ca27404a7094dd253e746ffccd.pdf', 2, '4'),
(9, '160511000-19-Dec-2020-06-15-46-c7f8b5ca27404a7094dd253e746ffccd.pdf', 2, '5'),
(10, '160511000-19-Dec-2020-06-15-46-c7f8b5ca27404a7094dd253e746ffccd.pdf', 2, '6'),
(11, '160511000-19-Dec-2020-06-15-46-c7f8b5ca27404a7094dd253e746ffccd.pdf', 2, '7'),
(12, '160511000-19-Dec-2020-06-15-46-c7f8b5ca27404a7094dd253e746ffccd.pdf', 2, '8'),
(13, '160511000-19-Dec-2020-06-15-46-c7f8b5ca27404a7094dd253e746ffccd.pdf', 2, '9'),
(14, '160511000-19-Dec-2020-06-15-46-c7f8b5ca27404a7094dd253e746ffccd.pdf', 2, '10'),
(15, '160511000-19-Dec-2020-06-15-46-c7f8b5ca27404a7094dd253e746ffccd.pdf', 2, '11'),
(16, '160511000-19-Dec-2020-06-15-46-c7f8b5ca27404a7094dd253e746ffccd.pdf', 2, '12'),
(17, '160511000-19-Dec-2020-06-15-46-c7f8b5ca27404a7094dd253e746ffccd.pdf', 2, '13'),
(19, '160511000-19-Dec-2020-06-15-46-c7f8b5ca27404a7094dd253e746ffccd.pdf', 2, '15'),
(20, '160511000-19-Dec-2020-06-15-46-c7f8b5ca27404a7094dd253e746ffccd.pdf', 2, '16'),
(21, '160511000-19-Dec-2020-06-15-46-c7f8b5ca27404a7094dd253e746ffccd.pdf', 2, '23'),
(23, '160511000-21-Dec-2020-03-22-34-c7f8b5ca27404a7094dd253e746ffccd.pdf', 2, '30');

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
(1, 17, '160511030-Contoh-Lembar-REvisi.pdf', NULL),
(2, 6, NULL, NULL),
(3, 7, NULL, NULL),
(7, 8, NULL, NULL),
(8, 9, NULL, NULL),
(11, 10, NULL, NULL),
(12, 11, NULL, NULL),
(13, 12, NULL, NULL),
(14, 13, NULL, NULL),
(15, 14, NULL, NULL),
(16, 15, NULL, NULL),
(17, 16, NULL, NULL),
(18, 18, NULL, NULL),
(19, 19, NULL, NULL),
(21, 21, NULL, NULL),
(50, 53, '160511000-21-Dec-2020-03-29-15-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511000-21-Dec-2020-03-39-30-c7f8b5ca27404a7094dd253e746ffccd.pdf');

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
(1, 3, 'Bimbingan Draft Bab 4', 'Bimbingan Draft', '2020-08-27', '160511013', '0416086408', '160511013-Contoh-File-Bimbingan.pdf', NULL, 'Perbaikan bab 1,3 dan 4123555\r\nTabel id creator\r\nRequirment Fungsional. Performance, Deployment, Development', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Draft', 'Dibalas', 'Belum Dibaca', 'Revisi'),
(2, 3, 'Bimbingan Draft Bab 5', 'Bimbingan Draft', '2020-09-01', '160511013', '0416086408', '160511013-Contoh-File-Bimbingan.pdf', NULL, 'Implementasi Koding2 utama dibahas atau dijelaskan', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Draft', 'Dibalas', 'Dibaca', 'Revisi'),
(3, 3, 'Bimbingan Draft Bab 6', 'Bimbingan Draft', '2020-09-18', '160511013', '0416086408', '160511013-Contoh-File-Bimbingan.pdf', NULL, 'Draft OK. Kesimpulan dirangkum', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Draft', 'Dibalas', 'Dibaca', 'Lanjut Bab'),
(4, 1, 'BAB 4', 'Bimbingan Bab 1-4', '2020-09-29', '160511030', '0416086408', '160511030-Contoh-File-Bimbingan.pdf', '2020-09-24', 'Desain Program', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Draft', 'Dibalas', 'Dibaca', 'Lanjut Bab'),
(16, 1, 'BAB 5', 'BAB 5', '2020-10-12', '160511030', '0416086408', '160511030-Contoh-File-Bimbingan.pdf', '2020-10-12', 'BAB 5 Implementasi Sistem', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Draft', 'Dibalas', 'Dibaca', 'Lanjut Bab'),
(17, 1, 'BAB 6 & 7', 'BAB 6, dan 7', '2020-10-19', '160511030', '0416086408', '160511030-Contoh-File-Bimbingan.pdf', '2020-10-19', '1. Bahas Lebih Detail Fungsi-fungsi utama\r\n2. Kesimpulan Diringkas menjadi 5 point\r\n3. saran', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Draft', 'Dibalas', 'Dibaca', 'Lanjut Bab'),
(18, 1, 'Program', 'demo program', '2020-10-27', '160511030', '0416086408', '160511030-Contoh-File-Bimbingan.pdf', '2020-10-27', 'Demo Program', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Draft', 'Dibalas', 'Dibaca', 'Layak'),
(22, 19, 'Bab 7', 'Bab 7', '2020-11-02', '160511001', '0408118304', '160511001-Contoh-File-Bimbingan.pdf', '2020-11-02', 'setuju', '0408118304-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Draft', 'Dibalas', 'Belum Dibaca', 'Layak'),
(23, 3, 'Bab 7', 'Bab 7', '2020-11-02', '160511013', '0416086408', '160511013-Contoh-File-Bimbingan.pdf', '2020-11-02', 'oke', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Draft', 'Dibalas', 'Belum Dibaca', 'Layak'),
(33, 50, 'asda', 'asda', '2020-12-21', '160511000', '0421117105', '160511000-21-Dec-2020-03-25-47-DRAFT 1 baru.pdf', '2020-12-21', 'asdas', '0421117105-21-Dec-2020-03-26-14-DRAFT 1 baru.pdf', 'Bimbingan Draft', 'Dibalas', 'Dibaca', 'Layak'),
(34, 50, 'Bimbingan 1', 'asda', '2020-12-21', '160511000', '0408118304', '160511000-21-Dec-2020-03-29-26-DRAFT 1 baru.pdf', NULL, 'asdas', '0408118304-21-Dec-2020-03-29-58-DRAFT 1 baru.pdf', 'Bimbingan Pendadaran', 'Dibalas', 'Dibaca', 'Layak'),
(35, 50, 'asda', 'asda', '2020-12-21', '160511000', '0408118304', '160511000-21-Dec-2020-03-39-41-DRAFT 1 baru.pdf', NULL, 'asdad', '0408118304-21-Dec-2020-03-40-16-DRAFT 1 baru.pdf', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Layak'),
(36, 1, 'asda', 'asdas', '2020-12-21', '160511030', '0416086408', '160511030-21-Dec-2020-08-09-41-DRAFT 1 baru.pdf', NULL, 'asdas', '0416086408-21-Dec-2020-08-10-16-DRAFT 1 baru.pdf', 'Bimbingan Pendadaran', 'Dibalas', 'Belum Dibaca', 'Layak');

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
(1, 'insert', 'Mahasiswa 1', '2020-11-01 19:13:26', 19, 44, 'Bab 1', 'bab 1', '2020-11-02', '160511000', '0421117105', '160511000-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Draft', 'Belum Dibaca', 'Belum Dibaca', NULL),
(2, 'update', 'Dian Novianti, M.Kom', '2020-11-01 19:13:49', 19, 44, 'Bab 1', 'bab 1', '2020-11-02', '160511000', '0421117105', '160511000-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Draft', 'Belum Dibaca', 'Belum Dibaca', NULL),
(3, 'update', 'Mahasiswa 1', '2020-11-01 19:14:27', 19, 44, 'Bab 1', 'bab 1', '2020-11-02', '160511000', '0421117105', '160511000-Contoh-File-Bimbingan.pdf', '2020-11-02', 'setuju', '0421117105-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Draft', 'Dibalas', 'Belum Dibaca', 'Layak'),
(4, 'insert', 'Mahasiswa 1', '2020-11-01 19:41:41', 20, 44, 'bab 1', 'bab 1', '2020-11-02', '160511000', '0416086408', '160511000-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Pendadaran', 'Belum Dibaca', 'Belum Dibaca', NULL),
(5, 'update', 'Agust Isa Martinus, M.T', '2020-11-01 19:42:23', 20, 44, 'bab 1', 'bab 1', '2020-11-02', '160511000', '0416086408', '160511000-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Pendadaran', 'Belum Dibaca', 'Belum Dibaca', NULL),
(6, 'update', 'Mahasiswa 1', '2020-11-01 19:42:31', 20, 44, 'bab 1', 'bab 1', '2020-11-02', '160511000', '0416086408', '160511000-Contoh-File-Bimbingan.pdf', NULL, 'ok', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pendadaran', 'Dibalas', 'Belum Dibaca', 'Layak'),
(7, 'insert', 'Mahasiswa 1', '2020-11-01 19:51:09', 21, 44, 'baba 1', 'bab 1', '2020-11-02', '160511000', '0416086408', '160511000-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', 'Belum Dibaca', NULL),
(8, 'update', 'Agust Isa Martinus, M.T', '2020-11-01 19:51:35', 21, 44, 'baba 1', 'bab 1', '2020-11-02', '160511000', '0416086408', '160511000-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', 'Belum Dibaca', NULL),
(9, 'update', 'Mahasiswa 1', '2020-11-01 19:51:51', 21, 44, 'baba 1', 'bab 1', '2020-11-02', '160511000', '0416086408', '160511000-Contoh-File-Bimbingan.pdf', NULL, 'bab 1', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Belum Dibaca', 'Layak'),
(10, 'insert', 'Andhika Budi Prasetya', '2020-11-01 21:30:37', 22, 19, 'Bab 7', 'Bab 7', '2020-11-02', '160511001', '0408118304', '160511001-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Draft', 'Belum Dibaca', 'Belum Dibaca', NULL),
(11, 'update', 'Harry Gunawan,M.Kom', '2020-11-01 21:31:18', 22, 19, 'Bab 7', 'Bab 7', '2020-11-02', '160511001', '0408118304', '160511001-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Draft', 'Belum Dibaca', 'Belum Dibaca', NULL),
(12, 'insert', 'Muhammad Irwan', '2020-11-01 21:34:12', 23, 3, 'Bab 7', 'Bab 7', '2020-11-02', '160511013', '0416086408', '160511013-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Draft', 'Belum Dibaca', 'Belum Dibaca', NULL),
(13, 'update', 'Agust Isa Martinus, M.T', '2020-11-01 21:34:28', 23, 3, 'Bab 7', 'Bab 7', '2020-11-02', '160511013', '0416086408', '160511013-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Draft', 'Belum Dibaca', 'Belum Dibaca', NULL),
(14, 'insert', 'Mahasiswa 1', '2020-11-22 18:31:11', 24, 45, 'asda', 'asd', '2020-11-23', '160511000', '0408118304', '160511000-23-Nov-2020-01-31-11-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Draft', 'Belum Dibaca', 'Belum Dibaca', NULL),
(15, 'update', 'Harry Gunawan,M.Kom', '2020-11-22 18:32:40', 24, 45, 'asda', 'asd', '2020-11-23', '160511000', '0408118304', '160511000-23-Nov-2020-01-31-11-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Draft', 'Belum Dibaca', 'Belum Dibaca', NULL),
(16, 'update', 'Mahasiswa 1', '2020-11-22 18:32:50', 24, 45, 'asda', 'asd', '2020-11-23', '160511000', '0408118304', '160511000-23-Nov-2020-01-31-11-Contoh-File-Bimbingan.pdf', '2020-11-23', 'asdsada', '0408118304-23-Nov-2020-01-32-40-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Draft', 'Dibalas', 'Belum Dibaca', 'Layak'),
(17, 'insert', 'Mahasiswa 1', '2020-11-23 06:15:38', 25, 45, 'Bimbingan 1', 'asdas', '2020-11-23', '160511000', '0416086408', '160511000-23-Nov-2020-01-15-38-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Pendadaran', 'Belum Dibaca', 'Belum Dibaca', NULL),
(18, 'update', 'Agust Isa Martinus, M.T', '2020-11-23 06:24:08', 25, 45, 'Bimbingan 1', 'asdas', '2020-11-23', '160511000', '0416086408', '160511000-23-Nov-2020-01-15-38-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Pendadaran', 'Belum Dibaca', 'Belum Dibaca', NULL),
(19, 'update', 'Mahasiswa 1', '2020-11-23 06:24:16', 25, 45, 'Bimbingan 1', 'asdas', '2020-11-23', '160511000', '0416086408', '160511000-23-Nov-2020-01-15-38-Contoh-File-Bimbingan.pdf', NULL, 'asdasd', '0416086408-23-Nov-2020-01-24-08-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pendadaran', 'Dibalas', 'Belum Dibaca', 'Layak'),
(20, 'insert', 'Mahasiswa 1', '2020-11-25 04:53:44', 26, 45, 'asda', 'asdas', '2020-11-25', '160511000', '0416086408', '160511000-25-Nov-2020-11-53-44-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', 'Belum Dibaca', NULL),
(21, 'update', 'Agust Isa Martinus, M.T', '2020-11-25 05:16:01', 26, 45, 'asda', 'asdas', '2020-11-25', '160511000', '0416086408', '160511000-25-Nov-2020-11-53-44-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', 'Belum Dibaca', NULL),
(22, 'insert', 'Mahasiswa 1', '2020-11-25 06:06:42', 27, 45, 'Bimbingan 1', 'a', '2020-11-25', '160511000', '0416086408', '160511000-25-Nov-2020-01-06-42-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', 'Belum Dibaca', NULL),
(23, 'update', 'Agust Isa Martinus, M.T', '2020-11-25 06:08:00', 27, 45, 'Bimbingan 1', 'a', '2020-11-25', '160511000', '0416086408', '160511000-25-Nov-2020-01-06-42-Contoh-File-Bimbingan.pdf', NULL, NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', 'Belum Dibaca', NULL),
(24, 'update', 'Mahasiswa 1', '2020-11-25 06:08:18', 27, 45, 'Bimbingan 1', 'a', '2020-11-25', '160511000', '0416086408', '160511000-25-Nov-2020-01-06-42-Contoh-File-Bimbingan.pdf', NULL, 'asda', '0416086408-25-Nov-2020-01-08-00-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Belum Dibaca', 'Layak'),
(25, 'update', 'Agust Isa Martinus, M.T', '2020-12-15 19:17:32', 27, 45, 'Bimbingan 1', 'a', '2020-11-25', '160511000', '0416086408', '160511000-25-Nov-2020-01-06-42-Contoh-File-Bimbingan.pdf', NULL, 'asda', '0416086408-25-Nov-2020-01-08-00-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Dibaca', 'Layak'),
(26, 'update', 'Agust Isa Martinus, M.T', '2020-12-15 19:32:07', 27, 45, 'Bimbingan 1', 'a', '2020-11-25', '160511000', '0416086408', '160511000-25-Nov-2020-01-06-42-Contoh-File-Bimbingan.pdf', NULL, 'asda123', '0416086408-25-Nov-2020-01-08-00-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Belum Dibaca', 'Layak'),
(27, 'update', 'Agust Isa Martinus, M.T', '2020-12-15 19:56:49', 1, 3, 'Bimbingan Draft Bab 4', 'Bimbingan Draft', '2020-08-27', '160511013', '0416086408', '160511013-Contoh-File-Bimbingan.pdf', NULL, 'Perbaikan bab 1,3 dan 4\r\nTabel id creator\r\nRequirment Fungsional. Performance, Deployment, Development', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Draft', 'Dibalas', 'Dibaca', 'Revisi'),
(28, 'update', 'Agust Isa Martinus, M.T', '2020-12-15 20:11:29', 27, 45, 'Bimbingan 1', 'a', '2020-11-25', '160511000', '0416086408', '160511000-25-Nov-2020-01-06-42-Contoh-File-Bimbingan.pdf', NULL, 'asda123312', '0416086408-25-Nov-2020-01-08-00-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Pasca', 'Dibalas', 'Belum Dibaca', 'Layak'),
(29, 'update', 'Agust Isa Martinus, M.T', '2020-12-15 20:13:48', 1, 3, 'Bimbingan Draft Bab 4', 'Bimbingan Draft', '2020-08-27', '160511013', '0416086408', '160511013-Contoh-File-Bimbingan.pdf', NULL, 'Perbaikan bab 1,3 dan 4123\r\nTabel id creator\r\nRequirment Fungsional. Performance, Deployment, Development', '0416086408-Contoh-File-Hasil_Bimbingan.pdf', 'Bimbingan Draft', 'Dibalas', 'Belum Dibaca', 'Revisi'),
(30, 'insert', 'Mahasiswa 1', '2020-12-20 14:20:30', 28, 46, 'Bimbingan Bab 1', 'Bab 1', '2020-12-20', '160511000', '0421117105', '160511000-20-Dec-2020-09-20-30-DRAFT 1 baru.pdf', NULL, NULL, NULL, 'Bimbingan Draft', 'Belum Dibaca', 'Belum Dibaca', NULL),
(31, 'update', 'Dian Novianti, M.Kom', '2020-12-20 14:22:13', 28, 46, 'Bimbingan Bab 1', 'Bab 1', '2020-12-20', '160511000', '0421117105', '160511000-20-Dec-2020-09-20-30-DRAFT 1 baru.pdf', NULL, NULL, NULL, 'Bimbingan Draft', 'Belum Dibaca', 'Belum Dibaca', NULL),
(32, 'update', 'Dian Novianti, M.Kom', '2020-12-20 14:22:26', 28, 46, 'Bimbingan Bab 1', 'Bab 1', '2020-12-20', '160511000', '0421117105', '160511000-20-Dec-2020-09-20-30-DRAFT 1 baru.pdf', '2020-12-20', 'asdas', '0421117105-20-Dec-2020-09-22-13-DRAFT 1 baru.pdf', 'Bimbingan Draft', 'Dibalas', 'Belum Dibaca', ''),
(33, 'insert', 'Mahasiswa1', '2020-12-20 17:49:50', 29, 49, 'Bimbingan 1', 'Nim', '2020-12-21', '160511000', '0421117105', '160511000-21-Dec-2020-12-49-50-DRAFT 1 baru.pdf', NULL, NULL, NULL, 'Bimbingan Draft', 'Belum Dibaca', 'Belum Dibaca', NULL),
(34, 'insert', 'Mahasiswa1', '2020-12-20 17:50:04', 30, 49, 'Bimbingan 1', 'Bimbingan', '2020-12-21', '160511000', '0408118304', '160511000-21-Dec-2020-12-50-04-DRAFT 1 baru.pdf', NULL, NULL, NULL, 'Bimbingan Draft', 'Belum Dibaca', 'Belum Dibaca', NULL),
(35, 'update', 'Dian Novianti, M.Kom', '2020-12-20 17:50:27', 29, 49, 'Bimbingan 1', 'Nim', '2020-12-21', '160511000', '0421117105', '160511000-21-Dec-2020-12-49-50-DRAFT 1 baru.pdf', NULL, NULL, NULL, 'Bimbingan Draft', 'Belum Dibaca', 'Belum Dibaca', NULL),
(36, 'update', 'Harry Gunawan,M.Kom', '2020-12-20 17:50:50', 30, 49, 'Bimbingan 1', 'Bimbingan', '2020-12-21', '160511000', '0408118304', '160511000-21-Dec-2020-12-50-04-DRAFT 1 baru.pdf', NULL, NULL, NULL, 'Bimbingan Draft', 'Belum Dibaca', 'Belum Dibaca', NULL),
(37, 'update', 'Mahasiswa1', '2020-12-20 17:51:02', 29, 49, 'Bimbingan 1', 'Nim', '2020-12-21', '160511000', '0421117105', '160511000-21-Dec-2020-12-49-50-DRAFT 1 baru.pdf', '2020-12-21', 'oke layak', '0421117105-21-Dec-2020-12-50-27-DRAFT 1 baru.pdf', 'Bimbingan Draft', 'Dibalas', 'Belum Dibaca', 'Layak'),
(38, 'update', 'Mahasiswa1', '2020-12-20 17:51:04', 30, 49, 'Bimbingan 1', 'Bimbingan', '2020-12-21', '160511000', '0408118304', '160511000-21-Dec-2020-12-50-04-DRAFT 1 baru.pdf', '2020-12-21', 'oke', '0408118304-21-Dec-2020-12-50-50-DRAFT 1 baru.pdf', 'Bimbingan Draft', 'Dibalas', 'Belum Dibaca', 'Layak'),
(39, 'update', 'Harry Gunawan,M.Kom', '2020-12-20 17:53:48', 30, 49, 'Bimbingan 1', 'Bimbingan', '2020-12-21', '160511000', '0408118304', '160511000-21-Dec-2020-12-50-04-DRAFT 1 baru.pdf', '2020-12-21', 'oke', '0408118304-21-Dec-2020-12-50-50-DRAFT 1 baru.pdf', 'Bimbingan Draft', 'Dibalas', 'Dibaca', 'Layak'),
(40, 'update', 'Dian Novianti, M.Kom', '2020-12-20 17:54:00', 29, 49, 'Bimbingan 1', 'Nim', '2020-12-21', '160511000', '0421117105', '160511000-21-Dec-2020-12-49-50-DRAFT 1 baru.pdf', '2020-12-21', 'oke layak', '0421117105-21-Dec-2020-12-50-27-DRAFT 1 baru.pdf', 'Bimbingan Draft', 'Dibalas', 'Dibaca', 'Layak'),
(41, 'update', 'Mahasiswa1', '2020-12-20 17:54:28', 29, 49, 'Bimbingan 1', 'Nim', '2020-12-21', '160511000', '0421117105', '160511000-21-Dec-2020-12-49-50-DRAFT 1 baru.pdf', '2020-12-21', 'Bimbingan', '0421117105-21-Dec-2020-12-50-27-DRAFT 1 baru.pdf', 'Bimbingan Draft', 'Dibalas', 'Belum Dibaca', 'Layak'),
(42, 'update', 'Mahasiswa1', '2020-12-20 17:54:46', 30, 49, 'Bimbingan 1', 'Bimbingan', '2020-12-21', '160511000', '0408118304', '160511000-21-Dec-2020-12-50-04-DRAFT 1 baru.pdf', '2020-12-21', 'Bimbingan Bab 1', '0408118304-21-Dec-2020-12-50-50-DRAFT 1 baru.pdf', 'Bimbingan Draft', 'Dibalas', 'Belum Dibaca', 'Layak'),
(43, 'insert', 'Mahasiswa1', '2020-12-20 19:18:21', 31, 49, 'Bimbingan 1', 'Bab 1', '2020-12-21', '160511000', '0416086408', '160511000-21-Dec-2020-02-18-21-DRAFT 1 baru.pdf', NULL, NULL, NULL, 'Bimbingan Pendadaran', 'Belum Dibaca', 'Belum Dibaca', NULL),
(44, 'update', 'Agust Isa Martinus, M.T', '2020-12-20 19:21:55', 31, 49, 'Bimbingan 1', 'Bab 1', '2020-12-21', '160511000', '0416086408', '160511000-21-Dec-2020-02-18-21-DRAFT 1 baru.pdf', NULL, NULL, NULL, 'Bimbingan Pendadaran', 'Belum Dibaca', 'Belum Dibaca', NULL),
(45, 'update', 'Mahasiswa1', '2020-12-20 19:27:43', 31, 49, 'Bimbingan 1', 'Bab 1', '2020-12-21', '160511000', '0416086408', '160511000-21-Dec-2020-02-18-21-DRAFT 1 baru.pdf', NULL, 'ok', '0416086408-21-Dec-2020-02-21-55-DRAFT 1 baru.pdf', 'Bimbingan Pendadaran', 'Dibalas', 'Belum Dibaca', 'Layak'),
(46, 'insert', 'Mahasiswa1', '2020-12-20 19:37:58', 32, 49, 'asdaasdadsdsad', 'asdsad', '2020-12-21', '160511000', '0416086408', '160511000-21-Dec-2020-02-37-58-DRAFT 1 baru.pdf', NULL, NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', 'Belum Dibaca', NULL),
(47, 'update', 'Agust Isa Martinus, M.T', '2020-12-20 19:38:48', 32, 49, 'asdaasdadsdsad', 'asdsad', '2020-12-21', '160511000', '0416086408', '160511000-21-Dec-2020-02-37-58-DRAFT 1 baru.pdf', NULL, NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', 'Belum Dibaca', NULL),
(48, 'update', 'Mahasiswa1', '2020-12-20 19:38:53', 32, 49, 'asdaasdadsdsad', 'asdsad', '2020-12-21', '160511000', '0416086408', '160511000-21-Dec-2020-02-37-58-DRAFT 1 baru.pdf', NULL, 'asda', '0416086408-21-Dec-2020-02-38-48-DRAFT 1 baru.pdf', 'Bimbingan Pasca', 'Dibalas', 'Belum Dibaca', 'Layak'),
(49, 'insert', 'Mahasiswa 1', '2020-12-20 20:25:48', 33, 50, 'asda', 'asda', '2020-12-21', '160511000', '0421117105', '160511000-21-Dec-2020-03-25-47-DRAFT 1 baru.pdf', NULL, NULL, NULL, 'Bimbingan Draft', 'Belum Dibaca', 'Belum Dibaca', NULL),
(50, 'update', 'Dian Novianti, M.Kom', '2020-12-20 20:26:14', 33, 50, 'asda', 'asda', '2020-12-21', '160511000', '0421117105', '160511000-21-Dec-2020-03-25-47-DRAFT 1 baru.pdf', NULL, NULL, NULL, 'Bimbingan Draft', 'Belum Dibaca', 'Belum Dibaca', NULL),
(51, 'update', 'Mahasiswa 1', '2020-12-20 20:26:34', 33, 50, 'asda', 'asda', '2020-12-21', '160511000', '0421117105', '160511000-21-Dec-2020-03-25-47-DRAFT 1 baru.pdf', '2020-12-21', 'asdas', '0421117105-21-Dec-2020-03-26-14-DRAFT 1 baru.pdf', 'Bimbingan Draft', 'Dibalas', 'Belum Dibaca', 'Layak'),
(52, 'insert', 'Mahasiswa 1', '2020-12-20 20:29:26', 34, 50, 'Bimbingan 1', 'asda', '2020-12-21', '160511000', '0408118304', '160511000-21-Dec-2020-03-29-26-DRAFT 1 baru.pdf', NULL, NULL, NULL, 'Bimbingan Pendadaran', 'Belum Dibaca', 'Belum Dibaca', NULL),
(53, 'update', 'Harry Gunawan,M.Kom', '2020-12-20 20:29:58', 34, 50, 'Bimbingan 1', 'asda', '2020-12-21', '160511000', '0408118304', '160511000-21-Dec-2020-03-29-26-DRAFT 1 baru.pdf', NULL, NULL, NULL, 'Bimbingan Pendadaran', 'Belum Dibaca', 'Belum Dibaca', NULL),
(54, 'update', 'Mahasiswa 1', '2020-12-20 20:30:12', 34, 50, 'Bimbingan 1', 'asda', '2020-12-21', '160511000', '0408118304', '160511000-21-Dec-2020-03-29-26-DRAFT 1 baru.pdf', NULL, 'asdas', '0408118304-21-Dec-2020-03-29-58-DRAFT 1 baru.pdf', 'Bimbingan Pendadaran', 'Dibalas', 'Belum Dibaca', 'Layak'),
(55, 'insert', 'Mahasiswa 1', '2020-12-20 20:39:41', 35, 50, 'asda', 'asda', '2020-12-21', '160511000', '0408118304', '160511000-21-Dec-2020-03-39-41-DRAFT 1 baru.pdf', NULL, NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', 'Belum Dibaca', NULL),
(56, 'update', 'Harry Gunawan,M.Kom', '2020-12-20 20:40:16', 35, 50, 'asda', 'asda', '2020-12-21', '160511000', '0408118304', '160511000-21-Dec-2020-03-39-41-DRAFT 1 baru.pdf', NULL, NULL, NULL, 'Bimbingan Pasca', 'Belum Dibaca', 'Belum Dibaca', NULL),
(57, 'update', 'Mahasiswa 1', '2020-12-20 20:40:31', 35, 50, 'asda', 'asda', '2020-12-21', '160511000', '0408118304', '160511000-21-Dec-2020-03-39-41-DRAFT 1 baru.pdf', NULL, 'asdad', '0408118304-21-Dec-2020-03-40-16-DRAFT 1 baru.pdf', 'Bimbingan Pasca', 'Dibalas', 'Belum Dibaca', 'Layak'),
(58, 'insert', 'Mohamad Irfan Manaf', '2020-12-21 01:09:41', 36, 1, 'asda', 'asdas', '2020-12-21', '160511030', '0416086408', '160511030-21-Dec-2020-08-09-41-DRAFT 1 baru.pdf', NULL, NULL, NULL, 'Bimbingan Pendadaran', 'Belum Dibaca', 'Belum Dibaca', NULL),
(59, 'update', 'Agust Isa Martinus, M.T', '2020-12-21 01:10:16', 36, 1, 'asda', 'asdas', '2020-12-21', '160511030', '0416086408', '160511030-21-Dec-2020-08-09-41-DRAFT 1 baru.pdf', NULL, NULL, NULL, 'Bimbingan Pendadaran', 'Belum Dibaca', 'Belum Dibaca', NULL);

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
(1, '0416086408', 1, 'Pembimbing 1', 'Aktif', '2020-11-01 16:28:05'),
(2, '0428117601', 1, 'Pembimbing 2', 'Aktif', '2020-11-01 16:28:05'),
(3, '0421117105', 2, 'Pembimbing 1', 'Aktif', '2020-11-01 16:28:05'),
(4, '0416086408', 2, 'Pembimbing 2', 'Aktif', '2020-11-01 16:28:05'),
(5, '0416086408', 3, 'Pembimbing 1', 'Aktif', '2020-11-01 16:28:05'),
(6, '0428117601', 3, 'Pembimbing 2', 'Aktif', '2020-11-01 16:28:05'),
(11, '0408118304', 7, 'Pembimbing 1', 'Aktif', '2020-11-01 16:28:05'),
(12, '0421117105', 7, 'Pembimbing 2', 'Aktif', '2020-11-01 16:28:05'),
(13, '0406067407', 13, 'Pembimbing 1', 'Aktif', '2020-11-01 16:28:05'),
(14, '0416086408', 13, 'Pembimbing 2', 'Aktif', '2020-11-01 16:28:05'),
(15, '0408118304', 19, 'Pembimbing 1', 'Aktif', '2020-11-01 16:28:05'),
(16, '0406067407', 19, 'Pembimbing 2', 'Aktif', '2020-11-01 16:28:05'),
(17, '0017057402', 16, 'Pembimbing 1', 'Aktif', '2020-11-01 16:28:05'),
(18, '0406067407', 16, 'Pembimbing 2', 'Aktif', '2020-11-01 16:28:05'),
(19, '0406067407', 18, 'Pembimbing 1', 'Aktif', '2020-11-01 16:28:05'),
(20, '0421117105', 18, 'Pembimbing 2', 'Aktif', '2020-11-01 16:28:05'),
(21, '0408118304', 21, 'Pembimbing 1', 'Aktif', '2020-11-01 16:28:05'),
(22, '0428117601', 21, 'Pembimbing 2', 'Aktif', '2020-11-01 16:28:05'),
(23, '0416086408', 17, 'Pembimbing 1', 'Aktif', '2020-11-01 16:28:05'),
(24, '0421117105', 17, 'Pembimbing 2', 'Aktif', '2020-11-01 16:28:05'),
(25, '0416086408', 15, 'Pembimbing 1', 'Aktif', '2020-11-01 16:28:05'),
(26, '0409046101', 15, 'Pembimbing 2', 'Aktif', '2020-11-01 16:28:05'),
(27, '0402057307', 11, 'Pembimbing 1', 'Aktif', '2020-11-01 16:28:05'),
(28, '0421117105', 11, 'Pembimbing 2', 'Aktif', '2020-11-01 16:28:05'),
(29, '0406067407', 8, 'Pembimbing 1', 'Aktif', '2020-11-01 16:28:05'),
(30, '0408118304', 8, 'Pembimbing 2', 'Aktif', '2020-11-01 16:28:05'),
(31, '0406067407', 14, 'Pembimbing 1', 'Aktif', '2020-11-01 16:28:05'),
(32, '0416086408', 14, 'Pembimbing 2', 'Aktif', '2020-11-01 16:28:05'),
(61, '0421117105', 50, 'Pembimbing 1', 'Aktif', '2020-12-20 20:25:32'),
(62, '0416086408', 50, 'Pembimbing 2', 'Aktif', '2020-12-20 20:25:32');

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
(20, 50, '160511000-21-Dec-2020-03-41-10-d baru 1.docx', '160511000-21-Dec-2020-03-41-10-DRAFT 1 baru.pdf', '160511000-21-Dec-2020-03-41-10-contoh khs dan sertif kkm.pdf', '160511000-21-Dec-2020-03-41-10-Paper2.docx', '160511000-21-Dec-2020-03-41-10-Import.rar', '160511000-21-Dec-2020-03-41-10-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511000-21-Dec-2020-03-41-10-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511000-21-Dec-2020-03-41-10-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511000-21-Dec-2020-03-41-10-kerangka berfikir.jpg');

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
(3, 'insert', 'Mahasiswa 1', '2020-12-13 21:53:34', 18, 45, '160511000-14-Dec-2020-04-53-34-d baru 1.docx', '160511000-14-Dec-2020-04-53-34-DRAFT 1 baru.pdf', '160511000-14-Dec-2020-04-53-34-contoh khs dan sertif kkm.pdf', '160511000-14-Dec-2020-04-53-34-Paper2.docx', '160511000-14-Dec-2020-04-53-34-Import.rar', '160511000-14-Dec-2020-04-53-34-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511000-14-Dec-2020-04-53-34-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511000-14-Dec-2020-04-53-34-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511000-14-Dec-2020-04-53-34-kerangka berfikir.jpg'),
(4, 'insert', 'Mahasiswa 1', '2020-12-14 00:25:24', 18, 45, '160511000-14-Dec-2020-04-53-34-d baru 1.docx', '160511000-14-Dec-2020-04-53-34-DRAFT 1 baru.pdf', '160511000-14-Dec-2020-04-53-34-contoh khs dan sertif kkm.pdf', '160511000-14-Dec-2020-04-53-34-Paper2.docx', '160511000-14-Dec-2020-04-53-34-Import.rar', '160511000-14-Dec-2020-04-53-34-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511000-14-Dec-2020-04-53-34-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511000-14-Dec-2020-04-53-34-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511000-14-Dec-2020-04-53-34-kerangka berfikir.jpg'),
(5, 'insert', 'Mahasiswa 1', '2020-12-14 00:31:44', 18, 45, '160511000-14-Dec-2020-04-53-34-d baru 1.docx', '160511000-14-Dec-2020-07-25-24-DRAFT 1 baru.pdf', '160511000-14-Dec-2020-04-53-34-contoh khs dan sertif kkm.pdf', '160511000-14-Dec-2020-04-53-34-Paper2.docx', '160511000-14-Dec-2020-04-53-34-Import.rar', '160511000-14-Dec-2020-04-53-34-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511000-14-Dec-2020-04-53-34-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511000-14-Dec-2020-04-53-34-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511000-14-Dec-2020-04-53-34-kerangka berfikir.jpg'),
(6, 'insert', 'Mahasiswa 1', '2020-12-14 00:37:18', 18, 45, '160511000-14-Dec-2020-04-53-34-d baru 1.docx', '160511000-14-Dec-2020-07-31-44-DRAFT 1 baru.pdf', '160511000-14-Dec-2020-04-53-34-contoh khs dan sertif kkm.pdf', '160511000-14-Dec-2020-04-53-34-Paper2.docx', '160511000-14-Dec-2020-04-53-34-Import.rar', '160511000-14-Dec-2020-04-53-34-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511000-14-Dec-2020-04-53-34-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511000-14-Dec-2020-04-53-34-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511000-14-Dec-2020-04-53-34-kerangka berfikir.jpg'),
(7, 'insert', 'Mahasiswa 1', '2020-12-14 00:37:18', 18, 45, '160511000-14-Dec-2020-04-53-34-d baru 1.docx', '160511000-14-Dec-2020-07-37-18-DRAFT 1 baru.pdf', '160511000-14-Dec-2020-04-53-34-contoh khs dan sertif kkm.pdf', '160511000-14-Dec-2020-04-53-34-Paper2.docx', '160511000-14-Dec-2020-04-53-34-Import.rar', '160511000-14-Dec-2020-04-53-34-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511000-14-Dec-2020-04-53-34-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511000-14-Dec-2020-04-53-34-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511000-14-Dec-2020-04-53-34-kerangka berfikir.jpg'),
(8, 'insert', 'Mahasiswa1', '2020-12-20 19:43:37', 19, 49, '160511000-21-Dec-2020-02-43-37-Paper2.docx', '160511000-21-Dec-2020-02-43-37-DRAFT 1 baru.pdf', '160511000-21-Dec-2020-02-43-37-contoh khs dan sertif kkm.pdf', '160511000-21-Dec-2020-02-43-37-Paper2.docx', '160511000-21-Dec-2020-02-43-37-Import.rar', '160511000-21-Dec-2020-02-43-37-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511000-21-Dec-2020-02-43-37-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511000-21-Dec-2020-02-43-37-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511000-21-Dec-2020-02-43-37-kerangka berfikir.jpg'),
(9, 'insert', 'Mahasiswa 1', '2020-12-20 20:41:10', 20, 50, '160511000-21-Dec-2020-03-41-10-d baru 1.docx', '160511000-21-Dec-2020-03-41-10-DRAFT 1 baru.pdf', '160511000-21-Dec-2020-03-41-10-contoh khs dan sertif kkm.pdf', '160511000-21-Dec-2020-03-41-10-Paper2.docx', '160511000-21-Dec-2020-03-41-10-Import.rar', '160511000-21-Dec-2020-03-41-10-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511000-21-Dec-2020-03-41-10-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511000-21-Dec-2020-03-41-10-c7f8b5ca27404a7094dd253e746ffccd.pdf', '160511000-21-Dec-2020-03-41-10-kerangka berfikir.jpg');

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
(1, 'insert', 'Agust Isa Martinus, M.T', '2020-11-01 18:56:46', 44, 47, NULL, NULL),
(2, 'update', 'Mahasiswa 1', '2020-11-01 19:29:43', 44, 47, NULL, NULL),
(3, 'update', 'Mahasiswa 1', '2020-11-01 19:50:54', 44, 47, '160511000-contoh lembar revisi.pdf', NULL),
(4, 'insert', 'Agust Isa Martinus, M.T', '2020-11-02 03:28:45', 45, 48, NULL, NULL),
(5, 'update', 'Mahasiswa 1', '2020-11-23 06:15:23', 45, 48, NULL, NULL),
(6, 'update', 'Mahasiswa 1', '2020-11-25 04:53:30', 45, 48, '160511000-23-Nov-2020-01-15-23-contoh lembar revisi.pdf', NULL),
(7, 'update', 'Mahasiswa 1', '2020-11-25 05:15:34', 45, 48, '160511000-23-Nov-2020-01-15-23-contoh lembar revisi.pdf', '160511000-25-Nov-2020-11-53-30-contoh lembar revisi.pdf'),
(8, 'insert', 'Agust Isa Martinus, M.T', '2020-12-19 11:03:39', 46, 49, NULL, NULL),
(9, 'insert', 'Agust Isa Martinus, M.T', '2020-12-20 16:06:07', 47, 50, NULL, NULL),
(10, 'insert', 'Agust Isa Martinus, M.T', '2020-12-20 17:19:31', 48, 51, NULL, NULL),
(11, 'insert', 'Agust Isa Martinus, M.T', '2020-12-20 17:24:47', 49, 52, NULL, NULL),
(12, 'update', 'Mahasiswa1', '2020-12-20 19:17:02', 49, 52, NULL, NULL),
(13, 'update', 'Mahasiswa1', '2020-12-20 19:37:07', 49, 52, '160511000-21-Dec-2020-02-17-02-c7f8b5ca27404a7094dd253e746ffccd.pdf', NULL),
(14, 'insert', 'Agust Isa Martinus, M.T', '2020-12-20 20:21:09', 50, 53, NULL, NULL),
(15, 'update', 'Mahasiswa 1', '2020-12-20 20:29:15', 50, 53, NULL, NULL),
(16, 'update', 'Mahasiswa 1', '2020-12-20 20:39:30', 50, 53, '160511000-21-Dec-2020-03-29-15-c7f8b5ca27404a7094dd253e746ffccd.pdf', NULL),
(17, 'update', 'Tatang', '2021-01-10 06:15:47', 20, 20, NULL, NULL);

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
(3, '2020-10-25', '160511000-2020-10-24-20-52-54-Contoh-File-Bimbingan', 2, '', '160511001'),
(5, '2020-10-25', '160511000-2020-10-24-20-52-54-Contoh-File-Bimbingan', 2, '', '160511009'),
(9, '2020-10-25', '160511000-2020-10-24-20-52-54-Contoh-File-Bimbingan', 2, '', '160511026'),
(10, '2020-10-25', '160511000-2020-10-24-20-52-54-Contoh-File-Bimbingan', 2, '', '160511006'),
(16, '2020-10-25', '160511000-2020-10-24-20-52-54-Contoh-File-Bimbingan', 2, '', '160511031'),
(17, '2020-10-25', '160511000-2020-10-24-20-52-54-Contoh-File-Bimbingan', 2, '', '160511013'),
(22, '2020-10-25', '160511000-2020-10-24-20-52-54-Contoh-File-Bimbingan', 2, '', '160511030'),
(24, '2020-10-25', '160511000-2020-10-24-20-52-54-Contoh-File-Bimbingan', 2, '', '160511051'),
(28, '2020-10-25', '160511000-2020-10-24-20-52-54-Contoh-File-Bimbingan', 2, '', '160511039'),
(30, '2020-10-25', '160511000-2020-10-24-20-52-54-Contoh-File-Bimbingan', 2, '', '160511053'),
(31, '2020-10-25', '160511000-2020-10-24-20-52-54-Contoh-File-Bimbingan', 2, '', '160511040'),
(37, '2020-10-25', '160511000-2020-10-24-20-52-54-Contoh-File-Bimbingan', 2, '', '160511052'),
(38, '2020-10-25', '160511000-2020-10-24-20-52-54-Contoh-File-Bimbingan', 2, '', '160511060'),
(44, '2020-10-25', '160511000-2020-10-24-20-52-54-Contoh-File-Bimbingan', 2, '', '160511055'),
(45, '2020-10-25', '160511000-2020-10-24-20-52-54-Contoh-File-Bimbingan', 2, '', '160511054'),
(46, '2020-10-25', '160511000-2020-10-24-20-52-54-Contoh-File-Bimbingan', 2, '', '160511064'),
(54, '2020-10-25', '160511000-2020-10-24-20-52-54-Contoh-File-Bimbingan', 2, '', '160511063'),
(58, '2020-10-25', '160511000-2020-10-24-20-52-54-Contoh-File-Bimbingan', 2, '', '160511068'),
(64, '2020-12-21', '160511000-21-Dec-2020-03-21-24-c7f8b5ca27404a7094dd253e746ffccd.pdf', 2, 'asdas', '160511000');

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
(1, 'insert', 'Mahasiswa 1', '2020-11-01 18:57:31', 60, '2020-11-02', '160511000-2020-11-02-01-57-31-contoh khs dan sertif kkm.pdf', 0, NULL, '160511000'),
(2, 'update', 'Tatang', '2020-11-01 18:57:47', 60, '2020-11-02', '160511000-2020-11-02-01-57-31-contoh khs dan sertif kkm.pdf', 0, NULL, '160511000'),
(3, 'insert', 'Mahasiswa 1', '2020-11-22 16:52:35', 61, '2020-11-22', '160511000-22-Nov-2020-11-52-35-contoh lembar revisi.pdf', 0, NULL, '160511000'),
(4, 'update', 'Tatang', '2020-11-22 16:53:02', 61, '2020-11-22', '160511000-22-Nov-2020-11-52-35-contoh lembar revisi.pdf', 0, NULL, '160511000'),
(5, 'update', 'Tatang', '2020-11-22 16:53:18', 61, '2020-11-22', '160511000-22-Nov-2020-11-52-35-contoh lembar revisi.pdf', 2, '123', '160511000'),
(6, 'update', 'Tatang', '2020-11-22 16:53:23', 61, '2020-11-22', '160511000-22-Nov-2020-11-52-35-contoh lembar revisi.pdf', 1, '123', '160511000'),
(7, 'update', 'Tatang', '2020-12-15 20:43:28', 61, '2020-11-22', '160511000-22-Nov-2020-11-52-35-contoh lembar revisi.pdf', 2, '123', '160511000'),
(8, 'update', 'Tatang', '2020-12-15 20:43:35', 61, '2020-11-22', '160511000-22-Nov-2020-11-52-35-contoh lembar revisi.pdf', 1, '123ok', '160511000'),
(9, 'insert', 'Mahasiswa 1', '2020-12-19 11:04:59', 62, '2020-12-19', '160511000-19-Dec-2020-06-04-59-c7f8b5ca27404a7094dd253e746ffccd.pdf', 0, NULL, '160511000'),
(10, 'update', 'Tatang', '2020-12-19 11:05:19', 62, '2020-12-19', '160511000-19-Dec-2020-06-04-59-c7f8b5ca27404a7094dd253e746ffccd.pdf', 0, NULL, '160511000'),
(11, 'insert', 'Mahasiswa1', '2020-12-20 17:26:53', 63, '2020-12-21', '160511000-21-Dec-2020-12-26-53-c7f8b5ca27404a7094dd253e746ffccd.pdf', 0, NULL, '160511000'),
(12, 'update', 'Tatang', '2020-12-20 17:27:28', 63, '2020-12-21', '160511000-21-Dec-2020-12-26-53-c7f8b5ca27404a7094dd253e746ffccd.pdf', 0, NULL, '160511000'),
(13, 'insert', 'Mahasiswa 1', '2020-12-20 20:21:24', 64, '2020-12-21', '160511000-21-Dec-2020-03-21-24-c7f8b5ca27404a7094dd253e746ffccd.pdf', 0, NULL, '160511000'),
(14, 'update', 'Tatang', '2020-12-20 20:21:34', 64, '2020-12-21', '160511000-21-Dec-2020-03-21-24-c7f8b5ca27404a7094dd253e746ffccd.pdf', 0, NULL, '160511000'),
(15, 'update', 'Tatang', '2021-01-10 06:15:47', 59, '2020-10-25', '160511000-2020-10-24-20-52-54-Contoh-File-Bimbingan', 2, '', '160511070');

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

--
-- Dumping data untuk tabel `surat`
--

INSERT INTO `surat` (`id_surat`, `jenis`, `tanggal`, `nomor`) VALUES
(3, 'Observasi Praktik Kerja Lapangan (PKL)', '2020-12-29', '001'),
(4, 'Observasi Praktik Kerja Lapangan (PKL)', '2020-12-29', '002'),
(5, 'Observasi Praktik Kerja Lapangan (PKL)', '2020-12-29', '003'),
(6, 'Observasi Praktik Kerja Lapangan (PKL)', '2020-12-29', '004');

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
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT untuk tabel `dosen_wali_log`
--
ALTER TABLE `dosen_wali_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `draft_nilai`
--
ALTER TABLE `draft_nilai`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `draft_nilai_log`
--
ALTER TABLE `draft_nilai_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `draft_penguji`
--
ALTER TABLE `draft_penguji`
  MODIFY `id_penguji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT untuk tabel `draft_sidang`
--
ALTER TABLE `draft_sidang`
  MODIFY `id_sidang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `draft_sidang_log`
--
ALTER TABLE `draft_sidang_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT untuk tabel `draft_sidang_syarat`
--
ALTER TABLE `draft_sidang_syarat`
  MODIFY `id_syarat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `judul`
--
ALTER TABLE `judul`
  MODIFY `id_judul` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT untuk tabel `mahasiswa_log`
--
ALTER TABLE `mahasiswa_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;

--
-- AUTO_INCREMENT untuk tabel `pend_nilai`
--
ALTER TABLE `pend_nilai`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `pend_penguji`
--
ALTER TABLE `pend_penguji`
  MODIFY `id_penguji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT untuk tabel `pend_sidang`
--
ALTER TABLE `pend_sidang`
  MODIFY `id_sidang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `pend_sidang_log`
--
ALTER TABLE `pend_sidang_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT untuk tabel `pend_sidang_syarat`
--
ALTER TABLE `pend_sidang_syarat`
  MODIFY `id_syarat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pkl`
--
ALTER TABLE `pkl`
  MODIFY `id_pkl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `pkl_bim`
--
ALTER TABLE `pkl_bim`
  MODIFY `id_bimPKL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT untuk tabel `pkl_bim_log`
--
ALTER TABLE `pkl_bim_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT untuk tabel `pkl_file`
--
ALTER TABLE `pkl_file`
  MODIFY `id_filePKL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT untuk tabel `pkl_file_log`
--
ALTER TABLE `pkl_file_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `pkl_log`
--
ALTER TABLE `pkl_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `pkl_nilai`
--
ALTER TABLE `pkl_nilai`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `pkl_nilai_log`
--
ALTER TABLE `pkl_nilai_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `pkl_sidang`
--
ALTER TABLE `pkl_sidang`
  MODIFY `id_sidpkl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT untuk tabel `pkl_sidang_log`
--
ALTER TABLE `pkl_sidang_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT untuk tabel `pkl_syarat`
--
ALTER TABLE `pkl_syarat`
  MODIFY `id_syarat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `pkl_syarat_log`
--
ALTER TABLE `pkl_syarat_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `pkl_syarat_sidang`
--
ALTER TABLE `pkl_syarat_sidang`
  MODIFY `id_syarat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `proposal`
--
ALTER TABLE `proposal`
  MODIFY `id_proposal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT untuk tabel `proposal_bim`
--
ALTER TABLE `proposal_bim`
  MODIFY `id_bim` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT untuk tabel `proposal_bim_log`
--
ALTER TABLE `proposal_bim_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT untuk tabel `proposal_file`
--
ALTER TABLE `proposal_file`
  MODIFY `id_file` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `proposal_file_log`
--
ALTER TABLE `proposal_file_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `proposal_log`
--
ALTER TABLE `proposal_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `proposal_penguji`
--
ALTER TABLE `proposal_penguji`
  MODIFY `id_penguji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT untuk tabel `proposal_sidang`
--
ALTER TABLE `proposal_sidang`
  MODIFY `id_sidang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `proposal_sidang_log`
--
ALTER TABLE `proposal_sidang_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `proposal_sidang_syarat`
--
ALTER TABLE `proposal_sidang_syarat`
  MODIFY `id_syarat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `skripsi`
--
ALTER TABLE `skripsi`
  MODIFY `id_skripsi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `skripsi_bim`
--
ALTER TABLE `skripsi_bim`
  MODIFY `id_bim` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `skripsi_bim_log`
--
ALTER TABLE `skripsi_bim_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT untuk tabel `skripsi_dosbing`
--
ALTER TABLE `skripsi_dosbing`
  MODIFY `id_alias` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT untuk tabel `skripsi_file`
--
ALTER TABLE `skripsi_file`
  MODIFY `id_file` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `skripsi_file_log`
--
ALTER TABLE `skripsi_file_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `skripsi_log`
--
ALTER TABLE `skripsi_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `skripsi_syarat`
--
ALTER TABLE `skripsi_syarat`
  MODIFY `id_syarat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT untuk tabel `skripsi_syarat_log`
--
ALTER TABLE `skripsi_syarat_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `surat`
--
ALTER TABLE `surat`
  MODIFY `id_surat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tata_usaha_log`
--
ALTER TABLE `tata_usaha_log`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
