-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2023 at 02:52 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `id` bigint(20) UNSIGNED NOT NULL,
  `kd_admin` char(255) NOT NULL,
  `nm_lengkap` varchar(25) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `notlp` varchar(15) NOT NULL,
  `username` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(191) NOT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `kd_admin`, `nm_lengkap`, `alamat`, `notlp`, `username`, `role`, `password`) VALUES
(1, 'KU01', 'Kepala Balai Kesehatan', 'Sekolah TI Al-Musthafawiyah Kec. Me', '6285921264904', 'admin01', 'admin', '$2y$10$bAzLkBD84JvwCjlrfkh7L.IxD84eIVelzLewulVcfwKBE5lJsJloq'),
(2, 'KU02', 'Staf Balai Kesehatan', 'Sekolah TI Al-Musthafawiyah Kec. Me', '6285693171777', 'staf01', 'user', '$2y$10$0K4B0ZoaM4UjjiC727vsCO1J3S6vV1Pp1ynkNemQaPoaORqctdmLC'),
(3, 'KU03', 'Asep Danang', 'Jl. Toraja No.19 Rt.03/Rw.04', '6281290171787', 'danang03', 'user', '$2y$10$nnk0RkDmRhJr1l0u0BQXju/GkDxOEJytdfIXlGrHqnPWSpEunG.O2'),
(4, 'KU04', 'Dian Minati', 'Jl. Kemuning No.10', '6281293171800', 'minati42', 'user', '$2y$10$lIOnKRQ7CM.NbQL8Z3YEo.KYOKZGX/wDh0LfFHtT7mDuiVlrlFGI.'),
(5, 'KU05', 'Riki Jiwa', 'Jl. Sekarwati No.11', '6289693171870', 'jiwa20', 'user', '$2y$10$Kc6H026xUadSjpLUEO9ueOo.BMRH2mzhQ3QlFx/qg1P0Y0adXTmDe'),
(6, 'KU06', 'Bambang Saputro', 'Jl. Ananda 45 Blok G1', '6285693171873', 'saputro18', 'user', '$2y$10$jxCe.qgX32A2uGVKYVGRS.hrq/BXAhgq/C3Ib3eYA5UeDo3zhw9Ny'),
(7, 'KU07', 'Dea Zulkarnaen', 'Jl. Kemuning No. 21', '6285693171871', 'zulkarnaen07', 'user', '$2y$10$02lO4WkFq/B/xYNwKICRduFXkEEAlJymhV6dYgcmaa7Cb/TwDN/AG');

-- --------------------------------------------------------

--
-- Table structure for table `beli`
--

CREATE TABLE `beli` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kd_beli` char(10) NOT NULL,
  `tgl_beli` date NOT NULL,
  `kd_obat` char(10) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `beli`
--

INSERT INTO `beli` (`id`, `kd_beli`, `tgl_beli`, `kd_obat`, `jumlah`) VALUES
(1, 'VHALXNLN', '2023-10-12', 'KO66', 250),
(2, 'VR0TXMIC', '2023-12-07', 'KO65', 100);

-- --------------------------------------------------------

--
-- Table structure for table annual_needs
-- 

CREATE TABLE `annual_needs` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY,
  `kd_obat` char(10) NOT NULL,
  `k_tahun` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `stock_opname` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY,
  `sisa_stok` int(11) NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `b_simpan` (
  `id` int(11) AUTO_INCREMENT  PRIMARY KEY,
  `b_total` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `b_pemesanan` (
  `id` int(11) AUTO_INCREMENT  PRIMARY KEY,
  `b_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


