<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Application - {{ config('app.name') }}</title>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Student Portal CSS -->
    <link rel="stylesheet" href="{{ asset('css/student-portal.css') }}">

    <style>
        /* Modern Navbar Styles */
        .navbar-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .navbar-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: white;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
            font-size: 16px;
            border: 2px solid white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            margin-top: 0.5rem;
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            min-width: 220px;
            z-index: 50;
            overflow: hidden;
        }

        .dropdown-menu.show {
            display: block;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-item {
            padding: 0.75rem 1.25rem;
            display: flex;
            align-items: center;
            color: #374151;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .dropdown-item i {
            width: 20px;
            margin-right: 0.75rem;
        }

        .status-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 0.5rem;
        }

        .status-pending { background: #fbbf24; }
        .status-accepted { background: #10b981; }
        .status-rejected { background: #ef4444; }

        .mobile-menu {
            display: none;
        }

        @media (max-width: 768px) {
            .desktop-menu {
                display: none;
            }

            .mobile-menu {
                display: block;
            }

            .mobile-menu-content {
                display: none;
                background: white;
                border-radius: 0.75rem;
                margin-top: 1rem;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .mobile-menu-content.show {
                display: block;
                animation: slideDown 0.3s ease;
            }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <!-- Modern Premium Navbar -->
    <nav class="navbar-gradient navbar-shadow sticky top-0 z-40 no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-lg">
                            <i class="fas fa-graduation-cap text-purple-600 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <h1 class="text-white font-bold text-lg leading-tight">Student Portal</h1>
                            {{-- <!-- <p class="text-purple-200 text-xs">{{ config('app.name') }}</p> --> --}}
                        </div>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <div class="desktop-menu flex items-center space-x-6">
                    <!-- Navigation Links -->
                    <a href="{{ route('home') }}" class="nav-link text-white hover:text-purple-100 font-medium flex items-center">
                        <i class="fas fa-home mr-2"></i>
                        <span>Home</span>
                    </a>

                    @if($admission)
                    <a href="{{ route('student.portal') }}" class="nav-link text-white hover:text-purple-100 font-medium flex items-center">
                        <i class="fas fa-file-alt mr-2"></i>
                        <span>My Application</span>
                    </a>
                    @endif

                    <!-- User Dropdown -->
                    <div class="relative">
                        <button onclick="toggleDropdown()" class="flex items-center space-x-3 focus:outline-none">
                            <div class="user-avatar">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="text-left hidden lg:block">
                                <p class="text-white font-semibold text-sm">{{ auth()->user()->name }}</p>
                                @if($admission)
                                <p class="text-purple-200 text-xs flex items-center">
                                    <span class="status-indicator status-{{ $admission->status }}"></span>
                                    {{ ucfirst($admission->status) }}
                                </p>
                                @endif
                            </div>
                            <i class="fas fa-chevron-down text-white text-sm"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="userDropdown" class="dropdown-menu">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                            </div>

                             <a href="{{ route('student.portal') }}" class="dropdown-item">
                                <i class="fas fa-user"></i>
                                <span>My Profile</span>
                            </a>

                              @if($admission)
                            <a href="{{ route('student.portal') }}" class="dropdown-item">
                                <i class="fas fa-file-alt"></i>
                                <span>Application Status</span>
                            </a>
                            @else
                             <a href="{{ route('admission.create') }}" class="dropdown-item">
                                <i class="fas fa-plus-circle"></i>
                                <span>Submit Application</span>
                            </a>
                            @endif

                            <div class="border-t border-gray-100"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item w-full text-left text-red-600 hover:text-white">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="mobile-menu">
                    <button onclick="toggleMobileMenu()" class="text-white focus:outline-none">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu Content -->


             <div id="mobileMenu" class="mobile-menu-content">
                <div class="p-4">

                    {{-- <div class="flex items-center space-x-3 pb-4 border-b border-gray-200">
                        <div class="user-avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                            @if($admission)
                            <p class="text-xs flex items-center mt-1">
                                <span class="status-indicator status-{{ $admission->status }}"></span>
                                {{ ucfirst($admission->status) }}
                            </p>
                            @endif
                        </div>
                    </div> --}}


                    {{-- <div class="py-2">
                        <a href="{{ route('home') }}" class="dropdown-item">
                            <i class="fas fa-home"></i>
                            <span>Home</span>
                        </a>

                        <a href="{{ route('student.portal') }}" class="dropdown-item">
                            <i class="fas fa-user"></i>
                            <span>My Profile</span>
                        </a>

                        @if($admission)
                        <a href="{{ route('student.portal') }}" class="dropdown-item">
                            <i class="fas fa-file-alt"></i>
                            <span>Application Status</span>
                        </a>
                        @else
                        <a href="{{ route('admission.create') }}" class="dropdown-item">
                            <i class="fas fa-plus-circle"></i>
                            <span>Submit Application</span>
                        </a>
                        @endif

                        <div class="border-t border-gray-100 my-2"></div> --}}

                        <!-- <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item w-full text-left text-red-600">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </button>
                        </form> -->
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg no-print">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 text-2xl mr-3"></i>
                    <p class="text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(!$admission)
            <!-- Empty State: No Application -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 px-8 py-16 text-center">
                    <div class="inline-block p-6 bg-white bg-opacity-20 rounded-full mb-6">
                        <i class="fas fa-file-alt text-white text-6xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-white mb-4">Welcome to Your Student Portal</h2>
                    <p class="text-white text-opacity-90 text-lg mb-8">You haven't submitted an application yet. Start your journey with us today!</p>
                </div>
                
                <div class="p-12 text-center">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Ready to Apply?</h3>
                    <p class="text-gray-600 mb-8 max-w-2xl mx-auto">
                        Complete your admission application in just a few steps. Our easy-to-use form will guide you through the process.
                    </p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10 max-w-4xl mx-auto">
                        <div class="p-6 bg-blue-50 rounded-lg">
                            <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-user text-white text-xl"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2">Personal Info</h4>
                            <p class="text-sm text-gray-600">Provide your basic information and contact details</p>
                        </div>
                        
                        <div class="p-6 bg-green-50 rounded-lg">
                            <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-file-upload text-white text-xl"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2">Upload Documents</h4>
                            <p class="text-sm text-gray-600">Submit required certificates and identification</p>
                        </div>
                        
                        <div class="p-6 bg-purple-50 rounded-lg">
                            <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-check-circle text-white text-xl"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2">Submit & Track</h4>
                            <p class="text-sm text-gray-600">Submit your application and track its status</p>
                        </div>
                    </div>
                    
                    <a href="{{ route('admission.create') }}" 
                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-lg font-bold rounded-lg hover:from-blue-700 hover:to-indigo-700 transform hover:scale-105 transition duration-200 shadow-lg">
                        <i class="fas fa-rocket mr-3"></i>
                        Start New Application
                    </a>
                    
                    <p class="text-sm text-gray-500 mt-6">
                        <i class="fas fa-save mr-1"></i> You can save your progress as a draft and continue later
                    </p>
                </div>
            </div>
        @elseif($isDraft)
            <!-- Draft State: Continue Application -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-yellow-500 to-orange-500 px-8 py-12 text-center">
                    <div class="inline-block p-6 bg-white bg-opacity-20 rounded-full mb-6">
                        <i class="fas fa-edit text-white text-6xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-white mb-4">Continue Your Application</h2>
                    <p class="text-white text-opacity-90 text-lg mb-8">You have a draft application saved. Pick up where you left off!</p>
                </div>
                
                <div class="p-8 text-center">
                    <div class="mb-6">
                        <p class="text-gray-700 text-lg mb-2">Current Progress: <strong>Step {{ $admission->current_step }} of 4</strong></p>
                        <div class="w-full bg-gray-200 rounded-full h-4 max-w-md mx-auto">
                            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 h-4 rounded-full transition-all duration-300" 
                                 style="width: {{ ($admission->current_step / 4) * 100 }}%"></div>
                        </div>
                    </div>
                    
                    <a href="{{ route('admission.create') }}" 
                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-yellow-500 to-orange-500 text-white text-lg font-bold rounded-lg hover:from-yellow-600 hover:to-orange-600 transform hover:scale-105 transition duration-200 shadow-lg">
                        <i class="fas fa-edit mr-3"></i>
                        Continue Application
                    </a>
                    
                    <p class="text-sm text-gray-500 mt-6">
                        Last saved: {{ $admission->updated_at->diffForHumans() }}
                    </p>
                </div>
            </div>
        @elseif($admission)
            <!-- Digital ID Card Header -->
            <div class="info-card mb-8">
                <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 px-8 py-12 text-center">
                    <!-- Student Photo -->
                    @if($admission->student_photo)
                        <img src="{{ asset('img/' . $admission->student_photo) }}" alt="Student Photo" class="student-photo-frame">
                    @else
                        <div class="photo-placeholder">
                            <i class="fas fa-user text-white text-5xl"></i>
                        </div>
                    @endif

                    <!-- Student Name -->
                    <h2 class="text-3xl font-bold text-white mt-6 mb-2">{{ $admission->full_name }}</h2>

                    <!-- National ID -->
                    <p class="text-white text-opacity-90 font-mono text-lg mb-4">
                        <i class="fas fa-id-card mr-2"></i>{{ $admission->national_id }}
                    </p>

                    <!-- Status Badge -->
                    <div class="mt-6">
                        @if($admission->status === 'pending')
                            <div class="status-badge status-pending">
                                <i class="fas fa-clock mr-2"></i>
                                Application Under Review
                            </div>
                        @elseif($admission->status === 'accepted')
                            <div class="status-badge status-accepted">
                                <i class="fas fa-check-circle mr-2"></i>
                                Accepted
                            </div>
                        @elseif($admission->status === 'rejected')
                            <div class="status-badge status-rejected">
                                <i class="fas fa-times-circle mr-2"></i>
                                Rejected
                            </div>
                        @endif
                    </div>

                    <!-- Student Code (if accepted) -->
                    @if($admission->status === 'accepted' && $admission->student_code)
                        <div class="mt-6 max-w-md mx-auto">
                            <p class="text-white text-sm mb-2">Student Code</p>
                            <div class="student-code bg-white bg-opacity-20 text-white border-2 border-white">
                                {{ $admission->student_code }}
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Status Message -->
                <div class="p-6">
                    @if($admission->status === 'pending')
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                            <p class="text-yellow-800">
                                <i class="fas fa-info-circle mr-2"></i>
                                Your application is being reviewed by our admissions team. We'll notify you via email once a decision is made.
                            </p>
                        </div>
                    @elseif($admission->status === 'accepted')
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
                            <p class="text-green-800 font-semibold text-lg">
                                <i class="fas fa-envelope mr-2"></i>
                                Congratulations! Check your email for your Student Code.
                            </p>
                        </div>
                    @elseif($admission->status === 'rejected')
                        @if($admission->rejection_reason)
                            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded mb-4">
                                <p class="text-sm font-semibold text-red-800 mb-2">Rejection Reason:</p>
                                <p class="text-red-700">{{ $admission->rejection_reason }}</p>
                            </div>
                        @endif
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                            <p class="text-blue-800 mb-3">
                                <i class="fas fa-info-circle mr-2"></i>
                                You can re-apply by fixing the issues mentioned above. Your previous data will be auto-filled to save time.
                            </p>
                            <a href="{{ route('admission.create') }}"
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition font-semibold shadow-lg">
                                <i class="fas fa-redo mr-2"></i>
                                Re-apply Now
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Personal Information Card -->
                <div class="info-card">
                    <div class="card-header-gradient card-header-blue">
                        <h3 class="text-xl font-bold flex items-center">
                            <i class="fas fa-user-circle mr-3"></i>
                            Personal Information
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="info-row">
                            <div class="info-icon">
                                <i class="fas fa-id-card"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">National ID</div>
                                <div class="info-value font-mono">{{ $admission->national_id }}</div>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Email</div>
                                <div class="info-value">{{ $admission->email }}</div>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Phone</div>
                                <div class="info-value">{{ $admission->phone }}</div>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-icon">
                                <i class="fas fa-birthday-cake"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Birth Date</div>
                                <div class="info-value">{{ $admission->birth_date->format('M d, Y') }}</div>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-icon">
                                <i class="fas fa-venus-mars"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Gender</div>
                                <div class="info-value">{{ ucfirst($admission->gender) }}</div>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-icon">
                                <i class="fas fa-pray"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Religion</div>
                                <div class="info-value">{{ $admission->religion }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Information Card -->
                <div class="info-card">
                    <div class="card-header-gradient card-header-green">
                        <h3 class="text-xl font-bold flex items-center">
                            <i class="fas fa-map-marker-alt mr-3"></i>
                            Address Information
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="info-row">
                            <div class="info-icon">
                                <i class="fas fa-map-pin"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Birth Governorate</div>
                                <div class="info-value">{{ $admission->birth_governorate }}</div>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-icon">
                                <i class="fas fa-building"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Current Governorate</div>
                                <div class="info-value">{{ $admission->current_governorate }}</div>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-icon">
                                <i class="fas fa-city"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">City/Center</div>
                                <div class="info-value">{{ $admission->city_center }}</div>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Village/District</div>
                                <div class="info-value">{{ $admission->village_district }}</div>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-icon">
                                <i class="fas fa-road"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Street Address</div>
                                <div class="info-value">{{ $admission->street_address }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Parent/Guardian Information Card -->
                <div class="info-card">
                    <div class="card-header-gradient card-header-purple">
                        <h3 class="text-xl font-bold flex items-center">
                            <i class="fas fa-users mr-3"></i>
                            Parent/Guardian Information
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="info-row">
                            <div class="info-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Parent Name</div>
                                <div class="info-value">{{ $admission->parent_name }}</div>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Parent Phone</div>
                                <div class="info-value">{{ $admission->parent_phone }}</div>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-icon">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Father's Occupation</div>
                                <div class="info-value">{{ $admission->father_occupation }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documents Card -->
                <div class="info-card">
                    <div class="card-header-gradient">
                        <h3 class="text-xl font-bold flex items-center">
                            <i class="fas fa-file-alt mr-3"></i>
                            Uploaded Documents
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="document-item">
                            <div class="document-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="document-info">
                                <div class="document-name">Birth Certificate</div>
                                <div class="document-date">Uploaded: {{ $admission->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>

                        <div class="document-item">
                            <div class="document-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="document-info">
                                <div class="document-name">Qualification Certificate</div>
                                <div class="document-date">Uploaded: {{ $admission->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>

                        <div class="document-item">
                            <div class="document-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="document-info">
                                <div class="document-name">Student ID Document</div>
                                <div class="document-date">Uploaded: {{ $admission->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>

                        <div class="document-item">
                            <div class="document-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="document-info">
                                <div class="document-name">Parent ID Document</div>
                                <div class="document-date">Uploaded: {{ $admission->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>

                        <div class="document-item">
                            <div class="document-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="document-info">
                                <div class="document-name">Student Photo</div>
                                <div class="document-date">Uploaded: {{ $admission->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timeline Card -->
                <div class="info-card lg:col-span-2">
                    <div class="card-header-gradient">
                        <h3 class="text-xl font-bold flex items-center">
                            <i class="fas fa-history mr-3"></i>
                            Application Timeline
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-dot active"></div>
                                <div class="timeline-content">
                                    <div class="timeline-title">Application Submitted</div>
                                    <div class="timeline-date">{{ $admission->created_at->format('M d, Y \a\t h:i A') }}</div>
                                </div>
                            </div>

                            @if($admission->reviewed_at)
                            <div class="timeline-item">
                                <div class="timeline-dot active"></div>
                                <div class="timeline-content">
                                    <div class="timeline-title">
                                        @if($admission->status === 'accepted')
                                            Application Accepted
                                        @elseif($admission->status === 'rejected')
                                            Application Rejected
                                        @else
                                            Application Reviewed
                                        @endif
                                    </div>
                                    <div class="timeline-date">{{ $admission->reviewed_at->format('M d, Y \a\t h:i A') }}</div>
                                </div>
                            </div>
                            @else
                            <div class="timeline-item">
                                <div class="timeline-dot"></div>
                                <div class="timeline-content">
                                    <div class="timeline-title text-gray-400">Under Review</div>
                                    <div class="timeline-date text-gray-400">Pending</div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Delete Button (Only for Pending) -->
                @if($admission->status === 'pending')
                <div class="lg:col-span-2 no-print">
                    <div class="info-card border-2 border-red-200">
                        <div class="p-6 text-center">
                            <i class="fas fa-exclamation-triangle text-red-500 text-3xl mb-3"></i>
                            <h4 class="text-lg font-bold text-gray-900 mb-2">Delete Application</h4>
                            <p class="text-gray-600 mb-4">You can delete your application and submit a new one if needed.</p>
                            <button onclick="showDeleteModal()"
                                class="bg-red-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-red-700 transition">
                                <i class="fas fa-trash-alt mr-2"></i>
                                Delete Application
                            </button>
                        </div>
                    </div>
                </div>
                @endif
            </div>

        @else
            <!-- No Application -->
            <div class="info-card text-center py-16">
                <i class="fas fa-file-alt text-gray-300 text-6xl mb-6"></i>
                <h3 class="text-2xl font-semibold text-gray-700 mb-3">No Application Found</h3>
                <p class="text-gray-600 mb-8">You haven't submitted an admission application yet.</p>
                <a href="{{ route('admission.create') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition font-semibold text-lg shadow-lg">
                    <i class="fas fa-plus-circle mr-3"></i>
                    Submit Application
                </a>
            </div>
        @endif
    </div>

    <!-- Delete Confirmation Modal -->
    @if($admission && $admission->status === 'pending')
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 transform transition-all">
            <div class="text-center mb-6">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Delete Application?</h3>
                <p class="text-gray-600">Are you sure you want to delete your application? This action cannot be undone.</p>
            </div>

            <form method="POST" action="{{ route('student.application.delete') }}">
                @csrf
                @method('DELETE')
                <div class="flex gap-3">
                    <button type="button" onclick="hideDeleteModal()"
                        class="flex-1 px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition">
                        Yes, Delete
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function showDeleteModal() {
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function hideDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    // Dropdown toggle
    function toggleDropdown() {
        const dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('show');
    }

    // Mobile menu toggle
    function toggleMobileMenu() {
        const mobileMenu = document.getElementById('mobileMenu');
        mobileMenu.classList.toggle('show');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('userDropdown');
        const button = event.target.closest('button[onclick="toggleDropdown()"]');

        if (!button && dropdown && !dropdown.contains(event.target)) {
            dropdown.classList.remove('show');
        }
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        const mobileMenu = document.getElementById('mobileMenu');
        const button = event.target.closest('button[onclick="toggleMobileMenu()"]');

        if (!button && mobileMenu && !mobileMenu.contains(event.target)) {
            mobileMenu.classList.remove('show');
        }
    });
    </script>
    @endif
</body>
</html>
