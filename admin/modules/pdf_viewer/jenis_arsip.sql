-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 30 Nov 2018 pada 23.11
-- Versi Server: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siako`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_arsip`
--

CREATE TABLE `jenis_arsip` (
  `id` int(1) NOT NULL,
  `kategori` int(1) NOT NULL,
  `jenis_arsip` varchar(50) NOT NULL,
  `php_pdf` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jenis_arsip`
--

INSERT INTO `jenis_arsip` (`id`, `kategori`, `jenis_arsip`, `php_pdf`) VALUES
(1, 1, 'FAKTUR PENJUALAN', '../pdf_viewer/dari_kasir.php?dir=penjualan&file='),
(2, 1, 'SURAT JALAN', '../pdf_viewer/surat_jalan.php?dir=penjualan&file='),
(3, 1, 'BUKTI PENGAMBILAN', ''),
(4, 2, 'FAKTUR PEMBELIAN', '../pdf_viewer/faktur_beli.php?file='),
(5, 2, 'SURAT JALAN PEMBELIAN', '../pdf_viewer/faktur_beli.php?file='),
(6, 2, 'FAKTUR PAJAK PEMBELIAN', '../pdf_viewer/faktur_beli.php?file='),
(7, 3, 'FAKTUR PAJAK PENJUALAN', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jenis_arsip`
--
ALTER TABLE `jenis_arsip`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jenis_arsip`
--
ALTER TABLE `jenis_arsip`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
