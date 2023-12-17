-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2023 at 07:26 AM
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
-- Database: `inv`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` varchar(20) NOT NULL,
  `nama_barang` varchar(100) DEFAULT NULL,
  `satuan_id` varchar(100) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `foto_barang` varchar(255) DEFAULT NULL,
  `create_by` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `satuan_id`, `stok`, `foto_barang`, `create_by`, `created_at`, `update_at`) VALUES
('BRG-0001', 'Ayam Kampung', 'STN-0001', 0, '6579d55be75fb.jpg', 0, '2023-12-13 23:01:31', '2023-12-13 23:01:46'),
('BRG-0002', 'Ayam Petelur', 'STN-0001', 0, '6579d575541dd.jpg', 0, '2023-12-13 23:01:57', '2023-12-14 00:15:18');

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id_bk` varchar(20) NOT NULL,
  `barang_id` varchar(20) NOT NULL,
  `tanggal_keluar` datetime NOT NULL,
  `tujuan` text NOT NULL,
  `jumlah_keluar` int(11) NOT NULL DEFAULT 0,
  `create_by` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id_bm` varchar(10) NOT NULL,
  `barang_id` varchar(15) NOT NULL,
  `supplier_id` varchar(15) NOT NULL,
  `jumlah_masuk` int(11) NOT NULL DEFAULT 0,
  `tanggal_masuk` datetime NOT NULL,
  `create_by` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `barang_id` varchar(100) DEFAULT NULL,
  `bmk_id` int(11) DEFAULT NULL,
  `role` varchar(100) DEFAULT NULL,
  `jumlah` int(11) DEFAULT 0,
  `tgl` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `id_satuan` varchar(15) NOT NULL,
  `nama_satuan` varchar(20) NOT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`id_satuan`, `nama_satuan`, `update_at`) VALUES
('STN-0001', 'Ekor', '2023-11-13 09:04:43');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_sup` varchar(20) NOT NULL,
  `nama_sup` varchar(30) NOT NULL,
  `telepon_sup` varchar(20) NOT NULL,
  `alamat_sup` varchar(50) NOT NULL,
  `latest_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_sup`, `nama_sup`, `telepon_sup`, `alamat_sup`, `latest_update`) VALUES
('SUP-0001', 'Aheng', '0822232488', 'jln.pemudaa', '2023-10-29 17:00:03'),
('SUP-0002', 'PT.Mabar Feed Indonesia', '0615851244', 'Jl.Rumah Potong Hewan, Sumatera utara', '2023-10-18 17:18:41'),
('SUP-0003', 'PT.Ayam Indonesiaa', '6676767676', 'Jl.pemuda Km.19 ', '2023-11-13 09:05:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(30) DEFAULT NULL,
  `latest_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `password`, `role`, `latest_update`) VALUES
(20, 'Pimpinan', 'pimpinan', '202cb962ac59075b964b07152d234b70', 'pimpinan', '2023-10-29 16:03:51'),
(21, 'admin', 'admin', '202cb962ac59075b964b07152d234b70', 'admin', '2023-10-29 16:04:06'),
(22, 'Richard Khoo', 'catkoo', '202cb962ac59075b964b07152d234b70', 'pimpinan', '2023-11-13 09:06:35'),
(23, 'Damejrr', 'jrr', '202cb962ac59075b964b07152d234b70', 'admin', '2023-11-13 09:06:49'),
(25, 'ayam', 'ayam', '202cb962ac59075b964b07152d234b70', 'admin', '2023-12-14 00:11:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id_bk`);

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id_bm`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_sup`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
