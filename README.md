# New Cairo University of Technology - College Management System

A comprehensive **Full-Stack Laravel-based Content Management System** designed for educational institutions. This system provides a robust admin dashboard for managing college content, departments, events, news, student services, and a complete **Student Admission & Portal System** with role-based access control and **AI-powered chatbot integration**.

---

## 🛠️ Technical Stack

| Component | Technology | Version |
|-----------|-----------|---------|
| **Backend Framework** | Laravel | 13.17.0 |
| **PHP** | PHP | 8.5 |
| **Database** | MySQL | 8.4 |
| **Frontend CSS** | Tailwind CSS | 3.4.19 |
| **JavaScript Framework** | Alpine.js | 3.15.11 |
| **Authentication** | Laravel Breeze | 2.4.2 |
| **API Security** | Laravel Sanctum | 4.3.2 |
| **Code Quality** | Laravel Pint | 1.29.3 |
| **Testing** | Pest | 4.7.4 |
| **Build Tool** | Vite | Latest |

### Additional Dependencies
- **Laravel Boost** (2.4.10) - Enhanced Laravel development tools
- **Laravel MCP** (0.8.2) - Model-Context-Protocol integration
- **Google Gemini PHP SDK** (v2.0.4) - AI chatbot integration
- **jQuery** (3.7.1) - JavaScript library
- **Owl Carousel** (2.3.4) - Responsive carousel
- **WOW.js** (1.1.2) - Scroll animations
- **FontAwesome** (5.10.0) - Icon library

---

## 🚀 Key Features

### 🎓 Student Admission System
- **Public Admission Form**: Complete student registration with document uploads
  - Quadruple name fields (First, Second, Third, Fourth)
  - Personal photo and document uploads (Birth Certificate, Qualification, Student ID)
  - Parent/Guardian information and ID document
  - Automatic email linkage from user account
- **Admin Review Dashboard**: 
  - Manage pending, accepted, and rejected applications
  - Generate unique student codes for accepted students
  - Track rejection reasons
  - Automated email notifications
- **Student Portal**: 
  - Application status tracking
  - Student profile card (for accepted students)
  - Profile management and password changes

### 🎯 Training Programs - Horizontal Card Layout
- **Frontend Display**: Modern horizontal card layout with:
  - Image on the left (40% width, full height)
  - Content on the right (60% width)
  - Styled date badge (orange background)
  - Bold title and description
  - Training metadata (instructor, location, duration, capacity)
  - Vertically stacked cards (no grid)
  - Responsive design (stacks vertically on mobile)
- **Admin Management**: Table-based CRUD interface
  - Single image upload per training
  - Thumbnail display in admin table
  - Edit/Delete operations
  - Status management (Active/Inactive)

### 🎓 Graduates Management
- **Single-Image Architecture**: Streamlined graduate achievement cards
  - Per-graduate image upload using HandlesImageUploads trait
  - ImageProcessor integration for optimized storage
  - Order management for display priority
  - Active/Inactive status control
- **Admin Interface**: Clean table layout with:
  - Image thumbnails in listing
  - CRUD operations (Create, Read, Update, Delete)
  - Responsive design
  - Bulk management capabilities

### 📊 Optimized Admin Dashboard
- **Table-Based Layouts**: Efficient data management with sortable tables
- **Flash Message System**: High-contrast alerts
  - Success: `bg-green-100 text-green-900 border-green-400`
  - Error: `bg-red-100 text-red-900 border-red-400`
  - Warning: `bg-yellow-100 text-yellow-900 border-yellow-400`
  - Info: `bg-blue-100 text-blue-900 border-blue-400`
- **Responsive Design**: Tailwind CSS-powered admin interface
- **Quick Actions**: Streamlined content management workflows

### 🤖 AI Chatbot System
- **Google Gemini Integration**: Official `google-gemini-php/laravel` SDK
- **Gemini 1.5 Flash Model**: Fast, context-aware responses
- **Modern UI**: Floating chatbot with auto-resize input
- **Real-Time Communication**: AJAX/Fetch API integration
- **Mobile-Optimized**: Full-screen on mobile, compact on desktop

### 📰 Content Management
- **President & Deans Management**: Leadership profile management
- **Departments**: Department information with images and status control
- **News & Events**: Full CRUD operations with image galleries
- **Gallery Management**: Institutional photo organization
- **Testimonials**: Graduate success stories with drag-and-drop reordering
- **Tuition Fees**: Fee structure management
- **Activities & Competitions**: Student event tracking
- **Protocols**: Internal and external partnership documentation

