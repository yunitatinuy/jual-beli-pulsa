-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2023 at 06:30 AM
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
-- Database: `db_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'pulsa elektrik');

-- --------------------------------------------------------

--
-- Table structure for table `metode_bayar`
--

CREATE TABLE `metode_bayar` (
  `id_metode_bayar` int(11) NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `kode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `metode_bayar`
--

INSERT INTO `metode_bayar` (`id_metode_bayar`, `jenis`, `kode`) VALUES
(1, 'Gopay', '082171479180'),
(2, 'Shopee Pay', '082391241295');

-- --------------------------------------------------------

--
-- Table structure for table `nohp`
--

CREATE TABLE `nohp` (
  `id_nohp` int(11) NOT NULL,
  `id_provider` int(11) NOT NULL,
  `no_telp` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `nohp`
--

INSERT INTO `nohp` (`id_nohp`, `id_provider`, `no_telp`) VALUES
(94, 7, '083181531047'),
(95, 8, '082382467889'),
(96, 9, '1352361623'),
(97, 20, '56136237124'),
(98, 8, '1351155112'),
(99, 10, '16136134'),
(100, 9, '083181531047'),
(101, 20, '083181531047');

-- --------------------------------------------------------

--
-- Table structure for table `proveder`
--

CREATE TABLE `proveder` (
  `id_provider` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `nama_provider` varchar(255) NOT NULL,
  `detail` text NOT NULL,
  `nominal` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `proveder`
--

INSERT INTO `proveder` (`id_provider`, `id_kategori`, `nama_provider`, `detail`, `nominal`, `harga`, `foto`) VALUES
(6, 1, 'Indosat', 'Masa aktif 30 hari + gratis nelpon 120mnt', 20000, 22000, 'indosat.png'),
(7, 1, 'Telkomsel', 'Masa aktif 10 hari + Gratis Nelpon 120mnt', 15000, 17000, 'telkomsel.png'),
(8, 1, 'XL', 'Masa aktif 3 hari + gratis sms 100 kali', 5000, 7000, 'xl.png'),
(9, 1, 'Axis', 'gratis nelpon ke sesama', 10000, 12000, 'axis.png'),
(10, 1, 'Telkomsel', 'gratis sms', 10000, 12000, 'telkomsel.png'),
(13, 1, 'Telkomsel', 'gratis 1GB internet + telpon kesesama operator', 20000, 22000, 'telkomsel.png'),
(17, 1, 'Indosat', 'Masa aktif 15 hari + Gratis Nelpon 150mnt', 25000, 27000, 'indosat.png'),
(19, 1, 'Telkomsel', 'gratis sms', 5000, 7000, 'telkomsel.png'),
(20, 1, 'Axis', 'gratis nelpon kesesama', 5000, 7000, 'axis.png');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_transaksi_penjualan` int(11) NOT NULL,
  `id_provider` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_transaksi_penjualan`, `id_provider`, `jumlah`) VALUES
(25, 25, 7, 1),
(26, 26, 7, 1),
(27, 27, 17, 1),
(28, 28, 7, 1),
(29, 29, 9, 1),
(30, 30, 7, 1),
(31, 31, 8, 1),
(32, 32, 7, 1),
(33, 33, 19, 1),
(34, 34, 8, 1),
(35, 35, 7, 1),
(36, 36, 9, 1),
(37, 37, 8, 1),
(38, 38, 8, 1),
(39, 39, 7, 1),
(40, 40, 8, 1),
(41, 41, 9, 1),
(42, 42, 20, 1),
(43, 43, 8, 1),
(44, 44, 10, 1),
(45, 45, 9, 2),
(46, 46, 20, 1);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_penjualan`
--

CREATE TABLE `transaksi_penjualan` (
  `id_transaksi` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_nohp` int(11) NOT NULL,
  `id_metode_bayar` int(11) NOT NULL,
  `tanggal_pembelian` date NOT NULL,
  `total_pembelian` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `transaksi_penjualan`
--

INSERT INTO `transaksi_penjualan` (`id_transaksi`, `id_user`, `id_nohp`, `id_metode_bayar`, `tanggal_pembelian`, `total_pembelian`) VALUES
(43, 35, 98, 1, '2023-12-20', 22000),
(44, 35, 99, 1, '2023-12-20', 22000),
(45, 34, 100, 2, '2023-12-20', 44000),
(46, 34, 101, 1, '2023-12-21', 22000);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(10) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `username`, `email`, `password`, `role`) VALUES
(29, 'Yun', 'yun', 'yunita@gmail.com', '$2y$10$7ILR78l5RTOqE8YdTsf.EuTb86PcIn5IrsSetHyccPhmYOnEUIDka', 1),
(30, 'Yunita Caroline Sianturi', 'tinuy', 'tinuy@gmail.com', '$2y$10$s50dtb0J9Fe/qmRIQbbN5.JBsm0D855LORTXNnfRfAaPNOeG/NmBm', 0),
(33, 'Muhammad Dafa Putra', 'admin', 'muhammaddavaputra@gmail.com', '$2y$10$VoIF/JU.vKEV5Ym6ZHU6Oetr.Qg/423vIUM0X9Inz7RC4mxGjuGUq', 1),
(34, 'mizu', 'user', 'rkiyoshi13@gmail.com', '$2y$10$6U4l4/5mZ2wNWgIf2hEO7ONf2UtqE4gq/l/bM2g5DHvDQMjEJ..3O', 0),
(35, 'dhaput', 'dhaput22', 'rkiyoshi13@gmail.com', '$2y$10$SZtqk7QhXSTzTCCgMyKWeuEWXwgJazt6xaumUGfZXzHElYzSFWMV.', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `metode_bayar`
--
ALTER TABLE `metode_bayar`
  ADD PRIMARY KEY (`id_metode_bayar`);

--
-- Indexes for table `nohp`
--
ALTER TABLE `nohp`
  ADD PRIMARY KEY (`id_nohp`);

--
-- Indexes for table `proveder`
--
ALTER TABLE `proveder`
  ADD PRIMARY KEY (`id_provider`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `transaksi_penjualan`
--
ALTER TABLE `transaksi_penjualan`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `metode_bayar`
--
ALTER TABLE `metode_bayar`
  MODIFY `id_metode_bayar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `nohp`
--
ALTER TABLE `nohp`
  MODIFY `id_nohp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `proveder`
--
ALTER TABLE `proveder`
  MODIFY `id_provider` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `transaksi_penjualan`
--
ALTER TABLE `transaksi_penjualan`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
