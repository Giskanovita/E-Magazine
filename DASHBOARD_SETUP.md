# Dashboard Pengguna - Setup Guide

## Fitur Dashboard
Dashboard pengguna menampilkan ringkasan:
- **Total Artikel**: Jumlah semua artikel yang dibuat user
- **Draft**: Jumlah artikel dengan status draft
- **Dipublikasi**: Jumlah artikel dengan status publikasi
- **Komentar**: Total komentar pada artikel user
- **Artikel Terbaru**: Daftar 5 artikel terbaru user

## Database Tables

### Tabel Komentar
```sql
CREATE TABLE `komentar` (
  `id_komentar` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_artikel` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `isi_komentar` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_komentar`)
);
```

### Update Tabel Artikel
- Kolom `status` dengan enum('draft', 'publikasi')
- Default value: 'draft'

## Setup Instructions

### Otomatis
```bash
setup_dashboard.bat
```

### Manual
```bash
# 1. Jalankan migration
php artisan migrate --path=database/migrations/2025_11_13_134201_create_komentar_table.php

# 2. Seed data komentar
php artisan db:seed --class=KomentarSeeder

# 3. Import SQL (opsional)
mysql -u root -p magazine < database_dashboard.sql
```

## Akses Dashboard
- URL: `http://localhost:8000/dashboard`
- Requirement: User harus login
- Available untuk semua role (admin, guru, siswa)

## Files Created/Modified

### New Files:
- `database/migrations/2025_11_13_134201_create_komentar_table.php`
- `app/Models/Komentar.php`
- `app/Http/Controllers/DashboardController.php`
- `resources/views/dashboard/index.blade.php`
- `database/seeders/KomentarSeeder.php`

### Modified Files:
- `app/Models/artikel.php` - Added komentar relation
- `routes/web.php` - Added dashboard route
- `resources/views/partials/navbar.blade.php` - Added dashboard link and auth buttons

## Navigation
- Dashboard link muncul di navbar untuk user yang login
- Login/Logout button di header
- Breadcrumb navigation

## Statistics Calculation
- Total artikel: Count artikel by user ID
- Draft/Publish: Count by status and user ID  
- Total komentar: Count komentar on user's articles
- Artikel terbaru: Latest 5 articles with kategori relation