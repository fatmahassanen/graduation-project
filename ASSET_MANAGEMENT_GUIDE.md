# 🎨 Asset Management Guide

## Overview

This document provides best practices for loading and managing assets (images, icons, CSS, JavaScript) in the NCTU Digital Campus Platform to ensure **zero broken links** and maximum reliability.

---

## ✅ Best Practices

### **1. Use CDN for Third-Party Libraries**

**Recommended for:**
- Icon libraries (FontAwesome)
- CSS frameworks (Tailwind CSS, Bootstrap)
- JavaScript libraries (jQuery, Alpine.js)

**Why CDN?**
- ✅ 99.9% uptime guarantee
- ✅ Global edge caching (faster load times)
- ✅ Automatic version updates
- ✅ Reduces server bandwidth costs
- ✅ No local file maintenance

**Implementation:**

```html
<!-- ✅ CORRECT: FontAwesome from CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css">

<!-- ✅ CORRECT: Tailwind CSS from CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- ✅ CORRECT: Bootstrap from CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
```

**Current CDN Assets in Use:**
- FontAwesome 5.10.0: `https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css`
- Tailwind CSS: `https://cdn.tailwindcss.com`
- Bootstrap 5: `https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css`
- jQuery 3.7.1: `https://code.jquery.com/jquery-3.7.1.min.js`

---

### **2. Use Laravel's `asset()` Helper for Local Files**

**For files in `/public` directory:**

```php
// ✅ CORRECT: Logo in public/img/
<img src="{{ asset('img/logo.png') }}" alt="Logo">

// ✅ CORRECT: CSS in public/css/
<link rel="stylesheet" href="{{ asset('css/student-portal.css') }}">

// ✅ CORRECT: JavaScript in public/js/
<script src="{{ asset('js/main.js') }}"></script>

// ❌ INCORRECT: Hardcoded path (breaks if app is in subdirectory)
<img src="/img/logo.png" alt="Logo">
```

**Why use `asset()` helper?**
- ✅ Automatically handles subdirectory installations
- ✅ Works with `APP_URL` configuration
- ✅ Supports HTTPS/HTTP switching
- ✅ Cache-busting via version hashing (with Mix/Vite)

---

### **3. Use Model's `fileUrl()` Method for User Uploads**

**For files uploaded by users (stored in `storage/app/public/` or `public/uploads/`):**

```php
// ✅ CORRECT: Using Admission model's fileUrl() method
<img src="{{ $admission->fileUrl($admission->student_photo) }}" alt="Student Photo">

// ❌ INCORRECT: Direct asset() without checking storage location
<img src="{{ asset('storage/' . $admission->student_photo) }}" alt="Photo">

// ❌ INCORRECT: Missing storage prefix
<img src="{{ asset($admission->student_photo) }}" alt="Photo">
```

**Why use `fileUrl()` method?**
- ✅ Handles mixed storage conventions automatically
- ✅ Works with both `public/uploads/` and `storage/app/public/`
- ✅ Strips duplicate path segments (e.g., `public/public/`)
- ✅ Returns `null` safely for missing images

---

## 🔧 Storage Architecture

### **Directory Structure**

```
public/
├── img/                    ← Static institutional images (logos, banners)
├── uploads/                ← User-uploaded images (processed by ImageProcessor)
├── css/                    ← Custom stylesheets
├── js/                     ← Custom JavaScript
└── storage/                ← Symlink to storage/app/public/ (Laravel)

storage/
└── app/
    └── public/
        └── admissions/     ← Admission documents (PDF certificates)
            └── documents/
```

### **Storage Conventions**

| Location | Use Case | Access Method |
|----------|----------|---------------|
| `public/img/` | Static images (logos, department photos) | `asset('img/filename.jpg')` |
| `public/uploads/` | User-uploaded photos (processed) | `asset('uploads/filename.jpg')` |
| `storage/app/public/admissions/` | Admission documents (PDFs) | `asset('storage/admissions/documents/file.pdf')` |

---

## 📝 Implementation Examples

### **Example 1: Static Logo (Navbar)**

```blade
{{-- resources/views/partials/navbar.blade.php --}}
<nav class="navbar">
    <a href="{{ route('home') }}" class="navbar-brand">
        <img src="{{ asset('img/sub-sub-logo.png') }}" alt="NCTU Logo" style="height:50px;">
    </a>
</nav>
```

