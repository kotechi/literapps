-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for peminjaman-buku
CREATE DATABASE IF NOT EXISTS `peminjaman-buku` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `peminjaman-buku`;

-- Dumping structure for table peminjaman-buku.buku
CREATE TABLE IF NOT EXISTS `buku` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_kategori` bigint unsigned NOT NULL,
  `nama_buku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('tersedia','tidak_tersedia') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tersedia',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `buku_id_kategori_foreign` (`id_kategori`),
  CONSTRAINT `buku_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table peminjaman-buku.buku: ~2 rows (approximately)
INSERT INTO `buku` (`id`, `id_kategori`, `nama_buku`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Kipas Angin', 'tersedia', '2026-02-11 05:55:55', '2026-04-19 20:37:12'),
	(2, 1, 'AC', 'tidak_tersedia', '2026-02-11 05:56:21', '2026-04-19 21:01:49'),
	(4, 1, 'PC 01', 'tersedia', '2026-04-19 20:19:49', '2026-04-19 20:19:49'),
	(5, 1, 'Laptop 001', 'tidak_tersedia', '2026-04-19 20:20:12', '2026-04-19 20:55:14'),
	(6, 1, 'PC 002', 'tersedia', '2026-04-19 20:22:17', '2026-04-19 20:22:17'),
	(7, 1, 'Laptop 002', 'tersedia', '2026-04-19 20:22:40', '2026-04-19 20:22:40'),
	(8, 1, 'PC 003', 'tersedia', '2026-04-19 20:44:42', '2026-04-19 20:44:42'),
	(9, 1, 'Laptop 003', 'tersedia', '2026-04-19 20:49:39', '2026-04-19 20:49:39');

-- Dumping structure for table peminjaman-buku.bukti_pengembalian
CREATE TABLE IF NOT EXISTS `bukti_pengembalian` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_pengembalian` bigint unsigned NOT NULL,
  `tipe_media` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'foto',
  `path_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bukti_pengembalian_id_pengembalian_foreign` (`id_pengembalian`),
  CONSTRAINT `bukti_pengembalian_id_pengembalian_foreign` FOREIGN KEY (`id_pengembalian`) REFERENCES `pengembalian` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table peminjaman-buku.bukti_pengembalian: ~0 rows (approximately)
INSERT INTO `bukti_pengembalian` (`id`, `id_pengembalian`, `tipe_media`, `path_file`, `keterangan`, `created_at`, `updated_at`) VALUES
	(2, 9, 'foto', 'bukti-pengembalian/TsSO7cZ4h39n1LVjjCLZgSE70FV8c8nSZwwrU3IC.jpg', NULL, '2026-04-19 21:01:27', '2026-04-19 21:01:27');

-- Dumping structure for table peminjaman-buku.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table peminjaman-buku.cache: ~6 rows (approximately)
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
	('laravel-cache-1ff65699b41ea5eb1e6b37a78af90b69', 'i:1;', 1776651620),
	('laravel-cache-1ff65699b41ea5eb1e6b37a78af90b69:timer', 'i:1776651620;', 1776651620),
	('laravel-cache-73be6290c2b2f51a8fa806cde0e8dbc2', 'i:1;', 1776651957),
	('laravel-cache-73be6290c2b2f51a8fa806cde0e8dbc2:timer', 'i:1776651957;', 1776651957),
	('laravel-cache-aditiya@gmail.com|127.0.0.1', 'i:1;', 1776651620),
	('laravel-cache-aditiya@gmail.com|127.0.0.1:timer', 'i:1776651620;', 1776651620),
	('laravel-cache-c525a5357e97fef8d3db25841c86da1a', 'i:1;', 1776651927),
	('laravel-cache-c525a5357e97fef8d3db25841c86da1a:timer', 'i:1776651927;', 1776651927),
	('laravel-cache-c94a54d2a2c33e5b08a8fb6c8cb8c96e', 'i:1;', 1776655519),
	('laravel-cache-c94a54d2a2c33e5b08a8fb6c8cb8c96e:timer', 'i:1776655519;', 1776655519);

-- Dumping structure for table peminjaman-buku.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table peminjaman-buku.cache_locks: ~0 rows (approximately)

-- Dumping structure for table peminjaman-buku.denda
CREATE TABLE IF NOT EXISTS `denda` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_pengembalian` bigint unsigned NOT NULL,
  `id_user` bigint unsigned NOT NULL,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('menunggu','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  `total_denda` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `denda_id_pengembalian_foreign` (`id_pengembalian`),
  KEY `denda_id_user_foreign` (`id_user`),
  CONSTRAINT `denda_id_pengembalian_foreign` FOREIGN KEY (`id_pengembalian`) REFERENCES `pengembalian` (`id`) ON DELETE CASCADE,
  CONSTRAINT `denda_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table peminjaman-buku.denda: ~5 rows (approximately)
