# Environment Configuration Guide

This document explains the environment-aware configuration for the University CMS application.

## Overview

The application is configured to behave differently across development, testing, and production environments to ensure optimal performance and security.

## Environment Variables

All environment-specific settings are configured in the `.env` file. Use `.env.example` as a template.

### Key Environment Settings

#### Application Environment
```env
APP_ENV=local          # Options: local, testing, production
APP_DEBUG=true         # true for dev/test, false for production
```

#### Cache Configuration
```env
# Development: Use 'file' or 'database' for simplicity
# Production: Use 'redis' for better performance
CACHE_STORE=database
```

**Automatic Defaults:**
- Production: `redis` (high performance, requires Redis server)
- Development/Testing: `file` (simple, no dependencies)

#### Queue Configuration
```env
# Development: Use 'sync' or 'database' for immediate execution
# Production: Use 'redis' for better performance
QUEUE_CONNECTION=database
```

#### Mail Configuration
```env
# Development: Use 'log' to write emails to log files
# Production: Use 'smtp' with real mail server credentials
MAIL_MAILER=log
```

#### Database Configuration
```env
# Development: Use 'sqlite' for simplicity
# Production: Use 'mysql' with proper credentials
DB_CONNECTION=sqlite
```

## Environment-Specific Behavior

### Development Environment (`APP_ENV=local`)

- **Debug Mode**: Enabled - Shows detailed error messages with stack traces
- **Cache Driver**: File-based (default) - Simple, no external dependencies
- **Queue Driver**: Database or Sync - Immediate execution for testing
- **Mail Driver**: Log - Emails written to `storage/logs/laravel.log`
- **Asset Compilation**: Hot reload with Vite for instant updates
- **Error Pages**: Detailed error information displayed

### Testing Environment (`APP_ENV=testing`)

- **Debug Mode**: Enabled - Detailed errors for debugging tests
- **Cache Driver**: Array - In-memory cache, cleared between tests
- **Queue Driver**: Sync - Immediate execution for predictable tests
- **Mail Driver**: Array - Emails captured in memory for assertions
- **Database**: Separate test database or in-memory SQLite

### Production Environment (`APP_ENV=production`)

- **Debug Mode**: Disabled - Generic error pages for security
- **Cache Driver**: Redis (default) - High performance distributed cache
- **Queue Driver**: Redis - Asynchronous job processing
- **Mail Driver**: SMTP - Real email delivery
- **Asset Compilation**: Minified and optimized with Vite
- **Error Pages**: Generic error messages (500, 404, 403)
- **Logging**: Daily log rotation for better management

## Configuration Files

### `config/cache.php`
Automatically selects Redis for production, file cache for development:
```php
'default' => env('CACHE_STORE', env('APP_ENV') === 'production' ? 'redis' : 'file'),
```

### `config/app.php`
Automatically disables debug mode in production:
```php
'debug' => (bool) env('APP_DEBUG', env('APP_ENV') !== 'production'),
```

### `bootstrap/app.php`
Configures environment-aware error handling:
- Production: Generic error pages (500, 404, 403)
- Development: Detailed error messages with stack traces

### `vite.config.js`
Configures asset compilation based on build mode:
- Development: Hot module replacement, source maps enabled
- Production: Minified assets, source maps disabled

## Switching Environments

### Local Development
```env
APP_ENV=local
APP_DEBUG=true
CACHE_STORE=file
QUEUE_CONNECTION=sync
MAIL_MAILER=log
```

### Production Deployment
```env
APP_ENV=production
APP_DEBUG=false
CACHE_STORE=redis
QUEUE_CONNECTION=redis
MAIL_MAILER=smtp
DB_CONNECTION=mysql
```

After changing environment settings:
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## Asset Compilation

### Development
```bash
npm run dev
```
Starts Vite development server with hot module replacement.

### Production
```bash
npm run build
```
Compiles and minifies assets for production deployment.

## Best Practices

1. **Never commit `.env` file** - Contains sensitive credentials
2. **Keep `.env.example` updated** - Document all required variables
3. **Use Redis in production** - Significantly improves cache and queue performance
4. **Disable debug mode in production** - Prevents information disclosure
5. **Use daily log rotation in production** - Prevents disk space issues
6. **Test environment switching** - Verify application works in all environments
7. **Use environment-specific databases** - Prevent accidental data loss

## Troubleshooting

### Cache not working in production
- Verify Redis is installed and running
- Check `REDIS_HOST` and `REDIS_PORT` in `.env`
- Run `php artisan config:clear`

### Assets not loading in production
- Run `npm run build` to compile assets
- Verify `APP_URL` is set correctly
- Check file permissions on `public/build` directory

### Emails not sending in production
- Verify SMTP credentials in `.env`
- Check `MAIL_FROM_ADDRESS` is valid
- Test with `php artisan tinker` and `Mail::raw()`
