@echo off
echo Setting up database...

echo Running migrations...
php artisan migrate:fresh

echo Running seeders...
php artisan db:seed

echo Database setup complete!
pause