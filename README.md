# New Cairo University of Technology - College Management System

A comprehensive **Full-Stack Laravel-based Content Management System** designed for educational institutions. This system provides a robust admin dashboard for managing college content, departments, events, news, student services, and a complete **Student Admission & Portal System** with role-based access control and **AI-powered chatbot integration**.

---

## 🛠️ Complete Technology Stack

### 🌐 Core Languages
- **PHP 8.3+** - Server-side programming language
- **JavaScript (ES6+)** - Client-side scripting with modern syntax
  - AJAX & Fetch API for asynchronous requests
  - DOM manipulation and event handling
- **HTML5** - Markup with Laravel Blade Templating Engine
- **SQL** - MySQL 8.4 database dialect for data management

### 🎯 Backend Framework & Architecture
- **Laravel 13.x** - Full-Stack PHP Framework
  - **MVC Architecture** - Model-View-Controller design pattern
  - **Eloquent ORM** - Database abstraction with relationships
  - **Middleware Guards** - Route protection and authentication
  - **Route Localization** - Multi-language URL routing
  - **Local File Storage** - Secure file upload system
  - **SMTP Mail System** - Automated email notifications
  - **Laravel Breeze** - Lightweight authentication scaffolding
  - **Laravel Sanctum** - API token authentication

### 🤖 AI Integration
- **Google Gemini PHP SDK** (`google-gemini-php/laravel` v2.0.4)
  - **Gemini 1.5 Flash Model** - High-speed conversational AI
  - Real-time chatbot with contextual responses
  - AJAX/Fetch API integration for seamless UX

### 🎨 Frontend Design & UI/UX
- **Tailwind CSS 3.1.0** - Utility-first CSS framework
  - 100% responsive modern layout
  - Custom utility classes with JIT compiler
  - `@tailwindcss/forms` plugin for form styling
- **Bootstrap 5.3.0** - Component library
  - Grid system and responsive utilities
  - RTL support for Arabic localization
- **FontAwesome 5.10.0** - Icon library (2,000+ icons)
- **Bootstrap Icons 1.4.1** - Additional icon set
- **Google Fonts** - Heebo & Nunito font families

### ✨ Frontend Interactivity & Effects
- **jQuery 3.7.1** - Fast, small JavaScript library
- **Owl Carousel 2.3.4** - Touch-enabled responsive carousel
  - News slider
  - Activities showcase
  - Testimonials rotator
- **WOW.js 1.1.2** - Scroll-triggered animations
- **Animate.css 4.1.1** - Cross-browser CSS animations
  - `slideInDown`, `slideInLeft`, `fadeInUp` effects
- **jQuery Easing 1.4.1** - Smooth animation transitions
- **Waypoints 4.0.1** - Scroll-based event triggers

### 📦 External Laravel Packages
- **mcamara/laravel-localization (v2.4)** - Multi-language routing
  - Seamless Arabic/English URL localization
  - Session-based language persistence
  - SEO-friendly localized routes
- **Laravel Tinker (v3.0)** - REPL for Laravel
- **Laravel Pint (v1.27)** - Opinionated PHP code formatter (PSR-12)

### 🛠️ Development & Build Tools
- **Vite 8.0.0** - Next-generation frontend build tool
  - Lightning-fast HMR (Hot Module Replacement)
  - Optimized production builds
  - Asset bundling and optimization
- **Laravel Vite Plugin 3.0.0** - Laravel integration for Vite
- **Composer** - PHP dependency manager
- **NPM** - Node package manager
- **PostCSS 8.4.31** - CSS transformation tool
- **Autoprefixer 10.4.2** - CSS vendor prefix automation
- **Axios 1.15.0** - Promise-based HTTP client
- **Alpine.js 3.4.2** - Lightweight JavaScript framework
- **Concurrently 9.0.1** - Run multiple commands simultaneously

### 🧪 Testing & Quality Assurance
- **Pest 4.6** - Elegant PHP testing framework
- **Pest Laravel Plugin 4.1** - Laravel-specific testing utilities
- **Mockery 1.6** - Mocking framework for unit tests
- **PHPUnit** - PHP testing framework (included with Pest)
- **Faker 1.23** - Fake data generator for testing

### 🗄️ Database & ORM
- **MySQL 8.4** - Relational database management system
- **Eloquent ORM** - Laravel's database abstraction layer
- **Migrations** - Version control for database schema
- **Seeders & Factories** - Test data generation

### 🔐 Security Features
- **CSRF Protection** - Cross-site request forgery prevention
- **Password Hashing** - Bcrypt encryption
- **Email Verification** - Secure account activation
- **Role-Based Access Control (RBAC)** - Admin/User roles
- **IsAdmin Middleware** - Route-level authorization
- **SQL Injection Prevention** - Parameterized queries via Eloquent

### 📡 Additional Technologies
- **RESTful API** - JSON endpoints for frontend integration
- **AJAX/Fetch API** - Asynchronous data loading
- **Session Management** - Secure user session handling
- **Cookie Management** - Laravel's encrypted cookies
- **File Upload System** - Validated image/document uploads
- **Email Templates** - Blade-based notification emails

