-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 10, 2026 at 09:58 AM
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
  `aktivitas` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id` int NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `penulis` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `penerbit` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tahun` year DEFAULT NULL,
  `stok` int DEFAULT '0',
  `harga` int NOT NULL DEFAULT '0',
  `cover` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kategori` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id`, `judul`, `penulis`, `penerbit`, `tahun`, `stok`, `harga`, `cover`, `kategori`, `created_at`, `status`) VALUES
(23, 'How to make Your own AI', 'masbro', 'Politeknik Negeri Batam', '2026', 46, 150000, '1781107019_download_(4).jpg', 18, '2026-06-03 10:51:17', 'tersedia'),
(26, 'Harry Potter', 'J. K. Rowling', 'Politeknik Negeri Batam', '2010', 6, 200000, '1781045693_download.jpg', 18, '2026-06-09 22:54:53', 'tersedia'),
(28, 'Informatika', 'Will Smith', 'Politeknik Negeri Batam', '2025', 47, 120000, '1781106978_download_(2).jpg', 14, '2026-06-10 15:56:18', 'tersedia'),
(29, 'Learning about making Robotic', 'Will Smith', 'Politeknik Negeri Batam', '1998', 70, 250000, '1781107010_download_(5).jpg', 15, '2026-06-10 15:56:50', 'tersedia'),
(30, 'Matahari', 'Will Smith', 'Politeknik Negeri Batam', '2025', 498, 100000, '1781107474_download_(1).jpg', 16, '2026-06-10 16:04:34', 'tersedia'),
(31, 'Python and Pandon', 'Will Smith', 'Politeknik Negeri Batam', '2025', 50, 180000, '1781107654_download_(3).jpg', 14, '2026-06-10 16:07:34', 'tersedia'),
(32, 'Pemrograman C++', 'Will Smith', 'Politeknik Negeri Batam', '2025', 50, 150000, '1781107684_download_(6).jpg', 14, '2026-06-10 16:08:04', 'tersedia'),
(33, 'Multimedia', 'Will Smith', 'Politeknik Negeri Batam', '2025', 48, 130000, '1781107711_f9ad5800bed9b48f2b35457687b5c8b5.jpg', 14, '2026-06-10 16:08:31', 'tersedia'),
(47, 'AI', 'masbro', 'Politeknik Negeri Batam', '2025', 46, 250000, '1782913590_images.png', 18, '2026-07-01 13:46:30', 'tersedia'),
(48, 'Claude', 'Will Smith', 'Politeknik Negeri Batam', '2025', 47, 200000, '1782975036_images.png', 18, '2026-07-02 06:50:36', 'tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `denda`
--

CREATE TABLE `denda` (
  `id` int NOT NULL,
  `peminjaman_id` int NOT NULL,
  `user_id` int NOT NULL,
  `jenis_denda` enum('terlambat','rusak') NOT NULL,
  `jumlah_denda` int NOT NULL,
  `status` enum('pending','lunas','unpaid') DEFAULT 'unpaid',
  `metode_pembayaran` varchar(50) NOT NULL DEFAULT 'tunai',
  `kode_konfirmasi` varchar(20) NOT NULL,
  `tanggal_bayar` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `denda`
--

INSERT INTO `denda` (`id`, `peminjaman_id`, `user_id`, `jenis_denda`, `jumlah_denda`, `status`, `metode_pembayaran`, `kode_konfirmasi`, `tanggal_bayar`, `created_at`) VALUES
(17, 18, 18, 'terlambat', 8000, 'pending', 'tunai', '5AD63F432C', '2026-06-27 01:43:55', '2026-06-26 18:43:55'),
(18, 18, 18, 'terlambat', 8000, 'pending', 'tunai', 'DEDB738B47', '2026-06-27 01:44:08', '2026-06-26 18:44:08'),
(19, 18, 18, 'terlambat', 8000, 'pending', 'tunai', 'A35198C740', '2026-06-27 01:44:24', '2026-06-26 18:44:24'),
(20, 18, 18, 'terlambat', 8000, 'pending', 'tunai', 'C6B9E86C39', '2026-06-27 01:44:53', '2026-06-26 18:44:53'),
(21, 18, 18, 'terlambat', 8000, 'pending', 'tunai', '1BAFC8B48A', '2026-06-27 01:48:29', '2026-06-26 18:48:29'),
(22, 18, 18, 'terlambat', 8000, 'pending', 'tunai', 'EF81BEF1C7', '2026-06-27 01:49:42', '2026-06-26 18:49:42'),
(23, 18, 18, 'terlambat', 8000, 'pending', 'tunai', '266A2DDC21', '2026-06-27 01:51:54', '2026-06-26 18:51:54'),
(28, 41, 18, 'terlambat', 24000, 'pending', 'tunai', 'D6FE968D7C', '2026-06-28 16:36:47', '2026-06-28 09:36:47'),
(29, 41, 18, 'terlambat', 24000, 'pending', 'tunai', 'B262105BE8', '2026-06-28 16:40:07', '2026-06-28 09:40:07'),
(30, 41, 18, 'terlambat', 24000, 'pending', 'tunai', '19F6908772', '2026-06-28 16:44:46', '2026-06-28 09:44:46'),
(31, 41, 18, 'terlambat', 724000, 'pending', 'tunai', '4CB95F3E1D', '2026-06-28 16:49:00', '2026-06-28 09:49:00'),
(32, 41, 18, 'terlambat', 724000, 'pending', 'tunai', '7869A3AEC0', '2026-06-28 18:27:40', '2026-06-28 11:27:40'),
(33, 41, 18, 'terlambat', 726000, 'pending', 'tunai', '81514AB7E7', '2026-06-29 14:32:42', '2026-06-29 07:32:42'),
(34, 41, 18, 'terlambat', 726000, 'pending', 'tunai', 'EFB4302287', '2026-06-29 21:35:59', '2026-06-29 14:35:59'),
(35, 41, 18, 'terlambat', 726000, 'pending', 'tunai', 'CC9F657781', '2026-06-29 22:15:39', '2026-06-29 15:15:39'),
(36, 18, 18, 'terlambat', 150000, 'pending', 'tunai', '737261DAD7', '2026-06-30 20:32:40', '2026-06-30 13:32:40'),
(37, 18, 18, 'terlambat', 150000, 'pending', 'tunai', '991CDA0057', '2026-06-30 22:35:17', '2026-06-30 15:35:17'),
(38, 18, 18, 'terlambat', 16000, 'pending', 'tunai', '0451179EF0', '2026-07-01 19:20:01', '2026-07-01 12:20:01'),
(39, 18, 18, 'terlambat', 184000, 'pending', 'tunai', '40E0E2701C', '2026-07-01 20:37:32', '2026-07-01 13:37:32'),
(40, 18, 18, 'terlambat', 184000, 'pending', 'tunai', '1EAE004DC0', '2026-07-01 20:40:34', '2026-07-01 13:40:34'),
(41, 18, 18, 'terlambat', 184000, 'pending', 'tunai', 'FF77BA0302', '2026-07-01 20:40:48', '2026-07-01 13:40:48'),
(42, 18, 18, 'terlambat', 34000, 'pending', 'tunai', '9194E16D90', '2026-07-01 20:53:05', '2026-07-01 13:53:05'),
(43, 18, 18, 'terlambat', 184000, 'pending', 'tunai', '8736C4735B', '2026-07-01 20:54:28', '2026-07-01 13:54:28'),
(44, 18, 18, 'terlambat', 184000, 'pending', 'tunai', '38A44D2054', '2026-07-01 21:07:31', '2026-07-01 14:07:31'),
(45, 18, 18, 'terlambat', 188000, 'pending', 'tunai', 'E6221FFDD6', '2026-07-03 20:08:14', '2026-07-03 13:08:14'),
(46, 18, 18, 'terlambat', 192000, 'pending', 'tunai', '87C190F718', '2026-07-05 12:32:28', '2026-07-05 05:32:28'),
(47, 18, 18, 'terlambat', 192000, 'pending', 'tunai', '8DCA477473', '2026-07-05 12:37:41', '2026-07-05 05:37:41'),
(50, 37, 18, 'terlambat', 24000, 'lunas', 'tunai', 'C68FCB55EB', '2026-07-08 18:13:47', '2026-07-05 06:15:59'),
(51, 18, 18, 'terlambat', 192000, 'lunas', 'tunai', 'A1D2E8F140', '2026-07-05 13:28:08', '2026-07-05 06:28:08'),
(52, 43, 18, 'terlambat', 250000, 'lunas', 'tunai', '', '2026-07-08 18:12:28', '2026-07-07 09:26:49'),
(56, 46, 21, 'terlambat', 44000, 'unpaid', 'tunai', '9C3C3ABC70', NULL, '2026-07-08 11:24:25'),
(57, 46, 21, 'terlambat', 164000, 'pending', 'tunai', '854D0887CF', '2026-07-08 18:26:03', '2026-07-08 11:26:03'),
(58, 45, 21, 'terlambat', 200000, 'unpaid', 'tunai', '', NULL, '2026-07-08 11:30:44'),
(59, 45, 21, 'terlambat', 200000, 'lunas', 'tunai', '9B73697846', '2026-07-10 10:46:47', '2026-07-08 11:31:05'),
(60, 49, 18, 'terlambat', 200000, 'unpaid', 'tunai', '', NULL, '2026-07-10 03:49:24'),
(61, 49, 18, 'rusak', 200000, 'unpaid', 'tunai', '7C4F7D04BB', NULL, '2026-07-10 04:23:37'),
(63, 48, 18, 'terlambat', 32000, 'unpaid', 'tunai', '4D3D9209FE', NULL, '2026-07-10 08:21:01'),
(64, 48, 18, 'terlambat', 32000, 'pending', 'tunai', 'DBB6C3D698', '2026-07-10 16:04:00', '2026-07-10 09:04:00');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int NOT NULL,
  `nama_kategori` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
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
  `status` enum('dipinjam','dikembalikan','dibatalkan','dihapus') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kondisi_buku` enum('baik','rusak') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'baik',
  `tanggal_pengembalian` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `user_id`, `buku_id`, `tanggal_pinjam`, `tanggal_kembali`, `status`, `kondisi_buku`, `tanggal_pengembalian`) VALUES
(47, 18, 47, '2026-07-10', '2026-07-24', 'dipinjam', 'baik', NULL),
(48, 18, 26, '2026-06-10', '2026-06-24', 'dikembalikan', 'baik', NULL),
(49, 18, 48, '2026-07-10', '2026-07-24', 'dipinjam', 'rusak', NULL),
(50, 21, 47, '2026-07-10', '2026-07-24', 'dipinjam', 'baik', NULL),
(51, 21, 26, '2026-07-10', '2026-07-24', 'dipinjam', 'baik', NULL),
(52, 21, 48, '2026-07-10', '2026-07-24', 'dipinjam', 'baik', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` int NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `isi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
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
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','anggota') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'anggota',
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
(21, 'test', 'test@gmail.com', '$2y$12$vCRZxuLFpgk1mTZy0iyTKObFg5b3.TFYUmnVXQmLzwyE4A8qyrkGu', 'anggota', '2026-06-11 10:48:13');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `denda`
--
ALTER TABLE `denda`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

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
