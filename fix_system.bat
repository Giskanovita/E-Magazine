@echo off
echo Memperbaiki sistem login dan database...

echo 1. Membuat user demo...
php create_demo_users.php

echo 2. Menjalankan migration komentar...
php artisan migrate --path=database/migrations/2025_11_13_134201_create_komentar_table.php

echo 3. Seeding data komentar...
php artisan db:seed --class=KomentarSeeder

echo 4. Membuat storage link...
php artisan storage:link

echo 5. Clear cache...
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo Sistem berhasil diperbaiki!
echo.
echo Login dengan:
echo - Username: admin, Password: password
echo - Username: guru, Password: password  
echo - Username: siswa, Password: password
echo.
echo Akses aplikasi di: http://localhost:8000
pause