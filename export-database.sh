#!/bin/bash

# Database Export Script
# This script exports a clean database with structure and essential seeded data

echo "=========================================="
echo "Database Export Script"
echo "=========================================="
echo ""

# Check if .env file exists
if [ ! -f .env ]; then
    echo "❌ Error: .env file not found"
    echo "Please run setup.sh first"
    exit 1
fi

# Get database credentials from .env file
DB_NAME=$(grep "^DB_DATABASE=" .env | cut -d '=' -f2)
DB_USER=$(grep "^DB_USERNAME=" .env | cut -d '=' -f2)
DB_PASS=$(grep "^DB_PASSWORD=" .env | cut -d '=' -f2)
DB_HOST=$(grep "^DB_HOST=" .env | cut -d '=' -f2)

# Set defaults if not found
DB_NAME=${DB_NAME:-graduation_project_clacet2}
DB_USER=${DB_USER:-root}
DB_HOST=${DB_HOST:-127.0.0.1}

echo "Database: $DB_NAME"
echo "User: $DB_USER"
echo "Host: $DB_HOST"
echo ""

# Check if mysqldump is available
if ! command -v mysqldump &> /dev/null
then
    echo "❌ Error: mysqldump is not found"
    echo "Please ensure MySQL is installed"
    exit 1
fi

echo "📤 Exporting database..."
echo ""

# Export database structure and data
if [ -z "$DB_PASS" ]; then
    mysqldump -h "$DB_HOST" -u "$DB_USER" --single-transaction --routines --triggers --databases "$DB_NAME" > database.sql
else
    mysqldump -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASS" --single-transaction --routines --triggers --databases "$DB_NAME" > database.sql
fi

if [ $? -ne 0 ]; then
    echo "❌ Failed to export database"
    exit 1
fi

echo ""
echo "=========================================="
echo "✅ Database exported successfully!"
echo "=========================================="
echo ""
echo "📁 File: database.sql"
echo "📊 Size: $(du -h database.sql | cut -f1)"
echo ""
echo "This file contains:"
echo "  - Complete database structure (all tables)"
echo "  - Essential seeded data (users, deans, departments, etc.)"
echo "  - Ready for import on any MySQL server"
echo ""
echo "To import on another machine:"
echo "  mysql -u root -p < database.sql"
echo ""