### 🔐 Security Features
- **Role-Based Access Control (RBAC)**: Admin/User roles
- **IsAdmin Middleware**: Route-level authorization
- **CSRF Protection**: Cross-site request forgery prevention
- **Password Hashing**: Bcrypt encryption
- **Email Verification**: Secure account activation
- **SQL Injection Prevention**: Parameterized queries via Eloquent

---

## 🗄️ Database Structure

### Single-Image Architecture

Both **graduates** and **trainings** tables utilize a streamlined single-image column design:

#### Graduates Table
```sql
CREATE TABLE graduates (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255) NULL,          -- Single image column
    is_active TINYINT(1) DEFAULT 1,
    order INT DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

#### Trainings Table
```sql
CREATE TABLE trainings (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255) NULL,          -- Single image column
    instructor VARCHAR(255) NULL,
    start_date DATE NULL,
    end_date DATE NULL,
    location VARCHAR(255) NULL,
    duration INT NULL,
    capacity INT NULL,
    category VARCHAR(255) NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

**Key Benefits**:
- ✅ Simplified data model
- ✅ Cleaner codebase
- ✅ Faster queries
- ✅ Reduced storage overhead
- ✅ Consistent architecture across modules

---

## 📋 Requirements

- **PHP**: 8.5+
- **Composer**: Latest stable version
- **Node.js**: v18+ and npm
- **Database**: MySQL 8.4+
- **Web Server**: Apache/Nginx or Laravel's built-in server

---

## 🛠️ Setup Instructions

### 1. Clone the Repository

```bash
git clone <repository-url>
cd <project-directory>
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Database

Edit `.env` file with your MySQL credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Run Migrations

```bash
# Run all migrations
php artisan migrate

# Seed the database with sample data (optional)
php artisan db:seed

# Or run both together
php artisan migrate --seed
```

**Important Migrations**:
- `2026_06_30_000001_add_image_column_to_graduates_table.php` - Adds single image support to graduates
- `2026_06_30_000002_refactor_trainings_to_single_image.php` - Consolidates training images to single column

### 6. Storage Link

Create symbolic link for public storage:

```bash
php artisan storage:link
```

### 7. Build Frontend Assets

```bash
# For development (with hot reload)
npm run dev

# For production (optimized build)
npm run build
```

### 8. Configure AI Chatbot (Optional)

Add your Google Gemini API key to `.env`:

```env
GEMINI_API_KEY=your_gemini_api_key_here
```

Get your API key from: https://aistudio.google.com/app/apikey

### 9. Start Development Server

```bash
# Laravel's built-in server
php artisan serve

# Application will be available at:
# http://127.0.0.1:8000
```

---

## 🔐 Default Credentials

After seeding, you can log in with:

**Admin Account:**
```
Email: admin@admin.com
Password: password
Role: admin
Dashboard: /admin/dashboard
```

**Test Student Account:**
```
Email: fatmahassanin@gmail.com
Password: (set during registration)
Role: user
Portal: /student/portal
```

**⚠️ Important**: Change these credentials immediately in production!

---

## 🧪 Testing

Run the test suite:

```bash
# Run all tests
php artisan test

# Run with coverage
php artisan test --coverage
```

# Run specific test
php artisan test tests/Feature/ExampleTest.php
```

---

## 🎨 Code Quality

Format code using Laravel Pint (PSR-12):

```bash
# Check code style
vendor/bin/pint --test

# Fix code style issues
vendor/bin/pint

# Fix only modified files
vendor/bin/pint --dirty
```

---

## 🚀 Production Deployment

### Optimization Commands

```bash
# Install production dependencies
composer install --optimize-autoloader --no-dev

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Build production assets
npm run build

# Run migrations
php artisan migrate --force
```

### Environment Configuration

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
```

### Set Permissions

```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

---

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Coding Standards

- Follow PSR-12 standards
- Write PHPDoc comments
- Add tests for new features
- Run `vendor/bin/pint` before committing

---

## 📝 License

This project is licensed under the MIT License.

---

## 🙏 Acknowledgments

- Built with [Laravel 13](https://laravel.com)
- UI powered by [Tailwind CSS](https://tailwindcss.com)
- Authentication via [Laravel Breeze](https://laravel.com/docs/breeze)
- AI Integration with [Google Gemini PHP SDK](https://github.com/google-gemini-php/laravel)
- Code quality maintained with [Laravel Pint](https://laravel.com/docs/pint)

---

**Developed with ❤️ for Educational Excellence**

**New Cairo University of Technology** | Full-Stack Laravel 13 | PHP 8.5 | MySQL 8.4 | Tailwind CSS
