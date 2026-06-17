@php
    use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
@endphp

<style>
    /* Hover effect for dropdown items */
    .dropdown-item:hover {
        background-color: #D08301 !important;
        color: #fff !important;
        border-radius: 6px;
        transition: 0.3s;
    }

    /* Dropdown headers spacing */
    .dropdown-menu h5 {
        margin-bottom: 12px;
        font-size: 1.1rem;
    }

    /* Optional: add spacing between links */
    .dropdown-links a {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }

    /* Navbar styling */
    .navbar-light .navbar-nav .nav-link {
        color: #1a096e !important;
        font-weight: 600;
        transition: 0.3s;
        padding: 0.5rem 0.4rem !important;
        font-size: 0.875rem;
    }

    .navbar-light .navbar-nav .nav-link:hover,
    .navbar-light .navbar-nav .nav-link.active {
        color: #D08301 !important;
    }

    /* Adjust navbar container spacing */
    @media (min-width: 992px) {
        .navbar-nav {
            gap: 0;
        }
        
        .navbar-brand {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }
        
        .navbar-collapse {
            padding: 0 !important;
        }
    }

    /* Ensure reader buttons don't take too much space */
    .reader-buttons-container {
        display: flex;
        gap: 0.2rem;
        margin-left: 0.3rem;
    }

    /* Reader buttons styling */
    .reader-btn {
        border: none;
        outline: none;
        font-size: 13px;
        padding: 3px;
        width: 26px;
        height: 26px;
        background: transparent;
        cursor: pointer;
    }

    /* Dashboard icon button styling */
    .dashboard-icon-btn {
        background: transparent !important;
        color: #1a096e !important;
        padding: 0.5rem 0.4rem !important;
        border-radius: 8px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: all 0.3s ease !important;
        border: none !important;
        text-decoration: none !important;
    }

    .dashboard-icon-btn:hover {
        background: rgba(26, 9, 110, 0.1) !important;
        color: #D08301 !important;
        transform: scale(1.05);
    }

    .dashboard-icon-btn i {
        font-size: 16px;
        color: #1a096e !important;
    }

    .dashboard-icon-btn:hover i {
        color: #D08301 !important;
    }

    .dashboard-icon-btn.dropdown-toggle::after {
        display: none;
    }

    /* Desktop: no extra margin */
    @media (min-width: 992px) {
        .dashboard-icon-btn {
            margin-left: 0 !important;
        }
    }

    /* Mobile: center alignment */
    @media (max-width: 991px) {
        .dashboard-icon-btn {
            margin: 10px auto !important;
            display: flex !important;
        }
    }
</style>

