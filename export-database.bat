@echo off
REM Database Export Script
REM This script exports a clean database with structure and essential seeded data

echo ==========================================
echo Database Export Script
echo ==========================================
echo.

REM Get database credentials from .env file
for /f "tokens=2 delims==" %%a in ('findstr /r "^DB_DATABASE=" .env') do set DB_NAME=%%a
for /f "tokens=2 delims==" %%a in ('findstr /r "^DB_USERNAME=" .env') do set DB_USER=%%a
for /f "tokens=2 delims==" %%a in ('findstr /r "^DB_PASSWORD=" .env') do set DB_PASS=%%a
for /f "tokens=2 delims==" %%a in ('findstr /r "^DB_HOST=" .env') do set DB_HOST=%%a

if "%DB_NAME%"=="" set DB_NAME=graduation_project_clacet2
if "%DB_USER%"=="" set DB_USER=root
if "%DB_HOST%"=="" set DB_HOST=127.0.0.1

echo Database: %DB_NAME%
echo User: %DB_USER%
echo Host: %DB_HOST%
echo.

REM Check if mysqldump is available
where mysqldump >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo Error: mysqldump is not found in PATH
    echo Please ensure MySQL is installed and mysqldump is in your PATH
    pause
    exit /b 1
)

echo Exporting database...
echo.

REM Export database structure and data
if "%DB_PASS%"=="" (
    mysqldump -h %DB_HOST% -u %DB_USER% --single-transaction --routines --triggers --databases %DB_NAME% > database.sql
) else (
    mysqldump -h %DB_HOST% -u %DB_USER% -p%DB_PASS% --single-transaction --routines --triggers --databases %DB_NAME% > database.sql
)

if %ERRORLEVEL% NEQ 0 (
    echo Failed to export database
    pause
    exit /b 1
)

echo.
echo ==========================================
echo Database exported successfully!
echo ==========================================
echo.
echo File: database.sql
echo Size: 
dir database.sql | findstr database.sql
echo.
echo This file contains:
echo - Complete database structure (all tables)
echo - Essential seeded data (users, deans, departments, etc.)
echo - Ready for import on any MySQL server
echo.
pause
