-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Des 2023 pada 07.28
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
-- Database: `inv`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
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
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `satuan_id`, `stok`, `foto_barang`, `create_by`, `created_at`, `update_at`) VALUES
('BRG-0001', 'Ayam Kampung', 'STN-0001', 0, '6584fce984473.jpg', 0, '2023-12-22 10:05:13', '2023-12-22 10:05:13'),
('BRG-0002', 'Ayam Petelur', 'STN-0001', 0, '6584fcf55b102.jpg', 0, '2023-12-22 10:05:25', '2023-12-22 10:05:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_keluar`
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
-- Struktur dari tabel `barang_masuk`
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
-- Struktur dari tabel `history`
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
-- Struktur dari tabel `satuan`
--

CREATE TABLE `satuan` (
  `id_satuan` varchar(15) NOT NULL,
  `nama_satuan` varchar(20) NOT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `satuan`
--

INSERT INTO `satuan` (`id_satuan`, `nama_satuan`, `update_at`) VALUES
('STN-0001', 'Ekor', '2023-11-13 09:04:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id_sup` varchar(20) NOT NULL,
  `nama_sup` varchar(30) NOT NULL,
  `telepon_sup` varchar(20) NOT NULL,
  `alamat_sup` varchar(50) NOT NULL,
  `latest_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id_sup`, `nama_sup`, `telepon_sup`, `alamat_sup`, `latest_update`) VALUES
('SUP-0001', 'Aheng', '0822232488', 'jln.pemudaa', '2023-10-29 17:00:03'),
('SUP-0002', 'PT.Mabar Feed Indonesia', '0615851244', 'Jl.Rumah Potong Hewan, Sumatera utara', '2023-10-18 17:18:41'),
('SUP-0003', 'PT.Ayam Indonesiaa', '6676767676', 'Jl.pemuda Km.19 ', '2023-11-13 09:05:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(30) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `latest_update` datetime DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiration` datetime DEFAULT NULL,
  `reset_request_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `password`, `role`, `email`, `latest_update`, `reset_token`, `token_expiration`, `reset_request_time`) VALUES
(22, 'Richard Khoo', 'catkoo', 'd41d8cd98f00b204e9800998ecf8427e', 'pimpinan', 'richard.khoo19@gmail.com', '2023-11-13 09:06:35', '5f883e1e82c90e908189d3911f43c2db71969ff2056e2d2579acf997ec7408fa', '2023-12-24 13:58:07', '2023-12-24 12:56:06'),
(31, 'admin', 'admin', '25d55ad283aa400af464c76d713c07ad', 'admin', 'ringgo.hs12@gmail.com', '2023-12-23 21:10:08', '552d77cf4bb61bbe50b3438cc8ea6faa7b323fc3740b93515b5fe7363feb9d42', NULL, NULL),
(32, 'Pimpinan', 'pimpinan', 'c8c605999f3d8352d7bb792cf3fdb25b', 'pimpinan', 'catkoo280@gmail.com', '2023-12-24 12:37:31', NULL, NULL, '2023-12-24 13:26:56');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indeks untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id_bk`);

--
-- Indeks untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id_bm`);

--
-- Indeks untuk tabel `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_sup`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
