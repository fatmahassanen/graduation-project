# NCTU Portal - Laravel MVC Architecture Diagram

## Overview
This document visualizes the Laravel MVC (Model-View-Controller) request-response lifecycle used in the NCTU University Portal system.

---

## Mermaid Architecture Diagram

```mermaid
graph TB
    subgraph "Client Layer"
        Browser[Web Browser]
        Mobile[Mobile Device]
    end
    
    subgraph "Presentation Layer - Blade Views"
        Layout[app.blade.php Layout]
        Components[Reusable Components]
        Pages[Page Templates]
        Forms[Form Views]
        
        Layout --> Components
        Layout --> Pages
        Layout --> Forms
        
        Components --> Navbar[navbar.blade.php]
        Components --> Footer[footer.blade.php]
        Components --> Chatbot[chatbot.blade.php]
        Components --> PageHeader[page-header.blade.php]
        
        Pages --> Home[home.blade.php]
        Pages --> About[about.blade.php]
        Pages --> Contact[contact.blade.php]
        Pages --> Dynamic[Dynamic Content Pages]
        
        Forms --> Login[login.blade.php]
        Forms --> Register[register.blade.php]
        Forms --> Admission[admission-form.blade.php]
    end
    
    subgraph "Routing Layer"
        WebRoutes[routes/web.php]
        FrontRoutes[routes/web_front/front.php]
        BackRoutes[routes/web_back/back.php]
        AuthRoutes[routes/web_back/auth.php]
        
        WebRoutes --> FrontRoutes
        WebRoutes --> BackRoutes
        WebRoutes --> AuthRoutes
    end
    
    subgraph "Middleware Layer"
        CSRF[VerifyCsrfToken]
        Auth[Authenticate]
        Admin[IsAdmin]
        Locale[LaravelLocalization]
        Session[StartSession]
        
        CSRF --> Auth
        Auth --> Admin
        Auth --> Locale
        CSRF --> Session
    end
    
    subgraph "Controller Layer"
        PageController[PageController.php]
        AdmissionController[AdmissionController.php]
        ChatbotController[ChatbotController.php]
        AdminController[Admin Controllers]
        
        PageController --> PublicMethods[Public Page Methods]
        AdmissionController --> AdmissionMethods[Admission CRUD]
        ChatbotController --> GeminiMethod[sendMessage]
        AdminController --> AdminMethods[Admin CRUD Methods]
        
        PublicMethods --> home
        PublicMethods --> about
        PublicMethods --> events
        PublicMethods --> news
        PublicMethods --> gallery
        
        AdmissionMethods --> create
        AdmissionMethods --> store
        AdmissionMethods --> show
        
        AdminMethods --> dashboard
        AdminMethods --> approve
        AdminMethods --> reject
        AdminMethods --> crud[CRUD Operations]
    end
    
    subgraph "Business Logic Layer"
        Validation[Form Validation]
        Authorization[Policy Checks]
        FileHandling[Image Upload/Storage]
        EmailService[Mail Notifications]
        CodeGeneration[Student Code Generator]
        
        Validation --> ValidationRules[Request Rules]
        Authorization --> Policies[User Policies]
        FileHandling --> Storage[Laravel Storage]
        EmailService --> MailClasses[Mailable Classes]
        CodeGeneration --> CodeLogic[Auto-generation Logic]
    end
    
    subgraph "Model Layer - Eloquent ORM"
        UserModel[User Model]
        AdmissionModel[Admission Model]
        EventModel[Event Model]
        NewsModel[News Model]
        GalleryModel[Gallery Model]
        ActivityModel[Activity Model]
        DeanModel[Dean Model]
        DepartmentModel[Department Model]
        
        UserModel --> UserRelations[Relationships]
        AdmissionModel --> AdmissionRelations[belongsTo User]
        
        UserRelations --> HasAdmission[hasOne Admission]
        UserRelations --> ReviewedAdmissions[hasMany reviewed]
    end
    
    subgraph "Database Layer"
        MySQL[(MySQL 8.4 Database)]
        
        MySQL --> UsersTable[users]
        MySQL --> AdmissionsTable[admissions]
        MySQL --> EventsTable[events]
        MySQL --> NewsTable[news]
        MySQL --> GalleriesTable[galleries]
        MySQL --> ActivitiesTable[activities]
        MySQL --> DeansTable[deans]
        MySQL --> DepartmentsTable[departments]
        MySQL --> CompetitionsTable[competitions]
        MySQL --> ProtocolsTable[protocols]
        MySQL --> TestimonialsTable[testimonials]
        MySQL --> TrainingsTable[trainings]
        MySQL --> ContactTable[contact_submissions]
        MySQL --> SessionsTable[sessions]
        MySQL --> CacheTable[cache]
    end
    
    subgraph "External Services"
        GeminiAPI[Google Gemini 1.5 Flash API]
        MailService[SMTP Mail Server]
        StorageService[File Storage System]
    end
    
    subgraph "Frontend Assets"
        TailwindCSS[Tailwind CSS Framework]
        JavaScript[Vanilla JavaScript]
        Vite[Vite Build Tool]
        FontAwesome[Icon Library]
    end
    
    %% Request Flow
    Browser --> WebRoutes
    Mobile --> WebRoutes
    
    WebRoutes --> Middleware Layer
    FrontRoutes --> Middleware Layer
    BackRoutes --> Middleware Layer
    
    Middleware Layer --> Controller Layer
    
    Controller Layer --> Business Logic Layer
    Controller Layer --> Model Layer
    
    Business Logic Layer --> Model Layer
    
    Model Layer --> MySQL
    
    %% Response Flow
    MySQL --> Model Layer
    Model Layer --> Controller Layer
    Controller Layer --> Presentation Layer
    
    Presentation Layer --> TailwindCSS
    Presentation Layer --> JavaScript
    
    TailwindCSS --> Browser
    JavaScript --> Browser
    
    %% External Service Connections
    ChatbotController --> GeminiAPI
    EmailService --> MailService
    FileHandling --> StorageService
    
    GeminiAPI --> ChatbotController
    
    %% Styling
    style Browser fill:#e3f2fd
    style Mobile fill:#e3f2fd
    style MySQL fill:#ffccbc
    style GeminiAPI fill:#f3e5f5
    style MailService fill:#fff9c4
    style TailwindCSS fill:#e0f2f1
    style JavaScript fill:#fff3e0
```

