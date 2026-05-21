# College Management System

A comprehensive Laravel-based Content Management System designed for educational institutions. This system provides a robust admin dashboard for managing college content, departments, events, news, student services, and a complete **Student Admission & Portal System** with role-based access control.

## 🚀 Features

### 🎓 Student Admission System (NEW!)
- **Public Admission Form**: Students can register and submit admission applications with:
  - Quadruple name fields (First, Second, Third, Fourth)
  - Personal photo upload
  - Document uploads (Birth Certificate, Qualification, Student ID)
  - Parent/Guardian information and ID document
  - Email automatically linked from user account
- **Admin Review Dashboard**: 
  - Pending, Accepted, and Rejected application management
  - Approve applications with unique student code generation
  - Reject applications with reason tracking
  - Automatic email notifications to students
- **Student Portal**: Dedicated portal for students to:
  - Track application status (Pending/Accepted/Rejected)
  - View student profile card (for accepted students)
  - Access student code
  - Update profile information
  - Change password
  - Logout functionality

### 🔐 Authentication & Security
- **Role-Based Access Control**: 
  - Admin role: Full access to admin dashboard
  - User role: Access to student portal and admission system
- **Secure Authentication**: Laravel Breeze-powered with email verification
- **IsAdmin Middleware**: Protects all admin routes from unauthorized access
- **Username-Based Registration**: Unique username requirement with validation
- **Email Uniqueness**: Enforced at both application and database levels
- **Duplicate Prevention**: Multiple layers of validation to prevent duplicate data

### Content Management
- **President & Deans Management**: Dedicated sections for college leadership profiles with rich content editing
- **Departments**: Manage college departments with descriptions, images, and active status control
- **News & Events**: Full CRUD operations for news articles and upcoming events with image galleries
- **Gallery Management**: Organize and display institutional photos and media
- **Testimonials/Success Stories**: Showcase graduate achievements with drag-and-drop reordering

### Academic Services
- **Training Programs**: Manage training courses with support for up to 4 images per training
- **Tuition Fees**: Maintain and display fee structures for different programs
- **Activities & Competitions**: Track student activities and competitive events
- **Internal & External Protocols**: Document institutional agreements and partnerships

### Administrative Features
- **Admission Statistics Dashboard**: Real-time counts of pending, accepted, and rejected applications
- **Image Upload Management**: Centralized image handling with automatic optimization
- **Drag & Drop Reordering**: Intuitive content prioritization for testimonials and other sortable content
- **Responsive Admin Dashboard**: Modern Tailwind CSS-based interface with quick action cards
- **Role-Based Navigation**: Dynamic navbar showing admin dashboard or student profile based on user role

### Technical Highlights
- **RESTful API**: JSON API endpoints for frontend integration
- **Database Seeding**: Pre-populated data for quick setup and testing
- **Code Quality**: PSR-12 compliant with Laravel Pint integration
- **DRY Principles**: Reusable traits for common operations (image uploads, validation)
- **Comprehensive Documentation**: PHPDoc comments throughout the codebase
- **Security Audited**: Multiple security layers and validation checks

## 📋 Requirements

- **PHP**: ^8.3
- **Composer**: Latest stable version
- **Node.js**: v18+ and npm
- **Database**: SQLite (default) or MySQL/PostgreSQL
- **Web Server**: Apache/Nginx or Laravel's built-in server

## 🛠️ Installation

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

Edit `.env` file with your database credentials:

```env
# For SQLite (default)
DB_CONNECTION=sqlite

# For MySQL
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

For SQLite, ensure the database file exists:

```bash
touch database/database.sqlite
```

### 5. Run Migrations and Seeders

```bash
# Run migrations
php artisan migrate

# Seed the database with sample data
php artisan db:seed

# Or run both together
php artisan migrate --seed
```

### 6. Storage Link

Create symbolic link for public storage:

```bash
php artisan storage:link
```

### 7. Build Frontend Assets

```bash
# For development
npm run dev

# For production
npm run build
```

### 8. Start Development Server

```bash
# Option 1: Laravel's built-in server
php artisan serve

# Option 2: Run all services concurrently (recommended)
composer run dev
```

The application will be available at `http://127.0.0.1:8000`

## 🔐 Default Credentials

After seeding, you can log in with:

**Admin Account:**
```
Email: admin@admin.com
Password: password
Role: admin
```

**Test Student Account:**
```
Email: fatmahassanin@gmail.com
Password: (set during registration)
Role: user
```

**⚠️ Important**: Change these credentials immediately in production!

## 👥 User Roles

### Admin Role
- Full access to admin dashboard (`/admin/dashboard`)
- Manage all content (news, events, departments, etc.)
- Review and approve/reject admission applications
- Assign student codes to accepted students
- View admission statistics

### User Role (Students)
- Register with unique username and email
- Submit admission application
- Access student portal (`/student/portal`)
- Track application status
- Update profile and change password
- View student code (if accepted)

