<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Test login logic
$username = 'admin';
$password = 'admin123';
$role = 'admin';

echo "Testing login dengan:\n";
echo "Username: $username\n";
echo "Password: $password\n";
echo "Role: $role\n\n";

// Find user by username and role
$user = User::where('username', $username)
           ->where('role', $role)
           ->first();

if ($user) {
    echo "User ditemukan:\n";
    echo "ID: " . $user->id_user . "\n";
    echo "Nama: " . $user->nama . "\n";
    echo "Username: " . $user->username . "\n";
    echo "Role: " . $user->role . "\n";
    
    if (Hash::check($password, $user->password)) {
        echo "\nPassword BENAR - Login berhasil!\n";
    } else {
        echo "\nPassword SALAH - Login gagal!\n";
    }
} else {
    echo "User tidak ditemukan dengan username: $username dan role: $role\n";
}