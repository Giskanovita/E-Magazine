-- Quick fix for login issue
USE `e-mading`;

-- Delete existing users and recreate with correct password
DELETE FROM users;

-- Insert users with Laravel bcrypt hash for 'password'
INSERT INTO `users` (`id_user`, `nama`, `username`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NOW(), NOW()),
(2, 'Pak Guru', 'guru', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'guru', NOW(), NOW()),
(3, 'Ahmad Siswa', 'siswa', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'siswa', NOW(), NOW());

-- Update artikel to use correct user IDs
UPDATE artikel SET id_user = 1 WHERE id_artikel IN (1, 5);
UPDATE artikel SET id_user = 2 WHERE id_artikel IN (2, 4);
UPDATE artikel SET id_user = 3 WHERE id_artikel = 3;

-- Update likes to use correct user IDs
DELETE FROM likes;
INSERT INTO `likes` (`id_like`, `id_artikel`, `id_user`, `created_at`, `updated_at`) VALUES
(1, 1, 3, NOW(), NOW()),
(2, 1, 2, NOW(), NOW()),
(3, 2, 3, NOW(), NOW()),
(4, 4, 1, NOW(), NOW());

-- Update notifications
DELETE FROM notifications;
INSERT INTO `notifications` (`id`, `id_user`, `title`, `message`, `type`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 1, 'Artikel Baru dari Siswa', 'Siswa Ahmad Siswa telah mengirim artikel: Pameran Seni Siswa', 'info', 0, NOW(), NOW()),
(2, 2, 'Artikel Baru dari Siswa', 'Siswa Ahmad Siswa telah mengirim artikel: Pameran Seni Siswa', 'info', 0, NOW(), NOW());

SELECT 'Database fixed successfully!' as status;