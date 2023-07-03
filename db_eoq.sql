-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2023 at 01:42 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

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
  `id` bigint UNSIGNED NOT NULL,
  `kd_admin` char(10) NOT NULL,
  `nm_lengkap` varchar(25) NOT NULL,
  `alamat` varchar(35) NOT NULL,
  `notlp` varchar(15) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


-- --------------------------------------------------------

--
-- Table structure for table `beli`
--

CREATE TABLE `beli` (
  `kd_beli` char(10) NOT NULL,
  `tgl_beli` date NOT NULL,
  `kd_obat` char(10) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eoq`
--

CREATE TABLE `eoq` (
  `id` int(10) NOT NULL,
  `kd_obat` char(10) NOT NULL,
  `k_tahun` int(11) NOT NULL,
  `b_simpan` int(11) NOT NULL,
  `b_pesan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `eoq`
--

INSERT INTO `eoq` (`id`, `kd_obat`, `k_tahun`, `b_simpan`, `b_pesan`) VALUES
(5, 'KO1', 2500, 4800000, 750000),
(7, 'KO1', 1900, 43715, 206521);

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `kd_obat` char(10) NOT NULL,
  `nm_obat` varchar(25) NOT NULL,
  `jenis_obat` varchar(15) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`kd_obat`, `nm_obat`, `jenis_obat`, `harga`, `stok`) VALUES
('KO1', 'Alpara', 'Tablet', 1200, 2190),
('KO10', 'Acyclovir 400mg', 'Tablet', 1100, 100),
('KO11', 'Biolysin tab', 'Tablet', 450, 1380),
('KO12', 'Becom C', 'Tablet', 2050, 300),
('KO13', 'Bufantacid', 'Tablet', 300, 1020),
('KO14', 'Caviplex', 'Tablet', 420, 1900),
('KO15', 'Cavicur', 'Tablet', 610, 390),
('KO16', 'Cetirizine DIHCL', 'Tablet', 230, 1710),
('KO17', 'Cimetidine', 'Tablet', 400, 500),
('KO18', 'Cefadroxil 500mg', 'Tablet', 700, 610),
('KO19', 'Diaform', 'Tablet', 234, 1500),
('KO2', 'Allupurinol 100mg', 'Tablet', 220, 850),
('KO20', 'Dexteem Plus', 'Tablet', 300, 2500),
('KO21', 'Dextral', 'Tablet', 870, 1920),
('KO22', 'Diatabs', 'Tablet', 900, 930),
('KO23', 'Dapyrin', 'Tablet', 1700, 200),
('KO24', 'Dionicol', 'Tablet', 1050, 190),
('KO25', 'Domperidone', 'Tablet', 600, 330),
('KO26', 'Etafenin', 'Tablet', 320, 800),
('KO27', 'Etabion', 'Tablet', 250, 1260),
('KO28', 'Farmabex C', 'Tablet', 900, 200),
('KO29', 'Farizol', 'Tablet', 400, 200),
('KO3', 'Antasida', 'Tablet', 130, 1000),
('KO30', 'Flucadex', 'Tablet', 525, 540),
('KO31', 'Grantusif', 'Tablet', 600, 1000),
('KO32', 'Grathazon', 'Tablet', 250, 1500),
('KO33', 'Gasela', 'Tablet', 250, 300),
('KO34', 'Glibenclamide 5mg', 'Tablet', 250, 300),
('KO35', 'Gludefatic', 'Tablet', 300, 200),
('KO36', 'Grafalin 4mg', 'Tablet', 100, 250),
('KO37', 'Hufamag tab', 'Tablet', 380, 2000),
('KO38', 'Hufabion', 'Tablet', 250, 650),
('KO39', 'Hufaneuron', 'Tablet', 650, 1000),
('KO4', 'Ambroxol tab', 'Tablet', 210, 1060),
('KO40', 'Ibuprofen', 'Tablet', 820, 920),
('KO41', 'Incidal', 'Tablet', 3200, 300),
('KO42', 'Imodium', 'Tablet', 1220, 100),
('KO43', 'Lopamid', 'Tablet', 450, 840),
('KO44', 'Loratadine 10mg', 'Tablet', 150, 550),
('KO45', 'Mirasic ', 'Tablet', 510, 4100),
('KO46', 'Mefinal', 'Tablet', 410, 2100),
('KO47', 'Mefenamit Acid', 'Tablet', 410, 2100),
('KO48', 'Metformin', 'Tablet', 280, 800),
('KO49', 'Molexflu', 'Tablet', 600, 500),
('KO5', 'Acyclovir 200mg', 'Tablet', 400, 300),
('KO50', 'Metrolet', 'Tablet', 550, 120),
('KO51', 'Opistan', 'Tablet', 700, 900),
('KO52', 'Orphen', 'Tablet', 200, 1010),
('KO53', 'Omedom tab', 'Tablet', 400, 340),
('KO54', 'Omefulvin', 'Tablet', 1850, 100),
('KO55', 'Paraflu', 'Tablet', 370, 370),
('KO56', 'Piroxicam 10mg', 'Tablet', 300, 430),
('KO57', 'Ramaflu', 'Tablet', 450, 290),
('KO58', 'Sanmol tab', 'Tablet', 350, 1900),
('KO59', 'Spasminal', 'Tablet', 1100, 380),
('KO6', 'Arkavit C', 'Tablet', 450, 500),
('KO60', 'Selcom C', 'Tablet', 1100, 650),
('KO61', 'Trisela', 'Tablet', 500, 510),
('KO62', 'Vitazym', 'Tablet', 975, 200),
('KO63', 'Voltadex', 'Tablet', 680, 300),
('KO64', 'Winatin', 'Tablet', 350, 320),
('KO65', 'Zink', 'Tablet', 850, 130),
('KO7', 'Amplodipin 5mg', 'Tablet', 220, 1000),
('KO8', 'Amplodipin 10mg', 'Tablet', 300, 300),
('KO9', 'Amoxicillin', 'Tablet', 600, 560);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`kd_admin`);

--
-- Indexes for table `beli`
--
ALTER TABLE `beli`
  ADD PRIMARY KEY (`kd_beli`);

--
-- Indexes for table `eoq`
--
ALTER TABLE `eoq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`kd_obat`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `eoq`
--
ALTER TABLE `eoq`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