---

## Request-Response Lifecycle Breakdown

### 1. **HTTP Request Arrives**
```
Browser/Mobile → Apache/Nginx → public/index.php → Laravel Bootstrap
```

### 2. **Routing Resolution**
```
Route Dispatcher → Route Match → Middleware Pipeline
```

**Example Routes:**
- `GET /` → `PageController@home`
- `POST /apply` → `AdmissionController@store`
- `GET /admin/dashboard` → `AdminController@dashboard`
- `POST /chatbot/message` → `ChatbotController@sendMessage`

### 3. **Middleware Execution**
```
StartSession → VerifyCsrfToken → Authenticate → Authorize (Admin) → Localization
```

**Key Middleware:**
- `web`: Session, CSRF, Cookie encryption
- `auth`: Verifies user authentication
- `admin`: Checks if user role is 'admin'
- `localeSessionRedirect`: Handles EN/AR language switching

### 4. **Controller Processing**
```
Controller Method → Validate Input → Execute Business Logic → Interact with Models
```

**Controller Responsibilities:**
- Validate incoming requests
- Call appropriate model methods
- Process business logic
- Prepare data for views
- Return responses (views, JSON, redirects)

**Example: Admission Form Submission**
```php
AdmissionController@store:
1. Validate form data (14 fields)
2. Handle file uploads (4 documents)
3. Create Admission record
4. Associate with authenticated user
5. Set status to 'pending'
6. Send confirmation email
7. Redirect to student portal
```

### 5. **Model Interaction (Eloquent ORM)**
```
Controller → Model Method → SQL Query → Database → Result Set → Model Instance
```

**Eloquent Features Used:**
- **Query Builder**: Fluent interface for queries
- **Relationships**: `belongsTo`, `hasOne`, `hasMany`
- **Accessors/Mutators**: Data transformation
- **Mass Assignment Protection**: `$fillable` arrays
- **Soft Deletes**: Preserve data integrity

**Example Query:**
```php
// Fetch pending admissions with user info
$admissions = Admission::with('user')
    ->where('status', 'pending')
    ->orderBy('created_at', 'desc')
    ->paginate(20);
```

### 6. **Database Execution**
```
Eloquent Query → PDO → MySQL Server → Execute SQL → Fetch Results → Return to Model
```

**Database Operations:**
- `SELECT`: Read data
- `INSERT`: Create records
- `UPDATE`: Modify existing records
- `DELETE`: Remove records (soft/hard delete)
- `JOIN`: Combine related tables

