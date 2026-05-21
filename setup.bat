@echo off
REM College Management System - Setup Script (Windows)
REM This script automates the complete project setup

echo ==========================================
echo College Management System - Setup
echo ==========================================
echo.

REM Check if composer is installed
where composer >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo Error: Composer is not installed. Please install Composer first.
    echo Visit: https://getcomposer.org/download/
    pause
    exit /b 1
)

REM Check if npm is installed
where npm >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo Error: npm is not installed. Please install Node.js and npm first.
    echo Visit: https://nodejs.org/
    pause
    exit /b 1
)

REM Check if php is installed
where php >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo Error: PHP is not installed. Please install PHP 8.3 or higher.
    pause
    exit /b 1
)

echo All required tools are installed
echo.

REM Step 1: Install PHP dependencies
echo Step 1/7: Installing PHP dependencies...
call composer install --optimize-autoloader --no-interaction
if %ERRORLEVEL% NEQ 0 (
    echo Failed to install PHP dependencies
    pause
    exit /b 1
)
echo PHP dependencies installed
echo.

REM Step 2: Create environment file
echo Step 2/7: Creating environment file...
if exist .env (
    echo .env file already exists. Skipping...
) else (
    copy .env.example .env
    echo Environment file created
)
echo.

REM Step 3: Generate application key
echo Step 3/7: Generating application key...
php artisan key:generate --ansi --no-interaction
if %ERRORLEVEL% NEQ 0 (
    echo Failed to generate application key
    pause
    exit /b 1
)
echo Application key generated
echo.

REM Step 4: Create database file (for SQLite)
echo Step 4/7: Setting up database...
if not exist database\database.sqlite (
    type nul > database\database.sqlite
    echo SQLite database file created
) else (
    echo Database file already exists
)
echo.

REM Step 5: Run migrations and seeders
echo Step 5/7: Running migrations and seeders...
php artisan migrate --seed --force --no-interaction
if %ERRORLEVEL% NEQ 0 (
    echo Failed to run migrations and seeders
    pause
    exit /b 1
)
echo Database migrated and seeded
echo.

REM Step 6: Create storage symlink
echo Step 6/7: Creating storage symlink...
php artisan storage:link --no-interaction
if %ERRORLEVEL% NEQ 0 (
    echo Storage link may already exist or failed to create
)
echo Storage linked
echo.

REM Step 7: Install Node dependencies and build assets
echo Step 7/7: Installing Node dependencies and building assets...
call npm install --silent
if %ERRORLEVEL% NEQ 0 (
    echo Failed to install Node dependencies
    pause
    exit /b 1
)

call npm run build
if %ERRORLEVEL% NEQ 0 (
    echo Failed to build assets
    pause
    exit /b 1
)
echo Assets compiled
echo.

echo ==========================================
echo Setup Complete!
echo ==========================================
echo.
echo To start the development server, run:
echo    php artisan serve
echo.
echo Default admin credentials:
echo    Email: admin@example.com
echo    Password: password
echo.
echo IMPORTANT: Change the admin password after first login!
echo.
echo The application will be available at:
echo    http://127.0.0.1:8000
echo.
echo ==========================================
pause