INSERT INTO `denda` (`id`, `id_pengembalian`, `id_user`, `nama_kategori`, `status`, `total_denda`, `created_at`, `updated_at`) VALUES
	(1, 1, 3, 'Elektronik', 'selesai', 35000, '2026-02-11 06:11:09', '2026-02-11 09:56:37'),
	(2, 2, 3, 'Elektronik', 'selesai', 10000, '2026-02-11 09:55:05', '2026-02-11 09:56:31'),
	(3, 3, 3, 'Elektronik', 'selesai', 20000, '2026-02-11 10:04:14', '2026-02-11 10:05:14'),
	(4, 5, 3, 'Elektronik', 'menunggu', 25000, '2026-04-19 19:38:45', '2026-04-19 19:38:45'),
	(5, 9, 3, 'Elektronik', 'selesai', 20000, '2026-04-19 21:01:49', '2026-04-19 21:03:16');

-- Dumping structure for table peminjaman-buku.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table peminjaman-buku.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table peminjaman-buku.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table peminjaman-buku.jobs: ~0 rows (approximately)

-- Dumping structure for table peminjaman-buku.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table peminjaman-buku.job_batches: ~0 rows (approximately)

-- Dumping structure for table peminjaman-buku.kategori
CREATE TABLE IF NOT EXISTS `kategori` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table peminjaman-buku.kategori: ~2 rows (approximately)
INSERT INTO `kategori` (`id`, `nama_kategori`, `created_at`, `updated_at`) VALUES
	(1, 'Elektronik', '2026-02-11 05:55:00', '2026-02-11 05:55:00'),
	(2, 'Perbukuan Sekolah', '2026-02-11 05:55:31', '2026-02-11 05:55:31');

-- Dumping structure for table peminjaman-buku.log_aktivitas
CREATE TABLE IF NOT EXISTS `log_aktivitas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `deskripsi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` bigint unsigned NOT NULL,
  `jenis_aktivitas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_aktivitas` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `log_aktivitas_id_user_foreign` (`id_user`),
  CONSTRAINT `log_aktivitas_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table peminjaman-buku.log_aktivitas: ~61 rows (approximately)
