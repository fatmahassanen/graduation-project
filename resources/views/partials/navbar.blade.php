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
    }

    .dashboard-icon-btn:hover {
        background: rgba(26, 9, 110, 0.1) !important;
        color: #D08301 !important;
        transform: scale(1.1);
    }

    .dashboard-icon-btn i {
        font-size: 16px;
        color: #1a096e !important;
    }

    .dashboard-icon-btn:hover i {
        color: #D08301 !important;
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
        <img src="{{ asset('uni/img.png') }}" alt="Logo" style="height:50px;">
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">

            <!-- Home -->
            <a href="{{ route('home') }}" class="nav-item nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>

            <!-- About Dropdown -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">About</a>
                <div class="dropdown-menu fade-down m-0" style="width: 350px; left: 0;">
                    <a class="dropdown-item" href="{{ route('about') }}" style="color: #1a096e;">About NCT</a>
                    <a class="dropdown-item" href="{{ route('president') }}" style="color: #1a096e;">University President</a>
                    <a class="dropdown-item" href="{{ route('dean1') }}" style="color: #1a096e;">Dean of Industrial & Energy Technology</a>
                    <a class="dropdown-item" href="{{ route('dean2') }}" style="color: #1a096e;">Dean of Applied Health Sciences Technology</a>
                    <a class="dropdown-item" href="{{ route('dean3') }}" style="color: #1a096e;">Students Affairs Vice Dean</a>
                    <a class="dropdown-item" href="{{ route('campus') }}" style="color: #1a096e;">Campus Tour</a>
                    <a class="dropdown-item" href="{{ route('internalprotocols') }}" style="color: #1a096e;">Internal Protocols</a>
                    <a class="dropdown-item" href="{{ route('externalprotocols') }}" style="color: #1a096e;">External Protocols</a>
                    <a class="dropdown-item" href="{{ route('reasons') }}" style="color: #1a096e;">Top 10 Reasons</a>
                    <a class="dropdown-item" href="{{ route('competitions') }}" style="color: #1a096e;">Competitions</a>
                    <a class="dropdown-item" href="{{ route('graduates') }}" style="color: #1a096e;">Graduate Achievements</a>
                </div>
            </div>

            <!-- Units Dropdown -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">Units</a>
                <div class="dropdown-menu fade-down m-0" style="width: 300px; left: 0;">
                    <a class="dropdown-item" href="{{ route('digitaltrans') }}" style="color: #1a096e;">Digital Transformation</a>
                    <a class="dropdown-item" href="{{ route('internationalcoop') }}" style="color: #1a096e;">International Cooperation</a>
                    <a class="dropdown-item" href="{{ route('quality') }}" style="color: #1a096e;">Quality Assurance</a>
                    <a class="dropdown-item" href="{{ route('evaluation') }}" style="color: #1a096e;">Measurement and Evaluation</a>
                    <a class="dropdown-item" href="{{ route('women') }}" style="color: #1a096e;">Combating Violence Against Women</a>
                </div>
            </div>

            <!-- Faculties Dropdown -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">Faculties</a>
                <div class="dropdown-menu fade-down m-0" style="width: 400px; left: 0;">
                    <a class="dropdown-item" href="{{ route('facultyit') }}" style="color: #1a096e;">Faculty of Industrial and Energy Technology</a>
                    <a class="dropdown-item" href="{{ route('facultyhealth') }}" style="color: #1a096e;">Faculty of Applied Health Sciences Technology</a>
                </div>
            </div>

            <!-- Media Center Dropdown -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">Media</a>
                <div class="dropdown-menu fade-down m-0" style="width: 230px; left: 0;">
                    <a class="dropdown-item" href="{{ route('events') }}" style="color: #1a096e;">Events</a>
                    <a class="dropdown-item" href="{{ route('gallery') }}" style="color: #1a096e;">Gallery</a>
                    <a class="dropdown-item" href="{{ route('news') }}" style="color: #1a096e;">News</a>
                </div>
            </div>

            <!-- Admissions Dropdown -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">Admissions</a>
                <div class="dropdown-menu fade-down m-0" style="width: 230px; left: 0;">
                    @auth
                        <a class="dropdown-item" href="{{ route('admission.create') }}" style="color: #1a096e;">Apply for Admission</a>
                    @else
                        <a class="dropdown-item" href="{{ route('login') }}" style="color: #1a096e;">Apply for Admission (Login Required)</a>
                    @endauth
                    
                    <a class="dropdown-item" href="{{ route('faculties-requirements') }}" style="color: #1a096e;">Faculties Requirements</a>
                    <a class="dropdown-item" href="{{ route('postgraduate-studies') }}" style="color: #1a096e;">Postgraduate Programs</a>
                    <a class="dropdown-item" href="{{ route('fees') }}" style="color: #1a096e;">Tuition Fees & Scholarships</a>
                </div>
            </div>

            <!-- Campus Dropdown -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">Campus</a>
                <div class="dropdown-menu fade-down m-0" style="width: 230px; left: 0;">
                    <a class="dropdown-item" href="https://enactus.org/" style="color: #1a096e;">Enactus</a>
                    <!-- <a class="dropdown-item" href="{{ route('entrepreneur') }}" style="color: #1a096e;">Entrepreneur</a> -->
                    <a class="dropdown-item" href="{{ route('activities') }}" style="color: #1a096e;">Student Activities</a>
                </div>
            </div>

            <!-- Staff Services Dropdown -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">Staff</a>
                <div class="dropdown-menu fade-down m-0" style="width: 270px; left: 0;">
                    <a class="dropdown-item" href="{{ route('login') }}" style="color: #1a096e;">Staff LMS</a>
                    {{-- <a class="dropdown-item" href="{{ route('profile') }}" style="color: #1a096e;">Profile</a> --}}
                    <!-- <a class="dropdown-item" href="{{ route('members') }}" style="color: #1a096e;">Staff Members</a> -->
                    <a class="dropdown-item" href="https://www.ekb.eg/" style="color: #1a096e;">Egyptian Knowledge Bank- EKB</a>
                </div>
            </div>

            <!-- Student Services Dropdown -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">Student Services</a>
                <div class="dropdown-menu fade-down m-0" style="width: 230px; left: 0;">
                    <a class="dropdown-item" href="https://sis.nctu.edu.eg/Nctu/Registration/ED_Login.aspx" style="color: #1a096e;">Students LMS</a>
                    @auth
                        <a class="dropdown-item" href="{{ route('admission.create') }}" style="color: #1a096e;">Student Affairs</a>
                    @else
                        <a class="dropdown-item" href="{{ route('login') }}" style="color: #1a096e;">Student Affairs (Login Required)</a>
                    @endauth
                    <a class="dropdown-item" href="{{ route('library') }}" style="color: #1a096e;">Library</a>
                    <a class="dropdown-item" href="{{ route('trainings') }}" style="color: #1a096e;">Training</a>
                </div>
            </div>

            <!-- Contacts -->
            <a href="{{ route('contact') }}" class="nav-item nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contacts</a>

            <!-- Dashboard/Profile Icon Button (Only visible when logged in) -->
            @auth
                @if(auth()->user()->role === 'admin')
                    <!-- Admin Dashboard Icon -->
                    <a href="{{ route('admin.dashboard') }}" class="nav-item nav-link dashboard-icon-btn" title="Admin Dashboard">
                        <i class="fas fa-tachometer-alt"></i>
                    </a>
                @else
                    <!-- Student Profile Icon -->
                    <a href="{{ route('student.portal') }}" class="nav-item nav-link dashboard-icon-btn" title="My Profile">
                        <i class="fas fa-user-circle"></i>
                    </a>
                @endif
            @endauth

        </div>

        <!-- Reader Buttons -->
        <div class="reader-buttons-container">
            <button class="reader-btn play" onclick="readPage()">🔊</button>
            <button class="reader-btn stop" onclick="stopReading()">⏹</button>
        </div>
    </div>
</nav>
