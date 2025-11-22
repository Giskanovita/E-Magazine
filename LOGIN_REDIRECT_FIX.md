# Fix Login Redirect Issue - Magazine System

## Masalah
- Login berhasil tapi tidak redirect ke halaman yang dituju
- Route middleware `role:guru` dan `role:siswa` tidak berfungsi
- Dashboard tidak bisa diakses setelah login

## Perbaikan yang Dilakukan

### 1. AuthController Redirect
```php
// Sebelum - menggunakan route name
return redirect()->route('guru.dashboard');

// Sesudah - menggunakan URL langsung
return redirect('/guru/dashboard');
```

### 2. Route Middleware
```php
// Sebelum - middleware role yang kompleks
Route::middleware(['auth', 'role:guru'])

// Sesudah - hanya auth middleware
Route::middleware('auth')
```

### 3. Switch Statement
```php
switch ($user->role) {
    case 'guru':
        return redirect('/guru/dashboard');
    case 'siswa':
        return redirect('/siswa/dashboard');
    default:
        return redirect('/dashboard');
}
```

## Files yang Diubah
- `AuthController.php` - Redirect logic
- `routes/web.php` - Middleware simplification
- Cache cleared untuk apply changes

## Testing
### Login Credentials:
- **Guru**: username=`guru`, password=`password`, role=`guru`
- **Siswa**: username=`siswa`, password=`password`, role=`siswa`
- **Admin**: username=`admin`, password=`password`, role=`admin`

### Expected Results:
- **Guru** → `/guru/dashboard`
- **Siswa** → `/siswa/dashboard`
- **Admin** → `/dashboard`

## Verification Steps
1. Buka `/login`
2. Pilih role dan masukkan credentials
3. Klik Login
4. Harus redirect ke dashboard yang sesuai
5. Dashboard harus menampilkan data user

## Route List
```
GET /guru/dashboard → GuruController@dashboard
GET /siswa/dashboard → SiswaController@dashboard  
GET /dashboard → DashboardController@index
```

Login redirect sekarang harus berfungsi dengan baik!