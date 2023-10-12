-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 08, 2023 at 06:32 AM
-- Server version: 8.0.33-0ubuntu0.20.04.2
-- PHP Version: 8.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_eoq`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` bigint UNSIGNED NOT NULL,
  `kd_admin` char(255) NOT NULL,
  `nm_lengkap` varchar(25) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `notlp` varchar(15) NOT NULL,
  `username` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(191) NOT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `beli`
--

CREATE TABLE `beli` (
  `id` bigint UNSIGNED NOT NULL,
  `kd_beli` char(10) NOT NULL,
  `tgl_beli` date NOT NULL,
  `kd_obat` char(10) NOT NULL,
  `jumlah` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `eoq`
--

CREATE TABLE `eoq` (
  `id` bigint UNSIGNED NOT NULL,
  `kd_obat` char(10) NOT NULL,
  `k_tahun` int NOT NULL,
  `b_simpan` int NOT NULL,
  `b_pesan` int NOT NULL,
  `jumlah_eoq` int DEFAULT NULL,
  `intval_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --
-- -- Dumping data for table `eoq`
-- --

-- INSERT INTO `eoq` (`id`, `kd_obat`, `k_tahun`, `b_simpan`, `b_pesan`) VALUES
-- (1, 'KO1', 2500, 4800000, 750000),
-- (2, 'KO55', 1000, 5000000, 2500000),
-- (3, 'KO18', 3000, 15000000, 10000000),
-- (4, 'KO55', 200, 15000000, 10000000),
-- (5, 'KO14', 400, 10000000, 15000000),
-- (6, 'KO28', 1000, 25000000, 35000000),
-- (7, 'KO33', 3000, 10000000, 11000000),
-- (8, 'KO17', 200, 15000000, 25000000),
-- (9, 'KO56', 5000, 50000000, 45000000),
-- (10, 'KO21', 100, 1000000, 2000000),
-- (11, 'KO18', 200, 2500000, 2000000),
-- (12, 'KO37', 400, 10000000, 15000000);

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id` bigint UNSIGNED NOT NULL,
  `kd_obat` char(10) NOT NULL,
  `nm_obat` varchar(25) NOT NULL,
  `jenis_obat` enum('TABLET', 'CAIR', 'CAPSULE') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int NOT NULL,
  `stok` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id`, `kd_obat`, `nm_obat`, `jenis_obat`, `harga`, `stok`) VALUES
(1, 'KO1', 'Alpara', 'TABLET', 1200, 2190),
(2, 'KO2', 'Acyclovir 400mg', 'TABLET', 1100, 100),
(3, 'KO3', 'Biolysin tab', 'TABLET', 450, 1380),
(4, 'KO4', 'Becom C', 'TABLET', 2050, 300),
(6, 'KO6', 'Caviplex', 'CAPSULE', 420, 1900),
(5, 'KO5', 'Bufantacid', 'CAPSULE', 300, 1020),
(7, 'KO7', 'Cavicur', 'TABLET', 610, 390),
(8, 'KO8', 'Cetirizine', 'TABLET', 230, 1710),
(9, 'KO9', 'Cimetidine', 'TABLET', 400, 500),
(10, 'KO10', 'Cefadroxil 500mg', 'TABLET', 700, 610),
(11, 'KO11', 'Diaform', 'TABLET', 234, 1500),
(12, 'KO12', 'Allupurinol 100mg', 'TABLET', 220, 850),
(13, 'KO13', 'Dexteem Plus', 'TABLET', 300, 2499),
(14, 'KO14', 'Dextral', 'TABLET', 870, 1920),
(15, 'KO15', 'Diatabs', 'TABLET', 900, 930),
(16, 'KO16', 'Dapyrin', 'TABLET', 1700, 200),
(17, 'KO17', 'OBH Surya Itrasal 100', 'CAIR', 10000, 200),
(18, 'KO18', 'Dionicol', 'TABLET', 1050, 190),
(19, 'KO19', 'Domperidone', 'TABLET', 600, 330),
(20, 'KO20', 'Etafenin', 'TABLET', 320, 800),
(21, 'KO21', 'Etabion', 'TABLET', 250, 1260),
(22, 'KO22', 'Farmabex C', 'TABLET', 900, 200),
(23, 'KO23', 'Farizol', 'TABLET', 400, 200),
(24, 'KO24', 'Antasida', 'TABLET', 130, 1000),
(25, 'KO25', 'Flucadex', 'TABLET', 525, 540),
(26, 'KO26', 'Grantusif', 'TABLET', 600, 1000),
(27, 'KO27', 'Grathazon', 'TABLET', 250, 300),
(28, 'KO28', 'Gasela', 'TABLET', 250, 300),
(29, 'KO29', 'Glibenclamide 5mg', 'TABLET', 250, 300),
(30, 'KO30', 'Gludefatic', 'TABLET', 300, 200),
(31, 'KO31', 'Grafalin 4mg', 'TABLET', 100, 250),
(32, 'KO32', 'Hufamag tab', 'TABLET', 380, 2000),
(33, 'KO33', 'Hufabion', 'CAPSULE', 250, 650),
(34, 'KO34', 'Hufaneuron', 'TABLET', 650, 1000),
(35, 'KO35', 'Ambroxol tab', 'TABLET', 210, 1060),
(36, 'KO36', 'Ibuprofen', 'TABLET', 820, 920),
(37, 'KO37', 'Incidal', 'TABLET', 3200, 300),
(38, 'KO38', 'Imodium', 'TABLET', 1220, 100),
(39, 'KO39', 'Lopamid', 'TABLET', 450, 840),
(40, 'KO40', 'Loratadine 10mg', 'CAPSULE', 150, 550),
(41, 'KO41', 'Mirasic', 'TABLET', 510, 4100),
(42, 'KO42', 'Mefinal', 'TABLET', 410, 2100),
(43, 'KO43', 'Mefenamit acid', 'TABLET', 410, 2100),
(44, 'KO44', 'Metformin', 'TABLET', 280, 800),
(45, 'KO45', 'Molexflu', 'TABLET', 600, 800),
(46, 'KO46', 'Acyclovir 200mg', 'CAPSULE', 400, 300),
(47, 'KO47', 'Metrolet', 'TABLET', 550, 120),
(48, 'KO48', 'Opistan', 'TABLET', 700, 900),
(49, 'KO49', 'Orphen', 'TABLET', 200, 1700),
(50, 'KO50', 'Omedom tab', 'TABLET', 400, 340),
(51, 'KO51', 'Omefulvin', 'TABLET', 1850, 100),
(52, 'KO52', 'Paraflu', 'TABLET', 370, 300),
(53, 'KO53', 'Piroxicam 10mg', 'TABLET', 300, 430),
(54, 'KO54', 'Ramaflu', 'TABLET', 450, 290),
(55, 'KO55', 'Sanmol tab', 'TABLET', 350, 1900),
(56, 'KO56', 'Spasminal', 'TABLET', 1100, 380),
(57, 'KO57', 'Arkavit c', 'CAPSULE', 450, 500),
(58, 'KO58', 'Selcom C', 'TABLET', 450, 500),
(59, 'KO59', 'Trisela', 'TABLET', 500, 510),
(60, 'KO60', 'Vitazym', 'TABLET', 975, 200),
(61, 'KO61', 'Voltadex', 'CAPSULE', 1000, 300),
(62, 'KO62', 'Winatin', 'TABLET', 350, 320),
(63, 'KO63', 'Zink', 'CAPSULE', 850, 130),
(64, 'KO64', 'Amplodipin 5mg', 'TABLET', 220, 1000),
(65, 'KO65', 'Amplodipin 10mg', 'TABLET', 300, 300),
(66, 'KO66', 'Amoxillin', 'TABLET', 600, 560),
(67, 'KO67', 'Tester ABC', 'TABLET', 5000, 100);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `beli`
--
ALTER TABLE `beli`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eoq`
--
ALTER TABLE `eoq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `eoq`
--
ALTER TABLE `eoq`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
