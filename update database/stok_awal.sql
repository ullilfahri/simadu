-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 13, 2020 at 02:25 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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
-- Table structure for table `stok_awal`
--

CREATE TABLE `stok_awal` (
  `id_stok_awal` int(100) NOT NULL,
  `tanggal` varchar(100) NOT NULL,
  `kode_barang` varchar(100) NOT NULL,
  `id_gudang` varchar(100) NOT NULL,
  `stok` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stok_awal`
--

INSERT INTO `stok_awal` (`id_stok_awal`, `tanggal`, `kode_barang`, `id_gudang`, `stok`) VALUES
(1, '2020-04-12', 'SA0003', '5', '100'),
(2, '2020-04-12', 'SA0003', '6', '200'),
(4, '2020-04-12', 'SA0003', '2', ''),
(5, '2020-04-12', 'SA0003', '5', '100'),
(8, '2020-04-12', 'SA0003', '2', ''),
(9, '2020-04-16', 'SA0003', '5', '100'),
(11, '2020-04-16', 'SA0003', '6', '188'),
(13, '2020-04-16', 'SA0003', '2', ''),
(16, '2020-04-16', 'SA0003', '2', ''),
(17, '2020-04-14', 'SA0003', '5', '100'),
(18, '2020-04-14', 'SA0003', '6', '188'),
(19, '2020-04-15', 'SA0003', '5', '100'),
(20, '2020-04-15', 'SA0003', '6', '188'),
(21, '2020-04-17', 'SA0003', '5', '100'),
(22, '2020-04-17', 'SA0003', '6', '188'),
(23, '2020-04-16', 'SA0003', '2', ''),
(24, '2020-04-19', 'SA0003', '5', '100'),
(25, '2020-04-20', 'SA0003', '5', '100'),
(26, '2020-04-19', 'SA0003', '6', '188'),
(27, '2020-04-20', 'SA0003', '6', '188'),
(28, '2020-04-19', 'SA0003', '2', ''),
(29, '2020-04-13', 'SA0003', '5', '100'),
(30, '2020-04-13', 'SA0003', '6', '188');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `stok_awal`
--
ALTER TABLE `stok_awal`
  ADD PRIMARY KEY (`id_stok_awal`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `stok_awal`
--
ALTER TABLE `stok_awal`
  MODIFY `id_stok_awal` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
