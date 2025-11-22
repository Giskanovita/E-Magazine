# Manajemen Artikel/Mading - CRUD System

## Fitur Lengkap
- **Create**: Form buat artikel baru dengan semua field
- **Read**: Daftar artikel user dengan pagination
- **Update**: Edit artikel dengan preview foto
- **Delete**: Hapus artikel dengan konfirmasi
- **Upload Foto**: Sistem upload dan storage foto artikel

## Field Artikel
- **Judul**: Teks maksimal 255 karakter
- **Isi**: Textarea untuk konten artikel
- **Kategori**: Dropdown dari tabel kategori
- **Tanggal**: Date picker
- **Foto**: Upload gambar (max 2MB)
- **Penulis**: Otomatis dari user login
- **Status**: Draft/Publikasi

## Routes
```php
// Manajemen Artikel CRUD
Route::middleware('auth')->prefix('manajemen')->name('manajemen.')->group(function () {
    Route::resource('artikel', ManajemenArtikelController::class);
});
```

## URL Access
- **Index**: `/manajemen/artikel` - Daftar artikel user
- **Create**: `/manajemen/artikel/create` - Form buat artikel
- **Edit**: `/manajemen/artikel/{id}/edit` - Form edit artikel
- **Delete**: POST `/manajemen/artikel/{id}` - Hapus artikel

## Security
- User hanya bisa CRUD artikel miliknya sendiri
- Validasi form lengkap
- File upload validation (image, max 2MB)
- CSRF protection

## Navigation
- Link "Kelola Artikel" di navbar untuk user login
- Tombol "Kelola Artikel" di dashboard
- Breadcrumb navigation di semua halaman

## Files Created
- `ManajemenArtikelController.php` - CRUD logic
- `manajemen/artikel/index.blade.php` - Daftar artikel
- `manajemen/artikel/create.blade.php` - Form create
- `manajemen/artikel/edit.blade.php` - Form edit

## Storage
- Foto artikel disimpan di `storage/app/public/artikel/`
- Symbolic link ke `public/storage` untuk akses foto
- Auto delete foto lama saat update/delete

## Features
- Pagination untuk daftar artikel
- Preview foto di form edit
- Status badge (Draft/Publikasi)
- Responsive table design
- Success/error messages
- Confirmation dialog untuk delete