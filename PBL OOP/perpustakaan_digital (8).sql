-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 18, 2026 at 01:07 PM
-- Server version: 8.4.6
-- PHP Version: 8.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan_digital`
--

-- --------------------------------------------------------

--
-- Table structure for table `aktivitas`
--

CREATE TABLE `aktivitas` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `aktivitas` text COLLATE utf8mb4_general_ci,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id` int NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `penulis` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `penerbit` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tahun` year DEFAULT NULL,
  `stok` int DEFAULT '0',
  `cover` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kategori` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id`, `judul`, `penulis`, `penerbit`, `tahun`, `stok`, `cover`, `kategori`, `created_at`, `status`) VALUES
(23, 'How to make Your own AI', 'masbro', 'Politeknik Negeri Batam', '2026', 46, '1781107019_download_(4).jpg', 18, '2026-06-03 10:51:17', 'tersedia'),
(26, 'Harry Potter', 'J. K. Rowling', 'Politeknik Negeri Batam', '2010', 8, '1781045693_download.jpg', 18, '2026-06-09 22:54:53', 'tersedia'),
(28, 'Informatika', 'Will Smith', 'Politeknik Negeri Batam', '2025', 50, '1781106978_download_(2).jpg', 14, '2026-06-10 15:56:18', 'tersedia'),
(29, 'Learning about making Robotic', 'Will Smith', 'Politeknik Negeri Batam', '1998', 70, '1781107010_download_(5).jpg', 15, '2026-06-10 15:56:50', 'tersedia'),
(30, 'Matahari', 'Will Smith', 'Politeknik Negeri Batam', '2025', 499, '1781107474_download_(1).jpg', 16, '2026-06-10 16:04:34', 'tersedia'),
(31, 'Python and Pandon', 'Will Smith', 'Politeknik Negeri Batam', '2025', 50, '1781107654_download_(3).jpg', 14, '2026-06-10 16:07:34', 'tersedia'),
(32, 'Pemrograman C++', 'Will Smith', 'Politeknik Negeri Batam', '2025', 50, '1781107684_download_(6).jpg', 14, '2026-06-10 16:08:04', 'tersedia'),
(33, 'Multimedia', 'Will Smith', 'Politeknik Negeri Batam', '2025', 48, '1781107711_f9ad5800bed9b48f2b35457687b5c8b5.jpg', 14, '2026-06-10 16:08:31', 'tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `denda`
--

CREATE TABLE `denda` (
  `id` int NOT NULL,
  `peminjaman_id` int NOT NULL,
  `user_id` int NOT NULL,
  `jumlah_denda` int NOT NULL,
  `status` enum('pending','lunas') NOT NULL DEFAULT 'pending',
  `metode_pembayaran` varchar(50) NOT NULL DEFAULT 'tunai',
  `kode_konfirmasi` varchar(20) NOT NULL,
  `tanggal_bayar` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `denda`
--

INSERT INTO `denda` (`id`, `peminjaman_id`, `user_id`, `jumlah_denda`, `status`, `metode_pembayaran`, `kode_konfirmasi`, `tanggal_bayar`) VALUES
(12, 22, 18, 18000, 'lunas', 'tunai', 'CASH-B45C78', '2026-06-18 09:55:55'),
(13, 22, 18, 18000, 'pending', 'tunai', 'CASH-50BB50', '2026-06-18 10:06:45'),
(14, 22, 18, 18000, 'lunas', 'tunai', 'CASH-F5B7D6', '2026-06-18 10:19:43'),
(15, 22, 18, 18000, 'lunas', 'tunai', 'CASH-789EFF', '2026-06-18 11:31:19'),
(16, 22, 18, 18000, 'lunas', 'tunai', 'CASH-673B77', '2026-06-18 19:30:30');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int NOT NULL,
  `nama_kategori` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`) VALUES
(18, 'Artificial Intelligence'),
(14, 'Informatika'),
(17, 'IoT'),
(16, 'PKN'),
(15, 'Robotic');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `buku_id` int DEFAULT NULL,
  `tanggal_pinjam` date DEFAULT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` enum('dipinjam','dikembalikan') COLLATE utf8mb4_general_ci DEFAULT 'dipinjam'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `user_id`, `buku_id`, `tanggal_pinjam`, `tanggal_kembali`, `status`) VALUES
(18, 18, 23, '2026-06-09', '2026-06-23', 'dipinjam'),
(22, 18, 30, '2026-06-17', '2026-06-09', 'dipinjam');

-- --------------------------------------------------------

--
-- Table structure for table `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` int NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `isi` text COLLATE utf8mb4_general_ci,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengumuman`
--

INSERT INTO `pengumuman` (`id`, `judul`, `isi`, `tanggal`) VALUES
(1, 'Perpanjangan Layanan Perpustakaan', 'Layanan perpustakaan akan buka lebih lama mulai 1 Juni 2025.', '2025-05-28'),
(2, 'Koleksi Buku Baru', '50+ buku baru telah ditambahkan. Yuk jelajahi!', '2025-05-27'),
(3, 'Maintenance Sistem', 'Akan ada maintenance sistem pada 1 Juni 2025 pukul 00.00 - 02.00', '2025-05-26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','anggota') COLLATE utf8mb4_general_ci DEFAULT 'anggota',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Admin Perpus', 'admin@gmail.com', '123456', 'admin', '2026-04-27 14:19:15'),
(17, 'john doe', 'johnny@gmail.com', '$2y$12$hAileiNXO0tPuU09/xRpS.E5DIob4YrWft4QiXZ1EYHukB2Ar.zu6', 'admin', '2026-06-02 13:16:31'),
(18, 'Rahmat Arief', 'arief@gmail.com', '$2y$12$0PuQuk4M/v0FQoviGzYb7OAxkhSffFaGzof3fpXajOGMKQrAn431u', 'anggota', '2026-06-09 14:12:18'),
(19, 'nafis', 'Nafis@gmail.com', '$2y$12$zFHkFOUWqtB69YcHmqhU0.YDyE08o5..4auA2gBtQOYID7W3.UVNe', 'anggota', '2026-06-10 14:30:10'),
(21, 'test', 'test@gmail.com', '$2y$12$YhoSg9vJYEUJx5rlJuxU0urpvpIwfY9JYiMd.EfX8Ovt27l2N.K6K', 'anggota', '2026-06-11 10:48:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aktivitas`
--
ALTER TABLE `aktivitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategori`);

--
-- Indexes for table `denda`
--
ALTER TABLE `denda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peminjaman_id` (`peminjaman_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_kategori` (`nama_kategori`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `buku_id` (`buku_id`);

--
-- Indexes for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aktivitas`
--
ALTER TABLE `aktivitas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `denda`
--
ALTER TABLE `denda`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aktivitas`
--
ALTER TABLE `aktivitas`
  ADD CONSTRAINT `aktivitas_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`kategori`) REFERENCES `kategori` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