CREATE TABLE `biaya` (
  `id` int(11) NOT NULL,
  `nama` char(10) NOT NULL,
  `biaya_bln` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table annual_needs
-- 

CREATE TABLE `b_penyimpanan` (
  `id` int(11) NOT NULL,
  `nm_obat` char(10) NOT NULL,
  `isi` int(11) NOT NULL,
  `k_tahun` int(11) NOT NULL,
  `k_each` int(11) NOT NULL,
  `total` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eoq`
--

CREATE TABLE `eoq` (
  `id` int(11) NOT NULL,
  `kd_obat` char(10) NOT NULL,
  `k_tahun` int(11) NOT NULL,
  `b_simpan` int(11) NOT NULL,
  `b_pesan` int(11) NOT NULL,
  `jumlah_eoq` int(11) DEFAULT NULL,
  `intval_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `eoq`
--

INSERT INTO `eoq` (`id`, `kd_obat`, `k_tahun`, `b_simpan`, `b_pesan`, `jumlah_eoq`, `intval_time`) VALUES
(1, 'KO66', 2000, 8000000, 6500000, 57, 10),
(2, 'KO17', 4000, 70000000, 35000000, 63, 6);

-- --------------------------------------------------------

--
-- Table structure for table `log_pembelian`
--

CREATE TABLE `log_pembelian` (
  `id` bigint(20) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `kd_admin` char(255) NOT NULL,
  `kd_beli` char(10) NOT NULL,
  `kd_obat` char(10) NOT NULL,
  `tgl_beli` date NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `log_pembelian`
--

INSERT INTO `log_pembelian` (`id`, `kd_admin`, `kd_beli`, `kd_obat`, `tgl_beli`, `jumlah`) VALUES
(1, 'KU02', 'VHALXNLN', 'KO66', '2023-10-12', 250),
(2, 'KU01', 'VR0TXMIC', 'KO65', '2023-12-07', 100);

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kd_obat` char(10) NOT NULL,
  `nm_obat` varchar(25) NOT NULL,
  `jenis_obat` enum('TABLET','CAIR','CAPSULE') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id`, `kd_obat`, `nm_obat`, `isi`, `satuan`, `jenis_obat`, `harga`, `stok`) VALUES
(1, 'KO1', 'Alpara', 100, 'box', 'TABLET', 1200, 2190),
(2, 'KO2', 'Acyclovir 400mg', 100, 'box', 'TABLET', 1100, 100),
(3, 'KO3', 'Biolysin tab', 100, 'box', 'TABLET', 450, 1380),
(4, 'KO4', 'Becom C', 100, 'box', 'TABLET', 2050, 300),
(5, 'KO5', 'Bufantacid', 100, 'box', 'CAPSULE', 300, 1020),
(6, 'KO6', 'Caviplex', 100, 'box', 'CAPSULE', 420, 1900),
(7, 'KO7', 'Cavicur', 100, 'box', 'TABLET', 610, 390),
(8, 'KO8', 'Cetirizine', 100, 'box', 'TABLET', 230, 1710),
(9, 'KO9', 'Cimetidine', 100, 'box', 'TABLET', 400, 500),
(10, 'KO10', 'Cefadroxil 500mg', 100, 'box', 'TABLET', 700, 610),
(11, 'KO11', 'Diaform', 100, 'box', 'TABLET', 234, 1500),
(12, 'KO12', 'Allupurinol 100mg', 100, 'box', 'TABLET', 220, 850),
(13, 'KO13', 'Dexteem Plus', 100, 'box', 'TABLET', 300, 2499),
(14, 'KO14', 'Dextral', 100, 'box', 'TABLET', 870, 1920),
(15, 'KO15', 'Diatabs', 100, 'box', 'TABLET', 900, 930),
(16, 'KO16', 'Dapyrin', 100, 'box', 'TABLET', 1700, 200),
(17, 'KO17', 'OBH Surya Itrasal 100', 100, 'box', 'CAIR', 10000, 200),
(18, 'KO18', 'Dionicol', 100, 'box', 'TABLET', 1050, 190),
(19, 'KO19', 'Domperidone', 100, 'box', 'TABLET', 600, 330),
(20, 'KO20', 'Etafenin', 100, 'box', 'TABLET', 320, 800),
(21, 'KO21', 'Etabion', 100, 'box', 'TABLET', 250, 1260),
(22, 'KO22', 'Farmabex C', 100, 'box', 'TABLET', 900, 200),
(23, 'KO23', 'Farizol', 100, 'box', 'TABLET', 400, 200),
(24, 'KO24', 'Antasida', 100, 'box', 'TABLET', 130, 1000),
(25, 'KO25', 'Flucadex', 100, 'box', 'TABLET', 525, 540),
(26, 'KO26', 'Grantusif', 100, 'box', 'TABLET', 600, 1000),
(27, 'KO27', 'Grathazon', 100, 'box', 'TABLET', 250, 300),
(28, 'KO28', 'Gasela', 100, 'box', 'TABLET', 250, 300),
(29, 'KO29', 'Glibenclamide 5mg', 100, 'box', 'TABLET', 250, 300),
(30, 'KO30', 'Gludefatic', 100, 'box', 'TABLET', 300, 200),
(31, 'KO31', 'Grafalin 4mg', 100, 'box', 'TABLET', 100, 250),
(32, 'KO32', 'Hufamag tab', 100, 'box', 'TABLET', 380, 2000),
(33, 'KO33', 'Hufabion', 100, 'box', 'CAPSULE', 250, 650),
(34, 'KO34', 'Hufaneuron', 100, 'box', 'TABLET', 650, 1000),
(35, 'KO35', 'Ambroxol tab', 100, 'box', 'TABLET', 210, 1060),
(36, 'KO36', 'Ibuprofen', 100, 'box', 'TABLET', 820, 920),
(37, 'KO37', 'Incidal', 100, 'box', 'TABLET', 3200, 300),
(38, 'KO38', 'Imodium', 100, 'box', 'TABLET', 1220, 100),
(39, 'KO39', 'Lopamid', 100, 'box', 'TABLET', 450, 840),
(40, 'KO40', 'Loratadine 10mg', 100, 'box', 'CAPSULE', 150, 550),
(41, 'KO41', 'Mirasic', 100, 'box', 'TABLET', 510, 4100),
(42, 'KO42', 'Mefinal', 100, 'box', 'TABLET', 410, 2100),
(43, 'KO43', 'Mefenamit acid', 100, 'box', 'TABLET', 410, 2100),
(44, 'KO44', 'Metformin', 100, 'box', 'TABLET', 280, 800),
(45, 'KO45', 'Molexflu', 100, 'box', 'TABLET', 600, 800),
(46, 'KO46', 'Acyclovir 200mg', 100, 'box', 'CAPSULE', 400, 300),
(47, 'KO47', 'Metrolet', 100, 'box', 'TABLET', 550, 120),
(48, 'KO48', 'Opistan', 100, 'box', 'TABLET', 700, 900),
(49, 'KO49', 'Orphen', 100, 'box', 'TABLET', 200, 1700),
(50, 'KO50', 'Omedom tab', 100, 'box', 'TABLET', 400, 340),
(51, 'KO51', 'Omefulvin', 100, 'box', 'TABLET', 1850, 100),
(52, 'KO52', 'Paraflu', 100, 'box', 'TABLET', 370, 300),
(53, 'KO53', 'Piroxicam 10mg', 100, 'box', 'TABLET', 300, 430),
(54, 'KO54', 'Ramaflu', 100, 'box', 'TABLET', 450, 290),
(55, 'KO55', 'Sanmol tab', 100, 'box', 'TABLET', 350, 1900),
(56, 'KO56', 'Spasminal', 100, 'box', 'TABLET', 1100, 380),
(57, 'KO57', 'Arkavit c', 100, 'box', 'CAPSULE', 450, 500),
(58, 'KO58', 'Selcom C', 100, 'box', 'TABLET', 450, 500),
(59, 'KO59', 'Trisela', 100, 'box', 'TABLET', 500, 510),
(60, 'KO60', 'Vitazym', 100, 'box', 'TABLET', 975, 200),
(61, 'KO61', 'Voltadex', 100, 'box', 'CAPSULE', 1000, 300),
(62, 'KO62', 'Winatin', 100, 'box', 'TABLET', 350, 320),
(63, 'KO63', 'Zink', 100, 'box', 'CAPSULE', 850, 130),
(64, 'KO64', 'Amplodipin 5mg', 100, 'box', 'TABLET', 220, 1000),
(65, 'KO65', 'Amplodipin 10mg', 100, 'box', 'TABLET', 300, 300),
(66, 'KO66', 'Amoxillin', 100, 'box', 'TABLET', 600, 560),
(67, 'KO67', 'Tester ABC', 100, 'box', 'TABLET', 5000, 100);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_kd_admin` (`kd_admin`);

--
-- Indexes for table `beli`
--
ALTER TABLE `beli`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_kd_beli` (`kd_beli`);

--
-- Indexes for table `eoq`
--
ALTER TABLE `eoq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table 
--
-- ALTER TABLE `annual_needs`
--   ADD PRIMARY KEY (`id`);

-- ALTER TABLE `stock_opname`
--   ADD PRIMARY KEY (`id`);

-- ALTER TABLE `total_b_pemesanan`
--   ADD PRIMARY KEY (`id`);
--
-- Indexes for table `log_pembelian`
--
ALTER TABLE `log_pembelian`
  ADD KEY `kd_admin` (`kd_admin`),
  ADD KEY `kd_beli` (`kd_beli`),
  ADD KEY `kd_obat` (`kd_obat`);

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_kd_obat` (`kd_obat`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `eoq`
--
ALTER TABLE `eoq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `log_pembelian`
--
-- ALTER TABLE `log_pembelian`
--   MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--
ALTER TABLE `annual_needs`
ADD CONSTRAINT `fk_annual_needs_obat` FOREIGN KEY (`kd_obat`) REFERENCES `obat` (`kd_obat`);


-- ALTER TABLE `stock_opname`
-- ADD CONSTRAINT `fk_stock_opname_obat` FOREIGN KEY (`kd_obat`) REFERENCES `obat` (`kd_obat`);

-- ALTER TABLE `b_simpan`
-- ADD CONSTRAINT `fk_b_simpan_obat` FOREIGN KEY (`kd_obat`) REFERENCES `obat` (`kd_obat`);
--
-- Constraints for table `log_pembelian`
--
ALTER TABLE `log_pembelian`
  ADD CONSTRAINT `log_pembelian_ibfk_1` FOREIGN KEY (`kd_admin`) REFERENCES `admin` (`kd_admin`),
  ADD CONSTRAINT `log_pembelian_ibfk_2` FOREIGN KEY (`kd_beli`) REFERENCES `beli` (`kd_beli`),
  ADD CONSTRAINT `log_pembelian_ibfk_3` FOREIGN KEY (`kd_obat`) REFERENCES `obat` (`kd_obat`) ON DELETE CASCADE
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
