# University CMS - Deployment Guide

## Project Overview
A dynamic Laravel 13.x CMS application for managing a university website with 70+ pages, multi-language support (English/Arabic), and comprehensive content management features.

## Features
- ✅ Dynamic page management with content blocks
- ✅ Multi-language support (English/Arabic with RTL)
- ✅ Media library with image optimization
- ✅ Event calendar with iCalendar export
- ✅ News feed with RSS
- ✅ Full-text search across content
- ✅ Role-based access control (Super Admin, Content Editor, Faculty Admin)
- ✅ Content versioning and audit logging
- ✅ SEO optimization with sitemap generation
- ✅ Contact form with validation
- ✅ Static HTML migration tool

## Tech Stack
- **Backend**: Laravel 13.x, PHP 8.2+
- **Frontend**: Blade templates, Bootstrap 5, Vite
- **Database**: MySQL 8.0+ / PostgreSQL 13+
- **Cache**: Redis (production) / File (development)
- **Testing**: PHPUnit with 417 passing tests

## Requirements
- PHP 8.2 or higher
- Composer 2.x
- Node.js 18.x or higher
- MySQL 8.0+ or PostgreSQL 13+
- Redis (for production)
- Nginx or Apache

## Local Development Setup

### 1. Clone the repository
```bash
git clone https://github.com/yourusername/university-cms.git
cd university-cms
```

### 2. Install dependencies
```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Configure environment
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=university_cms
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Set up database
```bash
# Run migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed

# Migrate static HTML files (optional)
php artisan cms:migrate-static-files
```

### 5. Build assets and start server
```bash
# Build frontend assets
npm run build

# Start development server
php artisan serve
```

Visit: http://localhost:8000

## Production Deployment

### Option 1: VPS Deployment (DigitalOcean, AWS, Linode)

**Server Requirements:**
- Ubuntu 22.04 LTS
- 2GB RAM minimum
- 20GB storage
- PHP 8.2-FPM, Nginx, MySQL, Redis

**Deployment Steps:**

1. **Prepare server:**
```bash
sudo apt update && sudo apt upgrade -y
sudo apt install -y nginx mysql-server php8.2-fpm php8.2-mysql php8.2-xml \
    php8.2-mbstring php8.2-curl php8.2-zip php8.2-gd php8.2-redis redis-server \
    composer git unzip
```

2. **Clone and configure:**
```bash
cd /var/www
sudo git clone https://github.com/yourusername/university-cms.git production
cd production
sudo cp .env.example .env
sudo nano .env  # Configure production settings
```

3. **Install and build:**
```bash
composer install --no-dev --optimize-autoloader
npm install && npm run build
php artisan key:generate
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

4. **Set permissions:**
```bash
sudo chown -R www-data:www-data /var/www/production
sudo chmod -R 775 storage bootstrap/cache
```

5. **Configure Nginx** (see nginx.conf in repository)

6. **Set up SSL:**
```bash
sudo certbot --nginx -d yourdomain.com
```

### Option 2: Laravel Forge
1. Sign up at [forge.laravel.com](https://forge.laravel.com)
2. Connect your server provider
3. Create server and site
4. Connect GitHub repository
5. Configure environment variables
6. Deploy with one click

### Option 3: Docker Deployment
```bash
docker-compose up -d
docker-compose exec app php artisan migrate --force
```

## Environment Variables

### Required Variables
```env
APP_NAME="University CMS"
APP_ENV=production
APP_KEY=base64:...
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=university_cms
DB_USERNAME=cms_user
DB_PASSWORD=secure_password

CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
```

## Testing

Run the test suite:
```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Unit
php artisan test --testsuite=Feature

# Run with coverage
php artisan test --coverage
```

**Test Results:** 417 tests passing with 12,415 assertions

## Post-Deployment Checklist

- [ ] Database migrations completed
- [ ] Environment variables configured
- [ ] SSL certificate installed
- [ ] File permissions set correctly
- [ ] Cache configured (Redis in production)
- [ ] Cron job for scheduler set up
- [ ] Email configuration tested
- [ ] Backup strategy implemented
- [ ] Monitoring tools configured
- [ ] Security headers enabled

## Maintenance

### Update application:
```bash
git pull origin main
composer install --no-dev
npm install && npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Clear cache:
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Database backup:
```bash
php artisan backup:run
```

## Troubleshooting

### Common Issues

**Issue: 500 Internal Server Error**
- Check storage permissions: `sudo chmod -R 775 storage bootstrap/cache`
- Check error logs: `tail -f storage/logs/laravel.log`
- Clear cache: `php artisan cache:clear`

**Issue: Assets not loading**
- Run: `npm run build`
- Check public/build directory exists
- Verify APP_URL in .env

**Issue: Database connection failed**
- Verify database credentials in .env
- Check database server is running
- Test connection: `php artisan tinker` then `DB::connection()->getPdo();`

## Support

For issues and questions:
- GitHub Issues: https://github.com/yourusername/university-cms/issues
- Documentation: See `/docs` directory
- Email: support@youruniversity.edu

## License

This project is proprietary software for [University Name].

## Contributors

- Development Team
- Testing Team
- Content Team

---

Last Updated: April 2026