INSERT INTO `log_aktivitas` (`id`, `deskripsi`, `id_user`, `jenis_aktivitas`, `tanggal_aktivitas`, `created_at`, `updated_at`) VALUES
	(1, 'Login ke sistem', 1, 'login', '2026-02-11', '2026-02-11 04:24:16', '2026-02-11 04:24:16'),
	(2, 'Logout dari sistem', 1, 'logout', '2026-02-11', '2026-02-11 05:44:19', '2026-02-11 05:44:19'),
	(3, 'Login ke sistem', 1, 'login', '2026-02-11', '2026-02-11 05:53:49', '2026-02-11 05:53:49'),
	(4, 'Menambahkan kategori baru: Elektronik', 1, 'kategori', '2026-02-11', '2026-02-11 05:55:00', '2026-02-11 05:55:00'),
	(5, 'Menambahkan kategori baru: Perbukuan Sekolah', 1, 'kategori', '2026-02-11', '2026-02-11 05:55:31', '2026-02-11 05:55:31'),
	(6, 'Menambahkan buku baru: Kipas Angin', 1, 'buku', '2026-02-11', '2026-02-11 05:55:55', '2026-02-11 05:55:55'),
	(7, 'Menambahkan buku baru: AC', 1, 'buku', '2026-02-11', '2026-02-11 05:56:21', '2026-02-11 05:56:21'),
	(8, 'Mengajukan peminjaman buku: AC', 1, 'peminjaman', '2026-02-11', '2026-02-11 06:06:20', '2026-02-11 06:06:20'),
	(9, 'Mengubah data buku: AC', 1, 'buku', '2026-02-11', '2026-02-11 06:06:20', '2026-02-11 06:06:20'),
	(10, 'Status peminjaman diubah dari \'menunggu\' menjadi \'disetujui\'', 1, 'peminjaman', '2026-02-11', '2026-02-11 06:07:44', '2026-02-11 06:07:44'),
	(11, 'Mengembalikan buku dari peminjaman ID: 1', 1, 'pengembalian', '2026-02-11', '2026-02-11 06:08:10', '2026-02-11 06:08:10'),
	(12, 'Status peminjaman diubah dari \'disetujui\' menjadi \'dikembalikan\'', 1, 'peminjaman', '2026-02-11', '2026-02-11 06:08:10', '2026-02-11 06:08:10'),
	(13, 'Mengubah data buku: AC', 1, 'buku', '2026-02-11', '2026-02-11 06:08:10', '2026-02-11 06:08:10'),
	(14, 'Login ke sistem', 2, 'login', '2026-02-11', '2026-02-11 06:10:12', '2026-02-11 06:10:12'),
	(15, 'Mengubah data pengembalian ID: 1', 2, 'pengembalian', '2026-02-11', '2026-02-11 06:11:09', '2026-02-11 06:11:09'),
	(16, 'Mengubah data buku: AC', 2, 'buku', '2026-02-11', '2026-02-11 06:11:09', '2026-02-11 06:11:09'),
	(17, 'Menambahkan denda sebesar Rp 35.000 untuk user ID: 3', 2, 'denda', '2026-02-11', '2026-02-11 06:11:09', '2026-02-11 06:11:09'),
	(18, 'Login ke sistem', 1, 'login', '2026-02-11', '2026-02-11 09:04:33', '2026-02-11 09:04:33'),
	(19, 'Logout dari sistem', 1, 'logout', '2026-02-11', '2026-02-11 09:07:23', '2026-02-11 09:07:23'),
	(20, 'Login ke sistem', 2, 'login', '2026-02-11', '2026-02-11 09:07:35', '2026-02-11 09:07:35'),
	(21, 'Logout dari sistem', 2, 'logout', '2026-02-11', '2026-02-11 09:24:08', '2026-02-11 09:24:08'),
	(22, 'Login ke sistem', 1, 'login', '2026-02-11', '2026-02-11 09:48:43', '2026-02-11 09:48:43'),
	(23, 'Menambahkan kategori baru: Perbukuan Rumah', 1, 'kategori', '2026-02-11', '2026-02-11 09:50:47', '2026-02-11 09:50:47'),
	(24, 'Mengubah kategori: Perabotan', 1, 'kategori', '2026-02-11', '2026-02-11 09:51:04', '2026-02-11 09:51:04'),
	(25, 'Menghapus kategori: Perabotan', 1, 'kategori', '2026-02-11', '2026-02-11 09:51:10', '2026-02-11 09:51:10'),
	(26, 'Menambahkan buku baru: Pel', 1, 'buku', '2026-02-11', '2026-02-11 09:51:37', '2026-02-11 09:51:37'),
	(27, 'Mengubah data buku: Kipas', 1, 'buku', '2026-02-11', '2026-02-11 09:51:52', '2026-02-11 09:51:52'),
	(28, 'Menghapus buku: Kipas', 1, 'buku', '2026-02-11', '2026-02-11 09:51:58', '2026-02-11 09:51:58'),
	(29, 'Mengajukan peminjaman buku: Kipas Angin', 1, 'peminjaman', '2026-02-11', '2026-02-11 09:52:43', '2026-02-11 09:52:43'),
	(30, 'Mengubah data buku: Kipas Angin', 1, 'buku', '2026-02-11', '2026-02-11 09:52:43', '2026-02-11 09:52:43'),
	(31, 'Status peminjaman diubah dari \'menunggu\' menjadi \'disetujui\'', 1, 'peminjaman', '2026-02-11', '2026-02-11 09:53:14', '2026-02-11 09:53:14'),
	(32, 'Mengembalikan buku dari peminjaman ID: 2', 1, 'pengembalian', '2026-02-11', '2026-02-11 09:53:58', '2026-02-11 09:53:58'),
	(33, 'Status peminjaman diubah dari \'disetujui\' menjadi \'dikembalikan\'', 1, 'peminjaman', '2026-02-11', '2026-02-11 09:53:58', '2026-02-11 09:53:58'),
	(34, 'Mengubah data buku: Kipas Angin', 1, 'buku', '2026-02-11', '2026-02-11 09:53:58', '2026-02-11 09:53:58'),
	(35, 'Login ke sistem', 2, 'login', '2026-02-11', '2026-02-11 09:54:50', '2026-02-11 09:54:50'),
	(36, 'Mengubah data pengembalian ID: 2', 2, 'pengembalian', '2026-02-11', '2026-02-11 09:55:05', '2026-02-11 09:55:05'),
	(37, 'Mengubah data buku: Kipas Angin', 2, 'buku', '2026-02-11', '2026-02-11 09:55:05', '2026-02-11 09:55:05'),
	(38, 'Menambahkan denda sebesar Rp 10.000 untuk user ID: 3', 2, 'denda', '2026-02-11', '2026-02-11 09:55:05', '2026-02-11 09:55:05'),
	(39, 'Status denda diubah menjadi \'selesai\'', 2, 'denda', '2026-02-11', '2026-02-11 09:56:31', '2026-02-11 09:56:31'),
	(40, 'Status denda diubah menjadi \'selesai\'', 2, 'denda', '2026-02-11', '2026-02-11 09:56:37', '2026-02-11 09:56:37'),
	(41, 'Mengubah data pengembalian ID: 2', 2, 'pengembalian', '2026-02-11', '2026-02-11 09:59:08', '2026-02-11 09:59:08'),
	(42, 'Mengubah data buku: Kipas Angin', 2, 'buku', '2026-02-11', '2026-02-11 09:59:08', '2026-02-11 09:59:08'),
	(43, 'Mengubah data pengembalian ID: 1', 2, 'pengembalian', '2026-02-11', '2026-02-11 09:59:12', '2026-02-11 09:59:12'),
	(44, 'Mengubah data buku: AC', 2, 'buku', '2026-02-11', '2026-02-11 09:59:12', '2026-02-11 09:59:12'),
	(45, 'Mengajukan peminjaman buku: AC', 2, 'peminjaman', '2026-02-11', '2026-02-11 09:59:44', '2026-02-11 09:59:44'),
	(46, 'Mengubah data buku: AC', 2, 'buku', '2026-02-11', '2026-02-11 09:59:44', '2026-02-11 09:59:44'),
	(47, 'Status peminjaman diubah dari \'menunggu\' menjadi \'ditolak\'', 2, 'peminjaman', '2026-02-11', '2026-02-11 10:00:02', '2026-02-11 10:00:02'),
	(48, 'Mengubah data buku: AC', 2, 'buku', '2026-02-11', '2026-02-11 10:00:02', '2026-02-11 10:00:02'),
	(49, 'Logout dari sistem', 2, 'logout', '2026-02-11', '2026-02-11 10:01:44', '2026-02-11 10:01:44'),
	(50, 'Login ke sistem', 3, 'login', '2026-02-11', '2026-02-11 10:02:00', '2026-02-11 10:02:00'),
	(51, 'Mengajukan peminjaman buku: AC', 3, 'peminjaman', '2026-02-11', '2026-02-11 10:02:42', '2026-02-11 10:02:42'),
	(52, 'Mengubah data buku: AC', 3, 'buku', '2026-02-11', '2026-02-11 10:02:42', '2026-02-11 10:02:42'),
	(53, 'Status peminjaman diubah dari \'menunggu\' menjadi \'disetujui\'', 1, 'peminjaman', '2026-02-11', '2026-02-11 10:03:03', '2026-02-11 10:03:03'),
	(54, 'Mengembalikan buku dari peminjaman ID: 4', 3, 'pengembalian', '2026-02-11', '2026-02-11 10:03:41', '2026-02-11 10:03:41'),
	(55, 'Status peminjaman diubah dari \'disetujui\' menjadi \'dikembalikan\'', 3, 'peminjaman', '2026-02-11', '2026-02-11 10:03:41', '2026-02-11 10:03:41'),
	(56, 'Mengubah data buku: AC', 3, 'buku', '2026-02-11', '2026-02-11 10:03:41', '2026-02-11 10:03:41'),
	(57, 'Logout dari sistem', 1, 'logout', '2026-02-11', '2026-02-11 10:03:54', '2026-02-11 10:03:54'),
	(58, 'Login ke sistem', 2, 'login', '2026-02-11', '2026-02-11 10:04:05', '2026-02-11 10:04:05'),
	(59, 'Mengubah data pengembalian ID: 3', 2, 'pengembalian', '2026-02-11', '2026-02-11 10:04:14', '2026-02-11 10:04:14'),
	(60, 'Mengubah data buku: AC', 2, 'buku', '2026-02-11', '2026-02-11 10:04:14', '2026-02-11 10:04:14'),
	(61, 'Menambahkan denda sebesar Rp 20.000 untuk user ID: 3', 2, 'denda', '2026-02-11', '2026-02-11 10:04:14', '2026-02-11 10:04:14'),
	(62, 'Status denda diubah menjadi \'selesai\'', 2, 'denda', '2026-02-11', '2026-02-11 10:05:14', '2026-02-11 10:05:14'),
	(63, 'Mengubah data pengembalian ID: 3', 2, 'pengembalian', '2026-02-11', '2026-02-11 10:05:47', '2026-02-11 10:05:47'),
	(64, 'Mengubah data buku: AC', 2, 'buku', '2026-02-11', '2026-02-11 10:05:47', '2026-02-11 10:05:47'),
	(65, 'Logout dari sistem', 2, 'logout', '2026-02-11', '2026-02-11 10:06:28', '2026-02-11 10:06:28'),
	(66, 'Login ke sistem', 1, 'login', '2026-04-17', '2026-04-16 20:00:45', '2026-04-16 20:00:45'),
	(67, 'Login ke sistem', 2, 'login', '2026-04-17', '2026-04-16 20:01:57', '2026-04-16 20:01:57'),
	(68, 'Login ke sistem', 3, 'login', '2026-04-17', '2026-04-16 20:02:37', '2026-04-16 20:02:37'),
	(69, 'Login ke sistem', 1, 'login', '2026-04-20', '2026-04-19 18:51:05', '2026-04-19 18:51:05'),
	(70, 'Login ke sistem', 1, 'login', '2026-04-20', '2026-04-19 19:16:51', '2026-04-19 19:16:51'),
	(71, 'Login ke sistem', 1, 'login', '2026-04-20', '2026-04-19 19:19:35', '2026-04-19 19:19:35'),
	(72, 'Logout dari sistem', 1, 'logout', '2026-04-20', '2026-04-19 19:23:46', '2026-04-19 19:23:46'),
	(73, 'Logout dari sistem', 1, 'logout', '2026-04-20', '2026-04-19 19:24:13', '2026-04-19 19:24:13'),
	(74, 'Login ke sistem', 1, 'login', '2026-04-20', '2026-04-19 19:24:28', '2026-04-19 19:24:28'),
	(75, 'Login ke sistem', 2, 'login', '2026-04-20', '2026-04-19 19:24:37', '2026-04-19 19:24:37'),
	(76, 'Login ke sistem', 3, 'login', '2026-04-20', '2026-04-19 19:24:58', '2026-04-19 19:24:58'),
	(77, 'Mengajukan peminjaman buku: AC', 3, 'peminjaman', '2026-04-20', '2026-04-19 19:31:07', '2026-04-19 19:31:07'),
	(78, 'Mengubah data buku: AC', 3, 'buku', '2026-04-20', '2026-04-19 19:31:07', '2026-04-19 19:31:07'),
	(79, 'Status peminjaman diubah dari \'menunggu\' menjadi \'disetujui\'', 2, 'peminjaman', '2026-04-20', '2026-04-19 19:31:19', '2026-04-19 19:31:19'),
	(80, 'Mengembalikan buku dari peminjaman ID: 5', 2, 'pengembalian', '2026-04-20', '2026-04-19 19:32:56', '2026-04-19 19:32:56'),
	(81, 'Status peminjaman diubah dari \'disetujui\' menjadi \'dikembalikan\'', 2, 'peminjaman', '2026-04-20', '2026-04-19 19:32:56', '2026-04-19 19:32:56'),
	(82, 'Mengubah data buku: AC', 2, 'buku', '2026-04-20', '2026-04-19 19:32:56', '2026-04-19 19:32:56'),
	(83, 'Mengubah data pengembalian ID: 4', 2, 'pengembalian', '2026-04-20', '2026-04-19 19:33:02', '2026-04-19 19:33:02'),
	(84, 'Mengubah data buku: AC', 2, 'buku', '2026-04-20', '2026-04-19 19:33:02', '2026-04-19 19:33:02'),
	(85, 'Mengubah data pengembalian ID: 4', 2, 'pengembalian', '2026-04-20', '2026-04-19 19:33:27', '2026-04-19 19:33:27'),
	(86, 'Mengubah data buku: AC', 2, 'buku', '2026-04-20', '2026-04-19 19:33:27', '2026-04-19 19:33:27'),
	(87, 'Mengajukan peminjaman buku: AC', 3, 'peminjaman', '2026-04-20', '2026-04-19 19:37:24', '2026-04-19 19:37:24'),
	(88, 'Mengubah data buku: AC', 3, 'buku', '2026-04-20', '2026-04-19 19:37:24', '2026-04-19 19:37:24'),
	(89, 'Status peminjaman diubah dari \'menunggu\' menjadi \'disetujui\'', 2, 'peminjaman', '2026-04-20', '2026-04-19 19:38:03', '2026-04-19 19:38:03'),
	(90, 'Mengembalikan buku dari peminjaman ID: 6', 3, 'pengembalian', '2026-04-20', '2026-04-19 19:38:22', '2026-04-19 19:38:22'),
	(91, 'Status peminjaman diubah dari \'disetujui\' menjadi \'dikembalikan\'', 3, 'peminjaman', '2026-04-20', '2026-04-19 19:38:22', '2026-04-19 19:38:22'),
	(92, 'Mengubah data buku: AC', 3, 'buku', '2026-04-20', '2026-04-19 19:38:22', '2026-04-19 19:38:22'),
	(93, 'Mengubah data pengembalian ID: 5', 2, 'pengembalian', '2026-04-20', '2026-04-19 19:38:45', '2026-04-19 19:38:45'),
	(94, 'Mengubah data buku: AC', 2, 'buku', '2026-04-20', '2026-04-19 19:38:45', '2026-04-19 19:38:45'),
	(95, 'Menambahkan denda sebesar Rp 25.000 untuk user ID: 3', 2, 'denda', '2026-04-20', '2026-04-19 19:38:45', '2026-04-19 19:38:45'),
	(96, 'Mengajukan peminjaman buku: Kipas Angin', 3, 'peminjaman', '2026-04-20', '2026-04-19 20:08:28', '2026-04-19 20:08:28'),
	(97, 'Mengubah data buku: Kipas Angin', 3, 'buku', '2026-04-20', '2026-04-19 20:08:28', '2026-04-19 20:08:28'),
	(98, 'Status peminjaman diubah dari \'menunggu\' menjadi \'disetujui\'', 2, 'peminjaman', '2026-04-20', '2026-04-19 20:10:08', '2026-04-19 20:10:08'),
	(99, 'Menambahkan buku baru: PC 01', 1, 'buku', '2026-04-20', '2026-04-19 20:19:49', '2026-04-19 20:19:49'),
	(100, 'Menambahkan buku baru: Laptop 001', 1, 'buku', '2026-04-20', '2026-04-19 20:20:12', '2026-04-19 20:20:12'),
	(101, 'Menambahkan buku baru: PC 002', 1, 'buku', '2026-04-20', '2026-04-19 20:22:17', '2026-04-19 20:22:17'),
	(102, 'Menambahkan buku baru: Laptop 002', 1, 'buku', '2026-04-20', '2026-04-19 20:22:40', '2026-04-19 20:22:40'),
	(103, 'Logout dari sistem', 1, 'logout', '2026-04-20', '2026-04-19 20:23:25', '2026-04-19 20:23:25'),
	(104, 'Login ke sistem', 2, 'login', '2026-04-20', '2026-04-19 20:24:20', '2026-04-19 20:24:20'),
	(105, 'Mengubah data pengembalian ID: 5', 2, 'pengembalian', '2026-04-20', '2026-04-19 20:24:52', '2026-04-19 20:24:52'),
	(106, 'Mengubah data buku: AC', 2, 'buku', '2026-04-20', '2026-04-19 20:24:52', '2026-04-19 20:24:52'),
	(107, 'Mengajukan peminjaman buku: AC', 3, 'peminjaman', '2026-04-20', '2026-04-19 20:25:44', '2026-04-19 20:25:44'),
	(108, 'Mengubah data buku: AC', 3, 'buku', '2026-04-20', '2026-04-19 20:25:44', '2026-04-19 20:25:44'),
	(109, 'Status peminjaman diubah dari \'menunggu\' menjadi \'disetujui\'', 2, 'peminjaman', '2026-04-20', '2026-04-19 20:25:55', '2026-04-19 20:25:55'),
	(110, 'Mengembalikan buku dari peminjaman ID: 8', 3, 'pengembalian', '2026-04-20', '2026-04-19 20:26:38', '2026-04-19 20:26:38'),
	(111, 'Status peminjaman diubah dari \'disetujui\' menjadi \'dikembalikan\'', 3, 'peminjaman', '2026-04-20', '2026-04-19 20:26:38', '2026-04-19 20:26:38'),
	(112, 'Mengubah data buku: AC', 3, 'buku', '2026-04-20', '2026-04-19 20:26:38', '2026-04-19 20:26:38'),
	(113, 'Mengubah data pengembalian ID: 6', 2, 'pengembalian', '2026-04-20', '2026-04-19 20:26:47', '2026-04-19 20:26:47'),
	(114, 'Mengubah data buku: AC', 2, 'buku', '2026-04-20', '2026-04-19 20:26:47', '2026-04-19 20:26:47'),
	(115, 'Mengembalikan buku dari peminjaman ID: 7', 3, 'pengembalian', '2026-04-20', '2026-04-19 20:33:39', '2026-04-19 20:33:39'),
	(116, 'Status peminjaman diubah dari \'disetujui\' menjadi \'dikembalikan\'', 3, 'peminjaman', '2026-04-20', '2026-04-19 20:33:39', '2026-04-19 20:33:39'),
	(117, 'Mengubah data buku: Kipas Angin', 3, 'buku', '2026-04-20', '2026-04-19 20:33:39', '2026-04-19 20:33:39'),
	(118, 'Mengubah data pengembalian ID: 7', 2, 'pengembalian', '2026-04-20', '2026-04-19 20:36:42', '2026-04-19 20:36:42'),
	(119, 'Status peminjaman diubah dari \'dikembalikan\' menjadi \'disetujui\'', 2, 'peminjaman', '2026-04-20', '2026-04-19 20:36:42', '2026-04-19 20:36:42'),
	(120, 'Mengubah data buku: Kipas Angin', 2, 'buku', '2026-04-20', '2026-04-19 20:36:42', '2026-04-19 20:36:42'),
	(121, 'Mengubah data pengembalian ID: 6', 2, 'pengembalian', '2026-04-20', '2026-04-19 20:36:47', '2026-04-19 20:36:47'),
	(122, 'Mengubah data buku: AC', 2, 'buku', '2026-04-20', '2026-04-19 20:36:47', '2026-04-19 20:36:47'),
	(123, 'Mengembalikan buku dari peminjaman ID: 7', 3, 'pengembalian', '2026-04-20', '2026-04-19 20:37:12', '2026-04-19 20:37:12'),
	(124, 'Status peminjaman diubah dari \'disetujui\' menjadi \'dikembalikan\'', 3, 'peminjaman', '2026-04-20', '2026-04-19 20:37:12', '2026-04-19 20:37:12'),
	(125, 'Mengubah data buku: Kipas Angin', 3, 'buku', '2026-04-20', '2026-04-19 20:37:12', '2026-04-19 20:37:12'),
	(126, 'Menambahkan buku baru: PC 003', 1, 'buku', '2026-04-20', '2026-04-19 20:44:42', '2026-04-19 20:44:42'),
	(127, 'Menambahkan buku baru: Laptop 003', 1, 'buku', '2026-04-20', '2026-04-19 20:49:39', '2026-04-19 20:49:39'),
	(128, 'Mengajukan peminjaman buku: Laptop 001', 3, 'peminjaman', '2026-04-20', '2026-04-19 20:55:14', '2026-04-19 20:55:14'),
	(129, 'Mengubah data buku: Laptop 001', 3, 'buku', '2026-04-20', '2026-04-19 20:55:14', '2026-04-19 20:55:14'),
	(130, 'Mengajukan peminjaman buku: AC', 3, 'peminjaman', '2026-04-20', '2026-04-19 20:59:57', '2026-04-19 20:59:57'),
	(131, 'Mengubah data buku: AC', 3, 'buku', '2026-04-20', '2026-04-19 20:59:57', '2026-04-19 20:59:57'),
	(132, 'Status peminjaman diubah dari \'menunggu\' menjadi \'disetujui\'', 2, 'peminjaman', '2026-04-20', '2026-04-19 21:00:24', '2026-04-19 21:00:24'),
	(133, 'Mengembalikan buku dari peminjaman ID: 10', 3, 'pengembalian', '2026-04-20', '2026-04-19 21:01:27', '2026-04-19 21:01:27'),
	(134, 'Status peminjaman diubah dari \'disetujui\' menjadi \'dikembalikan\'', 3, 'peminjaman', '2026-04-20', '2026-04-19 21:01:27', '2026-04-19 21:01:27'),
	(135, 'Mengubah data buku: AC', 3, 'buku', '2026-04-20', '2026-04-19 21:01:27', '2026-04-19 21:01:27'),
	(136, 'Mengubah data pengembalian ID: 9', 2, 'pengembalian', '2026-04-20', '2026-04-19 21:01:49', '2026-04-19 21:01:49'),
	(137, 'Mengubah data buku: AC', 2, 'buku', '2026-04-20', '2026-04-19 21:01:49', '2026-04-19 21:01:49'),
	(138, 'Menambahkan denda sebesar Rp 20.000 untuk user ID: 3', 2, 'denda', '2026-04-20', '2026-04-19 21:01:49', '2026-04-19 21:01:49'),
	(139, 'Status denda diubah menjadi \'selesai\'', 2, 'denda', '2026-04-20', '2026-04-19 21:03:16', '2026-04-19 21:03:16');

