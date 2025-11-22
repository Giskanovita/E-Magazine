-- Sistem Like untuk Artikel Magazine
-- Tabel likes sudah ada, ini adalah data sample

-- Sample data likes (sesuaikan dengan artikel yang ada)
INSERT INTO `likes` (`id_artikel`, `id_user`, `created_at`, `updated_at`) VALUES
(98, 1, NOW(), NOW()),
(98, 2, NOW(), NOW());

-- Query untuk cek artikel dengan jumlah like
SELECT 
    a.id_artikel,
    a.judul,
    a.status,
    COUNT(l.id_like) as total_likes
FROM artikel a
LEFT JOIN likes l ON a.id_artikel = l.id_artikel
WHERE a.status = 'publikasi'
GROUP BY a.id_artikel, a.judul, a.status
ORDER BY total_likes DESC;

-- Query untuk cek artikel yang disukai user tertentu
SELECT 
    a.id_artikel,
    a.judul,
    u.nama as penulis,
    k.nama_kategori
FROM artikel a
JOIN likes l ON a.id_artikel = l.id_artikel
JOIN users u ON a.id_user = u.id_user
LEFT JOIN kategori k ON a.id_kategori = k.id_kategori
WHERE l.id_user = 1 -- Ganti dengan ID user yang ingin dicek
AND a.status = 'publikasi'
ORDER BY l.created_at DESC;