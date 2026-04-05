<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- SEO Meta Tags --}}
    <title>{{ $metaTitle ?? config('app.name', 'New Cairo University of Technology') }}</title>
    <meta name="description" content="{{ $metaDescription ?? '' }}">
    <meta name="keywords" content="{{ $metaKeywords ?? '' }}">
    
    {{-- Open Graph Tags --}}
    @if(isset($ogImage))
    <meta property="og:image" content="{{ $ogImage }}">
    @endif
    <meta property="og:title" content="{{ $metaTitle ?? config('app.name') }}">
    <meta property="og:description" content="{{ $metaDescription ?? '' }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    
    {{-- Canonical URL --}}
    <link rel="canonical" href="{{ url()->current() }}">
    
    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    
    {{-- Google Web Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">
    
    {{-- Icon Font Stylesheet --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    
    {{-- Libraries Stylesheet --}}
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    
    {{-- Customized Bootstrap Stylesheet --}}
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    
    {{-- Template Stylesheet --}}
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    
    {{-- RTL Stylesheet for Arabic (loaded from resources/css) --}}
    @if(app()->getLocale() === 'ar')
        <style>
            /* RTL (Right-to-Left) Styles for Arabic Language */
            [dir="rtl"] body { text-align: right; }
            [dir="rtl"] .navbar-nav { margin-right: auto; margin-left: 0; }
            [dir="rtl"] .navbar-brand { padding-right: 0; padding-left: 1rem; }
            [dir="rtl"] .dropdown-menu { right: 0; left: auto; text-align: right; }
            [dir="rtl"] .dropdown-menu-end { right: auto; left: 0; }
            [dir="rtl"] .btn i, [dir="rtl"] .nav-link i { margin-left: 0.5rem; margin-right: 0; }
            [dir="rtl"] .card-body { text-align: right; }
            [dir="rtl"] ul, [dir="rtl"] ol { padding-right: 2rem; padding-left: 0; }
            [dir="rtl"] .form-label { text-align: right; }
            [dir="rtl"] .form-check { padding-right: 1.5em; padding-left: 0; }
            [dir="rtl"] .form-check-input { float: right; margin-right: -1.5em; margin-left: 0; }
            [dir="rtl"] .alert { text-align: right; }
            [dir="rtl"] .alert-dismissible .btn-close { left: 0; right: auto; }
        </style>
    @endif
    
    @stack('styles')
</head>

<body>
    {{-- Navbar --}}
    <x-navbar :currentPage="$currentPage ?? ''" :language="app()->getLocale()" />
    
    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>
    
    {{-- Footer --}}
    <x-footer />
    
    {{-- JavaScript Libraries --}}
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
    
    {{-- Template Javascript --}}
    <script src="{{ asset('js/main.js') }}"></script>
    
    @stack('scripts')
</body>

</html>
