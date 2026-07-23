@echo off
:: ====================================================
:: Script untuk menjalankan Laravel + Vite Dev Server
:: Sistem Inventarisasi Use Case AI - KPV1
:: ====================================================

echo Mengatur PATH ke PHP 8.4...
set "PATH=C:\xampp\php84;%PATH%"

echo Verifikasi versi PHP:
php --version

echo.
echo Menjalankan server Laravel dan Vite...
echo Laravel akan berjalan di: http://localhost:8000
echo Tekan Ctrl+C untuk menghentikan
echo.

:: Jalankan Vite di background lalu artisan serve
start "Vite Dev Server" cmd /k "npm run dev"
timeout /t 3 /nobreak >nul
php artisan serve
