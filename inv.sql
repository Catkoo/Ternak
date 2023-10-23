-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Okt 2023 pada 16.03
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.0.28

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
('BRG-0001', 'ayam tua 01', 'STN-0001', 20, '651e82766892c.jpg', 0, '2023-10-05 16:31:34', '2023-10-05 16:31:34'),
('BRG-0002', 'ayam boiler', 'STN-0001', 200, '652f85447311d.jpg', 0, '2023-10-18 14:12:04', '2023-10-18 14:12:04');

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

--
-- Dumping data untuk tabel `barang_keluar`
--

INSERT INTO `barang_keluar` (`id_bk`, `barang_id`, `tanggal_keluar`, `tujuan`, `jumlah_keluar`, `create_by`) VALUES
('BK-0001', 'BRG-0001', '2023-10-05 16:32:39', 'untuk idulfitri', 25, 0),
('BK-0002', 'BRG-0001', '2023-10-09 12:35:55', 'jual', 75, 0),
('BK-0003', 'BRG-0002', '2023-10-18 14:13:07', 'kjdihsd', 1000, 0),
('BK-0004', 'BRG-0002', '2023-10-20 22:38:57', 'ttt', 90, 0),
('BK-0005', 'BRG-0002', '2023-10-23 19:31:42', 'mandiri', 10, 0);

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

--
-- Dumping data untuk tabel `barang_masuk`
--

INSERT INTO `barang_masuk` (`id_bm`, `barang_id`, `supplier_id`, `jumlah_masuk`, `tanggal_masuk`, `create_by`) VALUES
('BM-0001', 'BRG-0001', 'SUP-0001', 120, '2023-10-05 16:31:59', 0),
('BM-0003', 'BRG-0002', 'SUP-0001', 1100, '2023-10-18 14:12:25', 0),
('BM-0004', 'BRG-0002', 'SUP-0001', 100, '2023-10-18 14:13:41', 0),
('BM-0005', 'BRG-0002', 'SUP-0002', 100, '2023-10-23 19:32:38', 0);

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

--
-- Dumping data untuk tabel `history`
--

INSERT INTO `history` (`id`, `barang_id`, `bmk_id`, `role`, `jumlah`, `tgl`) VALUES
(9, 'BRG-0002', 0, 'BK', 10, '2023-10-23 19:31:42'),
(10, 'BRG-0002', 0, 'BM', 100, '2023-10-23 19:32:38');

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
('STN-0001', 'ekor', '2023-10-11 13:03:17');

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
('SUP-0001', 'aheng', '0822232488', 'jln.pemudaa', '2023-10-11 13:03:28'),
('SUP-0002', 'PT.Mabar Feed Indonesia', '0615851244', 'Jl.Rumah Potong Hewan, Sumatera utara', '2023-10-18 17:18:41'),
('SUP-0003', 'PT.Ayam Indonesia', '6676767676', 'Jl.pemuda Km.19 ', '2023-10-23 21:00:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `latest_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `password`, `latest_update`) VALUES
(9, 'admin', 'admin', '202cb962ac59075b964b07152d234b70', '2023-10-23 20:22:09'),
(10, 'Richard Khoo', 'catkoo', '202cb962ac59075b964b07152d234b70', '2023-10-23 20:41:28');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
