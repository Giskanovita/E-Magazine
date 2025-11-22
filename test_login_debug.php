<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== Testing Login System ===\n\n";

// Test users
$users = User::all();
echo "Users in database:\n";
foreach ($users as $user) {
    echo "- ID: {$user->id_user}, Username: {$user->username}, Role: {$user->role}\n";
}

echo "\n=== Testing Password Hash ===\n";
$testPassword = 'password';
$testUser = User::where('username', 'admin')->first();

if ($testUser) {
    echo "Admin user found\n";
    echo "Stored hash: " . substr($testUser->password, 0, 20) . "...\n";
    echo "Password check: " . (Hash::check($testPassword, $testUser->password) ? 'PASS' : 'FAIL') . "\n";
    
    // Test creating new hash
    $newHash = Hash::make($testPassword);
    echo "New hash works: " . (Hash::check($testPassword, $newHash) ? 'PASS' : 'FAIL') . "\n";
} else {
    echo "Admin user not found!\n";
}
?>