### 7. **View Rendering (Blade Templates)**
```
Controller → Pass Data → Blade Compiler → PHP → HTML → Response
```

**Blade Features:**
- **Template Inheritance**: `@extends`, `@section`, `@yield`
- **Components**: `<x-component-name />`
- **Control Structures**: `@if`, `@foreach`, `@switch`
- **Localization**: `{{ __('messages.key') }}`
- **CSRF**: `@csrf` directive
- **Asset Bundling**: `@vite(['resources/css/app.css'])`

**Example: Dynamic Content Rendering**
```blade
@extends('layouts.app')

@section('content')
    <x-page-header :title="__('messages.events')" />
    
    <div class="container">
        @foreach($events as $event)
            <div class="event-card">
                <h3>{{ $event->title }}</h3>
                <p>{{ $event->description }}</p>
                <span>{{ $event->date }}</span>
            </div>
        @endforeach
    </div>
@endsection
```

### 8. **Response Delivery**
```
HTML → Middleware (reverse order) → HTTP Response → Apache/Nginx → Client Browser
```

**Response Types:**
- **View Response**: Rendered HTML
- **JSON Response**: API endpoints (chatbot)
- **Redirect Response**: After form submissions
- **File Response**: Document downloads
- **Stream Response**: Large file downloads

---

## MVC Component Interactions

### Model → Database
```
Eloquent Model ↔ MySQL Tables
- users ↔ User::class
- admissions ↔ Admission::class
- events ↔ Event::class
- news ↔ News::class
```

### Controller → Model
```
AdmissionController → Admission::create([...])
PageController → Event::latest()->get()
AdminController → Admission::find($id)->update([...])
```

### View → Controller
```
Form Submit → POST /apply → AdmissionController@store
Link Click → GET /events → PageController@events
AJAX Request → POST /chatbot/message → ChatbotController@sendMessage
```

### Controller → View
```
return view('pages.home', [
    'events' => $events,
    'news' => $news,
    'testimonials' => $testimonials
]);
```

---

## Key Laravel Features Used

### 1. **Eloquent ORM**
- Active Record pattern
- Relationship management
- Query scopes
- Model events (creating, created, updating, updated)

### 2. **Blade Templating**
- Template inheritance
- Component-based architecture
- Localization support
- CSRF protection

### 3. **Routing**
- Resource routes: `Route::resource('events', EventsController::class)`
- Route groups with middleware
- Named routes for URL generation
- Localized routes with prefix

### 4. **Middleware**
- Request filtering
- Authentication & authorization
- CSRF protection
- Language switching

### 5. **Validation**
- Form Request classes
- Built-in validation rules
- Custom validation messages
- File upload validation

### 6. **File Storage**
- Local disk storage
- Public disk for uploads
- Image processing
- Secure file handling

### 7. **Mail System**
- Mailable classes
- Email templates
- Queue support (optional)
- SMTP configuration

---

## Technology Stack Summary

### Backend
- **Framework**: Laravel 11.x
- **Language**: PHP 8.2+
- **Database**: MySQL 8.4
- **ORM**: Eloquent
- **Template Engine**: Blade

### Frontend
- **CSS Framework**: Tailwind CSS 3.x
- **JavaScript**: Vanilla JS + Fetch API
- **Icons**: FontAwesome 6.x
- **Build Tool**: Vite 5.x

### External Services
- **AI**: Google Gemini 1.5 Flash (`google-gemini-php/laravel`)
- **Localization**: `mcamara/laravel-localization`
- **Mail**: SMTP (Mailtrap for dev)

### Development Tools
- **Composer**: PHP dependency management
- **NPM**: JavaScript package management
- **Git**: Version control
- **HeidiSQL**: Database management

---

## Design Patterns Implemented

### 1. **MVC Pattern**
- Separation of concerns
- Model handles data
- View handles presentation
- Controller handles logic

### 2. **Repository Pattern** (Implicit via Eloquent)
- Data access abstraction
- Query centralization

### 3. **Facade Pattern**
- Simplified interfaces
- `Route::`, `DB::`, `Gemini::`

### 4. **Service Container**
- Dependency injection
- Automatic resolution

### 5. **Observer Pattern**
- Model events
- Event listeners

---

*Document Version: 1.0*  
*System: NCTU University Portal MVC Architecture*  
*Generated for Figma/FigJam Export*
