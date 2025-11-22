@echo off
echo ========================================
echo    KONEKSI LANGSUNG KE DATABASE
echo ========================================
echo.

echo Menjalankan koneksi database...
php direct_database_connection.php

echo.
echo ========================================
echo    MENGELOLA DATA DATABASE
echo ========================================
echo.

echo Menjalankan database manager...
php manage_database.php

echo.
echo Selesai! Tekan tombol apa saja untuk keluar...
pause > nul