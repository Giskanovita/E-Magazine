# E-Magazine Sekolah System

Sistem E-Magazine Sekolah yang dikembangkan dengan Laravel sesuai spesifikasi dokumen.

## Peran Aktor dan Hak Akses

### 1. Admin Sekolah
**Hak Akses/Aktivitas:**
- Login ke sistem
- Kelola kategori artikel
- Verifikasi dan publikasi artikel
- Kelola user (tambah, edit, hapus)
- Membuat laporan sistem

**Route Access:**
- `/admin/dashboard` - Dashboard admin
- `/admin/kategori` - Kelola kategori
- `/admin/artikel` - Verifikasi artikel
- `/admin/users` - Kelola user
- `/admin/laporan` - Laporan sistem

### 2. Guru/Pembina Mading
**Hak Akses/Aktivitas:**
- Menulis artikel (langsung publish)
- Mengedit artikel miliknya
- Melihat komentar pada artikelnya
- Menyetujui artikel siswa

**Route Access:**
- `/guru/dashboard` - Dashboard guru
- `/guru/artikel` - Kelola artikel
- `/guru/komentar` - Lihat komentar
- `/guru/moderasi` - Setujui artikel siswa

### 3. Siswa
**Hak Akses/Aktivitas:**
- Membuat artikel (status draft, perlu persetujuan)
- Mengedit artikel miliknya (hanya yang masih draft)
- Membaca artikel dan berkomentar

**Route Access:**
- `/siswa/dashboard` - Dashboard siswa
- `/siswa/artikel` - Kelola artikel
- Akses komentar pada artikel publik

### 4. Publik/Pengunjung (Opsional)
**Hak Akses/Aktivitas:**
- Membaca artikel tanpa login
- Tidak bisa menulis atau berkomentar

**Route Access:**
- `/` - Halaman utama
- `/artikel` - Daftar artikel
- `/kategori` - Daftar kategori

## Fitur Sistem

### Sistem Autentikasi
- Login berdasarkan username dan password
- Role-based access control
- Redirect otomatis ke dashboard sesuai role

### Manajemen Artikel
- **Admin**: Verifikasi semua artikel
- **Guru**: Buat artikel langsung publish, setujui artikel siswa
- **Siswa**: Buat artikel draft, edit hanya yang draft

### Sistem Komentar
- Hanya user yang login bisa berkomentar
- Komentar ditampilkan pada halaman artikel

### Notifikasi
- Notifikasi untuk guru saat ada artikel siswa baru
- Sistem notifikasi terintegrasi

## Instalasi dan Setup

1. **Clone dan Install Dependencies**
```bash
composer install
npm install
```

2. **Setup Environment**
```bash
cp .env.example .env
php artisan key:generate
```

3. **Setup Database**
```bash
php artisan migrate
php artisan db:seed
```

4. **Setup Storage**
```bash
php artisan storage:link
```

5. **Run Development Server**
```bash
php artisan serve
```

## User Demo

Setelah menjalankan seeder, tersedia user demo:

| Role | Username | Password |
|------|----------|----------|
| Admin | admin | admin123 |
| Guru | guru1 | guru123 |
| Siswa | siswa1 | siswa123 |
| Publik | publik1 | publik123 |

## Struktur Database

### Users Table
- `id_user` (Primary Key)
- `nama` - Nama lengkap
- `username` - Username untuk login
- `password` - Password (hashed)
- `role` - enum('admin', 'guru', 'siswa', 'publik')

### Artikel Table
- `id_artikel` (Primary Key)
- `judul` - Judul artikel
- `isi` - Konten artikel
- `tanggal` - Tanggal publikasi
- `foto` - Gambar artikel (optional)
- `status` - enum('draft', 'publikasi')
- `id_kategori` - Foreign key ke kategori
- `id_user` - Foreign key ke user

### Kategori Table
- `id_kategori` (Primary Key)
- `nama_kategori` - Nama kategori

### Komentar Table
- `id_komentar` (Primary Key)
- `isi_komentar` - Isi komentar
- `id_artikel` - Foreign key ke artikel
- `id_user` - Foreign key ke user

## Workflow Artikel

1. **Admin**: Buat artikel → Langsung publish
2. **Guru**: Buat artikel → Langsung publish
3. **Siswa**: Buat artikel → Status draft → Perlu persetujuan guru → Publish
4. **Publik**: Hanya baca artikel yang sudah publish

## Security Features

- Role-based middleware protection
- CSRF protection
- Password hashing
- File upload validation
- SQL injection protection (Eloquent ORM)

## Teknologi yang Digunakan

- **Backend**: Laravel 11
- **Database**: SQLite/MySQL
- **Frontend**: Blade Templates, Bootstrap
- **Authentication**: Laravel Auth
- **File Storage**: Laravel Storage