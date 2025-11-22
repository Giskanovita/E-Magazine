# Dashboard E-Magazine - 3 Aktor

## Fitur Dashboard yang Sudah Dibuat:

### 🔴 **ADMIN Dashboard**
- **Akses**: `/admin/dashboard`
- **Fitur**:
  - Statistik lengkap (total artikel, kategori, user, artikel pending)
  - Kelola semua artikel dari guru dan siswa
  - Approve/Reject artikel dari siswa
  - Notifikasi artikel baru dari siswa
  - Lihat artikel terbaru dari semua user

### 🟡 **GURU Dashboard** 
- **Akses**: `/guru/dashboard`
- **Fitur**:
  - Statistik artikel pribadi dan keseluruhan
  - Buat artikel baru (langsung publikasi)
  - Lihat artikel yang sudah dibuat
  - Notifikasi artikel baru dari siswa
  - Form upload artikel dengan foto

### 🔵 **SISWA Dashboard**
- **Akses**: `/siswa/dashboard`
- **Fitur**:
  - Statistik artikel pribadi (total, pending, published)
  - Kirim artikel untuk review
  - Lihat status artikel (menunggu persetujuan/dipublikasikan)
  - Form upload artikel dengan foto
  - Notifikasi otomatis ke admin & guru saat kirim artikel

## Alur Kerja Sistem:

1. **Siswa** kirim artikel → Status: `draft`
2. **Notifikasi** otomatis ke Admin & Guru
3. **Admin** review artikel → Approve/Reject
4. Jika approve → Status: `publikasi` → Muncul di website
5. **Guru** bisa langsung publikasi artikel

## Database Baru:

### Table `notifications`
```sql
- id (primary key)
- id_user (foreign key ke users)
- title (judul notifikasi)
- message (isi notifikasi)  
- type (info/warning/success)
- is_read (boolean)
- timestamps
```

## Routes Baru:

```php
// Admin Routes
/admin/dashboard - Dashboard admin
/admin/artikel - Kelola artikel
/admin/artikel/{id}/approve - Setujui artikel
/admin/artikel/{id}/reject - Tolak artikel

// Guru Routes  
/guru/dashboard - Dashboard guru
/guru/artikel/create - Form buat artikel
/guru/artikel - Submit artikel

// Siswa Routes
/siswa/dashboard - Dashboard siswa  
/siswa/artikel/create - Form kirim artikel
/siswa/artikel - Submit artikel
```

## Cara Testing:

1. Login sebagai **siswa** (`siswa/password`)
2. Kirim artikel baru
3. Login sebagai **admin** (`admin/password`) 
4. Lihat notifikasi & approve artikel
5. Cek artikel muncul di website publik

Sistem sudah lengkap dengan 3 aktor dan notifikasi!