-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Okt 2023 pada 14.16
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
('BRG-0001', 'ayam tua 01', 'STN-0001', 120, '651e82766892c.jpg', 0, '2023-10-05 16:31:34', '2023-10-05 16:31:34');

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
('BK-0002', 'BRG-0001', '2023-10-09 12:35:55', 'jual', 75, 0);

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
('BM-0002', 'BRG-0001', 'SUP-0001', 100, '2023-10-09 12:35:29', 0);

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
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `id_kary` varchar(20) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `nama_kary` varchar(30) NOT NULL,
  `telepon_kary` varchar(20) NOT NULL,
  `alamat_kary` varchar(50) NOT NULL,
  `latest_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `karyawan`
--

INSERT INTO `karyawan` (`id_kary`, `nik`, `nama_kary`, `telepon_kary`, `alamat_kary`, `latest_update`) VALUES
('KARY-0000', '2103061509020001', 'sdadadad', '2222222222', 'bvbvb', '2023-10-15 17:43:33');

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
('SUP-0001', 'aheng', '0822232488', 'jln.pemudaa', '2023-10-11 13:03:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `password`, `created_at`) VALUES
(6, 'administrator', 'admin', '5f4dcc3b5aa765d61d8327deb882cf99', '2022-08-22 18:52:58'),
(7, 'catkoo', 'catkoo', '81dc9bdb52d04dc20036dbd8313ed055', '2023-10-05 16:27:36');

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
-- Indeks untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_kary`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
