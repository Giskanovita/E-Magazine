@echo off
echo Setting up Dashboard Database...

echo Running migrations...
php artisan migrate --path=database/migrations/2025_11_13_134201_create_komentar_table.php

echo Seeding komentar data...
php artisan db:seed --class=KomentarSeeder

echo Dashboard setup complete!
echo You can now access the dashboard at: http://localhost:8000/dashboard
pause