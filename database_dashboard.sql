-- Database setup untuk Dashboard Magazine
-- Tabel komentar
CREATE TABLE IF NOT EXISTS `komentar` (
  `id_komentar` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_artikel` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `isi_komentar` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_komentar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data sample komentar
INSERT INTO `komentar` (`id_artikel`, `id_user`, `isi_komentar`, `created_at`, `updated_at`) VALUES
(1, 2, 'Artikel yang sangat menarik dan informatif!', NOW(), NOW()),
(1, 3, 'Terima kasih atas informasinya, sangat bermanfaat.', NOW(), NOW()),
(2, 1, 'Prestasi yang membanggakan untuk sekolah kita!', NOW(), NOW()),
(2, 3, 'Selamat untuk para juara!', NOW(), NOW()),
(3, 2, 'Kegiatan yang sangat positif untuk siswa.', NOW(), NOW());

-- Update artikel table untuk memastikan kolom status ada
ALTER TABLE `artikel` 
MODIFY COLUMN `status` enum('draft','publikasi') NOT NULL DEFAULT 'draft';

-- Update beberapa artikel untuk memiliki status yang berbeda
UPDATE `artikel` SET `status` = 'publikasi' WHERE `id_artikel` IN (1, 2);
UPDATE `artikel` SET `status` = 'draft' WHERE `id_artikel` = 3;