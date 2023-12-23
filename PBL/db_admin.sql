-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Des 2023 pada 14.15
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

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
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'pulsa elektrik');

-- --------------------------------------------------------

--
-- Struktur dari tabel `metode_bayar`
--

CREATE TABLE `metode_bayar` (
  `id_metode_bayar` int(11) NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `kode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `metode_bayar`
--

INSERT INTO `metode_bayar` (`id_metode_bayar`, `jenis`, `kode`) VALUES
(1, 'Gopay', '082171479180'),
(2, 'Shopee Pay', '082391241295');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nohp`
--

CREATE TABLE `nohp` (
  `id_nohp` int(11) NOT NULL,
  `id_provider` int(11) NOT NULL,
  `no_telp` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `nohp`
--

INSERT INTO `nohp` (`id_nohp`, `id_provider`, `no_telp`) VALUES
(114, 7, '1231546'),
(115, 7, '13246546'),
(116, 7, '0988777'),
(117, 7, '12315'),
(118, 7, '1214656565');

-- --------------------------------------------------------

--
-- Struktur dari tabel `proveder`
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
-- Dumping data untuk tabel `proveder`
--

INSERT INTO `proveder` (`id_provider`, `id_kategori`, `nama_provider`, `detail`, `nominal`, `harga`, `foto`) VALUES
(1, 1, 'Telkomsel', 'Masa Aktif 7 hari', 5000, 7000, 'telkomsel.png'),
(2, 1, 'Telkomsel', 'Masa Aktif 10 hari', 10000, 12000, 'telkomsel.png'),
(3, 1, 'Telkomsel', 'Masa Aktif 30 hari', 20000, 22000, 'telkomsel.png'),
(4, 1, 'Telkomsel', 'Masa Aktif 45 hari + 30 Hari Prime Video', 50000, 52000, 'telkomsel.png'),
(5, 1, 'XL', 'Masa Aktif 7 hari + Kuota 1 GB', 5000, 7000, 'xl.png'),
(6, 1, 'XL', 'Masa Aktif 15 hari + Kuota 2 GB', 10000, 12000, 'xl.png'),
(7, 1, 'XL', 'Masa Aktif 45 hari ', 30000, 32000, 'xl.png'),
(8, 1, 'XL', 'Masa Aktif 45 hari + Kuota 2 GB', 50000, 52000, 'xl.png'),
(9, 1, 'Axis', 'Bonus Isi Pulsa 200 MB 1 hari', 5000, 7000, 'axis.png'),
(10, 1, 'Axis', 'Bonus Isi Pulsa 500 MB 3 hari', 10000, 12000, 'axis.png'),
(11, 1, 'Axis', 'Bonus Isi Pulsa 1,5 GB 3 hari', 30000, 32000, 'axis.png'),
(12, 1, 'Axis', 'Bonus Isi Pulsa 3 GB 3 hari', 50000, 52000, 'axis.png'),
(13, 1, 'Indosat', 'Masa Aktif 7 hari', 5000, 7000, 'indosat.png'),
(14, 1, 'Indosat', 'Masa Aktif 15 hari', 10000, 12000, 'indosat.png'),
(15, 1, 'Indosat', 'Masa Aktif 30 hari + Gratis Game Sepuasnya 1 hari', 25000, 27000, 'indosat.png'),
(16, 1, 'Indosat', 'Masa Aktif 30 hari + Streaming Netflix, Viu, IQIYI 3 hari', 50000, 55000, 'indosat.png'),
(17, 1, 'Tri', 'Masa Aktif 5 hari', 5000, 7000, 'tri.png'),
(18, 1, 'Tri', 'Masa Aktif 10 hari', 10000, 12000, 'tri.png'),
(19, 1, 'Tri', 'Masa Aktif 30 hari + Gratis Telpon & SMS', 30000, 32000, 'tri.png'),
(20, 1, 'Tri', 'Masa Aktif 30 hari + Gratis Internetan 5 hari', 50000, 52000, 'tri.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_transaksi_penjualan` int(11) NOT NULL,
  `id_provider` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_transaksi_penjualan`, `id_provider`, `jumlah`) VALUES
(54, 54, 20, 2),
(55, 55, 7, 1),
(56, 56, 7, 1),
(57, 57, 7, 1),
(58, 57, 20, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_penjualan`
--

CREATE TABLE `transaksi_penjualan` (
  `id_transaksi_penjualan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_nohp` int(11) NOT NULL,
  `id_metode_bayar` int(11) NOT NULL,
  `tanggal_pembelian` date NOT NULL,
  `total_pembelian` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `transaksi_penjualan`
--

INSERT INTO `transaksi_penjualan` (`id_transaksi_penjualan`, `id_user`, `id_nohp`, `id_metode_bayar`, `tanggal_pembelian`, `total_pembelian`) VALUES
(54, 34, 109, 2, '2023-12-21', 14000),
(55, 34, 110, 1, '2023-12-21', 17000),
(56, 34, 112, 1, '2023-12-21', 17000),
(57, 34, 116, 0, '2023-12-21', 17000),
(58, 34, 116, 0, '2023-12-21', 7000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
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
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama`, `username`, `email`, `password`, `role`) VALUES
(29, 'Yun', 'yun', 'yunita@gmail.com', '$2y$10$7ILR78l5RTOqE8YdTsf.EuTb86PcIn5IrsSetHyccPhmYOnEUIDka', 1),
(30, 'Yunita Caroline Sianturi', 'tinuy', 'tinuy@gmail.com', '$2y$10$s50dtb0J9Fe/qmRIQbbN5.JBsm0D855LORTXNnfRfAaPNOeG/NmBm', 0),
(33, 'Muhammad Dafa Putra', 'admin', 'muhammaddavaputra@gmail.com', '$2y$10$VoIF/JU.vKEV5Ym6ZHU6Oetr.Qg/423vIUM0X9Inz7RC4mxGjuGUq', 1),
(34, 'mizu', 'user', 'rkiyoshi13@gmail.com', '$2y$10$6U4l4/5mZ2wNWgIf2hEO7ONf2UtqE4gq/l/bM2g5DHvDQMjEJ..3O', 0),
(35, 'dhaput', 'dhaput22', 'rkiyoshi13@gmail.com', '$2y$10$SZtqk7QhXSTzTCCgMyKWeuEWXwgJazt6xaumUGfZXzHElYzSFWMV.', 0),
(36, 'mikasa', 'mikasa', 'mikasa@gmail.com', '$2y$10$HZRuAebAv.UrCeWieAn6uerD9Mu1p0RYgvCAvk7t6fyToPya2lGrm', 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `metode_bayar`
--
ALTER TABLE `metode_bayar`
  ADD PRIMARY KEY (`id_metode_bayar`);

--
-- Indeks untuk tabel `nohp`
--
ALTER TABLE `nohp`
  ADD PRIMARY KEY (`id_nohp`);

--
-- Indeks untuk tabel `proveder`
--
ALTER TABLE `proveder`
  ADD PRIMARY KEY (`id_provider`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indeks untuk tabel `transaksi_penjualan`
--
ALTER TABLE `transaksi_penjualan`
  ADD PRIMARY KEY (`id_transaksi_penjualan`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `metode_bayar`
--
ALTER TABLE `metode_bayar`
  MODIFY `id_metode_bayar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `nohp`
--
ALTER TABLE `nohp`
  MODIFY `id_nohp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT untuk tabel `proveder`
--
ALTER TABLE `proveder`
  MODIFY `id_provider` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT untuk tabel `transaksi_penjualan`
--
ALTER TABLE `transaksi_penjualan`
  MODIFY `id_transaksi_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
