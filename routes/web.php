<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ModerasiController;
use App\Http\Controllers\PdfController;
use App\Http\Middleware\RoleMiddleware;

// Public routes - dapat diakses tanpa login (untuk publik/pengunjung)
Route::get('/', [IndexController::class, 'index']);
Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/kategori/{id}', [KategoriController::class, 'show']);
Route::get('/artikel', [ArtikelController::class, 'index']);
Route::get('/artikel/{id}', [ArtikelController::class, 'show']);
Route::get('/artikel/{id}/pdf', [PdfController::class, 'downloadArtikel'])->name('artikel.pdf');

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

// Routes yang memerlukan login
Route::middleware('auth')->group(function () {
    // Like system - untuk semua user yang login
    Route::get('/like', [LikeController::class, 'index']);
    Route::post('/like/toggle', [LikeController::class, 'toggle']);
    
    // Dashboard redirect berdasarkan role
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    // Admin Sekolah routes
    Route::middleware([RoleMiddleware::class.':admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/kategori', [App\Http\Controllers\AdminController::class, 'kategoriIndex'])->name('kategori.index');
        Route::post('/kategori', [App\Http\Controllers\AdminController::class, 'kategoriStore'])->name('kategori.store');
        Route::put('/kategori/{id}', [App\Http\Controllers\AdminController::class, 'kategoriUpdate'])->name('kategori.update');
        Route::delete('/kategori/{id}', [App\Http\Controllers\AdminController::class, 'kategoriDestroy'])->name('kategori.destroy');
        Route::get('/artikel', [App\Http\Controllers\AdminController::class, 'artikelIndex'])->name('artikel.index');
        Route::post('/artikel/{id}/approve', [App\Http\Controllers\AdminController::class, 'artikelApprove'])->name('artikel.approve');
        Route::delete('/artikel/{id}/reject', [App\Http\Controllers\AdminController::class, 'artikelReject'])->name('artikel.reject');
        Route::get('/users', [App\Http\Controllers\AdminController::class, 'userIndex'])->name('users.index');
        Route::post('/users', [App\Http\Controllers\AdminController::class, 'userStore'])->name('users.store');
        Route::put('/users/{id}', [App\Http\Controllers\AdminController::class, 'userUpdate'])->name('users.update');
        Route::delete('/users/{id}', [App\Http\Controllers\AdminController::class, 'userDestroy'])->name('users.destroy');
        Route::post('/user/store', [App\Http\Controllers\ModerasiController::class, 'storeUser'])->name('user.store');
        Route::get('/laporan', [App\Http\Controllers\AdminController::class, 'laporan'])->name('laporan');
        Route::get('/laporan/pdf', [App\Http\Controllers\AdminController::class, 'laporanPdf'])->name('laporan.pdf');
    });
    
    // Guru/Pembina Mading routes
    Route::middleware([RoleMiddleware::class.':guru'])->prefix('guru')->name('guru.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\GuruController::class, 'dashboard'])->name('dashboard');
        Route::get('/artikel', [App\Http\Controllers\GuruController::class, 'artikelIndex'])->name('artikel.index');
        Route::get('/artikel/create', [App\Http\Controllers\GuruController::class, 'createArtikel'])->name('artikel.create');
        Route::post('/artikel', [App\Http\Controllers\GuruController::class, 'storeArtikel'])->name('artikel.store');
        Route::get('/artikel/{id}/edit', [App\Http\Controllers\GuruController::class, 'editArtikel'])->name('artikel.edit');
        Route::put('/artikel/{id}', [App\Http\Controllers\GuruController::class, 'updateArtikel'])->name('artikel.update');
        Route::get('/komentar', [App\Http\Controllers\GuruController::class, 'komentarIndex'])->name('komentar.index');
        Route::get('/moderasi', [App\Http\Controllers\GuruController::class, 'moderasiIndex'])->name('moderasi.index');
        Route::post('/moderasi/{id}/approve', [App\Http\Controllers\GuruController::class, 'moderasiApprove'])->name('moderasi.approve');
    });
    
    // Siswa routes
    Route::middleware([RoleMiddleware::class.':siswa'])->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\SiswaController::class, 'dashboard'])->name('dashboard');
        Route::get('/artikel', [App\Http\Controllers\SiswaController::class, 'artikelIndex'])->name('artikel.index');
        Route::get('/artikel/create', [App\Http\Controllers\SiswaController::class, 'createArtikel'])->name('artikel.create');
        Route::post('/artikel', [App\Http\Controllers\SiswaController::class, 'storeArtikel'])->name('artikel.store');
        Route::get('/artikel/{id}/edit', [App\Http\Controllers\SiswaController::class, 'editArtikel'])->name('artikel.edit');
        Route::put('/artikel/{id}', [App\Http\Controllers\SiswaController::class, 'updateArtikel'])->name('artikel.update');
    });
    
    // Komentar routes - untuk semua user yang login
    Route::post('/komentar', [App\Http\Controllers\KomentarController::class, 'store'])->name('komentar.store');
});

// Route moderasi publik (redirect ke login)
Route::get('/moderasi', function () {
    if (auth()->check()) {
        $role = auth()->user()->role;
        switch ($role) {
            case 'admin':
                return redirect()->route('admin.artikel.index');
            case 'guru':
                return redirect()->route('guru.moderasi.index');
            default:
                return redirect('/')->with('error', 'Akses ditolak');
        }
    }
    return redirect('/login');
})->name('moderasi.index');

Route::get('/contact', function () {
    return view('pages.contact');
});

// Route untuk refresh CSRF token
Route::get('/refresh-csrf', function () {
    return response()->json(['token' => csrf_token()]);
});
