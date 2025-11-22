<?php

class DatabaseManager 
{
    private $pdo;
    
    public function __construct() 
    {
        $host = '127.0.0.1';
        $port = '3306';
        $database = 'e-mading';
        $username = 'root';
        $password = '';
        
        try {
            $this->pdo = new PDO("mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "✅ Koneksi database berhasil!\n";
        } catch (PDOException $e) {
            die("❌ Error: " . $e->getMessage() . "\n");
        }
    }
    
    public function insertUser($name, $email, $password, $role = 'siswa') 
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password, role, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
        return $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT), $role]);
    }
    
    public function insertKategori($nama, $deskripsi = null) 
    {
        $stmt = $this->pdo->prepare("INSERT INTO kategori (nama, deskripsi, created_at, updated_at) VALUES (?, ?, NOW(), NOW())");
        return $stmt->execute([$nama, $deskripsi]);
    }
    
    public function insertArtikel($judul, $konten, $kategori_id, $user_id) 
    {
        $stmt = $this->pdo->prepare("INSERT INTO artikel (judul, konten, kategori_id, user_id, status, created_at, updated_at) VALUES (?, ?, ?, ?, 'published', NOW(), NOW())");
        return $stmt->execute([$judul, $konten, $kategori_id, $user_id]);
    }
    
    public function getAllUsers() 
    {
        $stmt = $this->pdo->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAllKategori() 
    {
        $stmt = $this->pdo->query("SELECT * FROM kategori");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Contoh penggunaan
$db = new DatabaseManager();

// Tambah data contoh
echo "\n📝 Menambah data contoh...\n";

// Tambah user admin
$db->insertUser('Administrator', 'admin@magazine.com', 'admin123', 'admin');
echo "✅ User admin ditambahkan\n";

// Tambah kategori
$db->insertKategori('Teknologi', 'Artikel tentang teknologi terkini');
$db->insertKategori('Pendidikan', 'Artikel seputar dunia pendidikan');
echo "✅ Kategori ditambahkan\n";

// Tampilkan data
echo "\n👥 Daftar Users:\n";
foreach ($db->getAllUsers() as $user) {
    echo "- {$user['name']} ({$user['email']}) - Role: {$user['role']}\n";
}

echo "\n📂 Daftar Kategori:\n";
foreach ($db->getAllKategori() as $kategori) {
    echo "- {$kategori['nama']}: {$kategori['deskripsi']}\n";
}