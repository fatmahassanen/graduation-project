<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found - {{ config('app.name', 'New Cairo University of Technology') }}</title>
    
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    
    {{-- Google Web Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">
    
    {{-- Icon Font Stylesheet --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    
    {{-- Customized Bootstrap Stylesheet --}}
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    
    {{-- Template Stylesheet --}}
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>
    {{-- Navbar --}}
    <x-navbar :currentPage="''" :language="app()->getLocale()" />
    
    {{-- 404 Error Section --}}
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <i class="bi bi-exclamation-triangle display-1" style="color: #D08301;"></i>
                    <h1 class="display-1">404</h1>
                    <h1 class="mb-4">Page Not Found</h1>
                    <p class="mb-4">
                        We're sorry, the page you have looked for does not exist on our website! 
                        Maybe go to our home page or try to use a search?
                    </p>
                    <a class="btn btn-primary py-3 px-5" href="{{ route('home') }}" style="background: #D08301; border-color: #D08301;">
                        Go Back To Home
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Footer --}}
    <x-footer />
    
    {{-- JavaScript Libraries --}}
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