<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="{{ route('home') }}" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <img src="{{ asset('img/sub-logo.png') }}" alt="Logo" style="height:50px;">
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">

            <!-- Home -->
            <a href="{{ route('home') }}" class="nav-item nav-link {{ request()->routeIs('home') ? 'active' : '' }}">{{ __('messages.home') }}</a>

            <!-- About Dropdown -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ __('messages.about') }}</a>
                <div class="dropdown-menu fade-down m-0" style="width: 350px; left: 0;">
                    <a class="dropdown-item" href="{{ route('about') }}" style="color: #1a096e;">{{ __('messages.about_nct') }}</a>
                    <a class="dropdown-item" href="{{ route('president') }}" style="color: #1a096e;">{{ __('messages.president') }}</a>
                    <a class="dropdown-item" href="{{ route('dean1') }}" style="color: #1a096e;">{{ __('messages.dean1') }}</a>
                    <a class="dropdown-item" href="{{ route('dean2') }}" style="color: #1a096e;">{{ __('messages.dean2') }}</a>
                    <a class="dropdown-item" href="{{ route('dean3') }}" style="color: #1a096e;">{{ __('messages.dean3') }}</a>
                    <a class="dropdown-item" href="{{ route('campus') }}" style="color: #1a096e;">{{ __('messages.campus_tour') }}</a>
                    <a class="dropdown-item" href="{{ route('internalprotocols') }}" style="color: #1a096e;">{{ __('messages.internal_protocols') }}</a>
                    <a class="dropdown-item" href="{{ route('externalprotocols') }}" style="color: #1a096e;">{{ __('messages.external_protocols') }}</a>
                    <a class="dropdown-item" href="{{ route('reasons') }}" style="color: #1a096e;">{{ __('messages.top_reasons') }}</a>
                    <a class="dropdown-item" href="{{ route('competitions') }}" style="color: #1a096e;">{{ __('messages.competitions') }}</a>
                    <a class="dropdown-item" href="{{ route('graduates') }}" style="color: #1a096e;">{{ __('messages.graduate_achievements') }}</a>
                </div>
            </div>

            <!-- Units Dropdown -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ __('messages.units') }}</a>
                <div class="dropdown-menu fade-down m-0" style="width: 300px; left: 0;">
                    <a class="dropdown-item" href="{{ route('digitaltrans') }}" style="color: #1a096e;">{{ __('messages.digital_transformation') }}</a>
                    <a class="dropdown-item" href="{{ route('internationalcoop') }}" style="color: #1a096e;">{{ __('messages.international_cooperation') }}</a>
                    <a class="dropdown-item" href="{{ route('quality') }}" style="color: #1a096e;">{{ __('messages.quality_assurance') }}</a>
                    <a class="dropdown-item" href="{{ route('evaluation') }}" style="color: #1a096e;">{{ __('messages.measurement_evaluation') }}</a>
                    <a class="dropdown-item" href="{{ route('women') }}" style="color: #1a096e;">{{ __('messages.combat_violence_women') }}</a>
                </div>
            </div>

            <!-- Faculties Dropdown -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ __('messages.faculties') }}</a>
                <div class="dropdown-menu fade-down m-0" style="width: 400px; left: 0;">
                    <a class="dropdown-item" href="{{ route('facultyit') }}" style="color: #1a096e;">{{ __('messages.faculty_it') }}</a>
                    <a class="dropdown-item" href="{{ route('facultyhealth') }}" style="color: #1a096e;">{{ __('messages.faculty_health') }}</a>
                </div>
            </div>

            <!-- Media Center Dropdown -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ __('messages.media_center') }}</a>
                <div class="dropdown-menu fade-down m-0" style="width: 230px; left: 0;">
                    <a class="dropdown-item" href="{{ route('events') }}" style="color: #1a096e;">{{ __('messages.events') }}</a>
                    <a class="dropdown-item" href="{{ route('gallery') }}" style="color: #1a096e;">{{ __('messages.gallery') }}</a>
                    <a class="dropdown-item" href="{{ route('news') }}" style="color: #1a096e;">{{ __('messages.news') }}</a>
                </div>
            </div>

            <!-- Admissions Dropdown -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ __('messages.admissions') }}</a>
                <div class="dropdown-menu fade-down m-0" style="width: 230px; left: 0;">
                    @auth
                        <a class="dropdown-item" href="{{ route('admission.create') }}" style="color: #1a096e;">{{ __('messages.apply_now') }}</a>
                    @else
                        <a class="dropdown-item" href="{{ route('login') }}" style="color: #1a096e;">{{ __('messages.apply_login_required') }}</a>
                    @endauth
                    
                    <a class="dropdown-item" href="{{ route('faculties-requirements') }}" style="color: #1a096e;">{{ __('messages.requirements') }}</a>
                    <a class="dropdown-item" href="{{ route('postgraduate-studies') }}" style="color: #1a096e;">{{ __('messages.postgraduate_programs') }}</a>
                    <a class="dropdown-item" href="{{ route('fees') }}" style="color: #1a096e;">{{ __('messages.tuition_fees') }}</a>
                </div>
            </div>

            <!-- Campus Dropdown -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ __('messages.campus_tour') }}</a>
                <div class="dropdown-menu fade-down m-0" style="width: 230px; left: 0;">
                    <a class="dropdown-item" href="https://enactus.org/" style="color: #1a096e;">{{ __('messages.enactus') }}</a>
                    <a class="dropdown-item" href="{{ route('activities') }}" style="color: #1a096e;">{{ __('messages.student_activities') }}</a>
                </div>
            </div>

            <!-- Staff Services Dropdown -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ __('messages.staff') }}</a>
                <div class="dropdown-menu fade-down m-0" style="width: 270px; left: 0;">
                    <a class="dropdown-item" href="{{ route('login') }}" style="color: #1a096e;">{{ __('messages.staff_lms') }}</a>
                    <a class="dropdown-item" href="https://www.ekb.eg/" style="color: #1a096e;">{{ __('messages.ekb') }}</a>
                </div>
            </div>

            <!-- Student Services Dropdown -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ __('messages.student_services') }}</a>
                <div class="dropdown-menu fade-down m-0" style="width: 230px; left: 0;">
                    <a class="dropdown-item" href="https://sis.nctu.edu.eg/Nctu/Registration/ED_Login.aspx" style="color: #1a096e;">{{ __('messages.students_lms') }}</a>
                    @auth
                        <a class="dropdown-item" href="{{ route('admission.create') }}" style="color: #1a096e;">{{ __('messages.student_affairs') }}</a>
                    @else
                        <a class="dropdown-item" href="{{ route('login') }}" style="color: #1a096e;">{{ __('messages.student_affairs_login') }}</a>
                    @endauth
                    <a class="dropdown-item" href="{{ route('library') }}" style="color: #1a096e;">{{ __('messages.library') }}</a>
                    <a class="dropdown-item" href="{{ route('trainings') }}" style="color: #1a096e;">{{ __('messages.training') }}</a>
                </div>
            </div>

            <!-- Contacts -->
            <a href="{{ route('contact') }}" class="nav-item nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">{{ __('messages.contact') }}</a>

            <!-- Language Toggle -->
            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                @if($localeCode != LaravelLocalization::getCurrentLocale())
                    <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" class="nav-item nav-link" style="color: #D08301 !important; font-weight: 700;">
                        {{ $properties['native'] }}
                    </a>
                @endif
            @endforeach

            <!-- Dashboard/Profile Icon Button (Only visible when logged in) -->
            @auth
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle dashboard-icon-btn" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="{{ auth()->user()->role === 'admin' ? 'Admin Dashboard' : 'My Profile' }}">
                        <i class="fas {{ auth()->user()->role === 'admin' ? 'fa-tachometer-alt' : 'fa-user-circle' }}"></i>
                        <span class="ms-1" style="font-size: 0.875rem;">{{ auth()->user()->name }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end fade-down m-0" style="min-width: 200px;">
                        @if(auth()->user()->role === 'admin')
                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}" style="color: #1a096e;">
                                <i class="fas fa-tachometer-alt me-2"></i>{{ __('messages.dashboard') }}
                            </a>
                        @else
                            <a class="dropdown-item" href="{{ route('student.portal') }}" style="color: #1a096e;">
                                <i class="fas fa-user me-2"></i>{{ __('messages.my_profile') }}
                            </a>
                        @endif
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item" style="color: #1a096e;">
                                <i class="fas fa-sign-out-alt me-2"></i>{{ __('messages.logout') }}
                            </button>
                        </form>
                    </div>
                </div>
            @endauth

        </div>

        <!-- Reader Buttons -->
        <div class="reader-buttons-container">
            <button class="reader-btn play" onclick="readPage()">🔊</button>
            <button class="reader-btn stop" onclick="stopReading()">⏹</button>
        </div>
    </div>
</nav>
