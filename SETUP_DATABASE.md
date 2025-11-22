# 🗄️ Setup Database E-Mading

## 📋 **Langkah Setup Database:**

### 1. **Buat Database**
```sql
CREATE DATABASE `e-mading`;
```

### 2. **Import Database**
- Buka **phpMyAdmin** atau **MySQL Workbench**
- Pilih database `e-mading`
- Import file: `database_complete.sql`
- Atau copy-paste isi file ke SQL editor

### 3. **Verifikasi Database**
Jalankan test koneksi:
```bash
php test_database.php
```

### 4. **Konfigurasi .env**
Pastikan konfigurasi database di `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=e-mading
DB_USERNAME=root
DB_PASSWORD=
```

## 📊 **Struktur Database:**

### **Tables:**
- `users` - Data pengguna (admin, guru, siswa)
- `kategori` - Kategori artikel  
- `artikel` - Data artikel dengan status
- `likes` - Data like artikel
- `notifications` - Notifikasi sistem

### **Sample Data:**
- **5 Kategori**: Teknologi, Olahraga, Seni, Akademik, Berita Sekolah
- **5 Artikel**: 4 publikasi, 1 draft untuk testing
- **3 Users**: admin, guru, siswa
- **4 Likes**: Sample interaksi
- **2 Notifications**: Sample notifikasi

## 🔑 **Login Accounts:**

| Username | Password | Role | Akses |
|----------|----------|------|-------|
| `admin` | `password` | Admin | Dashboard admin, kelola artikel |
| `guru` | `password` | Guru | Dashboard guru, buat artikel |
| `siswa` | `password` | Siswa | Dashboard siswa, kirim artikel |

## 🚀 **Testing:**

1. **Import database** → `database_complete.sql`
2. **Test koneksi** → `php test_database.php`
3. **Jalankan server** → `php artisan serve`
4. **Login** → `/login` dengan akun di atas
5. **Test fitur** → Dashboard sesuai role

## ❗ **Troubleshooting:**

**Error: Database not found**
- Pastikan MySQL running
- Buat database `e-mading` dulu

**Error: Connection refused**
- Cek MySQL service
- Periksa username/password di `.env`

**Error: Table not found**
- Import ulang `database_complete.sql`
- Pastikan semua tabel ter-create

Database siap digunakan! 🎉