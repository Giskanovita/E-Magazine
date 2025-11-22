# Fix Database Relations - Primary Key Issue

## Masalah yang Diperbaiki
Error: `SQLSTATE[42S22]: Column not found: 1054 Unknown column 'users.id' in 'where clause'`

## Root Cause
- Tabel `users` menggunakan `id_user` sebagai primary key
- Model User sempat diubah menggunakan `id` sebagai primary key
- Relasi database menjadi tidak konsisten

## Perbaikan yang Dilakukan

### 1. Model User
```php
protected $primaryKey = 'id_user';  // Kembali ke id_user
```

### 2. Relasi Database
- `User::hasMany(Artikel)` → foreign key: `id_user`, local key: `id_user`
- `Artikel::belongsTo(User)` → foreign key: `id_user`, local key: `id_user`
- `User::hasMany(Like)` → foreign key: `id_user`, local key: `id_user`

### 3. Controller Updates
- `Auth::id()` → `Auth::user()->id_user`
- Semua query menggunakan `id_user` konsisten

### 4. View Updates
- `$user->name` → `$user->nama` (sesuai kolom database)

## Database Structure
```sql
users:
- id_user (PK)
- nama
- username
- password
- role

artikel:
- id_artikel (PK)
- id_user (FK → users.id_user)
- judul, isi, tanggal, foto, lampiran, status

komentar:
- id_komentar (PK)
- id_user (FK → users.id_user)
- id_artikel (FK → artikel.id_artikel)
```

## Files Fixed
- `app/Models/User.php`
- `app/Models/artikel.php`
- `app/Models/Komentar.php`
- `app/Http/Controllers/DashboardController.php`
- `app/Http/Controllers/ManajemenArtikelController.php`
- `resources/views/pages/artikel.blade.php`
- `resources/views/partials/navbar.blade.php`
- `resources/views/pages/single-post.blade.php`

## Testing
1. Login dengan user demo
2. Akses dashboard (harus menampilkan statistik)
3. Buka "Kelola Artikel" (harus menampilkan artikel user)
4. Buat artikel baru (harus tersimpan dengan id_user yang benar)
5. Lihat artikel public (harus menampilkan nama penulis)

Sistem sekarang konsisten menggunakan `id_user` sebagai primary key!