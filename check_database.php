<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Checking Database Structure ===\n";

// Check users table structure
echo "\n1. Users table structure:\n";
try {
    $columns = DB::select('DESCRIBE users');
    foreach ($columns as $column) {
        echo "- {$column->Field} ({$column->Type}) - Key: {$column->Key}\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Check artikel table structure
echo "\n2. Artikel table structure:\n";
try {
    $columns = DB::select('DESCRIBE artikel');
    foreach ($columns as $column) {
        echo "- {$column->Field} ({$column->Type}) - Key: {$column->Key}\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Check sample data
echo "\n3. Sample users data:\n";
try {
    $users = DB::select('SELECT * FROM users LIMIT 3');
    foreach ($users as $user) {
        echo "- ID: " . (isset($user->id) ? $user->id : 'N/A') . 
             ", ID_USER: " . (isset($user->id_user) ? $user->id_user : 'N/A') . 
             ", Username: " . (isset($user->username) ? $user->username : 'N/A') . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>