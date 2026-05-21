#!/bin/bash

# College Management System - Setup Script (Linux/Mac)
# This script automates the complete project setup

echo "=========================================="
echo "College Management System - Setup"
echo "=========================================="
echo ""

# Check if composer is installed
if ! command -v composer &> /dev/null
then
    echo "❌ Error: Composer is not installed. Please install Composer first."
    echo "Visit: https://getcomposer.org/download/"
    exit 1
fi

# Check if npm is installed
if ! command -v npm &> /dev/null
then
    echo "❌ Error: npm is not installed. Please install Node.js and npm first."
    echo "Visit: https://nodejs.org/"
    exit 1
fi

# Check if php is installed
if ! command -v php &> /dev/null
then
    echo "❌ Error: PHP is not installed. Please install PHP 8.3 or higher."
    exit 1
fi

echo "✅ All required tools are installed"
echo ""

# Step 1: Install PHP dependencies
echo "📦 Step 1/7: Installing PHP dependencies..."
composer install --optimize-autoloader --no-interaction
if [ $? -ne 0 ]; then
    echo "❌ Failed to install PHP dependencies"
    exit 1
fi
echo "✅ PHP dependencies installed"
echo ""

# Step 2: Create environment file
echo "⚙️  Step 2/7: Creating environment file..."
if [ -f .env ]; then
    echo "⚠️  .env file already exists. Skipping..."
else
    cp .env.example .env
    echo "✅ Environment file created"
fi
echo ""

# Step 3: Generate application key
echo "🔑 Step 3/7: Generating application key..."
php artisan key:generate --ansi --no-interaction
if [ $? -ne 0 ]; then
    echo "❌ Failed to generate application key"
    exit 1
fi
echo "✅ Application key generated"
echo ""

# Step 4: Create database file (for SQLite)
echo "🗄️  Step 4/7: Setting up database..."
if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
    echo "✅ SQLite database file created"
else
    echo "⚠️  Database file already exists"
fi
echo ""

# Step 5: Run migrations and seeders
echo "🌱 Step 5/7: Running migrations and seeders..."
php artisan migrate --seed --force --no-interaction
if [ $? -ne 0 ]; then
    echo "❌ Failed to run migrations and seeders"
    exit 1
fi
echo "✅ Database migrated and seeded"
echo ""

# Step 6: Create storage symlink
echo "🔗 Step 6/7: Creating storage symlink..."
php artisan storage:link --no-interaction
if [ $? -ne 0 ]; then
    echo "⚠️  Storage link may already exist or failed to create"
fi
echo "✅ Storage linked"
echo ""

# Step 7: Install Node dependencies and build assets
echo "🎨 Step 7/7: Installing Node dependencies and building assets..."
npm install --silent
if [ $? -ne 0 ]; then
    echo "❌ Failed to install Node dependencies"
    exit 1
fi

npm run build
if [ $? -ne 0 ]; then
    echo "❌ Failed to build assets"
    exit 1
fi
echo "✅ Assets compiled"
echo ""

# Set proper permissions (Linux/Mac)
echo "🔒 Setting permissions..."
chmod -R 775 storage bootstrap/cache
echo "✅ Permissions set"
echo ""

echo "=========================================="
echo "✅ Setup Complete!"
echo "=========================================="
echo ""
echo "🚀 To start the development server, run:"
echo "   php artisan serve"
echo ""
echo "📧 Default admin credentials:"
echo "   Email: admin@example.com"
echo "   Password: password"
echo ""
echo "⚠️  IMPORTANT: Change the admin password after first login!"
echo ""
echo "🌐 The application will be available at:"
echo "   http://127.0.0.1:8000"
echo ""
echo "=========================================="
