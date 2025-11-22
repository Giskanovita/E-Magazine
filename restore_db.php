<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    // Drop artikel_new table
    DB::statement('DROP TABLE IF EXISTS artikel_new');
    echo "Dropped artikel_new table\n";
    
    // Remove orphaned tablespace files
    DB::statement('DROP TABLE IF EXISTS artikel');
    echo "Dropped artikel table\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}