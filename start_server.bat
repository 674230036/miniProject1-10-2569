@echo off
title iRepair NPRU - Server
cd /d "%~dp0"

REM Check for .env file
if not exist ".env" (
    if exist ".env.example" (
        echo [.env not found, auto-copying from .env.example...]
        copy .env.example .env >nul
    )
)

REM Auto-detect PHP binary
set PHP_BIN=php
if exist "C:\xampp\php82\php.exe" (
    set PHP_BIN="C:\xampp\php82\php.exe"
) else if exist "C:\xampp\php\php.exe" (
    set PHP_BIN="C:\xampp\php\php.exe"
)

echo ========================================================
echo   iRepair NPRU - iPhone Repair Service Management System
echo ========================================================
echo   Starting server at http://127.0.0.1:8000 ...
echo   Front-end (User): http://127.0.0.1:8000
echo   Back-end (Admin): http://127.0.0.1:8000/login
echo ========================================================
start http://127.0.0.1:8000
%PHP_BIN% artisan serve --host=127.0.0.1 --port=8000
pause

