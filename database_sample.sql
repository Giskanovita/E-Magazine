-- Data untuk tabel users
INSERT INTO users (id_user, nama, username, password, role, created_at, updated_at) VALUES
(1, 'Administrator', 'admin', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NOW(), NOW()),
(2, 'Guru Bahasa Indonesia', 'guru1', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'guru', NOW(), NOW()),
(3, 'Guru Matematika', 'guru2', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'guru', NOW(), NOW()),
(4, 'Ahmad Siswa', 'siswa1', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'siswa', NOW(), NOW()),
(5, 'Siti Siswa', 'siswa2', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'siswa', NOW(), NOW()),
(6, 'Budi Siswa', 'siswa3', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'siswa', NOW(), NOW());

-- Data untuk tabel kategori
INSERT INTO kategori (id_kategori, nama_kategori, created_at, updated_at) VALUES
(1, 'Teknologi', NOW(), NOW()),
(2, 'Olahraga', NOW(), NOW()),
(3, 'Seni', NOW(), NOW()),
(4, 'Akademik', NOW(), NOW()),
(5, 'Berita Sekolah', NOW(), NOW());

-- Data untuk tabel artikel
INSERT INTO artikel (id_artikel, judul, isi, tanggal, id_user, id_kategori, foto, status, created_at, updated_at) VALUES
(1, 'Inovasi Teknologi di Sekolah', 'Penerapan teknologi terbaru dalam proses pembelajaran membawa perubahan positif. Siswa kini dapat belajar dengan lebih interaktif menggunakan tablet dan proyektor digital.', '2024-11-10', 4, 1, '66.jpeg', 'publikasi', NOW(), NOW()),
(2, 'Prestasi Tim Basket Sekolah', 'Tim basket sekolah meraih juara 1 dalam kompetisi antar sekolah se-kota. Prestasi ini merupakan hasil latihan keras selama 6 bulan.', '2024-11-09', 5, 2, 'bkns.jpeg', 'publikasi', NOW(), NOW()),
(3, 'Pameran Seni Siswa 2024', 'Karya seni siswa dipamerkan dalam acara tahunan sekolah. Berbagai lukisan, patung, dan kerajinan tangan ditampilkan dengan antusias tinggi.', '2024-11-08', 6, 3, 'nss.jpeg', 'publikasi', NOW(), NOW()),
(4, 'Pengumuman Hasil Ujian Semester', 'Hasil ujian semester telah diumumkan. Selamat kepada siswa yang meraih prestasi terbaik dan tetap semangat untuk yang lainnya.', '2024-11-07', 2, 4, NULL, 'publikasi', NOW(), NOW()),
(5, 'Kegiatan Ekstrakurikuler Baru', 'Sekolah membuka ekstrakurikuler robotika untuk mengembangkan minat siswa di bidang teknologi dan engineering.', '2024-11-06', 3, 1, NULL, 'draft', NOW(), NOW()),
(6, 'Lomba Puisi Tingkat Nasional', 'Siswa kelas XI meraih juara 2 dalam lomba puisi tingkat nasional. Karya puisinya bertema lingkungan hidup.', '2024-11-05', 4, 3, NULL, 'publikasi', NOW(), NOW());

-- Data untuk tabel like_artikel
INSERT INTO like_artikel (id_like, id_user, id_artikel, created_at, updated_at) VALUES
(1, 4, 1, NOW(), NOW()),
(2, 5, 1, NOW(), NOW()),
(3, 6, 1, NOW(), NOW()),
(4, 2, 1, NOW(), NOW()),
(5, 3, 1, NOW(), NOW()),
(6, 4, 2, NOW(), NOW()),
(7, 5, 2, NOW(), NOW()),
(8, 6, 2, NOW(), NOW()),
(9, 2, 2, NOW(), NOW()),
(10, 4, 3, NOW(), NOW()),
(11, 5, 3, NOW(), NOW()),
(12, 6, 3, NOW(), NOW()),
(13, 4, 6, NOW(), NOW()),
(14, 5, 6, NOW(), NOW());

-- Data untuk tabel contact
INSERT INTO contact (id_contact, nama, email, pesan, created_at, updated_at) VALUES
(1, 'Orang Tua Siswa', 'orangtua1@email.com', 'Terima kasih atas pendidikan yang baik untuk anak saya. Semoga sekolah terus maju.', NOW(), NOW()),
(2, 'Alumni 2020', 'alumni2020@email.com', 'Saya bangga menjadi alumni sekolah ini. Ingin berkontribusi untuk kemajuan sekolah.', NOW(), NOW()),
(3, 'Masyarakat Sekitar', 'warga@email.com', 'Sekolah ini sangat membantu dalam kegiatan sosial di lingkungan kami. Terima kasih.', NOW(), NOW()),
(4, 'Calon Siswa', 'calonsiswa@email.com', 'Bagaimana cara mendaftar di sekolah ini? Mohon informasinya.', NOW(), NOW());

-- Password untuk semua user adalah: password