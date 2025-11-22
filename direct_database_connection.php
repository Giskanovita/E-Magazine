<?php

// Koneksi langsung ke database MySQL
$host = '127.0.0.1';
$port = '3306';
$database = 'e-mading';
$username = 'root';
$password = '';

try {
    // Membuat koneksi PDO
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Koneksi database berhasil!\n";
    
    // Contoh query untuk mengecek tabel yang ada
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "\n📋 Tabel yang tersedia:\n";
    foreach ($tables as $table) {
        echo "- $table\n";
    }
    
    // Contoh insert data langsung (sesuaikan dengan kebutuhan)
    // $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    // $stmt->execute(['Admin', 'admin@example.com', password_hash('password', PASSWORD_DEFAULT)]);
    
} catch (PDOException $e) {
    echo "❌ Error koneksi database: " . $e->getMessage() . "\n";
}