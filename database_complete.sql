-- Database: e-mading
CREATE DATABASE IF NOT EXISTS `e-mading` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `e-mading`;

-- Table structure for table `users`
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id_user` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','guru','siswa') NOT NULL DEFAULT 'siswa',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table structure for table `kategori`
DROP TABLE IF EXISTS `kategori`;
CREATE TABLE `kategori` (
  `id_kategori` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table structure for table `artikel`
DROP TABLE IF EXISTS `artikel`;
CREATE TABLE `artikel` (
  `id_artikel` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `tanggal` date NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('draft','publikasi') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_artikel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table structure for table `likes`
DROP TABLE IF EXISTS `likes`;
CREATE TABLE `likes` (
  `id_like` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_artikel` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_like`),
  KEY `likes_id_artikel_foreign` (`id_artikel`),
  KEY `likes_id_user_foreign` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table structure for table `notifications`
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'info',
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_id_user_foreign` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample data for users (password: 'password')
INSERT INTO `users` (`id_user`, `nama`, `username`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NOW(), NOW()),
(2, 'Pak Guru', 'guru', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'guru', NOW(), NOW()),
(3, 'Ahmad Siswa', 'siswa', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'siswa', NOW(), NOW());

-- Insert sample data for kategori
INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `created_at`, `updated_at`) VALUES
(1, 'Teknologi', NOW(), NOW()),
(2, 'Olahraga', NOW(), NOW()),
(3, 'Seni', NOW(), NOW()),
(4, 'Akademik', NOW(), NOW()),
(5, 'Berita Sekolah', NOW(), NOW());

-- Insert sample data for artikel
INSERT INTO `artikel` (`id_artikel`, `judul`, `isi`, `tanggal`, `id_user`, `id_kategori`, `foto`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Inovasi Teknologi di Sekolah', 'Penerapan teknologi terbaru dalam proses pembelajaran membawa perubahan positif bagi siswa dan guru. Dengan menggunakan perangkat digital, pembelajaran menjadi lebih interaktif dan menarik. Siswa dapat mengakses materi pembelajaran dengan mudah melalui platform online yang telah disediakan sekolah.', '2024-11-12', 1, 1, NULL, 'publikasi', NOW(), NOW()),
(2, 'Prestasi Olahraga Terbaru', 'Tim basket sekolah meraih juara dalam kompetisi antar sekolah se-kota. Prestasi ini merupakan hasil dari latihan keras dan dedikasi tinggi para atlet muda. Pelatih dan seluruh tim sangat bangga dengan pencapaian ini.', '2024-11-10', 2, 2, NULL, 'publikasi', NOW(), NOW()),
(3, 'Pameran Seni Siswa', 'Karya seni siswa dipamerkan dalam acara tahunan sekolah dengan antusias tinggi dari seluruh warga sekolah. Berbagai karya mulai dari lukisan, patung, hingga kerajinan tangan ditampilkan dengan apik.', '2024-11-08', 3, 3, NULL, 'draft', NOW(), NOW()),
(4, 'Pengumuman Hasil Ujian Semester', 'Hasil ujian semester telah diumumkan dengan berbagai prestasi membanggakan dari siswa-siswi berprestasi. Sekolah memberikan apresiasi kepada siswa yang berhasil meraih nilai terbaik.', '2024-11-05', 2, 4, NULL, 'publikasi', NOW(), NOW()),
(5, 'Kegiatan Bakti Sosial Sekolah', 'Sekolah mengadakan kegiatan bakti sosial untuk membantu masyarakat sekitar. Seluruh siswa dan guru berpartisipasi aktif dalam kegiatan ini sebagai bentuk kepedulian sosial.', '2024-11-03', 1, 5, NULL, 'publikasi', NOW(), NOW());

-- Insert sample data for likes
INSERT INTO `likes` (`id_like`, `id_artikel`, `id_user`, `created_at`, `updated_at`) VALUES
(1, 1, 3, NOW(), NOW()),
(2, 1, 2, NOW(), NOW()),
(3, 2, 3, NOW(), NOW()),
(4, 4, 1, NOW(), NOW());

-- Insert sample notifications
INSERT INTO `notifications` (`id`, `id_user`, `title`, `message`, `type`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 1, 'Artikel Baru dari Siswa', 'Siswa Ahmad Siswa telah mengirim artikel: Pameran Seni Siswa', 'info', 0, NOW(), NOW()),
(2, 2, 'Artikel Baru dari Siswa', 'Siswa Ahmad Siswa telah mengirim artikel: Pameran Seni Siswa', 'info', 0, NOW(), NOW());

-- Add foreign key constraints
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_id_artikel_foreign` FOREIGN KEY (`id_artikel`) REFERENCES `artikel` (`id_artikel`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;