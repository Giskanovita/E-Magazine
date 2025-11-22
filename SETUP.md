# Setup E-Magazine Laravel

## Langkah-langkah Setup:

1. **Install Dependencies**
   ```bash
   composer install
   ```

2. **Setup Environment**
   - Copy `.env.example` ke `.env`
   - Sesuaikan konfigurasi database di `.env`:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=e-mading
     DB_USERNAME=root
     DB_PASSWORD=
     ```

3. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

4. **Setup Database**
   - Buat database `e-mading` di MySQL
   - Jalankan migrations dan seeders:
     ```bash
     php artisan migrate:fresh --seed
     ```
   - Atau jalankan file `setup_database.bat`

5. **Jalankan Server**
   ```bash
   php artisan serve
   ```

## Akun Login Default:

- **Admin**: username: `admin`, password: `password`
- **Guru**: username: `guru`, password: `password`  
- **Siswa**: username: `siswa`, password: `password`

## Fitur yang Sudah Terintegrasi:

✅ **Home Page**: Menampilkan artikel terbaru dan kategori dari database
✅ **Artikel Page**: Menampilkan semua artikel dengan pagination
✅ **Kategori Page**: Menampilkan kategori dan artikel per kategori
✅ **Like Page**: Menampilkan artikel yang disukai user (perlu login)
✅ **Single Article**: Halaman detail artikel dengan fitur like
✅ **Footer Copyright**: Menampilkan tahun dinamis

## Database Structure:

- `users` - Data pengguna (admin, guru, siswa)
- `kategori` - Kategori artikel
- `artikel` - Data artikel dengan relasi ke user dan kategori
- `likes` - Data like artikel oleh user

Semua halaman sudah terhubung ke database dan menampilkan data dinamis!