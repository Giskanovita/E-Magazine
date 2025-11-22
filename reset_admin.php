<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Cek user admin
$admin = User::where('username', 'admin')->first();

if ($admin) {
    echo "User admin ditemukan:\n";
    echo "ID: " . $admin->id_user . "\n";
    echo "Nama: " . $admin->nama . "\n";
    echo "Username: " . $admin->username . "\n";
    echo "Role: " . $admin->role . "\n";
    
    // Reset password
    $admin->password = Hash::make('admin123');
    $admin->save();
    
    echo "\nPassword berhasil direset ke: admin123\n";
    
    // Test password
    if (Hash::check('admin123', $admin->password)) {
        echo "Password verification: OK\n";
    } else {
        echo "Password verification: FAILED\n";
    }
} else {
    echo "User admin tidak ditemukan. Membuat user admin baru...\n";
    
    User::create([
        'nama' => 'Admin Sekolah',
        'username' => 'admin',
        'password' => Hash::make('admin123'),
        'role' => 'admin'
    ]);
    
    echo "User admin berhasil dibuat dengan password: admin123\n";
}