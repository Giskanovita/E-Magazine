<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== Testing Login Redirect ===\n\n";

// Test each user
$users = ['admin', 'guru', 'siswa'];

foreach ($users as $username) {
    $user = User::where('username', $username)->first();
    if ($user) {
        echo "User: {$username}\n";
        echo "Role: {$user->role}\n";
        echo "Password check: " . (Hash::check('password', $user->password) ? 'PASS' : 'FAIL') . "\n";
        
        // Expected redirect
        if ($user->role === 'guru') {
            echo "Expected redirect: /guru/dashboard\n";
        } elseif ($user->role === 'siswa') {
            echo "Expected redirect: /siswa/dashboard\n";
        } else {
            echo "Expected redirect: /dashboard\n";
        }
        echo "---\n";
    }
}
?>