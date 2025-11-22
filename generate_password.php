<?php
// Generate correct password hash for Laravel
$password = 'password';
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "Password: $password\n";
echo "Hash: $hash\n\n";

// Test verification
if (password_verify($password, $hash)) {
    echo "✅ Password verification successful!\n";
} else {
    echo "❌ Password verification failed!\n";
}

// Generate SQL update
echo "\n📋 SQL Update Commands:\n";
echo "UPDATE users SET password = '$hash' WHERE username = 'admin';\n";
echo "UPDATE users SET password = '$hash' WHERE username = 'guru';\n";
echo "UPDATE users SET password = '$hash' WHERE username = 'siswa';\n";
?>