---

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

### 🤖 AI Chatbot System (NEW!)
- **Google Gemini Integration**: Official `google-gemini-php/laravel` SDK
- **Gemini 1.5 Flash Model**: Fast, efficient AI responses
- **Floating Chatbot UI**: Modern, responsive chat interface
- **Real-Time Communication**: AJAX/Fetch API for seamless interaction
- **Context-Aware Responses**: University-specific information and guidance
- **Mobile-Optimized**: Full-screen on mobile, compact on desktop
- **Auto-Resize Input**: Dynamic textarea that grows with user input

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

### 8. Configure AI Chatbot (Optional)

Add your Google Gemini API key to `.env`:

```env
GEMINI_API_KEY=your_gemini_api_key_here
```

Get your API key from: https://aistudio.google.com/app/apikey

### 9. Start Development Server

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
│   │   │   ├── Auth/                        # Authentication controllers
│   │   │   ├── Back/                        # Admin dashboard controllers
│   │   │   ├── Pages/                       # Frontend page controllers
│   │   │   ├── AdmissionController.php      # Public admission form
│   │   │   ├── ChatbotController.php        # AI chatbot (Gemini integration)
│   │   │   └── StudentPortalController.php  # Student portal
│   │   ├── Middleware/
│   │   │   └── IsAdmin.php                  # Admin role middleware
│   │   └── Requests/                        # Form request validation
│   ├── Models/
│   │   ├── User.php                         # User model (with role)
│   │   ├── Admission.php                    # Admission model
│   │   └── ...                              # Other models
│   ├── Services/
│   │   └── Chatbot/                         # Chatbot service layer
│   │       └── AIClientInterface.php        # Gemini client interface
│   ├── Traits/                              # Reusable traits (HandlesImageUploads)
│   └── View/Components/                     # Blade components
├── config/
│   ├── gemini.php                           # Gemini API configuration
│   ├── laravellocalization.php              # Multi-language config
│   └── ...                                  # Other configs
├── database/
│   ├── factories/                           # Model factories for testing
│   ├── migrations/
│   │   ├── *_create_users_table.php
│   │   ├── *_create_admissions_table.php
│   │   ├── *_add_username_to_users.php
│   │   └── ...                              # Other migrations
│   └── seeders/                             # Database seeders
├── resources/
│   ├── views/
│   │   ├── admin/                           # Admin dashboard views
│   │   │   ├── admissions/                  # Admission management views
│   │   │   └── ...
│   │   ├── student/                         # Student portal views
│   │   │   ├── portal.blade.php
│   │   │   ├── edit-profile.blade.php
│   │   │   └── change-password.blade.php
│   │   ├── admission/                       # Public admission form
│   │   │   └── create.blade.php
│   │   ├── components/                      # Reusable Blade components
│   │   │   ├── chatbot.blade.php            # AI chatbot UI component
│   │   │   └── page-header.blade.php        # Page header component
│   │   ├── emails/                          # Email templates
│   │   │   └── admission-accepted.blade.php
│   │   ├── pages/                           # Frontend page views
│   │   ├── layouts/                         # Layout templates
│   │   └── partials/                        # Reusable view components (navbar, footer)
│   ├── lang/                                # Localization files
│   │   ├── en/messages.php                  # English translations
│   │   └── ar/messages.php                  # Arabic translations
│   └── css/                                 # Stylesheets
├── routes/
│   ├── web_back/                            # Admin routes (protected by IsAdmin middleware)
│   ├── web_front/                           # Public routes + Student portal routes
│   └── web.php                              # Main routing file (includes chatbot routes)
└── public/
    ├── uploads/                             # User-uploaded files
    └── storage/                             # Symlinked storage (admission documents)
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

- Built with [Laravel 11](https://laravel.com) - The PHP Framework for Web Artisans
- UI powered by [Tailwind CSS 4](https://tailwindcss.com) + [Bootstrap 5](https://getbootstrap.com)
- Authentication via [Laravel Breeze](https://laravel.com/docs/breeze)
- AI Integration with [Google Gemini PHP SDK](https://github.com/google-gemini-php/laravel)
- Localization by [mcamara/laravel-localization](https://github.com/mcamara/laravel-localization)
- Code quality maintained with [Laravel Pint](https://laravel.com/docs/pint)

---

## 🌐 Additional Resources

- **Laravel Documentation**: https://laravel.com/docs
- **Tailwind CSS Docs**: https://tailwindcss.com/docs
- **Google Gemini API**: https://ai.google.dev/docs
- **Laravel Breeze**: https://laravel.com/docs/starter-kits#breeze
- **PHP Standards**: https://www.php-fig.org/psr/psr-12/

---

**Developed with ❤️ for Educational Excellence**

**New Cairo University of Technology** | Full-Stack MVC Architecture | AI-Powered Student Services