-- Dumping structure for table peminjaman-buku.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table peminjaman-buku.migrations: ~0 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2025_08_14_170933_add_two_factor_columns_to_users_table', 1),
	(5, '2026_02_08_053110_kategori', 1),
	(6, '2026_02_08_053111_buku', 1),
	(7, '2026_02_08_053112_peminjaman', 1),
	(8, '2026_02_08_053258_pengembalian', 1),
	(9, '2026_02_08_053304_denda', 1),
	(10, '2026_02_08_053311_payment', 1),
	(11, '2026_02_08_053321_log_aktivitas', 1),
	(12, '2026_02_08_053313_add_deskripsi_to_peminjaman', 2),
	(13, '2026_02_08_053314_create_bukti_pengembalian_table', 2);

-- Dumping structure for table peminjaman-buku.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table peminjaman-buku.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table peminjaman-buku.payment
CREATE TABLE IF NOT EXISTS `payment` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_denda` bigint unsigned NOT NULL,
  `status` enum('menunggu','disetujui','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  `nominal` int NOT NULL,
  `proof_img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payment_id_denda_foreign` (`id_denda`),
  CONSTRAINT `payment_id_denda_foreign` FOREIGN KEY (`id_denda`) REFERENCES `denda` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table peminjaman-buku.payment: ~2 rows (approximately)
INSERT INTO `payment` (`id`, `id_denda`, `status`, `nominal`, `proof_img`, `created_at`, `updated_at`) VALUES
	(1, 1, 'disetujui', 35000, 'proof_images/1770815775_borrowing.png', '2026-02-11 06:16:16', '2026-02-11 09:56:37'),
	(2, 2, 'disetujui', 10000, 'proof_images/1770828979_borrowing.png', '2026-02-11 09:56:19', '2026-02-11 09:56:31'),
	(3, 3, 'disetujui', 20000, 'proof_images/1770829497_flowchart buku peminjaman barang -Logout.jpg', '2026-02-11 10:04:57', '2026-02-11 10:05:14'),
	(4, 5, 'disetujui', 20000, 'proof_images/1776657778_giphy.gif', '2026-04-19 21:02:58', '2026-04-19 21:03:16');

-- Dumping structure for table peminjaman-buku.peminjaman
CREATE TABLE IF NOT EXISTS `peminjaman` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_user` bigint unsigned NOT NULL,
  `id_buku` bigint unsigned NOT NULL,
  `tgl_pengembalian` date NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `status` enum('menunggu','disetujui','ditolak','dikembalikan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `peminjaman_id_user_foreign` (`id_user`),
  KEY `peminjaman_id_buku_foreign` (`id_buku`),
  CONSTRAINT `peminjaman_id_buku_foreign` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id`) ON DELETE CASCADE,
  CONSTRAINT `peminjaman_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table peminjaman-buku.peminjaman: ~4 rows (approximately)
INSERT INTO `peminjaman` (`id`, `id_user`, `id_buku`, `tgl_pengembalian`, `deskripsi`, `status`, `created_at`, `updated_at`) VALUES
	(1, 3, 2, '2026-02-12', NULL, 'dikembalikan', '2026-02-11 06:06:20', '2026-02-11 06:08:10'),
	(2, 3, 1, '2026-02-13', NULL, 'dikembalikan', '2026-02-11 09:52:43', '2026-02-11 09:53:58'),
	(3, 3, 2, '2026-02-14', NULL, 'ditolak', '2026-02-11 09:59:44', '2026-02-11 10:00:02'),
	(4, 3, 2, '2026-02-12', NULL, 'dikembalikan', '2026-02-11 10:02:42', '2026-02-11 10:03:41'),
	(5, 3, 2, '2026-04-21', NULL, 'dikembalikan', '2026-04-19 19:31:07', '2026-04-19 19:32:56'),
	(6, 3, 2, '2026-04-18', NULL, 'dikembalikan', '2026-04-19 19:37:24', '2026-04-19 19:38:22'),
	(7, 3, 1, '2026-04-21', NULL, 'dikembalikan', '2026-04-19 20:08:28', '2026-04-19 20:37:12'),
	(8, 3, 2, '2026-04-21', 'untuk ruangan B-21', 'dikembalikan', '2026-04-19 20:25:44', '2026-04-19 20:26:38'),
	(9, 3, 5, '2026-04-23', 'Laptop untuk kerja', 'menunggu', '2026-04-19 20:55:14', '2026-04-19 20:55:14'),
	(10, 3, 2, '2026-04-23', 'ac untuk ruangan A001', 'dikembalikan', '2026-04-19 20:59:57', '2026-04-19 21:01:27');

-- Dumping structure for table peminjaman-buku.pengembalian
CREATE TABLE IF NOT EXISTS `pengembalian` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_peminjaman` bigint unsigned NOT NULL,
  `tanggal_kembali_realisasi` date NOT NULL,
  `id_user` bigint unsigned NOT NULL,
  `status` enum('menunggu','disetujui','ditolak','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  `hari_terlambat` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pengembalian_id_peminjaman_foreign` (`id_peminjaman`),
  KEY `pengembalian_id_user_foreign` (`id_user`),
  CONSTRAINT `pengembalian_id_peminjaman_foreign` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pengembalian_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table peminjaman-buku.pengembalian: ~2 rows (approximately)
INSERT INTO `pengembalian` (`id`, `id_peminjaman`, `tanggal_kembali_realisasi`, `id_user`, `status`, `hari_terlambat`, `created_at`, `updated_at`) VALUES
	(1, 1, '2026-02-19', 3, 'selesai', 7, '2026-02-11 06:08:10', '2026-02-11 09:59:12'),
	(2, 2, '2026-02-15', 3, 'selesai', 2, '2026-02-11 09:53:58', '2026-02-11 09:59:08'),
	(3, 4, '2026-02-16', 3, 'selesai', 4, '2026-02-11 10:03:41', '2026-02-11 10:05:47'),
	(4, 5, '2026-04-13', 3, 'selesai', 0, '2026-04-19 19:32:56', '2026-04-19 19:33:27'),
	(5, 6, '2026-04-23', 3, 'selesai', 5, '2026-04-19 19:38:22', '2026-04-19 20:24:52'),
	(6, 8, '2026-04-20', 3, 'selesai', 0, '2026-04-19 20:26:38', '2026-04-19 20:36:47'),
	(7, 7, '2026-04-22', 3, 'ditolak', 1, '2026-04-19 20:33:39', '2026-04-19 20:36:42'),
	(8, 7, '2026-04-23', 3, 'menunggu', 2, '2026-04-19 20:37:12', '2026-04-19 20:37:12'),
	(9, 10, '2026-04-27', 3, 'disetujui', 4, '2026-04-19 21:01:27', '2026-04-19 21:01:49');

-- Dumping structure for table peminjaman-buku.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table peminjaman-buku.sessions: ~7 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('aDrrKzgHzZi1WQFDY0Zjzt7sYdwJTYEcSq1HHb7r', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWDNWanlvVE5nbkZsUHNDNXA2V3dZdUZlNjVPaGJyaUdweXNhbWRINSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZW1pbmphbWFuIjtzOjU6InJvdXRlIjtzOjE2OiJwZW1pbmphbWFuLmluZGV4Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1776657609),
	('k6As1XcMMomAdYMRrYtVY2b1pQzU7Ei4RNIYgwDf', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZ2I3RkZvRFFIQ1k4M0h4dHhGeWxqc09FWFlYZEJhQ3JZUTVkV3o5MSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wYXltZW50IjtzOjU6InJvdXRlIjtzOjEzOiJwYXltZW50LmluZGV4Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1776657798),
	('QaOy9raxq2L6JGvxzvKMwdSTbccQHnmubD852JQ8', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVno5M1R4eU14SW5zeEc5R0FyZVpZMlB1dTBqZ2pPQ3NvTWRlNlZiYiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vbG9jYWxob3N0OjgwMDAvZGVuZGEiO3M6NToicm91dGUiO3M6MTE6ImRlbmRhLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mzt9', 1776658049),
	('YiRLUrH2JwrinWxMOM7sY1rikCIQoLbE2dVcxgLQ', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoib0daYlA5eTNyakhkakw5Y1FPT3UxMkFheTdLNmVPM3ZSMGRRZWVsOCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9wZW1pbmphbWFuIjtzOjU6InJvdXRlIjtzOjE2OiJwZW1pbmphbWFuLmluZGV4Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1776657517);

-- Dumping structure for table peminjaman-buku.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','petugas','peminjam') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'peminjam',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table peminjaman-buku.users: ~3 rows (approximately)
INSERT INTO `users` (`id`, `name`, `username`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Admin', 'admin@gmail.com', NULL, '$2y$12$CKz63rwaKl03Z.nLm0mkvutAxYAPGSryskoni.65SPdDd7fAJjrjO', NULL, NULL, NULL, 'admin', NULL, '2026-02-10 22:50:57', '2026-02-10 22:50:57'),
	(2, 'Petugas', 'petugas@gmail.com', NULL, '$2y$12$GltCjb9JgvMI1Wf569RMKe8zT7irxbR4DyKe0Vte0.Ep4j/nQkffq', NULL, NULL, NULL, 'petugas', NULL, '2026-02-10 22:50:57', '2026-02-10 22:50:57'),
	(3, 'Peminjam', 'peminjam@gmail.com', NULL, '$2y$12$ZEax9M2peUruYVK/TJNL5.KtAng0W.iNzcURp8/hsgYpHdoyYCOJG', NULL, NULL, NULL, 'peminjam', NULL, '2026-02-10 22:50:58', '2026-02-10 22:50:58');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
