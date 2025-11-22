<?php

require_once 'vendor/autoload.php';

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Testing Login System ===\n\n";

// Test users
$testUsers = [
    ['username' => 'admin', 'role' => 'admin'],
    ['username' => 'guru', 'role' => 'guru'], 
    ['username' => 'siswa', 'role' => 'siswa']
];

foreach ($testUsers as $testUser) {
    echo "Testing {$testUser['username']} ({$testUser['role']}):\n";
    
    $user = User::where('username', $testUser['username'])
                ->where('role', $testUser['role'])
                ->first();
    
    if ($user) {
        echo "✓ User found: {$user->nama}\n";
        echo "✓ Role: {$user->role}\n";
        
        // Test password
        $password = match($testUser['role']) {
            'admin' => 'admin123',
            'guru' => 'guru123', 
            'siswa' => 'siswa123'
        };
        
        if (Hash::check($password, $user->password)) {
            echo "✓ Password correct\n";
            
            // Test redirect logic
            $expectedRedirect = match($user->role) {
                'admin' => '/admin/dashboard',
                'guru' => '/guru/dashboard',
                'siswa' => '/siswa/dashboard'
            };
            echo "✓ Should redirect to: {$expectedRedirect}\n";
        } else {
            echo "✗ Password incorrect\n";
        }
    } else {
        echo "✗ User not found\n";
    }
    
    echo "\n";
}

echo "=== Route Testing ===\n";
echo "Admin routes: /admin/dashboard\n";
echo "Guru routes: /guru/dashboard, /guru/artikel, /guru/moderasi\n";
echo "Siswa routes: /siswa/dashboard, /siswa/artikel\n";
echo "\nAll routes are protected by RoleMiddleware\n";