## 📁 Project Structure

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/              # Authentication controllers
│   │   │   ├── Back/              # Admin dashboard controllers
│   │   │   ├── Pages/             # Frontend page controllers
│   │   │   ├── AdmissionController.php      # Public admission form
│   │   │   └── StudentPortalController.php  # Student portal
│   │   ├── Middleware/
│   │   │   └── IsAdmin.php        # Admin role middleware
│   │   └── Requests/              # Form request validation
│   ├── Models/
│   │   ├── User.php               # User model (with role)
│   │   ├── Admission.php          # Admission model
│   │   └── ...                    # Other models
│   ├── Traits/                    # Reusable traits (HandlesImageUploads)
│   └── View/Components/           # Blade components
├── database/
│   ├── factories/                 # Model factories for testing
│   ├── migrations/
│   │   ├── *_create_users_table.php
│   │   ├── *_create_admissions_table.php
│   │   ├── *_add_username_to_users.php
│   │   └── ...                    # Other migrations
│   └── seeders/                   # Database seeders
├── resources/
│   ├── views/
│   │   ├── admin/                 # Admin dashboard views
│   │   │   ├── admissions/        # Admission management views
│   │   │   └── ...
│   │   ├── student/               # Student portal views
│   │   │   ├── portal.blade.php
│   │   │   ├── edit-profile.blade.php
│   │   │   └── change-password.blade.php
│   │   ├── admission/             # Public admission form
│   │   │   └── create.blade.php
│   │   ├── emails/                # Email templates
│   │   │   └── admission-accepted.blade.php
│   │   ├── pages/                 # Frontend page views
│   │   ├── layouts/               # Layout templates
│   │   └── partials/              # Reusable view components (navbar, footer)
│   └── css/                       # Stylesheets
├── routes/
│   ├── web_back/                  # Admin routes (protected by IsAdmin middleware)
│   └── web_front/                 # Public routes + Student portal routes
└── public/
    ├── uploads/                   # User-uploaded files
    └── storage/                   # Symlinked storage (admission documents)
```

## 🧪 Testing

Run the test suite:

```bash
# Run all tests
php artisan test

# Run tests with coverage
php artisan test --coverage

# Run specific test file
php artisan test tests/Feature/ExampleTest.php
```

## 🎨 Code Style

This project follows PSR-12 coding standards. Format your code using Laravel Pint:

```bash
# Check code style
vendor/bin/pint --test

# Fix code style issues
vendor/bin/pint

# Fix only modified files
vendor/bin/pint --dirty
```

## 📚 Key Modules

### President Management
Manage the college president's profile, message, and biography with rich media support.

### Deans Management
Maintain profiles for multiple deans with individual pages and content sections.

### Departments
Fixed-structure department management (edit-only) for college branches with:
- Department name and description
- Featured image
- Active/inactive status toggle

### Training Programs
Comprehensive training course management with:
- Support for up to 4 images per training
- Rich text descriptions
- Date and duration tracking
- Frontend gallery display

### Testimonials/Success Stories
Interactive testimonial management featuring:
- Drag-and-drop reordering
- Student photo uploads
- Success story narratives
- Dynamic homepage integration

### Tuition Fees
Structured fee management for different academic programs and levels.

### News & Events
Full content management for institutional news and upcoming events with:
- Featured images
- Publication dates
- Category organization
- Archive functionality

## 🔧 Configuration

### Image Upload Settings

Configure upload limits in `config/filesystems.php` or via environment variables.

### Mail Configuration

Set up email delivery in `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS="noreply@college.edu"
MAIL_FROM_NAME="${APP_NAME}"
```

### Cache Configuration

For production, use Redis or Memcached:

```env
CACHE_STORE=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

## 🚀 Deployment

### Production Checklist

1. **Environment Configuration**
   ```bash
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://your-domain.com
   ```

2. **Optimize Application**
   ```bash
   composer install --optimize-autoloader --no-dev
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   npm run build
   ```

3. **Set Permissions**
   ```bash
   chmod -R 755 storage bootstrap/cache
   chown -R www-data:www-data storage bootstrap/cache
   ```

4. **Database Migration**
   ```bash
   php artisan migrate --force
   ```

5. **Queue Workers** (if using queues)
   ```bash
   php artisan queue:work --daemon
   ```

### Recommended Hosting

- **Laravel Cloud**: Official Laravel hosting platform
- **Laravel Forge**: Server management and deployment
- **DigitalOcean**: VPS with Laravel optimizations
- **AWS/Azure**: Enterprise-grade cloud hosting

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Coding Standards

- Follow PSR-12 standards
- Write meaningful PHPDoc comments
- Add tests for new features
- Run `vendor/bin/pint` before committing

## 📝 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 🐛 Bug Reports & Feature Requests

Please use the GitHub issue tracker to report bugs or request features.

## 📧 Support

For support inquiries, please contact the development team or open an issue on GitHub.

## 🙏 Acknowledgments

- Built with [Laravel 13](https://laravel.com)
- UI powered by [Tailwind CSS 4](https://tailwindcss.com)
- Authentication via [Laravel Breeze](https://laravel.com/docs/breeze)
- Code quality maintained with [Laravel Pint](https://laravel.com/docs/pint)

---

**Developed with ❤️ for Educational Excellence**
