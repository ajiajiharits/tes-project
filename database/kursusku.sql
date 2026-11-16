-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2026 at 11:28 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kursusku`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `nama_kursus` varchar(150) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `durasi_jam` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `nama_kursus`, `kategori`, `harga`, `deskripsi`, `gambar`, `created_at`, `durasi_jam`) VALUES
(1, 'Desain Website', 'Pengembangan Web', 169000, 'Pelajari dasar pembuatan website modern menggunakan HTML, CSS, Bootstrap, dan struktur halaman responsif.', 'course-1.jpg', '2026-05-07 13:32:35', 2),
(2, 'Optimasi Mesin Pencari', 'Pemasaran Digital', 250000, 'Pelajari strategi SEO dan pemasaran digital agar website atau bisnis lebih mudah ditemukan calon pelanggan.', 'course-2.jpg', '2026-05-07 13:32:35', 4),
(3, 'Copywriting', 'Konten', 180000, 'Kuasai teknik menulis konten promosi yang menarik, jelas, dan mampu mendorong audiens untuk bertindak.', 'course-3.jpg', '2026-05-07 13:32:35', 3);

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `judul` varchar(100) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jam` varchar(50) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `judul`, `tanggal`, `jam`, `course_id`) VALUES
(1, 'Kelas HTML & CSS', '2026-05-08', '19.00 - 20.30 WIB', 1),
(2, 'Latihan Bootstrap', '2026-05-10', '18.30 - 20.00 WIB', 2),
(3, 'Belajar JavaScript', '2026-05-12', '20.00 - 21.30 WIB', 3);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Berlangganan',
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `course_id`, `total_harga`, `status`, `tanggal`) VALUES
(4, 4, 1, 169000, 'Berhasil', '2026-05-08 11:07:13'),
(5, 2, 1, 169000, 'Berhasil', '2026-05-09 17:41:32'),
(6, 2, 2, 250000, 'Berhasil', '2026-05-09 17:49:43'),
(7, 9, 3, 180000, 'Berhasil', '2026-05-09 17:57:30'),
(8, 11, 1, 169000, 'Berhasil', '2026-05-10 05:19:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `foto` varchar(255) DEFAULT 'profile-default.png',
  `role` varchar(20) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `created_at`, `foto`, `role`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$f/4LM/dj11NF/d7L/zw2Y.ad8vHbOgdM6KJmRSFHA017z4598Ok/6', '2026-05-07 14:01:42', '1778167765-profil.jpg.jpg', 'admin'),
(2, 'anjay', 'anjay@gmail.com', '$2y$10$ivVQHtLu31LVb2XKYsmFEuT7oB5AYGLicij.q7A1DHr6LLxf52x/S', '2026-05-07 15:30:45', 'profile-default.png', 'user'),
(3, 'admin2', 'admin2@gmail.com', '$2y$10$LFQ0xJcj7Wi2LrYdhZEjC.UW9UZIz1heMTZ1z5R4azV1/HtnyzO2q', '2026-05-07 15:31:56', 'profile-default.png', 'admin'),
(4, 'Harits Ponang Aji', 'ponangharis26@gmail.com', '$2y$10$5/ao70OYPu.peoFBBzg9M.T4iv97xjd6Y5Bm1c2PVd0xbpiWEaG5C', '2026-05-08 11:06:58', '1778265235-f0799f49-243c-4ee5-876b-b982f6ac0a3e.jfif', 'user'),
(8, 'user1', 'user1@gmail.com', '$2y$10$GvVHQfKBvUIEdshH.V5wO.pBuSkJt1lL5ell/deWc4/ByU8aHQ/hS', '2026-05-08 19:41:07', '1778269780-Screenshot 2025-05-01 150625.png', 'user'),
(9, 'user2', 'user2@gmail.com', '$2y$10$p4zM.NXrOx/6.zEROaXAouwqk9EKNUtexNRKH1XiPfnrpqkFERBZi', '2026-05-08 19:50:13', '1778271169-20250319004513.jpg', 'user'),
(10, 'user4', 'user4@gmail.com', '$2y$10$zVlXjRAizZL3sTGvFJcnl.cLBcDaMmMU.QqZGCnWR0FH0p8x5ErT6', '2026-05-09 16:55:04', '1778345819-20250319004513.jpg', 'user'),
(11, 'user5', 'user5@gmail.com', '$2y$10$YiJ2IwOcRDmsYVhLYF3vDuXOiCfFsQwcOdahbmUSnsB8b8T0oou2y', '2026-05-10 05:18:29', 'profile-default.png', 'user'),
(13, 'admin3', 'admin3@gmail.com', '$2y$10$ssl5odgbYWCf8WzeTMeOhOnTObYOHWSweOA2uhI0BR2dxjqvRO.uG', '2026-05-10 09:26:23', 'profile-default.png', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
