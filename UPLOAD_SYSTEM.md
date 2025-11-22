# Sistem Upload Gambar/Dokumen - Magazine

## Fitur Upload
- **Foto Artikel**: Upload 1 foto utama (max 2MB)
- **Lampiran Multiple**: Upload multiple file (max 5MB per file)
- **File Types**: Semua jenis file (gambar, PDF, Word, dll)
- **Storage**: File disimpan di `storage/app/public/`

## Database Changes
- **Kolom Baru**: `lampiran` (JSON) di tabel artikel
- **Data Structure**: Array berisi nama, path, size, type file

## Upload Features
- **Multiple Files**: Bisa upload beberapa file sekaligus
- **File Info**: Menyimpan nama asli, ukuran, dan tipe file
- **Auto Delete**: File terhapus otomatis saat artikel dihapus/diupdate
- **Preview**: Tampilan preview file di form edit

## Display Features
- **Card Indicator**: Icon paperclip + jumlah lampiran di card artikel
- **Detail View**: Tampilan lampiran dengan icon sesuai tipe file
- **Download Link**: Link download langsung ke file
- **File Icons**: Icon berbeda untuk image, PDF, Word, dll

## File Structure
```
storage/app/public/
├── artikel/          # Foto utama artikel
└── lampiran/         # File lampiran
```

## Validation
- **Foto**: Image only, max 2MB
- **Lampiran**: All files, max 5MB per file
- **Multiple**: Tidak ada limit jumlah file

## Security
- File disimpan dengan nama random
- Akses file melalui storage link
- Validasi tipe dan ukuran file

## UI/UX
- **Upload Form**: Input multiple file dengan progress
- **File List**: Daftar file dengan info lengkap
- **Icons**: Icon sesuai tipe file (image, PDF, Word)
- **Download**: Link download dengan target blank

## Migration Applied
```sql
ALTER TABLE artikel ADD COLUMN lampiran JSON NULL AFTER foto;
```

## Usage
1. **Create**: Upload foto + lampiran di form create
2. **Edit**: Lihat lampiran lama + upload baru
3. **View**: Lihat artikel dengan lampiran
4. **Download**: Klik file untuk download

Sistem upload sekarang mendukung foto dan multiple lampiran dengan tampilan yang user-friendly!