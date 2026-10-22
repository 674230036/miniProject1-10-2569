@echo off
title iRepair NPRU - Server
cd /d "%~dp0"
echo ========================================================
echo   iRepair NPRU - iPhone Repair Service Management System
echo ========================================================
echo   Starting server at http://127.0.0.1:8000 ...
echo   Front-end (User): http://127.0.0.1:8000
echo   Back-end (Admin): http://127.0.0.1:8000/login
echo ========================================================
start http://127.0.0.1:8000
"C:\xampp\php82\php.exe" artisan serve --host=127.0.0.1 --port=8000
pause
