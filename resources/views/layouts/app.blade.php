<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'NCTU'))</title>
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- University Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/sub-sub-logo.png') }}?v=3">
    <link rel="apple-touch-icon" href="{{ asset('img/sub-sub-logo.png') }}">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Bootstrap 5.3.0 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- RTL Support for Arabic -->
    @if(app()->getLocale() == 'ar')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body {
            direction: rtl !important;
            text-align: right !important;
            font-family: 'Cairo', 'Segoe UI', sans-serif !important;
        }
        .navbar-nav {
            margin-right: auto !important;
            margin-left: 0 !important;
        }
        .navbar-nav .dropdown-menu {
            text-align: right !important;
            right: 0 !important;
            left: auto !important;
        }
        .reader-buttons-container {
            margin-right: 0.3rem;
            margin-left: 0;
        }
        .float-end {
            float: left !important;
        }
        .float-start {
            float: right !important;
        }
        .text-end {
            text-align: left !important;
        }
        .text-start {
            text-align: right !important;
        }
        .pe-5 {
            padding-left: 3rem !important;
            padding-right: 0 !important;
        }
        .ps-5 {
            padding-right: 3rem !important;
            padding-left: 0 !important;
        }
        .me-auto {
            margin-left: auto !important;
            margin-right: 0 !important;
        }
        .ms-auto {
            margin-right: auto !important;
            margin-left: 0 !important;
        }
        .pe-3 {
            padding-left: 1rem !important;
            padding-right: 0 !important;
        }
        .ps-3 {
            padding-right: 1rem !important;
            padding-left: 0 !important;
        }
    </style>
    @endif

    @stack('styles')
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Page Content -->
    @yield('content')

    <!-- Footer -->
    @include('partials.footer')

    <!-- Back to Top -->
    <!-- <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a> -->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/reader.js') }}"></script>

    @stack('scripts')

    <!-- AI Chatbot -->
    @include('components.chatbot')
</body>
</html>