### **Example 2: Student Photo in Admin Panel**

```blade
{{-- resources/views/admin/admissions/rejected.blade.php --}}
@if($admission->student_photo)
    <img src="{{ $admission->fileUrl($admission->student_photo) }}" 
         alt="Photo" 
         class="w-10 h-10 rounded-full object-cover">
@else
    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
        <i class="fas fa-user text-red-600"></i>
    </div>
@endif
```

### **Example 3: Department Images (Dynamic Content)**

```blade
{{-- resources/views/pages/home.blade.php --}}
@foreach($departments as $dept)
    <div class="dept-card">
        <div class="dept-card-img">
            <img src="{{ asset($dept->image) }}" alt="{{ $dept->name }}">
        </div>
    </div>
@endforeach
```

---

## 🛠️ Troubleshooting Broken Images

### **Symptom: Broken image icon in admin panel**

**Possible Causes:**
1. Incorrect storage path in database
2. Missing `storage` symlink
3. Wrong asset helper usage

**Solution Steps:**

```bash
# Step 1: Verify storage symlink exists
php artisan storage:link

# Step 2: Check file permissions
chmod -R 755 public/uploads
chmod -R 755 storage/app/public

# Step 3: Verify image exists
ls -la public/uploads/

# Step 4: Use model's fileUrl() method in blade views
# Change from:
<img src="{{ asset('storage/' . $admission->student_photo) }}">

# To:
<img src="{{ $admission->fileUrl($admission->student_photo) }}">
```

### **Symptom: Icons not displaying (FontAwesome)**

**Possible Causes:**
1. CDN blocked by firewall/ad-blocker
2. Incorrect icon class names
3. CDN link outdated

**Solution:**

```html
<!-- ✅ Use specific version from reliable CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css">

<!-- ✅ Correct icon usage -->
<i class="fas fa-user"></i>        <!-- Solid style -->
<i class="far fa-user"></i>        <!-- Regular style -->
<i class="fab fa-facebook"></i>    <!-- Brands -->

<!-- ❌ Incorrect (missing style prefix) -->
<i class="fa-user"></i>
```

---

## 🚀 Production Optimization

### **Image Optimization**

The platform uses `ImageProcessor` for smart image handling:

```php
// app/Support/ImageProcessor.php
public static function storeUploadedImage(
    UploadedFile $file,
    bool $wasCropped,
    int $size = 400,
    ?string $oldPath = null
): string {
    $manager = ImageManager::usingDriver(Driver::class);
    $image = $manager->decode($file);
    
    if ($wasCropped) {
        $image->scale(width: $size);
    }
    
    // Convert to JPEG with 80% quality
    $encoded = $image->encodeUsingFormat(Format::JPEG, quality: 80);
    
    // Store in public/uploads/
    $filename = time().'_'.uniqid().'.jpg';
    $relativePath = 'uploads/'.$filename;
    
    return $relativePath; // Returns: "uploads/1234567890_abc123.jpg"
}
```

**Benefits:**
- ✅ Automatic JPEG conversion (smaller file sizes)
- ✅ Quality optimization (80% balance)
- ✅ Unique filenames prevent cache issues
- ✅ Old image cleanup on updates

### **CSS/JS Minification**

```bash
# Production asset build (uses Vite)
npm run build

# Generates minified files:
# public/build/assets/app-[hash].css
# public/build/assets/app-[hash].js
```

---

## ✅ Checklist for Developers

Before deploying, ensure:

- [ ] All CDN links use HTTPS
- [ ] All local assets use `{{ asset() }}` helper
- [ ] User uploads use model's `fileUrl()` method
- [ ] `php artisan storage:link` executed
- [ ] File permissions set correctly (`755` for directories, `644` for files)
- [ ] Images optimized (< 500KB for photos, < 100KB for thumbnails)
- [ ] No hardcoded `/public/` or `/storage/` paths in code
- [ ] Fallback placeholders for missing images

---

## 📞 Support

For asset-related issues, contact:
- **Technical Lead**: admin@nctu.edu.eg
- **Documentation**: `README.md` and this file

---

**Last Updated**: 2026  
**Platform Version**: 1.0.0  
**Maintained By**: NCTU Development Team
