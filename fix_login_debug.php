<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Test data yang diinput
$inputUsername = 'admin';
$inputPassword = 'admin123';
$inputRole = 'admin';

echo "=== DEBUG LOGIN ===\n";
echo "Input Username: $inputUsername\n";
echo "Input Password: $inputPassword\n";
echo "Input Role: $inputRole\n\n";

// Cari user berdasarkan username saja dulu
$userByUsername = User::where('username', $inputUsername)->first();
if ($userByUsername) {
    echo "User ditemukan berdasarkan username:\n";
    echo "ID: " . $userByUsername->id_user . "\n";
    echo "Username: " . $userByUsername->username . "\n";
    echo "Role: " . $userByUsername->role . "\n";
    echo "Nama: " . $userByUsername->nama . "\n";
    
    // Cek password
    echo "\nTesting password...\n";
    if (Hash::check($inputPassword, $userByUsername->password)) {
        echo "✓ Password BENAR\n";
    } else {
        echo "✗ Password SALAH\n";
        
        // Reset password untuk testing
        echo "Mereset password ke 'admin123'...\n";
        $userByUsername->password = Hash::make('admin123');
        $userByUsername->save();
        echo "Password berhasil direset\n";
        
        // Test lagi
        if (Hash::check($inputPassword, $userByUsername->password)) {
            echo "✓ Password sekarang BENAR\n";
        } else {
            echo "✗ Password masih SALAH\n";
        }
    }
    
    // Cek role
    echo "\nTesting role...\n";
    if ($userByUsername->role === $inputRole) {
        echo "✓ Role COCOK\n";
    } else {
        echo "✗ Role TIDAK COCOK (Expected: $inputRole, Got: " . $userByUsername->role . ")\n";
    }
} else {
    echo "✗ User tidak ditemukan dengan username: $inputUsername\n";
}

// Test query yang sama dengan AuthController
echo "\n=== TEST QUERY AUTHCONTROLLER ===\n";
$user = User::where('username', $inputUsername)
           ->where('role', $inputRole)
           ->first();

if ($user) {
    echo "✓ User ditemukan dengan query AuthController\n";
    echo "ID: " . $user->id_user . "\n";
    echo "Username: " . $user->username . "\n";
    echo "Role: " . $user->role . "\n";
    
    if (Hash::check($inputPassword, $user->password)) {
        echo "✓ Password BENAR dengan query AuthController\n";
        echo "LOGIN SEHARUSNYA BERHASIL!\n";
    } else {
        echo "✗ Password SALAH dengan query AuthController\n";
    }
} else {
    echo "✗ User tidak ditemukan dengan query AuthController\n";
}