# Perbaikan Sistem Login Berdasarkan Role

## Masalah yang Diperbaiki
- Admin bisa login dan masuk ke halaman admin ✓
- Guru dan siswa tidak bisa masuk ke halaman masing-masing ✗

## Penyebab Masalah
1. **RoleMiddleware** menggunakan `abort(403)` yang menampilkan error 403 alih-alih redirect yang user-friendly
2. **View dashboard** menggunakan route yang salah (`manajemen.artikel` instead of `guru.artikel` / `siswa.artikel`)
3. **Password** untuk user guru dan siswa tidak sesuai dengan yang diharapkan

## Solusi yang Diterapkan

### 1. Perbaikan RoleMiddleware
**File:** `app/Http/Middleware/RoleMiddleware.php`

**Sebelum:**
```php
if (!in_array($userRole, $roles)) {
    abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
}
```

**Sesudah:**
```php
if (!in_array($userRole, $roles)) {
    // Redirect ke dashboard sesuai role user
    switch ($userRole) {
        case 'admin':
            return redirect('/admin/dashboard')->with('error', 'Akses ditolak untuk halaman tersebut');
        case 'guru':
            return redirect('/guru/dashboard')->with('error', 'Akses ditolak untuk halaman tersebut');
        case 'siswa':
            return redirect('/siswa/dashboard')->with('error', 'Akses ditolak untuk halaman tersebut');
        default:
            return redirect('/')->with('error', 'Akses ditolak');
    }
}
```

### 2. Perbaikan View Dashboard
**File:** `resources/views/guru/dashboard.blade.php` dan `resources/views/siswa/dashboard.blade.php`

- Mengubah route dari `manajemen.artikel.*` menjadi `guru.artikel.*` / `siswa.artikel.*`
- Menambahkan link moderasi untuk guru

### 3. Pembuatan View yang Hilang
Dibuat view baru:
- `resources/views/guru/artikel.blade.php` - Kelola artikel guru
- `resources/views/guru/edit-artikel.blade.php` - Edit artikel guru
- `resources/views/guru/moderasi.blade.php` - Moderasi artikel siswa
- `resources/views/siswa/artikel.blade.php` - Kelola artikel siswa
- `resources/views/siswa/edit-artikel.blade.php` - Edit artikel siswa

### 4. Reset Password User
```bash
php artisan tinker --execute="
use Illuminate\Support\Facades\Hash; 
App\Models\User::where('username', 'guru')->update(['password' => Hash::make('guru123')]); 
App\Models\User::where('username', 'siswa')->update(['password' => Hash::make('siswa123')]);
"
```

## Kredensial Login

| Role   | Username | Password |
|--------|----------|----------|
| Admin  | admin    | admin123 |
| Guru   | guru     | guru123  |
| Siswa  | siswa    | siswa123 |

## Struktur Route

### Admin Routes (Prefix: /admin)
- `/admin/dashboard` - Dashboard admin
- `/admin/kategori` - Kelola kategori
- `/admin/artikel` - Kelola semua artikel
- `/admin/users` - Kelola user
- `/admin/laporan` - Laporan sistem

### Guru Routes (Prefix: /guru)
- `/guru/dashboard` - Dashboard guru
- `/guru/artikel` - Kelola artikel guru
- `/guru/artikel/create` - Buat artikel baru
- `/guru/artikel/{id}/edit` - Edit artikel
- `/guru/moderasi` - Moderasi artikel siswa
- `/guru/komentar` - Lihat komentar

### Siswa Routes (Prefix: /siswa)
- `/siswa/dashboard` - Dashboard siswa
- `/siswa/artikel` - Kelola artikel siswa
- `/siswa/artikel/create` - Buat artikel baru
- `/siswa/artikel/{id}/edit` - Edit artikel (hanya draft)

## Fitur Khusus

### Guru
- Dapat membuat artikel dan langsung publish
- Dapat memoderasi artikel siswa (approve/reject)
- Dapat melihat semua komentar pada artikelnya

### Siswa
- Artikel yang dibuat berstatus 'draft' dan perlu persetujuan guru
- Hanya dapat mengedit artikel yang masih berstatus 'draft'
- Mendapat notifikasi ketika artikel disetujui/ditolak

## Testing
Jalankan script test untuk memverifikasi sistem:
```bash
php test_login_roles.php
```

## Status
✅ **SELESAI** - Semua role sekarang dapat login dan mengakses halaman masing-masing dengan benar.