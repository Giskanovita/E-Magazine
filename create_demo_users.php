<?php
// Script untuk membuat user demo dengan password yang benar

require_once 'vendor/autoload.php';

// Load Laravel app
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Hapus user lama dengan aman
User::query()->delete();

// Buat user demo
$users = [
    [
        'nama' => 'Administrator',
        'username' => 'admin',
        'password' => Hash::make('password'),
        'role' => 'admin'
    ],
    [
        'nama' => 'Guru Demo',
        'username' => 'guru', 
        'password' => Hash::make('password'),
        'role' => 'guru'
    ],
    [
        'nama' => 'Siswa Demo',
        'username' => 'siswa',
        'password' => Hash::make('password'),
        'role' => 'siswa'
    ]
];

foreach ($users as $userData) {
    User::create($userData);
    echo "User {$userData['username']} berhasil dibuat\n";
}

echo "Semua user demo berhasil dibuat!\n";
echo "Login dengan:\n";
echo "- admin / password\n";
echo "- guru / password\n";
echo "- siswa / password\n";
?>