# Dashboard Guru & Siswa - Magazine System

## Fitur Dashboard Role-Based
- **Dashboard Guru**: Khusus untuk role guru
- **Dashboard Siswa**: Khusus untuk role siswa  
- **Template Konsisten**: Menggunakan design yang sama dengan dashboard umum
- **Auto Redirect**: Login otomatis redirect ke dashboard sesuai role

## Dashboard Features
### Statistik Cards
- **Total Artikel**: Jumlah artikel yang dibuat user
- **Draft**: Artikel dengan status draft
- **Dipublikasi**: Artikel yang sudah publish
- **Komentar**: Total komentar pada artikel user

### Artikel Terbaru
- **Table View**: Daftar 5 artikel terbaru
- **Quick Edit**: Link langsung ke edit artikel
- **Status Badge**: Visual indicator draft/publish

### Menu Sidebar
- **Buat Artikel**: Link ke form create artikel
- **Kelola Artikel**: Link ke manajemen CRUD
- **Lihat Artikel**: Link ke halaman public artikel
- **Artikel Favorit**: Link ke halaman like

## Role-Based Navigation
```php
// Navbar dinamis berdasarkan role
@if(Auth::user()->role == 'guru')
    Dashboard Guru
@elseif(Auth::user()->role == 'siswa') 
    Dashboard Siswa
@else
    Dashboard (admin/default)
@endif
```

## Auto Redirect System
```php
// AuthController redirect logic
if ($user->role === 'guru') {
    return redirect()->route('guru.dashboard');
} elseif ($user->role === 'siswa') {
    return redirect()->route('siswa.dashboard');
} else {
    return redirect()->route('dashboard');
}
```

## Routes Structure
- **Guru**: `/guru/dashboard` → `guru.dashboard`
- **Siswa**: `/siswa/dashboard` → `siswa.dashboard`
- **Default**: `/dashboard` → `dashboard`

## Files Created/Updated
### New Files:
- `resources/views/guru/dashboard.blade.php`
- `resources/views/siswa/dashboard.blade.php`

### Updated Files:
- `GuruController.php` - Dashboard method dengan statistik
- `SiswaController.php` - Dashboard method dengan statistik  
- `AuthController.php` - Role-based redirect
- `navbar.blade.php` - Dynamic dashboard links

## User Experience
### Guru Dashboard
- **Welcome Message**: "Selamat Datang, [Nama Guru]"
- **Tips Section**: Tips khusus untuk guru
- **Full Access**: Bisa langsung publish artikel

### Siswa Dashboard  
- **Welcome Message**: "Selamat Datang, [Nama Siswa]"
- **Tips Section**: Tips khusus untuk siswa
- **Draft Mode**: Artikel siswa default draft (perlu approval)

## Design Consistency
- **Same Layout**: Menggunakan template main.blade.php
- **Same Components**: Card statistik, table, sidebar menu
- **Same Colors**: Primary, warning, success, info untuk cards
- **Same Icons**: Bootstrap icons konsisten

## Testing
1. **Login sebagai guru** → Redirect ke Dashboard Guru
2. **Login sebagai siswa** → Redirect ke Dashboard Siswa
3. **Check statistik** → Menampilkan data sesuai user
4. **Test navigation** → Link dashboard sesuai role
5. **Test CRUD** → Akses manajemen artikel

Dashboard sekarang role-aware dengan template yang konsisten!