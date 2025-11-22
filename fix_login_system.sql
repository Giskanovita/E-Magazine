-- Fix Login System Database
-- Pastikan tabel users ada dengan struktur yang benar
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','guru','siswa') NOT NULL DEFAULT 'siswa',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Hapus user lama jika ada
DELETE FROM `users`;

-- Insert user demo dengan password yang benar
INSERT INTO `users` (`name`, `username`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
('Administrator', 'admin', 'admin@magazine.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NOW(), NOW()),
('Guru Demo', 'guru', 'guru@magazine.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'guru', NOW(), NOW()),
('Siswa Demo', 'siswa', 'siswa@magazine.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'siswa', NOW(), NOW());

-- Update artikel untuk menggunakan id user yang benar
UPDATE `artikel` SET `id_user` = 1 WHERE `id_artikel` = 1;
UPDATE `artikel` SET `id_user` = 2 WHERE `id_artikel` = 2;
UPDATE `artikel` SET `id_user` = 3 WHERE `id_artikel` = 3;