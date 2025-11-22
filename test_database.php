<?php
// Test database connection
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=e-mading', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Database connection successful!\n";
    
    // Test tables
    $tables = ['users', 'kategori', 'artikel', 'likes', 'notifications'];
    
    foreach ($tables as $table) {
        $stmt = $pdo->query("SELECT COUNT(*) FROM $table");
        $count = $stmt->fetchColumn();
        echo "✅ Table '$table': $count records\n";
    }
    
    // Test login users
    $stmt = $pdo->query("SELECT username, nama, role FROM users");
    echo "\n📋 Login accounts:\n";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "- {$row['username']} ({$row['nama']}) - Role: {$row['role']}\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
    echo "\n🔧 Please:\n";
    echo "1. Make sure MySQL is running\n";
    echo "2. Create database 'e-mading'\n";
    echo "3. Import database_complete.sql\n";
}
?>